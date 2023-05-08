<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->string('instrument_name');
            $table->text('description');
            $table->foreignId('type_instrument_id')->constrained('type_instruments');
            $table->foreignId('sector_id')->constrained('sectors');
<<<<<<< HEAD
            $table->foreignId('entity_id')->constrained('entities');
=======
            $table->text('entity');;
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instruments');
    }
};