<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instruments';

    public $incrementing = true;

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id',
        'instrument_name',
        'description',
        'type_instrument_id',
        'sector_id',
<<<<<<< HEAD
        'entity_id',
=======
        'entity',
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public function sector()
<<<<<<< HEAD
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }

    public function typeInstrument()
    {
        return $this->belongsTo(TypeInstrument::class, 'type_instrument_id', 'id');
    }

    public function entity()
=======
>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }

<<<<<<< HEAD
=======
    public function typeInstrument()
    {
        return $this->belongsTo(TypeInstrument::class, 'type_instrument_id', 'id');
    }

>>>>>>> 2b413b2241e5bf3c815a10b67fee54829e5ed014
    public function exonerations()
    {
        return $this->hasMany(Exoneration::class);
    }

    public function instumentDependence()
    {
        return $this->hasMany(InstrumentDependence::class);
    }
}
