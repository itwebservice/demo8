<?php
include "../../../model.php"; 
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");

$ticket_id = $_GET['ticket_id'];
$invoice_date = $_GET['invoice_date'];

$sq_visa_info = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id='$ticket_id'"));

$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_visa_info[customer_id]'"));
if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
  $name = $sq_customer['company_name'];
}else{
  $name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
}
$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Flight E-Ticket' and active_flag ='Active'"));
?>
    </style>
    <!-- header -->
    <section class="print_header main_block">
      <div class="col-md-4 no-pad">
        <div class="print_header_logo">
          <img src="<?php echo $admin_logo_url; ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-4 no-pad">
        <div class="text-center">
          <h3>E-Ticket</h3>
        </div>
      </div>
      <div class="col-md-4 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['contact_no'] : $app_contact_no ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>
        </div>
      </div>
    </section>

    <!-- Package -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-xs-12 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CUSTOMER NAME :</span> <?php echo $name.'&nbsp'; ?></li>
            <?php if($sq_visa_info['guest_name']!=''){ ?> <li><span>GUEST NAME & CONTACT NO :</span> <?= $sq_visa_info['guest_name'] ?></li> <?php } ?>
            <li><span>BOOKING DATE :</span> <?= $invoice_date ?></li>
          </ul>
        </div>
      </div>
    </section>
    <?php
    $sq_trip = mysqlQuery("SELECT * FROM ticket_trip_entries WHERE ticket_id='$ticket_id'");
    while($row_trip = mysqli_fetch_assoc($sq_trip))
    { ?> 
    <!-- Passenger -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered no-marg" id="tbl_emp_list">
              <thead>
                <tr class="">
                  <th colspan="9"><?php echo "From ".$row_trip['departure_city']." To ".$row_trip['arrival_city'] ; ?> </th>
                </tr>
                <tr class="table-heading-row">
                  <th>Airline</th>
                  <th>Departure Date</th>
                  <th>Departure Terminal</th>
                  <th>Arrival Date</th>
                  <th>Arrival Terminal</th>
                  <th>Cabin</th>
                  <th>Flight No.</th>
                  <th>Airline PNR</th>
                  <th>Duration</th>
                </tr>
              </thead>
              <tbody>  
                <?php
                // Create two new DateTime-objects...
                $date1 = new DateTime($row_trip['arrival_datetime']);
                $date2 = new DateTime($row_trip['departure_datetime']);

                // The diff-methods returns a new DateInterval-object...
                $diff = $date2->diff($date1);

                $timestamp1 = strtotime($row_trip['arrival_datetime']);
                $day1 = date('D', $timestamp1);
                $timestamp2 = strtotime($row_trip['departure_datetime']);
                $day2 = date('D', $timestamp2);
                ?>
                <tr>
                  <td><?php echo $row_trip['airlines_name']; ?></td>
                  <td><?php echo $day2 .' : '.get_datetime_user($row_trip['departure_datetime']); ?></td>
                  <td><?php echo $row_trip['departure_terminal']; ?></td>
                  <td><?php echo $day1 .' : '.get_datetime_user($row_trip['arrival_datetime']); ?></td>
                  <td><?php echo $row_trip['arrival_terminal']; ?></td>
                  <td><?php echo $row_trip['class']; ?></td>
                  <td><?php echo $row_trip['flight_no']; ?></td>
                  <td><?php echo $row_trip['airlin_pnr']; ?></td>
                  <td><?php echo $diff->format('%a Day(s) - %h hr(s) - %i Min(s)'); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered no-marg" id="tbl_emp_list">
              <thead>
                <tr class="table-heading-row">
                  <th>Sub-Category</th>
                  <th>Aircraft Type</th>
                  <th>Operating carrier</th>
                  <th>Frequent Flyer</th>
                  <th>Ticket_Status</th>
                  <th>Luggage</th>
                  <th>No_of_pieces</th>
                </tr>
              </thead>
              <tbody>  
                  <?php
                  $datetime1 = new DateTime($row_trip['arrival_datetime']);
                  $datetime2 = new DateTime($row_trip['departure_datetime']);
                  $interval = $datetime1->diff($datetime2);
                  $timestamp1 = strtotime($row_trip['arrival_datetime']);
                  $day1 = date('D', $timestamp1);
                  $timestamp2 = strtotime($row_trip['departure_datetime']);
                  $day2 = date('D', $timestamp2);
                  ?>
                  <tr>
                    <td><?php echo $row_trip['sub_category']; ?></td>
                    <td><?php echo $row_trip['aircraft_type']; ?></td>
                    <td><?php echo $row_trip['operating_carrier']; ?></td>
                    <td><?php echo $row_trip['frequent_flyer']; ?></td>
                    <td><?php echo $row_trip['ticket_status']; ?></td>
                    <td><?php echo $row_trip['luggage']; ?></td>
                    <td><?php echo $row_trip['no_of_pieces']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="7"><?php echo 'Special Note: '.$row_trip['special_note']; ?></td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>

    <?php
     $mainTicket = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master_entries where ticket_id = '$ticket_id'"));
    
    ?>
    <!-- Passenger -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>Passengers</th>
                <th>Adolescence</th>
                <th>Ticket_Number</th>
                <?php if($mainTicket['main_ticket']) echo  '<th>Main Ticket Number</th>'; ?> 
                <th>Baggage</th>
                <th>Seat No</th>
                <th>Meal_plan</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $from_city_arr = array();
            $to_city_arr = array();
            $sq_trip = mysqlQuery("SELECT * FROM ticket_trip_entries WHERE ticket_id='$ticket_id'");
            while($row_trip = mysqli_fetch_assoc($sq_trip)){
              
              $dep_city = explode('(',$row_trip['departure_city']);
              $arr_city = explode('(',$row_trip['arrival_city']);

              $dep_city1 = explode(')',$dep_city[1]);
              $arr_city1 = explode(')',$arr_city[1]);
              array_push($from_city_arr,$dep_city1[0]);
              array_push($to_city_arr,$arr_city1[0]);
            }
            $count = 1;
            $sq_passenger = mysqlQuery("select * from ticket_master_entries where ticket_id = '$ticket_id'");
            while($row_passenger = mysqli_fetch_assoc($sq_passenger))
            { 
              $seat_no_string = '';
              $meal_plan_string = '';
              $seat_nos = explode('/',$row_passenger['seat_no']);
              for($i = 0; $i < sizeof($seat_nos); $i++){
                $seat_no_string .= $seat_nos[$i].' ('.$from_city_arr[$i].'-'.$to_city_arr[$i].')';
                if($i != (sizeof($seat_nos)-1)){
                  $seat_no_string .= ', ';
                }
              }
              $meal_plans = explode('/',$row_passenger['meal_plan']);
              for($i = 0; $i < sizeof($meal_plans); $i++){
                $meal_plan_string .= $meal_plans[$i].' ('.$from_city_arr[$i].'-'.$to_city_arr[$i].')';
                if($i != (sizeof($meal_plans)-1)){
                  $meal_plan_string .= ', ';
                }
              }
              ?>   
                  <tr>
                    <td><?php echo $count.') '.$row_passenger['first_name'].' '.$row_passenger['last_name']; ?></td>
                    <td><?php echo $row_passenger['adolescence']; ?></td>
                    <td><?php echo $row_passenger['ticket_no'];?></td>
                    <?php if($row_passenger['main_ticket']) echo  '<td>'.$row_passenger['main_ticket'].'</td>';?>
                    <td><?php echo $row_passenger['baggage_info']; ?></td>
                    <td><?php echo ($row_passenger['seat_no']!= '') ? $seat_no_string : 'NA'; ?></td>
                    <td><?php echo ($row_passenger['meal_plan']!= '') ? $meal_plan_string : 'NA'; ?></td>
                  </tr>
              <?php 
              $count++;
            } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>
    <!-- Cancellation Policy -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Cancellation Policy</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <span><?= ($sq_visa_info['canc_policy']) ?><span>
          </div>
        </div>
      </div>
    </section>
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
            <span><?= ($sq_terms_cond['terms_and_conditions']) ?><span>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>