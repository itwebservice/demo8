<?php 
include "../../../../../model/model.php";
$bank_id = $_POST['bank_id'];
$branch_admin_id = $_POST['branch_admin_id'];

//Getting system bank amount
$debit = 0; $credit = 0;
$sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
$debit = ($sq_bank['dr_cr']=='Dr') ? $sq_bank['balance'] : '0';
$credit = ($sq_bank['dr_cr']=='Cr') ? $sq_bank['balance'] : '0';

$c_query = "select sum(payment_amount) as sum from finance_transaction_master where payment_side='Credit' and gl_id='$sq_bank[ledger_id]' ";
if($branch_admin_id != '0'){
  $c_query .= " and branch_admin_id='$branch_admin_id'";
}

$sq_trans_credit = mysqli_fetch_assoc(mysqlQuery($c_query));
$credit += ($sq_trans_credit['sum']=="") ? 0 : $sq_trans_credit['sum'];

$d_query = "select sum(payment_amount) as sum from finance_transaction_master where payment_side='Debit' and gl_id='$sq_bank[ledger_id]'";
if($branch_admin_id != '0'){
  $d_query .= " and branch_admin_id='$branch_admin_id'";
}

$sq_trans_debit = mysqli_fetch_assoc(mysqlQuery($d_query));
$debit += ($sq_trans_debit['sum']=="") ? 0 : $sq_trans_debit['sum'];      

if($debit>$credit){
  $balance =  $debit - $credit;
}
else{
  $balance =  $credit - $debit; 
}
$balance = ($bank_id == 0) ? 0 : $balance;
?>
<div class="row mg_bt_20">
  <div class="col-md-3 col-sm-6">
    <span class="main_block">
      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
      <label>Balance as per bank book : </label> </span>
  </div>
  <div class="col-md-3 col-sm-6">
    <input type="text" id="txt_system_bank" name="txt_system_bank" style="font-weight: bold;" title="Balance as per Books" value="<?= $balance ?>" class="form-control" readonly>
  </div>
