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

</script>
