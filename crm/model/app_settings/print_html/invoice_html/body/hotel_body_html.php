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
$service_tax_per = $_GET['service_tax_per'];
$service_tax = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];
$sac_code = $_GET['sac_code'];
$credit_card_charges = $_GET['credit_card_charges'];
$charge = ($credit_card_charges!='')?$credit_card_charges:0 ;
$basic_cost = number_format($basic_cost1,2);

$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$booking_id'"));
$tds = $sq_hotel['tds'];
$discount = $sq_hotel['discount'];
$bsmValues = json_decode($sq_hotel['bsm_values']);
$roundoff = $sq_hotel['roundoff'];
$tax_show = '';
$newBasic = 0;
$total_paid = intval($total_paid) + intval($credit_card_charges);
$tcs_per = $sq_hotel['tcs_per'];
$tcs_tax_amt = $sq_hotel['tcs_tax'];

//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_hotel['service_tax_subtotal'] !== 0.00 && ($sq_hotel['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_hotel['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;
}
else{
  $tax_show =  rtrim($name, ', ').' : ' . $currency_code." ".($service_tax_amount);
  $newSC = $service_charge;
}
$service_tax_amount_show = currency_conversion($currency,$sq_hotel['currency_code'],$service_tax_amount);
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($sq_hotel['markup_tax'] !== 0.00 && $sq_hotel['markup_tax'] !== ""){
  $service_tax_markup1 = explode(',',$sq_hotel['markup_tax']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
$markupservice_tax_amount_show = currency_conversion($currency,$sq_hotel['currency_code'],$markupservice_tax_amount);
if($bsmValues[0]->markup != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $sq_hotel['markup'] + $markupservice_tax_amount;
}
else{
  $newBasic = $basic_cost1;
  $newSC = $service_charge + $sq_hotel['markup'];
  $tax_show = rtrim($name, ', ') .' : ' . $currency_code." ".($markupservice_tax_amount + $service_tax_amount);
}
////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $service_tax_amount + $sq_hotel['markup'] + $markupservice_tax_amount;
}

$net_amount1 = 0;
$net_amount1 =  $basic_cost1 + $service_charge  + $sq_hotel['markup'] + $markupservice_tax_amount + $service_tax_amount - $discount - $tds + floatval($roundoff) + $tcs_tax_amt;

$net_total1 = currency_conversion($currency,$sq_hotel['currency_code'],$net_amount1);
$amount_in_word = $amount_to_word->convert_number_to_words($net_total1,$sq_hotel['currency_code']);

$newBasic1 = currency_conversion($currency,$sq_hotel['currency_code'],$newBasic+$newSC);
// $newSC1 = currency_conversion($currency,$sq_hotel['currency_code'],$newSC);
$charge1 = currency_conversion($currency,$sq_hotel['currency_code'],$charge);
$total_paid1 = currency_conversion($currency,$sq_hotel['currency_code'],$total_paid);
$tds1 = currency_conversion($currency,$sq_hotel['currency_code'],$tds);
$discount1 = currency_conversion($currency,$sq_hotel['currency_code'],$discount);
$roundoff1 = currency_conversion($currency,$sq_hotel['currency_code'],$roundoff);
$balance = floatval($net_amount1) - floatval($total_paid) + floatval($credit_card_charges);
$balance = currency_conversion($currency,$sq_hotel['currency_code'],$balance);
$service_tax_amount_show = explode(' ',$service_tax_amount_show);
$service_tax_amount_show1 = str_replace(',','',$service_tax_amount_show[1]);
$markupservice_tax_amount_show = explode(' ',$markupservice_tax_amount_show);
$markupservice_tax_amount_show1 = str_replace(',','',$markupservice_tax_amount_show[1]);

$tcs_tax = currency_conversion($currency,$sq_hotel['currency_code'],$tcs_tax_amt);

//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>

<hr class="no-marg">

<div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">PASSENGER : <?= $sq_hotel['pass_name'] ?></span></p></div>

<div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.NO</th>
              <th>City</th>     
              <th>Hotel</th>     
              <th>Check_IN_date</th>              
              <th>No of nights</th>
              <th>Room_Category</th>
              <th>Total_PAX</th>
            </tr>
          </thead>
          <tbody>   
          <?php 
          $count = 1;
          $sq_hotel_entry = mysqlQuery("select * from hotel_booking_entries where booking_id='$booking_id'");
          $sq_passengers = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$booking_id'"));
          while($row_passenger = mysqli_fetch_assoc($sq_hotel_entry))
          {
              $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_passenger[city_id]'"));
              $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_id, hotel_name from hotel_master where hotel_id='$row_passenger[hotel_id]'"));
            ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?php echo $sq_city['city_name']; ?></td>
              <td><?php echo $sq_hotel['hotel_name']; ?></td>
              <td><?php echo get_datetime_user($row_passenger['check_in']); ?></td>
              <td><?php echo $row_passenger['no_of_nights']; ?></td>
              <td><?php echo $row_passenger['category']; ?></td>
              <td><?php echo (($sq_passengers['adults'] != '') ? $sq_passengers['adults'] : 0).' Adult(s), '.(($sq_passengers['childrens'] != '') ? $sq_passengers['childrens'] : 0).' Child(ren), '.(($sq_passengers['infants'] != '') ? $sq_passengers['infants'] : 0).' Infant(s)'  ?></td>
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
    <div class="main_block inv_rece_calculation border_block">
      <div class="col-md-6"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $newBasic1 ?></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $net_total1 ?></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">TAX</span><span class="float_r"><?= str_replace(',','',$name).$service_tax_amount_show[0].' '.number_format($service_tax_amount_show1 + $markupservice_tax_amount_show1,2) ?></span></p></div>
      <!-- <div class="col-md-6"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?= $newSC1 ?></span></p></div> -->
      <div class="col-md-6"><p class="border_lt"><span class="font_5">CREDIT CARD CHARGES </span><span class="float_r"><?= $charge1 ?></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">DISCOUNT</span><span class="float_r"><?= $discount1 ?></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">ADVANCE PAID </span><span class="font_5 float_r"><?= $total_paid1 ?></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">TDS</span><span class="float_r"><?= $tds1 ?></span></p></div>

      <div class="col-md-6"><p class="border_lt"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?= $balance ?></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">TCS<?= '('.$tcs_per.'%)'?></span><span class="float_r"><?= $tcs_tax ?></span></p></div>
      
      <div class="col-md-6"><p class="border_lt"><span class="font_5">&nbsp;</span><span class="float_r"></span></p></div>
      <div class="col-md-6"><p class="border_lt"><span class="font_5">ROUNDOFF</span><span class="float_r"><?= $roundoff1 ?></span></p></div>
    </div>
  </div>
</div>
</section>
<?php
//Footer
include "../generic_footer_html.php"; ?>