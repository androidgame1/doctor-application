<script>
        $(document).on("click",".btn-edit-drug",function(){
            $("#form-edit-old-drug").find('input[name="trade_name"]').val("")
            $("#form-edit-old-drug").find('input[name="generic_name"]').val("")
            let self = $(this)
            let data_url_edit = self.attr('data-url-edit')
            let data_url_update = self.attr('data-url-update')
            $.ajax({
                method:'get',
                url:data_url_edit,
                data:{},
                success:function(data){
                    console.log(data)
                    let icon = data.icon
                    let result = data.drugs
                    if(icon == 'success'){
                        $("#form-edit-old-drug").find('input[name="trade_name"]').val(result.trade_name)
                        $("#form-edit-old-drug").find('input[name="generic_name"]').val(result.generic_name)
                        $("#form-edit-old-drug").attr('action',data_url_update)
                    }else{
                        console.log('There is no drug')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>