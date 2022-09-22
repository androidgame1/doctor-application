<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Helper;
use Lang;

class Activity extends Model
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
        'patient_id',
        'date',
        'remark',
        'reduction_total_amount',
        'ht_total_amount',
        'status'
    ];

    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function patient(){
        return $this->belongsTo(\App\Models\Patient::class);
    }

    function activity_lines(){
        return $this->hasMany(\App\Models\Activity_line::class);
    }

    function getStatusStateAttribute(){
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
        return Helper::givenAmountActivityPayment($this->id);
    }
    
    function getRemainingAmountAttribute(){
        return Helper::remainingAmountActivityPayment($this->id);
    }
}
