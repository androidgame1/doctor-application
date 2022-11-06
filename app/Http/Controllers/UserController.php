<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Charge;
use App\Models\Appoitment;
use App\Models\Patient;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Helper;
use Lang;  

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$role)
    {
        $user = Auth::user();
        $rolevalue="";
        if($user->is_superadministrator){
            if($role == "administrator"){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
            if($role == "secretary"){
                $rolevalue=2;
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $users = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue])->get();
        if($request->isMethod('post') && !is_null($request->start_date) && !is_null($request->end_date)){
            $users = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue])
            ->whereDate('created_at','>=',Carbon::parse($request->start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($request->end_date)->format('Y-m-d')."%")
            ->get();
        }
        $count_no_validated_users = $users->filter(function($value){
            return $value->isvalidate =='0';
        })->count();
        $count_no_activated_users = $users->filter(function($value){
            return $value->isvalidate =='1';
        })->count();
        $count_activated_users = $users->filter(function($value){
            return $value->isvalidate =='2';
        })->count();
        return view('users.users',compact('users','role','count_no_validated_users','count_no_activated_users','count_activated_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($role)
    {
        $user = Auth::user();
        $rolevalue="";
        if($user->is_superadministrator){
            if($role == "administrator"){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
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
        $user = Auth::user();
        $userRole = "";
        if($user->is_superadministrator){
            if($role == 'administrator'){
                $request->role = 1;
                $userRole = "administrator";
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
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
            'administrator_id'=>$user->id,
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
            toastr()->success(Lang::get('messages.the_'.$userRole.'_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_'.$userRole.'_has_not_inserted_by_success'));
        }
        if($user->is_superadministrator){
            return redirect()->route('superadministrator.users',$role);
        }else if($user->is_administrator){
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
    public function show(Request $request,$role,$id)
    {
        $user = Auth::user();
        $rolevalue="";
        $charges=null;
        $total_amount_charges = 0;
        $total_given_amount_charges = 0;
        $total_remaining_amount_charges = 0;
        if($user->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue,'id'=>$id])->firstOrFail();
        $patients = Patient::where(['administrator_id'=>$user->id])->get();
        $status = Status::where(['administrator_id'=>$user->id])->get();
        $user->status = $user->status;
        $user->editstatus = $user->editstatus;
        if($rolevalue == 2){
            //start charges
            $charges = $user->chargesSecretary;
            $total_amount_charges = $charges->sum('amount');
            $total_given_amount_charges = Helper::givenAmountChargePayment(null,$user->id,$request->start_date,$request->end_date);
            $total_remaining_amount_charges = Helper::remainingAmountChargePayment(null,$user->id,0,$request->start_date,$request->end_date);
            //end charges
        }
        return view('users.show_user',compact('user',
            'role',
            'charges',
            'patients',
            'status',
            'total_amount_charges',
            'total_given_amount_charges',
            'total_remaining_amount_charges'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role,$id)
    {
        $user = Auth::user();
        $rolevalue="";
        if($user->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
            }else{
                return response()->json($result);
            }
        }else if($user->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
            }else{
                return response()->json($result);
            }
        }else{
            return view('error');
        }
        $user = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue,'id'=>$id])->firstOrFail();
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
        $user = Auth::user();
        $userRole="";
        $rolevalue="";
        if($user->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
                $userRole="administrator";
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
                $userRole="secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue,'id'=>$id])->firstOrFail();
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
            toastr()->success(Lang::get('messages.the_'.$userRole.'_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_'.$userRole.'_has_not_updated_by_success'));
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
        $user = Auth::user();
        $rolevalue="";
        $userRole="";
        if($user->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
                $userRole ="administrator";
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
                $userRole ="secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue,'id'=>$id])->firstOrFail();
        if($user->delete()){
            toastr()->success(Lang::get('messages.the_'.$userRole.'_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_'.$userRole.'_has_not_deleted_by_success'));
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
        $user = Auth::user();
        $rolevalue="";
        $userRole ="";
        $isvalidate ='';
        $result=['icon'=>'warning','user'=>array()];
        if($user->is_superadministrator){
            if($role == 'administrator'){
                $rolevalue=1;
                $userRole ="administrator";
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
            if($role == 'secretary'){
                $rolevalue=2;
                $userRole ="secretary";
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $user = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue,'id'=>$id])->firstOrFail();
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
            toastr()->success(Lang::get('messages.the_'.$userRole.'_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_'.$userRole.'_has_not_updated_by_success'));
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
        $user = Auth::user();
        if($user->is_superadministrator || $user->is_administrator || $user->is_secretary){
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
        $user = Auth::user();
        if($user->is_superadministrator || $user->is_administrator || $user->is_secretary){
            if(Hash::check($request->old_password, $user->password)){
                if($user->update(['password'=>Hash::make($request->new_password)])){
                    toastr()->success(Lang::get('messages.the_password_has_updated_by_success'));
                }else{
                    toastr()->warning(Lang::get('messages.the_password_has_not_updated_by_success'));
                }
            }else{
                toastr()->warning(Lang::get('messages.the_old_password_is_incorrect'));
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
        $user = Auth::user();
        if($user->is_superadministrator || $user->is_administrator || $user->is_secretary){
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
        $user = Auth::user();
        if($user->is_superadministrator || $user->is_administrator|| $user->is_secretary){
            if($request->hasfile("image")){
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                if($user->is_superadministrator){
                    $filename = "uploads/superadministrator/profile/files_superadministrator_".$user->id."/".time().'.'.$extention;
                    $file->move("uploads/superadministrator/profile/files_superadministrator_".$user->id,$filename);
                    $request->image = $filename;
                
                }else if($user->is_administrator){
                    $filename = "uploads/administrator/profile/files_administrator_".$user->id."/".time().'.'.$extention;
                    $file->move("uploads/administrator/profile/files_administrator_".$user->id,$filename);
                    $request->image = $filename;
                
                }else if($user->is_secretary){
                    $filename = "uploads/secretary/profile/files_secretary_".$user->id."/".time().'.'.$extention;
                    $file->move("uploads/secretary/profile/files_secretary_".$user->id,$filename);
                    $request->image = $filename;
                
                }else{
                    toastr()->error(Lang::get('messages.there_is_a_problem'));
                    return redirect()->back();
                }
            }else{
                if($request->image_path){
                    $request->image = $user->image;
                }else{
                    $request->image = null;
                }
            }
            if($user->is_administrator){
                if($request->hasfile("logo")){
                    $file = $request->file('logo');
                    $extention = $file->getClientOriginalExtension();
                    $filename = "uploads/administrator/logo/files_administrator_".$user->id."/".time().'.'.$extention;
                    $file->move("uploads/administrator/logo/files_administrator_".$user->id,$filename);
                    $request->logo = $filename;
                }else{
                    $request->logo = $user->logo;
                }
            }
            if($user->update([
                'image'=>$request->image,
                'fullname'=>$request->fullname,
                'email'=>$request->email,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'city'=>$request->city,
                'logo'=>$request->logo,
                'ice'=>$request->ice,
                'rc'=>$request->rc,
                'if'=>$request->if
            ])){
                toastr()->success(Lang::get('messages.the_profile_has_updated_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_profile_has_not_updated_by_success'));
            }
            return redirect()->back();
        }else{
            return view('error');
        }
        
    }
    /**
     * Filter a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($role,$validation)
    {
        $user = Auth::user();
        $rolevalue="";
        if($user->is_superadministrator){
            if($role == "administrator"){
                $rolevalue=1;
            }else{
                return view('error');
            }
        }else if($user->is_administrator){
            if($role == "secretary"){
                $rolevalue=2;
            }else{
                return view('error');
            }
        }else{
            return view('error');
        }
        $users = User::where(['administrator_id'=>$user->id,'role'=>$rolevalue,'isvalidate'=>$validation])->get();
        return view('users.users',compact('users','role'));
    }

}
