<?php
//Generic Files
include "../../../model.php";
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");
global $currency;

$payment_id_name = $_GET['payment_id_name'];
$payment_id = $_GET['payment_id'];
$receipt_date = $_GET['receipt_date'];
$booking_id = $_GET['booking_id'];
$customer_id = $_GET['customer_id'];
$booking_name = $_GET['booking_name'];
$travel_date = $_GET['travel_date'];
$payment_amount = $_GET['payment_amount'];
$transaction_id = $_GET['transaction_id'];
$payment_date = $_GET['payment_date'];
$receipt_date = $_GET['receipt_date'];
$payment_mode = $_GET['payment_mode'];
$bank_name = $_GET['bank_name'];
$confirm_by = $_GET['confirm_by'];
$receipt_type = $_GET['receipt_type'];
$payment_mode = $_GET['payment_mode'];
$outstanding = $_GET['outstanding'];
$currency_code = $_GET['currency_code'];
$tour = $_GET['tour'];
// This is new customization for displaying history
$table_name = $_GET['table_name'];
$inside_customer_id = $_GET['in_customer_id'];
$customer_field = $_GET['customer_field'];
$values_query = "select * from $table_name where $customer_field = $inside_customer_id and clearance_status!='Pending' and clearance_status!='Cancelled'";
if ($table_name != "payment_master" && $table_name != "package_payment_master") {
  $date_key = "payment_date";
  $amount_key = "payment_amount";
  $credit_charges = "credit_charges";
} else {
  $date_key = "date";
  $amount_key = "amount";
  $credit_charges = "credit_charges";
}
$values_query .= " and $amount_key !='0'";

//***END****/
if($receipt_type == 'Hotel Receipt' || $receipt_type == 'Tour Receipt' || $receipt_type == 'Activity Receipt' || $receipt_type == 'Visa Receipt'){

  $payment_amount1 = currency_conversion($currency,$currency_code,$payment_amount);
  $outstanding1 = currency_conversion($currency,$currency_code,$outstanding);
  $amount_in_word = $amount_to_word->convert_number_to_words($payment_amount1,$currency_code);
}else{
  $payment_amount1 = number_format($payment_amount,2);
  $outstanding1 = number_format($outstanding,2);
  $amount_in_word = $amount_to_word->convert_number_to_words($payment_amount,'');
}

if ($payment_mode == 'Cheque') {
  $payment_mode1 = $payment_mode . '(' . $transaction_id . ')';
} else {
  $payment_mode1 = $payment_mode;
}

$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
$sq_role = mysqli_fetch_assoc(mysqlQuery("select emp_id from roles where id='$confirm_by'"));

if ($confirm_by == '' || $confirm_by == 0) {
  $booking_by = $app_name;
} else {
  $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$confirm_by'"));
  $booking_by = $sq_emp['first_name'] . ' ' . $sq_emp['last_name'];
}
include "standard_header_html.php";
?>

<section class="print_sec_bt_s main_block">
  <!-- invoice_receipt_body_table-->
  <div class="border_block inv_rece_back_detail">
    <div class="row">
      <div class="col-md-4">
        <p class="border_lt"><span class="font_5">RECEIPT AMOUNT : </span><?php echo $payment_amount1; ?></p>
      </div>
      <div class="col-md-4">
        <p class="border_lt"><span class="font_5">Payment Date : </span><?php echo get_date_user($payment_date); ?></p>
      </div>
      <div class="col-md-4">
        <p class="border_lt"><span class="font_5">Payment Mode : </span><?php echo $payment_mode1; ?></p>
      </div>
      <?php if ($outstanding > 0) { ?><div class="col-md-4">
          <p class="border_lt"><span class="font_5">Balance : </span><?php echo $outstanding1; ?></p>
        </div><?php } ?>
      <div class="col-md-4">
        <p class="border_lt"><span class="font_5">For Services : </span><?php echo $booking_name; ?></p>
      </div>
      <?php if ($tour != '') { ?><div class="col-md-4">
          <p class="border_lt"><span class="font_5">Tour Name : </span><?php echo $tour; ?></p>
        </div><?php } ?>

      <div class="col-md-4">
        <p class="border_lt"><span class="font_5">Travel Date : </span><?php echo $travel_date; ?></p>
      </div>
    </div>
  </div>
</section>
<?php
//Footer
include "generic_footer_html.php"; ?>