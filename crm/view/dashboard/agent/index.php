<?php
$login_id = $_SESSION['login_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$emp_id = $_SESSION['emp_id'];
//**Enquiries
$added_enq_count = mysqli_num_rows(mysqlQuery("select enquiry_id from enquiry_master where login_id='$login_id' and status!='Disabled'"));
$assigned_enq_count = mysqli_num_rows(mysqlQuery("select enquiry_id from enquiry_master where assigned_emp_id='$emp_id' and status!='Disabled' and financial_year_id='$financial_year_id'"));

$converted_count = 0;
$closed_count = 0;
$followup_count = 0;
$infollowup_count = 0;

$sq_enquiry = mysqlQuery("select * from enquiry_master where status!='Disabled' and financial_year_id='$financial_year_id' and assigned_emp_id='$emp_id'");
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

$total_tour_fee = 0; $incentive_total = 0;
$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$emp_id'"));
if($sq_emp['target'] == ''){ $sq_emp['target'] =0; }

$cur_date= date('Y/m/d H:i');
$search_form = date('Y-m-01 H:i',strtotime($cur_date));
$search_to =  date('Y-m-t H:i',strtotime($cur_date));

//Completed Target                
$sq_group_bookings = mysqlQuery("select * from tourwise_traveler_details where emp_id = '$emp_id' and financial_year_id='$financial_year_id' and  tour_group_status != 'Cancel' and (form_date between '$search_form' and '$search_to')");

$total_group  = 0;
while($row_group_bookings = mysqli_fetch_assoc($sq_group_bookings))
{
  // Group booking cancel
  $cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_group_bookings[id]'"));
  if($cancel_esti_count1 != '0'){
    $tour_total_amount1 = 0;
  }
  else
  { 
    $tour_total_amount1 = $row_group_bookings['net_total']; 
  }
  $total_group = $total_group + $tour_total_amount1;
}

  $sq_package_booking = mysqlQuery("select * from package_tour_booking_master where emp_id ='$emp_id' and financial_year_id='$financial_year_id' and tour_status !='Cancel' and (booking_date between '$search_form' and '$search_to')");
  $total_package = 0;
  while($row_package_booking = mysqli_fetch_assoc($sq_package_booking)){
    $sq_can_count = mysqli_num_rows(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$row_package_booking[booking_id]'"));
    if($sq_can_count == '0')
    {  
      //Tour Total
      $total_tour_amount = $row_package_booking['net_total'];
    } 
    else{
      $total_tour_amount = 0;
    }
    $total_package += $total_tour_amount;
  }
  $completed_amount = $total_package + $total_group;

// Incentive
// $sq_incentive1 = mysqlQuery("select * from booker_incentive_group_tour where emp_id='$emp_id' and financial_year_id='$financial_year_id'");  
// while($row_group_bookings = mysqli_fetch_assoc($sq_incentive1)){
//     $incentive_total = $incentive_total + $row_group_bookings['basic_amount'];
// }

// $sq_incentive2 = mysqlQuery("select * from booker_incentive_package_tour where emp_id='$emp_id' and financial_year_id='$financial_year_id'");
// while($row_package_booking = mysqli_fetch_assoc($sq_incentive2)){
//     $incentive_total = $incentive_total + $row_package_booking['basic_amount'];
// }
?>
<div class="app_panel">
<div class="dashboard_panel panel-body">

      <div class="dashboard_widget_panel dashboard_widget_panel_first main_block mg_bt_25">
            <div class="row">
              <div class="col-md-6">
                  <div class="dashboard_widget main_block mg_bt_10_xs">

                    <div class="dashboard_widget_title_panel main_block widget_red_title">

                      <div class="dashboard_widget_icon">

                        <i class="fa fa-bullseye" aria-hidden="true"></i>

                      </div>

                      <div class="dashboard_widget_title_text" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">

                        <h3>Leads</a></h3>

                        <p>Total Leads Summary</p>

                      </div>

                    </div>

                    <div class="dashboard_widget_conetent_panel main_block">
                    <div class="col-md-12">
                      <div class="col-sm-1">
                      </div>
                      <div class="col-sm-2" style="border-right: 1px solid #e6e4e5;padding:0">

                        <div class="dashboard_widget_single_conetent">

                          <span class="dashboard_widget_conetent_amount"><?php echo $assigned_enq_count; ?></span>

                          <span class="dashboard_widget_conetent_text widget_blue_text">Total</span>

                        </div>

                      </div>

                      <div class="col-sm-2" style="border-right: 1px solid #e6e4e5;padding:0">

                        <div class="dashboard_widget_single_conetent">

                          <span class="dashboard_widget_conetent_amount"><?php echo $followup_count; ?></span>

                          <span class="dashboard_widget_conetent_text widget_yellow_text">Active</span>

                        </div>

                      </div>

                      <div class="col-sm-2" style="border-right: 1px solid #e6e4e5;padding:0">

                        <div class="dashboard_widget_single_conetent">

                          <span class="dashboard_widget_conetent_amount"><?php echo $infollowup_count; ?></span>

                          <span class="dashboard_widget_conetent_text widget_gray_text">In-Followup</span>

                        </div>

                      </div>

                      <div class="col-sm-2" style="border-right: 1px solid #e6e4e5;padding:0">

                        <div class="dashboard_widget_single_conetent">

                          <span class="dashboard_widget_conetent_amount"><?php echo $converted_count; ?></span>

                          <span class="dashboard_widget_conetent_text widget_green_text">Converted</span>

                        </div>

                      </div>

                      <div class="col-sm-2">

                        <div class="dashboard_widget_single_conetent">
                          <span class="dashboard_widget_conetent_amount"><?php echo $closed_count; ?></span>
                          <span class="dashboard_widget_conetent_text widget_red_text">Dropped</span>
                        </div>

                      </div>

                    </div>  
                    </div>

                    </div>  

              </div>
              <?php 
              $total_tour_fee = 0; $incentive_total = 0;
              $total_forex_cost = 0;  $total_visa_cost = 0;
              $total_train_cost = 0;  $total_ticket_cost = 0;
              $total_pass_cost = 0;   $total_misc_cost = 0;
              $total_hotel_cost = 0;  $total_car_cost = 0;
              $total_exc_cost = 0;    $total_bus_cost = 0;
              $package_tour_cost = 0; $grp_tour_cost = 0;
              $inc_amt=0;
              $a_date = date('Y-m-d');

              $last_day_this_month =  date("Y-m-t", strtotime($a_date));
              
              $first_day_this_month= date("Y-m-1", strtotime($a_date));
              
              $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$emp_id'"));
              $cur_date= date('Y/m/d H:i');
              $search_form = date('Y-m-01 H:i',strtotime($cur_date));
              $search_to =  date('Y-m-t H:i',strtotime($cur_date));
              
              //Completed Target                
              $sq_group_bookings = mysqlQuery("select * from tourwise_traveler_details where emp_id = '$emp_id' and financial_year_id='$financial_year_id' and (form_date between '$first_day_this_month' and '$last_day_this_month')");
              while($row_group_bookings = mysqli_fetch_assoc($sq_group_bookings)){

                $pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_group_bookings[id]'"));
                $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_group_bookings[id]' and status='Cancel'"));
                if($row_group_bookings['tour_group_status']!="Cancel" && $pass_count!=$cancelpass_count){
                  $total_tour_fee = $total_tour_fee + $row_group_bookings['net_total'];
                }
              }

              $sq_package_booking = mysqlQuery("select * from package_tour_booking_master where emp_id ='$emp_id' and financial_year_id='$financial_year_id' and (booking_date between '$first_day_this_month' and '$last_day_this_month')");
              while($row_package_booking = mysqli_fetch_assoc($sq_package_booking)){
                $pass_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_package_booking[booking_id]'"));
			          $cancle_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_package_booking[booking_id]' and status='Cancel'"));
                if($pass_count!=$cancle_count){
                  $total_tour_fee = $total_tour_fee + $row_package_booking['net_total'] ;
                }
              }

               $sq_bus = mysqlQuery("select * from bus_booking_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'"); 
              //  echo $sq_bus;   
                while($sq_total_amount = mysqli_fetch_assoc($sq_bus)){

                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  bus_booking_entries where booking_id='$sq_total_amount[booking_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  bus_booking_entries where booking_id='$sq_total_amount[booking_id]' and status='Cancel'"));
                  if( $pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['net_total'];
                    $total_bus_cost = $total_bus_cost+$total_exp_amount;
                  } 
                }
                $sq_exc=mysqlQuery("select * from excursion_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_exc)){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  excursion_master_entries where exc_id='$sq_total_amount[exc_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  excursion_master_entries where exc_id='$sq_total_amount[exc_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['exc_total_cost'];
                    $total_exc_cost = $total_exc_cost+$total_exp_amount;
                  }
                }
                $sq_car = mysqlQuery("select * from car_rental_booking where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id' and status!='Cancel'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_car)){
                  
                    $total_exp_amount = $sq_total_amount['total_fees'];
                    $total_car_cost = $total_car_cost +  $total_exp_amount;
                  
                }
                $sq_hotel = mysqlQuery("select * from hotel_booking_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_hotel )){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  hotel_booking_entries where booking_id='$sq_total_amount[booking_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  hotel_booking_entries where booking_id='$sq_total_amount[booking_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['total_fee'];
                    $total_hotel_cost = $total_hotel_cost +  $total_exp_amount;
                  }
                }
                $sq_misc = mysqlQuery("select * from miscellaneous_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while( $sq_total_amount = mysqli_fetch_assoc($sq_misc)){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  miscellaneous_master_entries where misc_id='$sq_total_amount[misc_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  miscellaneous_master_entries where misc_id='$sq_total_amount[misc_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['misc_total_cost'];
                    $total_misc_cost = $total_misc_cost +  $total_exp_amount;
                  }
                }
                $sq_pass = mysqlQuery("select * from passport_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_pass)){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  passport_master_entries where passport_id='$sq_total_amount[passport_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  passport_master_entries where passport_id='$sq_total_amount[passport_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['passport_total_cost'];
                    $total_pass_cost = $total_pass_cost +  $total_exp_amount;
                  }
                }
                $sq_ticket = mysqlQuery("select * from ticket_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_ticket)){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  passport_master_entries where passport_id='$sq_total_amount[passport_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  passport_master_entries where passport_id='$sq_total_amount[passport_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['ticket_total_cost'];
                    $total_ticket_cost = $total_ticket_cost +  $total_exp_amount;
                  }
                }
                $sq_train = mysqlQuery("select * from train_ticket_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_train)){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  ticket_master_entries where ticket_id='$sq_total_amount[ticket_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  ticket_master_entries where ticket_id='$sq_total_amount[ticket_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['net_total'];
                    $total_train_cost = $total_train_cost +  $total_exp_amount;
                  }
                }
                $sq_visa = mysqlQuery("select * from visa_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_visa)){
                  $pass_count = mysqli_num_rows(mysqlQuery("select * from  visa_master_entries where visa_id='$sq_total_amount[visa_id]'"));
                  $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  visa_master_entries where visa_id='$sq_total_amount[visa_id]' and status='Cancel'"));
                  if($pass_count!=$cancelpass_count){
                    $total_exp_amount = $sq_total_amount['visa_total_cost'];
                    $total_visa_cost = $total_visa_cost +  $total_exp_amount;
                  }
                }
                $sq_forex = mysqlQuery("select * from forex_booking_master
                    where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysqli_fetch_assoc($sq_forex)){
                    $total_exp_amount = $sq_total_amount['net_total'];
                    $total_forex_cost = $total_forex_cost +  $total_exp_amount;
                }
                $ince_amount= $total_forex_cost+$total_visa_cost+$total_train_cost+$total_ticket_cost+$total_pass_cost+$total_misc_cost+$total_hotel_cost+$total_car_cost+$total_exc_cost+$total_bus_cost+$total_tour_fee;

              //target
                $target = ($sq_emp['target']!='')?$sq_emp['target']:'0';
              // Incentive
               $sql_inc =mysqlQuery("select * from booker_sales_incentive where emp_id='$emp_id' and financial_year_id='$financial_year_id' and booking_date<='$last_day_this_month' and booking_date>='$first_day_this_month' ");
               while($row =mysqli_fetch_assoc($sql_inc)){
                   $inc_amt = $inc_amt + $row['incentive_amount'];
               }
              
              ?>
              <div class="col-md-6">
                <div class="dashboard_widget main_block">
                  <div class="dashboard_widget_title_panel main_block widget_purp_title" >
                    <div class="dashboard_widget_icon">
                      <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    </div>
                    <div class="dashboard_widget_title_text">
                      <h3>achievements</h3>
                      <p>Total Achievements Summary</p>
                    </div>
                  </div>
                  <div class="dashboard_widget_conetent_panel main_block">
                    <div class="col-sm-4" style="border-right: 1px solid #e6e4e5">
                      <div class="dashboard_widget_single_conetent">
                        <span class="dashboard_widget_conetent_amount"><?php echo number_format($target,2); ?></span>
                        <span class="dashboard_widget_conetent_text widget_blue_text">Target</span>
                      </div>
                    </div>
                    <div class="col-sm-4" style="border-right: 1px solid #e6e4e5">
                      <div class="dashboard_widget_single_conetent">
                        <span class="dashboard_widget_conetent_amount"><?php echo number_format($ince_amount,2); ?></span>
                        <span class="dashboard_widget_conetent_text widget_green_text">Completed</span>
                      </div>
                    </div>
                    <!-- <div class="col-sm-4 last_block">
                      <div class="dashboard_widget_single_conetent">
                        <span class="dashboard_widget_conetent_amount"><?php echo number_format($inc_amt,2); ?></span>
                        <span class="dashboard_widget_conetent_text widget_yellow_text">Incentives</span>
                      </div>
                    </div> -->
                  </div>  
                </div>
              </div>
      </div>
   </div>

  
   <!-- dashboard_tab -->
           <div class="row">
            <div class="col-md-12">
              <div class="dashboard_tab text-center">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs responsive" role="tablist">
                  <li role="presentation" class="active"><a href="#follow_tab" aria-controls="follow_tab" role="tab" data-toggle="tab">Followups</a></li>
                  <!-- <li role="presentation"><a href="#incent_tab" aria-controls="incent_tab" role="tab" data-toggle="tab">Incentive</a></li></li> -->
                </ul>
                <!-- Tab panes -->
                <div class="tab-content responsive main_block">
                  <!-- Enquiry & Followup summary -->
                  <div role="tabpanel" class="tab-pane active" id="follow_tab">
                        <div class="dashboard_table dashboard_table_panel main_block">
                          <div class="row text-left">
                            <div class="col-md-6">
                              <div class="dashboard_table_heading main_block">
                                <div class="col-md-10 no-pad">
                                  <h3 style="cursor: pointer;" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">Followup Reminders</h3>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2 col-sm-6 mg_bt_10">
                              <input type="text" id="followup_from_date_filter" name="followup_from_date_filter" placeholder="Followup From D/T" title="Followup From D/T">
                            </div>
                            <div class="col-md-2 col-sm-6 mg_bt_10">
                              <input type="text" id="followup_to_date_filter" name="followup_to_date_filter" placeholder="Followup To D/T" title="Followup To D/T">
                            </div>
                            <div class="col-md-1 text-left col-sm-6 mg_bt_10">
                              <button class="btn btn-excel btn-sm" id="followup_reflect1" onclick="followup_reflect()" data-toggle="tooltip" title="" data-original-title="Proceed"><i class="fa fa-arrow-right"></i></button>
                            </div>
                            <div id='followup_data'></div>

                          </div>

                        </div>

                    <div id="history_data"></div>
                  </div>
                  <!-- Enquiry & Followup summary End -->

                  <!-- Incentive -->
                  <div role="tabpanel" class="tab-pane" id="incent_tab">
                      <div class="dashboard_table dashboard_table_panel main_block">

                        <div class="row text-left">

                          <div class="col-md-12">

                            <div class="dashboard_table_heading main_block">

                              <div class="col-md-8 no-pad">

                                <h3 style="cursor: pointer;" onclick="window.open('<?= BASE_URL ?>view/booker_incentive/booker_incentive.php', 'My Window');">Incentive/Commission</h3>

                              </div>

                              <div class="col-md-2 col-xs-12 mg_bt_10_sm_xs no-pad-sm">

                                  <input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="booking_list_reflect()">

                              </div>

                              <div class="col-md-2 col-xs-12 no-pad-sm">

                                  <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="booking_list_reflect()">

                              </div>

                            </div>

                          </div>

                          <div class="col-md-12">

                            <div class="dashboard_table_body main_block">

                              <div class="col-md-12 no-pad  table_verflow"> 

                                  <div id="div_booker_incentive_reflect">

                                  </div>                     

                              </div>

                            </div>

                          </div>

                        </div>

                      </div>
                  </div>
                  <!-- Incentive End -->

                </div>
              </div>
            </div>
          </div>
    </div>
  </div>

<script type="text/javascript">
  $('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#followup_from_date_filter, #followup_to_date_filter').datetimepicker({format:'d-m-Y H:i' });
	followup_reflect();
	function followup_reflect(){
		var from_date = $('#followup_from_date_filter').val();
		var to_date = $('#followup_to_date_filter').val();
		$.post('agent/followup_list_reflect.php', { from_date : from_date,to_date:to_date }, function(data){
			$('#followup_data').html(data);
		});
	}

  function booking_list_reflect()

  {

    var from_date = $('#from_date').val();

    var to_date = $('#to_date').val();

    $.post('agent/incentive_list_reflect.php', { from_date : from_date, to_date : to_date }, function(data){

      $('#div_booker_incentive_reflect').html(data);

    });

  }

  booking_list_reflect();

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
</script>