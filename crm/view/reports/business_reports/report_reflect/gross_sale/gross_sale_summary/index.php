<?php 
include "../../../../../../model/model.php";

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$financial_year_id = $_SESSION['financial_year_id'];
$pre_financial_year_id = $financial_year_id -1;

$sq_finacial_year = mysqli_fetch_assoc(mysqlQuery("select * from financial_year where financial_year_id='$financial_year_id'")); 
$current_finance_yr = get_date_user($sq_finacial_year['from_date']).' - '.get_date_user($sq_finacial_year['to_date']);
$sq_finacial_year = mysqli_fetch_assoc(mysqlQuery("select * from financial_year where financial_year_id='$pre_financial_year_id'")); 
$prev_finance_yr = get_date_user($sq_finacial_year['from_date']).' - '.get_date_user($sq_finacial_year['to_date']);
$current_date = date("Y-m-d");
$month = date('m', strtotime($current_date));
?>
<div class="row mg_tp_20">
<form id="frm_save">
    <div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
    <table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
            <thead >
                <tr class="table-heading-row ">
                    <th></th>
                    <th colspan="2" class="text-center"><?= date('F') ?></th>
                    <th colspan="2" class="text-center">For The Year</th>
                </tr>
                <tr class="table-heading-row">
                    <th>Particular</th>
                    <th><?= $prev_finance_yr ?></th>
                    <th><?= $current_finance_yr ?></th>
                    <th><?= $prev_finance_yr ?></th>
                    <th><?= $current_finance_yr ?></th>
                </tr>
            </thead>
            <tbody>
<!-- Group Booking -->
<?php
$sq_group_count = mysqli_num_rows(mysqlQuery("select * from tourwise_traveler_details where financial_year_id='$financial_year_id' and tour_group_status != 'Cancel'"));
$sq_group_pre_count = mysqli_num_rows(mysqlQuery("select * from tourwise_traveler_details where financial_year_id='$pre_financial_year_id' and tour_group_status != 'Cancel'"));

$sq_group = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from tourwise_traveler_details where financial_year_id='$financial_year_id' and tour_group_status != 'Cancel'"));
$sq_group_pre = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from tourwise_traveler_details where financial_year_id='$pre_financial_year_id' and tour_group_status != 'Cancel'"));
$current_group_sale = $sq_group['net_total'];
$previous_group_sale = $sq_group_pre['net_total'];

$sq_group_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total FROM tourwise_traveler_details WHERE MONTH(form_date) = $month AND financial_year_id='$financial_year_id' and tour_group_status != 'Cancel'"));
$sq_group_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total FROM  tourwise_traveler_details WHERE MONTH(form_date) = $month AND financial_year_id='$pre_financial_year_id' and tour_group_status != 'Cancel'"));
$current_group_sale_m = $sq_group_month['net_total'];
$previous_group_sale_m = $sq_group_month_pre['net_total'];
    if($sq_group_count!="0" || $sq_group_pre_count!='0'){
    ?>
            <tr> 
                <td>Group Booking</td>
                <td><?= number_format($previous_group_sale_m,2) ?></td>
                <td><?= number_format($current_group_sale_m,2) ?> </td>
                <td><?= number_format($previous_group_sale,2) ?></td>
                <td><?= number_format($current_group_sale,2) ?></td>
            </tr>
    <?php } ?>
<!-- Package Booking -->
<?php
$sq_package_count = mysqli_num_rows(mysqlQuery("select * from package_tour_booking_master where financial_year_id='$financial_year_id'"));
$sq_package_pre_count = mysqli_num_rows(mysqlQuery("select * from package_tour_booking_master where financial_year_id='$pre_financial_year_id'"));

$sq_package = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from package_tour_booking_master where financial_year_id='$financial_year_id'"));
$sq_package_pre = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from package_tour_booking_master where financial_year_id='$pre_financial_year_id'"));

$current_package_sale = $sq_package['net_total'];
$previous_package_sale = $sq_package_pre['net_total'];

