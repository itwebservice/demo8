<?php include "../../../model/model.php";
$supplier = $_POST['supplier'];
$type = $_POST['type'];
$emp_id = $_SESSION['emp_id'];

if($type == 'Hotel Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `hotel_master` WHERE `hotel_id` = '.$supplier));
}
else if($type == 'Car Rental Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `car_rental_vendor` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Cruise Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state` as `state_id` FROM `cruise_master` WHERE `cruise_id` = '.$supplier));
} 
else if($type == 'DMC Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `dmc_master` WHERE `dmc_id` = '.$supplier));
}
else if($type == 'Excursion Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `site_seeing_vendor` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Insurance Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `insuarance_vendor` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Other Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `other_vendors` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Passport Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `passport_vendor` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Ticket Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `ticket_vendor` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Train Ticket Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `train_ticket_vendor` WHERE `vendor_id` = '.$supplier));
}
else if($type == 'Transport Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `transport_agency_master` WHERE `transport_agency_id` = '.$supplier));
}
else if($type == 'Visa Vendor'){
    $state = mysqli_fetch_assoc(mysqlQuery('SELECT `state_id` FROM `visa_vendor` WHERE `vendor_id` = '.$supplier));
}

if($emp_id!=0 && $emp_id!=''){
    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select branch_id from emp_master where emp_id ='$emp_id'"));
    $sq_state = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id ='$sq_emp[branch_id]'"));
    $state_id = $sq_state['state'];
}else{
    $sq_state = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id ='1'"));
    $state_id = $sq_state['state_id'];
}
echo $state['state_id'].'-'.$state_id;
?>