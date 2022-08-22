<?php
include "../../../model/model.php";
?>
<div class="modal fade" id="location_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Location</h4>
      </div>
      <div class="modal-body">
        <form id="frm_location_save"> 
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 mg_bt_10">
              <input type="text" id="location_name" name="location_name" onchange="locationname_validate(this.id);" placeholder="*Location i.e Pune" title="Location Name" class="form-control">
            </div>
            <div class="col-sm-6 hidden">
              <select name="active_flag" id="active_flag" title="Status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>            
          </div>  
          <div class="row text-center mg_tp_30">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="location_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
            </div>
          </div>
          </form>        
      </div>      
    </div>
  </div>
</div>

<script>
$('#location_save_modal').modal('show'); 
$(function(){

$('#frm_location_save').validate({
	rules:{
		location_name:{ required:true, maxlength:200 },
		active_flag:{ required:true },
	},
	submitHandler:function(form){
		$('#location_save').button('loading');
		var base_url = $('#base_url').val();
		var location_name = $('#location_name').val();
		$.ajax({
			type:'post',
			url: base_url+'controller/branches_and_location/location_save.php',
			data: $('#frm_location_save').serialize(),
			success:function(result){
			var msg = result.split('--');				
			if(msg[0]=='error'){
				error_msg_alert(msg[1]);
				$('#location_save').button('reset');
				return false;
			}
			else{
				success_msg_alert(result);
				$('#location_save').button('reset');
				$('#location_save_modal').modal('hide');
				reset_form('frm_location_save');
				// locations_list_reflect();
			//	window.reload();
				setTimeout(function(){window.location.href = base_url+'view/branches_and_locations/index.php'}, 1200);
			}
			}
		});
	}
});
});
</script>
