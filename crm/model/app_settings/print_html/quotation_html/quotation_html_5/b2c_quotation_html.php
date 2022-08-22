<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$currency;

$quotation_id = $_GET['quotation_id'];
$emp_id = $_SESSION['emp_id'];
$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
$emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name'];

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from b2c_quotations where entry_id='$quotation_id'"));
$package_id=$sq_quotation['package_id'];
$type = $sq_quotation['type'];

$quotation_date = $sq_quotation['created_at'];
$yr = explode("-", $quotation_date);
$year = $yr[0];

$pax = intval($sq_quotation['adults']) + intval($sq_quotation['chwob']) + intval($sq_quotation['chwb']) + intval($sq_quotation['extra_bed']) + intval($sq_quotation['infant']);

// PDF for Package Tour/Holiday
if($type == '1'){

  $sq_pckg = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$package_id'"));
  $sq_dest = mysqli_fetch_assoc(mysqlQuery("select * from destination_master where dest_id='$sq_pckg[dest_id]'"));
  $sq_dest_link = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_pckg[dest_id]'"));
  $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Quotation' and dest_id='$sq_pckg[dest_id]' and active_flag ='Active'"));

  $currency_id = $sq_pckg['currency_id'];
  $to_currency_id = $currency;
  $total_cost1 = 0;
  $q = "select * from custom_package_tariff where (`from_date` <= '$sq_quotation[travel_from_date]' and `to_date` >= '$sq_quotation[travel_from_date]') and (`min_pax` <= '$pax' and `max_pax` >= '$pax') and `package_id`='$sq_quotation[package_id]' and `hotel_type`='$sq_quotation[package_type]' ";
  $sq_tariff = mysqlQuery($q);
  while($row_tariff = mysqli_fetch_assoc($sq_tariff)){
    
    $total_cost1 = ($sq_quotation['adults']*floatval($row_tariff['cadult'])) + ($sq_quotation['chwob']*floatval($row_tariff['ccwob'])) + ($sq_quotation['chwb']*floatval($row_tariff['ccwb'])) + ($sq_quotation['infant']*floatval($row_tariff['cinfant'])) + ($sq_quotation['extra_bed']*floatval($row_tariff['cextra']));
  }
  if($total_cost1 == '0'){
    $quotation_cost = 'On Request';
  }else{
    
    $quotation_cost = currency_conversion($currency_id,$to_currency_id,$total_cost1);
    $quotation_cost .= ' (+Tax)';
  }
  ?>

      <!-- landingPage -->
      <section class="landingSec main_block">
        <div class="col-md-8 no-pad">
          <img src="<?= $app_quot_img?>" class="img-responsive">
          <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
        </div>
        <div class="col-md-4 no-pad">
        </div>
        <h1 class="landingpageTitle"><?= $sq_pckg['package_name'] ?><?=' ('.$sq_pckg['package_code'].')' ?></h1>
        <div class="packageDeatailPanel">
          <div class="landingPageBlocks">
          
              <div class="detailBlock">
                <div class="detailBlockIcon detailBlockBlue">
                  <i class="fa fa-map-marker"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= $sq_dest['dest_name'] ?></h3>
                  <span class="contentLabel">DESTINATION</span>
                </div>
              </div>

              <div class="detailBlock">
                <div class="detailBlockIcon">
                  <i class="fa fa-calendar"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= get_datetime_user($sq_quotation['created_at']) ?></h3>
                  <span class="contentLabel">QUOTATION DATE/TIME</span>
                </div>
              </div>
              
              <div class="detailBlock">
                <div class="detailBlockIcon detailBlockGreen">
                  <i class="fa fa-users"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= $pax ?></h3>
                  <span class="contentLabel">TOTAL GUEST</span>
                </div>
              </div>

              <div class="detailBlock">
                <div class="detailBlockIcon detailBlockGreen">
                  <i class="fa fa-moon-o"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= $sq_pckg['total_nights'].'N/'.$sq_pckg['total_days'].'D' ?></h3>
                  <span class="contentLabel">DURATION</span>
                </div>
              </div>
          </div>

          <div class="landigPageCustomer">
            <h3 class="customerFrom">Prepared for</h3>
            <span class="customerName"><em><i class="fa fa-user"></i></em> : <?= $sq_quotation['name'] ?></span><br>
            <span class="customerMail"><em><i class="fa fa-envelope"></i></em> : <?= $sq_quotation['email'] ?></span><br>
            <span class="customerMobile"><em><i class="fa fa-phone"></i></em> : <?= $sq_quotation['phone'] ?></span>
          </div>
        </div>
      </section>

      <!-- Itinerary -->
      <?php 
        $count = 1;
        $checkPageEnd = 0;
        $sq_package_program = mysqlQuery("select * from custom_package_program where package_id = '$package_id'");
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
          if($checkPageEnd%2==0 || $checkPageEnd==0){
            $go = $checkPageEnd + 2;
            $flag = 0;
            ?>
            <section class="pageSection main_block">
              
            <!-- background Image -->
            <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

            <section class="itinerarySec pageSectionInner main_block mg_tp_30">
            <?php if($checkPageEnd==0){ ?>
              <div class="vitinerary_div" style="margin-bottom:20px!important;">
                <h6>Destination Guide Video</h6>
                <img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive"><br/>
                <a href="<?=$sq_dest_link['link']?>" class="no-marg" target="_blank"></a>
              </div>
              <?php }
          }
            ?>
            <section class="print_single_itinenary leftItinerary">
                <div class="itneraryImg">
                  <div class="itneraryImgblock">
                    <img src="<?= $daywise_image ?>" class="img-responsive">
                  </div>
                  <div class="itneraryText">
                    <div class="itneraryDayInfo">
                      <i class="fa fa-map-marker" aria-hidden="true"></i><span> Day <?= $count ?> : <?= $row_itinarary['attraction'] ?> </span>
                    </div>
                    <div class="itneraryDayPlan">
                      <p><?= $row_itinarary['day_wise_program'] ?></p>
                    </div>
                  </div>
                </div>
                  <div class="itneraryDayAccomodation">
                    <span><i class="fa fa-bed"></i> : <?=  $row_itinarary['stay'] ?></span>
                    <span><i class="fa fa-cutlery"></i> : <?= $row_itinarary['meal_plan'] ?></span>
                  </div>
            </section>

            <?php 
            if($go == $checkPageEnd){
              $flag = 1;
              ?>

              </section>
              </section>
              <?php
            }
          $count++;
          $checkPageEnd++; 
        }
        if($flag == 0){
          ?>
          </section>
          </section>
        <?php } ?>


        <?php
      $sq_hotelc = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id='$package_id'"));
      if($sq_hotelc!=0){ ?>
      <!-- traveling Information -->
      <section class="pageSection main_block">
        <!-- background Image -->
        <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

        <section class="travelingDetails main_block mg_tp_30 pageSectionInner">

          <!-- Hotel -->
          <section class="transportDetailsPanel transportDetailsleft main_block">
            <div class="travsportInfoBlock">
              <div class="transportIcon">
                <img src="<?= BASE_URL ?>images/quotation/p4/TI_hotel.png" class="img-responsive">
              </div>
              <div class="transportDetails">
              <div class="col-md-12 no-pad">
                  <div class="table-responsive">
                    <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                    <thead>
                        <tr class="table-heading-row">
                        <th>City</th>
                        <th>Hotel Name</th>
                        <th>Hotel_category</th>
                        <th>Total Nights</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $sq_hotel = mysqlQuery("select * from custom_package_hotels where package_id='$package_id'");
                        while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                          $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
                          $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_name]'"));
                        ?>
                          
                        <tr>
                            <?php

                            $sql = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$row_hotel[hotel_name]'"));
                            $sq_count_h = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id='$package_id' "));
                            if($sq_count_h ==0){
                              $download_url =  BASE_URL.'images/dummy-image.jpg';
                            }
                            else{  
                                  $image = $sql['hotel_pic_url']; 
                                  $download_url = preg_replace('/(\/+)/','/',$image);
                            }
                            ?>
                            <td><?php echo $city_name['city_name']; ?></td>
                            <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                            <td></span><?php echo $row_hotel['hotel_type']; ?></td>
                            <td></span><?php echo $row_hotel['total_days']; ?></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Hotel END -->
          <!-- Transport -->
          <?php
          $sq_hotelt = mysqli_num_rows(mysqlQuery("select * from custom_package_transport where package_id='$package_id'"));
          if($sq_hotelt!=0){?>
            <section class="transportDetailsPanel transportDetailsleft main_block mg_tp_20">
              <div class="travsportInfoBlock">
                <div class="transportIcon">
                  <img src="<?= BASE_URL ?>images/quotation/p4/TI_car.png" class="img-responsive">
                </div>
                <div class="transportDetails">
                <div class="col-md-12 no-pad">
                    <div class="table-responsive">
                      <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                      <thead>
                          <tr class="table-heading-row">
                            <th>VEHICLE</th>
                            <th>Pickup_Location</th>
                            <th>Dropoff_Location</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $count = 0;
                          $sq_hotel = mysqlQuery("select * from custom_package_transport where package_id='$package_id'");
                          while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                            $transport_name = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id ='$row_hotel[vehicle_name]'"));
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
                              $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
                            }
                            // Drop
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
                              $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
                            }
                            ?>
                            <tr>
                              <td><?= $transport_name['vehicle_name'].$similar_text ?></td>
                              <td><?= $pickup ?></td>
                              <td><?= $drop ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                </div>
              </div>
            </section>
          <?php } ?>
          <!-- Transport END -->
        </section>
      </section>
      <?php } ?>
    <!-- Inclusion -->
    <?php
    if($sq_pckg['inclusions'] != '' && $sq_pckg['inclusions'] != ' ' && $sq_pckg['inclusions'] != '<div><br></div>'){ ?>
      <section class="pageSection main_block">
        <!-- background Image -->
          <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

          <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

            <!-- Inclusion -->
            <?php if($sq_pckg['inclusions'] != ' '){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Inclusions</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_pckg['inclusions'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </section>
      </section>
    <?php } ?>
    <!-- Exclusions / Note -->
    <?php
    if(($sq_pckg['exclusions'] != '' && $sq_pckg['exclusions'] != ' ' && $sq_pckg['exclusions'] != '<div><br></div>') || $sq_pckg['note'] != '' && $sq_pckg['note'] != ' '){ ?>
      <section class="pageSection main_block">
        <!-- background Image -->
          <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

          <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

            <!-- Exclusion -->
            <?php if($sq_pckg['exclusions'] != ' '){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Exclusions</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_pckg['exclusions'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>
            <!-- Note -->
            <?php if($sq_pckg['note'] != ' '){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Note</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_pckg['note'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </section>
      </section>
    <?php } ?>
    <!-- TNC -->
    <?php
    if($sq_terms_cond['terms_and_conditions'] != ''){ ?>
      <section class="pageSection main_block">
        <!-- background Image -->
          <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

          <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

            <!-- Note -->
            <?php if($sq_terms_cond['terms_and_conditions'] != ''){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Terms & Conditions</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_terms_cond['terms_and_conditions'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>

          </section>
      </section>
    <?php } ?>
<?php }

// PDF for Group Tour
else if($type == '2'){

  $sq_pckg = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id = '$package_id'"));
  $sq_dest = mysqli_fetch_assoc(mysqlQuery("select * from destination_master where dest_id='$sq_pckg[dest_id]'"));
  $sq_dest_link = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_pckg[dest_id]'"));
  $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Group Quotation' and active_flag ='Active'"));

  $currency_id = $currency;
  $to_currency_id = $currency;
  $total_cost1 = 0;
  
  $date1_ts = strtotime($sq_quotation['travel_from_date']);
  $date2_ts = strtotime($sq_quotation['travel_to_date']);
  $diff = $date2_ts - $date1_ts;
  $days = round($diff / 86400);
  
  $adult_cost_total = intval($sq_quotation['adults']) * floatval($sq_pckg['adult_cost']);
  $child_without_cost_total = intval($sq_quotation['chwob']) * floatval($sq_pckg['child_without_cost']);
  $child_with_cost_total = intval($sq_quotation['chwb']) * floatval($sq_pckg['child_with_cost']);
  $with_bed_cost_total = intval($sq_quotation['extra_bed']) * floatval($sq_pckg['with_bed_cost']);
  $infant_cost_total = intval($sq_quotation['infant']) * floatval($sq_pckg['infant_cost']);

  $total_cost1 = floatval($adult_cost_total) + floatval($child_without_cost_total) + floatval($child_with_cost_total) + floatval($infant_cost_total) + floatval($with_bed_cost_total);
  
  if($total_cost1 == '0'){
    $quotation_cost = 'On Request';
  }
  else{
    $quotation_cost = currency_conversion($currency_id,$to_currency_id,$total_cost1);
    $quotation_cost .= ' (+Tax)';
  }
  ?>

      <!-- landingPage -->
      <section class="landingSec main_block">
        <div class="col-md-8 no-pad">
          <img src="<?= $app_quot_img?>" class="img-responsive">
          <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
        </div>
        <div class="col-md-4 no-pad">
        </div>
        <h1 class="landingpageTitle"><?= $sq_pckg['tour_name'] ?></h1>
        <div class="packageDeatailPanel">
          <div class="landingPageBlocks">
          
              <div class="detailBlock">
                <div class="detailBlockIcon detailBlockBlue">
                  <i class="fa fa-map-marker"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= $sq_dest['dest_name'] ?></h3>
                  <span class="contentLabel">DESTINATION</span>
                </div>
              </div>

              <div class="detailBlock">
                <div class="detailBlockIcon">
                  <i class="fa fa-calendar"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= get_datetime_user($sq_quotation['created_at']) ?></h3>
                  <span class="contentLabel">QUOTATION DATE/TIME</span>
                </div>
              </div>
              
              <div class="detailBlock">
                <div class="detailBlockIcon detailBlockGreen">
                  <i class="fa fa-users"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= $pax ?></h3>
                  <span class="contentLabel">TOTAL GUEST</span>
                </div>
              </div>

              <div class="detailBlock">
                <div class="detailBlockIcon detailBlockGreen">
                  <i class="fa fa-moon-o"></i>
                </div>
                <div class="detailBlockContent">
                  <h3 class="contentValue"><?= $days.'N/'.($days+1).'D' ?></h3>
                  <span class="contentLabel">DURATION</span>
                </div>
              </div>
          </div>

          <div class="landigPageCustomer">
            <h3 class="customerFrom">Prepared for</h3>
            <span class="customerName"><em><i class="fa fa-user"></i></em> : <?= $sq_quotation['name'] ?></span><br>
            <span class="customerMail"><em><i class="fa fa-envelope"></i></em> : <?= $sq_quotation['email'] ?></span><br>
            <span class="customerMobile"><em><i class="fa fa-phone"></i></em> : <?= $sq_quotation['phone'] ?></span>
          </div>
        </div>
      </section>

      <!-- Itinerary -->
      <?php 
        $count = 1;
        $checkPageEnd = 0;
        $sq_package_program = mysqlQuery("select * from group_tour_program where tour_id = '$package_id'");
        while($row_itinarary = mysqli_fetch_assoc($sq_package_program)){
          
          $sq_day_image = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_images where quotation_id='$row_itinarary[quotation_id]'"));
          $daywise_image = $row_itinarary['daywise_images'];
          if($daywise_image == ''){
            $daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
          }
          // for($count1 = 0; $count1<sizeof($day_url1);$count1++){
          //     $day_url2 = explode('=',$day_url1[$count1]);
          //     if($day_url2[1]==$row_itinarary['day_count'] && $day_url2[0]==$row_itinarary['package_id']){
          //       $daywise_image = $day_url2[2];
          //     }
          // }
          if($checkPageEnd%2==0 || $checkPageEnd==0){
            $go = $checkPageEnd + 2;
            $flag = 0;
            ?>
            <section class="pageSection main_block">
              
            <!-- background Image -->
            <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

            <section class="itinerarySec pageSectionInner main_block mg_tp_30">
            <?php if($checkPageEnd==0){ ?>
              <div class="vitinerary_div" style="margin-bottom:20px!important;">
                <h6>Destination Guide Video</h6>
                <img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive"><br/>
                <a href="<?=$sq_dest_link['link']?>" class="no-marg" target="_blank"></a>
              </div>
              <?php }
          }
            ?>
            <section class="print_single_itinenary leftItinerary">
                <div class="itneraryImg">
                  <div class="itneraryImgblock">
                    <img src="<?= $daywise_image ?>" class="img-responsive">
                  </div>
                  <div class="itneraryText">
                    <div class="itneraryDayInfo">
                      <i class="fa fa-map-marker" aria-hidden="true"></i><span> Day <?= $count ?> : <?= $row_itinarary['attraction'] ?> </span>
                    </div>
                    <div class="itneraryDayPlan">
                      <p><?= $row_itinarary['day_wise_program'] ?></p>
                    </div>
                  </div>
                </div>
                  <div class="itneraryDayAccomodation">
                    <span><i class="fa fa-bed"></i> : <?=  $row_itinarary['stay'] ?></span>
                    <span><i class="fa fa-cutlery"></i> : <?= $row_itinarary['meal_plan'] ?></span>
                  </div>
            </section>

            <?php 
            if($go == $checkPageEnd){
              $flag = 1;
              ?>

              </section>
              </section>
              <?php
            }
          $count++;
          $checkPageEnd++; 
        }
        if($flag == 0){
          ?>
          </section>
          </section>
        <?php } ?>
      <?php
      $sq_hotelc = mysqli_num_rows(mysqlQuery("select * from group_tour_hotel_entries where tour_id ='$package_id'"));
      if($sq_hotelc!=0){ ?>
      <!-- traveling Information -->
      <section class="pageSection main_block">
        <!-- background Image -->
        <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

        <section class="travelingDetails main_block mg_tp_30 pageSectionInner">

          <!-- Hotel -->
          <section class="transportDetailsPanel transportDetailsleft main_block">
            <div class="travsportInfoBlock">
              <div class="transportIcon">
                <img src="<?= BASE_URL ?>images/quotation/p4/TI_hotel.png" class="img-responsive">
              </div>
              <div class="transportDetails">
              <div class="col-md-12 no-pad">
                  <div class="table-responsive">
                    <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                    <thead>
                        <tr class="table-heading-row">
                        <th>City</th>
                        <th>Hotel Name</th>
                        <th>Hotel Type</th>
                        <th>Total Nights</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $sq_hotel = mysqlQuery("select * from group_tour_hotel_entries where tour_id='$package_id'");
                        while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                          $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_id]'"));
                          $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_id]'"));
                        ?>
                          
                        <tr>
                            <?php
                            ?>
                            <td><?php echo $city_name['city_name']; ?></td>
                            <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                            <td></span><?php echo $row_hotel['hotel_type']; ?></td>
                            <td></span><?php echo $row_hotel['total_nights']; ?></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Hotel END -->
          <!-- Train -->
          <?php
          $sq_hotelt = mysqli_num_rows(mysqlQuery("select * from group_train_entries where tour_id='$package_id'"));
          if($sq_hotelt!=0){?>
            <section class="transportDetailsPanel transportDetailsleft main_block mg_tp_20">
              <div class="travsportInfoBlock">
                <div class="transportIcon">
                  <img src="<?= BASE_URL ?>images/quotation/p4/TI_train.png" class="img-responsive">
                </div>
                <div class="transportDetails">
                <div class="col-md-12 no-pad">
                    <div class="table-responsive">
                      <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                      <thead>
                          <tr class="table-heading-row">
                            <th>From_Location</th>
                            <th>To_Location</th>
                            <th>Class</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $count = 0;
                          $sq_hotel = mysqlQuery("select * from group_train_entries where tour_id='$package_id'");
                          while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                            ?>
                            <tr>
                              <td><?= $row_hotel['from_location'].$similar_text ?></td>
                              <td><?= $row_hotel['to_location'] ?></td>
                              <td><?= $row_hotel['class'] ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                </div>
              </div>
            </section>
          <?php } ?>
          <!-- Train END -->
          <!-- Flight -->
          <?php
          $sq_hotelt = mysqli_num_rows(mysqlQuery("select * from group_tour_plane_entries where tour_id='$package_id'"));
          if($sq_hotelt!=0){?>
            <section class="transportDetailsPanel transportDetailsleft main_block mg_tp_20">
              <div class="travsportInfoBlock">
                <div class="transportIcon">
                  <img src="<?= BASE_URL ?>images/quotation/p4/TI_flight.png" class="img-responsive">
                </div>
                <div class="transportDetails">
                <div class="col-md-12 no-pad">
                    <div class="table-responsive">
                      <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                      <thead>
                          <tr class="table-heading-row">
                            <th>From_Location</th>
                            <th>To_Location</th>
                            <th>Airline</th>
                            <th>Class</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $count = 0;
                          $sq_hotel = mysqlQuery("select * from group_tour_plane_entries where tour_id='$package_id'");
                          while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                            $sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_hotel[airline_name]'"));
                            $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_hotel[from_city]'"));
                            $sq_city1 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_hotel[to_city]'"));
                            ?>
                            <tr>
                              <td><?= $sq_city['city_name'].' ('.$row_hotel['from_location'].')' ?></td>
                              <td><?= $sq_city1['city_name'].' ('.$row_hotel['to_location'].')' ?></td>
                              <td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>
                              <td><?= $row_hotel['class'] ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                </div>
              </div>
            </section>
          <?php } ?>
          <!-- Flight END -->
          <!-- Cruise -->
          <?php
          $sq_hotelt = mysqli_num_rows(mysqlQuery("select * from group_cruise_entries where tour_id ='$package_id'"));
          if($sq_hotelt!=0){?>
            <section class="transportDetailsPanel transportDetailsleft main_block mg_tp_20">
              <div class="travsportInfoBlock">
                <div class="transportIcon">
                  <img src="<?= BASE_URL ?>images/quotation/p4/TI_cruise.png" class="img-responsive">
                </div>
                <div class="transportDetails">
                <div class="col-md-12 no-pad">
                    <div class="table-responsive">
                      <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                      <thead>
                          <tr class="table-heading-row">
                            <th>Route</th>
                            <th>Cabin</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          $count = 0;
                          $sq_hotel = mysqlQuery("select * from group_cruise_entries where tour_id ='$package_id'");
                          while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                            ?>
                            <tr>
                              <td><?= $row_hotel['route'] ?></td>
                              <td><?= $row_hotel['cabin'] ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                </div>
              </div>
            </section>
          <?php } ?>
          <!-- Cruise END -->
        </section>
      </section>
      <?php } ?>
    <!-- Inclusion -->
    <?php
    if($sq_pckg['inclusions'] != '' && $sq_pckg['inclusions'] != ' ' && $sq_pckg['inclusions'] != '<div><br></div>'){ ?>
      <section class="pageSection main_block">
        <!-- background Image -->
          <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

          <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

            <!-- Inclusion -->
            <?php if($sq_pckg['inclusions'] != ' '){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Inclusions</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_pckg['inclusions'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </section>
      </section>
    <?php } ?>
    <!-- Exclusions / Note -->
    <?php
    if(($sq_pckg['exclusions'] != '' && $sq_pckg['exclusions'] != ' ' && $sq_pckg['exclusions'] != '<div><br></div>')){ ?>
      <section class="pageSection main_block">
        <!-- background Image -->
          <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

          <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

            <!-- Exclusion -->
            <?php if($sq_pckg['exclusions'] != ' '){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Exclusions</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_pckg['exclusions'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </section>
      </section>
    <?php } ?>
    <!-- TNC -->
    <?php
    if($sq_terms_cond['terms_and_conditions'] != ''){ ?>
      <section class="pageSection main_block">
        <!-- background Image -->
          <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

          <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

            <!-- Note -->
            <?php if($sq_terms_cond['terms_and_conditions'] != ''){?>
              <div class="row">
                <div class="col-md-12 mg_tp_30 mg_bt_30">
                  <div class="incluExcluTermsTabPanel exclusions main_block">
                      <h3 class="incexTitle">Terms & Conditions</h3>
                      <div class="tabContent">
                          <pre class="real_text"><?= $sq_terms_cond['terms_and_conditions'] ?></pre>      
                      </div>
                  </div>
                </div>
              </div>
            <?php } ?>

          </section>
      </section>
    <?php } ?>
<?php } ?>


  <!-- Costing & Banking Page -->
  <section class="endPageSection main_block mg_tp_30">

    <div class="row">
      
      <!-- Guest Detail -->
      <div class="col-md-12 passengerPanel endPagecenter mg_bt_30">
        <h3 class="endingPageTitle text-center">Total Guest</h3>
        <div class="col-md-3 text-center mg_bt_30">
          <div class="iconPassengerBlock">
            <div class="iconPassengerSide leftSide"></div>
            <div class="iconPassenger">
              <img src="<?= BASE_URL ?>images/quotation/p4/adult.png" class="img-responsive">
              <h4 class="no-marg">Adult : <?= $sq_quotation['adults']+$sq_quotation['extra_bed'] ?></h4>
            </div>
            <div class="iconPassengerSide rightSide"></div>
          </div>
        </div>
        <div class="col-md-3 text-center mg_bt_30">
          <div class="iconPassengerBlock">
            <div class="iconPassengerSide leftSide"></div>
            <div class="iconPassenger">
              <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
              <h4 class="no-marg">CWB : <?= $sq_quotation['chwb'] ?></h4>
            </div>
            <div class="iconPassengerSide rightSide"></div>
            <i class="fa fa-plus"></i>
          </div>
        </div>
        <div class="col-md-3 text-center mg_bt_30">
          <div class="iconPassengerBlock">
            <div class="iconPassengerSide leftSide"></div>
            <div class="iconPassenger">
              <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
              <h4 class="no-marg">CWOB : <?= $sq_quotation['chwob'] ?></h4>
            </div>
            <div class="iconPassengerSide rightSide"></div>
            <i class="fa fa-plus"></i>
          </div>
        </div>
        <div class="col-md-3 text-center mg_bt_30">
          <div class="iconPassengerBlock">
            <div class="iconPassengerSide leftSide"></div>
            <div class="iconPassenger">
              <img src="<?= BASE_URL ?>images/quotation/p4/infant.png" class="img-responsive">
              <h4 class="no-marg">Infant : <?= $sq_quotation['infant'] ?></h4>
            </div>
            <div class="iconPassengerSide rightSide"></div>
            <i class="fa fa-plus"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 passengerPanel endPagecenter">
      <h3 class="endingPageTitle text-center">Enquiry Details</h3>
      <div class="travsportInfoBlock1">
        <div class="transportDetails_costing">
        <div class="table-responsive">
          <table class="table table-bordered tableTrnasp no-marg" style="width:100% !important;" id="tbl_emp_list">
            <tr><td style="text-align:left;border: 1px solid #888888;font"><b>Package Type</b></td>   <td style="text-align:left;border: 1px solid #888888;"><?= $sq_quotation['package_type'] ?></td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"><b>Travel Date</b></td>   <td style="text-align:left;border: 1px solid #888888;"><?= get_date_user($sq_quotation['travel_from_date']).' To '.get_date_user($sq_quotation['travel_to_date']) ?></td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"><b>Specification</b></td>   <td style="text-align:left;border: 1px solid #888888;"><?= ($sq_quotation['specification']!='') ? $sq_quotation['specification'] : 'NA' ?></td></tr>
          </table>
        </div>
        </div>
      </div>
    </div>
    <!-- Costing -->
    <h3 class="no-pad endingPageTitle" style="margin-left:25px!important;">Quotation Cost: <?=$quotation_cost?> </h3>
    <?php if($quot_note != ''){?>
            <h6 class="no-pad endingPageTitle" style="margin-left:25px!important;"><?php echo $quot_note; ?></h6>
    <?php } ?>
    <!-- Bank Detail -->
    <div class="col-md-12 passengerPanel endPagecenter mg_bt_30">
      <h3 class="endingPageTitle text-center">Bank Details</h3>
      <div class="travsportInfoBlock1">
        <div class="transportDetails_costing">
        <div class="table-responsive">
          <table class="table table-bordered tableTrnasp no-marg" style="width:100% !important;" id="tbl_emp_list">
            <thead>
              <tr>
                <th>BANK NAME</th>
                <th>BRANCH NAME</th>
                <th>A/C NAME</th>
                <th>A/C NO</th>
                <th>IFSC</th>
                <th>SWIFT CODE</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?= ($bank_name_setting != '') ? $bank_name_setting : 'NA' ?></td>
                <td><?= ($bank_branch_name!= '') ? $bank_branch_name : 'NA' ?></td>
                <td><?= ($acc_name != '') ? $acc_name : 'NA' ?></td>
                <td><?= ($bank_acc_no != '') ? $bank_acc_no : 'NA' ?></td>
                <td><?= ($bank_ifsc_code != '') ? $bank_ifsc_code : 'NA' ?></td>
                <td><?= ($bank_swift_code != '') ? $bank_swift_code : 'NA' ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>

  </section>

  <!-- Contact Page -->
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

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