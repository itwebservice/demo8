<?php
include "../../../../../../model/model.php";
global $currency;
$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from package_tour_booking_master where customer_id='$customer_id' ";
if($booking_id!=""){
	$query .=" and booking_id = '$booking_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
  
<table class="table table-bordered table-hover bg_white cust_table" id="package_table" style="margin: 20px 0 !important;">
  <thead>
    <tr class="table-heading-row">
      <th>S_No.</th>
      <th>Booking_ID</th>
      <th>Tour_Name</th>
      <th>Tour_Date&nbsp;&nbsp;&nbsp;&nbsp;</th>
      <th>View</th>
      <th class="text-right info">Total_Amount</th>
      <th class="text-right success">Paid_Amount</th>
      <th class="text-right danger">Cancel_Amount</th>
      <th class="text-right warning">Balance</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $count = 0;
    $sq_booking = mysqlQuery($query);

    while($row_booking = mysqli_fetch_assoc($sq_booking)){

      $pass_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_booking[booking_id]'"));
      $cancle_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_booking[booking_id]' and status='Cancel'"));
      if($pass_count==$cancle_count){
          $bg="danger";
      }else{
          $bg="#fff";
      }
      $date = $row_booking['booking_date'];
      $yr = explode("-", $date);
      $year = $yr[0];
      $cancel_est=mysqli_fetch_assoc(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));

      $total_paid=mysqli_fetch_assoc(mysqlQuery("select sum(amount) as sum,sum(`credit_charges`) as sumc from package_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
      $credit_card_charges = $total_paid['sumc'];
      $paid_amount = $total_paid['sum']+$credit_card_charges;
      $paid_amount = ($paid_amount == '')?'0':$paid_amount;

      $sale_total_amount = $row_booking['net_total'] + $credit_card_charges;
      $cancel_est=mysqli_fetch_assoc(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
      $cancel_amount=$cancel_est['cancel_amount'];
      //balance
      if($paid_amount > 0){
        if($pass_count==$cancle_count){
          $balance_amount = 0;
        }
        else{
          $balance_amount = $sale_total_amount - $paid_amount;
        }
      }else{
        if($pass_count!=$cancle_count){
          $balance_amount = $sale_total_amount;
        }
        else{
          $balance_amount = $cancel_amount;
        }
      }

      $net_total1 = currency_conversion($currency,$row_booking['currency_code'],$row_booking['net_total']+$credit_card_charges);
      $paid_amount1 = currency_conversion($currency,$row_booking['currency_code'],$paid_amount);
      $cancel_amount1 = currency_conversion($currency,$row_booking['currency_code'],$cancel_amount);
      $balance_amount1 = currency_conversion($currency,$row_booking['currency_code'],$balance_amount);

      $net_total1_string = explode(' ',$net_total1);
      $footer_net_total = str_replace(',', '', $net_total1_string[1]);
      $paid_amount1_string = explode(' ',$paid_amount1);
      $footer_paid_amount = str_replace(',', '', $paid_amount1_string[1]);
      $cancel_amount1_string = explode(' ',$cancel_amount1);
      $footer_cancel_amount = str_replace(',', '', $cancel_amount1_string[1]);
      $balance_amount1_string = explode(' ',$balance_amount1);
      $footer_balance_amount = str_replace(',', '', $balance_amount1_string[1]);
      
      //Total
      $total_amount += $footer_net_total;
      $total_paid1 += $footer_paid_amount;
      $total_cancel += $footer_cancel_amount;
      $total_balance += $footer_balance_amount;
      ?>
      <tr class="<?=$bg?>">
        <td><?= ++$count ?></td>
        <td><?= get_package_booking_id($row_booking['booking_id'],$year) ?></td>
        <td><?= $row_booking['tour_name'] ?></td>
        <td><?= date('d-m-Y', strtotime($row_booking['tour_from_date'])) ?></td>
        <td>
          <button class="btn btn-info btn-sm" onclick="package_view_modal(<?= $row_booking['booking_id'] ?>)" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </td>
        <td class="text-right info"><?= $net_total1 ?></td>
        <td class="text-right success"><?= $paid_amount1 ?></td>
        <td class="danger text-right"><?= $cancel_amount1 ?></td>
        <td class="warning text-right"><?= $balance_amount1 ?></td>
      </tr>
      <?php

    }

    ?>
  </tbody>
  <tfoot>
    <tr class="active">
      <th colspan="5" class="text-right">Total</th>
      <th class="info text-right"><?= number_format($total_amount,2) ?></th>
      <th class="success text-right"><?= number_format($total_paid1,2) ?></th>
      <th class="danger text-right"><?= number_format($total_cancel,2) ?></th>
      <th class="warning text-right"><?= number_format($total_balance,2) ?></th>
    </tr>
  </tfoot>
</table>

</div> </div> </div>
<div id="div_package_content_display"></div>
<script type="text/javascript">
$('#package_table').dataTable({
  "pagingType": "full_numbers"
});
  function package_view_modal(booking_id)
  {
    var base_url = $('#base_url').val();
    $.post(base_url+'view/customer/other/bookings/package_booking/view/index.php', { booking_id : booking_id }, function(data){
      $('#div_package_content_display').html(data);
    });
  }
</script>