<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'administrator_id',
        'cin',
        'fullname',
        'email',
        'address',
        'phone',
        'city'
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }
}
