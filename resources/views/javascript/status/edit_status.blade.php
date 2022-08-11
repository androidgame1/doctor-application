<script>
        $(document).on("click",".btn-edit-status",function(){
            $("#form-edit-old-status").find('input[name="name"]').val("")
            $("#form-edit-old-status").find('input[name="color"]').val("")
            let self = $(this)
            let data_url_edit = self.attr('data-url-edit')
            let data_url_update = self.attr('data-url-update')
            $.ajax({
                method:'get',
                url:data_url_edit,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.status
                    if(icon == 'success'){
                        $("#form-edit-old-status").find('input[name="name"]').val(result.name)
                        $("#form-edit-old-status").find('input[name="color"]').val(result.color)
                        $("#form-edit-old-status").attr('action',data_url_update)
                    }else{
                        console.log('There is no status')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>