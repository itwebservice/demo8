<?php
include "../../../model.php"; 
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");
global $currency_code,$currency;

$booking_id = $_GET['booking_id'];
$credit_card_charges = $_GET['credit_card_charges'];

$charge = ($credit_card_charges!='')?$credit_card_charges:0 ;


$package_booking_info = mysqli_fetch_assoc(mysqlQuery("select *  from b2c_sale where booking_id='$booking_id' "));

$enq_data = json_decode($package_booking_info['enq_data']);
$costing_data = json_decode($package_booking_info['costing_data']);
$guest_data = json_decode($package_booking_info['guest_data']);

//Total days
$total_days1=strtotime($enq_data[0]->travel_to) - strtotime($enq_data[0]->travel_from);
$total_days = round($total_days1 / 86400);
// Total guest
$total_guest = intval($enq_data[0]->adults) + intval($enq_data[0]->chwob) + intval($enq_data[0]->chwb) + intval($enq_data[0]->infant) + intval($enq_data[0]->extra_bed);

$package_id = $enq_data[0]->package_id;
$tour_name = $enq_data[0]->package_name;
if($package_booking_info['service'] == 'Holiday'){

  $sq_pckg = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$package_id'"));
  $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Sale' and active_flag ='Active'"));
}
elseif($package_booking_info['service'] == 'Group Tour'){

  $sq_pckg = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id = '$package_id'"));
  $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Group Sale' and active_flag ='Active'"));
}
$inclusions = $sq_pckg['inclusions'];
$exclusions = $sq_pckg['exclusions'];

