<script>
        $(document).on("click",".btn-cancel-item",function(){
            let self = $(this)
            let data_url_cancel = self.attr('data-url-cancel')
            let data_message = self.attr('data-message')
            let data_title = self.attr('data-title')
            $("#form-cancel-old-item").find('span[name="span-title-old-item"]').text(data_title)
            $("#form-cancel-old-item").find('p[name="p-message"]').text(data_message)
            $("#form-cancel-old-item").attr('action',data_url_cancel)
            
        })
</script>