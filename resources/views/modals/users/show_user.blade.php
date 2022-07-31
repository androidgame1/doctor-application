<!-- /.modal -->
<div class="modal fade" id="div-show-old-user" tabindex="-1" role="dialog" aria-labelledby="div-show-old-user-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-user-modal">Show @if($role=="administrator") administrator @elseif($role == "secretary") secretary @elseif($role == "deliveryman") delivery man @else error @endif</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-user" class="table browser m-0 no-border">
                <tbody>
                    <tr>
                        <td><b></b>CIN</td>
                        <td class="text-right"><span class="text-primary" name="cin"></span></td>
                    </tr>
                    <tr>
                        <td><b>Fullname</b></td>
                        <td class="text-right"><span class="text-gray" name="fullname"></span></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td class="text-right"><span class="text-gray" name="email"></span></td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td class="text-right"><span class="text-gray" name="address"></span></td>
                    </tr>
                    <tr>
                        <td><b>Phone</b></td>
                        <td class="text-right"><span class="text-gray" name="phone"></span></td>
                    </tr>
                    <tr>
                        <td><b>City</b></td>
                        <td class="text-right"><span class="text-gray" name="city"></span></td>
                    </tr>
                    <tr>
                        <td><b>Status</b></td>
                        <td class="text-right"><span class="text-gray" name="status"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center" name="edit-status" ></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->