<?php
include "../../../../../../model/model.php";
$tourwise_traveler_id = $_POST['tourwise_traveler_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from payment_master where tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id') and amount != '0' ";
if($tourwise_traveler_id!=""){
	$query .=" and tourwise_traveler_id = '$tourwise_traveler_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered table-hover bg_white cust_table" id="group_table2" style="margin:20px 0 !important">     
  <thead>
      <tr class="table-heading-row">
        <th> S_No. </th>
        <th> Booking_ID </th>
        <th> Payment_Date </th>
        <th> Payment_Mode </th>
        <th> Bank_Name </th>
        <th> Cheque_No/ID </th>
        <th class="text-right success">Payment_Amount </th>
        <th> Receipt </th>
      </tr>
  </thead>
  <tbody id="tbl_payment_installment_detail">   
  <?php
  $count = 0;
  $sq_pending_amount=0;
  $sq_cancel_amount=0;
  $sq_paid_amount=0;
  $Total_payment=0;
  $footer_paid_total = 0;
  $bg;
  $sq = mysqlQuery($query);
  while($row = mysqli_fetch_assoc($sq))
  {
    $sq_cancel_amount = 0;
    $sq_pending_amount = 0;

    $date = $row['date'];
    $yr = explode("-", $date);
    $year = $yr[0];
    $sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where id='$row[tourwise_traveler_id]'"));
		$sq_pay = mysqli_fetch_assoc(mysqlQuery("select sum(amount) as sum ,sum(credit_charges) as sumc from payment_master where clearance_status!='Cancelled' and tourwise_traveler_id='$row[tourwise_traveler_id]'"));
		$total_sale = $sq_booking['net_total']+$sq_pay['sumc'];
		$total_pay_amt = $sq_pay['sum']+$sq_pay['sumc'];
		$outstanding =  $total_sale - $total_pay_amt;

    $paid_amount = currency_conversion($currency,$sq_booking['currency_code'],$row['amount']+$row['credit_charges']);
    $sq_paid_amount_string = explode(' ',$paid_amount);
    $footer_paid_total += str_replace(',', '', $sq_paid_amount_string[1]);

    $sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id='$sq_booking[tour_id]'"));
    $sq_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id='$sq_booking[tour_group_id]'"));
    $tour = $sq_tour['tour_name'];
    $bg = '';
    if($row['clearance_status']=="Pending"){ $bg='warning';
      $sq_pending_amount = $row['amount']+$row['credit_charges'];
    }
    elseif($row['clearance_status']=="Cancelled"){ $bg='danger';
      $sq_cancel_amount = $row['amount']+$row['credit_charges'];
    }else{
      $bg = '';
    }

    $total = $total+$row['amount']+$row['credit_charges'];

    $pending_amount = currency_conversion($currency,$sq_booking['currency_code'],$sq_pending_amount);
    $sq_pending_amount_string = explode(' ',$pending_amount);
    $footer_pending_total += str_replace(',', '', $sq_pending_amount_string[1]);
    $cancel_amounts = currency_conversion($currency,$sq_booking['currency_code'],$sq_cancel_amount);
    
    $sq_cancel_amount_string = explode(' ',$cancel_amounts);
    $footer_cancel_total += str_replace(',', '', $sq_cancel_amount_string[1]);

    $total = $total+$row['amount']+$row['credit_charges'];
    $payment_id_name = "Group Payment ID";
    $payment_id = get_group_booking_payment_id($row['payment_id'],$year);
    $receipt_date = date('d-m-Y');
    $date = $sq_booking['form_date'];
    $yr = explode("-", $date);
    $year1 =$yr[0];
    $booking_id = get_group_booking_id($row['tourwise_traveler_id'],$year1);

    $customer_id = $sq_booking['customer_id'];
    $booking_name = "Group Booking";
    $travel_date = get_date_user($sq_group['from_date']);

    $payment_amount = $row['amount']+$row['credit_charges'];

    $payment_mode1 = $row['payment_mode'];

    $transaction_id = $row['transaction_id'];

    $payment_date = get_date_user($row['date']);

    $bank_name = $row['bank_name'];

    $confirm_by = $sq_booking['emp_id'];

    $receipt_type = ($row['payment_for']=='Travelling') ? "Travel Receipt" : "Tour Receipt";

    $url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&tour=$tour&table_name=payment_master&customer_field=tourwise_traveler_id&in_customer_id=$row[tourwise_traveler_id]&currency_code=$sq_booking[currency_code]";
    ?>   
      <tr class="<?= $bg;?>">
        <td><?= ++$count ?></td>
        <td><?= get_group_booking_id($row['tourwise_traveler_id'],$year1) ?></td>
        <td> <?php echo date("d-m-Y", strtotime($row['date'])); ?> </td>
        <td> <?php echo $row['payment_mode'] ?> </td>
        <td> <?php echo $row['bank_name'] ?> </td>
        <td> <?php echo $row['transaction_id'] ?> </td>
        <td class="text-right success"> <?php echo $paid_amount ?> </td>
        <td>
            <a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
        </td>
      </tr>
    <?php
  }    
  ?>    
  </tbody>
  <tfoot>
    <tr class="active"> 
      <th colspan="2" class="text-right info">Paid Amount: <?= number_format(($footer_paid_total),2); ?></th>
      <th colspan="2" class="text-right warning">Pending Clearance: <?= number_format($footer_pending_total,2)?></th>
      <th colspan="2" class="text-right danger">Cancelled : <?= ($footer_cancel_total)?></th>
      <th colspan="2" class="text-right success">Total Amount: <?= number_format(($footer_paid_total-$footer_pending_total-$footer_cancel_total),2); ?></th>
    </tr>
  </tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
  
$('#group_table2').dataTable({
  "pagingType": "full_numbers"
});
</script>