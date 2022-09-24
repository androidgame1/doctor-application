<script>
        $(document).on("click",".btn-show-charge",function(){
            $("#table-show-old-charge").find('span[name="name"]').text("")
            $("#table-show-old-charge").find('span[name="amount"]').text("")
            $("#table-show-old-charge").find('span[name="description"]').text("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.charge
                    if(icon == 'success'){
                        $("#table-show-old-charge").find('span[name="name"]').text(result.name)
                        $("#table-show-old-charge").find('span[name="amount"]').text(result.amount)
                        $("#table-show-old-charge").find('span[name="description"]').text(result.description)
                    }else{
                        console.log('There is no patient')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>