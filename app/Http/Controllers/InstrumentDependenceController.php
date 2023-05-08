<?php

namespace App\Http\Controllers;

use App\Models\InstrumentDependence;
use App\Models\Dependence;
use App\Models\Instrument;
use Illuminate\Http\Request;
use DB;
use Encrypt;

class InstrumentDependenceController extends Controller
{
    public function index()
    {
        $instrumentDependences = InstrumentDependence::all();
        
        foreach ($instrumentDependences as $instrumentDependence) {
            $instrumentDependence->dependence_name = Dependence::find($instrumentDependence->dependence_id)->dependence_name;
            $instrumentDependence->instrument_name = Instrument::find($instrumentDependence->instrument_id)->instrument_name;
        }

        $instrumentDependences = Encrypt::encryptObject($instrumentDependences, "id");

        return response()->json([
            "status"=>"success",
            "message"=>"Registro creado correctamente.",
            "instrumentDependences"=>$instrumentDependences]); 
    }

    public function store(Request $request)
    {
        //dd($request);
        InstrumentDependence::create([
            'instrument_id' => Instrument::where("instrument_name", $request->instrument_name)->first()->id,
            'dependence_id' => Dependence::where("dependence_name", $request->dependence_name)->first()->id,
        ]);

        return response()->json([
            "status"=>"success",
            "message"=>"Registro creado correctamente."]);
    }

    public function update(Request $request){

        $instruments = Instrument::where("instrument_name", $request->instrument_name)->first()->id;
        $dependences = Dependence::where("dependence_name", $request->dependence_name)->first()->id;
        $data = Encrypt::decryptArray($request->except(["dependence_name", "instrument_name"]), "id");

        $data["dependence_id"] = $dependences->id;
        $data["instrument_id"] = $instruments->id;

        InstrumentDependence::where("id", $data)->update($data);
        return response()->json([
            "status"=>"success",
            "message"=>"Registro editado correctamente."]);
    }

    public function destroy($id)
    {
        $id = Encrypt::decryptValue($id);

        InstrumentDependence::where('id', $id)->delete();
        return response()->json([
            "status"=>"success",
            "message"=>"Registro eliminado correctamente."
        ]);
    }
}
