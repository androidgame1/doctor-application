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
    //routes purchase_invoices controller
    Route::get('/purchase_invoices',[App\Http\Controllers\PurchaseInvoiceController::class,'index'])->name('administrator.purchase_invoices');
    Route::get('/purchase_invoice/{id}/show',[App\Http\Controllers\PurchaseInvoiceController::class,'show'])->name('administrator.purchase_invoice.show');
    Route::get('/purchase_invoice/create',[App\Http\Controllers\PurchaseInvoiceController::class,'create'])->name('administrator.purchase_invoice.create');
    Route::post('/purchase_invoice/store',[App\Http\Controllers\PurchaseInvoiceController::class,'store'])->name('administrator.purchase_invoice.store');
    Route::get('/purchase_invoice/{id}/edit',[App\Http\Controllers\PurchaseInvoiceController::class,'edit'])->name('administrator.purchase_invoice.edit');
    Route::put('/purchase_invoice/{id}/update',[App\Http\Controllers\PurchaseInvoiceController::class,'update'])->name('administrator.purchase_invoice.update');
    Route::delete('/purchase_invoice/{id}/destroy',[App\Http\Controllers\PurchaseInvoiceController::class,'destroy'])->name('administrator.purchase_invoice.destroy');
    Route::get('/purchase_invoice/{id}/cancel',[App\Http\Controllers\PurchaseInvoiceController::class,'cancel'])->name('administrator.purchase_invoice.cancel');
    Route::get('/purchase_invoice/{id}/duplicate',[App\Http\Controllers\PurchaseInvoiceController::class,'duplicate'])->name('administrator.purchase_invoice.duplicate');
    //routes patient controller
    Route::get('/patients',[App\Http\Controllers\PatientController::class,'index'])->name('administrator.patients');
    Route::get('/patient/{id}/show',[App\Http\Controllers\PatientController::class,'show'])->name('administrator.patient.show');
    Route::get('/patient/create',[App\Http\Controllers\PatientController::class,'create'])->name('administrator.patient.create');
    Route::post('/patient/store',[App\Http\Controllers\PatientController::class,'store'])->name('administrator.patient.store');
    Route::get('/patient/{id}/edit',[App\Http\Controllers\PatientController::class,'edit'])->name('administrator.patient.edit');
    Route::put('/patient/{id}/update',[App\Http\Controllers\PatientController::class,'update'])->name('administrator.patient.update');
    Route::delete('/patient/{id}/destroy',[App\Http\Controllers\PatientController::class,'destroy'])->name('administrator.patient.destroy');
    //routes appointment controller
    Route::get('/appointments/{from}',[App\Http\Controllers\AppointmentController::class,'index'])->name('administrator.appointments');
    Route::get('/calendar',[App\Http\Controllers\AppointmentController::class,'calendar'])->name('administrator.calendar');
    Route::get('/appointment/{id}/show',[App\Http\Controllers\AppointmentController::class,'show'])->name('administrator.appointment.show');
    Route::get('/appointment/create',[App\Http\Controllers\AppointmentController::class,'create'])->name('administrator.appointment.create');
    Route::post('/appointment/store',[App\Http\Controllers\AppointmentController::class,'store'])->name('administrator.appointment.store');
    Route::get('/appointment/{id}/edit',[App\Http\Controllers\AppointmentController::class,'edit'])->name('administrator.appointment.edit');
    Route::put('/appointment/{id}/update',[App\Http\Controllers\AppointmentController::class,'update'])->name('administrator.appointment.update');
    Route::delete('/appointment/{id}/destroy',[App\Http\Controllers\AppointmentController::class,'destroy'])->name('administrator.appointment.destroy');
    Route::any('/appointment/{id}/drop-or-resize',[App\Http\Controllers\AppointmentController::class,'dropOrResize'])->name('administrator.appointment.drop_or_resize');
    //routes status controller
    Route::get('/status',[App\Http\Controllers\StatusController::class,'index'])->name('administrator.status');
    Route::get('/status/{id}/show',[App\Http\Controllers\StatusController::class,'show'])->name('administrator.status.show');
    Route::post('/status/store',[App\Http\Controllers\StatusController::class,'store'])->name('administrator.status.store');
    Route::get('/status/{id}/edit',[App\Http\Controllers\StatusController::class,'edit'])->name('administrator.status.edit');
    Route::put('/status/{id}/update',[App\Http\Controllers\StatusController::class,'update'])->name('administrator.status.update');
    Route::delete('/status/{id}/destroy',[App\Http\Controllers\StatusController::class,'destroy'])->name('administrator.status.destroy');
    //routes drug controller
    Route::get('/drugs',[App\Http\Controllers\DrugController::class,'index'])->name('administrator.drugs');
    Route::get('/drug/{id}/show',[App\Http\Controllers\DrugController::class,'show'])->name('administrator.drug.show');
    Route::post('/drug/store',[App\Http\Controllers\DrugController::class,'store'])->name('administrator.drug.store');
    Route::get('/drug/{id}/edit',[App\Http\Controllers\DrugController::class,'edit'])->name('administrator.drug.edit');
    Route::put('/drug/{id}/update',[App\Http\Controllers\DrugController::class,'update'])->name('administrator.drug.update');
    Route::delete('/drug/{id}/destroy',[App\Http\Controllers\DrugController::class,'destroy'])->name('administrator.drug.destroy');
    //routes drug controller
    Route::get('/tests',[App\Http\Controllers\TestController::class,'index'])->name('administrator.tests');
    Route::get('/test/{id}/show',[App\Http\Controllers\TestController::class,'show'])->name('administrator.test.show');
    Route::post('/test/store',[App\Http\Controllers\TestController::class,'store'])->name('administrator.test.store');
    Route::get('/test/{id}/edit',[App\Http\Controllers\TestController::class,'edit'])->name('administrator.test.edit');
    Route::put('/test/{id}/update',[App\Http\Controllers\TestController::class,'update'])->name('administrator.test.update');
    Route::delete('/test/{id}/destroy',[App\Http\Controllers\TestController::class,'destroy'])->name('administrator.test.destroy');
});

