<?php
include_once('../../../model/model.php');
?>
<form id="frm_type_save" class="servingTime">
<div class="modal fade" id="bike_type_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bike Type</h4>
      </div>
      <div class="modal-body">
        
        <div class='row'>
            <div class="col-md-12 col-sm-3 text-center"> 
              <input type="text" class="form-control" id="cbike_type" name="cbike_type" placeholder="*Enter Bike Type" title="Bike Type" onkeypress="return blockSpecialChar(event);"/>
            </div>
        </div>
        <div class="row text-center mg_tp_30">
            <div class="col-md-12 text-center">
              <button class="btn btn-sm btn-success" id="csave_bike_type"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>   
            </div>
        </div>

      </div>      
    </div>
  </div>
</div>
</form>
<script>
$('#bike_type_modal').modal('show');
//**Site Tooltips
$(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});
$(function () {
	$('#frm_type_save').validate({
		rules         : {},
		submitHandler : function (form) {
			
		$('#save').prop('disabled', true);
		$('#csave_bike_type').prop('disabled', true);
		var base_url = $('#base_url').val();
		var bike_type = $('#cbike_type').val();
		if (bike_type == '') {
			error_msg_alert('Please enter bike type');
			$('#csave_bike_type').prop('disabled', false);
			return false;
		}
		$('#csave_bike_type').button('loading');
		$.ajax({
			type    : 'post',
			url     : base_url + 'controller/rent_bike/bike_type_save.php',
			data    : { bike_type: bike_type },
			success : function (result) {
			var msg = result.split('--');
			if (msg[0] == 'error') {
				error_msg_alert(msg[1]);
				$('#csave_bike_type').button('reset');
				$('#csave_bike_type').prop('disabled', false);
				return false;
			}
			else {
				msg_alert(result);
				location.reload();
				update_b2c_cache();
				reset_form('frm_type_save');
				$('#csave_bike_type').button('reset');
				$('#csave_bike_type').prop('disabled', false);
				$('#bike_type_modal').modal('hide');
			}
			}
		});
		}
	});
});
</script>
