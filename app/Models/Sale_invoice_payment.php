<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class Sale_invoice_payment extends Model
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
    
    function sale_invoice(){
        return $this->belongsTo(\App\Models\Sale_invoice::class,'sale_invoice_id');
    }

    function getWayOfPaymentNameAttribute(){
        return Lang::get('messages.'.$this->way_of_payment);
    }
}
