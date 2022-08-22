<?php include "../../../model/model.php"; ?>
<?php
  $tour_id = $_GET['tour_id'];
  $tour_group_id = $_GET['tour_group_id'];


  $tourwise_id_arr =array();
  $traveler_group_id_arr =array();
  $customer_id_arr =array();
  $year_arr =array();
  $sq = mysqlQuery("select id, traveler_group_id,customer_id,form_date from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' and tour_group_status = 'Cancel' ");
  while($row = mysqli_fetch_assoc($sq))
  {
    $tourwise_id = $row['id'];
  	$traveler_group = $row['traveler_group_id'];
  	$customer_id = $row['customer_id'];
    $date = $row['form_date'];
    $yr = explode("-", $date);
    $year =$yr[0];
  	
  	if(!in_array($traveler_group,$traveler_group_id_arr))
  	{
      array_push($tourwise_id_arr, $tourwise_id);
      array_push($traveler_group_id_arr, $traveler_group);
      array_push($customer_id_arr, $customer_id);
      array_push($year_arr,$year);
      
  	}	
  }	
  echo "<option value=''> Select Booking ID </option>";
  
  for($i=0; $i<sizeof($customer_id_arr) ; $i++)
  {
  	$sq1 = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id = '$customer_id_arr[$i]'"));
  	
  		$first_name =  $sq1['first_name'];
      $last_name = $sq1['last_name'];
      $customer_name = ($sq1['type'] == 'Corporate'||$sq1['type'] == 'B2B')?$sq1['company_name'] : $first_name." ".$last_name;?>
   <option value='<?= $tourwise_id_arr[$i] ?>'><?= get_group_booking_id($tourwise_id_arr[$i],$year_arr[$i])." : ".$customer_name ?></option>
  <?php } ?>