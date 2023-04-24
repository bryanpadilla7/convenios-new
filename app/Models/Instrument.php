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
        'entity',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = true;

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }

    public function typeInstrument()
    {
        return $this->belongsTo(TypeInstrument::class, 'type_instrument_id', 'id');
    }

    public function exonerations()
    {
        return $this->hasMany(Exoneration::class);
    }
}
