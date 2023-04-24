<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Encrypt;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        $sectors = Encrypt::encryptObject($sectors, 'id');

        return response()->json([
            "status"=>"success",
            "message"=>"Registros obtenidos correctamente.",
            'sectors'=>$sectors
        ]);
    }

    public function store(Request $request)
    {
        Sector::insert($request->all());

        return response()->json([
            "status"=>"success",
            "message"=>"Registro creado correctamente."
        ]);
    }

    public function show(Sector $sector)
    {
        //
    }

    public function update(Request $request)
    {
        $data = Encrypt::decryptArray($request->all(), 'id');

        Sector::where('id', $data)->update($data);
        return response()->json([
            "status"=>"success",
            "message"=>"Registro modificado correctamente."
        ]);
    }

    public function destroy($id)
    {
        $id = Encrypt::decryptValue($id);

        Sector::where('id', $id)->delete();
        return response()->json([
            "status"=>"success",
            "message"=>"Registro eliminado correctamente."
        ]);
    }
}
