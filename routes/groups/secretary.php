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
    //routes patient controller
    Route::get('/appointments/{from}',[App\Http\Controllers\AppointmentController::class,'index'])->name('secretary.appointments');
    Route::get('/calendar',[App\Http\Controllers\AppointmentController::class,'calendar'])->name('secretary.calendar');
    Route::get('/appointment/{id}/show',[App\Http\Controllers\AppointmentController::class,'show'])->name('secretary.appointment.show');
    Route::get('/appointment/create',[App\Http\Controllers\AppointmentController::class,'create'])->name('secretary.appointment.create');
    Route::post('/appointment/store',[App\Http\Controllers\AppointmentController::class,'store'])->name('secretary.appointment.store');
    Route::get('/appointment/{id}/edit',[App\Http\Controllers\AppointmentController::class,'edit'])->name('secretary.appointment.edit');
    Route::put('/appointment/{id}/update',[App\Http\Controllers\AppointmentController::class,'update'])->name('secretary.appointment.update');
    Route::delete('/appointment/{id}/destroy',[App\Http\Controllers\AppointmentController::class,'destroy'])->name('secretary.appointment.destroy');
    Route::any('/appointment/{id}/drop-or-resize',[App\Http\Controllers\AppointmentController::class,'dropOrResize'])->name('secretary.appointment.drop_or_resize');
});

