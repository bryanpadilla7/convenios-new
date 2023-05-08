<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicePlace;
use App\Models\Exoneration;
use App\Models\Instrument;
use App\Models\Dependence;
use App\Models\Tariff;
use Encrypt;
use DB;

class ExonerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    public function store(Request $request)
<<<<<<< HEAD
    {   //dd($request);
        $instrument_id = Instrument::where("instrument_name", $request->instrument_name)->first()->id;
=======
    {   //dd($request->exonerations);
        $instrument_id = Instrument::where("instrument_name", $request->instrument_name)->first()->id;
        $dependence_id = Dependence::where("dependence_name", $request->dependence_name)->first()->id;
        $place_id = ServicePlace::where("place_name", $request->place_name)->first()->id;
        $tariff_id = Tariff::where("type_charge", $request->tariff_hour)->first()->id;
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
        
        $exonerations = $request->exonerations;

        foreach ($exonerations as $exoneration) {
<<<<<<< HEAD
            $tariff_id = "1";
=======
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
            $tariff_hour = null;
            $tariff_people = null;
            $not_charged_hour = null;
            $not_charged_people = null;

            if ($exoneration["tariff_hour"] != null && $exoneration["tariff_hour"] != "" && $exoneration["tariff_people"] != null && $exoneration["tariff_people"] != "") {
                $tariff_hour = Tariff::where("type_charge", $exoneration["tariff_hour"])->first()->id;
                $tariff_people = Tariff::where("type_charge", $exoneration["tariff_people"])->first()->id;
<<<<<<< HEAD
                $tariff_id = Tariff::where("type_charge", $request->tariff_hour)->first()->id;
=======
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
            } else {
                $not_charged_hour = $exoneration["not_charged_hour"];
                $not_charged_people = $exoneration["not_charged_people"];
            }

            Exoneration::create([
                'exonerated_description' => $exoneration["exonerated_description"],
                'instrument_id' => $instrument_id,
<<<<<<< HEAD
=======
                'dependence_id' => $dependence_id,
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
                'tariff_id' => $tariff_id,
                'hour'=> $exoneration["hour"],
                'people'=> $exoneration["people"],
                'date'=> $exoneration["date"],
                'amount_hour' => $exoneration["amount_hour"],
                'amount_people' => $exoneration["amount_people"],
<<<<<<< HEAD
                'service_place' => $exoneration["service_place"],
=======
                'service_place_id' => $place_id,
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
                'tariff_hour' => $tariff_hour,
                'tariff_people' => $tariff_people,
                'not_charged_hour' => $not_charged_hour,
                'not_charged_people' => $not_charged_people,
                'concept' => $exoneration["concept"],
                'worth' => $exoneration["worth"],
                'concept_amount' => $exoneration["concept_amount"],
            ]);
    }

    return response()->json([
        "status" => "success",
        "message" => "Registros creados correctamente."
    ]);
    }

    

    public function show($agreement_id)
    {
       //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        $id = Encrypt::decryptValue($id);

        Exoneration::where("id", $id)->delete();
        return response()->json([
            "status"=>"success",
            "message"=>"Registro eliminado correctamente."
        ]);
    }
}