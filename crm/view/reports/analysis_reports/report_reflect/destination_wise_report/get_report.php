<?php
include "../../../../../model/model.php";
$fromdate = !empty($_POST['fromdate']) ? get_date_db($_POST['fromdate']) : null;
$todate = !empty($_POST['todate']) ? get_date_db($_POST['todate']) : null;
$array_s = array();

if (empty($fromdate) && empty($todate)) {
    $_SESSION['tourwise'] = "";
    $_SESSION['package'] = "";
} else {
    $_SESSION['tourwise'] = "and tourwise_traveler_details.form_date between '" . $fromdate . "' and '" . $todate . "'";
    $_SESSION['package'] = "and package_tour_booking_master.booking_date between '" . $fromdate . "' and '" . $todate . "'";
}

function total_bookings_package($dest_id)
{
    $qry = "select count(*) as booking from package_tour_booking_master inner join destination_master on package_tour_booking_master.dest_id=destination_master.dest_id where destination_master.dest_id=".$dest_id." ".$_SESSION['package'];
    $res = mysqlQuery($qry);
    $amt = mysqli_fetch_assoc($res)['booking'];
    return empty($amt) ? 0 : $amt;    
}
function total_bookings_tour($dest_id)
{
    $qry = "select count(*) as booking from tourwise_traveler_details inner join tour_master on tourwise_traveler_details.tour_id=tour_master.tour_id inner join destination_master on tour_master.dest_id=destination_master.dest_id where destination_master.dest_id=".$dest_id." ".$_SESSION['tourwise'];
    $res = mysqlQuery($qry);
    $amt = mysqli_fetch_assoc($res)['booking'];
    return empty($amt) ? 0 : $amt;    
}
function total_selling_package($dest_id)
{
    $qry = "select sum(subtotal) as selling from package_tour_booking_master inner join destination_master on package_tour_booking_master.dest_id=destination_master.dest_id where destination_master.dest_id=".$dest_id." ".$_SESSION['package'];
    $res = mysqlQuery($qry);
    $amt = mysqli_fetch_assoc($res)['selling'];
    return empty($amt) ? 0 : $amt;    
}
function total_selling_tour($dest_id)
{
    $qry = "select sum(basic_amount) as booking from tourwise_traveler_details inner join tour_master on tourwise_traveler_details.tour_id=tour_master.tour_id inner join destination_master on tour_master.dest_id=destination_master.dest_id where destination_master.dest_id=".$dest_id." ".$_SESSION['tourwise'];
    $res = mysqlQuery($qry);
    $amt = mysqli_fetch_assoc($res)['booking'];
    return empty($amt) ? 0 : $amt;    
}



if (empty($fromdate) && empty($todate)) {
    $query =  "SELECT * FROM destination_master";
} else {
    $query =  "SELECT * FROM destination_master";
}

$type = 'display';
$result = mysqlQuery($query);
$count = 1;
while ($data = mysqli_fetch_assoc($result)) {
   
   
    $temparr = array("data" => array(
        (int) ($count++),
        $data['dest_name'],
        total_bookings_package($data['dest_id']) + total_bookings_tour($data['dest_id']),
        total_selling_package($data['dest_id']) + total_selling_tour($data['dest_id']),
    
    
        '<button class="btn btn-info btn-sm" onclick="view_desti_wise_modal(' . $data['dest_id'] . ')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


    ), "bg" => $bg);
    array_push($array_s, $temparr);
}



$footer_data = array(
    "footer_data" => array()
);

array_push($array_s, $footer_data);
echo json_encode($array_s);
