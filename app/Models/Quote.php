<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Helper;
use Lang;

class Quote extends Model
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
        'tva_total_amount',
        'ttc_total_amount',
        'status'
    ];
    

    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function patient(){
        return $this->belongsTo(\App\Models\Patient::class);
    }

    function quote_lines(){
        return $this->hasMany(\App\Models\Quote_line::class);
    }

    function getPaymentStatusStateAttribute(){
        if($this->status == 0){
            return '<span class="badge bg-success text-white font-bold">'.Lang::get("messages.activated").'</span>';
        }else if($this->status == 1){
            return '<span class="badge bg-danger text-white font-bold">'.Lang::get("messages.canceled").'</span>';
        }else{
            return 'Error';
        }
    }
}
