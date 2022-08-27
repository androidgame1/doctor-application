<script>
        $(document).on("click",".btn-show-purchase-invoice-payment",function(){
            $("#table-show-old-purchase-invoice-payment").find('span[name="purchase_invoice"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('span[name="ttc_amount"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('span[name="given_amount"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('span[name="remaining_amount"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('span[name="way_of_payment"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('span[name="remark"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('span[name="date"]').text("")
            $("#table-show-old-purchase-invoice-payment").find('div[name="justification"]').html("")
            let self = $(this)
            let data_url_show = self.attr('data-url-show')
            $.ajax({
                method:'get',
                url:data_url_show,
                data:{},
                success:function(data){
                    let icon = data.icon
                    let result = data.purchase_invoice_payment
                    if(icon == 'success'){
                        $("#table-show-old-purchase-invoice-payment").find('span[name="purchase_invoice"]').text(result.purchase_invoice.series)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="ttc_amount"]').text(result.purchase_invoice.ttc_total_amount)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="given_amount"]').text(result.given_amount)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="remaining_amount"]').text(result.remaining_amount)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="remaining_amount"]').text(result.remaining_amount)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="way_of_payment"]').text(result.way_of_payment)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="remark"]').text(result.remark)
                        $("#table-show-old-purchase-invoice-payment").find('span[name="date"]').text(moment(result.date).format('DD/MM/YYYY'))
                        if(result.justification){
                            $("#table-show-old-purchase-invoice-payment").find('div[name="justification"]').html(`<a href="{{asset('/')}}`+result.justification+`" target="_blank" class="btn btn-primary"><i class="fa fa-eye"></i></a>`)
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