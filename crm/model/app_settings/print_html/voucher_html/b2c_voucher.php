<?php
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";

$booking_id = $_GET['booking_id'];
$sq_package_info = mysqli_fetch_assoc(mysqlQuery("select * from b2c_sale where booking_id='$booking_id' "));

$enq_data = json_decode($sq_package_info['enq_data']);
$package_id = $enq_data[0]->package_id;
$name = $sq_package_info['name'];
$sq_package_program = mysqlQuery("select * from custom_package_program where package_id ='$package_id'");
$sq_service_voucher = mysqli_fetch_assoc(mysqlQuery("select * from b2c_transport_voucher where booking_id='$booking_id' "));
?>
<!-- Hotel Voucher Start -->
<?php
$sq_accomodation1_hotel = mysqlQuery("select * from custom_package_hotels where package_id='$package_id'") ;
while($sq_accomodation = mysqli_fetch_assoc( $sq_accomodation1_hotel)){

    $hotel_id = $sq_accomodation['hotel_name'];
    $sq_hotel = mysqli_fetch_assoc( mysqlQuery("select * from hotel_master where hotel_id='$hotel_id'") );
    $mobile_no = $encrypt_decrypt->fnDecrypt($sq_hotel['mobile_no'], $secret_key);
    $email_id = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);

    //Total days
    $total_days = $sq_accomodation['total_days'];

    $adults = intval($enq_data[0]->adults);
    $children = intval($enq_data[0]->chwob)+intval($enq_data[0]->chwb);
    $infants = intval($enq_data[0]->infant);
    $extra_bed = intval($enq_data[0]->extra_bed);
    $total_pax = $adults + $children + $infants + $extra_bed;

    $emp_id = $_SESSION['emp_id'];
    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
    if($emp_id == '0'){ $emp_name = 'Admin';}
    else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }
    ?>
      <!-- header -->
      <div class="repeat_section main_block">
        <section class="print_header main_block">
          <div class="col-md-6 no-pad">
          <span class="title"><i class="fa fa-file-text"></i> HOTEL SERVICE VOUCHER</span>
            <div class="print_header_logo">
              <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
            </div>
          </div>
          <div class="col-md-6 no-pad">
            <div class="print_header_contact text-right">
              <span class="title"><?php echo $sq_hotel['hotel_name']; ?></span><br>
              <p><?php echo $sq_hotel['hotel_address']; ?></p>
              <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $mobile_no; ?></p>
              <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $email_id; ?></p>
            </div>
          </div>
        </section>

        <!-- print-detail -->
        <section class="print_sec main_block">
          <div class="section_heding">
            <h2>BOOKING DETAILS</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="print_info_block">
                <ul class="main_block noType">
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                      <span>DURATION</span><br>
                      <?= ($total_days).'N'?><br>
                    </div>
                  </li>
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-users" aria-hidden="true"></i><br>
                      <span>TOTAL GUEST(s)</span><br>
                      <?= $adults ?> A, <?= $children ?> C, <?= $extra_bed ?> E, <?= $infants ?> I<br>
                    </div>
                  </li>
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-university" aria-hidden="true"></i><br>
                      <span>HOTEL CATEGORY</span><br>
                      <?= $sq_accomodation['hotel_type'] ?><br>
                    </div>
                  </li>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>

        <!-- BOOKING -->
        <section class="print_sec main_block">
          <div class="row">
            <div class="col-md-6 mg_bt_20">
              <ul class="print_info_list no-pad noType">
                <li><span>GUEST NAME :</span> <?= $name ?></li>
              </ul>
            </div>
            <div class="col-md-6 mg_bt_20">
              <ul class="print_info_list no-pad noType">
                <li><span>CONTACT :</span> <?= $sq_package_info['phone_no'] ?></li>
              </ul>
            </div>
            <div class="col-md-6 mg_bt_20">
              <ul class="print_info_list no-pad noType">
                <li><span>PACKAGE NAME :</span> <?= $enq_data[0]->package_name ?></li>
              </ul>
            </div>
            <div class="col-md-6 mg_bt_20">
              <ul class="print_info_list no-pad noType">
                <li><span>PACKAGE TYPE :</span> <?= $enq_data[0]->package_type ?></li>
              </ul>
            </div>
          </div>
        </section>
        <?php
        $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Service Voucher' and active_flag ='Active'"));
        if($sq_terms_cond['terms_and_conditions'] != ''){
          ?>
          <!-- Terms and Conditions -->
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
                  <?php echo $sq_terms_cond['terms_and_conditions'];   ?> 
                </div>
              </div>
            </div>
          </section>
        <?php } ?>
      
        <!-- ID Proof -->
        <?php
        // $sq_traveler_id = mysqli_fetch_assoc(mysqlQuery("select * from package_travelers_details where booking_id='$hotel_accomodation_id'"));  
        // $id_proof_image = $sq_traveler_id['id_proof_url'];
        // if($id_proof_image != ''){
        //   $newUrl = preg_replace('/(\/+)/','/',$id_proof_image);
        //   $newUrl = explode('uploads', $newUrl);
        //   $newUrl = BASE_URL.'uploads'.$newUrl[1];
        ?>
        <section class="print_sec main_block">
          <div class="row">
            <div class="col-md-12">
              <div class="section_heding">
                <!-- <h2>ID PROOF</h2> -->
                <h2></h2>
                <div class="section_heding_img">
                  <img src="<?= $newUrl ?>" class="img-responsive">
                </div>
              </div>
            </div>
          </div>
        </section>
        <?php //} ?>
        <p style="float: left;width: 100%;"><b>Note: Please present this service voucher to service provider (Hotel/Transport) upon arrival</b></p>
      </div>  
