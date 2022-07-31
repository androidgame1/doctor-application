<script>
        $(document).on("click",".btn-edit-user",function(){
            $("#form-edit-old-user").find('input[name="cin"]').val("")
            $("#form-edit-old-user").find('input[name="fullname"]').val("")
            $("#form-edit-old-user").find('input[name="email"]').val("")
            $("#form-edit-old-user").find('input[name="address"]').val("")
            $("#form-edit-old-user").find('input[name="phone"]').val("")
            $("#form-edit-old-user").find('input[name="city"]').val("")
            let self = $(this)
            let data_url_edit = self.attr('data-url-edit')
            let data_url_update = self.attr('data-url-update')
            $.ajax({
                method:'get',
                url:data_url_edit,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.user
                    if(icon == 'success'){
                        $("#form-edit-old-user").find('input[name="cin"]').val(result.cin)
                        $("#form-edit-old-user").find('input[name="fullname"]').val(result.fullname)
                        $("#form-edit-old-user").find('input[name="email"]').val(result.email)
                        $("#form-edit-old-user").find('input[name="address"]').val(result.address)
                        $("#form-edit-old-user").find('input[name="phone"]').val(result.phone)
                        $("#form-edit-old-user").find('input[name="city"]').val(result.city)
                        $("#form-edit-old-user").attr('action',data_url_update)
                    }else{
                        console.log('There is no user')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>