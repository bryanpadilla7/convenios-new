<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tariffs';

    public $incrementing = true;

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id',
        'type_charge',
        'amount',
        'dependence_id',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamps = false;

    public function exonerationDetail()
    {
        return $this->hasMany(ExonerationDetail::class);
    }

    public function dependences()
    {
        return $this->belongsTo(Dependence::class, 'dependence_id', 'id');
    }
}