<?php } ?>
<!-- Hotel Voucher End -->

<!-- Transport Voucher Start -->
<?php

$total_days1=strtotime($enq_data[0]->travel_to) - strtotime($enq_data[0]->travel_from);
$total_days = round($total_days1 / 86400);
?>
  <section class="print_header main_block">
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
        <span class="title"><i class="fa fa-file-text"></i> TRANSPORT SERVICE VOUCHER</span>
        <div class="print_header_logo">
          <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo $app_address; ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $app_contact_no; ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>
        </div>
      </div>
    </section>

    <!-- print-detail -->
    <section class="print_sec main_block">
    <div class="section_heding">
        <h2>BOOKING DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                  <span>DURATION</span><br>
                  <?php echo ($total_days).' Days'; ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-users" aria-hidden="true"></i><br>
                  <span>TOTAL GUEST(s)</span><br>
                  <?= $adults ?> A, <?= $children ?> C, <?= $extra_bed ?> E, <?= $infants ?> I<br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-user" aria-hidden="true"></i><br>
                  <span>CUSTOMER NAME</span><br>
                  <?= $name ?><br>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Transport Details -->
    <?php
    $sq_count = mysqli_num_rows(mysqlQuery("select * from b2c_transport_voucher_entries where booking_id='$booking_id'"));
    if($sq_count != 0){
    ?>
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>Vehicle</th>
                <th>Pick_From</th>
                <th>Drop_To</th>
                <th>D_Name</th>
                <th>D_Contact</th>
                <th>Confirmed_by</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $countVehicle = 0;
            $sq_tr_acc = mysqlQuery("select * from b2c_transport_voucher_entries where booking_id='$booking_id'");
            while($row_tr_acc=mysqli_fetch_assoc($sq_tr_acc))
            {  
              $vehicleDetails = array();
              $q_transport = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id='$row_tr_acc[transport_bus_id]'"));

              $q_transport_info = mysqlQuery("select * from custom_package_transport where package_id='$package_id'");
              
              while($rows = mysqli_fetch_assoc($q_transport_info)){
                array_push($vehicleDetails, $rows);
              }
                // Pickup
              if($vehicleDetails[$countVehicle]['pickup_type'] == 'city'){
                  $city_id = $vehicleDetails[$countVehicle]['pickup'];
                  $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                  $pickup = $row['city_name'];
              }
              else if($vehicleDetails[$countVehicle]['pickup_type'] == 'hotel'){
                $hotel_id = $vehicleDetails[$countVehicle]['pickup'];
                  $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$hotel_id'"));
                  $pickup = $row['hotel_name'];
              }
              else{
                $a_id = $vehicleDetails[$countVehicle]['pickup'];
                  $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$a_id'"));
                  $airport_nam = clean($row['airport_name']);
                  $airport_code = clean($row['airport_code']);
                  $pickup = $airport_nam." (".$airport_code.")";
              }
              //Drop-off
              if($vehicleDetails[$countVehicle]['drop_type'] == 'city'){
                $city_id = $vehicleDetails[$countVehicle]['drop'];
                  $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                  $drop = $row['city_name'];
              }
              else if($vehicleDetails[$countVehicle]['drop_type'] == 'hotel'){
                $hotel_id = $vehicleDetails[$countVehicle]['drop'];
                  $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$hotel_id'"));
                  $drop = $row['hotel_name'];
              }
              else{
                $a_id = $vehicleDetails[$countVehicle]['drop'];
                  $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$a_id'"));
                  $airport_nam = clean($row['airport_name']);
                  $airport_code = clean($row['airport_code']);
                  $drop = $airport_nam." (".$airport_code.")";
              }
            ?>
                <tr>
                  <td><?= $q_transport['vehicle_name'] ?></td>
                  <td><?= $pickup ?></td>
                  <td><?= $drop ?></td>
                  <td><?= $row_tr_acc['driver_name'] ?></td>
                  <td><?= $row_tr_acc['driver_contact'] ?></td>
                  <td><?= $row_tr_acc['confirm_by'] ?></td>
                </tr>
            <?php  $countVehicle++; } ?>
            </tbody>
          </table>
        </div>
      </div>
      </div>
    </section>
    <?php }?>
    
    <!-- INCLUSIONS -->
    <?php if($sq_service_voucher['inclusions'] != ''){?> 
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>INCLUSIONS</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?= $sq_service_voucher['inclusions'] ?>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
    <?php if($sq_service_voucher['special_arrangments'] != ''){?> 
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>SPECIAL ARRANGEMENT</h2>
            <div class="print_text_bolck">
              <?= $sq_service_voucher['special_arrangments'] ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php }?>

    <!-- HOTEL Detail -->
    <?php
    $sq_count = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id='$package_id'"));
    if($sq_count != 0){
    ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>HOTEL DETAILs</h2>
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
                <th>CITY_NAME</th>
                <th>HOTEL_NAME</th>
                <th>Hotel_Category</th>
                <th>Total_Night(s)</th>
              </tr>
            </thead>
            <tbody>   
            <?php             
            $sq_hotel_acc = mysqlQuery("select * from custom_package_hotels where package_id='$package_id'");
            while($row_hotel_acc=mysqli_fetch_assoc($sq_hotel_acc))
            {  
              $sq_city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel_acc[city_name]'"));
              $sq_hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel_acc[hotel_name]'"));
              ?>
                <tr>
                  <td><?= $sq_city_name['city_name'] ?></td>
                  <td><?= $sq_hotel_name['hotel_name'] ?></td>
                  <td><?php echo $row_hotel_acc['hotel_type']; ?></td>
                  <td></span><?php echo $row_hotel_acc['total_days']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>
    <?php }?>

    <!-- Tour Itinenary -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>TOUR ITINERARY</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <ul class="print_itinenary main_block no-pad no-marg noType">
          <?php
          $count = 1;
          while($row_itinarary = mysqli_fetch_assoc($sq_package_program)){
          ?>
            <li class="print_single_itinenary main_block">
              <div class="print_itinenary_count print_info_block">DAY - <?= $count ?></div>
              <div class="print_itinenary_desciption print_info_block">
                <div class="print_itinenary_attraction">
                  <span class="print_itinenary_attraction_icon"><i class="fa fa-map-marker"></i></span>
                  <samp class="print_itinenary_attraction_location"><?= $row_itinarary['attraction'] ?></samp>
                </div>
                <p><?= $row_itinarary['day_wise_program'] ?></p>
              </div>
              <div class="print_itinenary_details">
                <div class="print_info_block">
                  <ul class="main_block no-pad noType">
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-bed"></i> : </span><?= $row_itinarary['stay'] ?></li>
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
                  </ul>
                </div>
              </div>
            </li>
            <?php 
            $count ++; } ?>
          </ul>
        </div>
      </div>
    </section>
  
    <!-- Terms and Conditions -->
    <?php
    $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Transport Service Voucher' and active_flag ='Active'"));
    if($sq_terms_cond['terms_and_conditions'] != ''){?> 
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
              <?php 
              echo $sq_terms_cond['terms_and_conditions'];   ?> 
            </div>
          </div>
        </div>
      </section>
      
    <?php } ?>
</section>
</div>
  </body>
</html>