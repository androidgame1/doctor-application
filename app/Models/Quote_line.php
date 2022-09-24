<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class Quote_line extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'quote_id',
        'designation',
        'description',
        'quantity',
        'unit_price',
        'reduction',
        'reduction_amount',
        'ht_amount',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function quote(){
        return $this->belongsTo(\App\Models\Quote::class,'quote_id');
    }
}
