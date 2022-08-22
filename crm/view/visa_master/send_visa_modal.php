<?php
include "../../model/model.php";
$entry_id = $_POST['entry_id'];
?>
<div class="modal fade" id="visa_send_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Visa Information</h4>
      </div>
      <div class="modal-body">
        <form id="frm_visa_send">
          <input type="hidden" value="<?= $entry_id ?>" id="entry_id" name="entry_id">
          <div class="row mg_bt_10">
            <div class="col-md-12 col-sm-12">
            <span><input type="checkbox" id="mail" name="mail">&nbsp;&nbsp;Enter Multiple Email Id's with comma!</span>
            </div>
          </div>
          <div class="row mg_bt_20">
              <div class="col-md-12 col-sm-12 mg_bt_10">
                  <input type="text" name="email_id"  class="form-control" title="Email ID" placeholder="Email ID" id="email_id" data-role="tagsinput" onchange="validate_email(this.id)">
              </div>
          </div>
          <div class="row mg_bt_10">
            <div class="col-md-12 col-sm-12">
            <span><input type="checkbox" id="whatsapp" name="whatsapp">&nbsp;&nbsp;Select checkbox to send on whatsapp!</span>
            </div>
          </div>
          <div class="row mg_bt_30">
            <div class="col-sm-4 col-xs-12">
              <select name="country_code" id="country_code" style="width:100%;" class="form-control">
                <?= get_country_code() ?>
              </select>
            </div>
            <div class="col-sm-8 col-xs-12">
              <input type="number" id="cust_contact_no" name="cust_contact_no" maxlength="15" onchange="mobile_validate(this.id)" placeholder="Mobile No" title="Mobile No">
            </div>
          </div>
          <div class="row text-center">
              <div class="col-md-12">
                <button class="btn btn-sm btn-success" id="btn_visa_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>  
              </div>
            </div>
        </form>
      </div>
</div>
</div>
</div>
</div>

<script>
$('#visa_send_modal').modal('show');
$("#email_id").tagsinput('items');
$('#country_code').select2();
$(function(){
  $('#frm_visa_send').validate({
    submitHandler:function(form){

			$('#btn_visa_send').prop('disabled', true);
      var base_url = $('#base_url').val();
      var entry_id = $('#entry_id').val();
      var mail = document.getElementById('mail').checked;
      var email_id = $('#email_id').val();
      var whatsapp = document.getElementById('whatsapp').checked;
      var country_code = $('#country_code').val();
      var contact_no = $('#cust_contact_no').val();
      if(mail == true && email_id == ''){
        error_msg_alert("Enter email id!");
			  $('#btn_visa_send').prop('disabled', false);
        $('#btn_visa_send').button('reset'); 
        return false;
      }
      if(whatsapp == true && country_code == ''){
        error_msg_alert("Select country code!");
			  $('#btn_visa_send').prop('disabled', false);
        $('#btn_visa_send').button('reset'); 
        return false;
      }
      if(whatsapp == true && contact_no == ''){
        error_msg_alert("Enter mobile no!");
			  $('#btn_visa_send').prop('disabled', false);
        $('#btn_visa_send').button('reset'); 
        return false;
      }
      if(mail == false && whatsapp == false){
        error_msg_alert("Send information on mail or on whatsapp atleast!");
			  $('#btn_visa_send').prop('disabled', false);
        $('#btn_visa_send').button('reset'); 
        return false;
      }
      if(mail == true){

        $('#btn_visa_send').button('loading');
        $.ajax({
          type:'post',
          url: base_url+'controller/visa_master/visa_email_send.php',
          data:{ entry_id : entry_id, email_id : email_id},
          success: function(message){
            msg_alert(message);
            $('#btn_visa_send').button('reset'); 
            $('#btn_visa_send').prop('disabled', false);
            $('#visa_send_modal').modal('hide');
          }  
        });
      }
      if(whatsapp == true){
        $('#btn_visa_send').button('loading');
        whatsapp_send(country_code+contact_no,entry_id,'visa_send_modal');
        $('#btn_visa_send').button('reset');
			  $('#btn_visa_send').prop('disabled', false); 
      }
    }
  });
});
function whatsapp_send(contact_no,entry_id,visa_send_modal){
  
  var base_url = $('#base_url').val();
	$.post(base_url+'controller/visa_master/visa_whatsapp.php',{contact_no:contact_no,entry_id:entry_id}, function(data){
    $('#'+visa_send_modal).modal('hide');
		window.open(data);
	});
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
