<script>
        $(document).on("click",".btn-show-status",function(){
            $("#table-show-old-status").find('span[name="name"]').text("")
            $("#table-show-old-status").find('span[name="color"]').text("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon    
                    let result = data.status
                    if(icon == 'success'){
                        $("#table-show-old-status").find('span[name="name"]').text(result.name)
                        $("#table-show-old-status").find('span[name="color"]').text(result.color)
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