<?php
include "../../../../model/model.php";
$quotation_id = $_REQUEST['quotation_id'];

$qDetails = mysqli_fetch_assoc(mysqlQuery("SELECT `hotel_details`,`enquiry_details`,`costing_details` FROM `hotel_quotation_master` WHERE `quotation_id` =".$quotation_id));

$appDetails = json_decode($qDetails['hotel_details'], TRUE);
$enqDetails = json_decode($qDetails['enquiry_details'], TRUE);
$costDetails = json_decode($qDetails['costing_details'], TRUE);

foreach($appDetails as $key =>$values){

    $hotelName = mysqli_fetch_assoc(mysqlQuery("SELECT `hotel_name` FROM `hotel_master` WHERE `hotel_id`=".$values['hotel_id']));
    $cityName = mysqli_fetch_assoc(mysqlQuery("SELECT `city_name` FROM `city_master` WHERE `city_id`=".$values['city_id']));
    $appDetails[$key]['city_name'] = $cityName['city_name'];
    $appDetails[$key]['hotel_name'] = $hotelName['hotel_name'];
}

$finalArray['hotel_details'] = $appDetails;
$finalArray['enquiry_details'] =  $enqDetails;
$finalArray['costing_details'] =  $costDetails;
echo json_encode($finalArray);
?>