$_SESSION['generated_by'] = $app_name;
$booking_date = get_date_user($package_booking_info['created_at']);
$yr = explode("-", $package_booking_info['created_at']);
$year = $yr[0];
$net_amount = $costing_data[0]->net_total;
$net_amount = currency_conversion($currency,$currency,$net_amount);
?>

    <!-- header -->
    <section class="print_header main_block">
      <div class="col-md-4 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> CONFIRMATION FORM</span>
        <div class="print_header_logo">
          <img src="<?php echo $admin_logo_url; ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-8 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo $app_address ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $app_contact_no ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>
        </div>
      </div>
    </section>

    <!-- print-detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-calendar" aria-hidden="true"></i><br>
                  <span>BOOKING DATE</span><br>
                  <?= $booking_date ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                  <span>DURATION</span><br>
                    <?php echo ($total_days).'N/'.($total_days+1).'D'; ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-users" aria-hidden="true"></i><br>
                  <span>TOTAL GUEST (s)</span><br>
                  <?php echo $total_guest; ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-tags" aria-hidden="true"></i><br>
                  <span>PRICE</span><br>
                  <?=  $net_amount ?><br>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Package -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>BOOKING DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>TOUR NAME :</span> <?= $tour_name ?> </li>
            <li><span>CUSTOMER NAME :</span> <?= $package_booking_info['name'] ?></li>
            <li><span>CONTACT NUMBER :</span> <?= $package_booking_info['phone_no'] ?></li>
          </ul>
        </div>
        <div class="col-md-5 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>TOUR DATE :</span> <?= $enq_data[0]->travel_from.' To '.$enq_data[0]->travel_to ?></li>
            <li><span>BOOKING ID :</span> <?= get_b2c_booking_id($booking_id,$year) ?></li>
          </ul>
        </div>
      </div>
    </section>

    
    <!-- Passenger -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>PASSENGERS</h2>
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
                <th>Adolescence</th>
                <th>Full_Name</th>
                <th>DOB</th>
              </tr>
            </thead>
            <tbody>
            <?php
              for($i=0;$i<sizeof($guest_data[0]->adult);$i++){
              ?>   
                  <tr>
                    <td>Adult</td>
                    <td><?php echo $guest_data[0]->adult[$i]->honorific.' '.$guest_data[0]->adult[$i]->first_name.' '.$guest_data[0]->adult[$i]->last_name; ?></td>
                    <td><?php echo ($guest_data[0]->adult[$i]->birthdate!='') ? $guest_data[0]->adult[$i]->birthdate : 'NA'; ?></td>
                  </tr>
            <?php
            } ?>
            <?php
              $guest_data[0]->chwob = ($guest_data[0]->chwob != '') ? $guest_data[0]->chwob : [];
              for($i=0;$i<sizeof($guest_data[0]->chwob);$i++){
              ?>   
                  <tr>
                    <td>Child w/o bed</td>
                    <td><?php echo $guest_data[0]->chwob[$i]->honorific.' '.$guest_data[0]->chwob[$i]->first_name.' '.$guest_data[0]->chwob[$i]->last_name; ?></td>
                    <td><?php echo ($guest_data[0]->chwob[$i]->birthdate!='') ? $guest_data[0]->chwob[$i]->birthdate : 'NA'; ?></td>
                  </tr>
            <?php
            } ?>
            <?php
              $guest_data[0]->chwb = ($guest_data[0]->chwb != '') ? $guest_data[0]->chwb : [];
              for($i=0;$i<sizeof($guest_data[0]->chwb);$i++){
              ?>   
                  <tr>
                    <td>Child with bed</td>
                    <td><?php echo $guest_data[0]->chwb[$i]->honorific.' '.$guest_data[0]->chwb[$i]->first_name.' '.$guest_data[0]->chwb[$i]->last_name; ?></td>
                    <td><?php echo ($guest_data[0]->chwb[$i]->birthdate!='') ? $guest_data[0]->chwb[$i]->birthdate : 'NA'; ?></td>
                  </tr>
            <?php
            } ?>
            <?php
                $guest_data[0]->extra_bed = ($guest_data[0]->extra_bed != '') ? $guest_data[0]->extra_bed : [];
              for($i=0;$i<sizeof($guest_data[0]->extra_bed);$i++){
              ?>   
                <tr>
                <td>Extra Bed</td>
                <td><?php echo $guest_data[0]->extra_bed[$i]->honorific.' '.$guest_data[0]->extra_bed[$i]->first_name.' '.$guest_data[0]->infant[$i]->last_name; ?></td>
                <td><?php echo ($guest_data[0]->extra_bed[$i]->birthdate!='') ? $guest_data[0]->extra_bed[$i]->birthdate : 'NA'; ?></td>
                </tr>
            <?php
            } ?>
            <?php
              $guest_data[0]->infant = ($guest_data[0]->infant != '') ? $guest_data[0]->infant : [];
              for($i=0;$i<sizeof($guest_data[0]->infant);$i++){
              ?>   
                  <tr>
                    <td>Infant</td>
                    <td><?php echo $guest_data[0]->infant[$i]->honorific.' '.$guest_data[0]->infant[$i]->first_name.' '.$guest_data[0]->infant[$i]->last_name; ?></td>
                    <td><?php echo ($guest_data[0]->infant[$i]->birthdate!='') ? $guest_data[0]->infant[$i]->birthdate : 'NA'; ?></td>
                  </tr>
            <?php
            } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>
    <?php
    if($package_booking_info['service'] == 'Holiday'){
      ?>
        <!-- Accommodation -->
        <?php
        $sq_count = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id='$package_id'"));
        if($sq_count != 0){
        ?>
        <section class="print_sec main_block">
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
                    <th>Hotel_Name</th>
                    <th>Hotel_Category</th>
                    <th>Total_Night(s)</th>
                  </tr>
                </thead>
                <tbody>   
                <?php 
                $sq_hotel = mysqlQuery("select * from custom_package_hotels where package_id='$package_id'");
                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                  $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
                  $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_name]'"));
                  ?>
                  <tr>
                    <td><?php echo $city_name['city_name']; ?></td>
                    <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                    <td><?php echo $row_hotel['hotel_type']; ?></td>
                    <td></span><?php echo $row_hotel['total_days']; ?></td>
                  </tr>
                  <?php 
                  } ?>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <!-- transport -->
        <?php
        $sq_count = mysqli_num_rows(mysqlQuery("select * from custom_package_transport where package_id='$package_id'"));
        if($sq_count != 0){
        ?>
        <section class="print_sec main_block">
          <div class="section_heding">
            <h2>TRANSPORT</h2>
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
                    <th>VEHICLE</th>
                    <th>Pickup_Location</th>
                    <th>Dropoff_LOcation</th>
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
        </section>
        <?php } ?>

      <!-- Tour Itinenary -->
      <section class="print_sec main_block side_pad mg_tp_30">
        <div class="section_heding">
          <h2>TOUR ITINERARY</h2>
          <div class="section_heding_img">
            <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="print_itinenary main_block no-pad no-marg">          
            <?php
            $count = 1;
            $sq_package_program = mysqlQuery("select * from custom_package_program where package_id = '$package_id'");
            while($row_itinarary = mysqli_fetch_assoc($sq_package_program)){
              ?>
              <section class="print_single_itinenary main_block">
                <div class="print_itinenary_count print_info_block">DAY - <?php echo $count++; ?></div>
                <div class="print_itinenary_desciption print_info_block">
                  <div class="print_itinenary_attraction">
                    <span class="print_itinenary_attraction_icon"><i class="fa fa-map-marker"></i></span>
                    <samp class="print_itinenary_attraction_location"><?= $row_itinarary['attraction'] ?></samp>
                  </div>
                  <p><?= $row_itinarary['day_wise_program'] ?></p>
                </div>
                <div class="print_itinenary_details">
                  <div class="print_info_block">
                    <ul class="main_block no-pad">
                      <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-bed"></i> : </span><?= $row_itinarary['stay'] ?></li>
                      <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
                    </ul>
                  </div>
                </div>
              </section>
            <?php } ?>
            </div>
          </div>
        </div>
      </section>
    <?php } ?>

    <?php
    if($package_booking_info['service'] == 'Group Tour'){
      ?>
        <!-- Accommodation -->
        <?php
        $sq_count = mysqli_num_rows(mysqlQuery("select * from group_tour_hotel_entries where tour_id='$package_id'"));
        if($sq_count != 0){
        ?>
        <section class="print_sec main_block">
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
                    <th>Hotel_Name</th>
                    <th>Hotel_Category</th>
                    <th>Total_Night(s)</th>
                  </tr>
                </thead>
                <tbody>   
                <?php 
                $sq_hotel = mysqlQuery("select * from group_tour_hotel_entries where tour_id='$package_id'");
                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
                  $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_id]'"));
                  $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_id]'"));
                  ?>
                  <tr>
                    <td><?php echo $city_name['city_name']; ?></td>
                    <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                    <td><?php echo $row_hotel['hotel_type']; ?></td>
                    <td></span><?php echo $row_hotel['total_nights']; ?></td>
                  </tr>
                  <?php 
                  } ?>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <!-- Train -->
        <?php
        $sq_count = mysqli_num_rows(mysqlQuery("select * from group_train_entries where tour_id='$package_id'"));
        if($sq_count != 0){
        ?>
        <section class="print_sec main_block">
          <div class="section_heding">
            <h2>TRAIN</h2>
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
                    <th>From_Location</th>
                    <th>To_Location</th>
                    <th>Class</th>
                  </tr>
                </thead>
                <tbody>   
                <?php 
                $sq_hotel = mysqlQuery("select * from group_train_entries where tour_id='$package_id'");
                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                  ?>
                  <tr>
                    <td><?= $row_hotel['from_location'].$similar_text ?></td>
                    <td><?= $row_hotel['to_location'] ?></td>
                    <td><?= $row_hotel['class'] ?></td>
                  </tr>
                  <?php 
                  } ?>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <!-- FLIGHT -->
        <?php
        $sq_count = mysqli_num_rows(mysqlQuery("select * from group_tour_plane_entries where tour_id='$package_id'"));
        if($sq_count != 0){
        ?>
        <section class="print_sec main_block">
          <div class="section_heding">
            <h2>FLIGHT</h2>
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
                    <th>From_sector</th>
                    <th>To_sector</th>
                    <th>Airline</th>
                    <th>Class</th>
                  </tr>
                </thead>
                <tbody>   
                <?php 
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
                  <?php 
                  } ?>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <!-- Train -->
        <?php
        $sq_count = mysqli_num_rows(mysqlQuery("select * from group_cruise_entries where tour_id='$package_id'"));
        if($sq_count != 0){
        ?>
        <section class="print_sec main_block">
          <div class="section_heding">
            <h2>CRUISE</h2>
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
                    <th>Route</th>
                    <th>Cabin</th>
                  </tr>
                </thead>
                <tbody>   
                <?php 
                $sq_hotel = mysqlQuery("select * from group_cruise_entries where tour_id='$package_id'");
                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                  ?>
                  <tr>
                    <td><?= $row_hotel['route'] ?></td>
                    <td><?= $row_hotel['cabin'] ?></td>
                  </tr>
                  <?php 
                  } ?>
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </section>
        <?php } ?>

        <!-- Tour Itinenary -->
        <section class="print_sec main_block side_pad mg_tp_30">
          <div class="section_heding">
            <h2>TOUR ITINERARY</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="row">
          <div class="col-md-12">
            <div class="print_itinenary main_block no-pad no-marg">          
            <?php
            $count = 1;
            $sq_package_program = mysqlQuery("select * from group_tour_program where tour_id = '$package_id'");
            while($row_itinarary = mysqli_fetch_assoc($sq_package_program)){
              ?>
              <section class="print_single_itinenary main_block">
                <div class="print_itinenary_count print_info_block">DAY - <?php echo $count++; ?></div>
                <div class="print_itinenary_desciption print_info_block">
                  <div class="print_itinenary_attraction">
                    <span class="print_itinenary_attraction_icon"><i class="fa fa-map-marker"></i></span>
                    <samp class="print_itinenary_attraction_location"><?= $row_itinarary['attraction'] ?></samp>
                  </div>
                  <p><?= $row_itinarary['day_wise_program'] ?></p>
                </div>
                <div class="print_itinenary_details">
                  <div class="print_info_block">
                    <ul class="main_block no-pad">
                      <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-bed"></i> : </span><?= $row_itinarary['stay'] ?></li>
                      <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
                    </ul>
                  </div>
                </div>
              </section>
            <?php } ?>
            </div>
          </div>
        </div>
      </section>
    <?php } ?>
    <!-- Inclusion -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Inclusions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?php echo $inclusions; ?>
          </div>
        </div>
      </div>
    </section> 


    <!-- Exclusion -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Exclusions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?php echo $exclusions; ?>
          </div>
        </div>
      </div>
    </section> 

    <!-- Terms and Conditions -->
    <?php
    if($sq_terms_cond['terms_and_conditions'] != ''){
      ?>
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Terms and Conditions</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
            <span><?= $sq_terms_cond['terms_and_conditions'] ?></span>
            </div>
          </div>
        </div>
      </section>
    <?php } ?>
    <!-- Note -->
    <?php
    if($sq_pckg['note'] != '' && $package_booking_info['service'] == 'Holiday'){
      ?>
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Note</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
            <span><?= $sq_pckg['note'] ?></span>
            </div>
          </div>
        </div>
      </section>
    <?php } ?>

    <!-- Payment Detail -->
    <?php
    $total_cost = $costing_data[0]->total_cost;
    $total_tax = $costing_data[0]->total_tax;
    $taxes = explode(',',$total_tax);
    $tax_amount = 0;
    $tax_string = '';
    for($i=0; $i<sizeof($taxes);$i++){
      $single_tax = explode(':',$taxes[$i]);
      $tax_amount += floatval($single_tax[1]);
      $temp_tax = explode(' ',$single_tax[1]);
      $tax_string .= $single_tax[0].$temp_tax[1];
    }
	  $grand_total = $costing_data[0]->grand_total;
	  $coupon_amount = $costing_data[0]->coupon_amount;
	  $net_total = $costing_data[0]->net_total;
    $coupon_amount = ($coupon_amount!='')?$coupon_amount:0;
    
    $total_cost = currency_conversion($currency,$currency,$total_cost);
    $tax_amount = currency_conversion($currency,$currency,$tax_amount);
    $grand_total = currency_conversion($currency,$currency,$grand_total);
    $coupon_amount = currency_conversion($currency,$currency,$coupon_amount);
    $net_total = currency_conversion($currency,$currency,$net_total);
    ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>PAYMENT DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_amount_block">
            <ul class="main_block no-pad text-right noType">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TOTAL COST : </span><?php echo $total_cost; ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>COUPON AMOUNT : </span><?php echo $coupon_amount; ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TAX : </span><?php echo $tax_string.' '.$tax_amount; ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>NET TOTAL : </span><b><?php echo $net_total; ?></b></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>GRAND TOTAL : </span><?php echo $grand_total; ?></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
          <div class="print_quotation_creator">
            <span>CUSTOMER'S SIGNATURE: </span><br>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>