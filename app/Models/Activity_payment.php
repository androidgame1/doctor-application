<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Helper;
use Lang;

class Activity_payment extends Model
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
        'date',
        'given_amount',
        'remaining_amount',
        'way_of_payment',
        'remark',
        'justification',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function activity(){
        return $this->belongsTo(\App\Models\Activity::class,'activity_id');
    }
    
    function getWayOfPaymentNameAttribute(){
        return Lang::get('messages.'.$this->way_of_payment);
    }
}
