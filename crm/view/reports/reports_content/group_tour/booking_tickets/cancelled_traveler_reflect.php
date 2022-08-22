<?php
include "../../../../../model/model.php";
  $tour_id = $_GET['tour_id'];
  $tour_group_id = $_GET['tour_group_id'];

  $tourwise_id_arr =array();
  $traveler_group_id_arr =array();
  $year_arr =array();
  $cust_name_arr = array();
  $sq = mysqlQuery("select id, traveler_group_id, form_date,customer_id from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' ");
  echo "<option value=''> Select Booking ID </option>";
  while($row = mysqli_fetch_assoc($sq))
  {
    $tourwise_id = $row['id'];
  	$traveler_group = $row['traveler_group_id'];

    $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row[customer_id]'"));
    if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
      $cust_name = $sq_customer['company_name'];
    }else{
      $cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
    }

  	$date = $row['form_date'];
    $yr = explode("-", $date);
    $year = $yr[0];

  	if(!in_array($traveler_group,$traveler_group_id_arr))
  	{
      array_push($tourwise_id_arr, $tourwise_id);
  		array_push($traveler_group_id_arr, $traveler_group);
      array_push($year_arr, $year);
      array_push($cust_name_arr,$cust_name);
  	}	
  }
  
  for($i=0; $i<sizeof($traveler_group_id_arr) ; $i++)
  {
    echo "<option value='$tourwise_id_arr[$i]'>".get_group_booking_id($tourwise_id_arr[$i],$year_arr[$i])." : $cust_name_arr[$i] </option>";
  }	

?>