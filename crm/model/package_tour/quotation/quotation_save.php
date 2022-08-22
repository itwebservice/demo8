<?php 
class quotation_save{

public function quotation_master_save()
{
	$login_id = $_POST['login_id'];
	$emp_id = $_POST['emp_id'];
	$enquiry_id = $_POST['enquiry_id'];
	$tour_name = $_POST['tour_name'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$total_days = $_POST['total_days'];
	$customer_name = $_POST['customer_name'];
	$email_id = $_POST['email_id'];
	$mobile_no = $_POST['mobile_no'];
	$total_adult = $_POST['total_adult'];
	$total_infant = $_POST['total_infant'];
	$total_passangers = $_POST['total_passangers'];
	$children_without_bed = $_POST['children_without_bed'];
	$children_with_bed = $_POST['children_with_bed'];
	$quotation_date = $_POST['quotation_date'];
	$booking_type = $_POST['booking_type'];
	$train_cost = $_POST['train_cost'];
	$flight_cost = $_POST['flight_cost'];
	$cruise_cost = $_POST['cruise_cost'];
	$visa_cost = $_POST['visa_cost'];
	$guide_cost = $_POST['guide_cost'];
	$misc_cost = $_POST['misc_cost'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$financial_year_id = $_POST['financial_year_id'];
	$price_str_url = $_POST['price_str_url']; 
	$incl_arr = $_POST['incl_arr']; 
	$excl_arr = $_POST['excl_arr'];
	$pckg_daywise_url = $_POST['pckg_daywise_url'];
	$costing_type = $_POST['costing_type'];
	$currency_code = $_POST['currency_code'];

	//Train
	$train_from_location_arr = $_POST['train_from_location_arr'] ?: [];
	$train_to_location_arr = $_POST['train_to_location_arr'];
	$train_class_arr = $_POST['train_class_arr'];
	$train_arrival_date_arr = $_POST['train_arrival_date_arr'];
	$train_departure_date_arr = $_POST['train_departure_date_arr'];

	//Plane
	$plane_from_city_arr = $_POST['plane_from_city_arr'];
	$plane_to_city_arr = $_POST['plane_to_city_arr'];
	$plane_from_location_arr = $_POST['plane_from_location_arr'] ?: [];
	$plane_to_location_arr = $_POST['plane_to_location_arr'];
	$airline_name_arr = $_POST['airline_name_arr'];
	$plane_class_arr = $_POST['plane_class_arr'];
	$arraval_arr = $_POST['arraval_arr'];
	$dapart_arr = $_POST['dapart_arr'];

	//Cruise
	$cruise_departure_date_arr = $_POST['cruise_departure_date_arr'] ?: [];
	$cruise_arrival_date_arr = $_POST['cruise_arrival_date_arr'];
	$route_arr = $_POST['route_arr'];
	$cabin_arr = $_POST['cabin_arr'];
	$sharing_arr = $_POST['sharing_arr'];

	//Hotel
	$package_type_arr = $_POST['package_type_arr'] ?: [];
	$city_name_arr = $_POST['city_name_arr'] ?: [];
	$hotel_name_arr = $_POST['hotel_name_arr'];
	$hotel_cat_arr = $_POST['hotel_cat_arr'];
	$hotel_stay_days_arr = $_POST['hotel_stay_days_arr'];
	$package_name_arr = $_POST['package_name_arr'];
	$hotel_type_arr = $_POST['hotel_type_arr'];
	$extra_bed_arr = $_POST['extra_bed_arr'];
	$total_rooms_arr = $_POST['total_rooms_arr'];
	$hotel_cost_arr = $_POST['hotel_cost_arr'];
	$extra_bed_cost_arr = $_POST['extra_bed_cost_arr'];
	$check_in_arr = $_POST['check_in_arr'];
	$check_out_arr = $_POST['check_out_arr'];

	//Tranport
	$vehicle_name_arr = $_POST['vehicle_name_arr'] ?: [];
	$start_date_arr = $_POST['start_date_arr'];
	$end_date_arr = $_POST['end_date_arr'];
	$pickup_arr = $_POST['pickup_arr'];
	$drop_arr = $_POST['drop_arr'];
	$vehicle_count_arr = $_POST['vehicle_count_arr'];
	$transport_cost_arr1 = $_POST['transport_cost_arr1'];
	$package_name_arr1 = $_POST['package_name_arr1'];
	
	//Excursion
	$city_name_arr_e = $_POST['city_name_arr_e'] ?: [];
	$excursion_name_arr = $_POST['excursion_name_arr'];
	$excursion_amt_arr = $_POST['excursion_amt_arr'];
	$exc_date_arr_e = $_POST['exc_date_arr_e'];
	$transfer_option_arr = $_POST['transfer_option_arr'];
	$adult_arr = $_POST['adult_arr'];
	$chwb_arr = $_POST['chwb_arr'];
	$chwob_arr = $_POST['chwob_arr'];
	$infant_arr = $_POST['infant_arr'];
	
	//Costing
	$tour_cost_arr = $_POST['tour_cost_arr'] ?: [];
	$transport_cost_arr = $_POST['transport_cost_arr'];
	$excursion_cost_arr = $_POST['excursion_cost_arr'];
	$basic_amount_arr = $_POST['basic_amount_arr'];
	$service_charge_arr = $_POST['service_charge_arr'];
	$service_tax_subtotal_arr = $_POST['service_tax_subtotal_arr'];
	$total_tour_cost_arr = $_POST['total_tour_cost_arr'];
    $package_name_arr2 = $_POST['package_name_arr2'];
	$package_type_c_arr = $_POST['package_type_c_arr'];
    
	//Adult & child cost
	$c_package_id_arr = $_POST['c_package_id_arr'];
	$adult_cost_arr = $_POST['adult_cost_arr'];
	$infant_cost_arr = $_POST['infant_cost_arr'];
	$child_with_arr = $_POST['child_with_arr'];
	$child_without_arr = $_POST['child_without_arr'];

	$package_id_arr = $_POST['package_id_arr'] ?: [];
	$discount = $_POST['discount'];

	// Package Program
	$attraction_arr = $_POST['attraction_arr'];
	$program_arr = $_POST['program_arr'] ?: [];
	$stay_arr = $_POST['stay_arr'];
	$meal_plan_arr = $_POST['meal_plan_arr'];
	$package_p_id_arr = $_POST['package_p_id_arr'];

	$enquiry_content = '[{"name":"tour_name","value":"'.$tour_name.'"},{"name":"travel_from_date","value":"'.$from_date.'"},{"name":"travel_to_date","value":"'.$to_date.'"},{"name":"budget","value":"0"},{"name":"total_adult","value":"'.$total_adult.'"},{"name":"total_children","value":"0"},{"name":"total_infant","value":"'.$total_infant.'"},{"name":"total_members","value":"'.$total_passangers.'"},{"name":"hotel_type","value":""},{"name":"children_without_bed","value":"'.$children_without_bed.'"},{"name":"children_with_bed","value":"'.$children_with_bed.'"}]';
	
	$quotation_date = get_date_db($quotation_date);	
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$created_at = date('Y-m-d');
	$quotation_id_arr = array();
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
    // $bsmValues = json_encode($bsmValues);
	for($i=0; $i<sizeof($package_id_arr); $i++){

		$incl = addslashes($incl_arr[$i]);
		$excl = addslashes($excl_arr[$i]);
		
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(quotation_id) as max from package_tour_quotation_master"));
		$quotation_id = $sq_max['max']+1;
	    $quotation_id_arr[$i] = $quotation_id;

		$sq_quotation = mysqlQuery("insert into package_tour_quotation_master ( quotation_id,enquiry_id, branch_admin_id,financial_year_id, tour_name, from_date, to_date, total_days, customer_name, email_id,mobile_no, total_adult, total_infant, total_passangers, children_without_bed, children_with_bed, quotation_date, booking_type, train_cost, flight_cost, cruise_cost, visa_cost, guide_cost,misc_cost, price_str_url, package_id, created_at, login_id,emp_id,inclusions,exclusions,costing_type,currency_code,discount) values ( '$quotation_id','$enquiry_id', '$branch_admin_id','$financial_year_id', '$tour_name', '$from_date', '$to_date', '$total_days', '$customer_name', '$email_id','$mobile_no', '$total_adult', '$total_infant', '$total_passangers', '$children_without_bed', '$children_with_bed', '$quotation_date', '$booking_type', '$train_cost','$flight_cost','$cruise_cost','$visa_cost','$guide_cost','$misc_cost','$price_str_url','$package_id_arr[$i]', '$created_at', '$login_id', '$emp_id','$incl','$excl','$costing_type','$currency_code','$discount')");

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_images"));
		$image_id = $sq_max['max']+1;
		$sq_quotation1 = mysqlQuery("insert into package_tour_quotation_images ( id,quotation_id,package_id,image_url) values('$image_id','$quotation_id','$package_id_arr[$i]','$pckg_daywise_url')");
	}

	if($sq_quotation){
		////////////Enquiry Save///////////
		if($enquiry_id == 0){
			$sq_max_id = mysqli_fetch_assoc(mysqlQuery("select max(enquiry_id) as max from enquiry_master"));
			$enquiry_id1 = $sq_max_id['max']+1;
			$sq_enquiry = mysqlQuery("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content ) values ('$enquiry_id1', '$login_id', '$branch_admin_id','$financial_year_id', 'Package Booking','Strong', '$customer_name', '$mobile_no','$mobile_no', '$email_id','', '$emp_id','', '$quotation_date', '$quotation_date', '', '$enquiry_content')");
			if($sq_enquiry){
				for($j=0; $j<sizeof($quotation_id_arr); $j++){
					$sq_quot_update = mysqlQuery("update package_tour_quotation_master set enquiry_id='$enquiry_id1' where quotation_id='$quotation_id_arr[$j]'");
				}
			}

			$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from enquiry_master_entries"));
			$entry_id = $sq_max['max'] + 1;
			$sq_followup = mysqlQuery("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id1', '', 'Active','', '$quotation_date','Strong', '$quotation_date')");
			$sq_entryid = mysqlQuery("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id1'");
		}

		/////////////Enquiry Save End///////////////
		$this->train_entries_save($quotation_id_arr, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_arrival_date_arr, $train_departure_date_arr);
		$this->plane_entries_save($quotation_id_arr,$plane_from_city_arr,$plane_to_city_arr, $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr);
		$this->cruise_entries_save($quotation_id_arr, $cruise_departure_date_arr, $cruise_arrival_date_arr, $route_arr, $cabin_arr, $sharing_arr);
		$this->hotel_entries_save($quotation_id_arr, $city_name_arr, $hotel_name_arr,$hotel_cat_arr,$hotel_type_arr, $hotel_stay_days_arr, $package_name_arr,$total_rooms_arr,$hotel_cost_arr,$extra_bed_cost_arr,$extra_bed_arr,$check_in_arr,$check_out_arr,$package_type_arr);
		$this->tranport_entries_save($quotation_id_arr,$vehicle_name_arr,$start_date_arr,$pickup_arr,$drop_arr,$vehicle_count_arr,$transport_cost_arr1,$package_name_arr1,$end_date_arr);	
		$this->costing_entries_save($quotation_id,$tour_cost_arr,$basic_amount_arr,$service_charge_arr,$service_tax_subtotal_arr,$total_tour_cost_arr, $package_name_arr2,$transport_cost_arr,$excursion_cost_arr,$adult_cost_arr,$infant_cost_arr,$child_with_arr,$child_without_arr,$bsmValues,$package_type_c_arr);
		$this->excursion_entries_save($quotation_id_arr,$city_name_arr_e, $excursion_name_arr, $excursion_amt_arr,$exc_date_arr_e,$transfer_option_arr,$adult_arr,$chwb_arr,$chwob_arr,$infant_arr);
		$this->program_entries_save($quotation_id_arr,$attraction_arr, $program_arr, $stay_arr,$meal_plan_arr,$package_p_id_arr,$package_id_arr,$pckg_daywise_url);	

		echo "Quotation has been successfully saved.";
		exit;
	}
	else{
		echo "error--Quotation not saved!";
		exit;
	}

}

public function train_entries_save($quotation_id_arr, $train_from_location_arr, $train_to_location_arr, $train_class_arr, $train_arrival_date_arr, $train_departure_date_arr)
{
	for($j=0; $j<sizeof($quotation_id_arr); $j++){
	for($i=0; $i<sizeof($train_from_location_arr); $i++){

		$train_arrival_date_arr[$i] = get_datetime_db($train_arrival_date_arr[$i]);
		$train_departure_date_arr[$i] = get_datetime_db($train_departure_date_arr[$i]);

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_train_entries"));
		$id = $sq_max['max']+1;

		$sq_train = mysqlQuery("insert into package_tour_quotation_train_entries ( id, quotation_id, from_location, to_location, class, arrival_date, departure_date ) values ( '$id', '$quotation_id_arr[$j]', '$train_from_location_arr[$i]', '$train_to_location_arr[$i]', '$train_class_arr[$i]', '$train_arrival_date_arr[$i]', '$train_departure_date_arr[$i]' )");
		if(!$sq_train){
			echo "error--Train information not saved!";
			exit;
		}
	}
	}
}

public function plane_entries_save($quotation_id_arr,$plane_from_city_arr,$plane_to_city_arr, $plane_from_location_arr, $plane_to_location_arr, $plane_class_arr,$airline_name_arr, $arraval_arr, $dapart_arr)
{
	for($j=0; $j<sizeof($quotation_id_arr); $j++){

		for($i=0; $i<sizeof($plane_from_location_arr); $i++){
		
			$arraval_arr[$i] = date('Y-m-d H:i', strtotime($arraval_arr[$i]));
			$dapart_arr[$i] = date('Y-m-d H:i', strtotime($dapart_arr[$i]));

			$from_location = array_slice(explode(' - ', $plane_from_location_arr[$i]), 1);
			$from_location = implode(' - ',$from_location);
			$to_location = array_slice(explode(' - ', $plane_to_location_arr[$i]), 1);
			$to_location = implode(' - ',$to_location);

			$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_plane_entries"));
			$id = $sq_max['max']+1;

			$sq_plane = mysqlQuery("insert into package_tour_quotation_plane_entries ( id, quotation_id,from_city,to_city, from_location, to_location,airline_name, class, arraval_time, dapart_time) values ( '$id', '$quotation_id_arr[$j]', '$plane_from_city_arr[$i]', '$plane_to_city_arr[$i]', '$from_location', '$to_location','$airline_name_arr[$i]', '$plane_class_arr[$i]', '$arraval_arr[$i]', '$dapart_arr[$i]' )");
			if(!$sq_plane){
				echo "error--Plane information not saved!";
				exit;
			}
		}

	}

}

public function cruise_entries_save($quotation_id_arr, $cruise_departure_date_arr, $cruise_arrival_date_arr, $route_arr, $cabin_arr, $sharing_arr)
{
	for($j=0; $j<sizeof($quotation_id_arr); $j++){
	for($i=0; $i<sizeof($cruise_departure_date_arr); $i++){

		$cruise_departure_date_arr[$i] = date('Y-m-d H:i', strtotime($cruise_departure_date_arr[$i]));
		$cruise_arrival_date_arr[$i] = date('Y-m-d H:i', strtotime($cruise_arrival_date_arr[$i]));

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_cruise_entries"));
		$id = $sq_max['max']+1;

		$sq_cruise = mysqlQuery("insert into package_tour_quotation_cruise_entries ( id, quotation_id, dept_datetime, arrival_datetime,route, cabin, sharing) values ( '$id', '$quotation_id_arr[$j]', '$cruise_departure_date_arr[$i]', '$cruise_arrival_date_arr[$i]','$route_arr[$i]', '$cabin_arr[$i]', '$sharing_arr[$i]')");
		if(!$sq_cruise){
			echo "error--Cruise information not saved!";
			exit;
		}
	}

	}
}

public function hotel_entries_save($quotation_id_arr, $city_name_arr, $hotel_name_arr,$hotel_cat_arr,$hotel_type_arr, $hotel_stay_days_arr, $package_name_arr,$total_rooms_arr,$hotel_cost_arr,$extra_bed_cost_arr,$extra_bed_arr,$check_in_arr,$check_out_arr,$package_type_arr)
{
	$j=0;
	for($i=0; $i<sizeof($city_name_arr); $i++){

		$check_in = get_date_db($check_in_arr[$i]);
		$check_out = get_date_db($check_out_arr[$i]);

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_hotel_entries"));
		$id = $sq_max['max']+1;

		$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_name = '$package_name_arr[$i]'"));
		$package_id = $sq_package['package_id']; 
		$sq_plane = mysqlQuery("insert into package_tour_quotation_hotel_entries ( id, quotation_id, city_name, hotel_name,room_category,hotel_type, total_days,package_id,total_rooms,hotel_cost,extra_bed,extra_bed_cost,check_in,check_out,package_type ) values ( '$id', '$quotation_id_arr[$j]', '$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_cat_arr[$i]','$hotel_type_arr[$i]', '$hotel_stay_days_arr[$i]','$package_id','$total_rooms_arr[$i]','$hotel_cost_arr[$i]','$extra_bed_arr[$i]','$extra_bed_cost_arr[$i]','$check_in','$check_out','$package_type_arr[$i]' )");
		
		if(!$sq_plane){
			echo "error--Hotel information not saved!";
			exit;
		}
	}
}

public function tranport_entries_save($quotation_id_arr,$vehicle_name_arr,$start_date_arr,$pickup_arr,$drop_arr,$vehicle_count_arr,$transport_cost_arr1,$package_name_arr1,$end_date_arr){
	$j=0;
	for($i=0; $i<sizeof($vehicle_name_arr); $i++){
		$start_date_arr[$i] = get_date_db($start_date_arr[$i]);
		$end_date_arr[$i] = get_date_db($end_date_arr[$i]);
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_transport_entries2"));
		$id = $sq_max['max']+1;

		$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_name = '$package_name_arr1[$i]'"));
		$package_id = $sq_package['package_id'];

		$pickup_type = explode("-",$pickup_arr[$i])[0];
        $drop_type = explode("-",$drop_arr[$i])[0];
        $pickup = explode("-",$pickup_arr[$i])[1];
        $drop = explode("-",$drop_arr[$i])[1];

		$sq_plane = mysqlQuery("INSERT INTO `package_tour_quotation_transport_entries2`(`id`, `quotation_id`, `vehicle_name`, `start_date`, `pickup`, `drop`, `pickup_type`, `drop_type`, `package_id`, `transport_cost`,`vehicle_count`,`end_date`) values ( '$id', '$quotation_id_arr[$j]', '$vehicle_name_arr[$i]', '$start_date_arr[$i]', '$pickup','$drop','$pickup_type','$drop_type','$package_id','$transport_cost_arr1[$i]','$vehicle_count_arr[$i]','$end_date_arr[$i]' )");
		if(!$sq_plane){
			echo "error--Transport information not saved!";
			exit;
		}
	}
}

public function excursion_entries_save($quotation_id_arr,$city_name_arr_e, $excursion_name_arr, $excursion_amt_arr,$exc_date_arr_e,$transfer_option_arr,$adult_arr,$chwb_arr,$chwob_arr,$infant_arr)
{
	for($i=0; $i<sizeof($quotation_id_arr); $i++){
		for($j=0; $j<sizeof($city_name_arr_e); $j++){

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_excursion_entries"));
		$id = $sq_max['max']+1;
		$exc_date_arr_e[$j] = get_datetime_db($exc_date_arr_e[$j]);
		$sq_plane = mysqlQuery("insert into package_tour_quotation_excursion_entries ( id, quotation_id, city_name, excursion_name, excursion_amount,exc_date,transfer_option,adult,chwb,chwob,infant ) values ( '$id', '$quotation_id_arr[$i]', '$city_name_arr_e[$j]','$excursion_name_arr[$j]', '$excursion_amt_arr[$j]','$exc_date_arr_e[$j]','$transfer_option_arr[$j]','$adult_arr[$j]','$chwb_arr[$j]','$chwob_arr[$j]','$infant_arr[$j]')");
		if(!$sq_plane){
			echo "error--Activity information not saved!";
			exit;
		}
	}
	}
}

public function program_entries_save($quotation_id_arr,$attraction_arr, $program_arr, $stay_arr,$meal_plan_arr,$package_p_id_arr,$package_id_arr,$pckg_daywise_url)
{

	for($i=0; $i<sizeof($quotation_id_arr); $i++){
		$day_count = 0;
		for($j=0; $j<sizeof($program_arr); $j++){

			if($package_p_id_arr[$j] == $package_id_arr[$i])
			{
				$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_quotation_program"));
				$id = $sq_max['max']+1;
				$day_count++;
				$attr = addslashes($attraction_arr[$j]);
				$program = addslashes($program_arr[$j]);
				$stay = addslashes($stay_arr[$j]);
				$meal_plan = addslashes($meal_plan_arr[$j]);
				
				$sq_plane = mysqlQuery("insert into package_quotation_program ( id, quotation_id,package_id, attraction, day_wise_program, stay,meal_plan,day_count ) values ( '$id', '$quotation_id_arr[$i]','$package_p_id_arr[$j]', '$attr','$program', '$stay','$meal_plan','$day_count')");
				if(!$sq_plane){
					echo "error--Program not saved!";
					exit;
			    }
				}
	}
	
	}

}
public function costing_entries_save($quotation_id,$tour_cost_arr,$basic_amount_arr,$service_charge_arr,$service_tax_subtotal_arr,$total_tour_cost_arr, $package_name_arr2,$transport_cost_arr,$excursion_cost_arr,$adult_cost_arr,$infant_cost_arr,$child_with_arr,$child_without_arr,$bsmValues,$package_type_c_arr)
{
	for($i=0; $i<sizeof($package_type_c_arr); $i++){
		$bsmvaluesEach = json_decode(json_encode($bsmValues[$i]));
		foreach($bsmvaluesEach[0] as $key => $value){
			switch($key){
				case 'basic' : $basic_cost = ($value != "") ? $value : $basic_amount_arr[$i];break;
				case 'service' : $service_charge = ($value != "") ? $value : $service_charge_arr[$i];break;
			}
		}
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from package_tour_quotation_costing_entries"));
		$id = $sq_max['max']+1;
		$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_name = '$package_name_arr2[$i]'"));
		$package_id = $sq_package['package_id']; 
		$bsmvaluesEach = json_encode($bsmValues[$i]);
		$sq_plane = mysqlQuery("insert into package_tour_quotation_costing_entries ( id, quotation_id, tour_cost,excursion_cost,basic_amount, service_charge, service_tax_subtotal, total_tour_cost, package_id, transport_cost,adult_cost,infant_cost,child_with,child_without,bsmValues,package_type ) values ( '$id', '$quotation_id', '$tour_cost_arr[$i]','$excursion_cost_arr[$i]', '$basic_amount_arr[$i]', ' $service_charge_arr[$i]', '$service_tax_subtotal_arr[$i]', '$total_tour_cost_arr[$i]','$package_id','$transport_cost_arr[$i]','$adult_cost_arr[$i]','$infant_cost_arr[$i]','$child_with_arr[$i]','$child_without_arr[$i]','$bsmvaluesEach','$package_type_c_arr[$i]' )");
		
		if(!$sq_plane){
			echo "error--Costing information not saved!";
			exit;
		}
	}
}
}
?>