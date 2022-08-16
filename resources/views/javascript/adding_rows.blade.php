<script>
let lines_length = $('.line').length
//add row
$(document).on('click','.btn-add-row',function(){
    let lines_length = $('.line').length
    let class_btn_delete = "btn-secondary"
    if(lines_length<=0){
        class_btn_delete = "btn-secondary"
    }else{
        class_btn_delete = "btn-danger deletable"
    }
    $("#table-lines tbody").append(
        `<tr class="line">`+
            `<td>`+
                `<input placeholder="{{__('messages.designation')}}" type="text" list="datalist-designations[]" name="designation[]" class="form-control calculate-row {{$errors->has('designation')?'form-control-danger':''}} designation mb-3" required>`+
                `<datalist id="datalist-designations[]" class="datalist-designations">`+
                    `@foreach($designations as $value)`+
                        `<option value="{{$value->name}}" data-id="{{$value->id}}" data-name="{{$value->name}}" data-amount="{{$value->amount}}" data-description="{{$value->description}}">{{$value->name}}</option>`+
                    `@endforeach`+
                `</datalist>`+
                `<textarea placeholder="{{__('messages.description')}}" name="description[]"  class="form-control calculate-row {{$errors->has('description')?'form-control-danger':''}} description" rows="4"></textarea>`+
            `</td>`+
            `<td>`+
                `<input placeholder="0" min="1" value="1" type="number" name="quantity[]" class="form-control calculate-row {{$errors->has('quantity')?'form-control-danger':''}} quantity" required>`+
            `</td>`+
            `<td>`+
                `<input placeholder="0" min="1" value="0" type="number" name="unit_price[]" class="form-control calculate-row {{$errors->has('unit_price')?'form-control-danger':''}} unit_price" required>`+
            `</td>`+
            @if(Route::current()->getName() == 'administrator.purchase_invoice.create' || Route::current()->getName() == 'administrator.purchase_invoice.edit' || Route::current()->getName() == 'administrator.purchase_invoice.duplicate')
                `<td>`+
                    `<input placeholder="0" min="0" value="0" max="100" type="number" name="tva[]" class="form-control calculate-row {{$errors->has('tva')?'form-control-danger':''}} tva mb-3">`+
                    `<input placeholder="0" min="0" value="0" type="number" name="tva_amount[]" readonly class="form-control calculate-row {{$errors->has('tva_amount')?'form-control-danger':''}} tva_amount" required>`+
                `</td>`+
            @endif
            `<td>`+
                `<input placeholder="0" min="0" value="0" max="100" type="number" name="reduction[]" class="form-control calculate-row {{$errors->has('reduction')?'form-control-danger':''}} reduction mb-3" required>`+
                `<input placeholder="0" min="0" value="0" type="number" name="reduction_amount[]" readonly class="form-control calculate-row {{$errors->has('reduction_amount')?'form-control-danger':''}} reduction_amount"  required>`+
            `</td>`+
            `<td>`+
                `<input placeholder="0" min="1" value="0" type="number" name="ht_amount[]" class="form-control calculate-row {{$errors->has('ht_amount')?'form-control-danger':''}} ht_amount" readonly required>`+
            `</td>`+
            @if(Route::current()->getName() == 'administrator.purchase_invoice.create' || Route::current()->getName() == 'administrator.purchase_invoice.edit' || Route::current()->getName() == 'administrator.purchase_invoice.duplicate')
                `<td>`+
                    ` <input placeholder="0" min="1" value="0" type="number" name="ttc_amount[]" class="form-control calculate-row {{$errors->has('ttc_amount')?'form-control-danger':''}} ttc_amount" readonly required>`+
                `</td>`+
            @endif
            `<td>`+
                ` <a href="javascript:void(0)" class="btn `+class_btn_delete+` btn-delete-row"><i class="fa fa-trash"></i></a>`+
            `</td>`+
        `</tr>`
    )
})
//show the price of selected product
$(document).on('change keyup','.designation',function(){
    let value= $(this).val()
    let line = $(this).parents('.line')
    for (let index = 0; index < line.find('.datalist-designations').children('option').length; index++) {
        let option = line.find('.datalist-designations').children('option:eq('+index+')')
        if(value.toLowerCase() == option.attr('data-name').toLowerCase()){
            line.find('.unit_price').val(option.attr('data-amount'))
            line.find('.description').val(option.attr('data-description'))
            break;
        }
        
    }
})
//delete column
$(document).on('click','.btn-delete-row.deletable',function(){
    let line = $(this).parents('.line')
    line.remove()
    calculateSpecifiedRow(line.find('.quantity'),line.find('.unit_price'),line.find('.tva'),line.find('.tva_amount'),line.find('.reduction'),line.find('.reduction_amount'),line.find('.ht_amount'),line.find('.ttc_amount'))
    calculateTotal()
})
if(lines_length<=0){
    $('.btn-add-row').click()
}else{
    calculateTotal()
}
//calculate specified row
$(document).on("change keyup",'.calculate-row',function(){
    let line = $(this).parents('.line')
    calculateSpecifiedRow(line.find('.quantity'),line.find('.unit_price'),line.find('.tva'),line.find('.tva_amount'),line.find('.reduction'),line.find('.reduction_amount'),line.find('.ht_amount'),line.find('.ttc_amount'))
    calculateTotal()
})
</script>