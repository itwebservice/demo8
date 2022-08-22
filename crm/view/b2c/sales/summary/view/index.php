<?php 
include "../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$sq_package_info = mysqli_fetch_assoc(mysqlQuery("select * from b2c_sale where booking_id = '$booking_id'")) ;
$booking_date = $sq_package_info['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];

$status = $sq_package_info['status'];
$bg_clr = ($status=='Cancel') ? 'danger': '';
$costing_data = json_decode($sq_package_info['costing_data']);
$enq_data = json_decode($sq_package_info['enq_data']);
$guest_data = json_decode($sq_package_info['guest_data']);
$total_pax = intval($enq_data[0]->adults)+intval($enq_data[0]->chwob)+intval($enq_data[0]->chwb)+intval($enq_data[0]->infant)+intval($enq_data[0]->extra_bed);
$state_id = $costing_data[0]->state;
$package_id = $enq_data[0]->package_id;
$sq_state = mysqli_fetch_assoc(mysqlQuery("select state_name from state_master where id='$state_id'"));
?>
<div class="modal fade profile_box_modal" id="exc_display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Booking Information(<?= get_b2c_booking_id($booking_id,$year) ?>)</h5>
      </div>
      <div class="modal-body profile_box_padding">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#basic_information" aria-controls="basic_information" role="tab" data-toggle="tab" class="tab_name">General</a></li>
          <li role="presentation"><a href="#hotel_information" aria-controls="hotel_information" role="tab" data-toggle="tab" class="tab_name">Hotel/Transport</a></li>
        </ul>
				<div class="panel panel-default panel-body fieldset profile_background">

						<!-- Tab panes1 -->
					<div class="tab-content">

						<!-- *****TAb1 start -->
						<div role="tabpanel" class="tab-pane active" id="basic_information">
							
              <div class="row mg_bt_20">
                <div class="col-md-6 col-sm-12 col-xs-12 mg_bt_20_xs">
                  <div class="profile_box main_block">
                    <h3>Tour Details</h3>
                    <div class="row">
                      <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
                        <span class="main_block"> 
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Booking ID <em>:</em></label>" .get_b2c_booking_id($booking_id,$year) ?>
                        </span>
                        <span class="main_block"> 
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Tour Name <em>:</em></label>" .$enq_data[0]->package_name; ?>
                        </span>
                        <span class="main_block">
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Travel Date <em>:</em></label>" .$enq_data[0]->travel_from.' To '.$enq_data[0]->travel_to ?> 
                        </span>
                        <span class="main_block">
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Total Guest <em>:</em></label>" .$total_pax ?> 
                        </span>
                      </div>
                      <?php
                      if($sq_package_info['service'] == 'Holiday'){ ?>
                      <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
                        <span class="main_block"> 
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Pickup Location <em>:</em></label>" .$enq_data[0]->pickup_from ?>
                        </span>
                        <span class="main_block"> 
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Pickup Date&Time <em>:</em></label>" .$enq_data[0]->pickup_time; ?>
                        </span>
                        <span class="main_block">
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Dropoff Location <em>:</em></label>" .$enq_data[0]->drop_to ?> 
                        </span>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="profile_box main_block">

                    <h3>Customer Details</h3>

                    <div class="row">

                      <div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">

                        <span class="main_block"> 

                            <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                          <?php echo  "<label>Customer Name <em>:</em></label> " .$sq_package_info['name'].'&nbsp'; ?>

                        </span>

                        <span class="main_block">

                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                          <?php echo "<label>Email <em>:</em></label> " .$sq_package_info['email_id']; ?>

                        </span>	

                        <span class="main_block">

                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                          <?php echo "<label>Mobile No <em>:</em></label>" .$sq_package_info['phone_no']; ?> 

                        </span>

                      </div>

                      <div class="col-sm-6 col-xs-12">


                            <span class="main_block">

                                <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                              <?php echo "<label>City <em>:</em></label> ".$sq_package_info['city']; ?>

                            </span>

                        <span class="main_block">

                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

                            <?php echo "<label>State <em>:</em></label> ".$sq_state['state_name']; ?> 

                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mg_bt_20">
                <div class="col-md-8 col-sm-12 col-xs-12">
                  <div class="profile_box main_block">
                    <h3>Booking Details</h3>
                    <div class="row">
                      <div class="col-xs-12">
                        <span class="main_block">
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Booking Date&Time <em>:</em></label> ".get_datetime_user($sq_package_info['created_at']) ;?> 
                        </span>
                      </div>
                    </div>
                    <div class="row">	
                      <div class="col-md-12">
                        <span class="main_block">
                          <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                          <?php echo "<label>Other Specification <em>:</em></label> ".$enq_data[0]->specification;?> 
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="profile_box main_block">
                  <h3>Guest Details</h3>
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
                          <tr class="<?= $bg_clr ?>">
                          <td>Adult</td>
                          <td><?php echo $guest_data[0]->adult[$i]->honorific.' '.$guest_data[0]->adult[$i]->first_name.' '.$guest_data[0]->adult[$i]->last_name; ?></td>
                          <td><?php echo $guest_data[0]->adult[$i]->birthdate; ?></td>
                          </tr>
                      <?php
                      } ?>
                      <?php
                          $guest_data[0]->chwob = ($guest_data[0]->chwob != '') ? $guest_data[0]->chwob : [];
                        for($i=0;$i<sizeof($guest_data[0]->chwob);$i++){
                        ?>   
                          <tr class="<?= $bg_clr ?>">
                          <td>Child w/o bed</td>
                          <td><?php echo $guest_data[0]->chwob[$i]->honorific.' '.$guest_data[0]->chwob[$i]->first_name.' '.$guest_data[0]->chwob[$i]->last_name; ?></td>
                          <td><?php echo $guest_data[0]->chwob[$i]->birthdate; ?></td>
                          </tr>
                      <?php
                      } ?>
                      <?php
                          $guest_data[0]->chwb = ($guest_data[0]->chwb != '') ? $guest_data[0]->chwb : [];
                        for($i=0;$i<sizeof($guest_data[0]->chwb);$i++){
                        ?>   
                          <tr class="<?= $bg_clr ?>">
                          <td>Child with bed</td>
                          <td><?php echo $guest_data[0]->chwb[$i]->honorific.' '.$guest_data[0]->chwb[$i]->first_name.' '.$guest_data[0]->chwb[$i]->last_name; ?></td>
                          <td><?php echo $guest_data[0]->chwb[$i]->birthdate; ?></td>
                          </tr>
                      <?php
                      } ?>
                      <?php
                          $guest_data[0]->extra_bed = ($guest_data[0]->extra_bed != '') ? $guest_data[0]->extra_bed : [];
                        for($i=0;$i<sizeof($guest_data[0]->extra_bed);$i++){
                        ?>   
                          <tr class="<?= $bg_clr ?>">
                          <td>Extra Bed</td>
                          <td><?php echo $guest_data[0]->extra_bed[$i]->honorific.' '.$guest_data[0]->extra_bed[$i]->first_name.' '.$guest_data[0]->infant[$i]->last_name; ?></td>
                          <td><?php echo $guest_data[0]->extra_bed[$i]->birthdate; ?></td>
                          </tr>
                      <?php
                      } ?>
                      <?php
                          $guest_data[0]->infant = ($guest_data[0]->infant != '') ? $guest_data[0]->infant : [];
                        for($i=0;$i<sizeof($guest_data[0]->infant);$i++){
                        ?>   
                          <tr class="<?= $bg_clr ?>">
                          <td>Infant</td>
                          <td><?php echo $guest_data[0]->infant[$i]->honorific.' '.$guest_data[0]->infant[$i]->first_name.' '.$guest_data[0]->infant[$i]->last_name; ?></td>
                          <td><?php echo $guest_data[0]->infant[$i]->birthdate; ?></td>
                          </tr>
                      <?php
                      } ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
						</div>
						<!-- ********Tab1 End******** --> 
						<div role="tabpanel" class="tab-pane" id="hotel_information">
              <?php
              if($sq_package_info['service'] == 'Holiday'){
                $sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id='$package_id'"));
                if($sq_c_hotel != '0'){
                ?>
                <div class="row mg_bt_20">
                  <div class="col-xs-12">
                    <div class="profile_box main_block">
                      <h3 class="editor_title">Accommodation Details</h3>
                      <div class="table-responsive">
                        <table class="table table-bordered no-marg">
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
                </div>
                <?php } ?>

                <?php 
                $sq_tr_count = mysqli_num_rows(mysqlQuery("select * from custom_package_transport where package_id='$package_id'"));
                if($sq_tr_count != '0'){
                ?>
                <div class="row mg_bt_20">
                  <div class="col-md-12">
                    <div class="profile_box main_block">
                      <h3 class="editor_title">Transport Details</h3>
                      <div class="table-responsive">
                        <table class="table table-bordered no-marg">
                          <thead>
                            <tr class="table-heading-row">
                              <th>VEHICLE</th>
                              <th>Pickup_location</th>
                              <th>Dropoff_location</th>
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
                <?php }
              }
              else{
                  // Hotel
                  $sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_tour_hotel_entries where tour_id='$package_id'"));
                  if($sq_c_hotel != '0'){
                    ?>
                    <div class="row mg_bt_20">
                      <div class="col-xs-12">
                        <div class="profile_box main_block">
                          <h3 class="editor_title">Accommodation Details</h3>
                          <div class="table-responsive">
                            <table class="table table-bordered no-marg">
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
                    </div>
                  <?php }
                  // Train
                  $sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_train_entries where tour_id='$package_id'"));
                  if($sq_c_hotel != '0'){
                    ?>
                    <div class="row mg_bt_20">
                      <div class="col-xs-12">
                        <div class="profile_box main_block">
                          <h3 class="editor_title">Train Details</h3>
                          <div class="table-responsive">
                            <table class="table table-bordered no-marg">
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
                                $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_id]'"));
                                $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_id]'"));
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
                    </div>
                  <?php }
                  // Flight
                  $sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_tour_plane_entries where tour_id='$package_id'"));
                  if($sq_c_hotel != '0'){
                    ?>
                    <div class="row mg_bt_20">
                      <div class="col-xs-12">
                        <div class="profile_box main_block">
                          <h3 class="editor_title">Flight Details</h3>
                          <div class="table-responsive">
                            <table class="table table-bordered no-marg">
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
                    </div>
                  <?php }
                  // Cruise
                  $sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_cruise_entries where tour_id='$package_id'"));
                  if($sq_c_hotel != '0'){
                    ?>
                    <div class="row mg_bt_20">
                      <div class="col-xs-12">
                        <div class="profile_box main_block">
                          <h3 class="editor_title">Cruise Details</h3>
                          <div class="table-responsive">
                            <table class="table table-bordered no-marg">
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
                    </div>
                  <?php }
              }
              ?>
						</div>
          </div>
        </div>

</div>

</div>
</div>
</div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#exc_display_modal').modal('show');
</script>