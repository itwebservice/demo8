<?php 
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$currency;

$quotation_id = $_GET['quotation_id'];
$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Hotel Quotation' and active_flag ='Active'"));

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from hotel_quotation_master where quotation_id='$quotation_id'"));
$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));
$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year =$yr[0];

$enquiryDetails = json_decode($sq_quotation['enquiry_details'], true);
$hotelDetails = json_decode($sq_quotation['hotel_details'], true);
$costDetails = json_decode($sq_quotation['costing_details'], true);

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
if($costDetails['tax_amount'] !== 0.00 && ($costDetails['tax_amount']) !== ''){
  $service_tax_subtotal1 = explode(',',$costDetails['tax_amount']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $percent = $service_tax[1];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
$service_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$service_tax_amount);

$basic_cost1 = $costDetails['hotel_cost'];
$service_charge = $costDetails['service_charge'];
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($costDetails['markup_tax'] !== 0.00 && $costDetails['markup_tax'] !== ""){
  $service_tax_markup1 = explode(',',$costDetails['markup_tax']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
$markupservice_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$markupservice_tax_amount);

if(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '')  && $bsmValues[0]->markup != ''){
  $tax_show = '';
  $newBasic = $basic_cost1 + $costDetails['markup_cost'] + $markupservice_tax_amount + $service_charge + $service_tax_amount;
}
elseif(($bsmValues[0]->service == '' || $bsmValues[0]->basic == '')  && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount + $service_tax_amount);
  $newBasic = $basic_cost1 + $costDetails['markup_cost'] + $service_charge;
}
elseif(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '') && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount);
  $newBasic = $basic_cost1 + $costDetails['markup_cost'] + $service_charge + $service_tax_amount;
}
else{
  $tax_show = $percent.' '. ($service_tax_amount);
  $newBasic = $basic_cost1 + $costDetails['markup_cost'] + $service_charge + $markupservice_tax_amount;
}
////////////////Currency conversion ////////////
$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$costDetails['total_amount']);
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
          <span class="title"><i class="fa fa-pencil-square-o"></i> HOTEL QUOTATION</span>
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
                    <i class="fa fa-tags" aria-hidden="true"></i><br>
                    <span>PRICE</span><br>
                    <?= $currency_amount1 ?><br>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

    </section>

    <!-- Hotel -->
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
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CUSTOMER NAME :</span><?= $enquiryDetails['customer_name'] ?></li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CONTACT NUMBER :</span> <?= $enquiryDetails['country_code'].$enquiryDetails['whatsapp_no'] ?></li>
          </ul>
          <ul class="print_info_list">
            
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>E-MAIL ID :</span> <?= $enquiryDetails['email_id'] ?></li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>QUOTATION ID : </span><?= get_quotation_id($quotation_id, $year) ?></li>
          </ul>
          <hr class="main_block">
            <ul class="main_block">
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>Adult(s) : </span><?= $enquiryDetails['total_adult'] ?></li>
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CWB : </span><?= $enquiryDetails['children_with_bed'] ?></li>
            </ul>
            <ul class="main_block">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CWOB : </span><?= $enquiryDetails['children_without_bed'] ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>Infant(s) : </span><?= $enquiryDetails['total_infant'] ?></li>
            </ul>
            <ul class="main_block">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>Total : </span><?= $enquiryDetails['total_members'] ?></li>
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
              $total_fare = currency_conversion($currency,$sq_quotation['currency_code'],$newBasic + $costDetails['roundoff']);
              $service_tax_amount_show = explode(' ',$service_tax_amount_show);
              $service_tax_amount_show1 = str_replace(',','',$service_tax_amount_show[1]);
              $markupservice_tax_amount_show = explode(' ',$markupservice_tax_amount_show);
              $markupservice_tax_amount_show1 = str_replace(',','',$markupservice_tax_amount_show[1]);
              ?>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TOTAL FARE : </span><?= $total_fare ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TAX : </span><?= str_replace(',','',$name).$service_tax_amount_show[0].' '.number_format($service_tax_amount_show1 + $markupservice_tax_amount_show1,2) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>QUOTATION COST : </span><?= $currency_amount1 ?></li>
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
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SWIFT CODE : </span><?= ($bank_swift_code != '') ? strtoupper($bank_swift_code) : 'NA' ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <section class="print_sec main_block side_pad mg_tp_30">
        <div class="section_heding">
              <h2>ACCOMMODATION</h2>
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
                      <th>City</th>
                      <th>Hotel Name</th>
                      <th>Check_IN</th>
                      <th>Check_OUT</th>
                    </tr>
                  </thead>
                  <tbody> 
                <?php 
                $hotelDetails = json_decode($sq_quotation['hotel_details']);
                foreach($hotelDetails as $details){
                  $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$details->hotel_id'"));
                  $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$details->city_id'"));
                ?>
                <tr>
                    <?php
                    $sq_count_h = mysqli_num_rows(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$details->city_id' "));
                    if($sq_count_h ==0){
                      $download_url =  BASE_URL.'images/dummy-image.jpg';
                    }
                    else{
                      $sq_hotel_image = mysqlQuery("select * from hotel_vendor_images_entries where hotel_id = '$details->city_id'");
                      while($row_hotel_image = mysqli_fetch_assoc($sq_hotel_image)){      
                          $image = $row_hotel_image['hotel_pic_url']; 
                          $newUrl = preg_replace('/(\/+)/','/',$image);
                          $newUrl = explode('uploads', $newUrl);
                          $download_url = BASE_URL.'uploads'.$newUrl[1];
                        }
                    }
                    ?>
                      <td><?php echo $city_name['city_name']; ?></td>
                      <td><?php echo $hotel_name['hotel_name']; ?></td>
                      <td><?= get_date_user($details->checkin) ?></td>
                      <td><?= get_date_user($details->checkout) ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            </div>
          </section>
    
    <section class="print_sec main_block side_pad mg_tp_30">
    <?php if($sq_terms_cond['terms_and_conditions'] != ''){ ?>
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Terms and Conditions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
           <?php echo $sq_terms_cond['terms_and_conditions']; ?>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="row mg_tp_10">
      <div class="col-md-12">
        <?php echo $quot_note; ?>
      </div>
    </div>

      <div class="row mg_tp_30">
        <div class="col-md-7"></div>
        <div class="col-md-5 mg_tp_30">
          <div class="print_quotation_creator text-center">
            <span>PREPARED BY </span><br><?= $emp_name?>
          </div>
        </div>
      </div>
    </section>

    <section>
      
    </section>    
  </body>
</html>