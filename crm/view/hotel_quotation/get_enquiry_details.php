<?php
include "../../model/model.php";
$enquiry_id = $_POST['enquiry_id'];
$sq_enq = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));
$enquiry_content = $sq_enq['enquiry_content'];
$enquiry_content_arr1 = json_decode($enquiry_content, true);	
foreach($enquiry_content_arr1 as $enquiry_content_arr2){
	if($enquiry_content_arr2['name']=="hotel_requirements"){ $sq_enq['hotel_requirements'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_adult"){ $sq_enq['total_adult'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_infant"){ $sq_enq['total_infant'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_cwb"){ $sq_enq['total_cwb'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_cwob"){ $sq_enq['total_cwob'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_cwob"){ $sq_enq['total_cwob'] = $enquiry_content_arr2['value']; }
}
echo json_encode($sq_enq);
?>