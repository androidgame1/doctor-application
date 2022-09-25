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
        'status',
        'remark',
        'file',
    ];

    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function supplier(){
        return $this->belongsTo(\App\Models\Supplier::class);
    }

    function getStatusStateAttribute(){
        if($this->status == 0){
            return '<span class="badge bg-gray text-white font-bold">'.Lang::get("messages.normal").'</span>';
        }else if($this->status == 1){
            return '<span class="badge bg-success text-white font-bold">'.Lang::get("messages.converted").'</span>';
        }else{
            return 'Error';
        }
    }
}
