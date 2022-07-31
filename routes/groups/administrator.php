<?php
Route::group(['prefix'=>'administrator','middleware'=>['prevent.back.history','is.administrator']],function(){
    // Routes home controller
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('administrator.home');
    // Routes user controller
    Route::get('/edit-password', [App\Http\Controllers\UserController::class, 'editPassword'])->name('administrator.password.edit');
    Route::put('/update-password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('administrator.password.update');
    Route::get('/edit-profile', [App\Http\Controllers\UserController::class, 'editProfile'])->name('administrator.profile.edit');
    Route::put('/update-profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('administrator.profile.update');
    //routes user controller
    Route::get('/users/{role}',[App\Http\Controllers\UserController::class,'index'])->name('administrator.users');
    Route::get('/user/{role}/{id}/show',[App\Http\Controllers\UserController::class,'show'])->name('administrator.user.show');
    Route::get('/user/{role}/create',[App\Http\Controllers\UserController::class,'create'])->name('administrator.user.create');
    Route::post('/user/{role}/store',[App\Http\Controllers\UserController::class,'store'])->name('administrator.user.store');
    Route::get('/user/{role}/{id}/edit',[App\Http\Controllers\UserController::class,'edit'])->name('administrator.user.edit');
    Route::put('/user/{role}/{id}/update',[App\Http\Controllers\UserController::class,'update'])->name('administrator.user.update');
    Route::delete('/user/{role}/{id}/destroy',[App\Http\Controllers\UserController::class,'destroy'])->name('administrator.user.destroy');
    Route::get('/user/{role}/{id}/status/update',[App\Http\Controllers\UserController::class,'updateStatus'])->name('administrator.user.status.update');
    //routes supplier controller
    Route::get('/suppliers',[App\Http\Controllers\SupplierController::class,'index'])->name('administrator.suppliers');
    Route::get('/supplier/{id}/show',[App\Http\Controllers\SupplierController::class,'show'])->name('administrator.supplier.show');
    Route::get('/supplier/create',[App\Http\Controllers\SupplierController::class,'create'])->name('administrator.supplier.create');
    Route::post('/supplier/store',[App\Http\Controllers\SupplierController::class,'store'])->name('administrator.supplier.store');
    Route::get('/supplier/{id}/edit',[App\Http\Controllers\SupplierController::class,'edit'])->name('administrator.supplier.edit');
    Route::put('/supplier/{id}/update',[App\Http\Controllers\SupplierController::class,'update'])->name('administrator.supplier.update');
    Route::delete('/supplier/{id}/destroy',[App\Http\Controllers\SupplierController::class,'destroy'])->name('administrator.supplier.destroy');
    //routes product controller
    Route::get('/products',[App\Http\Controllers\ProductController::class,'index'])->name('administrator.products');
    Route::get('/product/{id}/show',[App\Http\Controllers\ProductController::class,'show'])->name('administrator.product.show');
    Route::post('/product/store',[App\Http\Controllers\ProductController::class,'store'])->name('administrator.product.store');
    Route::get('/product/{id}/edit',[App\Http\Controllers\ProductController::class,'edit'])->name('administrator.product.edit');
    Route::put('/product/{id}/update',[App\Http\Controllers\ProductController::class,'update'])->name('administrator.product.update');
    Route::delete('/product/{id}/destroy',[App\Http\Controllers\ProductController::class,'destroy'])->name('administrator.product.destroy');
});

