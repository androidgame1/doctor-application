<script>
        $(document).on("click",".btn-show-delivery-order",function(){
            $("#table-show-old-delivery-order").find('span[name="series"]').text("")
            $("#table-show-old-delivery-order").find('span[name="supplier"]').text("")
            $("#table-show-old-delivery-order").find('span[name="remark"]').text("")
            $("#table-show-old-delivery-order").find('span[name="date"]').text("")
            $("#table-show-old-delivery-order").find('div[name="file"]').html("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    console.log(data)
                    let icon = data.icon
                    let result = data.delivery_order
                    if(icon == 'success'){
                        $("#table-show-old-delivery-order").find('span[name="series"]').text(result.series)
                        $("#table-show-old-delivery-order").find('span[name="supplier"]').text(result.supplier.fullname)
                        $("#table-show-old-delivery-order").find('span[name="remark"]').text(result.remark)
                        $("#table-show-old-delivery-order").find('span[name="date"]').text(moment(result.date).format('DD/MM/YYYY'))
                        if(result.file){
                            $("#table-show-old-delivery-order").find('div[name="file"]').html(`<a href="{{asset('/')}}`+result.file+`" target="_blank" class="btn btn-primary"><i class="fa fa-eye"></i></a>`)
                        }
                        
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