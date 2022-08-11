<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_invoice extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'series',
        'administrator_id',
        'supplier_id',
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

    function supplier(){
        return $this->belongsTo(\App\Models\Supplier::class);
    }

    function purchase_invoice_lines(){
        return $this->hasMany(\App\Models\Purchase_invoice_line::class);
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
