<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class Purchase_invoice_payment extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'purchase_invoice_id',
        'date',
        'given_amount',
        'remaining_amount',
        'way_of_payment',
        'remark',
        'justification',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function purchase_invoice(){
        return $this->belongsTo(\App\Models\Purchase_invoice::class,'purchase_invoice_id');
    }
}
