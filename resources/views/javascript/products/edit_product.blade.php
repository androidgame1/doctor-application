<script>
        $(document).on("click",".btn-edit-product",function(){
            $("#form-edit-old-product").find('input[name="name"]').val("")
            $("#form-edit-old-product").find('input[name="amount"]').val("")
            $("#form-edit-old-product").find('textarea[name="description"]').val("")
            let self = $(this)
            let data_url_edit = self.attr('data-url-edit')
            let data_url_update = self.attr('data-url-update')
            $.ajax({
                method:'get',
                url:data_url_edit,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.product
                    if(icon == 'success'){
                        $("#form-edit-old-product").find('input[name="name"]').val(result.name)
                        $("#form-edit-old-product").find('input[name="amount"]').val(result.amount)
                        $("#form-edit-old-product").find('textarea[name="description"]').val(result.description)
                        $("#form-edit-old-product").attr('action',data_url_update)
                    }else{
                        console.log('There is no product')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>