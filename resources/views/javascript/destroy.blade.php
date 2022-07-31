<script>
        $(document).on("click",".btn-destroy-item",function(){
            let self = $(this)
            let data_url_destroy = self.attr('data-url-destroy')
            let data_message = self.attr('data-message')
            let data_title = self.attr('data-title')
            $("#form-destroy-old-item").find('span[name="span-title-old-item"]').text(data_title)
            $("#form-destroy-old-item").find('p[name="p-message"]').text(data_message)
            $("#form-destroy-old-item").attr('action',data_url_destroy)
            
        })
</script>