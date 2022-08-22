<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='bank_vouchers/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Receipt/Payment/JV','') ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_cash_rp" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_cash_rp" name="rd_rpj" checked onchange="rpj_content_reflect()">
      &nbsp;&nbsp;Receipt/Payment
  </label>
  <label for="rd_cash_jv" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_cash_jv" name="rd_rpj" onchange="rpj_content_reflect()">
      &nbsp;&nbsp;Journal Entry
  </label>
</div>

<div id="div_bank_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
function rpj_content_reflect()
{ 
  var branch_status = $('#branch_status').val();
  var id = $('input[name="rd_rpj"]:checked').attr('id');
  if(id=="rd_cash_rp"){
      $.post('receipt/index.php', {branch_status : branch_status}, function(data){
        $('#div_bank_dashboard_content').html(data);
      });
  }
  if(id=="rd_cash_jv"){
      $.post('journal_entries/index.php', {branch_status : branch_status}, function(data){
        $('#div_bank_dashboard_content').html(data);
      });
  }
}
rpj_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>