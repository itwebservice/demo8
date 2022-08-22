<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id= $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Receipt/Payment</h4>
      </div>
      <div class="modal-body">
            <div class="row mg_bt_10">
              <div class="col-md-4 col-sm-6 col-xs-12">
                  <select name="receipt_type" id="receipt_type" class='form-control' title="Transaction Type">
                    <option value="Receipt">Receipt</option>
                    <option value="Payment">Payment</option>
                  </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <select name="ledger_id" id="ledger_id" title="Select Ledger" class="form-control app_select2" style="width:100%" required>
                  <option value="">*Select Ledger</option>
                  <?php
                  $sq_ledger = mysqlQuery("select ledger_id,ledger_name from ledger_master");
                    while($row_ledger = mysqli_fetch_assoc($sq_ledger)){
                  ?>
                    <option value="<?= $row_ledger['ledger_id'] ?>"><?= $row_ledger['ledger_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
						<div class="row mg_bt_10">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input type="text" id="payment_date" name="payment_date" placeholder="*Date" title="Date" value="<?= date('d-m-Y') ?>" onchange="check_valid_date(this.id)">
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');">
                  <option value="">*Mode</option>
                  <option value="Cash"> Cash </option>
                  <option value="Cheque"> Cheque </option>
                  <option value="NEFT"> NEFT </option>
                  <option value="RTGS"> RTGS </option>
                  <option value="IMPS"> IMPS </option>
                  <option value="DD"> DD </option>
                  <option value="Online"> Online </option>
                  <option value="Other"> Other </option>
								</select>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','bank_name','transaction_id','bank_id');">
							</div>
						</div>
						<div class="row mg_bt_10">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" class="bank_suggest" title="Bank Name" readonly>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" placeholder="Cheque No/ID" title="Cheque No/ID" readonly>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<select name="bank_id" id="bank_id" title="Select Bank" class='form-control' style="width:100%" disabled>
									<?php get_bank_dropdown('Select Bank'); ?>
								</select>
							</div>
						</div>
            <div class="row">
                <div class="col-md-8">
                    <textarea id="narration" name="narration" class="form-control" placeholder="*Narration" title="Narration" rows="1" required></textarea>
						    </div>
                <div class="col-md-4">
                  <div class="div-upload pull-left" id="div_upload_button">
                      <div id="payment_evidence_upload" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url" name="payment_evidence_url">
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-9">
                <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= 'Please make sure Date, Amount, Mode, Bank entered properly.' ?></span>
                </div>
            </div>

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
            </div>
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#save_modal').modal('show');
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#bank_id,#ledger_id').select2();

payment_evidence_upload();
function payment_evidence_upload(offset='')
{
    var btnUpload=$('#payment_evidence_upload'+offset);
    var status=$('#payment_evidence_status'+offset);
    new AjaxUpload(btnUpload, {
      action: 'receipt/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

        var id_proof_url = $("#payment_evidence_url"+offset).val();
        if (!(ext && /^(jpg|png|jpeg)$/.test(ext))){ 
          // extension is not allowed 
          error_msg_alert('Only JPG, JPEG, PNG files are allowed');
          return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
        } else{
          $("#payment_evidence_url"+offset).val(response);
          msg_alert('File uploaded!');
        }
      }
    });

}
$('#frm_save').validate({
  rules:{
        bank_id : { required: true },
        payment_amount : { required: true, number: true },
        payment_date : { required: true },
        payment_mode: {
          required: true
        },
        transaction_id: {
          required: function() {
            if ($('#payment_mode').val() != "Cash") {
              return true;
            } else {
              return false;
            }
          }
        },
        bank_id: {
          required: function() {
            if ($('#payment_mode').val() != "Cash") {
              return true;
            } else {
              return false;
            }
          }
        },
  },
  submitHandler:function(form){

    $('#btn_save').prop('disabled', true);
    var base_url = $('#base_url').val();

    var receipt_type = $('#receipt_type').val();
    var ledger_id = $('#ledger_id').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var payment_amount = $('#payment_amount').val();
    var bank_id = $('#bank_id').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var narration = $('#narration').val();
    var payment_evidence_url = $('#payment_evidence_url').val();
    var branch_admin_id = $('#branch_admin_id1').val();
    var emp_id = $('#emp_id').val();

    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
    if(data !== 'valid'){
      error_msg_alert("The Date does not match between selected Financial year.");
      $('#btn_save').prop('disabled', false);
      return false;
    }
    else{
        $('#btn_save').button('loading');

        $.ajax({
          type:'post',
          url:base_url+'controller/finance_master/receipt_payment/save.php',
          data: { receipt_type:receipt_type,ledger_id:ledger_id,bank_id : bank_id, bank_name:bank_name,transaction_id:transaction_id,payment_amount : payment_amount, payment_date : payment_date,payment_mode:payment_mode,payment_evidence_url : payment_evidence_url, narration:narration,branch_admin_id : branch_admin_id,emp_id : emp_id },
          success:function(result){        
            msg_alert(result);
            var msg = result.split('--');
            if(msg[0]!="error"){
              $('#save_modal').modal('hide');
              list_reflect();
            }
          }    
        });
    }
    });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>