<div class="modal fade" id="sms_group_save_modal"  role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New SMS Group</h4>
      </div>
      <div class="modal-body">

		<form id="frm_sms_group_save">

      	<div class="row">
      		<div class="col-md-6">
      			<input type="text" id="sms_group_name" name="sms_group_name" onchange="validate_spaces(this.id); validate_specialChar(this.id);" placeholder="*SMS Group Name" title="SMS Group Name">
      		</div>
      		<div class="col-md-6">
      			<button class="btn btn-sm btn-success" id="save_msg"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
      		</div>
      	</div>

      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
$(function(){
  $('#frm_sms_group_save').validate({
    rules:{ 
        sms_group_name : { required:true }
    },
    submitHandler:function(form){
      $('#save_msg').prop('disabled',true);
      var sms_group_name = $('#sms_group_name').val();
      var base_url = $('#base_url').val();

      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_sms/sms_group/sms_group_save.php',
        data: { sms_group_name : sms_group_name },
        success:function(result){
          var msg = result.split('--');
          if(msg[0]=="error"){
            error_msg_alert(msg[1]);
            $('#save_msg').prop('disabled',false);
            return false;
          }else{

            success_msg_alert(result);
            reset_form('frm_sms_group_save');
            $('#save_msg').prop('disabled',false);
            $('#sms_group_save_modal').modal('hide');
            sms_group_list_reflect();
          }
        }
      });

    }
  });
});
</script>