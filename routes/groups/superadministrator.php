<?php
Route::group(['prefix'=>'superadministrator','middleware'=>['prevent.back.history','is.superadministrator']],function(){
    // Routes home controller
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('superadministrator.home');
    // Routes user controller
    Route::get('/edit-password', [App\Http\Controllers\UserController::class, 'editPassword'])->name('superadministrator.password.edit');
    Route::put('/update-password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('superadministrator.password.update');
    Route::get('/edit-profile', [App\Http\Controllers\UserController::class, 'editProfile'])->name('superadministrator.profile.edit');
    Route::put('/update-profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('superadministrator.profile.update');
    //routes user controller
    Route::get('/users/{role}',[App\Http\Controllers\UserController::class,'index'])->name('superadministrator.users');
    Route::get('/user/{role}/{id}/show',[App\Http\Controllers\UserController::class,'show'])->name('superadministrator.user.show');
    Route::get('/user/{role}/create',[App\Http\Controllers\UserController::class,'create'])->name('superadministrator.user.create');
    Route::post('/user/{role}/store',[App\Http\Controllers\UserController::class,'store'])->name('superadministrator.user.store');
    Route::get('/user/{role}/{id}/edit',[App\Http\Controllers\UserController::class,'edit'])->name('superadministrator.user.edit');
    Route::put('/user/{role}/{id}/update',[App\Http\Controllers\UserController::class,'update'])->name('superadministrator.user.update');
    Route::delete('/user/{role}/{id}/destroy',[App\Http\Controllers\UserController::class,'destroy'])->name('superadministrator.user.destroy');
    Route::get('/user/{role}/{id}/status/update',[App\Http\Controllers\UserController::class,'updateStatus'])->name('superadministrator.user.status.update');
});

