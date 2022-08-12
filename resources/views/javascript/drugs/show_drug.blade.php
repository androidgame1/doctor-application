<script>
        $(document).on("click",".btn-show-drug",function(){
            $("#table-show-old-drug").find('span[name="trade_name"]').text("")
            $("#table-show-old-drug").find('span[name="generic_name"]').text("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon    
                    let result = data.drug
                    if(icon == 'success'){
                        $("#table-show-old-drug").find('span[name="trade_name"]').text(result.trade_name)
                        $("#table-show-old-drug").find('span[name="generic_name"]').text(result.generic_name)
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