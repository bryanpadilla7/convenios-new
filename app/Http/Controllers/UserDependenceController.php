<?php

namespace App\Http\Controllers;

use App\Models\UserDependence;
use App\Models\Dependence;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Encrypt;

class UserDependenceController extends Controller
{
    public function index()
    {
        $userDependences = UserDependence::all();
        
        foreach ($userDependences as $userDependence) {
            $userDependence->dependence_name = Dependence::find($userDependence->dependence_id)->dependence_name;
            $userDependence->name = User::find($userDependence->user_id)->name;
        }

        $userDependences = Encrypt::encryptObject($userDependences, "id");

        return response()->json([
            "status"=>"success",
            "message"=>"Registro creado correctamente.",
            "userDependences"=>$userDependences]); 
    }

    public function store(Request $request)
    {
        //dd($request);
        UserDependence::create([
            'user_id' => User::where("name", $request->name)->first()->id,
            'dependence_id' => Dependence::where("dependence_name", $request->dependence_name)->first()->id,
        ]);

        return response()->json([
            "status"=>"success",
            "message"=>"Registro creado correctamente."]);
    }

    public function update(Request $request){

        $dependences = Dependence::where("dependence_name", $request->dependence_name)->first()->id;
        $users = User::where("name", $request->name)->first()->id;
        $data = Encrypt::decryptArray($request->except(["dependence_name", "name"]), "id");

        $data["dependence_id"] = $dependences->id;
        $data["user_id"] = $users->id;

        UserDependence::where("id", $data)->update($data);
        return response()->json([
            "status"=>"success",
            "message"=>"Registro editado correctamente."]);
    }

    public function destroy($id)
    {
        $id = Encrypt::decryptValue($id);

        UserDependence::where('id', $id)->delete();
        return response()->json([
            "status"=>"success",
            "message"=>"Registro eliminado correctamente."
        ]);
    }
}