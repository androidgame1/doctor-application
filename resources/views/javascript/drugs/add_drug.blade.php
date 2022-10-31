<script>
        $("#select-type-of-drug").on('change',function(){
            let measruing_unit = $(this).find(':selected').attr('data-measruing-unit')
            $("#form-add-new-drug").find("label[data-field='quantity']").find('span[name="quantity"]').text(!["",undefined,null].includes(measruing_unit) ? '('+measruing_unit+')' : '')
        })

        $(document).on("click","#btn-save-new-drug",function(e){
            e.preventDefault()
            let drug_list = ""
            let type = $("#form-add-new-drug").find('select[name="type"]').val()
            let type_name = $("#form-add-new-drug").find('select[name="type"]').find(':selected').attr('data-name')
            let type_measruing_unit = $("#form-add-new-drug").find('select[name="type"]').find(':selected').attr('data-measruing-unit')
            let drug = $("#form-add-new-drug").find('select[name="drug"]').val()
            let drug_trade_name = $("#form-add-new-drug").find('select[name="drug"]').find(':selected').attr('data-trade-name')
            let drug_generic_name = $("#form-add-new-drug").find('select[name="drug"]').find(':selected').attr('data-generic-name')
            let drug_description = $("#form-add-new-drug").find('select[name="drug"]').find(':selected').attr('data-description')
            let quantity = $("#form-add-new-drug").find('input[name="quantity"]').val()
            let dose = $("#form-add-new-drug").find('input[name="dose"]').val()
            let duration = $("#form-add-new-drug").find('input[name="duration"]').val()
            let description = $("#form-add-new-drug").find('textarea[name="description"]').val()
            let self = $(this)
            let old_node = tinymce.get("note").getContent();
            $("#form-add-new-drug").addClass('was-validated')
            if(document.getElementById('form-add-new-drug').checkValidity()){
                if(![undefined,null,''].includes(drug_trade_name) && ![undefined,null,''].includes(drug_generic_name)){
                    drug_list += '<h3> + {{__("messages.drug")}} (<span>'+drug_trade_name+'/'+drug_generic_name+'<span>)</h3>'
                }
                if(![undefined,null,''].includes(type_name)){
                    drug_list += '<p> - <b>{{__("messages.type")}} : </b><span>'+type_name+'<span></p>'
                }
                if(![undefined,null,''].includes(drug_description)){
                    drug_list += '<p> - <b>{{__("messages.drug")}} {{__("messages.description")}} : </b><span>'+drug_description+'<span></p>'
                }
                if(![undefined,null,''].includes(quantity) && ![undefined,null,''].includes(type_measruing_unit)){
                    drug_list += '<p> - <b>{{__("messages.quantity")}} : </b><span>'+quantity+'</span> <b>'+type_measruing_unit+'</b><span></p>'
                }
                if(![undefined,null,''].includes(dose)){
                    drug_list += '<p> - <b>{{__("messages.dose")}} : </b><span>'+dose+'<span></p>'
                }
                if(![undefined,null,''].includes(duration)){
                    drug_list += '<p> - <b>{{__("messages.duration")}} : </b><span>'+duration+(parseInt(duration)>1 ? ' <b>{{__("messages.days")}}</b>' : ' <b>{{__("messages.day")}}</b>') +'<span></p>'
                }
                if(![undefined,null,''].includes(description)){
                    drug_list += '<p> - <b>{{__("messages.description")}} : </b><span>'+description+'<span></p>'
                }
                            
            
                tinymce.get("note").setContent($.trim(old_node)+$.trim(drug_list));
                $("#div-add-new-drug").modal("hide")
            }
            
        })

</script>