<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class Delivery_order_line extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'delivery_order_id',
        'designation',
        'description',
        'quantity',
        'unit_price',
        'reduction',
        'reduction_amount',
        'ht_amount',
        'tva',
        'tva_amount',
        'ttc_amount',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function delivery_order(){
        return $this->belongsTo(\App\Models\Delivery_order::class,'delivery_order_id');
    }
}
