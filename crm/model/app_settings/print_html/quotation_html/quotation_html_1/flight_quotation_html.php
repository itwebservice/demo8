<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$currency;

$quotation_id = $_GET['quotation_id'];
$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Flight Quotation' and active_flag ='Active'"));

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from flight_quotation_master where quotation_id='$quotation_id'"));
$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));
$sq_plane = mysqli_fetch_assoc(mysqlQuery("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'"));
$sq_airline1 = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$sq_plane[airline_name]'"));
$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year =$yr[0];

if($sq_emp_info['first_name']==''){
  $emp_name = 'Admin';
}
else{
  $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}

$tax_show = '';
$newBasic = $basic_cost1 = $sq_quotation['subtotal'] ;
$service_charge = $sq_quotation['service_charge'];
$bsmValues = json_decode($sq_quotation['bsm_values']);
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_quotation['service_tax'] !== 0.00 && ($sq_quotation['service_tax']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_quotation['service_tax']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $percent = $service_tax[1];
  }
}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($sq_quotation['markup_cost_subtotal'] !== 0.00 && $sq_quotation['markup_cost_subtotal'] !== ""){
  $service_tax_markup1 = explode(',',$sq_quotation['markup_cost_subtotal']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
$total_tax_amount_show = currency_conversion($currency,$currency,floatval($service_tax_amount) + floatval($markupservice_tax_amount));

if(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '')  && $bsmValues[0]->markup != ''){
  $tax_show = '';
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $markupservice_tax_amount + $service_charge + $service_tax_amount;
}
elseif(($bsmValues[0]->service == '' || $bsmValues[0]->basic == '')  && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($total_tax_amount_show);
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $service_charge;
}
elseif(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '') && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount);
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $service_charge + $service_tax_amount;
}
else{
  $tax_show = $percent.' '. ($service_tax_amount);
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $service_charge + $markupservice_tax_amount;
}
$quotation_cost = currency_conversion($currency,$currency,$sq_quotation['quotation_cost']);
?>

    <section class="headerPanel main_block">
        <div class="headerImage">
          <img src="<?= $app_quot_img ?>" class="img-responsive">
          <div class="headerImageOverLay"></div>
        </div>
        
      <!-- Header -->
      <section class="print_header main_block side_pad mg_tp_30">
        <div class="col-md-4 no-pad">
          <div class="print_header_logo">
            <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
          </div>
        </div>
        <div class="col-md-4 no-pad text-center mg_tp_30">
          <span class="title"><i class="fa fa-pencil-square-o"></i> FLIGHT QUOTATION</span>
        </div>
      <?php 
      include "standard_header_html.php";
      ?>

      <!-- print-detail -->
      <section class="print_sec main_block side_pad">
        <div class="row">
          <div class="col-md-12">
            <div class="print_info_block">
              <ul class="main_block">
                <li class="col-md-3 mg_tp_10 mg_bt_10">
                  <div class="print_quo_detail_block">
                    <i class="fa fa-calendar" aria-hidden="true"></i><br>
                    <span>QUOTATION DATE</span><br>
                    <?= get_date_user($sq_quotation['quotation_date']) ?><br>
                  </div>
                </li>
                <li class="col-md-3 mg_tp_10 mg_bt_10">
                  <div class="print_quo_detail_block">
                    <i class="fa fa-hashtag" aria-hidden="true"></i><br>
                    <span>QUOTATION ID</span><br>
                    <?= get_quotation_id($quotation_id,$year) ?><br>
                  </div>
                </li>
                <li class="col-md-3 mg_tp_10 mg_bt_10">
                  <div class="print_quo_detail_block">
                    <i class="fa fa-users" aria-hidden="true"></i><br>
                    <span>TOTAL SEATS</span><br>
                    <?= $sq_plane['total_adult'] + $sq_plane['total_child'] + $sq_plane['total_infant']?><br>
                  </div>
                </li>
                <li class="col-md-3 mg_tp_10 mg_bt_10">
                  <div class="print_quo_detail_block">
                    <i class="fa fa-tags" aria-hidden="true"></i><br>
                    <span>PRICE</span><br>
                    <?= $quotation_cost ?><br>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

    </section>

    <!-- Package -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>CUSTOMER DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 mg_bt_20">
        </div>
        <div class="col-md-5 mg_bt_20">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
          <ul class="print_info_list">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CUSTOMER NAME :</span><?= $sq_quotation['customer_name'] ?></li>
          </ul>
          <ul class="print_info_list">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CONTACT NUMBER :</span> <?= $sq_quotation['mobile_no'] ?></li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>E-MAIL ID :</span> <?= $sq_quotation['email_id'] ?></li>
          </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Costing -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="row">
        <div class="col-md-6">
          <div class="section_heding">
            <h2>COSTING</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_info_block">
            <ul class="main_block">
              <?php
              $fare_cost = currency_conversion($currency,$currency,(floatval($newBasic) + $sq_quotation['roundoff']));
              ?>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TOTAL FARE : </span><?= $fare_cost ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TAX : </span><?= $tax_show ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>QUOTATION COST : </span><?= $quotation_cost ?></li>
            </ul>
          </div>
        </div>
    
    <!-- Bank Detail -->
        <div class="col-md-6">
          <div class="section_heding">
            <h2>BANK DETAILS</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_info_block">
            <ul class="main_block">
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>BANK NAME : </span><?= ($bank_name_setting != '') ? $bank_name_setting : 'NA' ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>A/C NAME : </span><?= ($acc_name != '') ? $acc_name : 'NA' ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>BRANCH : </span><?= ($bank_branch_name!= '') ? $bank_branch_name : 'NA' ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>A/C NO : </span><?= ($bank_acc_no != '') ? $bank_acc_no : 'NA' ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>IFSC : </span><?= ($bank_ifsc_code != '') ? $bank_ifsc_code : 'NA' ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SWIFT CODE : </span><?= ($bank_swift_code != '') ? $bank_swift_code : 'NA' ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Flight -->
    <?php 
    $sq_plane_count = mysqli_num_rows(mysqlQuery("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'"));
    if($sq_plane_count>0){ 
    ?>
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>Flight</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>From</th>
                <th>To</th>
                <th>Airline</th>
                <th>Class</th>
                <th>Departure</th>
                <th>Arrival</th>
              </tr>
            </thead>
            <tbody>
            <?php 
            $sq_plane = mysqlQuery("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'");
              while($row_plane = mysqli_fetch_assoc($sq_plane)){
              $sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_plane[airline_name]'")); ?>   
              <tr>
                <td><?= $row_plane['from_location'] ?></td>
                <td><?= $row_plane['to_location'] ?></td>
                <td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>
                <td><?= $row_plane['class'] ?></td>
                <td><?= get_datetime_user($row_plane['dapart_time']) ?></td>
                <td><?= get_datetime_user($row_plane['arraval_time']) ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php } ?>

<!-- Terms and Conditions -->
    <section class="print_sec main_block side_pad mg_tp_30">
    <?php if($sq_terms_cond['terms_and_conditions']) {?>
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Terms and Conditions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
           <?= $sq_terms_cond['terms_and_conditions'] ?>
          </div>
        </div>
      </div>
    <?php } ?>
      <div class="row mg_tp_30">
        <div class="col-md-7"></div>
        <div class="col-md-5 mg_tp_30">
          <div class="print_quotation_creator text-center">
            <span>PREPARED BY </span><br><?= $emp_name?>
          </div>
        </div>
      </div>
    </section>
    
  </body>
</html>