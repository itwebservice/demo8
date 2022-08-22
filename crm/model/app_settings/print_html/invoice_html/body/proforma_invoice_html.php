<?php
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 
global $currency;

//Parameters
$for = $_GET['for'];
$invoice_no = $_GET['invoice_no'];
$invoice_date = $_GET['invoice_date'];
$customer_name = $_GET['customer_id'];
$customer_email = $_GET['customer_email'];
$service_name = $_GET['service_name'];
$basic_cost = $_GET['basic_cost'];
$service_tax = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$travel_cost = $_GET['travel_cost'];
$currency1 = $_GET['currency'];

$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Invoice' and   active_flag ='Active'"));

$basic_cost1 = currency_conversion($currency,$currency1,$basic_cost);
$travel_cost1 = currency_conversion($currency,$currency1,$travel_cost);
$net_amount = currency_conversion($currency,$currency1,$net_amount);

$amount_in_word = $amount_to_word->convert_number_to_words($net_amount,$currency1);

$service_tax_string = explode(':',$service_tax);
$tax_amount = currency_conversion($currency,$currency1,$service_tax_string[2]);

$emp_id = $_SESSION['emp_id'];
$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0'){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }
?>
<section class="print_sec_tp_s main_block ">
<!-- invloice_receipt_hedaer_top-->
<div class="main_block inv_rece_header_top header_seprator header_seprator_4 mg_bt_10">
  <div class="row">
    <div class="col-md-4">
      <div class="inv_rece_header_left">
        <div class="inv_rece_header_logo">
          <img src="<?php echo $admin_logo_url ?>" class="img-responsive">
        </div>
      </div>
    </div>
    <div class="col-md-4 text-center pd_tp_5">
      <div class="inv_rece_header_left">
        <div class="inv_rec_no_detail">
          <h2 class="inv_rec_no_title font_5 font_s_21 no-marg no-pad">PROFORMA INVOICE</h2>
          <h4 class="inv_rec_no font_5 font_s_14 no-marg no-pad"><?php echo $invoice_no; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 last_h_sep_border_lt">
      <div class="inv_rece_header_right text-right">
        <ul class="no-pad no-marg font_s_12 noType">
          <li><h3 class=" font_5 font_s_16 no-marg no-pad caps_text"><?php echo $app_name; ?></h3></li>
          <li><p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p></li>
          <li><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ? 
          $branch_details['contact_no'] : $app_contact_no ?></li>
          <li><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></li>
          <li><span class="font_5">TAX NO : </span><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['branch_tax'] : $service_tax_no; ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<hr class="no-marg">

<!-- invloice_receipt_bottom-->
<div class="main_block inv_rece_header_bottom mg_tp_10">
  <div class="row">
    <div class="col-md-7">
      <div class="inv_rece_header_left mg_bt_10">
        <ul class="no-marg no-pad">
          <li><h3 class="title font_5 font_s_16 no-marg no-pad">TO,</h3></li>
          <li><i class="fa fa-user"></i> : <?php echo $customer_name; ?></li>
          <li><i class="fa fa-map-marker"></i> : <?php echo $customer_email; ?></li>
        </ul>
      </div>
    </div>
    <div class="col-md-5">
      <div class="inv_rece_header_right">
        <ul class="no-marg no-pad">
          <li><span class="font_5">INVOICE FOR </span>: <?php echo $for; ?></li>
          <li><span class="font_5">INVOICE DATE </span>: <?php echo $invoice_date; ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</section>
<hr class="no-marg">

<section class="print_sec main_block">

<!-- invoice_receipt_body_calculation -->
  <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6">
      <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-12"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $basic_cost1 ?></span></p></div>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">TAX</span><span class="float_r"><?= $service_tax_string[0].$service_tax_string[1].' '.$tax_amount ?></span></p></div>
        <?php if($for == 'Package Tour'){ ?>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">Travel+Visa+Guide+Misc </span><span class="font_5 float_r"><?= $travel_cost1 ?></span></p></div>
        <?php } ?>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $net_amount ?></span></p></div>
      </div>
    </div>
  </div>

</section>
<?php 
//Footer
include "../generic_footer_html.php"; ?>