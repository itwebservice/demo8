<?php
include "../../model/model.php";
$vehicle_id = $_POST['vehicle_id'];
$sq_vehicle = mysqli_fetch_assoc(mysqlQuery("SELECT cancellation_policy FROM `b2b_transfer_master` where entry_id='$vehicle_id'"));
?>
<div class="modal fade" id="display_cancellation_modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cancellation Policy</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="custom_texteditor">
                    <?php echo $sq_vehicle['cancellation_policy']; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#display_cancellation_modal').modal('show');
</script>