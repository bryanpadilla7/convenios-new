<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\TypeInstrument;
use App\Models\Entity;
use App\Models\Exoneration;
<<<<<<< HEAD
=======
use App\Models\Dependence;
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
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
<<<<<<< HEAD
            $instrument->exonerations = Exoneration::select('exonerations.*', DB::raw('IFNULL(tariffs.amount, exonerations.not_charged_hour) AS charge_hour'))
=======
            $instrument->exonerations = Exoneration::select('exonerations.*', 'service_places.place_name', DB::raw('IFNULL(tariffs.amount, exonerations.not_charged_hour) AS charge_hour'))
            ->leftJoin('service_places', 'exonerations.service_place_id', '=', 'service_places.id')
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
            ->leftJoin('tariffs', 'exonerations.tariff_id', '=', 'tariffs.id')
            ->where('exonerations.instrument_id', $instrument->id)
            ->get();
            $instrument->sector_name = Sector::find($instrument->sector_id)->sector_name;
            $instrument->type_instrument_name = TypeInstrument::find($instrument->type_instrument_id)->type_instrument_name;
<<<<<<< HEAD
            $instrument->entity_name = Entity::find($instrument->entity_id)->entity_name;
=======
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
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
<<<<<<< HEAD
            'entity_id' => Entity::where("entity_name", $request->entity_name)->first()->id,
=======
            'entity' => $request->entity,
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
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
<<<<<<< HEAD
        $entity = Entity::where("entity_name", $request->entity_name)->first();

        $data = Encrypt::decryptArray($request->except(["entity_name", "type_instrument_name", "sector_name", "exonerations"]), "id");

        $data["type_instruments_id"] = $type->id;
        $data["sector_id"] = $sector->id;
        $data["entity_id"] = $entity->id;
=======

        $data = Encrypt::decryptArray($request->except(["type_instrument_name", "sector_name", "exonerations"]), "id");

        $data["type_instruments_id"] = $type->id;
        $data["sector_id"] = $sector->id;
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
        
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
