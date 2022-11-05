<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Helper;
use Lang;

class Charge extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'secretary_id',
        'name',
        'amount',
        'description',
        'status'
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function secretary(){
        return $this->belongsTo(\App\Models\User::class,'secretary_id');
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

    function getTotalGivenAmountAttribute(){
        return Helper::givenAmountChargePayment($this->id);
    }
    
    function getTotalRemainingAmountAttribute(){
        return Helper::remainingAmountChargePayment($this->id);
    }
}
