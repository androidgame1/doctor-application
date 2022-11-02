<!-- /.modal -->
<div class="modal fade" id="div-show-old-appointment" tabindex="-1" role="dialog" aria-labelledby="div-show-old-appointment-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-appointment-modal">{{__('messages.show_appointment')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-appointment" class="table browser m-0 no-border">
                <tbody>
                    <tr class="tr-show">
                        <td><b>{{__('messages.patient')}}</b></td>
                        <td class="text-right"><span class="text-primary" name="patient"></span></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.start_date')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="start_date"></span></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.end_date')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="end_date"></span></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.status')}}</b></td>
                        <td class="text-right" name="status"></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.remark')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="remark"></span></td>
                    </tr>
                    @if(auth()->user()->is_administrator)
                        <tr class="tr-show">
                            <td colspan="2">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-appointments-target">{{__('messages.appointments')}}</a>
                                <a href="javascript:void(0)" class="btn btn-success btn-quotes-target">{{__('messages.quotes')}}</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-activities-target">{{__('messages.activities')}}</a>
                                <a href="javascript:void(0)" class="btn btn-warning btn-sale-invoices-target">{{__('messages.sale_invoices')}}</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->