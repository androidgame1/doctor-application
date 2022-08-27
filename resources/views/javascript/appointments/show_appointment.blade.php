<script>
        $(document).on("click",".btn-show-appointment",function(){
            $("#table-show-old-appointment").find('span[name="patient"]').text("")
            $("#table-show-old-appointment").find('span[name="remark"]').text("")
            $("#table-show-old-appointment").find('td[name="status"]').html("")
            $("#table-show-old-appointment").find('span[name="start_date"]').text("")
            $("#table-show-old-appointment").find('span[name="end_date"]').text("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    
                    let icon = data.icon
                    let result = data.appointment
                    console.log(result)
                    if(icon == 'success'){
                        $("#table-show-old-appointment").find('span[name="patient"]').text(result.patient.fullname)
                        $("#table-show-old-appointment").find('span[name="remark"]').text(result.remark)
                        $("#table-show-old-appointment").find('td[name="status"]').html(result.status_state)
                        $("#table-show-old-appointment").find('span[name="start_date"]').text(moment(result.start_date).format('DD/MM/YYYY H:mm:ss'))
                        $("#table-show-old-appointment").find('span[name="end_date"]').text(moment(result.end_date).format('DD/MM/YYYY H:mm:ss'))
                    }else{
                        console.log('There is no appointment')
                    }
                },error: function(xhr, ajaxOptions, thrownError) {
                  console.log(xhr)
                  console.log(ajaxOptions)
                  console.log(thrownError)
                }
            })
        })
</script>