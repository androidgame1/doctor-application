<script>
        $(document).on("click",".btn-show-patient",function(){
            $("#table-show-old-patient").find('span[name="cin"]').text("")
            $("#table-show-old-patient").find('span[name="fullname"]').text("")
            $("#table-show-old-patient").find('span[name="email"]').text("")
            $("#table-show-old-patient").find('span[name="address"]').text("")
            $("#table-show-old-patient").find('span[name="phone"]').text("")
            $("#table-show-old-patient").find('span[name="city"]').text("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.patient
                    if(icon == 'success'){
                        $("#table-show-old-patient").find('span[name="cin"]').text(result.cin)
                        $("#table-show-old-patient").find('span[name="fullname"]').text(result.fullname)
                        $("#table-show-old-patient").find('span[name="email"]').text(result.email)
                        $("#table-show-old-patient").find('span[name="address"]').text(result.address)
                        $("#table-show-old-patient").find('span[name="phone"]').text(result.phone)
                        $("#table-show-old-patient").find('span[name="city"]').text(result.city)
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