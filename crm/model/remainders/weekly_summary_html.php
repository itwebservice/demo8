<?php
include_once('../model.php');
$theme_color = "#36aae7"; $theme_color_dark = "#239ede"; $theme_color_2 = "#1d4372"; $topbar_color = "#ffffff"; $sidebar_color = "#36aae7"; 
?>
<?php 
$week_start_date = date('Y-m-d', strtotime('-5 days'));
$converted_count = 0;
$closed_count = 0;
$followup_count = 0;
$inf_count = 0;

//************************************Enquiy summary ***********************************************//
$cur_date = date('Y-m-d');
$day = date("D", strtotime($cur_date));
$sq_enquiry = mysqlQuery("select * from enquiry_master where status!='Disabled' and enquiry_date between '$week_start_date' and '$cur_date'");
while($row_enq = mysqli_fetch_assoc($sq_enquiry)){

    $sq_enquiry_entry = mysqli_fetch_assoc(mysqlQuery("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
    if($sq_enquiry_entry['followup_status']=="In-Followup"){
        $inf_count++;
    }

    if($sq_enquiry_entry['followup_status']=="Dropped"){
        $closed_count++;
    }

    if($sq_enquiry_entry['followup_status']=="Converted"){
        $converted_count++;
    }
    if($sq_enquiry_entry['followup_status']=="Active"){
        $followup_count++;
    }
}

//************************************Task summary ***********************************************//
$sq_task =mysqli_num_rows(mysqlQuery("select * from tasks_master where remind_due_date between '$week_start_date' and '$cur_date' "));

$sq_task_complete =mysqli_num_rows(mysqlQuery("select * from tasks_master where remind_due_date between '$week_start_date' and '$cur_date' and task_status='Completed' "));

$sq_task_active =mysqli_num_rows(mysqlQuery("select * from tasks_master where remind_due_date between '$week_start_date' and '$cur_date' and task_status='Created' "));

//************************************Sale summary ***********************************************//
//Group booking
$sq_group_booking = 0;
$group_amount = 0;
$tourwise_details = mysqlQuery("select * from tourwise_traveler_details where DATE(form_date) between '$week_start_date' and '$cur_date' and tour_group_status!='Cancel'");
while($row_group = mysqli_fetch_assoc($tourwise_details)){

  $pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_group[id]'"));
	$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_group[id]' and status='Cancel'"));
  if($pass_count != $cancelpass_count){
    $total_amount= $row_group['net_total'];
    $sq_group_booking++;
    $group_amount = $group_amount + $total_amount;
  }
}

//Package booking
$sq_package_booking = 0;
$package_amount = 0;
$sq_package = mysqlQuery("select * from package_tour_booking_master where booking_date between '$week_start_date' and '$cur_date'");
while($row_package = mysqli_fetch_assoc($sq_package)){

  //Tour TOtal
  $pass_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_package[booking_id]'"));
  $cancle_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_package[booking_id]' and status='Cancel'"));
	if($pass_count != $cancle_count){
    $sq_package_booking++;
    $tour_amount = $row_package['net_total'];
    $package_amount = $package_amount + $tour_amount;
  }
}

// Visa booking
$sq_visa_booking = 0;
$visa_amount = 0;
$sq_visa = mysqlQuery("select * from visa_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_visa = mysqli_fetch_assoc($sq_visa)){

  $pass_count = mysqli_num_rows(mysqlQuery("select * from  visa_master_entries where visa_id='$row_visa[visa_id]'"));
  $cancel_count = mysqli_num_rows(mysqlQuery("select * from  visa_master_entries where visa_id='$row_visa[visa_id]' and status='Cancel'"));
  if($pass_count!=$cancel_count){
    $visa_amount = $visa_amount + $row_visa['visa_total_cost'];
    $sq_visa_booking++;
  }
}

//Passport booking
$sq_passport_booking = 0;
$passport_amount = 0;
$sq_pass = mysqlQuery("select * from passport_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_pass = mysqli_fetch_assoc($sq_pass)){

	$pass_count = mysqli_num_rows(mysqlQuery("select * from  passport_master_entries where passport_id='$row_pass[passport_id]'"));
	$cancel_count = mysqli_num_rows(mysqlQuery("select * from  passport_master_entries where passport_id='$row_pass[passport_id]' and status='Cancel'"));
	if($pass_count!=$cancel_count){
    $passport_amount = $passport_amount + $row_pass['passport_total_cost'];
    $sq_passport_booking++;
  }
}

// Air ticket booking
$sq_air_booking =mysqli_num_rows(mysqlQuery("select * from ticket_master where DATE(created_at) between '$week_start_date' and '$cur_date'"));
$air_amount = 0;
$sq_air = mysqlQuery("select * from ticket_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_air = mysqli_fetch_assoc($sq_air)){

    $pass_count = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id='$row_air[ticket_id]'"));
    $cancel_count = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id='$row_air[ticket_id]' and status='Cancel'"));
    if($pass_count!=$cancel_count){
      $air_amount = $air_amount + $row_air['ticket_total_cost'];
      $sq_air_booking++;
    }
}

//Train booking
$sq_train_booking = 0;
$train_amount = 0;
$sq_train = mysqlQuery("select * from train_ticket_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_train = mysqli_fetch_assoc($sq_train)){
	$pass_count = mysqli_num_rows(mysqlQuery("select * from  train_ticket_master_entries where train_ticket_id='$row_train[train_ticket_id]'"));
	$cancel_count = mysqli_num_rows(mysqlQuery("select * from  train_ticket_master_entries where train_ticket_id='$row_train[train_ticket_id]' and status='Cancel'"));
  if($pass_count!=$cancel_count){
    $train_amount = $train_amount + $row_train['net_total'];
    $sq_train_booking++;
  }
}

//Bus booking
$sq_bus_booking = 0;
$bus_amount = 0;
$sq_bus = mysqlQuery("select * from bus_booking_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_bus = mysqli_fetch_assoc($sq_bus)){
  $pass_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id='$row_bus[booking_id]'"));
  $cancel_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id='$row_bus[booking_id]' and status='Cancel'"));
  if($pass_count!=$cancel_count){
    $bus_amount = $bus_amount + $row_bus['net_total'];
    $sq_bus_booking++;
  }
}

// Car rental booking
$sq_car_booking =mysqli_num_rows(mysqlQuery("select * from car_rental_booking where traveling_date between '$week_start_date' and '$cur_date' and status!='Cancel'"));
$car_amount = 0;
$sq_car = mysqlQuery("select * from car_rental_booking where traveling_date between '$week_start_date' and '$cur_date' and status!='Cancel'");
while($row_car = mysqli_fetch_assoc($sq_car)){
    $car_amount = $car_amount + $row_car['total_fees'];
}

//forex booking 
$sq_forex_booking =mysqli_num_rows(mysqlQuery("select * from forex_booking_master where DATE(created_at) between '$week_start_date' and '$cur_date'"));
$forex_amount = 0;
$sq_forex = mysqlQuery("select * from forex_booking_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_forex = mysqli_fetch_assoc($sq_forex)){
    $forex_amount = $forex_amount + $row_forex['net_total'];
}

// Hotel booking
$sq_hotel_booking = 0;        
$hotel_amount = 0;
$sq_hotel = mysqlQuery("select * from hotel_booking_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
  $pass_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id='$row_hotel[booking_id]'"));
  $cancel_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id='$row_hotel[booking_id]' and status='Cancel'"));
  if($pass_count!=$cancel_count){
    $hotel_amount = $hotel_amount + $row_hotel['total_fee'];
    $sq_hotel_booking++;
  }
}

// Excursion booking
$sq_exc_booking =mysqli_num_rows(mysqlQuery("select * from excursion_master where DATE(created_at) between '$week_start_date' and '$cur_date'"));        
$exc_amount = 0;
$sq_exc = mysqlQuery("select * from excursion_master where DATE(created_at) between '$week_start_date' and '$cur_date'");
while($row_exc = mysqli_fetch_assoc($sq_exc)){
  $pass_count = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id='$row_exc[exc_id]'"));
  $cancel_count = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id='$row_exc[exc_id]' and status='Cancel'"));
  if($pass_count!=$cancel_count){
    $exc_amount = $exc_amount + $row_exc['exc_total_cost'];
    $sq_exc_booking++;
  }
}

$total_sale_amount = $group_amount + $package_amount + $visa_amount + $passport_amount + $air_amount + $train_amount + $bus_amount + $car_amount + $forex_amount + $hotel_amount + $exc_amount;

//****************************** Purchase Report ********************************//

//Hotel vendor
$sq_hotel_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Hotel Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_hotel = 0;
$sq_hotel = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Hotel Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
    $p_hotel = $p_hotel + $row_hotel['net_total'];
}

//DMc vendor
$sq_dmc_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='DMC Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_dmc = 0;
$sq_dmc = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='DMC Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_dmc = mysqli_fetch_assoc($sq_dmc)){
    $p_dmc = $p_dmc + $row_dmc['net_total'];
}

