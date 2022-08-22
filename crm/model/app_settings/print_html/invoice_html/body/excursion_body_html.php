<?php  
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 
global $currency;

//Parameters
$invoice_no = $_GET['invoice_no'];
$booking_id = $_GET['booking_id'];
$invoice_date = $_GET['invoice_date'];
$customer_id = $_GET['customer_id'];
$service_name = $_GET['service_name'];
$basic_cost1 = $_GET['basic_cost'];
$service_charge = $_GET['service_charge'];
$taxation_type = $_GET['taxation_type'];
$service_tax_per = $_GET['service_tax_per'];
$service_tax = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];
$sac_code = $_GET['sac_code'];
$credit_card_charges = $_GET['credit_card_charges'];
$currency_code = $_GET['currency_code'];

$charge = ($credit_card_charges!='')?$credit_card_charges:0 ;

$basic_cost = number_format($basic_cost1,2);
$sq_exc = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master where exc_id='$booking_id'"));
$roundoff = $sq_exc['roundoff'];

$total_paid = floatval($total_paid);
$bsmValues = json_decode($sq_exc['bsm_values']);
//print_r($bsmValues);
$tax_show = '';
$newBasic = 0;

$name = '';
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_exc['service_tax_subtotal'] !== 0.00 && ($sq_exc['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_exc['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
$service_tax_amount_show = currency_conversion($currency,$currency_code,$service_tax_amount);
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;

}
else{
  $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
  $newSC = $service_charge;
}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($sq_exc['service_tax_markup'] !== 0.00 && $sq_exc['service_tax_markup'] !== ""){
  $service_tax_markup1 = explode(',',$sq_exc['service_tax_markup']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];

  }
}
$markupservice_tax_amount_show = currency_conversion($currency,$currency_code,$markupservice_tax_amount);

if($bsmValues[0]->markup != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $sq_exc['markup'] + $markupservice_tax_amount;
}
else{
  $newBasic = $basic_cost1;
  $newSC = $service_charge + $sq_exc['markup'];
  $tax_show = rtrim($name, ', ') .' : ' . ($markupservice_tax_amount + $service_tax_amount);
}
////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  //$newBasic = $basic_cost1 + $service_tax_amount;
  $newBasic = $basic_cost1 + $service_tax_amount + $sq_exc['markup'] + $markupservice_tax_amount;
  $tax_show = '';
}

$net_amount1 = 0;
$net_amount1 =  ($basic_cost1 + $service_charge  + $sq_exc['markup'] + $markupservice_tax_amount + $service_tax_amount) + $roundoff;

$net_amount2 = currency_conversion($currency,$currency_code,$net_amount1);
$amount_in_word = $amount_to_word->convert_number_to_words($net_amount2,$currency_code);

//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>

<hr class="no-marg">
<div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">Activity : </span></p></div>
<div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.NO</th>
              <th>Date_time</th>
              <th>City_Name</th>
              <th>Activity_Name</th>
              <th>Transfer_Option</th>
              <th>Adult</th>
              <th>Child</th>
            </tr>
          </thead>
          <tbody>   
          <?php 
          $count = 1;
          $sq_vehicle_entries = mysqlQuery("select * from excursion_master_entries where exc_id='$booking_id' and status!='Cancel'");
          while($row_vehicle = mysqli_fetch_assoc($sq_vehicle_entries)){

            $sql_exc_name = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff where entry_id='$row_vehicle[exc_name]'"));
            $sql_city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_vehicle[city_id]'"));
            ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?= get_datetime_user($row_vehicle['exc_date'])  ?></td>
              <td><?php echo $sql_city_name['city_name']; ?></td>
              <td><?= $sql_exc_name['excursion_name'] ?></td>
              <td><?= $row_vehicle['transfer_option'] ?></td>
              <td><?php echo $row_vehicle['total_adult']; ?></td>
              <td><?= $row_vehicle['total_child'] ?></td>
            </tr>
            <?php   
              $count++;
            } ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
  </div>
<section class="print_sec main_block">

<!-- invoice_receipt_body_calculation -->
  <div class="row">
    <div class="col-md-12">
      <?php
      $newBasic1 = currency_conversion($currency,$currency_code,$newBasic);
      $newSC1 = currency_conversion($currency,$currency_code,$newSC);
      $charge1 = currency_conversion($currency,$currency_code,$charge);
      $total_paid1 = currency_conversion($currency,$currency_code,$total_paid);
      $roundoff = currency_conversion($currency,$currency_code,$sq_exc['roundoff']);
      $balance_amount1 = currency_conversion($currency,$currency_code,$balance_amount);
      
      $service_tax_amount_show = explode(' ',$service_tax_amount_show);
      $service_tax_amount_show1 = str_replace(',','',$service_tax_amount_show[1]);
      $markupservice_tax_amount_show = explode(' ',$markupservice_tax_amount_show);
      $markupservice_tax_amount_show1 = str_replace(',','',$markupservice_tax_amount_show[1]);

      ?>
    <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-6"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $newBasic1 ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $net_amount2 ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?= $newSC1 ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CREDIT CARD CHARGES </span><span class="float_r"><?= $charge1 ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TAX </span><span class="float_r"><?= str_replace(',','',$name).$service_tax_amount_show[0].' '.number_format($service_tax_amount_show1 + $markupservice_tax_amount_show1,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ADVANCE PAID </span><span class="font_5 float_r"><?= $total_paid1 ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ROUND OFF </span><span class="font_5 float_r"><?= $roundoff ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?= $balance_amount1 ?></span></p></div>
        
        
      </div>
      </div>
  </div>
</section>
<?php 
//Footer
include "../generic_footer_html.php"; ?>