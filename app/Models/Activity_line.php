<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity_line extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'activity_id',
        'designation',
        'description',
        'quantity',
        'unit_price',
        'reduction',
        'reduction_amount',
        'ht_amount',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function activity(){
        return $this->belongsTo(\App\Models\Activity::class,'activity_id');
    }
}