$sq_package_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total FROM package_tour_booking_master WHERE MONTH(booking_date) = $month AND financial_year_id='$financial_year_id'"));
$sq_package_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total FROM package_tour_booking_master WHERE MONTH(booking_date) = $month AND financial_year_id='$pre_financial_year_id'"));
$current_package_sale_m = $sq_package_month['net_total'];
$previous_package_sale_m = $sq_package_month_pre['net_total'];
    if($sq_package_count!="0" || $sq_package_pre_count!='0'){
    ?>
        <tr> 
            <td>Package Booking</td>
            <td><?= number_format($previous_package_sale_m,2) ?></td>
            <td><?= number_format($current_package_sale_m,2) ?> </td>
            <td><?= number_format($previous_package_sale,2) ?></td>
            <td><?= number_format($current_package_sale,2) ?></td>
        </tr>
    <?php } ?>
 <!-- Hotel Booking -->
<?php
$sq_hotel_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_master where financial_year_id='$financial_year_id' and booking_id in(SELECT booking_id FROM `hotel_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$sq_hotel_pre_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_master where financial_year_id='$pre_financial_year_id' and booking_id in(SELECT booking_id FROM `hotel_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));

$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select sum(total_fee) as hotel_total from hotel_booking_master where financial_year_id='$financial_year_id' and booking_id in(SELECT booking_id FROM `hotel_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$sq_hotel_pre = mysqli_fetch_assoc(mysqlQuery("select sum(total_fee) as hotel_total from hotel_booking_master where financial_year_id='$pre_financial_year_id' and booking_id in(SELECT booking_id FROM `hotel_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$current_hotel_sale = $sq_hotel['hotel_total'];
$previous_hotel_sale = $sq_hotel_pre['hotel_total'];
$sq_hotel_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(total_fee) as hotel_total
FROM hotel_booking_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and booking_id in(SELECT booking_id FROM `hotel_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$sq_hotel_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(total_fee) as hotel_total
FROM hotel_booking_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and booking_id in(SELECT booking_id FROM `hotel_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$pre_month_hotel = $sq_hotel_month_pre['hotel_total'];
$current_month_hotel = $sq_hotel_month['hotel_total'];
    if($sq_hotel_count!="0" || $sq_hotel_pre_count!='0'){
        
    ?>
    <tr>
        <td>Hotel Booking</td> 
        <td><?= number_format($pre_month_hotel,2) ?></td>
        <td><?= number_format($current_month_hotel,2) ?> </td>
        <td><?= number_format($previous_hotel_sale,2) ?></td>
        <td><?= number_format($current_hotel_sale,2) ?></td>
    </tr>
    <?php }
// Bus Booking
$sq_bus_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_master where financial_year_id='$financial_year_id' and booking_id in(SELECT booking_id FROM `bus_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$sq_bus_pre_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_master where financial_year_id='$pre_financial_year_id' and booking_id in(SELECT booking_id FROM `bus_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));

$sq_bus = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as bus_total from bus_booking_master where financial_year_id='$financial_year_id' and booking_id in(SELECT booking_id FROM `bus_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$sq_bus_pre = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as bus_total from bus_booking_master where financial_year_id='$pre_financial_year_id' and booking_id in(SELECT booking_id FROM `bus_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$current_bus_sale = $sq_bus['bus_total'];
$previous_bus_sale = $sq_bus_pre['bus_total'];
$sq_bus_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as bus_total
FROM bus_booking_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and booking_id in(SELECT booking_id FROM `bus_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));

$sq_bus_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as bus_total
FROM bus_booking_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and booking_id in(SELECT booking_id FROM `bus_booking_entries` WHERE `status`!='Cancel' group by booking_id)"));
$pre_month_bus = $sq_bus_month_pre['bus_total'];
$current_month_bus = $sq_bus_month['bus_total'];
if($sq_bus_count!="0" || $sq_bus_pre_count!='0'){
?>
    <tr>
        <td>Bus Booking</td>
        <td><?= number_format($pre_month_bus,2) ?></td>
        <td><?= number_format($current_month_bus,2) ?> </td>
        <td><?= number_format($previous_bus_sale,2) ?></td> 
        <td><?= number_format($current_bus_sale,2) ?></td>
    </tr>
<?php } 
// Flight Booking
$sq_flight_count = mysqli_num_rows(mysqlQuery("select * from ticket_master where financial_year_id='$financial_year_id' and ticket_id in(SELECT ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by ticket_id)"));
$sq_flight_pre_count = mysqli_num_rows(mysqlQuery("select * from ticket_master where financial_year_id='$pre_financial_year_id' and ticket_id in(SELECT ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by ticket_id)"));

$sq_flight = mysqli_fetch_assoc(mysqlQuery("select sum(ticket_total_cost) as flight_total from ticket_master where financial_year_id='$financial_year_id' and ticket_id in(SELECT ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by ticket_id)"));
$sq_flight_pre = mysqli_fetch_assoc(mysqlQuery("select sum(ticket_total_cost) as flight_total from ticket_master where financial_year_id='$pre_financial_year_id' and ticket_id in(SELECT ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by ticket_id)"));
$current_flight_sale = $sq_flight['flight_total'];
$previous_flight_sale = $sq_flight_pre['flight_total'];
$sq_flight_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(ticket_total_cost) as flight_total
FROM ticket_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and ticket_id in(SELECT ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by ticket_id)"));

$sq_flight_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(ticket_total_cost) as flight_total
FROM ticket_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and ticket_id in(SELECT ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by ticket_id)"));

$pre_month_flight = $sq_flight_month_pre['flight_total'];
$current_month_flight = $sq_flight_month['flight_total'];
if($sq_flight_count!="0" || $sq_flight_pre_count!='0'){
?>
        <tr>
            <td>Flight Booking</td> 
            <td><?= number_format($pre_month_flight,2) ?></td>
            <td><?= number_format($current_month_flight,2) ?> </td>
            <td><?= number_format($previous_flight_sale,2) ?></td>
            <td><?= number_format($current_flight_sale,2) ?></td>
        </tr>
<?php } 
// <!-- Train Booking -->
$sq_train_count = mysqli_num_rows(mysqlQuery("select * from  train_ticket_master where financial_year_id='$financial_year_id' and train_ticket_id in(SELECT train_ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by train_ticket_id)"));
$sq_train_pre_count = mysqli_num_rows(mysqlQuery("select * from train_ticket_master where financial_year_id='$pre_financial_year_id' and train_ticket_id in(SELECT train_ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by train_ticket_id)"));

$sq_train = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from train_ticket_master where financial_year_id='$financial_year_id' and train_ticket_id in(SELECT train_ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by train_ticket_id)"));
$sq_train_pre = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from train_ticket_master where financial_year_id='$pre_financial_year_id' and train_ticket_id in(SELECT train_ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by train_ticket_id)"));
$current_train_sale = $sq_train['net_total'];
$previous_train_sale = $sq_train_pre['net_total'];
$sq_train_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total
FROM train_ticket_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and train_ticket_id in(SELECT train_ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by train_ticket_id)"));

$sq_train_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total
FROM train_ticket_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and train_ticket_id in(SELECT train_ticket_id FROM `ticket_master_entries` WHERE `status`!='Cancel' group by train_ticket_id)"));
$pre_month_train = $sq_train_month_pre['net_total'];
$current_month_train = $sq_train_month['net_total'];
            if($sq_train_count!="0" || $sq_train_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Train Booking</td>
                        <td><?= number_format($pre_month_train,2) ?></td>
                        <td><?= number_format($current_month_train,2) ?> </td>
                        <td><?= number_format($previous_train_sale,2) ?></td>
                        <td><?= number_format($current_train_sale,2) ?></td>
                    </tr>
            <?php } 
 // <!-- Visa Booking -->
$sq_visa_count = mysqli_num_rows(mysqlQuery("select * from visa_master where financial_year_id='$financial_year_id' and visa_id in(SELECT visa_id FROM `visa_master_entries` WHERE `status`!='Cancel' group by visa_id)"));
$sq_visa_pre_count = mysqli_num_rows(mysqlQuery("select * from visa_master where financial_year_id='$pre_financial_year_id' and visa_id in(SELECT visa_id FROM `visa_master_entries` WHERE `status`!='Cancel' group by visa_id)"));

$sq_visa = mysqli_fetch_assoc(mysqlQuery("select sum(visa_total_cost) as net_total from visa_master where financial_year_id='$financial_year_id' and visa_id in(SELECT visa_id FROM `visa_master_entries` WHERE `status`!='Cancel' group by visa_id)"));
$sq_visa_pre = mysqli_fetch_assoc(mysqlQuery("select sum(visa_total_cost) as net_total from visa_master where financial_year_id='$pre_financial_year_id' and visa_id in(SELECT visa_id FROM `visa_master_entries` WHERE `status`!='Cancel' group by visa_id)"));
$current_visa_sale = $sq_visa['net_total'];
$previous_visa_sale = $sq_visa_pre['net_total'];
$sq_visa_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(visa_total_cost) as net_total
FROM visa_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and visa_id in(SELECT visa_id FROM `visa_master_entries` WHERE `status`!='Cancel' group by visa_id)"));

$sq_visa_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(visa_total_cost) as net_total
FROM visa_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and visa_id in(SELECT visa_id FROM `visa_master_entries` WHERE `status`!='Cancel' group by visa_id)"));
$pre_month_visa = $sq_visa_month_pre['net_total'];
$current_month_visa = $sq_visa_month['net_total'];
            if($sq_visa_count!="0" || $sq_visa_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Visa Booking</td>
                        <td><?= number_format($pre_month_visa,2) ?></td>
                        <td><?= number_format($current_month_visa,2) ?> </td>
                        <td><?= number_format($previous_visa_sale,2) ?></td>
                        <td><?= number_format($current_visa_sale,2) ?></td>
                    </tr>
            <?php }
// <!-- Car Rental Booking -->
$sq_car_count = mysqli_num_rows(mysqlQuery("select * from car_rental_booking where financial_year_id='$financial_year_id' and status!='Cancel'"));
$sq_car_pre_count = mysqli_num_rows(mysqlQuery("select * from car_rental_booking where financial_year_id='$pre_financial_year_id' and status!='Cancel'"));

$sq_car = mysqli_fetch_assoc(mysqlQuery("select sum(total_fees) as net_total from car_rental_booking where financial_year_id='$financial_year_id' and status!='Cancel'"));
$sq_car_pre = mysqli_fetch_assoc(mysqlQuery("select sum(total_fees) as net_total from car_rental_booking where financial_year_id='$pre_financial_year_id' and status!='Cancel'"));
$current_car_sale = $sq_car['net_total'];
$previous_car_sale = $sq_car_pre['net_total'];
$sq_car_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(total_fees) as net_total
FROM car_rental_booking WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and status!='Cancel'"));

$sq_car_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(total_fees) as net_total
FROM car_rental_booking WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and status!='Cancel'"));
$pre_month_car = $sq_car_month_pre['net_total'];
$current_month_car = $sq_car_month['net_total'];
            if($sq_car_count!="0" || $sq_car_pre_count!='0'){
            ?>
                    <tr>
                        <td>Car rental Booking</td> 
                        <td><?= number_format($pre_month_car,2) ?></td>
                        <td><?= number_format($current_month_car,2) ?> </td>
                        <td><?= number_format($previous_car_sale,2) ?></td>
                        <td><?= number_format($current_car_sale,2) ?></td>
                    </tr>
            <?php } 
// <!-- Activity Booking -->
$sq_exc_count = mysqli_num_rows(mysqlQuery("select * from excursion_master where financial_year_id='$financial_year_id' and exc_id in(SELECT exc_id FROM `excursion_master_entries` WHERE `status`!='Cancel' group by exc_id)"));
$sq_exc_pre_count = mysqli_num_rows(mysqlQuery("select * from excursion_master where financial_year_id='$pre_financial_year_id' and exc_id in(SELECT exc_id FROM `excursion_master_entries` WHERE `status`!='Cancel' group by exc_id)"));

$sq_exc = mysqli_fetch_assoc(mysqlQuery("select sum(exc_total_cost) as net_total from excursion_master where financial_year_id='$financial_year_id' and exc_id in(SELECT exc_id FROM `excursion_master_entries` WHERE `status`!='Cancel' group by exc_id)"));
$sq_exc_pre = mysqli_fetch_assoc(mysqlQuery("select sum(exc_total_cost) as net_total from excursion_master where financial_year_id='$pre_financial_year_id' and exc_id in(SELECT exc_id FROM `excursion_master_entries` WHERE `status`!='Cancel' group by exc_id)"));
$current_exc_sale = $sq_exc['net_total'];
$previous_exc_sale = $sq_exc_pre['net_total'];
$sq_exc_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(exc_total_cost) as net_total
FROM excursion_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and exc_id in(SELECT exc_id FROM `excursion_master_entries` WHERE `status`!='Cancel' group by exc_id)"));

$sq_exc_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(exc_total_cost) as net_total
FROM excursion_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and exc_id in(SELECT exc_id FROM `excursion_master_entries` WHERE `status`!='Cancel' group by exc_id)"));
$pre_month_act = $sq_exc_month_pre['net_total'];
$current_month_act = $sq_exc_month['net_total'];
            if($sq_exc_count!="0" || $sq_exc_pre_count!='0'){
            ?>
                    <tr>
                        <td>Activity Booking</td> 
                        <td><?= number_format($pre_month_act,2) ?></td>
                        <td><?= number_format($current_month_act,2) ?> </td>
                        <td><?= number_format($previous_exc_sale,2) ?></td>
                        <td><?= number_format($current_exc_sale,2) ?></td>
                    </tr>
            <?php } 
// <!-- misc Booking -->
$sq_misc_count = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master where financial_year_id='$financial_year_id' and misc_id in(SELECT misc_id FROM `miscellaneous_master_entries` WHERE `status`!='Cancel' group by misc_id)"));
$sq_misc_pre_count = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master where financial_year_id='$pre_financial_year_id' and misc_id in(SELECT misc_id FROM `miscellaneous_master_entries` WHERE `status`!='Cancel' group by misc_id)"));

$sq_misc = mysqli_fetch_assoc(mysqlQuery("select sum(misc_total_cost) as net_total from miscellaneous_master where financial_year_id='$financial_year_id' and misc_id in(SELECT misc_id FROM `miscellaneous_master_entries` WHERE `status`!='Cancel' group by misc_id)"));
$sq_misc_pre = mysqli_fetch_assoc(mysqlQuery("select sum(misc_total_cost) as net_total from miscellaneous_master where financial_year_id='$pre_financial_year_id' and misc_id in(SELECT misc_id FROM `miscellaneous_master_entries` WHERE `status`!='Cancel' group by misc_id)"));
$current_misc_sale = $sq_misc['net_total'];
$previous_misc_sale = $sq_misc_pre['net_total'];
$sq_misc_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(misc_total_cost) as net_total
FROM miscellaneous_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and misc_id in(SELECT misc_id FROM `miscellaneous_master_entries` WHERE `status`!='Cancel' group by misc_id)"));

$sq_misc_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(misc_total_cost) as net_total
FROM miscellaneous_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and misc_id in(SELECT misc_id FROM `miscellaneous_master_entries` WHERE `status`!='Cancel' group by misc_id)"));
$pre_month_misc = $sq_misc_month_pre['net_total'];
$current_month_misc = $sq_misc_month['net_total'];
            if($sq_misc_count!="0" || $sq_misc_pre_count!='0'){
            ?>
                    <tr> 
                        <td>Miscellaneous Booking</td>
                        <td><?= number_format($pre_month_misc,2) ?></td>
                        <td><?= number_format($current_month_misc,2) ?> </td>
                        <td><?= number_format($previous_misc_sale,2) ?></td>
                        <td><?= number_format($current_misc_sale,2) ?></td>
                    </tr>
            <?php }
 // <!-- Forex Booking -->
$sq_forex_count = mysqli_num_rows(mysqlQuery("select * from forex_booking_master where financial_year_id='$financial_year_id'"));
$sq_forex_pre_count = mysqli_num_rows(mysqlQuery("select * from forex_booking_master where financial_year_id='$pre_financial_year_id'"));

$sq_forex = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from forex_booking_master where financial_year_id='$financial_year_id'"));
$sq_forex_pre = mysqli_fetch_assoc(mysqlQuery("select sum(net_total) as net_total from forex_booking_master where financial_year_id='$pre_financial_year_id'"));
$current_forex_sale = $sq_forex['net_total'];
$previous_forex_sale = $sq_forex_pre['net_total'];
$sq_forex_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total
FROM forex_booking_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id'"));

$sq_forex_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(net_total) as net_total
FROM forex_booking_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id'"));
$pre_month_forex = $sq_forex_month_pre['net_total'];
$current_month_forex = $sq_forex_month['net_total'];
            if($sq_forex_count!="0" || $sq_forex_pre_count!='0'){
            ?>
                    <tr>
                        <td>Forex Booking</td> 
                        <td><?= number_format($pre_month_forex,2) ?></td>
                        <td><?= number_format($current_month_forex,2) ?> </td>
                        <td><?= number_format($previous_forex_sale,2) ?></td>
                        <td><?= number_format($current_forex_sale,2) ?></td>
                    </tr>
            <?php } 
// <!-- Passport Booking -->
$sq_passport_count = mysqli_num_rows(mysqlQuery("select * from passport_master where financial_year_id='$financial_year_id' and passport_id in(SELECT passport_id FROM `passport_master_entries` WHERE `status`!='Cancel' group by passport_id)"));
$sq_passport_pre_count = mysqli_num_rows(mysqlQuery("select * from passport_master where financial_year_id='$pre_financial_year_id' and passport_id in(SELECT passport_id FROM `passport_master_entries` WHERE `status`!='Cancel' group by passport_id)"));

$sq_passport = mysqli_fetch_assoc(mysqlQuery("select sum(passport_total_cost) as net_total from passport_master where financial_year_id='$financial_year_id' and passport_id in(SELECT passport_id FROM `passport_master_entries` WHERE `status`!='Cancel' group by passport_id)"));
$sq_passport_pre = mysqli_fetch_assoc(mysqlQuery("select sum(passport_total_cost) as net_total from passport_master where financial_year_id='$pre_financial_year_id' and passport_id in(SELECT passport_id FROM `passport_master_entries` WHERE `status`!='Cancel' group by passport_id)"));
$current_passport_sale = $sq_passport['net_total'];
$previous_passport_sale = $sq_passport_pre['net_total'];
$sq_passport_month = mysqli_fetch_assoc(mysqlQuery("SELECT sum(passport_total_cost) as net_total
FROM passport_master WHERE MONTH(created_at) = $month AND financial_year_id='$financial_year_id' and passport_id in(SELECT passport_id FROM `passport_master_entries` WHERE `status`!='Cancel' group by passport_id)"));

$sq_passport_month_pre = mysqli_fetch_assoc(mysqlQuery("SELECT sum(passport_total_cost) as net_total
FROM passport_master WHERE MONTH(created_at) = $month AND financial_year_id='$pre_financial_year_id' and passport_id in(SELECT passport_id FROM `passport_master_entries` WHERE `status`!='Cancel' group by passport_id)"));
$pre_month_passport = $sq_passport_month_pre['net_total'];
$current_month_passport = $sq_passport_month['net_total'];
            if($sq_passport_count!=0 || $sq_passport_pre_count!=0){
            ?>
                    <tr>
                        <td>Passport Booking</td>
                        <td><?= number_format($pre_month_passport,2) ?></td>
                        <td><?= number_format($current_month_passport,2) ?> </td>
                        <td><?= number_format($previous_passport_sale,2) ?></td> 
                        <td><?= number_format($current_passport_sale,2) ?></td>
                    </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <?php
            // curent year sale
            $total_current_yr_sale = $current_group_sale+$current_package_sale+$current_hotel_sale+$current_visa_sale+$current_flight_sale+$current_train_sale+$current_bus_sale+$current_car_sale+$current_forex_sale+$current_exc_sale+$current_passport_sale+$current_misc_sale;
            // previous year sale
            $total_pre_yr_sale = $previous_group_sale+$previous_package_sale+$previous_hotel_sale+$previous_visa_sale+$previous_flight_sale+$previous_train_sale+$previous_bus_sale+$previous_car_sale+$previous_forex_sale+$previous_exc_sale+$previous_passport_sale+$previous_misc_sale;
            // previous year month sale
            $total_pre_month_sale = $previous_group_sale_m+$previous_package_sale_m+$pre_month_hotel+$pre_month_bus+$pre_month_car+$pre_month_flight+$pre_month_train+$pre_month_visa+$pre_month_forex+$pre_month_misc+$pre_month_act+$pre_month_passport;
            // current year month sale
            $total_current_month_sale = $current_group_sale_m+$current_package_sale_m+$current_month_hotel+$current_month_bus+$current_month_car+$current_month_flight+$current_month_train+$current_month_visa+$current_month_forex+$current_month_misc+$current_month_act+$current_month_passport;
            ?>
                <tr class="active">
                    <th colspan="" class="" style="font-weight: bold;">Total : </th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_pre_month_sale, 2) ?></th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_current_month_sale, 2) ?></th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_pre_yr_sale, 2) ?></th>
                    <th class="" id="total" style="font-weight: bold;"><?= number_format($total_current_yr_sale, 2) ?></th>
                </tr>
            </tfoot>
        </table>
    </div> </div> </div>
</form>
</div>
<script>
function excel_report()
{
	
	
	var branch_id = $('#branch_id_filter').val();
	var base_url = $('#base_url').val();
	var branch_status = $('#branch_status').val();
	window.location = base_url+'view/reports/business_reports/report_reflect/gross_sale/gross_sale_summary/excel_report.php?branch_id='+branch_id+'&branch_status='+branch_status;
}
</script>