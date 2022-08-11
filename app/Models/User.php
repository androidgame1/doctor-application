<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

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
            return 'Super administrator';
        }else if($this->role == 1){
            return 'Administrator';
        }else if($this->role == 2){
            return 'Secretary';
        }else if($this->role == 3){
            return 'Delivery man';
        }else{
            return "Error";
        }
    }
    
    public function getRolepluralnameAttribute(){
        if($this->role == 0){
            return 'Super administrators';
        }else if($this->role == 1){
            return 'Administrators';
        }else if($this->role == 2){
            return 'Secretaries';
        }else if($this->role == 3){
            return 'Delivery men';
        }else{
            return "Error";
        }
    }

    public function getStatusAttribute(){
        if($this->isvalidate == '0'){
            return '<span class="badge badge-warning badge-pill">No validated</span>';
        }else if($this->isvalidate == '1'){
            return '<span class="badge badge-danger badge-pill">No activated</span>';
        }else if($this->isvalidate == '2'){
            return '<span class="badge badge-success badge-pill">Actvated</span>';
        }else{
            return 'Error';
        }
    }
    public function getEditstatusAttribute(){
        $role = $this->role;
        $id = $this->id;
        if($role == '1' || $role == '2' || $role == '3'){
            if($this->isvalidate == '0'){
                return array('class'=>'btn-warning','value'=>'Validate');
            }else if($this->isvalidate == '1'){
                return array('class'=>'btn-success','value'=>'Activate');
            }else if($this->isvalidate == '2'){
                return array('class'=>'btn-danger','value'=>'Deactivate');
            }else{
                return 'Error';
            }
        }else{
            $role = 'error';
        }
    }
}