<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Helper;
use Lang;

class Delivery_order extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'series',
        'administrator_id',
        'supplier_id',
        'purchase_order_id',
        'date',
        'remark',
        'file',
        'reduction_total_amount',
        'ht_total_amount',
        'tva_total_amount',
        'ttc_total_amount',
        'status'
    ];

    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function supplier(){
        return $this->belongsTo(\App\Models\Supplier::class);
    }

    function delivery_order_lines(){
        return $this->hasMany(\App\Models\Delivery_order_line::class);
    }

    function delivery_order_payments(){
        return $this->hasMany(\App\Models\Delivery_order_payment::class);
    }

    function getPaymentStatusStateAttribute(){
        if($this->status == 0){
            return '<span class="badge bg-danger text-white font-bold">'.Lang::get("messages.unpaid").'</span>';
        }else if($this->status == 1){
            return '<span class="badge bg-warning text-white font-bold">'.Lang::get("messages.partiel").'</span>';
        }else if($this->status == 2){
            return '<span class="badge bg-success text-white font-bold">'.Lang::get("messages.paid").'</span>';
        }else if($this->status == 3){
            return '<span class="badge bg-danger text-white font-bold">'.Lang::get("messages.canceled").'</span>';
        }else{
            return 'Error';
        }
    }

    function getPaidAmountAttribute(){
        return Helper::givenAmountDeliveryOrderPayment($this->id);
    }
    
    function getRemainingAmountAttribute(){
        return Helper::remainingAmountDeliveryOrderPayment($this->id);
    }

    function getTotalGivenAmountAttribute(){
        return Helper::givenAmountDeliveryOrderPayment($this->id);
    }
    
    function getTotalRemainingAmountAttribute(){
        return Helper::remainingAmountDeliveryOrderPayment($this->id);
    }
}