</div>
<?php
$count_query1 = "SELECT * FROM `finance_transaction_master` WHERE `gl_id` = '$sq_bank[ledger_id]' AND `clearance_status` LIKE 'Pending' AND `row_specification` LIKE 'sales'";
if($branch_admin_id != '0'){
  $count_query1 .= " and branch_admin_id='$branch_admin_id'";
}
$count1 = mysqli_num_rows(mysqlQuery($count_query1));
/////////////////////////////////////////////////////////////////////////////
$count_query2 = "SELECT * FROM `finance_transaction_master` WHERE `gl_id` = '$sq_bank[ledger_id]' AND `clearance_status` LIKE 'Pending' AND `row_specification` LIKE 'purchase'";
if($branch_admin_id != '0'){
  $count_query2 .= " and branch_admin_id='$branch_admin_id'";
}
$count2 = mysqli_num_rows(mysqlQuery($count_query2));
?>
<?php if($count1 > '0'){ ?>

<h3 class="editor_title">Cheque Deposited but not Cleared</h3>
<div class="panel panel-default panel-body app_panel_style feildset-panel">  
  <div class="row text-center mg_tp_20">
    <div class="col-md-12">
      <table class="table table-bordered table-hover" id="tbl_rec_list" style="margin: 0 !important;">
        <thead>
          <tr class="table-heading-row">
            <th>SR.No</th>
            <th>Date</th>
            <th>Cheque_No.</th>
            <th>Booking type</th>
            <th>Booking ID</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $count = 1;
          $debit_query = "SELECT * FROM `bank_cash_book_master` WHERE `bank_id` = '$bank_id' AND `clearance_status`='Pending' AND `payment_type`='Bank' AND payment_side='Debit'";
          if($branch_admin_id != '0'){
            $debit_query .= " and branch_admin_id='$branch_admin_id'";
          }
          $sq_query = mysqlQuery($debit_query);
          while($row_query = mysqli_fetch_assoc($sq_query)){
        ?>
            <tr>
              <td><input type="text" class="form-control" id="r_count" name="r_count" value="<?= $count++ ?>" readonly></td>
              <td class="col-md-2 col-sm-6"><input type="text" class="form-control" id="r_date" name="r_date" value="<?= get_date_user($row_query['payment_date']) ?>" readonly></td>
              <td class="col-md-2 col-sm-6"><input type="text" class="form-control" id="r_che_no" name="r_che_no" value="<?=  $row_query['transaction_id']?>" readonly></td>
              <td class="col-md-3 col-sm-6"><input type="text" class="form-control" id="r_sale" name="r_sale" value="<?= $row_query['module_name']?>" readonly></td>
              <td class="col-md-2 col-sm-6"><input type="text" class="form-control" id="r_sale_id" name="r_sale_id" value="<?= $row_query['module_entry_id']?>" readonly></td>
              <td class="col-md-3 col-sm-6"><input type="text" title="Total Amount" class="form-control" id="r_amount" name="r_amount" class="text-right" value="<?= $row_query['payment_amount']?>" readonly></td>
            </tr> 
            <script type="text/javascript">
              get_total_receipt_pending('<?=  $row_query['payment_amount']?>'); 
            </script>   
        <?php } ?>               
        </tbody>
      </table>  
    </div> 
  </div>
  <div class="row mg_tp_10">
    <div class="col-md-3 col-md-offset-9 col-sm-6">
      <input type="text" id="total_r_amount" name="total_r_amount" style="font-weight: bold;" title="Total Amount" class="form-control" value="0.00" class="text-right" readonly>  
    </div>
  </div>
</div>
<?php } ?>
<?php if($count2 > '0'){ ?>
<h3 class="editor_title">Cheque Issued but not Presented for Payment</h3>
<div class="panel panel-default panel-body app_panel_style feildset-panel">  
  <div class="row text-center mg_tp_20">
      <div class="col-md-12">
        <table class="table table-bordered table-hover" id="tbl_payment_list" style="margin: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.No</th>
              <th>Date</th>
              <th>Cheque_No.</th>
              <th>Purchase</th>
              <th>Purchase_ID</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>          
          <?php 
            $count = 1;
            $credit_query = "SELECT * FROM `bank_cash_book_master` WHERE `bank_id` = '$bank_id' AND `clearance_status`='Pending' AND `payment_type`='Bank' AND payment_side='Credit'";
            if($branch_admin_id != '0'){
              $credit_query .= " and branch_admin_id='$branch_admin_id'";
            }
            $sq_query = mysqlQuery($credit_query);
            while($row_query = mysqli_fetch_assoc($sq_query)){
          ?>
              <tr>
                <td><input type="text" class="form-control" id="p_count" name="p_count" value="<?= $count++ ?>" readonly></td>
                <td class="col-md-2 col-sm-6"><input type="text" class="form-control" id="p_date" name="p_date" value="<?= get_date_user($row_query['payment_date']) ?>" readonly></td>
                <td class="col-md-2 col-sm-6"><input type="text" class="form-control" id="p_che_no" value="<?=  $row_query['transaction_id']?>" name="p_che_no" readonly></td>
                <td class="col-md-3 col-sm-6"><input type="text" class="form-control" id="r_sale" name="r_sale" value="<?= $row_query['module_name']?>" readonly></td>
                <td class="col-md-2 col-sm-6"><input type="text" class="form-control" id="r_sale_id" name="r_sale_id" value="<?= $row_query['module_entry_id']?>" readonly></td>
                <td class="col-md-3 col-sm-6"><input type="text" class="form-control" id="p_amount" name="p_amount" value="<?=  $row_query['payment_amount']?>" title="Total Amount" class="text-right" readonly></td>
              </tr>     
            <script type="text/javascript">
              get_total_payment_pending('<?=  $row_query['payment_amount']?>'); 
            </script>   
        <?php } ?>                 
          </tbody>
        </table>  
      </div> 
  </div>
  <div class="row mg_tp_10">
    <div class="col-md-3 col-md-offset-9 col-sm-6">
      <input type="text" id="total_p_amount" name="total_p_amount" style="font-weight: bold;" title="Total Amount" class="form-control" value="0.00" class="text-right" readonly>  
    </div>
  </div>
</div>
<?php } ?>