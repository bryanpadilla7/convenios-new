<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\TypeInstrument;
use App\Models\Entity;
use App\Models\Exoneration;
use App\Models\Dependence;
use App\Models\ServicePlace;
use App\Models\Tariff;
use App\Models\Sector;
use Encrypt;
use Illuminate\Http\Request;
use DB;

class InstrumentController extends Controller
{
    public function index()
    {
        $instruments = Instrument::all();

        foreach ($instruments as $instrument)
        {
            $instrument->exonerations = Exoneration::select('exonerations.*', 'service_places.place_name', DB::raw('IFNULL(tariffs.amount, exonerations.not_charged_hour) AS charge_hour'))
            ->leftJoin('service_places', 'exonerations.service_place_id', '=', 'service_places.id')
            ->leftJoin('tariffs', 'exonerations.tariff_id', '=', 'tariffs.id')
            ->where('exonerations.instrument_id', $instrument->id)
            ->get();
            $instrument->sector_name = Sector::find($instrument->sector_id)->sector_name;
            $instrument->type_instrument_name = TypeInstrument::find($instrument->type_instrument_id)->type_instrument_name;
        }

        $instruments = Encrypt::encryptObject($instruments, "id");
        
        return response()->json([
            "status"=>"success", 
            "message"=>"Registro obtenido correctamente.", 
            "instruments"=>$instruments]);
    }


    public function store(Request $request)
    {
        Instrument::create([
            'instrument_name' => $request->instrument_name,
            'description' => $request->description,
            'type_instrument_id' => TypeInstrument::where("type_instrument_name", $request->type_instrument_name)->first()->id,
            'entity' => $request->entity,
            'sector_id' => Sector::where("sector_name", $request->sector_name)->first()->id,
        ]);

        return response()->json([
            "status"=>"success",
            "message"=>"Registro creado correctamente."
        ]);
    }

    public function update(Request $request)
    {
        $type = TypeInstrument::where("type_instrument_name", $request->type_instrument_name)->first();
        $sector = Sector::where("sector_name", $request->sector_name)->first();

        $data = Encrypt::decryptArray($request->except(["type_instrument_name", "sector_name", "exonerations"]), "id");

        $data["type_instruments_id"] = $type->id;
        $data["sector_id"] = $sector->id;
        
        Instrument::where("id", $data)->update($data);

        return response()->json([
            "status"=>"success",
            "message"=>"Registro modificado correctamente."
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
