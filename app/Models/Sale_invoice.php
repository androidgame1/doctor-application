<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale_invoice extends Model
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

    function sale_invoice_lines(){
        return $this->hasMany(\App\Models\Sale_invoice_line::class);
    }

    function getStatusStateAttribute(){
        if($this->status == 0){
            return '<span class="badge bg-success text-white">Activaled</span>';
        }else if($this->status == 1){
            return '<span class="badge bg-danger text-white">Canceled</span>';
        }else{
            return 'Error';
        }
    }
}
