<?php 
include_once('../../../model/model.php');
$enquiry_id = $_POST['enquiry_id'];
?>
<form id="frm_followup_reply">
<div class="modal fade" id="followup_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Followup Update</h4>
      </div>
      <div class="modal-body">
      <input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>" />
		<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <select name="followup_status" id="followup_status" title="Followup Status" class="form-control" onchange="followup_type_reflect(this.value)">
            <option value="">*Status</option>
            <option value="Active">Active</option>
						<option value="In-Followup">In-Followup</option>
            <option value="Dropped">Dropped</option>
            <option value="Converted">Converted</option>
          </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <select id="followup_type" name="followup_type" title="Followup Type" class="form-control">
              <option value="">*Type</option>
          </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="followup_date" name="followup_date" placeholder="Next Followup Date" title="Next Followup Date" value="<?= date('d-m-Y H:i')?>" style="min-width:136px;" class="form-control">
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
              <select name="followup_stage" id="followup_stage" title="Enquiry Type" class="form-control">
                <option value="">Stage</option>
                <option value="<?= "Strong" ?>">Strong</option>
                <option value="<?= "Hot" ?>">Hot</option>
                <option value="<?= "Cold" ?>">Cold</option>
              </select>
        </div>
        
	</div>
	  <div class="row mg_bt_10">
      <div class="col-md-9">
        <textarea id="followup_reply" name="followup_reply" onchange="validate_spaces(this.id);" placeholder="*Followup Description" class="form-control"></textarea>
      </div>		
      <div class="col-md-3 col-sm-6 mg_bt_10">
          <select name="cust_state" id="cust_state" title="Select State" style="width : 100%" class="form-control">
            <?php get_states_dropdown() ?>
          </select>
      </div>
	  </div>
	<div class="row text-center mg_bt_20">
		<div class="col-md-12">
			<button class="btn btn-sm btn-success" id="btn_followup_reply"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
		</div>
	</div>
	 </div>
    </div>
  </div>
</div>
    </form>
 
<script>
	$('#followup_date').datetimepicker({ format:'d-m-Y H:i' });
	$(function(){
  	$('#frm_followup_reply').validate({
    rules:{
      followup_reply: "required",
      followup_date:"required",
      followup_type: "required",
      followup_status: "required",
    },
    submitHandler:function(form){
      
      $('#btn_followup_reply').prop('disabled', true);
      var enquiry_id = $("#enquiry_id").val(); 
      var followup_reply = $("#followup_reply").val(); 
      var followup_date = $('#followup_date').val();
      var followup_type = $('#followup_type').val();
      var followup_status = $('#followup_status').val();
      var followup_stage = $('#followup_stage').val();
      var cust_state = $('#cust_state').val();

      // if(followup_status=='Converted'){
      //   if(cust_state=='' || cust_state==undefined){
      //     error_msg_alert("Please select state");
      //           return false;
      //   }
      // }
      var base_url = $('#base_url').val();
      $('#btn_followup_reply').button('loading');
      // $.post( 
      //   base_url+"controller/attractions_offers_enquiry/followup_reply_save.php",
      //   { enquiry_id : enquiry_id, followup_reply : followup_reply, followup_date : followup_date, followup_type : followup_type, followup_status : followup_status, followup_stage : followup_stage },
      //   function(data) {  
      //     msg_alert(data);
      //     $('#followup_save_modal').modal('hide');
      //     followup_reflect();
      // });
      if(followup_status=='Converted'){
        if(cust_state=='' || cust_state==undefined){
          error_msg_alert("Please select state");
          $('#btn_followup_reply').prop('disabled', false);
          return false;
        }
        $.ajax({
          type: 'post',
          url: base_url+'view/attractions_offers_enquiry/enquiry/followup/followup/enquiry_info_load.php',
          data: { enquiry_id: enquiry_id },
          success: function (result) {
            var response = JSON.parse(result);
            
            var first_name = response.first_name;
            var middle_name = response.middle_name;
            var last_name = response.last_name;
            var gender = response.gender;
            var birth_date = response.birth_date;
              var age = response.age;
              var contact_no = response.landline_no;
            var email_id = response.email_id;
            var address = response.address;
            var address2 = response.address2;
            var city = response.city;
            var active_flag = response.active_flag;
            var service_tax_no = response.service_tax_no;
            var landline_no = response.contact_no;
            var alt_email_id = response.alt_email_id;
            var company_name = response.company_name;
            var cust_type = response.type;
            var state = cust_state;
            var branch_admin_id = response.branch_admin_id;
            var country_code = response.country_code;
            $('#btn_followup_reply').button('loading');
            $.ajax({
            type: 'post',
            url: base_url + 'controller/customer_master/customer_save.php',
            data: {
              first_name: first_name, middle_name: middle_name,
              last_name: last_name, gender: gender, birth_date: birth_date,age: age, contact_no: contact_no,email_id: email_id,address: address,address2: address2,city: city, active_flag: active_flag, service_tax_no: service_tax_no,landline_no: landline_no,alt_email_id: alt_email_id, company_name: company_name,cust_type: cust_type, state: state, branch_admin_id: branch_admin_id,country_code: country_code
            },
            success: function(result) {
              $.post( 
              base_url+"controller/attractions_offers_enquiry/followup_reply_save.php",
              { enquiry_id : enquiry_id, followup_reply : followup_reply, followup_date : followup_date, followup_type : followup_type, followup_status : followup_status, followup_stage : followup_stage ,cust_state:cust_state},
              function(data) {  
                  msg_alert(data);
                  $('#followup_save_modal').modal('hide');
                  followup_reflect();
                });
            }
            });
          }
        });
      }else{
        $.post( 
                  base_url+"controller/attractions_offers_enquiry/followup_reply_save.php",
                  { enquiry_id : enquiry_id, followup_reply : followup_reply, followup_date : followup_date, followup_type : followup_type, followup_status : followup_status, followup_stage : followup_stage ,cust_state:cust_state},
                  function(data) {  
                    msg_alert(data);
                    $('#followup_save_modal').modal('hide');
                    followup_reflect();
                });
      }
    }
  });
});
</script>
<script type="text/javascript">
$('#followup_save_modal').modal('show');
</script>