<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        'city',
        'image',
        'role',
        'password',
        'isvalidate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    function administrator(){
        return $this->belongsTo(\App\Models\User::class,'administrator_id');
    }

    public function getIsSuperadministratorAttribute(){
        return $this->role == 0;
    }

    public function getIsAdministratorAttribute(){
        return $this->role == 1;
    }

    public function getIsSecretaryAttribute(){
        return $this->role == 2;
    }

    public function getIsDeliverymanAttribute(){
        return $this->role == 3;
    }
    
    public function getRolesingularnameAttribute(){
        if($this->role == 0){
            return Lang::get('messages.super_administrator');
        }else if($this->role == 1){
            return Lang::get('messages.administrator');
        }else if($this->role == 2){
            return Lang::get('messages.secretary');
        }else{
            return Lang::get('messages.error');
        }
    }
    
    public function getRolepluralnameAttribute(){
        if($this->role == 0){
            return Lang::get('messages.super_administrators');
        }else if($this->role == 1){
            return Lang::get('messages.administrators');
        }else if($this->role == 2){
            return Lang::get('messages.secretaries');
        }else{
            return Lang::get('messages.error');
        }
    }

    public function getStatusAttribute(){
        if($this->isvalidate == '0'){
            return '<span class="badge badge-warning badge-pill">'.Lang::get("messages.no_validated").'</span>';
        }else if($this->isvalidate == '1'){
            return '<span class="badge badge-danger badge-pill">'.Lang::get("messages.no_activated").'</span>';
        }else if($this->isvalidate == '2'){
            return '<span class="badge badge-success badge-pill">'.Lang::get("messages.activated").'</span>';
        }else{
            return Lang::get("messages.error");
        }
    }
    public function getEditstatusAttribute(){
        $role = $this->role;
        $id = $this->id;
        if($role == '1' || $role == '2' || $role == '3'){
            if($this->isvalidate == '0'){
                return array('class'=>'btn-warning','value'=>Lang::get("messages.validate"));
            }else if($this->isvalidate == '1'){
                return array('class'=>'btn-success','value'=>Lang::get("messages.activate"));
            }else if($this->isvalidate == '2'){
                return array('class'=>'btn-danger','value'=>Lang::get("messages.deactivate"));
            }else{
                return Lang::get("messages.error");
            }
        }else{
             return Lang::get("messages.error");   
        }
    }
}