<script>
    function upload(file) {
        $(file).click()
    }

    function choseFile(input,img) {
        let fileValue = input.value
        if(fileValue.length>0){
            let file = input.files[0];
            let reader = new FileReader();
            reader.onload = function () {
                $(img).attr('src',reader.result)
            };
            reader.onerror = function () {
                console.log(reader.error);
            };
            reader.readAsDataURL(file);
        }else{
            $(img).attr('src','')
        }
        
    }
    function cancelImage(img,imgpath){
        $(img).attr('src','')
        $(imgpath).val('')
    }
    function makeConfirmPasswordRequired(form,password,confirmpassword){
        let passwordtouse = $(form).find('input[name="'+password+'"]')
        let confirmpasswordtouse = $(form).find('input[name="'+confirmpassword+'"]')
        if(![undefined,null,''].includes(passwordtouse.val()) || ![undefined,null,''].includes(confirmpasswordtouse.val())){
            passwordtouse.attr('required','')
            confirmpasswordtouse.attr('required','')
        }else{
            passwordtouse.removeAttr('required')
            confirmpasswordtouse.removeAttr('required')
        }
    }
    function calculateSpecifiedRow(quantity,unit_price,tva,tva_amount,reduction,reduction_amount,ht_amount,ttc_amount){
        
        let quantity_value = (parseInt(quantity.val())>=1 ? parseInt(quantity.val()) : 1)
        let unit_price_value = (parseFloat(unit_price.val()) >=0 ? parseFloat(unit_price.val()) : 0) 
        let subtotal_amount_value = (parseFloat(parseFloat(unit_price_value) * parseInt(quantity_value)) >=0 ? parseFloat(parseFloat(unit_price_value) * parseInt(quantity_value)) : 0)
        let tva_value = ((parseInt(tva.val()) >=0 && parseInt(tva.val()) <=100) ? parseInt(tva.val()) : 0)
        let reduction_value = ((parseInt(reduction.val()) >=0 && parseInt(reduction.val()) <=100) ? parseInt(reduction.val()) : 0)
        let reduction_amount_value = (parseFloat((parseFloat(subtotal_amount_value) * parseInt(reduction.val())) / 100) >= 0 ? parseFloat((parseFloat(subtotal_amount_value) * parseInt(reduction.val())) / 100) : 0)
        let ht_amount_value = (parseFloat(parseFloat(subtotal_amount_value) - parseFloat(reduction_amount_value)) >=0 ? parseFloat(parseFloat(subtotal_amount_value) - parseFloat(reduction_amount_value)) : 0)
        let tva_amount_value = (parseFloat((parseFloat(ht_amount_value) * parseInt(tva.val()) / 100)) >= 0 ? parseFloat((parseFloat(ht_amount_value) * parseInt(tva.val()) / 100)) : 0)
        let ttc_amount_value = (parseFloat(parseFloat(ht_amount_value) + parseFloat(tva_amount_value)) >=0 ? parseFloat(parseFloat(ht_amount_value) + parseFloat(tva_amount_value)) : 0)

        quantity.val(quantity_value)
        unit_price.val(unit_price_value)
        tva.val(tva_value)
        tva_amount.val(tva_amount_value)
        reduction.val(reduction_value)
        reduction_amount.val(reduction_amount_value)
        ht_amount.val(ht_amount_value)
        ttc_amount.val(ttc_amount_value)
        
    }
    function calculateTotal(){
        
        let lines = $('.line').length
        let quantity_value_to_calculate = 0
        let unit_price_value_to_calculate = 0
        let subtotal_amount_value_to_calculate = 0
        let tva_value_to_calculate = 0
        let reduction_value_to_calculate = 0
        let reduction_amount_value_to_calculate = 0
        let ht_amount_value_to_calculate = 0
        let tva_amount_value_to_calculate = 0
        let ttc_amount_value_to_calculate = 0
        let reduction_amount_total = 0
        let tva_amount_total = 0
        let ht_amount_total = 0
        let ttc_amount_total = 0

        for (let i = 0; i < lines; i++) {
            
            quantity_value_to_calculate = (parseInt($('.line:eq('+i+')').find('.quantity').val())>=1 ? parseInt($('.line:eq('+i+')').find('.quantity').val()) : 1)
            unit_price_value_to_calculate = (parseFloat($('.line:eq('+i+')').find('.unit_price').val()) >=0 ? parseFloat($('.line:eq('+i+')').find('.unit_price').val()) : 0) 
            subtotal_amount_value_to_calculate = (parseFloat(parseFloat(unit_price_value_to_calculate) * parseInt($('.line:eq('+i+')').find('.quantity').val())) >=0 ? parseFloat(parseFloat(unit_price_value_to_calculate) * parseInt($('.line:eq('+i+')').find('.quantity').val())) : 0)
            tva_value_to_calculate = ((parseInt($('.line:eq('+i+')').find('.tva').val()) >=0 && parseInt($('.line:eq('+i+')').find('.tva').val()) <=100) ? parseInt($('.line:eq('+i+')').find('.tva').val()) : 0)
            reduction_value_to_calculate = ((parseInt($('.line:eq('+i+')').find('.reduction').val()) >=0 && parseInt($('.line:eq('+i+')').find('.reduction').val()) <=100) ? parseInt($('.line:eq('+i+')').find('.reduction').val()) : 0)
            reduction_amount_value_to_calculate = (parseFloat((parseFloat(subtotal_amount_value_to_calculate) * parseInt($('.line:eq('+i+')').find('.reduction').val())) / 100) >= 0 ? parseFloat((parseFloat(subtotal_amount_value_to_calculate) * parseInt($('.line:eq('+i+')').find('.reduction').val())) / 100) : 0)
            ht_amount_value_to_calculate = (parseFloat(parseFloat(subtotal_amount_value_to_calculate) - parseFloat(reduction_amount_value_to_calculate)) >=0 ? parseFloat(parseFloat(subtotal_amount_value_to_calculate) - parseFloat(reduction_amount_value_to_calculate)) : 0)
            tva_amount_value_to_calculate = (parseFloat((parseFloat(ht_amount_value_to_calculate) * parseInt($('.line:eq('+i+')').find('.tva').val()) / 100)) >= 0 ? parseFloat((parseFloat(ht_amount_value_to_calculate) * parseInt($('.line:eq('+i+')').find('.tva').val()) / 100)) : 0)
            ttc_amount_value_to_calculate = (parseFloat(parseFloat(ht_amount_value_to_calculate) + parseFloat(tva_amount_value_to_calculate)) >=0 ? parseFloat(parseFloat(ht_amount_value_to_calculate) + parseFloat(tva_amount_value_to_calculate)) : 0)
            console.log(unit_price_value_to_calculate)
            reduction_amount_total += parseFloat(reduction_amount_value_to_calculate)
            tva_amount_total += parseFloat(tva_amount_value_to_calculate)
            ht_amount_total += parseFloat(ht_amount_value_to_calculate)
            ttc_amount_total += parseFloat(ttc_amount_value_to_calculate)

            
        }
   
        $(".reduction-amount-span").text(reduction_amount_total)
        $(".tva-amount-span").text(tva_amount_total)
        $(".ht-amount-span").text(ht_amount_total)
        $(".ttc-amount-span").text(ttc_amount_total)
        
        $(".reduction_total_amount").val(reduction_amount_total)
        $(".tva_total_amount").val(tva_amount_total)
        $(".ht_total_amount").val(ht_amount_total)
        $(".ttc_total_amount").val(ttc_amount_total)
    }
</script>
