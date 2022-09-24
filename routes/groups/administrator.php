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
    Route::get('/users/{role}/{validation}',[App\Http\Controllers\UserController::class,'filter'])->name('administrator.users.filter');
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
    //routes product controller
    Route::get('/acts',[App\Http\Controllers\ActController::class,'index'])->name('administrator.acts');
    Route::get('/act/{id}/show',[App\Http\Controllers\ActController::class,'show'])->name('administrator.act.show');
    Route::post('/act/store',[App\Http\Controllers\ActController::class,'store'])->name('administrator.act.store');
    Route::get('/act/{id}/edit',[App\Http\Controllers\ActController::class,'edit'])->name('administrator.act.edit');
    Route::put('/act/{id}/update',[App\Http\Controllers\ActController::class,'update'])->name('administrator.act.update');
    Route::delete('/act/{id}/destroy',[App\Http\Controllers\ActController::class,'destroy'])->name('administrator.act.destroy');
    //routes purchase_invoices controller
    Route::get('/purchase_invoices',[App\Http\Controllers\PurchaseInvoiceController::class,'index'])->name('administrator.purchase_invoices');
    Route::get('/purchase_invoices/{status}/filter',[App\Http\Controllers\PurchaseInvoiceController::class,'filter'])->name('administrator.purchase_invoices.filter');
    Route::get('/purchase_invoice/{id}/show',[App\Http\Controllers\PurchaseInvoiceController::class,'show'])->name('administrator.purchase_invoice.show');
    Route::get('/purchase_invoice/create',[App\Http\Controllers\PurchaseInvoiceController::class,'create'])->name('administrator.purchase_invoice.create');
    Route::post('/purchase_invoice/store',[App\Http\Controllers\PurchaseInvoiceController::class,'store'])->name('administrator.purchase_invoice.store');
    Route::get('/purchase_invoice/{id}/edit',[App\Http\Controllers\PurchaseInvoiceController::class,'edit'])->name('administrator.purchase_invoice.edit');
    Route::put('/purchase_invoice/{id}/update',[App\Http\Controllers\PurchaseInvoiceController::class,'update'])->name('administrator.purchase_invoice.update');
    Route::delete('/purchase_invoice/{id}/destroy',[App\Http\Controllers\PurchaseInvoiceController::class,'destroy'])->name('administrator.purchase_invoice.destroy');
    Route::get('/purchase_invoice/{id}/cancel',[App\Http\Controllers\PurchaseInvoiceController::class,'cancel'])->name('administrator.purchase_invoice.cancel');
    Route::get('/purchase_invoice/{id}/duplicate',[App\Http\Controllers\PurchaseInvoiceController::class,'duplicate'])->name('administrator.purchase_invoice.duplicate');
    Route::get('/purchase_invoice/{id}/pdf',[App\Http\Controllers\PurchaseInvoiceController::class,'pdf'])->name('administrator.purchase_invoice.pdf');
    //routes purchase_invoice_payment controller
    Route::get('/purchase_invoice_payments/{purchase_invoice_id}',[App\Http\Controllers\PurchaseInvoicePaymentController::class,'index'])->name('administrator.purchase_invoice_payments');
    Route::get('/purchase_invoice_payment/{id}/show',[App\Http\Controllers\PurchaseInvoicePaymentController::class,'show'])->name('administrator.purchase_invoice_payment.show');
    Route::get('/purchase_invoice_payment/{purchase_invoice_id}/create',[App\Http\Controllers\PurchaseInvoicePaymentController::class,'create'])->name('administrator.purchase_invoice_payment.create');
    Route::post('/purchase_invoice_payment/store',[App\Http\Controllers\PurchaseInvoicePaymentController::class,'store'])->name('administrator.purchase_invoice_payment.store');
    Route::get('/purchase_invoice_payment/{id}/edit',[App\Http\ControllePurchase::class,'edit'])->name('administrator.purchase_invoice_payment.edit');
    Route::put('/purchase_invoice_payment/{id}/update',[App\Http\Controllers\PurchaseInvoicePaymentController::class,'update'])->name('administrator.purchase_invoice_payment.update');
    Route::delete('/purchase_invoice_payment/{id}/destroy',[App\Http\Controllers\PurchaseInvoicePaymentController::class,'destroy'])->name('administrator.purchase_invoice_payment.destroy');
    //routes sale_invoices controller
    Route::get('/sale_invoices',[App\Http\Controllers\SaleInvoiceController::class,'index'])->name('administrator.sale_invoices');
    Route::get('/sale_invoices/{status}/filter',[App\Http\Controllers\SaleInvoiceController::class,'filter'])->name('administrator.sale_invoices.filter');
    Route::get('/sale_invoice/{id}/show',[App\Http\Controllers\SaleInvoiceController::class,'show'])->name('administrator.sale_invoice.show');
    Route::get('/sale_invoice/create',[App\Http\Controllers\SaleInvoiceController::class,'create'])->name('administrator.sale_invoice.create');
    Route::post('/sale_invoice/store',[App\Http\Controllers\SaleInvoiceController::class,'store'])->name('administrator.sale_invoice.store');
    Route::get('/sale_invoice/{id}/edit',[App\Http\Controllers\SaleInvoiceController::class,'edit'])->name('administrator.sale_invoice.edit');
    Route::put('/sale_invoice/{id}/update',[App\Http\Controllers\SaleInvoiceController::class,'update'])->name('administrator.sale_invoice.update');
    Route::delete('/sale_invoice/{id}/destroy',[App\Http\Controllers\SaleInvoiceController::class,'destroy'])->name('administrator.sale_invoice.destroy');
    Route::get('/sale_invoice/{id}/cancel',[App\Http\Controllers\SaleInvoiceController::class,'cancel'])->name('administrator.sale_invoice.cancel');
    Route::get('/sale_invoice/{id}/duplicate',[App\Http\Controllers\SaleInvoiceController::class,'duplicate'])->name('administrator.sale_invoice.duplicate');
    Route::get('/sale_invoice/{id}/pdf',[App\Http\Controllers\SaleInvoiceController::class,'pdf'])->name('administrator.sale_invoice.pdf');
    //routes sale_invoice_payment controller
    Route::get('/sale_invoice_payments/{sale_invoice_id}',[App\Http\Controllers\SaleInvoicePaymentController::class,'index'])->name('administrator.sale_invoice_payments');
    Route::get('/sale_invoice_payment/{id}/show',[App\Http\Controllers\SaleInvoicePaymentController::class,'show'])->name('administrator.sale_invoice_payment.show');
    Route::get('/sale_invoice_payment/{sale_invoice_id}/create',[App\Http\Controllers\SaleInvoicePaymentController::class,'create'])->name('administrator.sale_invoice_payment.create');
    Route::post('/sale_invoice_payment/store',[App\Http\Controllers\SaleInvoicePaymentController::class,'store'])->name('administrator.sale_invoice_payment.store');
    Route::get('/sale_invoice_payment/{id}/edit',[App\Http\Controllers\SaleInvoicePaymentController::class,'edit'])->name('administrator.sale_invoice_payment.edit');
    Route::put('/sale_invoice_payment/{id}/update',[App\Http\Controllers\SaleInvoicePaymentController::class,'update'])->name('administrator.sale_invoice_payment.update');
    Route::delete('/sale_invoice_payment/{id}/destroy',[App\Http\Controllers\SaleInvoicePaymentController::class,'destroy'])->name('administrator.sale_invoice_payment.destroy');
    //routes activity controller
    Route::get('/activities',[App\Http\Controllers\ActivityController::class,'index'])->name('administrator.activities');
    Route::get('/activities/{status}/filter',[App\Http\Controllers\ActivityController::class,'filter'])->name('administrator.activities.filter');
    Route::get('/activity/{id}/show',[App\Http\Controllers\ActivityController::class,'show'])->name('administrator.activity.show');
    Route::get('/activity/create',[App\Http\Controllers\ActivityController::class,'create'])->name('administrator.activity.create');
    Route::post('/activity/store',[App\Http\Controllers\ActivityController::class,'store'])->name('administrator.activity.store');
    Route::get('/activity/{id}/edit',[App\Http\Controllers\ActivityController::class,'edit'])->name('administrator.activity.edit');
    Route::put('/activity/{id}/update',[App\Http\Controllers\ActivityController::class,'update'])->name('administrator.activity.update');
    Route::delete('/activity/{id}/destroy',[App\Http\Controllers\ActivityController::class,'destroy'])->name('administrator.activity.destroy');
    Route::get('/activity/{id}/cancel',[App\Http\Controllers\ActivityController::class,'cancel'])->name('administrator.activity.cancel');
    Route::get('/activity/{id}/duplicate',[App\Http\Controllers\ActivityController::class,'duplicate'])->name('administrator.activity.duplicate');
    Route::get('/activity/{id}/pdf',[App\Http\Controllers\ActivityController::class,'pdf'])->name('administrator.activity.pdf');
    //routes quote controller
    Route::get('/quotes',[App\Http\Controllers\QuoteController::class,'index'])->name('administrator.quotes');
    Route::get('/quotes/{status}/filter',[App\Http\Controllers\QuoteController::class,'filter'])->name('administrator.quotes.filter');
    Route::get('/quote/{id}/show',[App\Http\Controllers\QuoteController::class,'show'])->name('administrator.quote.show');
    Route::get('/quote/create',[App\Http\Controllers\QuoteController::class,'create'])->name('administrator.quote.create');
    Route::post('/quote/store',[App\Http\Controllers\QuoteController::class,'store'])->name('administrator.quote.store');
    Route::get('/quote/{id}/edit',[App\Http\Controllers\QuoteController::class,'edit'])->name('administrator.quote.edit');
    Route::put('/quote/{id}/update',[App\Http\Controllers\QuoteController::class,'update'])->name('administrator.quote.update');
    Route::delete('/quote/{id}/destroy',[App\Http\Controllers\QuoteController::class,'destroy'])->name('administrator.quote.destroy');
    Route::get('/quote/{id}/cancel',[App\Http\Controllers\QuoteController::class,'cancel'])->name('administrator.quote.cancel');
    Route::get('/quote/{id}/duplicate',[App\Http\Controllers\QuoteController::class,'duplicate'])->name('administrator.quote.duplicate');
    Route::get('/quote/{id}/pdf',[App\Http\Controllers\QuoteController::class,'pdf'])->name('administrator.quote.pdf');
    //routes activity_payment controller
    Route::get('/activity_payments/{activity_id}',[App\Http\Controllers\ActivityPaymentController::class,'index'])->name('administrator.activity_payments');
    Route::get('/activity_payment/{id}/show',[App\Http\Controllers\ActivityPaymentController::class,'show'])->name('administrator.activity_payment.show');
    Route::get('/activity_payment/{activity_id}/create',[App\Http\Controllers\ActivityPaymentController::class,'create'])->name('administrator.activity_payment.create');
    Route::post('/activity_payment/store',[App\Http\Controllers\ActivityPaymentController::class,'store'])->name('administrator.activity_payment.store');
    Route::get('/activity_payment/{id}/edit',[App\Http\Controllers\ActivityPaymentController::class,'edit'])->name('administrator.activity_payment.edit');
    Route::put('/activity_payment/{id}/update',[App\Http\Controllers\ActivityPaymentController::class,'update'])->name('administrator.activity_payment.update');
    Route::delete('/activity_payment/{id}/destroy',[App\Http\Controllers\ActivityPaymentController::class,'destroy'])->name('administrator.activity_payment.destroy');
    //routes delivery order controller
    Route::get('/delivery_orders',[App\Http\Controllers\DeliveryOrderController::class,'index'])->name('administrator.delivery_orders');
    Route::get('/delivery_order/{id}/show',[App\Http\Controllers\DeliveryOrderController::class,'show'])->name('administrator.delivery_order.show');
    Route::get('/delivery_order/create',[App\Http\Controllers\DeliveryOrderController::class,'create'])->name('administrator.delivery_order.create');
    Route::post('/delivery_order/store',[App\Http\Controllers\DeliveryOrderController::class,'store'])->name('administrator.delivery_order.store');
    Route::get('/delivery_order/{id}/edit',[App\Http\Controllers\DeliveryOrderController::class,'edit'])->name('administrator.delivery_order.edit');
    Route::put('/delivery_order/{id}/update',[App\Http\Controllers\DeliveryOrderController::class,'update'])->name('administrator.delivery_order.update');
    Route::delete('/delivery_order/{id}/destroy',[App\Http\Controllers\DeliveryOrderController::class,'destroy'])->name('administrator.delivery_order.destroy');
    Route::get('/delivery_order/{id}/duplicate',[App\Http\Controllers\DeliveryOrderController::class,'duplicate'])->name('administrator.delivery_order.duplicate');
    //routes drug controller
    Route::get('/purchase_orders',[App\Http\Controllers\PurchaseOrderController::class,'index'])->name('administrator.purchase_orders');
    Route::get('/purchase_order/{id}/show',[App\Http\Controllers\PurchaseOrderController::class,'show'])->name('administrator.purchase_order.show');
    Route::get('/purchase_order/create',[App\Http\Controllers\PurchaseOrderController::class,'create'])->name('administrator.purchase_order.create');
    Route::post('/purchase_order/store',[App\Http\Controllers\PurchaseOrderController::class,'store'])->name('administrator.purchase_order.store');
    Route::get('/purchase_order/{id}/edit',[App\Http\Controllers\PurchaseOrderController::class,'edit'])->name('administrator.purchase_order.edit');
    Route::put('/purchase_order/{id}/update',[App\Http\Controllers\PurchaseOrderController::class,'update'])->name('administrator.purchase_order.update');
    Route::delete('/purchase_order/{id}/destroy',[App\Http\Controllers\PurchaseOrderController::class,'destroy'])->name('administrator.purchase_order.destroy');
    Route::get('/purchase_order/{id}/pdf',[App\Http\Controllers\PurchaseOrderController::class,'pdf'])->name('administrator.purchase_order.pdf');
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
     //routes type_drug controller
     Route::get('/type_drugs',[App\Http\Controllers\TypeDrugController::class,'index'])->name('administrator.type_drugs');
     Route::get('/type_drug/{id}/show',[App\Http\Controllers\TypeDrugController::class,'show'])->name('administrator.type_drug.show');
     Route::post('/type_drug/store',[App\Http\Controllers\TypeDrugController::class,'store'])->name('administrator.type_drug.store');
     Route::get('/type_drug/{id}/edit',[App\Http\Controllers\TypeDrugController::class,'edit'])->name('administrator.type_drug.edit');
     Route::put('/type_drug/{id}/update',[App\Http\Controllers\TypeDrugController::class,'update'])->name('administrator.type_drug.update');
     Route::delete('/type_drug/{id}/destroy',[App\Http\Controllers\TypeDrugController::class,'destroy'])->name('administrator.type_drug.destroy');
    //routes drug controller
    Route::get('/prescriptions',[App\Http\Controllers\PrescriptionController::class,'index'])->name('administrator.prescriptions');
    Route::get('/prescription/{id}/show',[App\Http\Controllers\PrescriptionController::class,'show'])->name('administrator.prescription.show');
    Route::get('/prescription/create',[App\Http\Controllers\PrescriptionController::class,'create'])->name('administrator.prescription.create');
    Route::post('/prescription/store',[App\Http\Controllers\PrescriptionController::class,'store'])->name('administrator.prescription.store');
    Route::get('/prescription/{id}/edit',[App\Http\Controllers\PrescriptionController::class,'edit'])->name('administrator.prescription.edit');
    Route::put('/prescription/{id}/update',[App\Http\Controllers\PrescriptionController::class,'update'])->name('administrator.prescription.update');
    Route::delete('/prescription/{id}/destroy',[App\Http\Controllers\PrescriptionController::class,'destroy'])->name('administrator.prescription.destroy');
    Route::get('/prescription/{id}/pdf',[App\Http\Controllers\PrescriptionController::class,'pdf'])->name('administrator.prescription.pdf');
    //routes product controller
    Route::get('/charges',[App\Http\Controllers\ChargeController::class,'index'])->name('administrator.charges');
    Route::get('/charge/{id}/show',[App\Http\Controllers\ChargeController::class,'show'])->name('administrator.charge.show');
    Route::post('/charge/store',[App\Http\Controllers\ChargeController::class,'store'])->name('administrator.charge.store');
    Route::get('/charge/{id}/edit',[App\Http\Controllers\ChargeController::class,'edit'])->name('administrator.charge.edit');
    Route::put('/charge/{id}/update',[App\Http\Controllers\ChargeController::class,'update'])->name('administrator.charge.update');
    Route::delete('/charge/{id}/destroy',[App\Http\Controllers\ChargeController::class,'destroy'])->name('administrator.charge.destroy');
});