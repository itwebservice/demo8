<?php 
function get_service_info($service_name)
{
	$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='$service_name'"));
	$vendor_type_val = $sq_hotel['hsn_sac_code'];

	return $vendor_type_val;
}
?>