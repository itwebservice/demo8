<?php
include "../../../../../model/model.php";

$ticket_id = $_POST['ticket_id'];
$sql_booking_date = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id='$ticket_id'"));
$date = $sql_booking_date['created_at'];
$yr = explode("-", $date);
$year = $yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_ticket_booking_id($ticket_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
        <div class="row">
            <div class="col-xs-12">
              <div class="profile_box main_block">
                <h3 class="editor_title">Passenger Details</h3>
                <?php
                $query = "select * from ticket_master where 1 and ticket_id='$ticket_id' ";
                $mainTicket = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master_entries where ticket_id = '$ticket_id'"));  
                ?>
                <div class="table-responsive">
                <table class="table table-hover table-bordered no-marg" id="tbl_ticket_report">
                  <thead>
                    <tr class="table-heading-row">
                      <th>S_No.</th>
                      <th>Name</th>
                      <th>Adolescence</th>
                      <th>Ticket_No.</th>
                      <?php if($mainTicket['main_ticket']) echo  '<th>Main Ticket Number</th>'; ?> 
                      <th>Baggage</th>
                      <th>Gds_Pnr</th>
                      <th>Seat_No</th>
                      <th>Meal_plan</th>
                    </tr>
                    
                  </thead>
                  <tbody>
                    <?php
                    $count = 0;
                    $sq_ticket = mysqlQuery($query);
                    while($row_ticket =mysqli_fetch_assoc($sq_ticket)){

                      $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

                      $sq_entry = mysqlQuery("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
                      while($row_entry = mysqli_fetch_assoc($sq_entry)){

                        $bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
                        ?>
                        <tr class="<?= $bg ?>">
                          <td><?= ++$count ?></td>
                          <td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
                          <td><?= $row_entry['adolescence'] ?></td>
                          <td><?= $row_entry['ticket_no'] ?></td>
                          <?php if($row_entry['main_ticket']) echo  '<td>'.$row_entry['main_ticket'].'</td>';?>
                          <td><?php echo $row_entry['baggage_info']; ?></td>
                          <td><?= $row_entry['gds_pnr'] ?></td>
                          <td><?= $row_entry['seat_no'] ?></td>
                          <td><?= $row_entry['meal_plan'] ?></td>
                        </tr>
                        <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>
                    </div>
                </div>  
            </div>
            </div>
    
          <div class="row mg_tp_10">
            <div class="col-xs-12">
              <h3 class="editor_title">Trip Details</h3>
              <?php  	$query = "select * from ticket_master where 1 ";
              $query .=" and ticket_id='$ticket_id'";
              $tickect_query="select * from ticket_trip_entries where 1 and ticket_id='$ticket_id' ";
              ?>
              <div class="table-responsive">
                  <table class="table table-hover table-bordered no-marg" id="tbl_ticket_report">
                  <thead>
                    <tr class="table-heading-row">
                      <th>S_No</th>
                      <th>Departure_Date&Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <th>Arrival_Date&Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      <th>Airline</th>
                      <th>Cabin</th>
                      <th>Sub-category</th>
                      <th>Flight_No.</th>
                      <th>Airline_PNR</th>
                      <th>From_City</th>
                      <th>Sector_From</th>
                      <th>To_City</th>
                      <th>Sector_To</th>
                      <th>Luggage&nbsp;&nbsp;&nbsp;</th>
                      <th>No_of_pieces&nbsp;&nbsp;&nbsp;</th>
                      <th>Aircraft_type</th>
                      <th>Operating_carrier&nbsp;&nbsp;</th>
                      <th>Frequent_flyer&nbsp;&nbsp;&nbsp;</th>
                      <th>Ticket_status&nbsp;&nbsp;&nbsp;</th>
                      <th>Special_Note</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $count = 0;
                    $sq_ticket = mysqlQuery($query);
                    $sq_ticket1 = mysqlQuery($tickect_query);
                    while($row_ticket =mysqli_fetch_assoc($sq_ticket)){

                      $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

                      $sq_entry = mysqlQuery("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
                      
                      while($row_entry = mysqli_fetch_assoc($sq_entry)){

                        while($row_entry1 = mysqli_fetch_assoc($sq_ticket1)) {
                          $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_entry1[from_city]'"));
                          $sq_city1 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_entry1[to_city]'"));  
                          $bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
                        ?>
                        <tr class="<?= $bg ?>">
                          <td><?= ++$count ?></td>
                          <td><?php echo get_datetime_user($row_entry1['departure_datetime']); ?> </td>
                          <td><?php echo get_datetime_user($row_entry1['arrival_datetime']); ?></td>
                          <td><?php echo $row_entry1['airlines_name']; ?></td>
                          <td><?php echo $row_entry1['class']; ?></td>
                          <td><?php echo $row_entry1['sub_category']; ?></td>
                          <td><?php echo $row_entry1['flight_no']; ?></td>
                          <td style="text-transform: uppercase;"><?php echo $row_entry1['airlin_pnr']; ?></td>
                          <td><?php echo $sq_city['city_name']; ?></td>
                          <td><?php echo $row_entry1['departure_city']; ?></td>
                          <td><?php echo $sq_city1['city_name']; ?></td>
                          <td><?php echo $row_entry1['arrival_city']; ?></td>
                          <td><?php echo $row_entry1['luggage']; ?></td>
                          <td><?php echo $row_entry1['no_of_pieces']; ?></td>
                          <td><?php echo $row_entry1['aircraft_type']; ?></td>
                          <td><?php echo $row_entry1['operating_carrier']; ?></td>
                          <td><?php echo $row_entry1['frequent_flyer']; ?></td>
                          <td><?php echo $row_entry1['ticket_status']; ?></td>
                          <td><?php echo $row_entry1['special_note']; ?></td>
                        </tr>
                        <?php
                        }
                    }
                  }
                  ?>
                  </tbody>
                </table>
                </div>
            </div>
        </div> 
</div>	
</div>
</div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#visa_display_modal').modal('show');
</script>