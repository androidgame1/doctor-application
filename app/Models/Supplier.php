<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'cin',
        'fullname',
        'email',
        'address',
        'phone',
        'city'
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function purchase_orders(){
        return $this->hasMany(\App\Models\Purchase_order::class,'supplier_id');
    }
    
    function delivery_orders(){
        return $this->hasMany(\App\Models\Delivery_order::class,'supplier_id');
    }
    
    function purchase_invoices(){
        return $this->hasMany(\App\Models\Purchase_invoice::class,'supplier_id');
    }
}
