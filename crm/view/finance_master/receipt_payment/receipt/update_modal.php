<?php
include "../../../../model/model.php";
$id = $_POST['id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id= $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
$sq_rp = mysqli_fetch_assoc(mysqlQuery("select * from receipt_payment_master where id='$id'"));
$enable = ($sq_rp['payment_mode']=="Cash" || $sq_rp['payment_mode']=="Credit Note" || $sq_rp['payment_mode']=="Credit Card") ? "disabled" : "";
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<form id="rpfrm_update">
<div class="modal fade" id="rp_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Receipt/Payment</h4>
      </div>
      <div class="modal-body">
            <input type="hidden" id="entry_id" value="<?=$id?>"/>
            <input type="hidden" id="old_amount" value="<?=$sq_rp['payment_amount']?>"/>
            <input type="hidden" id="old_mode" value="<?=$sq_rp['payment_mode']?>"/>
            <div class="row mg_bt_10">
              <div class="col-md-4 col-sm-6 col-xs-12">
                  <select name="receipt_type" id="receipt_type" class='form-control' title="Transaction Type" disabled>
                    <option value="<?=$sq_rp['receipt_type']?>"><?= $sq_rp['receipt_type'] ?></option>
                    <option value="Receipt">Receipt</option>
                    <option value="Payment">Payment</option>
                  </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <select name="ledger_id" id="ledger_id" title="Select Ledger" class="form-control app_select2" style="width:100%" disabled>
                <?php $sq_ledger = mysqli_fetch_assoc(mysqlQuery("select ledger_id,ledger_name from ledger_master where ledger_id='$sq_rp[ledger_id]'")); ?>
                  <option value="<?=$sq_ledger['ledger_id']?>"><?= $sq_ledger['ledger_name'] ?></option>
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
								<input type="text" id="payment_date" name="payment_date" placeholder="*Date" title="Date" value="<?= get_date_user($sq_rp['payment_date']) ?>" onchange="check_valid_date(this.id)" readonly>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');" disabled>
                  <option value="<?=$sq_rp['payment_mode']?>"><?= $sq_rp['payment_mode'] ?></option> 
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
								<input type="text" id="payment_amount1" name="payment_amount1" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','bank_name','transaction_id','bank_id');" value="<?= $sq_rp['payment_amount'] ?>">
							</div>
						</div>
						<div class="row mg_bt_10">
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" class="bank_suggest" title="Bank Name" value="<?= $sq_rp['bank_name'] ?>" <?=$enable?>>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_rp['transaction_id'] ?>" <?=$enable?>>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<select name="bank_id" id="bank_id1" title="Select Bank" class='form-control' style="width:100%" <?=$enable?> disabled>
                  <?php
                  if($sq_rp['bank_id'] != '0'){
                    $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from bank_master where bank_id='$sq_rp[bank_id]'"));  
                    ?>
                    <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                    <?php
                  }
                  ?>
                  <?php
                  get_bank_dropdown('Select Bank');
                  ?>
								</select>
							</div>
						</div>
            <div class="row">
                <div class="col-md-8">
                    <textarea id="narration" name="narration" class="form-control" placeholder="*Narration" title="Narration" rows="1" required><?= $sq_rp['narration'] ?></textarea>
						    </div>
                <div class="col-md-4">
                  <div class="div-upload pull-left" id="div_upload_button">
                      <div id="payment_evidence_upload1" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" value="<?=$sq_rp['url']?>" id="payment_evidence_url1" name="payment_evidence_url">
                  </div>
                </div>
            </div>

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
              </div>
            </div>
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#rp_update_modal').modal('show');
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#bank_id,#ledger_id').select2();

payment_evidence_upload1('1');
function payment_evidence_upload1(offset='')
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
$('#rpfrm_update').validate({
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

    $('#btn_update').prop('disabled', true);
    var base_url = $('#base_url').val();

    var receipt_type = $('#receipt_type').val();
    var ledger_id = $('#ledger_id').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var payment_amount = $('#payment_amount1').val();
    var bank_id = $('#bank_id1').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var narration = $('#narration').val();
    var payment_evidence_url = $('#payment_evidence_url1').val();
    var entry_id = $('#entry_id').val();
    var old_amount = $('#old_amount').val();
    var old_mode = $('#old_mode').val();
    if(parseFloat(payment_amount) != parseFloat(old_amount)){
      if(parseFloat(payment_amount) != 0){
        error_msg_alert("Can not update payment amount else make it 0");
        $('#btn_update').prop('disabled', false);
        return false;
      }
    }

    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
    if(data !== 'valid'){
      error_msg_alert("The Date does not match between selected Financial year.");
      $('#btn_update').prop('disabled', false);
      return false;
    }
    else{
        $('#btn_update').button('loading');

        $.ajax({
          type:'post',
          url:base_url+'controller/finance_master/receipt_payment/update.php',
          data: { receipt_type:receipt_type,ledger_id:ledger_id,bank_id : bank_id, bank_name:bank_name,transaction_id:transaction_id,payment_amount : payment_amount, payment_date : payment_date,payment_mode:payment_mode,payment_evidence_url : payment_evidence_url, narration:narration,entry_id : entry_id,old_amount:old_amount ,old_mode:old_mode},
          success:function(result){        
            msg_alert(result);
            var msg = result.split('--');
            if(msg[0]!="error"){
              $('#rp_update_modal').modal('hide');
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