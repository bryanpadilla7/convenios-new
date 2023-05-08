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
        Schema::create('exonerations', function (Blueprint $table) {
            $table->id();
            $table->string('exonerated_description');
            $table->foreignId('instrument_id')->constrained('instruments')->nullable();
<<<<<<< HEAD
            $table->integer('hour')->nullable();
=======
            $table->string('hour')->nullable();
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
            $table->integer('people')->nullable();
            $table->date('date')->nullable();
            $table->decimal('amount_hour', 8, 2)->nullable();
            $table->decimal('amount_people', 8, 2)->nullable();
<<<<<<< HEAD
            $table->string('service_place')->nullable();
=======
            $table->foreignId('service_place_id')->constrained('service_places')->nullable();
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
            $table->foreignId('tariff_id')->constrained('tariffs')->nullable();
            $table->decimal('tariff_people', 8, 2)->nullable();
            $table->decimal('tariff_hour', 8, 2)->nullable();
            $table->decimal('not_charged_hour', 8, 2)->nullable();
            $table->decimal('not_charged_people', 8, 2)->nullable();
            $table->string('concept')->nullable();
            $table->string('worth')->nullable();
            $table->decimal('concept_amount', 8, 2)->nullable();
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
        Schema::dropIfExists('exonerations');
    }
};