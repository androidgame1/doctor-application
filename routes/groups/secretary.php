<?php
Route::group(['prefix'=>'secretary','middleware'=>['prevent.back.history','is.secretary']],function(){
    // Routes home controller
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('secretary.home');
    // Routes user controller
    Route::get('/edit-password', [App\Http\Controllers\UserController::class, 'editPassword'])->name('secretary.password.edit');
    Route::put('/update-password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('secretary.password.update');
    Route::get('/edit-profile', [App\Http\Controllers\UserController::class, 'editProfile'])->name('secretary.profile.edit');
    Route::put('/update-profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('secretary.profile.update');
    //routes patient controller
    Route::get('/patients',[App\Http\Controllers\PatientController::class,'index'])->name('secretary.patients');
    Route::get('/patient/{id}/show',[App\Http\Controllers\PatientController::class,'show'])->name('secretary.patient.show');
    Route::get('/patient/create',[App\Http\Controllers\PatientController::class,'create'])->name('secretary.patient.create');
    Route::post('/patient/store',[App\Http\Controllers\PatientController::class,'store'])->name('secretary.patient.store');
    Route::get('/patient/{id}/edit',[App\Http\Controllers\PatientController::class,'edit'])->name('secretary.patient.edit');
    Route::put('/patient/{id}/update',[App\Http\Controllers\PatientController::class,'update'])->name('secretary.patient.update');
    Route::delete('/patient/{id}/destroy',[App\Http\Controllers\PatientController::class,'destroy'])->name('secretary.patient.destroy');
});

