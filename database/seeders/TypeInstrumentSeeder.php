<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\TypeInstrument;

class TypeInstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeInstrument::insert([
        [
            "id" => 1,
            "type_instrument_name" => "Acuerdo",
        ],
        [
            "id" => 2,
            "type_instrument_name" => "Acta de traslado",
        ],
        [
            "id" => 3,
            "type_instrument_name" => "Acta de donación",
        ],
        [
            "id" => 4,
            "type_instrument_name" => "Carta de entendimiento",
        ],
        [
            "id" => 5,
            "type_instrument_name" => "Convenio",
        ],
        [
            "id" => 6,
            "type_instrument_name" => "Programa",
        ],
        [
            "id" => 7,
            "type_instrument_name" => "Transferencia",
        ],    
    ]);
    }
}
