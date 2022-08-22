<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$similar_text,$quot_note,$currency;

$quotation_id = $_GET['quotation_id'];

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
$transport_agency_id = $sq_quotation['transport_agency_id'];
$sq_transport = mysqli_fetch_assoc(mysqlQuery("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
$sq_package_name = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Quotation' and dest_id='$sq_package_name[dest_id]' and active_flag ='Active'"));
$sq_dest = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_package_name[dest_id]'"));

$sq_transport = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));
$sq_costing = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id'"));
$sq_package_program = mysqlQuery("select * from  package_quotation_program where quotation_id='$quotation_id'");

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

$basic_cost = $sq_costing['basic_amount'];
$service_charge = $sq_costing['service_charge'];
$tour_cost= $basic_cost +$service_charge;
$service_tax_amount = 0;
$tax_show = '';
$bsmValues = json_decode($sq_costing['bsmValues']);

if($sq_costing['service_tax_subtotal'] !== 0.00 && ($sq_costing['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_costing['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}

$service_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$service_tax_amount);
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $tour_cost + $service_tax_amount;
  $tax_show = '';
}
else{
  // $tax_show = $service_tax_amount;
  $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
  $newBasic = $tour_cost;
}

////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $tour_cost + $service_tax_amount;
  $tax_show = '';
}

$quotation_cost = $basic_cost +$service_charge+ $service_tax_amount+ $sq_quotation['train_cost'] + $sq_quotation['cruise_cost']+ $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
////////////////Currency conversion ////////////
$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
?>

    <!-- landingPage -->
    <section class="landingSec main_block">

      <div class="landingPageTop main_block">
        
        <img src="<?= $app_quot_img?>" class="img-responsive">
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
        <h1 class="landingpageTitle"><?= $sq_package_name['package_name']?><?=' ('.$sq_package_name['package_code'].')' ?></h1>

        
        <div class="packageDeatailPanel">
          <div class="landigPageCustomer">
            <h3 class="customerFrom">PREPARED FOR :</h3>
            <span class="customerName"><em><i class="fa fa-user"></i></em> : <?= $sq_quotation['customer_name'] ?></span><br>
            <span class="customerMail"><em><i class="fa fa-envelope"></i></em> : <?= $sq_quotation['email_id'] ?></span><br>
            <span class="customerMobile"><em><i class="fa fa-phone"></i></em> : <?= $sq_quotation['mobile_no'] ?></span>
          </div>

          <div class="landingPageBlocks">
          
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-calendar"></i>
              </div>
              <div class="detailBlockContent">
                <p>QUOTATION DATE : <?= get_date_user($sq_quotation['quotation_date']) ?></p>
              </div>
            </div>
    
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-hourglass-half"></i>
              </div>
              <div class="detailBlockContent">
                <p>DURATION : <?php echo ($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D' ?></p>
              </div>
            </div>
    
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-users"></i>
              </div>
              <div class="detailBlockContent">
                <p>TOTAL GUEST : <?= $sq_quotation['total_passangers'] ?></p>
              </div>
            </div>
    
            <!-- <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-tag"></i>
              </div>
              <div class="detailBlockContent">
                <p>PRICE : <?= $currency_amount1 ?></p>
              </div>
            </div> -->
          </div>
        </div>

      </div>
    </section>

<!-- Count queries -->
<?php
  $sq_package_count = mysqli_num_rows(mysqlQuery("select * from  package_quotation_program where quotation_id='$quotation_id'"));
  $sq_hotel_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'"));
  $sq_transport_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));
  $sq_train_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id'"));
  $sq_plane_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'"));
  $sq_cruise_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));
  $sq_exc_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'"));

  $overall_count = 0;
  if($sq_train_count>0) $overall_count++; 
  if($sq_plane_count>0) $overall_count++; 
  if($sq_cruise_count>0) $overall_count++; 
  if($sq_hotel_count>0) $overall_count++; 
  if($sq_transport_count>0) $overall_count++; 
  if($sq_exc_count>0) $overall_count++; 
  ?>
