<script>
        $(document).on("click",".btn-edit-appointment",function(){
            $("#form-edit-old-appointment").find('select[name="patient_id"]').val("")
            $("#form-edit-old-appointment").find('input[name="start_date"]').val("")
            $("#form-edit-old-appointment").find('input[name="end_date"]').val("")
            $("#form-edit-old-appointment").find('select[name="status_id"]').val("")
            $("#form-edit-old-appointment").find('textarea[name="remark"]').val("")
            let self = $(this)
            let data_url_edit = self.attr('data-url-edit')
            let data_url_update = self.attr('data-url-update')
            console.log(data_url_update)
            $.ajax({
                method:'get',
                url:data_url_edit,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.appointment
                    if(icon == 'success'){
                        $("#form-edit-old-appointment").find('select[name="patient_id"]').val(result.patient.id)
                        $("#form-edit-old-appointment").find('input[name="start_date"]').val(result.start_date)
                        $("#form-edit-old-appointment").find('input[name="end_date"]').val(result.end_date)
                        $("#form-edit-old-appointment").find('select[name="status_id"]').val(result.status_id)
                        $("#form-edit-old-appointment").find('textarea[name="remark"]').val(result.remark)
                        $("#form-edit-old-appointment").attr('action',data_url_update)
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