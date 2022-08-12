<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
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
        'patient_id',
        'remark',
        'status_id',
        'start_date',
        'end_date',
    ];

    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function secretary(){
        return $this->belongsTo(\App\Models\User::class,'secretary_id');
    }
    
    function status(){
        return $this->belongsTo(\App\Models\Status::class,'status_id');
    }
    
    function patient(){
        return $this->belongsTo(\App\Models\Patient::class,'patient_id');
    }

    function getStatusStateAttribute(){
            return '<span class="badge text-white" style="background:'.$this->status->color.'">'.$this->status->name.'</span>';
    }
}