//Tranport vendor
$sq_transport_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Transport Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_transport = 0;
$sq_trans = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Transport Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_trans)){
    $p_transport = $p_transport + $row_tr['net_total'];
}

//Car Rental vendor
$sq_car_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Car Rental Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_car = 0;
$sq_trans = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Car Rental Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_trans)){
    $p_car = $p_car + $row_tr['net_total'];
}

//Visa Vendor
$sq_visa_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Visa Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_visa = 0;
$sq_visa = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Visa Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_visa = mysqli_fetch_assoc($sq_visa)){
    $p_visa = $p_visa + $row_visa['net_total'];
}
//Cruise Vendor
$sq_cruise_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Cruise Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_cruise = 0;
$sq_cruise = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Cruise Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_cruise = mysqli_fetch_assoc($sq_cruise)){
    $p_cruise = $p_cruise + $row_cruise['net_total'];
}

//Passport Vendor
$sq_passport_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Passport Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_passport = 0;
$sq_trans = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Passport Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_trans)){
    $p_passport = $p_passport + $row_tr['net_total'];
}

//Ticket Vendor
$sq_ticket_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Ticket Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_ticket = 0;
$sq_trans = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Ticket Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_trans)){
    $p_ticket = $p_ticket + $row_tr['net_total'];
}

//Excursion Vendor
$sq_exc_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Excursion Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$exc_ticket = 0;
$sq_exc = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Excursion Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_exc = mysqli_fetch_assoc($sq_exc)){
    $exc_ticket = $exc_ticket + $row_exc['net_total'];
}
//Train Vendor
$sq_train_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Train Ticket Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_train = 0;
$sq_train = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Train Ticket Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_train)){
    $p_train = $p_train + $row_tr['net_total'];
}

