<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrumentDependence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instrument_dependences';

    public $incrementing = true;

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id',
        'instrument_id',
        'dependence_id',
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

    public function dependence()
    {
        return $this->belongsTo(Dependence::class, 'dependence_id', 'id');
    }
}