<!-- traveling Information -->
<?php if($sq_transport_count != 0 || $sq_train_count != 0 || $sq_plane_count != 0 ){
  ?>
  <!-- traveling Information -->
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
    <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
        <!-- Flight -->
        <?php
        if($sq_plane_count>0){ ?>
        <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_flight.png" class="img-responsive">
            </div>
            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                  <thead>
                    <tr class="table-heading-row">
                      <th>From_Sector</th>
                      <th>To_Sector</th>
                      <th>Airline</th>
                      <th>Class</th>
                      <th>Departure_D/T</th>
                      <th>Arrival_D/T</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $sq_plane = mysqlQuery("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'");
                      while($row_plane = mysqli_fetch_assoc($sq_plane)){
                      $sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_plane[airline_name]'"));
                      $airline = ($row_plane['airline_name'] != '') ? $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' : 'NA';
                    ?>   
                    <tr>
                      <td><?= $row_plane['from_location'] ?></td>
                      <td><?= $row_plane['to_location'] ?></td>
                      <td><?= $airline ?></td>
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
        <!-- Train -->
        <?php if($sq_train_count>0){ ?>
        <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_train.png" class="img-responsive">
            </div>
            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                  <thead>
                    <tr class="table-heading-row">
                      <th>From_Location</th>
                      <th>To_Location</th>
                      <th>Class</th>
                      <th>Departure_D/T</th>
                      <th>Arrival_D/T</th>
                    </tr>
                  </thead>
                  <tbody>  
                  <?php 
                  $sq_train = mysqlQuery("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id'");
                  while($row_train = mysqli_fetch_assoc($sq_train)){  
                    ?>
                    <tr>
                      <td><?= $row_train['from_location'] ?></td>
                      <td><?= $row_train['to_location'] ?></td>
                      <td><?php echo ($row_train['class']!='')?$row_train['class']:'NA'; ?></td>
                      <td><?= date('d-m-Y H:i', strtotime($row_train['departure_date'])) ?></td>
                      <td><?= date('d-m-Y H:i', strtotime($row_train['arrival_date'])) ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <?php
        if($sq_transport_count>0){ ?>
        <!-- transport -->
        <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_car.png" class="img-responsive">
            </div>
            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table no-marg tableTrnasp">
                  <thead>
                    <tr class="table-heading-row">
                      <th>VEHICLE</th>
                      <th>START_DATE</th>
                      <th>END_DATE</th>
                      <th>PICKUP LOCATION</th>
                      <th>DROP LOCATION</th>
                      <th>TOTAL VEHICLES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $count = 0;
                    $sq_hotel = mysqlQuery("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'");
                    while($row_hotel = mysqli_fetch_assoc($sq_hotel))
                    {
                      $transport_name = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id='$row_hotel[vehicle_name]'"));
                      // Pickup
                      if($row_hotel['pickup_type'] == 'city'){
                        $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[pickup]'"));
                        $pickup = $row['city_name'];
                      }
                      else if($row_hotel['pickup_type'] == 'hotel'){
                        $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[pickup]'"));
                        $pickup = $row['hotel_name'];
                      }
                      else{
                        $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[pickup]'"));
                        $airport_nam = clean($row['airport_name']);
                        $airport_code = clean($row['airport_code']);
                        $pickup = $airport_nam." (".$airport_code.")";
                      }
                      //Drop-off
                      if($row_hotel['drop_type'] == 'city'){
                        $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
                        $drop = $row['city_name'];
                      }
                      else if($row_hotel['drop_type'] == 'hotel'){
                        $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
                        $drop = $row['hotel_name'];
                      }
                      else{
                        $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
                        $airport_nam = clean($row['airport_name']);
                        $airport_code = clean($row['airport_code']);
                        $drop = $airport_nam." (".$airport_code.")";
                      }
                      ?>
                      <tr>
                        <td><?= $transport_name['vehicle_name'].$similar_text ?></td>
                        <td><?= date('d-m-Y', strtotime($row_hotel['start_date'])) ?></td>
                        <td><?= date('d-m-Y', strtotime($row_hotel['end_date'])) ?></td>
                        <td><?= $pickup ?></td>
                        <td><?= $drop ?></td>
                        <td><?= $row_hotel['vehicle_count'] ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>
    </section>
  </section>
<?php } ?>
<!-- traveling Information -->
<?php if($sq_exc_count != 0 || $sq_cruise_count != 0){?>
  <!-- traveling Information -->
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
    <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
        <!-- excursion -->
        <?php
        if($sq_exc_count>0){ ?>
        <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_excursion.png" class="img-responsive">
            </div>

            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table no-marg tableTrnasp">
                  <thead>
                      <tr class="table-heading-row">
                        <th>City </th>
                        <th>Activity Date&Time</th>
                        <th>Activity Name</th>
                        <th>Transfer Option</th>
                        <th>Adult(s)</th>
                        <th>CWB</th>
                        <th>CWOB</th>
                        <th>Infant(s)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $count = 0;
                      $sq_ex = mysqlQuery("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'");
                      while($row_ex = mysqli_fetch_assoc($sq_ex)){
                        $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_ex[city_name]'"));
                        $sq_ex_name = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff where entry_id='$row_ex[excursion_name]'"));
                        ?>
                        <tr>
                          <td><?= $sq_city['city_name'] ?></td>
                          <td><?= get_datetime_user($row_ex['exc_date']) ?></td>
                          <td><?= $sq_ex_name['excursion_name'] ?></td>
                          <td><?= $row_ex['transfer_option'] ?></td>
                          <td><?= $row_ex['adult'] ?></td>
                          <td><?= $row_ex['chwb'] ?></td>
                          <td><?= $row_ex['chwob'] ?></td>
                          <td><?= $row_ex['infant'] ?></td>
                        </tr>
                        <?php }	?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <!-- Cruise -->
        <?php
        if($sq_cruise_count>0){ ?>
        <section class="transportDetailsPanel transportDetailsLeftPanel transportDetailsLastPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_cruise.png" class="img-responsive">
            </div>

            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                  <thead>
                    <tr class="table-heading-row">
                      <th>Departure_D/T</th>
                      <th>Arrival_D/T</th>
                      <th>Route</th>
                      <th>Cabin</th>
                      <th>Sharing</th>
                    </tr>
                  </thead>
                  <tbody>  
                  <?php 
                  $sq_cruise = mysqlQuery("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'");
                  while($row_cruise = mysqli_fetch_assoc($sq_cruise)){  
                    ?>
                    <tr>
                      <td><?= date('d-m-Y H:i', strtotime($row_cruise['dept_datetime'])) ?></td>
                      <td><?= date('d-m-Y H:i', strtotime($row_cruise['arrival_datetime'])) ?></td>
                      <td><?= $row_cruise['route'] ?></td>
                      <td><?= $row_cruise['cabin'] ?></td>
                      <td><?= $row_cruise['sharing'] ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>

    </section>
  </section>
<?php } ?>
<!-- hotel Information -->
<?php if($sq_hotel_count != 0){?>
  <!-- hotel Information -->
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
    <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
        <!-- hotel -->
        <?php
        $package_type_count = 1;
        if($sq_hotel_count != 0){
          $sq_package_type = mysqlQuery("select DISTINCT(package_type) from package_tour_quotation_hotel_entries where quotation_id='$quotation_id' order by package_type");
          while($row_hotel1 = mysqli_fetch_assoc($sq_package_type)){

            $sq_package_type1 = mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id' and package_type='$row_hotel1[package_type]' order by package_type");
            if($package_type_count=='4'||$package_type_count=='7'||$package_type_count=='10'){

              ?>
              <section class="pageSection main_block">
              <!-- background Image -->
              <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
              <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
            <?php } ?>
              <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
                <h6 class="text-center">PACKAGE TYPE - <?= $row_hotel1['package_type'] ?></h6>
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
                              <th>Hotel Name</th>
                              <th>Check_IN</th>
                              <th>Check_OUT</th>
                            </tr>
                          </thead>
                          <tbody> 
                          <?php
                          while($row_hotel = mysqli_fetch_assoc($sq_package_type1)){

                            $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
                            $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_name]'"));
                            ?>
                              <tr>
                                <td><?php echo $city_name['city_name']; ?></td>
                                <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                                <td><?= get_date_user($row_hotel['check_in']) ?></td>
                                <td><?= get_date_user($row_hotel['check_out']) ?></td>
                              </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </section>
            <?php
            if($package_type_count=='3'||$package_type_count=='6'||$package_type_count=='9'){?>
                </section>
                </section>
            <?php  }
            $package_type_count++;
          } 
        } 
      ?>
<?php } ?>
<!-- Itinerary -->
<?php
  $count = 1;
  $checkPageEnd = 0;
  while($row_itinarary = mysqli_fetch_assoc($sq_package_program)){
    
    $sq_day_image = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_images where quotation_id='$row_itinarary[quotation_id]'"));
    $day_url1 = explode(',',$sq_day_image['image_url']);
    $daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
    for($count1 = 0; $count1<sizeof($day_url1);$count1++){
        $day_url2 = explode('=',$day_url1[$count1]);
        if($day_url2[1]==$row_itinarary['day_count'] && $day_url2[0]==$row_itinarary['package_id']){
          $daywise_image = $day_url2[2];
        }
    }
    if($checkPageEnd%1==0 || $checkPageEnd==0){
      $go = $checkPageEnd + 0;
      $flag = 0;
    ?>
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
    
      <section class="itinerarySec main_block side_pad mg_tp_30 pageSectionInner">
      <?php if($count == 1){ ?>
        <div class="mg-bt-30">
          <div class="vitinerary_div">
            <h6>Destination Guide Video</h6>
            <img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive"><br/>
            <a href="<?=$sq_dest['link']?>" class="no-marg" target="_blank"></a>
          </div>
        </div>
        <?php } ?>
          <?php 
            }
          // if($count%2!=0){
          ?>
          <ul class="print_itinenary no-pad no-marg">
          <li class="print_single_itinenary topItinerary">
              <div class="itineraryContent">
                <div class="itneraryImg">
                  <img src="<?= $daywise_image ?>" class="img-responsive">
                </div>
                <div class="itneraryText">
                  <div class="itneraryDayInfo">
                    <i class="fa fa-map-marker" aria-hidden="true"></i><span> Day <?= $count ?> : <?= $row_itinarary['attraction'] ?> </span>
                  </div>
                  <div class="itneraryDayPlan">
                    <p><?= $row_itinarary['day_wise_program'] ?></p>
                  </div>
                  <div class="itneraryDayAccomodation">
                    <span><i class="fa fa-bed"></i> : <?=  $row_itinarary['stay'] ?></span>
                    <span><i class="fa fa-cutlery"></i> : <?= $row_itinarary['meal_plan'] ?></span>
                  </div>
                </div>
              </div>
          </li>

          <?php
          // }
          if($go == $checkPageEnd){
            $flag = 1;
          ?>
        </ul>
      </section>
    </section>
    <?php 
    } $count++; $checkPageEnd++; } 
    if($flag == 0){
      ?>
        </ul>
      </section>
    </section>
  <?php } ?>

  <?php if($sq_quotation['inclusions'] != '' && $sq_quotation['inclusions'] != ' ' && $sq_quotation['inclusions'] != '<div><br></div>'){ ?>
    <!-- Inclusion -->
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="incluExcluTerms main_block side_pad mg_tp_30 pageSectionInner">

        <?php if($sq_quotation['inclusions'] != '' && $sq_quotation['inclusions'] != ' ' && $sq_quotation['inclusions'] != '<div><br></div>'){?>
          <!-- Inclusion -->
          <div class="row side_pad">
            <div class="col-md-12 mg_tp_30">
              <div class="incluExcluTermsTabPanel inclusions main_block">
                  <h3 class="incexTitle">INCLUSIONS</h3>
                  <div class="tabContent">
                      <pre class="real_text"><?= $sq_quotation['inclusions'] ?></pre>
                  </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </section>
    </section>
  <?php } ?>
  
  <?php if($sq_quotation['exclusions'] != '' && $sq_quotation['exclusions'] != ' ' && $sq_quotation['exclusions'] != '<div><br></div>'){ ?>
    <!-- Inclusion -->
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="incluExcluTerms main_block side_pad mg_tp_30 pageSectionInner">

        <?php if($sq_quotation['exclusions'] != '' && $sq_quotation['exclusions'] != ' ' && $sq_quotation['exclusions'] != '<div><br></div>'){?>           
        <!-- Exclusion -->
        <div class="row side_pad">
          <div class="col-md-12 mg_tp_30">
            <div class="incluExcluTermsTabPanel exclusions main_block">
                <h3 class="incexTitle">EXCLUSIONS</h3>
                <div class="tabContent">
                    <pre class="real_text"><?= $sq_quotation['exclusions'] ?></pre>      
                </div>
            </div>
          </div>
        </div>  
      <?php } ?>
      </section>
    </section>
  <?php } ?>

  <!-- Terms and Conditions -->
  <?php if($sq_terms_cond['terms_and_conditions'] != '' || $sq_package_name['note'] != '' || $quot_note!=''){?>
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="incluExcluTerms main_block side_pad mg_tp_30 pageSectionInner">

        <?php
        if($sq_terms_cond['terms_and_conditions']!=''){ ?>
        <div class="row side_pad mg_tp_10">
          <!-- Terms and Conditions -->
          <div class="col-md-10">
            <div class="incluExcluTermsTabPanel inclusions main_block">
                <h3 class="incexTitle">TERMS AND CONDITIONS</h3>
                <div class="tabContent">
                    <pre class="real_text"><?php echo $sq_terms_cond['terms_and_conditions']; ?></pre> 
                </div>
            </div>
          </div>
        </div>
        <?php }
        if($sq_package_name['note']!=''){ ?>
          <!-- Note -->
          <div class="row side_pad">
            <div class="col-md-10 mg_tp_30">
              <div class="incluExcluTermsTabPanel inclusions main_block">
                  <h3 class="incexTitle">NOTE</h3>
                  <div class="tabContent">
                      <pre class="real_text"><?php echo $sq_package_name['note']; ?></pre>
                  </div>
              </div>
            </div>
          </div>
        <?php }
        if($quot_note != ''){ ?>
          <pre class="real_text"><?php echo $quot_note; ?></pre>  
        <?php } ?>
      </section>
    </section>
    <?php } ?>

  <!-- Costing & Banking Page -->
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="endPageSection main_block mg_tp_30 pageSectionInner">

        <div class="row">
          
          <!-- Guest Detail -->
          <div class="col-md-3 passengerPanel endPagecenter mg_bt_30">
            <h3 class="endingPageTitle text-center">TOTAL GUEST</h3>
            <div class="icon">
              <img src="<?= BASE_URL ?>images/quotation/p4/adult.png" class="img-responsive">
              <h4 class="no-marg">Adult : <?= $sq_quotation['total_adult'] ?></h4>
              <i class="fa fa-plus"></i>
            </div>
            <div class="icon">
              <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
              <h4 class="no-marg">CWB/CWOB : <?= $sq_quotation['children_with_bed']+$sq_quotation['children_without_bed'] ?></h4>
              <i class="fa fa-plus"></i>
            </div>
            <div class="icon">
              <img src="<?= BASE_URL ?>images/quotation/p4/infant.png" class="img-responsive">
              <h4 class="no-marg">Infant : <?= $sq_quotation['total_infant'] ?></h4>
            </div>
          </div>
        <div class="col-md-9">
          <!-- Costing -->
          <div class="col-md-12 constingPanel constingBankingPanel mg_bt_30">
            <h3 class="costBankTitle text-center">COSTING DETAILS</h3>
            <!-- Group costing -->
            <?php
            if($sq_quotation['costing_type'] == 1){ ?>
                
              <div class="travsportInfoBlock1">
                <div class="transportDetails_costing">
                <div class="table-responsive">
                  <table class="table table-bordered tableTrnasp no-marg" style="width:100% !important;" id="tbl_emp_list">
                    <thead>
                      <tr class="table-heading-row">
                        <th>Package Type</th>
                        <th>Tour Cost</th>
                        <th>Tax</th>
                        <th>Travel Cost</th>
                        <th>Total Cost</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sq_costing1 = mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id' order by package_type");
                      while($sq_costing = mysqli_fetch_assoc($sq_costing1)){
                        $basic_cost = $sq_costing['basic_amount'];
                        $service_charge = $sq_costing['service_charge'];
                        $tour_cost= $basic_cost + $service_charge;
                        $service_tax_amount = 0;
                        $tax_show = '';
                        $bsmValues = json_decode($sq_costing['bsmValues']);
                        $name = '';
                        if($sq_costing['service_tax_subtotal'] !== 0.00 && ($sq_costing['service_tax_subtotal']) !== ''){
                          $service_tax_subtotal1 = explode(',',$sq_costing['service_tax_subtotal']);
                          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                            $service_tax = explode(':',$service_tax_subtotal1[$i]);
                            $service_tax_amount +=  $service_tax[2];
                            $name .= $service_tax[0] . $service_tax[1] .', ';
                          }
                        }
                        $service_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$service_tax_amount);
                        if($bsmValues[0]->service != ''){   //inclusive service charge
                          $newBasic = $tour_cost + $service_tax_amount;
                          $tax_show = '';
                        }
                        else{
                          $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
                          $newBasic = $tour_cost;
                        }
                        
                        ////////////Basic Amount Rules
                        if($bsmValues[0]->basic != ''){ //inclusive markup
                          $newBasic = $tour_cost + $service_tax_amount;
                          $tax_show = '';
                        }
                        $quotation_cost = $basic_cost + $service_charge + $service_tax_amount + $sq_quotation['train_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
                        ////////////////Currency conversion ////////////
                        $currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
                        
                        $newBasic = currency_conversion($currency,$sq_quotation['currency_code'],$newBasic);
                        $travel_cost = floatval($sq_quotation['train_cost']) + floatval($sq_quotation['flight_cost']) + floatval($sq_quotation['cruise_cost']) + floatval($sq_quotation['visa_cost']) + floatval($sq_quotation['guide_cost'])+ floatval($sq_quotation['misc_cost']);
                        $travel_cost = currency_conversion($currency,$sq_quotation['currency_code'],$travel_cost);
                        ?>
                        <tr>
                          <td><?php echo $sq_costing['package_type']?></td>
                          <td><?= $newBasic ?></td>
                          <td><?= str_replace(',','',$name).$service_tax_amount_show ?></td>
                          <td><?= $travel_cost ?></td>
                          <td><?= $currency_amount1 ?></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                </div>
              </div><!-- group Costing End -->
              <?php
            }
            else{
              ?>
              <div class="travsportInfoBlock1">
                <div class="transportDetails_costing">
                <div class="table-responsive">
                  <table class="table table-bordered tableTrnasp no-marg" style="width:100% !important;" id="tbl_emp_list">
                    <thead>
                      <tr class="table-heading-row">
                        <th>Package Type</th>
                        <th>ADULT(PP)</th>
                        <th>CWB(PP)</th>
                        <th>CWOB(PP)</th>
                        <th>INFANT(PP)</th>
                        <th>TAX</th>
                        <th>TRAVEL/OTHER</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sq_costing1 = mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id'  order by package_type");
                      while($sq_costing = mysqli_fetch_assoc($sq_costing1)){
    
                        $service_charge = $sq_costing['service_charge'];
                        $total_pax = intval($sq_quotation['total_adult'])+intval($sq_quotation['children_with_bed'])+intval($sq_quotation['children_without_bed'])+intval($sq_quotation['total_infant']);
                        $per_service_charge = floatval($service_charge)/floatval($total_pax);
              
                        $adult_cost = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['adult_cost']+floatval($per_service_charge))));
                        $child_with = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['child_with']+floatval($per_service_charge))));
                        $child_without = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['child_without']+floatval($per_service_charge))));
                        $infant_cost = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['infant_cost']+floatval($per_service_charge))));
              
                        $tour_cost= $basic_cost + $service_charge;
                        $service_tax_amount = 0;
                        $tax_show = '';
                        $bsmValues = json_decode($sq_costing['bsmValues']);
                        $name = '';
                        if($sq_costing['service_tax_subtotal'] !== 0.00 && ($sq_costing['service_tax_subtotal']) !== ''){
                          $service_tax_subtotal1 = explode(',',$sq_costing['service_tax_subtotal']);
                          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                            $service_tax = explode(':',$service_tax_subtotal1[$i]);
                            $service_tax_amount +=  $service_tax[2];
                            $name .= $service_tax[0] . $service_tax[1] .', ';
                          }
                        }
                        $service_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$service_tax_amount);
                        if($bsmValues[0]->service != ''){   //inclusive service charge
                          $newBasic = $tour_cost + $service_tax_amount;
                          $tax_show = '';
                        }
                        else{
                          $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
                          $newBasic = $tour_cost;
                        }
                        
                        ////////////Basic Amount Rules
                        if($bsmValues[0]->basic != ''){ //inclusive markup
                          $newBasic = $tour_cost + $service_tax_amount;
                          $tax_show = '';
                        }
    
                        $travel_cost = floatval($sq_quotation['train_cost']) + floatval($sq_quotation['flight_cost']) + floatval($sq_quotation['cruise_cost']) + floatval($sq_quotation['visa_cost']) + floatval($sq_quotation['guide_cost']) + floatval($sq_quotation['misc_cost']);
                        $travel_cost = currency_conversion($currency,$sq_quotation['currency_code'],$travel_cost);
                        $basic_cost = $sq_costing['basic_amount'];
                        $quotation_cost = $basic_cost + $service_charge + $service_tax_amount + $sq_quotation['train_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
                        ////////////////Currency conversion ////////////
                        $currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
                        ?>
                        <tr>
                          <td><?php echo $sq_costing['package_type'].' ('.$currency_amount1.')' ?></td>
                          <td><?= ($sq_quotation['total_adult']!='0')?$adult_cost:number_format(0,2) ?></td>
                          <td><?= ($sq_quotation['children_with_bed']!='0')?$child_with:number_format(0,2) ?></td>
                          <td><?= ($sq_quotation['children_without_bed']!='0')?$child_without:number_format(0,2)  ?></td>
                          <td><?= ($sq_quotation['total_infant']!='0')?$infant_cost:number_format(0,2) ?></td>
                          <td><?= str_replace(',','',$name).$service_tax_amount_show ?></td>
                          <td><?= $travel_cost ?></td>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
            <?php } ?>
            <?php
            $discount1 = currency_conversion($currency,$sq_quotation['currency_code'],$sq_quotation['discount']);
            if($sq_quotation['discount']!=0){ $discount = ' (Applied Discount : '.$discount1.')'; } else{ $discount = ''; }
            ?><p class="costBankTitle mg_tp_10"><?= $discount ?></p>
          <!-- Per person costing End -->
          </div>

          <!-- Bank Detail -->
          <div class="col-md-12 constingBankingPanel BankingPanel">
                <h3 class="costBankTitle text-center">BANK DETAILS</h3>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/bankName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= ($bank_name_setting != '') ? $bank_name_setting : 'NA' ?></h4>
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
                  <h4 class="no-marg"><?= ($bank_swift_code != '') ? $bank_swift_code : 'NA' ?></h4>
                  <p>SWIFT CODE</p>
                </div>
          </div>

        </div>
        </div>

    </section>
  </section>

  <!-- Costing & Banking Page -->
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p6/pageBG.jpg" class="img-responsive pageBGImg">
    <section class="contactSection main_block mg_tp_30 pageSectionInner">
        <div class="contactPanel">
        <div class="companyLogo">
          <img src="<?= $admin_logo_url ?>">
        </div>
        <div class="companyContactDetail">
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
      </div>
    </section>
  </section>

  </body>
</html>