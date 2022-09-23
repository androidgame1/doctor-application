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
    ];

    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    function supplier(){
        return $this->belongsTo(\App\Models\Supplier::class);
    }
}
