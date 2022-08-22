<?php
$login_id = $_SESSION['login_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
//**Enquiries
$assigned_enq_count = mysqli_num_rows(mysqlQuery("select enquiry_id from enquiry_master where assigned_emp_id='$emp_id' and status!='Disabled' and financial_year_id='$financial_year_id'"));

$converted_count = 0;
$closed_count = 0;
$infollowup_count = 0;
$followup_count = 0;

$sq_enquiry = mysqlQuery("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$emp_id' and financial_year_id='$financial_year_id'");
	while($row_enq = mysqli_fetch_assoc($sq_enquiry)){
		$sq_enquiry_entry = mysqli_fetch_assoc(mysqlQuery("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
		if($sq_enquiry_entry['followup_status']=="Dropped"){
			$closed_count++;
		}
		if($sq_enquiry_entry['followup_status']=="Converted"){
			$converted_count++;
		}
		if($sq_enquiry_entry['followup_status']=="Active"){
			$followup_count++;
		}
		if($sq_enquiry_entry['followup_status']=="In-Followup"){
			$infollowup_count++;
		}
	}

?>
<div class="app_panel"> 
<div class="dashboard_panel panel-body">

	<div class="dashboard_enqury_widget_panel main_block mg_bt_25">
            <div class="row">
                <div class="col-sm-3 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block blue_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-cubes"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $assigned_enq_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount"> 
                      Total Enquiries 
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block yellow_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-folder-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $followup_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Active
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block gray_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-folder-open-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $infollowup_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      In-Followup
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block green_enquiry_widget">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-check-square-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $converted_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Converted
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block red_enquiry_widget">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-trash-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $closed_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Dropped Enquiries
                    </div>
                  </div>
                </div>
            </div>
    </div>

    <div class="row">
      <div class="col-md-12">
      <div id="id_proof2"></div>
        <div class="dashboard_tab text-center main_block">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs responsive" role="tablist">
            <li role="presentation"  class="active"><a href="#week_fol_tab" aria-controls="week_fol_tab" role="tab" data-toggle="tab">Followups</a></li>
            <li role="presentation"><a href="#oncoming_tab" aria-controls="oncoming_tab" role="tab" data-toggle="tab">Ongoing Tours</a></li>
            <li role="presentation" class=""><a href="#upcoming_tab" aria-controls="upcoming_tab" role="tab" data-toggle="tab">Upcoming Tours</a></li>
            <li role="presentation"><a href="#week_task_tab" aria-controls="week_task_tab" role="tab" data-toggle="tab">Tasks</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content responsive main_block">
            
            <!-- Ongoing FIT Tours -->
                <div role="tabpanel" class="tab-pane" id="oncoming_tab">
                <?php 
                $count = 1;
                $today = date('Y-m-d');  
                $today1 = date('Y-m-d H:i');                
                ?>
                <div class="dashboard_table dashboard_table_panel main_block">
                  <div class="row text-left">
                    
                    <div class="col-md-12">
                      <div class="dashboard_table_body main_block">
                        <div class="col-md-12 no-pad table_verflow"> 
                          <div class="table-responsive">
                            <table class="table table-hover" style="margin: 0 !important;border: 0;">
                              <thead>
                                <tr class="table-heading-row">
                                  <th>S_No.</th>
                                  <th>Tour_Type</th>
                                  <th>Tour_Name</th>
                                  <th>Tour_Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                  <th>Customer_Name</th>
                                  <th>Mobile</th>
                                  <th>Owned&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                  <th>Client_Feedback</th>
                                </tr>
                              </thead>
                              <tbody>
                        <?php
                        $query1 = "select * from package_tour_booking_master where tour_status!='Disabled' and financial_year_id='$financial_year_id' and emp_id = '$emp_id' and tour_from_date <= '$today' and tour_to_date >= '$today'";
                          
                        $sq_query = mysqlQuery($query1);
                        while($row_query=mysqli_fetch_assoc($sq_query)){
                          $sq_cancel_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_query[booking_id]' and status='Cancel'"));
                          $sq_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_query[booking_id]'"));
                          if($sq_cancel_count != $sq_count){
                          $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                          if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                            $customer_name = $sq_cust['company_name'];
                          }else{
                            $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                          }
                          $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                        ?>
                              <tr class="<?= $bg ?>">
                                <td><?php echo $count++; ?></td>
                                <td><?php echo 'Package Booking'; ?></td>
                                <td><?php echo $row_query['tour_name']; ?></td>
                                <td><?= get_date_user($row_query['tour_from_date']).' To '.get_date_user($row_query['tour_to_date']); ?></td>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $row_query['mobile_no']; ?></td>
                                <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query['booking_id'] ?>,'Package Booking',<?= $row_query['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                              </tr>
                            <?php
                              } }
                            ?>
                            <!-- Hotel Booking -->
                            <?php
                            $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='hotels/booking/index.php'"));
                            $branch_status = $sq['branch_status'];
                            $query = "select * from hotel_booking_entries where status!='Cancel' and DATE(check_in)<= '$today' and DATE(check_out) >= '$today'";
                            
                            $sq_query = mysqlQuery($query);
                            while($row_query=mysqli_fetch_assoc($sq_query)){
                            
                            $query1 = "select * from hotel_booking_master where booking_id = '$row_query[booking_id]' and emp_id = '$emp_id'";
                            if($branch_status=='yes'){
                              if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                $query1 .= " and branch_admin_id = '$branch_admin_id'";
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                              }
                            }
                            elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                              $query1 .= " and emp_id='$emp_id'";
                            }
                            $sql_hotel = mysqlQuery($query1);
                              while($sq_hotel = mysqli_fetch_assoc($sql_hotel)){

                              
                              $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                              if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                $customer_name = $sq_cust['company_name'];
                              }else{
                                $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                              }
                              $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                              $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                              ?>
                                <tr class="<?= $bg ?>">
                                <td><?php echo $count++; ?></td>
                                <td>Hotel Booking</td>
                                <td><?php echo 'NA'; ?></td>
                                <td><?= get_date_user($row_query['check_in']).' To '.get_date_user($row_query['check_out']) ?></td>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['booking_id'] ?>,'Hotel Booking',<?= $sq_hotel['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>	
                                </tr>
                              <?php } } ?>
                              <!-- flight Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_train = "select *	from  ticket_trip_entries where DATE(departure_datetime)<= '$today' and DATE(arrival_datetime)>= '$today' and ticket_id in(select ticket_id from ticket_master where emp_id='$emp_id') and ticket_id in (select ticket_id from 	ticket_master_entries where status!='Cancel')";
                              
                              $sq_query1 = mysqlQuery($query_train);
                              while($row_query1=mysqli_fetch_assoc($sq_query1)){
                                
                              $query1 = "select * from ticket_master where ticket_id = '$row_query1[ticket_id]' and emp_id = '$emp_id'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_flight = mysqlQuery($query1);
                                while($sq_hotel = mysqli_fetch_assoc($sql_flight)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Flight Booking</td>
                                  <td><?php echo $row_query1['arrival_city']; ?></td>
                                  <td><?= get_date_user($row_query1['departure_datetime']).' To '.get_date_user($row_query1['arrival_datetime']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['ticket_id'] ?>,'Flight Booking',<?= $sq_hotel['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } } ?>
                              <!-- Train Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_train = "select *	from  train_ticket_master_trip_entries where DATE(travel_datetime)<= '$today' and DATE(arriving_datetime) >= '$today' and train_ticket_id in(select train_ticket_id from train_ticket_master_entries where status!='Cancel')";
                              $sq_query_train = mysqlQuery($query_train);
                              while($row_query1=mysqli_fetch_assoc($sq_query_train)){
                                
                                $query1 = "select * from train_ticket_master where train_ticket_id = '$row_query1[train_ticket_id]' and emp_id = '$emp_id'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sql_train = mysqlQuery($query1);
                                while($sq_train = mysqli_fetch_assoc($sql_train)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_train[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_train[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Train Booking</td>
                                  <td><?php echo 'NA'; ?></td>
                                  <td><?= get_date_user($row_query1['travel_datetime'])?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_train['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_train['train_ticket_id'] ?>,'Train Booking',<?= $sq_train['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } } ?>
                              
                              <!-- Bus Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='bus_booking/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_bus = "select *	from  bus_booking_entries where DATE(date_of_journey)	= '$today' and status!='Cancel'	";

                                $sq_query_bus = mysqlQuery($query_bus);
                                while($row_query1=mysqli_fetch_assoc($sq_query_bus)){
                                
                                $query1 = "select * from bus_booking_master where booking_id = '$row_query1[booking_id]' and emp_id = '$emp_id'";

                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sql_bus = mysqlQuery($query1);

                                while($sq_hotel = mysqli_fetch_assoc($sql_bus)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Bus Booking</td>
                                  <td><?php echo 'NA'; ?></td>
                                  <td><?= get_date_user($row_query1['date_of_journey']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['booking_id'] ?>,'Bus Booking',<?= $sq_hotel['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } }?>
                              <!-- Excursion Booking -->
                              <?php
                              
                              $add7days1 = date('Y-m-d', strtotime('+7 days'));
                              $query_exc = "select * from excursion_master_entries where DATE(exc_date) ='$today' and status!='Cancel'";

                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='excursion/index.php'"));
                              $branch_status = $sq['branch_status'];
                            
                              $sq_query_exc = mysqlQuery($query_exc);
                              while($row_query1=mysqli_fetch_assoc($sq_query_exc)){
                                
                              $query1 = "select * from 	excursion_master where exc_id = '$row_query1[exc_id]' and emp_id = '$emp_id'";
                              $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from	city_master where city_id = '$row_query1[city_id]'"));
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_exc = mysqlQuery($query1);
                              while( $sq_hotel = mysqli_fetch_assoc($sql_exc)){

                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Activity Booking</td>
												          <td><?php echo $sq_city['city_name']; ?></td>
                                  <td><?= get_date_user($row_query1['exc_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['exc_id'] ?>,'Excursion Booking',<?= $sq_hotel['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } }?>
                                <!-- Car Rental Booking -->
                                  <?php
                                  $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='car_rental/booking/index.php'"));
                                  $branch_status = $sq['branch_status'];
                                  $query_car = "select * from car_rental_booking  where DATE(from_date)='$today' and travel_type ='Local' and status!='Cancel'";

                                  if($branch_status=='yes'){
                                    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                      $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                    }
                                    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                      $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                    }
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query_car .= " and emp_id='$emp_id'";
                                  }
                                  
                                $sq_query_car = mysqlQuery($query_car);
                                while($row_query1=mysqli_fetch_assoc($sq_query_car)){
                                    
                                    $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                    if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                      $customer_name = $sq_cust['company_name'];
                                    }else{
                                      $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                    }
                                    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                    ?>
                                      <tr class="<?= $bg ?>">
                                      <td><?php echo $count++; ?></td>
                                      <td>Car Rental Booking</td>
                                      <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                      <td><?= get_date_user($row_query1['from_date']).' To '.get_date_user($row_query1['to_date']) ?></td>
                                      <td><?php echo $customer_name; ?></td>
                                      <td><?php echo $contact_no; ?></td>
                                      <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                      <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['booking_id'] ?>,'Car Rental Booking',<?= $row_query1['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                      </tr>
                                  <?php } ?>
                                  <!-- Car Rental Booking -->
                                  <?php
                                  $query_car = "select * from car_rental_booking  where DATE(traveling_date)='$today' and travel_type ='Outstation' and status!='Cancel'";

                                  if($branch_status=='yes'){
                                    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                      $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                    }
                                    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                      $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                    }
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query_car .= " and emp_id='$emp_id'";
                                  }
                                  
                                  $sq_query_car = mysqlQuery($query_car);
                                  while($row_query1=mysqli_fetch_assoc($sq_query_car)){
                                    
                                    $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                    if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                      $customer_name = $sq_cust['company_name'];
                                    }else{
                                      $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                    }
                                    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                    ?>
                                      <tr class="<?= $bg ?>">
                                      <td><?php echo $count++; ?></td>
                                      <td>Car Rental Booking</td>
                                      <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                      <td><?= get_date_user($row_query1['traveling_date']) ?></td>
                                      <td><?php echo $customer_name; ?></td>
                                      <td><?php echo $contact_no; ?></td>
                                      <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                      <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['booking_id'] ?>,'Car Rental Booking',<?= $row_query1['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                      </tr>
                                  <?php } ?>
                              <!-- Group Booking -->
                                  <?php
                                  $sq = mysqlQuery("select * from tourwise_traveler_details where 1 and emp_id='$emp_id' and financial_year_id='$financial_year_id' and tour_group_status!='Cancel'");
                                  while($row_query = mysqli_fetch_assoc($sq)){
                                    
                                    $sq_trcount = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_query[traveler_group_id]' and status='Cancel'"));
                                    if($sq_trcount == 0){
                                      $sq_booking1 = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id = '$row_query[tour_id]'"));
                                      $row_grps_count = mysqli_num_rows(mysqlQuery("select * from tour_groups where tour_id = '$row_query[tour_id]' and group_id='$row_query[tour_group_id]' and from_date<='$today' and to_date>='$today'"));
                                      if($row_grps_count > 0){
                                        $row_grps = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where tour_id = '$row_query[tour_id]' and group_id='$row_query[tour_group_id]' and from_date<='$today' and to_date>='$today'"));
                                        $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                        if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                          $customer_name = $sq_cust['company_name'];
                                        }else{
                                          $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                        }
                                        $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                        $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                        $tour_id = $sq_booking1['tour_id'];
                                        $dest_id = $sq_booking1['dest_id'];

                                        $date1 = $row_query['form_date'];
                                        $yr1 = explode("-", $date1);
                                        $year1 = $yr1[0];
                                      ?>
                                        <tr class="<?= $bg ?>">
                                          <td><?php echo $count++; ?></td>
                                          <td>Group Booking(<?=get_group_booking_id($row_query['id'],$year1)?>)</td>
                                          <td><?php echo $sq_booking1['tour_name']; ?></td>
                                          <td><?= get_date_user($row_grps['from_date']).' To '.get_date_user($row_grps['to_date']) ?></td>
                                          <td><?php echo $customer_name; ?></td>
                                          <td><?php echo $contact_no; ?></td>
                                          <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                          <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query['id'] ?>,'Group Booking',<?= $row_query['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                        </tr>
                                  <?php }
                                } } ?>
                              <!-- Visa Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/visa/index.php'"));
                              $branch_status = $sq['branch_status'];
                              
                              $query_visa = "select *	from  visa_master_entries where appointment_date='$today' and status!='Cancel'";

                              $sq_query_visa = mysqlQuery($query_visa);
                              while($row_query_visa=mysqli_fetch_assoc($sq_query_visa)){

                              $query1 = "select * from visa_master where visa_id = '$row_query_visa[visa_id]' and emp_id = '$emp_id'";

                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_visa = mysqlQuery($query1);

                              while($sq_visa = mysqli_fetch_assoc($sql_visa)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Visa Booking</td>
                                  <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                  <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_visa['visa_id'] ?>,'Visa Booking',<?= $sq_visa['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php }}?>
                                <!-- Passport Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/passport/index.php'"));
                              $branch_status = $sq['branch_status'];

                              $query_pass = "select *	from  passport_master_entries where DATE(appointment_date)='$today' and status!='Cancel'";

                              $sq_query_pass = mysqlQuery($query_pass);
                              while($row_query_visa=mysqli_fetch_assoc($sq_query_pass)){

                              $query1 = "select * from passport_master where passport_id = '$row_query_visa[passport_id]' and emp_id = '$emp_id'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_pass = mysqlQuery($query1);
                              while($sq_visa = mysqli_fetch_assoc($sql_pass)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Passport Booking</td>
                                  <td><?php echo 'NA'; ?></td>
                                  <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_visa['passport_id'] ?>,'Passport Booking',<?= $sq_visa['emp_id']?>,'<?= $contact_no?>', '<?= $sq_cust['first_name'] ?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } }?>
                          </tbody>
                        </table>
                      </div> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <!-- Ongoing FIT Tour summary End -->

            <!-- Upcoming  FIT Tours -->
            <div role="tabpanel" class="tab-pane" id="upcoming_tab">
                <?php 
                $count = 1;
                $today = date('Y-m-d-h-i-s');
                $add7days = date('Y-m-d-h-i-s', strtotime('+7 days'));
                $today1 = date('Y-m-d');
                $add7days1 = date('Y-m-d', strtotime('+7 days'));  
                ?>
                <div class="dashboard_table dashboard_table_panel main_block">
                  <div class="row text-left">
                    
                    <div class="col-md-12">
                      <div class="dashboard_table_body main_block">
                        <div class="col-md-12 no-pad table_verflow"> 
                          <div class="table-responsive">
                            <table class="table table-hover" style="margin: 0 !important;border: 0;">
                              <thead>
                                <tr class="table-heading-row">
                                  <th>S_No.</th>
											            <th>Tour_Type</th>
                                  <th>Tour_Name</th>
                                  <th>Tour_Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                  <th>Customer_Name</th>
                                  <th>Mobile</th>
                                  <th>Owned&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                  <th>Checklist</th>
                                  <th>Checklist_Status</th>
                                  <th>Send_Wishes</th>
                                </tr>
                              </thead>
                              <tbody>
                             <!-- //package Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='package_booking/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query = "select * from package_tour_booking_master where tour_status!='Disabled' and financial_year_id='$financial_year_id' and tour_from_date > '$today1'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query .= " and emp_id='$emp_id'";
                              }
                            $sq_query = mysqlQuery($query);
                            while($row_query=mysqli_fetch_assoc($sq_query)){
                                $sq_cancel_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_query[booking_id]' and status='Cancel'"));
                                $sq_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_query[booking_id]'"));

                                if($row_query['dest_id']=='0'){
                                  $sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id='$row_query[package_id]'"));
                                  $dest_id = $sq_package['dest_id'];
                                }else{
                                  $dest_id = $row_query['dest_id'];
                                }
                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Package Tour' "));
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Package Tour' and status='Completed'"));
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Package Tour' and status='Not Updated'"));
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                  
                                if($sq_cancel_count != $sq_count){
                                  $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                  if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                    $customer_name = $sq_cust['company_name'];
                                  }else{
                                    $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                  }
                                  $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Package Tour</td>
                                  <td><?= ($row_query['tour_name']=='')?'NA':$row_query['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query['tour_from_date']).' To '.get_date_user($row_query['tour_to_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $row_query['mobile_no']; ?></td>
                                  <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['booking_id']; ?>','Package Tour');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $row_query['mobile_no'] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php } } ?>
                              <!-- Hotel Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='hotels/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              
                              $query1 = "select * from hotel_booking_entries where status!='Cancel' and DATE(check_in) >= '$today' and booking_id in(select booking_id from hotel_booking_master where emp_id='$emp_id' and financial_year_id='$financial_year_id') and status!='Cancel'";                              
                              $sq_query = mysqlQuery($query1);
                              while($row_query=mysqli_fetch_assoc($sq_query)){

                                $query = "select * from hotel_booking_master where booking_id = '$row_query[booking_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query .= " and emp_id='$emp_id'";
                                }
                                $sq = mysqlQuery($query);
                                while($sq_hotel = mysqli_fetch_assoc($sq)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);

                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Hotel Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Hotel Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Hotel Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Hotel Booking</td>
                                  <td><?= ($row_query['tour_name']=='')?'NA':$row_query['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query['check_in']).' To '.get_date_user($row_query['check_out']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['booking_id']; ?>','Hotel Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></i></button></td>
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php } } ?>
                              <!-- Flight Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_flight = "select * from  ticket_trip_entries where DATE(departure_datetime) > '$today' and ticket_id in(select ticket_id from ticket_master where emp_id='$emp_id') and ticket_id in(select ticket_id from ticket_master_entries where status!='Cancel') ";
                              $sq_query1 = mysqlQuery($query_flight);
                              while($row_query1=mysqli_fetch_assoc($sq_query1)){
                              
                                $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id = '$row_query1[ticket_id]'"));
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[ticket_id]' and tour_type='Flight Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[ticket_id]' and tour_type='Flight Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[ticket_id]' and tour_type='Flight Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Flight Booking</td>
                                  <td><?= $row_query1['arrival_city'] ?></td>
                                  <td><?= get_date_user($row_query1['departure_datetime']).' To '.get_date_user($row_query1['arrival_datetime']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['ticket_id']; ?>','Flight Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php } ?>
                              <!-- Train Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_train = "select * from  train_ticket_master_trip_entries where DATE(travel_datetime) > '$today' and train_ticket_id in(select train_ticket_id from train_ticket_master where emp_id='$emp_id') and train_ticket_id in(select train_ticket_id from train_ticket_master_entries where status!='Cancel')";
                              $sq_query_train = mysqlQuery($query_train);
                              while($row_query1=mysqli_fetch_assoc($sq_query_train)){
                                
                                $sq_train = mysqli_fetch_assoc(mysqlQuery("SELECT * from `train_ticket_master` where `train_ticket_id` = '$row_query1[train_ticket_id]'"));

                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_train[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_train[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[train_ticket_id]' and tour_type='Train Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[train_ticket_id]' and tour_type='Train Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[train_ticket_id]' and tour_type='Train Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Train Booking</td>
                                  <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query1['travel_datetime'])?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_train['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['train_ticket_id']; ?>','Train Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                  
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php } ?>
                              <!-- Bus Booking -->
                              <?php
                              $today1 = date('Y-m-d');
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='bus_booking/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_bus = "select * from bus_booking_entries where DATE(date_of_journey) > '$today' and booking_id in(select booking_id from bus_booking_master where emp_id='$emp_id' and financial_year_id='$financial_year_id') and status!='Cancel'";
                                    $sq_query_bus = mysqlQuery($query_bus);
                                    while($row_query1=mysqli_fetch_assoc($sq_query_bus)){
                                
                                $query1 = "select * from bus_booking_master where booking_id = '$row_query1[booking_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysqlQuery($query1);
                                while($sq_hotel = mysqli_fetch_assoc($sq)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);

                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Bus Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Bus Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Bus Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Bus Booking</td>
                                  <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query1['date_of_journey']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Bus Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                              <!-- Excursion Booking -->
                              <?php
                              $today1 = date('Y-m-d');
                              $add7days1 = date('Y-m-d', strtotime('+7 days'));
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='excursion/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_exc = "select * from  excursion_master_entries where DATE(exc_date) > '$today1' and exc_id in(select exc_id from excursion_master where emp_id='$emp_id' and financial_year_id='$financial_year_id') and status!='Cancel'";
                              $sq_query_exc = mysqlQuery($query_exc);
                              while($row_query1=mysqli_fetch_assoc($sq_query_exc)){
                                
                                $query1 = "select * from 	excursion_master where exc_id = '$row_query1[exc_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysqlQuery($query1);
                                while($sq_hotel = mysqli_fetch_assoc($sq)){
                                $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from 	city_master where city_id = '$row_query1[city_id]'"));
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);

                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[exc_id]' and tour_type='Excursion Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[exc_id]' and tour_type='Excursion Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[exc_id]' and tour_type='Excursion Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Activity Booking</td>
                                  <td><?php echo $sq_city['city_name']; ?></td>
                                  <td><?= get_date_user($row_query1['exc_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['exc_id']; ?>','Excursion Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                                <!-- Car Rental Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='car_rental/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_car = "select * from car_rental_booking where DATE(from_date) > '$today1' and travel_type ='Local' and emp_id='$emp_id' and status!='Cancel' and financial_year_id='$financial_year_id'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query_car .= " and emp_id='$emp_id'";
                              }

                                    $sq_query_car = mysqlQuery($query_car);
                                    while($row_query1=mysqli_fetch_assoc($sq_query_car)){
                                
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Car Rental Booking</td>
                                  <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query1['from_date']).' To '.get_date_user($row_query1['to_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Car Rental Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                              <?php } ?>
                              <?php
                              $query_car = "select * from car_rental_booking where DATE(traveling_date) > '$today1'  and travel_type ='Outstation' and status!='Cancel' and financial_year_id='$financial_year_id'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query_car .= " and emp_id='$emp_id'";
                              }

                              $sq_query_car = mysqlQuery($query_car);
                              while($row_query1=mysqli_fetch_assoc($sq_query_car)){
                                
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);$today1 = date('Y-m-d');
                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and status='Completed'"));
          
                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and status='Not Updated'"));
          
                                if($sq_total == $sq_notupdated){
          
                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){
          
                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){
          
                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{
          
                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Car Rental Booking</td>
                                  <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query1['traveling_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Car Rental Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                              <?php } ?>
                              <!-- Group Booking -->
                              <?php
                              $sq = mysqlQuery("select * from tourwise_traveler_details where 1 and emp_id='$emp_id' and financial_year_id='$financial_year_id' and tour_group_status!='Cancel'");
                              while($row_query = mysqli_fetch_assoc($sq)){
                                
                                $sq_trcount = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_query[traveler_group_id]' and status='Cancel'"));
                                if($sq_trcount == 0){
                                  $sq_booking1 = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id = '$row_query[tour_id]'"));
                                  $row_grps_count = mysqli_num_rows(mysqlQuery("select * from tour_groups where tour_id = '$row_query[tour_id]' and group_id='$row_query[tour_group_id]' and from_date >= '$today'"));
                                  if($row_grps_count > 0){
                                    $row_grps = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where tour_id = '$row_query[tour_id]' and group_id='$row_query[tour_group_id]' and from_date >= '$today'"));
                                    $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                    if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                      $customer_name = $sq_cust['company_name'];
                                    }else{
                                      $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                    }
                                    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                    $tour_id = $sq_booking1['tour_id'];
                                    $dest_id = $sq_booking1['dest_id'];

                                    $date1 = $row_query['form_date'];
                                    $yr1 = explode("-", $date1);
                                    $year1 = $yr1[0];

                                    $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[id]' and tour_type='Group Tour'"));							
                                    $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[id]' and tour_type='Group Tour' and status='Completed'"));
                                    
                                    $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query[id]' and tour_type='Group Tour' and status='Not Updated'"));
                                    if($sq_total == $sq_notupdated){
          
                                      $bg_color = 'rgba(244,106,106,.18)';
                                      $status = 'Not Updated';
                                      $text_color = '#f46a6a';
                                    }else if($sq_total == $sq_completed){
              
                                      $bg_color = 'rgba(52,195,143,.18);';
                                      $status = 'Completed';
                                      $text_color = '#34c38f;';
                                    }else if($sq_total == 0){
              
                                      $bg_color = '';
                                      $status = '';
                                      $text_color = '';
                                    }else{
              
                                      $bg_color = 'rgba(241,180,76,.18)';
                                      $status = 'Ongoing';
                                      $text_color = '#f1b44c';
                                    }
                                    ?>
                                      <tr class="<?= $bg ?>">
                                      <td><?php echo $count++; ?></td>
                                      <td>Group Booking(<?=get_group_booking_id($row_query['id'],$year1)?>)</td>
                                      <td><?php echo $sq_booking1['tour_name']; ?></td>
                                      <td><?= get_date_user($row_grps['from_date']).' To '.get_date_user($row_grps['to_date']) ?></td>
                                      <td><?php echo $customer_name; ?></td>
                                      <td><?php echo $contact_no; ?></td>
                                      <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                      <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['id']; ?>','Group Tour');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                      <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                      <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                      </tr>
                                  <?php }
                                }
                            }
                            ?>
                              <!-- Visa Booking -->
                              <?php
                              $sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='visa_passport_ticket/visa/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_visa = "select * from  visa_master_entries where appointment_date > '$today' and visa_id in(select visa_id from visa_master where emp_id='$emp_id' and financial_year_id='$financial_year_id')  and status!='Cancel'";
                                    $sq_query_visa = mysqlQuery($query_visa);
                              while($row_query_visa=mysqli_fetch_assoc($sq_query_visa)){
                                $query1 = "select * from visa_master where visa_id = '$row_query_visa[visa_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysqlQuery($query1);
                                while($sq_visa = mysqli_fetch_assoc($sq)){
                                $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                  $customer_name = $sq_cust['company_name'];
                                }else{
                                  $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                }
                                $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_total = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query_visa[visa_id]' and tour_type='Visa Booking'"));								
                                $sq_completed = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query_visa[visa_id]' and tour_type='Visa Booking' and status='Completed'"));

                                $sq_notupdated = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$row_query_visa[visa_id]' and tour_type='Visa Booking' and status='Not Updated'"));

                                if($sq_total == $sq_notupdated){

                                  $bg_color = 'rgba(244,106,106,.18)';
                                  $status = 'Not Updated';
                                  $text_color = '#f46a6a';
                                }else if($sq_total == $sq_completed){

                                  $bg_color = 'rgba(52,195,143,.18);';
                                  $status = 'Completed';
                                  $text_color = '#34c38f;';
                                }else if($sq_total == 0){

                                  $bg_color = '';
                                  $status = '';
                                  $text_color = '';
                                }else{

                                  $bg_color = 'rgba(241,180,76,.18)';
                                  $status = 'Ongoing';
                                  $text_color = '#f1b44c';
                                }
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Visa Booking</td>
                                  <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                  <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query_visa['visa_id']; ?>','Visa Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                                <!-- Miscellaneous Booking -->
                                <?php
                                $query_pass = "select * from miscellaneous_master where DATE(created_at) > '$today' and misc_id in(SELECT `misc_id` FROM `miscellaneous_master_entries` WHERE `status`!='Cancel') and emp_id='$emp_id' order by misc_id desc";
                                $sq_query_pass = mysqlQuery($query_pass);
                                while($row_query_visa=mysqli_fetch_assoc($sq_query_pass)){
                                  $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$row_query_visa[customer_id]'"));
                                  if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
                                    $customer_name = $sq_cust['company_name'];
                                  }else{
                                    $customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
                                  }
                                  $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                  $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_query_visa[emp_id]'"));
                                  ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Miscellaneous Booking</td>
                                  <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                  <td><?= get_date_user($row_query_visa['created_at']) ?></td>
                                  <td><?php echo $customer_name; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($row_query_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center">NA</td>

                                  <td class="text-center">NA</td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $contact_no ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="Whatsapp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <!-- Upcoming FIT Tour summary End -->

            <!-- Weekly Followups -->
            <div role="tabpanel" class="tab-pane active" id="week_fol_tab">
              <div class="dashboard_table dashboard_table_panel main_block">
              <div class="row text-left">
                <div class="col-md-6">
                  <div class="dashboard_table_heading main_block">
                    <div class="col-md-12 no-pad">
                      <h3>Followup Reminders</h3>
                    </div>
                  </div>
                </div>
							  <div class="col-md-1"></div>
								<div class="col-md-2 col-sm-6 mg_bt_10">
									<input type="text" id="followup_from_date_filter" name="followup_from_date_filter" placeholder="Followup From D/T" title="Followup From D/T" onchange="get_to_datetime(this.id,'followup_to_date_filter')">
								</div>
								<div class="col-md-2 col-sm-6 mg_bt_10">
									<input type="text" id="followup_to_date_filter" name="followup_to_date_filter" placeholder="Followup To D/T" title="Followup To D/T" onchange="validate_validDatetime('followup_from_date_filter','followup_to_date_filter')">
								</div>
								<div class="col-md-1 text-left col-sm-6 mg_bt_10">
									<button class="btn btn-excel btn-sm" id="followup_reflect1" onclick="followup_reflect()" data-toggle="tooltip" title="" data-original-title="Proceed"><i class="fa fa-arrow-right"></i></button>
								</div>
								<div id='followup_data'></div>
              </div>
              </div>
              <div id="history_data"></div>
            </div>
            <!-- Weekly Followups end -->
            <!-- Weekly Task -->
            <div role="tabpanel" class="tab-pane" id="week_task_tab">
              <?php
              $assigned_task_count = mysqli_num_rows(mysqlQuery("select task_id from tasks_master where emp_id='$emp_id' and task_status!='Disabled'"));
              $can_task_count = mysqli_num_rows(mysqlQuery("select task_id from tasks_master where emp_id='$emp_id' and task_status='Cancelled'"));
              $completed_task_count = mysqli_num_rows(mysqlQuery("select task_id from tasks_master where emp_id='$emp_id' and task_status='Completed'"));
              ?>
              <div class="dashboard_table dashboard_table_panel main_block">
                <div class="row text-left">
                    <div class="col-md-12">
                      <div class="dashboard_table_heading main_block">
                        <div class="col-md-12 no-pad">
                          <h3>Allocated Tasks</h3>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="dashboard_table_body main_block">
                        <div class="col-sm-9 no-pad table_verflow table_verflow_two"> 
                          <div class="table-responsive no-marg-sm">
                            <table class="table table-hover" style="margin: 0 !important;border: 0;">
                              <thead>
                                <tr class="table-heading-row">
                                  <th>Task_Name</th>
                                  <th>Task_Type</th>
                                  <th>ID/Enq_No.</th>
                                  <th>Assign_Date</th>
                                  <th>Due_Date&Time</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                               $sq_task = mysqlQuery("select * from tasks_master where emp_id='$emp_id' and (task_status='Created' or task_status='Incomplete') order by task_id");
                               while($row_task = mysqli_fetch_assoc($sq_task)){ 
                                  $count++;
                                  if($row_task['task_status'] == 'Created'){
                                    $bg='warning';
                                  }
                                  elseif($row_task['task_status'] == 'Incomplete' ){
                                    $bg='danger';
                                  }
                                  if($row_task['task_type'] == 'Package Tour'){

                                    $sq_booking = mysqli_fetch_assoc(mysqlQuery("select booking_date,booking_id from package_tour_booking_master where booking_id='$row_task[task_type_field_id]'"));
                                    $date = $sq_booking['booking_date'];
                                    $yr = explode("-", $date);
                                    $year =$yr[0];
                                    $booking_id = get_package_booking_id($sq_booking['booking_id'],$year);
                                  }
                                  else if($row_task['task_type'] == 'Group Tour'){

                                    $sq_booking = mysqli_fetch_assoc(mysqlQuery("select form_date,id from tourwise_traveler_details where id='$row_task[task_type_field_id]'"));
                                    $date = $sq_booking['form_date'];
                                    $yr = explode("-", $date);
                                    $year =$yr[0];
                                    $booking_id = get_group_booking_id($sq_booking['id'],$year);
                                  }
                                  else if($row_task['task_type'] == 'Enquiry'){

                                    $sq_booking = mysqli_fetch_assoc(mysqlQuery("select enquiry_date,enquiry_id from enquiry_master where enquiry_id='$row_task[task_type_field_id]'"));
                                    $date = $sq_booking['enquiry_date'];
                                    $yr = explode("-", $date);
                                    $year =$yr[0];
                                    $booking_id = get_enquiry_id($sq_booking['enquiry_id'],$year);
                                  }
                                  else{
                                    $booking_id = 'NA';
                                  }
                              ?>
                                  <tr class="odd">
                                    <td><?php echo $row_task['task_name']; ?></td>
                                    <td><?php echo $row_task['task_type']; ?></td>
                                    <td><?php echo $booking_id; ?></td>
                                    <td><?php echo get_date_user($row_task['created_at']); ?></td>
                                    <td><?php echo get_datetime_user($row_task['due_date']); ?></td>
                                    <td><span class="<?= $bg ?>"><?php echo $row_task['task_status']; ?></span></td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="col-sm-3 no-pad">
                          <div class="table_side_widget_panel main_block">
                            <div class="table_side_widget_content main_block">
                              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                <div class="table_side_widget">
                                  <div class="table_side_widget_amount"><?= $assigned_task_count ?></div>
                                  <div class="table_side_widget_text widget_blue_text">Total Task</div>
                                </div>
                              </div>
                              <div class="col-xs-6" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                <div class="table_side_widget">
                                  <div class="table_side_widget_amount"><?= $completed_task_count ?></div>
                                  <div class="table_side_widget_text widget_green_text">Task Completed</div>
                                </div>
                              </div>
                              <div class="col-xs-6" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                <div class="table_side_widget">
                                  <div class="table_side_widget_amount"><?= $can_task_count ?></div>
                                  <div class="table_side_widget_text widget_red_text">Task Cancelled</div>
                                </div>
                              </div>
                              <div class="col-xs-12">
                                <div class="table_side_widget">
                                  <div class="table_side_widget_amount"><?= $assigned_task_count-$completed_task_count-$can_task_count ?></div>
                                  <div class="table_side_widget_text widget_yellow_text">Task Pending</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div> 
            </div>
            <!-- Weekly Task end -->
          </div>
        </div>
      </div>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#followup_from_date_filter, #followup_to_date_filter').datetimepicker({format:'d-m-Y H:i' });
  function send_sms(id,tour_type,emp_id,contact_no, name){
    var base_url = $('#base_url').val();
    var draft = "Hello Dear "+name+",We hope that you are enjoying your trip. It will be a great source of input from you, if you can share your tour feedback with us, so that we can serve you even better.Thank you."
    $('#send_btn').button('loading');
      $.ajax({
      type:'post',
      url: base_url+'controller/dashboard_sms_send.php',
      data:{ draft : draft,enquiry_id : id,mobile_no : contact_no},
      success: function(message){
        msg_alert("Feedback sent successfully");
        $('#send_btn').button('reset'); 
      }
      });
      web_whatsapp_open(contact_no,name);
  }
function web_whatsapp_open(mobile_no,name){
  var link = 'https://web.whatsapp.com/send?phone='+mobile_no+'&text=Hello%20Dear%20'+encodeURI(name)+',%0aWe%20hope%20that%20you%20are%20enjoying%20your%20trip.%20It%20will%20be%20a%20great%20source%20of%20input%20from%20you,%20if%20you%20can%20share%20your%20tour%20feedback%20with%20us,%20so%20that%20we%20can%20serve%20you%20even%20better.%0aThank%20you.';
  window.open(link);
}
  function whatsapp_wishes(number,name){
	var msg = encodeURI("Hello Dear "+ name +",\nMay this trip turns out to be a wonderful treat for you and may you create beautiful memories throughout this trip to cherish forever. Wish you a very happy and safe journey!!\nThank you.");
	window.open('https://web.whatsapp.com/send?phone='+number+'&text='+msg);
}
  function checklist_update(booking_id,tour_type){
	
	$.post('backoffice/update_checklist.php', { booking_id:booking_id,tour_type:tour_type}, function(data){
		$('#id_proof2').html(data);
	});
}
	function display_history(enquiry_id)
	{
		$.post('admin/followup_history.php', { enquiry_id : enquiry_id }, function(data){
		$('#history_data').html(data);
		});
  }
  function Followup_update(enquiry_id)
{
  $.post('admin/followup_update.php', { enquiry_id : enquiry_id }, function(data){
    $('#history_data').html(data);
  });
}
function followup_type_reflect(followup_status){
	$.post('admin/followup_type_reflect.php', {followup_status : followup_status}, function(data){
		$('#followup_type').html(data);
	}); 
}
	followup_reflect();
	function followup_reflect(){
		var from_date = $('#followup_from_date_filter').val();
		var to_date = $('#followup_to_date_filter').val();
		$.post('backoffice/followup_list_reflect.php', { from_date : from_date,to_date:to_date }, function(data){
			$('#followup_data').html(data);
		});
	}
</script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script type="text/javascript">
    (function($) {
        fakewaffle.responsiveTabs(['xs', 'sm']);
    })(jQuery);
  </script>