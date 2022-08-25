<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class Sale_invoice_line extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'sale_invoice_id',
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
    
    function sale_invoice(){
        return $this->belongsTo(\App\Models\Sale_invoice::class,'sale_invoice_id');
    }
}