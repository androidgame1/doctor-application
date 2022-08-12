<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
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
        'cin',
        'fullname',
        'email',
        'address',
        'phone',
        'city',
        'birthdate',
        'gender',
        'blood_group',
        'weight',
        'height',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
    
    function secretary(){
        return $this->belongsTo(\App\Models\User::class,'secretary_id');
    }

    function getGenderNameAttribute(){
        if($this->gender == '0'){
            return 'Male';
        }else if($this->gender == '1'){
            return 'Female';
        }else{
            return 'Error';
        }
    }
}
