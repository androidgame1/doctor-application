<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;   

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role)
    {
        $rolevalue="";
        if(Auth::user()->is_superadministrator){
            if($role == "administrator"){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == "secretary"){
                $rolevalue=2;
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $users = User::where('role',$rolevalue)->get();
        return view('users.users',compact('users','role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($role)
    {
        $rolevalue="";
        if(Auth::user()->is_superadministrator){
            if($role == "administrator"){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == "secretary"){
                $rolevalue=2;
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        return view('users.create_user',compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request,$role)
    {
        $userRole = "";
        if(Auth::user()->is_superadministrator){
            if($role == 'administrator'){
                $request->role = 1;
                $userRole = "administrator";
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == 'secretary'){
                $request->role = 2;
                $userRole = "secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $data = [
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'role'=>$request->role,
            'password'=>Hash::make($request->password),
            'isvalidate'=>1
        ];
        if(User::create($data)){
            toastr()->success('The '.$userRole.' has inserted by success !');
        }else{
            toastr()->warning('The '.$userRole.' has not inserted by success !');
        }
        if(Auth::user()->is_superadministrator){
            return redirect()->route('superadministrator.users',$role);
        }else if(Auth::user()->is_administrator){
            return redirect()->route('administrator.users',$role);
        }else{
            return view('error');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($role,$id)
    {
        $rolevalue="";
        // $result=['icon'=>'warning','user'=>array()];
        if(Auth::user()->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where('role',$rolevalue)->where('id',$id)->firstOrFail();
        $user->status = $user->status;
        $user->editstatus = $user->editstatus;
        // $result=['icon'=>'success','user'=>$user];
        return view('users.show_user',compact('user','role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role,$id)
    {
        $rolevalue="";
        if(Auth::user()->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
            }else{
                return response()->json($result);
            }
        }else if(Auth::user()->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
            }else{
                return response()->json($result);
            }
        }else{
            return view('error');
        }
        $user = User::where('role',$rolevalue)->where('id',$id)->firstOrFail();
        return view('users.edit_user',compact('user','role'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,$role, $id)
    {
        $userRole="";
        $rolevalue="";
        if(Auth::user()->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
                $userRole="administrator";
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
                $userRole="secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where('role',$rolevalue)->where('id',$id)->firstOrFail();
        $data = [
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city
        ];
        if($request->password){
            $data['password']=Hash::make($request->new_password);
        }
        if($user->update($data)){
            toastr()->success('The '.$userRole.' has updated by success !');
        }else{
            toastr()->warning('The '.$userRole.' has not updated by success !');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role,$id)
    {
        $rolevalue="";
        $userRole="";
        if(Auth::user()->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
                $userRole ="administrator";
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
                $userRole ="secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where('role',$rolevalue)->where('id',$id)->firstOrFail();
        if($user->delete()){
            toastr()->success('The '.$userRole.' has deleted by success !');
        }else{
            toastr()->warning('The '.$userRole.' has not deleted by success !');
        }
        return redirect()->back();
    }
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($role, $id)
    {
        $rolevalue="";
        $userRole ="";
        $isvalidate ='';
        $result=['icon'=>'warning','user'=>array()];
        if(Auth::user()->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
                $userRole ="administrator";
            }else{
                return view('error');
            }
        }else if(Auth::user()->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
                $userRole ="secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where('role',$rolevalue)->where('id',$id)->firstOrFail();
        if($user->isvalidate == '0'){
            $isvalidate='1';
        }else if($user->isvalidate == '1'){
            $isvalidate='2';
        }else if($user->isvalidate == '2'){
            $isvalidate='1';
        }else{
            return view('error');
        }
        $data = [
            'isvalidate'=>$isvalidate
        ];
        
        if($user->update($data)){
            toastr()->success('The '.$userRole.' has updated by success !');
        }else{
            toastr()->warning('The '.$userRole.' has not updated by success !');
        }
        return redirect()->back();
    }
    /**
     * edit password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword()
    {
        if(Auth::user()->is_superadministrator || Auth::user()->is_administrator || Auth::user()->is_secretary){
            return view('change_password');
        }else{
            return view('error');
        }
        
    }
    /**
     * update password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserRequest $request)
    {
        if(Auth::user()->is_superadministrator || Auth::user()->is_administrator || Auth::user()->is_secretary){
            $user = Auth::user();
            if(Hash::check($request->old_password, $user->password)){
                if($user->update(['password'=>Hash::make($request->new_password)])){
                    toastr()->success('The password has updated by success.');
                }else{
                    toastr()->warning('The password has not updated by success !');
                }
            }else{
                toastr()->warning('The old password is incorrect !');
            }
            return redirect()->back();
        }else{
            return view('error');
        }
    }
    /**
     * edit password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        if(Auth::user()->is_superadministrator || Auth::user()->is_administrator || Auth::user()->is_secretary){
            return view('profile');
        }else{
            return view('error');
        }
    }
    /**
     * update password
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UserRequest $request)
    {
        if(Auth::user()->is_superadministrator || Auth::user()->is_administrator|| Auth::user()->is_secretary){
            $user = Auth::user();
            if($request->hasfile("image")){
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                if(Auth::user()->is_superadministrator){
                    $filename = "uploads/superadministrator/profile/files_superadministrator_".Auth::user()->id."/".time().'.'.$extention;
                    $file->move("uploads/superadministrator/profile/files_superadministrator_".Auth::user()->id,$filename);
                    $request->image = $filename;
                
                }else if(Auth::user()->is_administrator){
                    $filename = "uploads/administrator/profile/files_administrator_".Auth::user()->id."/".time().'.'.$extention;
                    $file->move("uploads/administrator/profile/files_administrator_".Auth::user()->id,$filename);
                    $request->image = $filename;
                
                }else if(Auth::user()->is_secretary){
                    $filename = "uploads/secretary/profile/files_secretary_".Auth::user()->id."/".time().'.'.$extention;
                    $file->move("uploads/secretary/profile/files_secretary_".Auth::user()->id,$filename);
                    $request->image = $filename;
                
                }else{
                    toastr()->error("Il y'a un probléme !");
                    return redirect()->back();
                }
            }else{
                if($request->image_path){
                    $request->image = Auth::user()->image;
                }else{
                    $request->image = null;
                }
            }
            if($user->update([
                'image'=>$request->image,
                'fullname'=>$request->fullname,
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'city'=>$request->city
            ])){
                toastr()->success('The profile has updated by success.');
            }else{
                toastr()->warning('The profile has not updated by success !');
            }
            return redirect()->back();
        }else{
            return view('error');
        }
        
    }

}
