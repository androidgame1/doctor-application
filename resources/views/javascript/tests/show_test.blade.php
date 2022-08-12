<script>
        $(document).on("click",".btn-show-test",function(){
            $("#table-show-old-test").find('span[name="name"]').text("")
            $("#table-show-old-test").find('span[name="description"]').text("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon    
                    let result = data.tests
                    if(icon == 'success'){
                        $("#table-show-old-test").find('span[name="name"]').text(result.name)
                        $("#table-show-old-test").find('span[name="description"]').text(result.description)
                    }else{
                        console.log('There is no test')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>