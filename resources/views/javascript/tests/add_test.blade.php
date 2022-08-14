<script>

        $(document).on("click","#btn-save-new-test",function(e){
            e.preventDefault()
            let test_list = ""
            let test = $("#form-add-new-test").find('select[name="test"]').val()
            let test_name = $("#form-add-new-test").find('select[name="test"]').find(':selected').attr('data-name')
            let test_description = $("#form-add-new-test").find('select[name="test"]').find(':selected').attr('data-description')
            let description = $("#form-add-new-test").find('textarea[name="description"]').val()
            let self = $(this)
            let old_note = tinymce.get("note").getContent();
            $("#form-add-new-drug").addClass('was-validated')
            if(document.getElementById('form-add-new-test').checkValidity()){
                test_list += '<h3> + {{__("messages.test_to_do")}}</h3>'
                if(![undefined,null,''].includes(name)){
                    test_list += '<p> - <b>{{__("messages.name")}} : </b><span>'+test_name+'<span></p>'
                }
                if(![undefined,null,''].includes(test_description)){
                    test_list += '<p> - <b>{{__("messages.test")}} {{__("messages.description")}} : </b><span>'+test_description+'<span></p>'
                }
                if(![undefined,null,''].includes(description)){
                    test_list += '<p> - <b>{{__("messages.description")}} : </b><span>'+description+'<span></p>'
                }                            
            
                tinymce.get("note").setContent($.trim(old_note)+$.trim(test_list));
                $("#div-add-new-test").modal("hide")
            }
            
        })

</script>