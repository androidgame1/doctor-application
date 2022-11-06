<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table" id="table-lines">
                <thead>
                    <tr>
                        <th>{{__('messages.designation')}}</th>
                        <th>{{__('messages.quantity')}}</th>
                        <th>{{__('messages.unit_price')}}</th>
                        <th>{{__('messages.tva')}}</th>
                        <th>{{__('messages.reduction')}}</th>
                        <th>{{__('messages.ht_amount')}}</th>
                        <th>{{__('messages.ttc_amount')}}</th>
                        <th>{{__('messages.action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(Route::current()->getName() == 'administrator.purchase_invoice.edit' || Route::current()->getName() == 'administrator.purchase_invoice.duplicate' || Route::current()->getName() == 'administrator.sale_invoice.edit' || Route::current()->getName() == 'administrator.sale_invoice.duplicate' || Route::current()->getName() == 'administrator.activity.edit' || Route::current()->getName() == 'administrator.activity.duplicate' || Route::current()->getName() == 'administrator.quote.edit' || Route::current()->getName() == 'administrator.quote.duplicate' || Route::current()->getName() == 'administrator.delivery_order.edit' || Route::current()->getName() == 'administrator.delivery_order.duplicate')
                        @php
                         $lines = [];
                         $index = 0; 
                         @endphp
                        @if(Route::current()->getName() == 'administrator.purchase_invoice.edit' || Route::current()->getName() == 'administrator.purchase_invoice.duplicate')
                            @php $lines = $purchase_invoice->purchase_invoice_lines; @endphp
                        @elseif(Route::current()->getName() == 'administrator.sale_invoice.edit' || Route::current()->getName() == 'administrator.sale_invoice.duplicate')
                            @php $lines = $sale_invoice->sale_invoice_lines; @endphp
                        @elseif(Route::current()->getName() == 'administrator.activity.edit' || Route::current()->getName() == 'administrator.activity.duplicate')
                            @php $lines = $activity->activity_lines; @endphp
                        @elseif(Route::current()->getName() == 'administrator.quote.edit' || Route::current()->getName() == 'administrator.quote.duplicate')
                            @php $lines = $quote->quote_lines; @endphp
                        @elseif(Route::current()->getName() == 'administrator.delivery_order.edit' || Route::current()->getName() == 'administrator.delivery_order.duplicate')
                            @php $lines = $delivery_order->delivery_order_lines; @endphp
                        @endif

                        @foreach($lines as $line)
                        <tr class="line">
                            <td>
                                <input placeholder="{{__('messages.designation')}}" value="{{$line->designation}}" type="text" list="datalist-designation[]" name="designation[]" class="form-control calculate-row {{$errors->has('designation')?'no-valid':''}} designation mb-3" required>
                                <datalist id="datalist-designations[]" class="datalist-designations">
                                    @foreach($designations as $value)
                                        <option value="{{$value->name}}" data-id="{{$value->id}}" data-name="{{$value->name}}" data-amount="{{$value->amount}}" data-description="{{$value->description}}">{{$value->name}}</option>
                                    @endforeach
                                </datalist>
                                <textarea placeholder="{{__('messages.description')}}" name="description[]"  class="form-control calculate-row {{$errors->has('description')?'no-valid':''}} description" rows="4" >{{$line->description}}</textarea>
                            </td>
                            <td>
                                <input placeholder="0" min="1" value="{{$line->quantity}}" type="number" name="quantity[]" class="form-control calculate-row {{$errors->has('quantity')?'no-valid':''}} quantity" required>
                            </td>
                            <td>
                                <input placeholder="0" min="1" value="{{$line->unit_price}}" type="number" name="unit_price[]" class="form-control calculate-row {{$errors->has('unit_price')?'no-valid':''}} unit_price" required>
                            </td>
                            <td>
                                <input placeholder="0" min="0" value="{{$line->tva}}" max="100" type="number" name="tva[]" class="form-control calculate-row {{$errors->has('tva')?'no-valid':''}} tva mb-3">
                                <input placeholder="0" min="0" value="{{$line->tva_amount}}" type="number" name="tva_amount[]" class="form-control calculate-row {{$errors->has('tva_amount')?'no-valid':''}} tva_amount" readonly required>
                            
                            </td>
                            <td>
                                <input placeholder="0" min="0" value="{{$line->reduction}}" max="100" type="number" name="reduction[]" class="form-control calculate-row {{$errors->has('reduction')?'no-valid':''}} reduction mb-3" required>
                                <input placeholder="0" min="0" value="{{$line->reduction_amount}}" type="number" name="reduction_amount[]" class="form-control calculate-row {{$errors->has('reduction_amount')?'no-valid':''}} reduction_amount" readonly required>
                            </td>
                            <td>
                                <input placeholder="0" min="1" value="{{$line->ht_amount}}" type="number" name="ht_amount[]" class="form-control calculate-row {{$errors->has('ht_amount')?'no-valid':''}} ht_amount" readonly required>
                            </td>
                            <td>
                                <input placeholder="0" min="1" value="{{$line->ttc_amount}}" type="number" name="ttc_amount[]" class="form-control calculate-row {{$errors->has('ttc_amount')?'no-valid':''}} ttc_amount" readonly required>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn {{$index <= 0 ? 'btn-secondary' : 'btn-danger btn-delete-row'}}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @php $index++; @endphp
                        @endforeach
                    @endif
                </tbody>
            </table>
            
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group text-right">
            <button type="button" class="btn btn-success btn-add-row"><i class="fa fa-plus"></i> {{__('messages.add')}}</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">
        <table class="table text-center">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th width="15%">{{__('messages.tva')}}</th>
                        <th width="15%">{{__('messages.reduction')}}</th>
                        <th width="15%">{{__('messages.ht_amount')}}</th>
                        <th width="15%">{{__('messages.ttc_amount')}}</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <span class="tva-amount-span">0</span> <b>MAD</b>
                            <input type="hidden" class="tva_total_amount" name="tva_total_amount" id="tva_total_amount">
                        </td>
                        <td>
                            <span class="reduction-amount-span">0</span> <b>MAD</b>
                            <input type="hidden" class="reduction_total_amount" name="reduction_total_amount" id="reduction_total_amount">
                        </td>
                        <td>
                            <span class="ht-amount-span">0</span> <b>MAD</b>
                            <input type="hidden" class="ht_total_amount" name="ht_total_amount" id="ht_total_amount">
                        </td>
                        <td>
                            <span class="ttc-amount-span">0</span> <b>MAD</b>
                            <input type="hidden" class="ttc_total_amount" name="ttc_total_amount" id="ttc_total_amount">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
