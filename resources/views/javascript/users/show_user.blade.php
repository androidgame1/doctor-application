<script>
        $(document).on("click",".btn-show-user",function(){
            $("#table-show-old-user").find('span[name="cin"]').text("")
            $("#table-show-old-user").find('span[name="fullname"]').text("")
            $("#table-show-old-user").find('span[name="email"]').text("")
            $("#table-show-old-user").find('span[name="address"]').text("")
            $("#table-show-old-user").find('span[name="phone"]').text("")
            $("#table-show-old-user").find('span[name="city"]').text("")
            $("#table-show-old-user").find('span[name="status"]').html("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.user
                    if(icon == 'success'){
                        $("#table-show-old-user").find('span[name="cin"]').text(result.cin)
                        $("#table-show-old-user").find('span[name="fullname"]').text(result.fullname)
                        $("#table-show-old-user").find('span[name="email"]').text(result.email)
                        $("#table-show-old-user").find('span[name="address"]').text(result.address)
                        $("#table-show-old-user").find('span[name="phone"]').text(result.phone)
                        $("#table-show-old-user").find('span[name="city"]').text(result.city)
                        $("#table-show-old-user").find('span[name="status"]').html(result.status)
                        $("#table-show-old-user").find('td[name="edit-status"]').html(`<a href="@if(auth()->user()->is_administrator){{route('administrator.user.status.update',['role'=>'deliveryman','id'=>111])}}@else javascript:void(0) @endif" class="btn 222">333</a>`.replace('111',result.id).replace('222',result.editstatus.class).replace('333',result.editstatus.value))
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