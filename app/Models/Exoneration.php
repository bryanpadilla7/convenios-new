<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Exoneration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exonerations';

    public $incrementing = true;

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id',
        'exonerated_description',
        'instrument_id',
        'hour',
        'people',
        'date',
        'amount_hour',
        'amount_people',
<<<<<<< HEAD
        'service_place',
=======
        'service_place_id',
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
        'tariff_id',
        'tariff_hour',
        'tariff_people',
        'not_charged_hour',
        'not_charged_people',
        'concept',
        'worth',
        'concept_amount',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'id');
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class, "tariff_id_hour", "id");
<<<<<<< HEAD
=======
    }

    public function place()
    {
        return $this->belongsTo(ServicePlace::class, "service_place_id", "id");
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
    }
}