//Insurance Vendor
$sq_insurance_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Insurance Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_ins = 0;
$sq_trans = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Insurance Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_trans)){
    $p_ins = $p_ins + $row_tr['net_total'];
}

// Other Vendor
$sq_other_vendor =mysqli_num_rows(mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Other Vendor' and  purchase_date between '$week_start_date' and '$cur_date'"));
$p_other = 0;
$sq_trans = mysqlQuery("select * from vendor_estimate where status!='Cancel' and vendor_type='Other Vendor' and purchase_date between '$week_start_date' and '$cur_date'");
while($row_tr = mysqli_fetch_assoc($sq_trans)){
    $p_other = $p_other + $row_tr['net_total'];
}

$total_purchase_amount = $p_hotel + $p_transport + $p_train + $p_ticket + $p_ins + $p_car + $p_other + $p_visa+ $p_dmc + $p_passport + $exc_ticket + $p_cruise;

//*************** Office Expense *****************//
$row_exp = mysqli_fetch_assoc(mysqlQuery("select sum(total_fee) as exp_paid from other_expense_master where expense_date between '$week_start_date' and '$cur_date'"));

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.theme.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/menu-style.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/btn-style.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/modules/single_quotation.php">   

  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
  
</head>

<body>
  <!-- Header -->

  <nav class="navbar navbar-default">

      <!-- Header-Top -->
      <div class="Header_Top">
        <div class="container">
          <div class="row">
            <div class="col-md-offset-6 col-md-6">
              <ul class="company_contact">
                <li><a href="mailto:email@company_name.com"><i class="fa fa-envelope"></i>  <?= $app_email_id; ?></a></li>
                <li><i class="fa fa-mobile"></i> <?= $app_contact_no; ?></li>
                <li><i class="fa fa-phone"></i> <?= $app_landline_no; ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>


    <div class="container">

      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a style="width: 40%!important;" class="navbar-brand" href="#"><img src="<?php echo BASE_URL ?>images/Admin-Area-Logo.png" class="img-responsive"></a>
        <div class="logo_right_part">
          <h1>
            <i class="fa fa-pencil-square-o"></i> Weekly Summary Report<br>
            <SPAN style="font-size: 15px;color: #000;">(<?php echo date('d-m-Y', strtotime($week_start_date)).' To '.date('d-m-Y', strtotime($cur_date)); ?>)</SPAN>
          </h1>
        </div>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="nav">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul id="menu-center" class="nav navbar-nav">
            <li class="active"><a href="#0">SALE SUMMARY</a></li>
            <li><a href="#1">PURCHASE SUMMARY</a></li>
            <li><a href="#2">ABSTRACT REPORT</a></li>
            <li><a href="#3">ENQUIRY</a></li>	
          </ul>
        </div><!-- /.navbar-collapse -->
      </div>
    </div><!-- /.container-fluid -->
  </nav>

  <!-- Header-End -->

<!-- Sale -->
  <section id="0" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>Sale Summary</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list"  style="padding-bottom: 0 !important;">
            <thead>
              <tr class="table-heading-row">
                <th>SERVICES</th>
                <th>Group</th>
                <th>Package</th>
                <th>Flight</th>
                <th>Visa</th>
                <th>Hotel</th>
                <th>Train</th>
                <th>Bus</th>
                <th>Car_Rental</th>
                <th>Activity</th>
              </tr>
            </thead>
            <tbody>   
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_SALE</td>
                <td><?= $sq_group_booking ?></td>
                <td><?= $sq_package_booking ?></td>
                <td><?= $sq_air_booking ?></td>
                <td><?= $sq_visa_booking ?></td>
                <td><?= $sq_hotel_booking ?></td>
                <td><?= $sq_train_booking ?></td>
                <td><?= $sq_bus_booking ?></td>
                <td><?= $sq_car_booking ?></td>
                <td><?= $sq_exc_booking ?></td>
              </tr>
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_AMOUNT</td>
                <td><?= number_format($group_amount,2) ?></td>
                <td><?= number_format($package_amount,2) ?></td>
                <td><?= number_format($air_amount,2) ?></td>
                <td><?= number_format($visa_amount,2) ?></td>
                <td><?= number_format($hotel_amount,2) ?></td>
                <td><?= number_format($train_amount,2) ?></td>
                <td><?= number_format($bus_amount,2) ?></td>
                <td><?= number_format($car_amount,2) ?></td>
                <td><?= number_format($exc_amount,2) ?></td>
              </tr>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </div>
  </section>

<!-- Purchase -->
  <section id="1" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>Purchase Summary</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding-bottom: 0 !important;">
            <thead>
              <tr class="table-heading-row">
                <th>SERVICES</th>
                <th>Hotel</th>
                <th>DMC</th>
                <th>Transport</th>
                <th>Visa</th>
                <th>Cruise</th>
                <th>FLIGHT</th>
                <th>Activity</th>
                <th>Train</th>
                <th>Insurance</th>
                <th>Car_Rental</th>
                <th>Other</th>
              </tr>
            </thead>
            <tbody>   
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_PURCHASE</td>
                <td><?= $sq_hotel_vendor ?></td>
                <td><?= $sq_dmc_vendor ?></td>
                <td><?= $sq_transport_vendor ?></td>
                <td><?= $sq_visa_vendor ?></td>
                <td><?= $sq_cruise_vendor ?></td>
                <td><?= $sq_ticket_vendor ?></td>
                <td><?= $sq_exc_vendor ?></td>
                <td><?= $sq_train_vendor ?></td>
                <td><?= $sq_insurance_vendor ?></td>
                <td><?= $sq_car_vendor ?></td>
                <td><?= $sq_other_vendor ?></td>
              </tr>
              <tr>
                <td style="background: #f2f2f2; font-weight:500;">TOTAL_AMOUNT</td>                
                <td><?= number_format($p_hotel,2) ?></td>
                <td><?= number_format($p_dmc,2) ?></td>
                <td><?= number_format($p_transport,2) ?></td>
                <td><?= number_format($p_visa,2) ?></td>
                <td><?= number_format($p_cruise,2) ?></td>
                <td><?= number_format($p_ticket,2) ?></td>
                <td><?= number_format($exc_ticket,2) ?></td>
                <td><?= number_format($p_train,2) ?></td>
                <td><?= number_format($p_ins,2) ?></td>
                <td><?= number_format($p_car,2) ?></td>
                <td><?= number_format($p_other,2) ?></td>
              </tr>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </div>
  </section>

<!-- Summary Report -->
  <section id="2" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>ABSTRACT REPORT</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="adolence_info">
            <ul class="main_block">
              <li class="col-md-4"><span>Total Sale : </span><?php echo number_format($total_sale_amount,2); ?></li>
              <li class="col-md-4"><span>Total Purchase : </span><?php echo number_format($total_purchase_amount,2); ?></li>
              <li class="col-md-4"><span>Other Expense : </span><?php echo number_format($row_exp['exp_paid'],2); ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- Enquiry Summary Report -->
  <section id="3" class="main_block link_page_section">
    <div class="container">
      <div class="sec_heding">
        <h2>Enquiry</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="adolence_info">
            <ul class="main_block">
              <li class="col-md-3"><span>Active : </span><?php echo $followup_count; ?></li>
              <li class="col-md-3"><span>In-Followup : </span><?php echo $inf_count; ?></li>
              <li class="col-md-3 highlight" style="font-weight: 600; color: #016d01;"><span class="highlight">Converted : </span><?php echo $converted_count; ?></li>
              <li class="col-md-3 highlight" style="font-weight: 600; color: red;"><span class="highlight">Dropped : </span><?php echo $closed_count; ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>



<!-- Footer -->

  <footer class="main_block">
    <div class="footer_part">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="footer_company_cont">
              <p><i class="fa fa-map-marker"></i> <?php echo $app_address; ?></p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="footer_company_cont text-right">
              <p><i class="fa fa-phone"></i> <?php echo $app_contact_no; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

<!-- Footer-End-->




<!-- sticky-header -->
    <script type="text/javascript">
      $(document).ready(function(){

        $(window).bind('scroll', function() {
      
          var navHeight = 159; // custom nav height
      
          ($(window).scrollTop() > navHeight) ? $('div.nav').addClass('goToTop') : $('div.nav').removeClass('goToTop');
      
        });
      
      });
    </script>

<!-- Smooth-scroll -->
<script type="text/javascript">
       $(document).on('click', '#menu-center a', function(event){
          event.preventDefault();

          $('html, body').animate({
              scrollTop: $( $.attr(this, 'href') ).offset().top
          }, 500);
      });
</script>

<!-- Active-menu -->
<script type="text/javascript">
  $("#menu-center a").click(function(){
      $(this).parent().siblings().removeClass('active');
      $(this).parent().addClass('active');
  });
</script>

<!-- Accordion -->
<script type="text/javascript">
  $('#myCollapsible').collapse({
    toggle: false
  })
</script>

<!-- Slider -->
<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        pagination:false,
        autoPlay:true,
        singleItem:true,
        navigation:true,
        navigationText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
</script>

</body>
</html>