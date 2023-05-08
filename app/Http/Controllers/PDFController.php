<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Models\Exoneration;
use App\Models\Instrument;

class PDFController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function generatePDF(Request $request)
    {
        //dd($request);
        //dd($data);
        $date = $request->all();

        if($request->dateOne == null || $request->dateOne == ''){
            $instrument_id = Instrument::where("instrument_name", $request->instrument_name)->first()->id;

            $data = Instrument::select('instruments.*', 'type_instruments.type_instrument_name', 'sectors.sector_name')
                                ->join('type_instruments', 'instruments.type_instrument_id', '=', 'type_instruments.id')
                                ->join('sectors', 'instruments.sector_id', '=', 'sectors.id')
                                ->where('instruments.id', $instrument_id)
                                ->get();

           /*  $data = Exoneration::selectRaw('SUM(exonerations.exonerated_amount) AS Total')
                    ->where('exonerations.agreement_id', $agreement_id)
                    ->value('Total'); */

            foreach($data as $item){
                $item->exonerations = Exoneration::select('exonerations.*', 'service_places.place_name',
                        DB::raw('IFNULL(tariffs.amount, exonerations.not_charged_hour) AS charge_hour'), DB::raw('IFNULL(tariffs.amount, exonerations.not_charged_people) AS charge_people'))
                ->leftJoin('service_places', 'exonerations.service_place_id', '=', 'service_places.id')
                ->leftJoin('tariffs', 'exonerations.tariff_id', '=', 'tariffs.id') 
                ->where('exonerations.instrument_id', $instrument_id)
                ->get();

                $item->totalAmountHour = Exoneration::selectRaw('SUM(exonerations.amount_hour) AS Total_hour')
                    ->where('exonerations.instrument_id', $instrument_id)
                    ->value('Total_hour');
                
                $item->totalAmountPeople = Exoneration::selectRaw('SUM(exonerations.amount_people) AS Total_people')
                    ->where('exonerations.instrument_id', $instrument_id)
                    ->value('Total_people');
                
                $item->totalContributed = $item->totalAmountHour + $item->totalAmountPeople;
            } 

        }else{
            $instrument_id = Instrument::where("instrument_name", $request->instrument_name)->first()->id;

            $data = Instrument::select('instruments.*', 'entities.entity_name', 'type_instruments.type_instrument_name')
                                ->join('entities', 'instruments.entity_id', '=', 'entities.id')
                                ->join('type_instruments', 'instruments.type_instrument_id', '=', 'type_instruments.id')
                                ->join('sectors', 'instruments.sector_id', '=', 'sectors.id')
                                ->where('instruments.id', $instrument_id)
                                ->get();

            foreach($data as $item){
                $item->exonerations = Exoneration::select('exonerations.*', 'service_places.place_name',
                        DB::raw('IFNULL(tariffs.amount, exonerations.not_charged_hour) AS charge_hour'))
                ->leftJoin('service_places', 'exonerations.service_place_id', '=', 'service_places.id')
                ->leftJoin('tariffs', 'exonerations.tariff_id', '=', 'tariffs.id')
                ->whereRaw("(exonerations.date >= ? AND exonerations.date <= ?)", [$date['dateOne'], $date['dateTwo']])
                ->where('exonerations.agreement_id', $agreement_id)
                ->get();

                $item->totalAmount = Exoneration::selectRaw('SUM(exonerations.exonerated_amount) AS Total')
                    ->whereRaw("(exonerations.date >= ? AND exonerations.date <= ?)", [$date['dateOne'], $date['dateTwo']])
                    ->where('exonerations.agreement_id', $agreement_id)
                    ->value('Total');
            }
        }
            
        $pdf = PDF::loadView('PDF.report', compact('data'));

        return $pdf->stream('report-'.now().'.pdf');
    }
}