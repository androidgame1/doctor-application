<script>
        $(document).on("click",".btn-edit-type-drug",function(){
            $("#form-edit-old-type-drug").find('input[name="name"]').val("")
            $("#form-edit-old-type-drug").find('input[name="measruing_unit"]').val("")
            let self = $(this)
            let data_url_edit = self.attr('data-url-edit')
            let data_url_update = self.attr('data-url-update')
            $.ajax({
                method:'get',
                url:data_url_edit,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.type_drug
                    if(icon == 'success'){
                        $("#form-edit-old-type-drug").find('input[name="name"]').val(result.name)
                        $("#form-edit-old-type-drug").find('input[name="measruing_unit"]').val(result.measruing_unit)
                        $("#form-edit-old-type-drug").attr('action',data_url_update)
                    }else{
                        console.log('There is no type-drug')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>