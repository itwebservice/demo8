<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$similar_text,$quot_note,$currency;

$quotation_id = $_GET['quotation_id'];
$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Hotel Quotation' and active_flag ='Active'")); 

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from hotel_quotation_master where quotation_id='$quotation_id'"));

$enquiryDetails = json_decode($sq_quotation['enquiry_details'], true);
$hotelDetails = json_decode($sq_quotation['hotel_details'], true);
$costDetails = json_decode($sq_quotation['costing_details'], true);

$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));
$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year =$yr[0];

$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));

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

    <!-- landingPage -->
    <section class="landingSec main_block">

      <div class="landingPageTop main_block">
        <img src="<?= $app_quot_img?>" class="img-responsive">
        <h1 class="landingpageTitle">HOTEL QUOTATION</h1>
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
      </div>

      <div class="ladingPageBottom main_block side_pad">
        <div class="row">
          <div class="col-md-12 mg_tp_30">
              <h3 class="customerFrom">Prepared for</h3>
          </div>
          <div class="col-md-5">
            <div class="landigPageCustomer">
              <span class="customerName mg_tp_10"><i class="fa fa-user"></i> : <?= $enquiryDetails['customer_name'] ?></span><br>
              <span class="customerMail mg_tp_10"><i class="fa fa-envelope"></i> : <?= $enquiryDetails['email_id'] ?></span><br>
              <span class="customerMobile mg_tp_10"><i class="fa fa-phone"></i> : <?= $enquiryDetails['country_code'].$enquiryDetails['whatsapp_no'] ?></span><br>
            </div>
          </div>
          <div class="col-md-7 text-right">
          
            <div class="detailBlock text-center">
              <div class="detailBlockIcon detailBlockBlue">
                <i class="fa fa-calendar"></i>
              </div>
              <div class="detailBlockContent">
                <h3 class="contentValue"><?= get_date_user($sq_quotation['quotation_date']) ?></h3>
                <span class="contentLabel">QUOTATION DATE</span>
              </div>
            </div>

            <div class="detailBlock text-center">
              <div class="detailBlockIcon detailBlockYellow">
                <i class="fa fa-users"></i>
              </div>
              <div class="detailBlockContent">
                <h3 class="contentValue"><?= $enquiryDetails['total_members'] ?></h3>
                <span class="contentLabel">TOTAL GUEST</span>
              </div>
            </div>

            <div class="detailBlock text-center">
              <div class="detailBlockIcon detailBlockRed">
                <i class="fa fa-tag"></i>
              </div>
              <div class="detailBlockContent">
                <h3 class="highlightContentValue"><?= $currency_amount1 ?></h3>
                <span class="contentLabel">PRICE</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  

  <!-- Hotel -->
  <section class="transportDetailsPanel main_block side_pad mg_tp_30 mg_bt_30">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_hotel.png" class="img-responsive">
            </div>
            <div class="transportDetails">
            <div class="col-md-12 no-pad">
                <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                  <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                    <thead>
                      <tr class="table-heading-row">
                        <th>City</th>
                        <th>Hotel</th>
                        <th>R_Category</th>
                        <th>Meal_Plan</th>
                        <th>H_Category</th>
                        <th>Check_IN</th>
                        <th>Check_OUT</th>
                      </tr>
                    </thead>
                    <tbody> 
                  <?php
                  foreach($hotelDetails as $values){
                      $cityName = mysqli_fetch_assoc(mysqlQuery("SELECT `city_name` FROM `city_master` WHERE `city_id`=".$values['city_id']));
                      $hotelName = mysqli_fetch_assoc(mysqlQuery("SELECT `hotel_name` FROM `hotel_master` WHERE `hotel_id`=".$values['hotel_id']));
                  ?>
                  <tr>
                      <td><?php echo $cityName['city_name']; ?></td>
                      <td><?php echo $hotelName['hotel_name']; ?></td>
                      <td><?= $values['hotel_cat'] ?></td>
                      <td><?= $values['meal_plan'] ?></td>
                      <td><?= $values['hotel_type'] ?></td>
                      <td><?= get_date_user($values['checkin']) ?></td>
                      <td><?= get_date_user($values['checkout']) ?></td>
                  </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
            </div>
            </div>
          </div>
          <div class="row">
          
          <div class="col-md-12 mg_tp_30">
            <div class="incluExcluTermsTabPanel main_block">
                <h3 class="incexTitle">Terms & Conditions</h3>
                <div class="tncContent">
                    <pre class="real_text"><?php echo $sq_terms_cond['terms_and_conditions']; ?></pre>      
                </div>
            </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-md-12">
              <div class="tncContent">
                  <pre class="real_text"><?php echo $quot_note; ?></pre>      
              </div>              
            </div>
          </div>
        </div>
        </section>

  <!-- Costing & Banking Page -->
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p4/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="endPageSection main_block mg_tp_30 pageSectionInner">

        <div class="row">
          
          <!-- Guest Detail -->
          <div class="col-md-12 passengerPanel endPagecenter mg_bt_30">
                <h3 class="endingPageTitle text-center">Total Guest</h3>
                <div class="col-md-3 text-center mg_bt_30">
                  <div class="icon">
                    <img src="<?= BASE_URL ?>images/quotation/p4/adult.png" class="img-responsive">
                    <h4 class="no-marg">Adult : <?= $enquiryDetails['total_adult'] ?></h4>
                  </div>
                </div>
                <div class="col-md-3 text-center mg_bt_30">
                  <div class="icon">
                    <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
                    <h4 class="no-marg">CWB : <?= $enquiryDetails['children_with_bed'] ?></h4>
                  </div>
                </div>
                <div class="col-md-3 text-center mg_bt_30">
                  <div class="icon">
                    <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
                    <h4 class="no-marg">CWOB : <?= $enquiryDetails['children_without_bed'] ?></h4>
                  </div>
                </div>
                <div class="col-md-3 text-center mg_bt_30">
                  <div class="icon">
                    <img src="<?= BASE_URL ?>images/quotation/p4/infant.png" class="img-responsive">
                    <h4 class="no-marg">Infant : <?= $enquiryDetails['total_infant'] ?></h4>
                  </div>
                </div>
          </div>
          
        </div>
        <div class="row constingBankingPanelRow">
          <!-- Costing -->
          <div class="col-md-12 constingBankingPanel constingPanel">
                <h3 class="costBankTitle text-center">Costing Details</h3>
                <!-- gROUP cOSTING -->
              <?php
              $total_fare = currency_conversion($currency,$sq_quotation['currency_code'],$newBasic + $costDetails['roundoff']);
              $service_tax_amount_show = explode(' ',$service_tax_amount_show);
              $service_tax_amount_show1 = str_replace(',','',$service_tax_amount_show[1]);
              $markupservice_tax_amount_show = explode(' ',$markupservice_tax_amount_show);
              $markupservice_tax_amount_show1 = str_replace(',','',$markupservice_tax_amount_show[1]);
              ?>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tourCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $total_fare ?></h4>
                  <p>TOTAL FARE</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tax.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= str_replace(',','',$name).$service_tax_amount_show[0].' '.number_format($service_tax_amount_show1 + $markupservice_tax_amount_show1,2) ?></h4>
                  <p>TAX</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/quotationCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $currency_amount1 ?></h4>
                  <p>QUOTATION COST</p>
                </div>
          </div>
          
        

          <!-- Bank Detail -->
          <div class="col-md-12 constingBankingPanel BankingPanel">
                <h3 class="costBankTitle text-center">Bank Details</h3>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/bankName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $bank_name_setting ?></h4>
                  <p>BANK NAME</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/branchName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= ($bank_branch_name!= '') ? $bank_branch_name : 'NA' ?></h4>
                  <p>BRANCH</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= ($acc_name != '') ? $acc_name : 'NA' ?></h4>
                  <p>A/C NAME</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accNumber.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= ($bank_acc_no != '') ? $bank_acc_no : 'NA' ?></h4>
                  <p>A/C NO</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= ($bank_ifsc_code != '') ? $bank_ifsc_code : 'NA' ?></h4>
                  <p>IFSC</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= ($bank_swift_code != '') ? strtoupper($bank_swift_code) : 'NA' ?></h4>
                  <p>SWIFT CODE</p>
                </div>
          </div>
          
        
        </div>

      </section>
    </section>

  <!-- Costing & Banking Page -->
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p4/pageBG.jpg" class="img-responsive pageBGImg">
    <section class="contactSection main_block mg_tp_30 text-center pageSectionInner">
        <div class="companyLogo">
          <img src="<?= $admin_logo_url ?>">
        </div>
        <div class="companyContactDetail">
            <h3><?= $app_name ?></h3>
            <?php if($app_address != ''){?>
            <div class="contactBlock">
              <i class="fa fa-map-marker"></i>
              <p><?php echo $app_address; ?></p>
            </div>
            <?php } ?>
            <?php if($app_contact_no != ''){?>
            <div class="contactBlock">
              <i class="fa fa-phone"></i>
              <p><?php echo $app_contact_no; ?></p>
            </div>
            <?php } ?>
            <?php if($app_email_id != ''){?>
            <div class="contactBlock">
              <i class="fa fa-envelope"></i>
              <p><?php echo $app_email_id; ?></p>
            </div>
            <?php } ?>
            <?php if($app_website != ''){?>
            <div class="contactBlock">
              <i class="fa fa-globe"></i>
              <p><?php echo $app_website; ?></p>
            </div>
            <?php } ?>
            <div class="contactBlock">
              <i class="fa fa-pencil-square-o"></i>
              <p>Prepared By : <?= $emp_name?></p>
            </div>
        </div>
    </section>
  </section>

  </body>
</html>