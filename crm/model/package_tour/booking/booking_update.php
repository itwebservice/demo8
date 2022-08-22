<?php 
$flag = true;
class booking_update{

//////////////////////////////////**Package Tour Booking Master Update Start *********/////////////////////////////////////////////////////////////

function package_tour_booking_master_update()
{
    $row_spec='sales';
    $booking_id = $_POST['booking_id'];
    $customer_id = $_POST['customer_id'];

    //** Getting tour information    
    $tour_name = $_POST['tour_name'];
    $tour_type = $_POST['tour_type'];
    $tour_from_date = $_POST['tour_from_date'];
    $tour_to_date = $_POST['tour_to_date'];
    $total_tour_days = $_POST['total_tour_days'];
    $taxation_type = $_POST['taxation_type'];
    //** Getting member information    
    $m_honorific = $_POST['m_honorific'];
    $m_first_name = $_POST['m_first_name'] ?: [];
    $m_middle_name = $_POST['m_middle_name'];
    $m_last_name = $_POST['m_last_name'];
    $m_gender = $_POST['m_gender'];
    $m_birth_date = $_POST['m_birth_date'];
    $m_age = $_POST['m_age'];
    $m_adolescence = $_POST['m_adolescence'];
    $m_passport_no = $_POST['m_passport_no'];
    $m_passport_issue_date = $_POST['m_passport_issue_date'];
    $m_passport_expiry_date = $_POST['m_passport_expiry_date'];
    $m_traveler_id = $_POST['m_traveler_id'];

    $contact_person_name = mysqlREString($_POST['contact_person_name']);
    $email_id = $_POST['email_id'];
    $mobile_no = $_POST['mobile_no'];
    $address = mysqlREString($_POST['address']);
    $country_name = $_POST['country_name'];
    $city = $_POST['city'];
    $state = $_POST['state'];

    //** Traveling information overall
    $train_expense = $_POST['train_expense'];
    $train_service_charge = $_POST['train_service_charge'];
    $train_taxation_id = $_POST['train_taxation_id'];
    $train_service_tax = $_POST['train_service_tax'];
    $train_service_tax_subtotal = $_POST['train_service_tax_subtotal'];
    $total_train_expense = $_POST['total_train_expense'];

    $plane_expense = $_POST['plane_expense'];
    $plane_service_charge = $_POST['plane_service_charge'];
    $plane_taxation_id = $_POST['plane_taxation_id'];
    $plane_service_tax = $_POST['plane_service_tax'];
    $plane_service_tax_subtotal = $_POST['plane_service_tax_subtotal'];
    $total_plane_expense = $_POST['total_plane_expense'];

    $cruise_expense = $_POST['cruise_expense'];
    $cruise_service_charge = $_POST['cruise_service_charge'];
    $cruise_taxation_id = $_POST['cruise_taxation_id'];
    $cruise_service_tax = $_POST['cruise_service_tax'];
    $cruise_service_tax_subtotal = $_POST['cruise_service_tax_subtotal'];
    $total_cruise_expense = $_POST['total_cruise_expense'];

    $total_travel_expense = $_POST['total_travel_expense'];
    $train_upload_ticket = $_POST['train_ticket_path'];
    $plane_upload_ticket = $_POST['plane_ticket_path'];
    $cruise_upload_ticket =$_POST['cruise_ticket_path'];

    //**Traveling information for train
    $train_uploaded_doc_path = $_POST['train_uploaded_doc_path'];
    $train_travel_date = $_POST['train_travel_date'] ?: [];
    $train_from_location = $_POST['train_from_location'];
    $train_to_location = $_POST['train_to_location'];
    $train_train_no = $_POST['train_train_no'];
    $train_travel_class = $_POST['train_travel_class'];
    $train_travel_priority = $_POST['train_travel_priority'];
    $train_amount = $_POST['train_amount'];
    $train_seats = $_POST['train_seats'];
    $train_id = $_POST['train_id'];

    //**Traveling information for plane
    $from_city_id_arr = $_POST['from_city_id_arr'];
    $to_city_id_arr = $_POST['to_city_id_arr'];
    $plane_uploaded_doc_path = $_POST['plane_uploaded_doc_path'];
    $plane_travel_date = $_POST['plane_travel_date'] ?: [];
    $plane_from_location = $_POST['plane_from_location'];
    $plane_to_location = $_POST['plane_to_location'];
    $plane_amount = $_POST['plane_amount'];
    $plane_seats = $_POST['plane_seats'];
    $plane_company = $_POST['plane_company'];
    $arrval_arr = $_POST['arrval_arr'];

    $plane_id = $_POST['plane_id'];

    // Cruise
    $cruise_dept_date_arr =$_POST['cruise_dept_date_arr'] ?: [];
    $cruise_arrival_date_arr =$_POST['cruise_arrival_date_arr'];
    $route_arr =$_POST['route_arr'];
    $cabin_arr =$_POST['cabin_arr'];
    $sharing_arr =$_POST['sharing_arr'];
    $cruise_seats_arr =$_POST['cruise_seats_arr'];
    $cruise_amount_arr =$_POST['cruise_amount_arr'];
    $cruise_id_arr =$_POST['cruise_id_arr'];

    //**Hoteling details
    $city_id = $_POST['city_id'];
    $hotel_id = $_POST['hotel_id'] ?: [];
    $hotel_from_date = $_POST['hotel_from_date'];
    $hotel_to_date = $_POST['hotel_to_date'];
    $hotel_rooms = $_POST['hotel_rooms'];
    $hotel_catagory = $_POST['hotel_catagory'];
    $room_type = $_POST['room_type'];
    $hotel_meal_plan = $_POST['hotel_meal_plan'];
    $confirmation_no = $_POST['confirmation_no'];
    $hotel_acc_id = $_POST['hotel_acc_id'];

    //**Transport details
    $transport_bus_id = $_POST['transport_bus_id'];
    $transport_from_date = $_POST['transport_from_date'];
    $trans_pickuptype_arr=$_POST['trans_pickuptype_arr'] ?: [];
    $trans_pickup_arr=$_POST['trans_pickup_arr'];
    $trans_droptype_arr=$_POST['trans_droptype_arr'];
    $trans_drop_arr=$_POST['trans_drop_arr'];
    $trans_count_arr=$_POST['trans_count_arr'];

    //**Visa Details
    $visa_country_name = $_POST['visa_country_name'];
    $visa_amount = $_POST['visa_amount'];
    $visa_service_charge = $_POST['visa_service_charge'];
    $visa_taxation_id = $_POST['visa_taxation_id'];
    $visa_service_tax = $_POST['visa_service_tax'];
    $visa_service_tax_subtotal = $_POST['visa_service_tax_subtotal'];
    $visa_total_amount = $_POST['visa_total_amount'];
  
    $insuarance_company_name = $_POST['insuarance_company_name'];
    $insuarance_amount = $_POST['insuarance_amount'];
    $insuarance_service_charge = $_POST['insuarance_service_charge'];
    $insuarance_taxation_id = $_POST['insuarance_taxation_id'];
    $insuarance_service_tax = $_POST['insuarance_service_tax'];
    $insuarance_service_tax_subtotal = $_POST['insuarance_service_tax_subtotal'];
    $insuarance_total_amount = $_POST['insuarance_total_amount'];

    //**Costing details
    $total_hotel_expense = $_POST['total_hotel_expense'];
    $service_charge = $_POST['service_charge'];
    $subtotal = $_POST['subtotal'];
    
    $tour_service_tax = $_POST['tour_service_tax'];
    $tour_service_tax_subtotal = $_POST['tour_service_tax_subtotal'];
    $tcs_tax = $_POST['tcs_tax'];
    $tcs = $_POST['tcs'];

    $rue_cost = $_POST['rue_cost'];
    $subtotal_with_rue = $_POST['subtotal_with_rue'];
    $net_total = $_POST['net_total'];
    $actual_tour_cost = $_POST['actual_tour_cost'];


    // Transport
    $transp_vehicle_arr =$_POST['transp_vehicle_arr'] ?: [];
    $transp_start_date =$_POST['transp_start_date'];
    $transp_end_date = $_POST['transp_end_date'];
    $trans_entry_id_arr = $_POST['trans_entry_id_arr'];

    // Activity
    $exc_city_arr =$_POST['exc_city_arr'] ?: [];
    $exc_name_arr =$_POST['exc_name_arr'];
    $exc_date_arr = $_POST['exc_date_arr'];
    $transfer_arr = $_POST['transfer_arr'];
    $exc_entry_id_arr = $_POST['exc_entry_id_arr'];
    $adult_arr =$_POST['adult_arr'];
    $cwb_arr = $_POST['cwb_arr'];
    $cwob_arr = $_POST['cwob_arr'];
    $infant_arr = $_POST['infant_arr'];

    // Itinerary
    $special_attraction_arr =$_POST['special_attraction_arr'];
    $day_program_arr =$_POST['day_program_arr'] ?: [];
    $stay_arr =$_POST['stay_arr'];
    $meal_plan_arr =$_POST['meal_plan_arr'];
    $iti_entry_id_arr = $_POST['iti_entry_id_arr'];

    //**Form information
    $special_request = $_POST['special_request'];
    $booking_date = $_POST['booking_date'];

    $quotation_id = $_POST['quotation_id'];
    $incl =$_POST['incl'];
    $excl =$_POST['excl'];
    $incl = addslashes($incl);
    $excl = addslashes($excl);

    $special_request = addslashes($special_request);

    $tour_from_date = date("Y-m-d", strtotime($tour_from_date));
    $tour_to_date = date("Y-m-d", strtotime($tour_to_date));

    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $basic_amount = $_POST['basic_amount'];
    $roundoff = $_POST['roundoff'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
      switch($key){
      case 'basic' : $basic_amount = ($value != "") ? $value : $basic_amount;break;
      case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      }
    }
    $bsmValues = json_encode($bsmValues);
    $reflections = json_encode($reflections);
    begin_t();
    $sq_booking = mysqlQuery("update package_tour_booking_master set customer_id='$customer_id', tour_name='$tour_name', tour_type='$tour_type', tour_from_date='$tour_from_date', tour_to_date='$tour_to_date', total_tour_days='$total_tour_days', taxation_type='$taxation_type', required_rooms='', child_with_bed='', child_without_bed='', contact_person_name='$contact_person_name', email_id='$email_id', mobile_no='$mobile_no', address='$address', country_name='$country_name', city='$city', state='$state', train_upload_ticket='$train_upload_ticket', plane_upload_ticket='$plane_upload_ticket', cruise_upload_ticket='$cruise_upload_ticket',train_expense = '$train_expense', train_service_charge = '$train_service_charge', train_taxation_id = '$train_taxation_id', train_service_tax = '$train_service_tax', train_service_tax_subtotal = '$train_service_tax_subtotal', total_train_expense = '$total_train_expense', plane_expense = '$plane_expense', plane_service_charge = '$plane_service_charge', plane_taxation_id = '$plane_taxation_id', plane_service_tax = '$plane_service_tax', plane_service_tax_subtotal = '$plane_service_tax_subtotal', total_plane_expense = '$total_plane_expense',cruise_expense = '$cruise_expense', cruise_service_charge = '$cruise_service_charge', cruise_taxation_id = '$cruise_taxation_id', cruise_service_tax = '$cruise_service_tax', cruise_service_tax_subtotal = '$cruise_service_tax_subtotal', total_cruise_expense = '$total_cruise_expense', total_travel_expense='$total_travel_expense', total_hotel_expense='$total_hotel_expense', visa_country_name='$visa_country_name', visa_amount='$visa_amount', visa_service_charge='$visa_service_charge', visa_taxation_id='$visa_taxation_id', visa_service_tax='$visa_service_tax', visa_service_tax_subtotal='$visa_service_tax_subtotal', visa_total_amount='$visa_total_amount', insuarance_company_name='$insuarance_company_name', insuarance_amount='$insuarance_amount', insuarance_service_charge='$insuarance_service_charge', insuarance_taxation_id='$insuarance_taxation_id', insuarance_service_tax='$insuarance_service_tax', insuarance_service_tax_subtotal='$insuarance_service_tax_subtotal', insuarance_total_amount='$insuarance_total_amount', service_charge='$service_charge', subtotal='$subtotal', tour_service_tax='$tour_service_tax', tour_service_tax_subtotal='$tour_service_tax_subtotal', rue_cost='$rue_cost', subtotal_with_rue='$subtotal_with_rue', service_charge='$service_charge', actual_tour_expense='$actual_tour_cost', special_request='$special_request',inclusions='$incl',exclusions='$excl',reflections='$reflections',basic_amount='$basic_amount',bsm_values = '$bsmValues',roundoff='$roundoff',net_total='$net_total',tcs_tax='$tcs_tax',tcs_per='$tcs' where booking_id='$booking_id'");

    if(!$sq_booking){
      rollback_t();
      echo "Booking details not updated.";
      exit;
    }
    else{
      //**This update package tour travelers details
      $this->package_tour_travelers_details_master_update($booking_id, $m_honorific, $m_first_name, $m_middle_name, $m_last_name, $m_gender, $m_birth_date, $m_age, $m_adolescence, $m_passport_no, $m_passport_issue_date, $m_passport_expiry_date, $m_traveler_id);


      //** This function updates the traveling information
      $this->package_tour_traveling_information_update( $booking_id, $train_travel_date, $train_from_location, $train_to_location, $train_train_no, $train_travel_class, $train_travel_priority, $train_amount, $train_seats, $train_id, $plane_travel_date, $from_city_id_arr, $plane_from_location, $to_city_id_arr, $plane_to_location, $plane_amount, $plane_seats, $plane_company, $plane_id, $arrval_arr,$cruise_dept_date_arr, $cruise_arrival_date_arr, $route_arr, $cabin_arr, $sharing_arr, $cruise_seats_arr, $cruise_amount_arr,$cruise_id_arr);

      //** This function updates the hotel accommodation information
      $this->package_tour_hotel_accomodation_information_update($booking_id, $city_id, $hotel_id, $hotel_from_date, $hotel_to_date, $hotel_rooms, $hotel_catagory, $room_type, $hotel_meal_plan, $confirmation_no, $hotel_acc_id);

      //** This function stores the transport information
      $this->package_tour_tranpsort_information_save($booking_id, $transp_vehicle_arr, $transp_start_date,$trans_pickuptype_arr,$trans_pickup_arr,$trans_droptype_arr,$trans_drop_arr,$trans_count_arr,$trans_entry_id_arr,$transp_end_date);

      //** This function stores the excursion information
      $this->package_tour_exc_information_save($booking_id, $exc_city_arr, $exc_name_arr,$exc_entry_id_arr,$exc_date_arr,$transfer_arr,$adult_arr,$cwb_arr,$cwob_arr,$infant_arr);

      //** This function stores the itinerary information
      if($quotation_id == 0){
        $this->package_tour_itinerary_inf_save($booking_id, $special_attraction_arr, $day_program_arr,$stay_arr,$meal_plan_arr,$iti_entry_id_arr);
      }

      //Get Particular
      $particular = $this->get_particular($customer_id,$tour_name,$tour_from_date,($total_tour_days-1));
       //**=============**Finance Entries update start**============**//
      $booking_update_transaction = new booking_update_transaction;
      $booking_update_transaction->finance_update($booking_id, $row_spec,$particular);
      //**=============**Finance Entries update end**============**//
     

      if($GLOBALS['flag']){
        commit_t();
        echo "Package Tour has been successfully updated.";
        exit;
      }
      else{
        rollback_t();
        exit;
      }
      

    }    
} 

function get_particular($customer_id,$tour_name,$tour_from_date,$total_tour_days){

  $sq_ct = mysqli_fetch_assoc(mysqlQuery("select first_name,last_name from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];

  return $tour_name.' for '.$cust_name.' for '.$total_tour_days.' Nights starting from '.get_date_user($tour_from_date);
}
//////////////////////////////////**Package Tour Booking Master Update End *********/////////////////////////////////////////////////////////////

//Transport Save
function package_tour_tranpsort_information_save($booking_id, $transp_vehicle_arr, $transp_start_date,$trans_pickuptype_arr,$trans_pickup_arr,$trans_droptype_arr,$trans_drop_arr,$trans_count_arr,$trans_entry_id_arr,$transp_end_date){
    for($i=0; $i<sizeof($transp_vehicle_arr); $i++){

      $transp_vehicle_arr[$i] = mysqlREString($transp_vehicle_arr[$i]);
      $transp_start_date[$i] = mysqlREString($transp_start_date[$i]);
      $transp_end_date[$i] = mysqlREString($transp_end_date[$i]);
      $trans_pickuptype_arr[$i] = mysqlREString($trans_pickuptype_arr[$i]);
      $trans_pickup_arr[$i] = mysqlREString($trans_pickup_arr[$i]);
      $trans_droptype_arr[$i] = mysqlREString($trans_droptype_arr[$i]);
      $trans_drop_arr[$i] = mysqlREString($trans_drop_arr[$i]);
      $trans_count_arr[$i] = mysqlREString($trans_count_arr[$i]);

      $transp_start_date[$i] = date("Y-m-d", strtotime($transp_start_date[$i]));
      $transp_end_date[$i] = date("Y-m-d", strtotime($transp_end_date[$i]));

      $pickup_type = explode("-",$trans_pickup_arr[$i])[0];
      $drop_type = explode("-",$trans_drop_arr[$i])[0];
      $pickup = explode("-",$trans_pickup_arr[$i])[1];
      $drop = explode("-",$trans_drop_arr[$i])[1];

      if($trans_entry_id_arr[$i]!=''){

          $sq = mysqlQuery("update package_tour_transport_master set `transport_bus_id` = '$transp_vehicle_arr[$i]', `transport_from_date` = '$transp_start_date[$i]',`transport_end_date`='$transp_end_date[$i]', `pickup`='$pickup', `pickup_type`='$pickup_type', `drop`='$drop', `drop_type`='$drop_type', `vehicle_count`='$trans_count_arr[$i]' where entry_id='$trans_entry_id_arr[$i]'");

          if(!$sq){
            $GLOBALS['flag'] = false;
            echo "Error at row".($i+1)." for Transport information.";
          }
      }
      else{
        $sq = mysqlQuery("select max(entry_id) as max from package_tour_transport_master");
        $value = mysqli_fetch_assoc($sq);
        $max_entry_id = $value['max'] + 1;

        $sq = mysqlQuery("INSERT INTO `package_tour_transport_master`(`entry_id`, `booking_id`, `transport_bus_id`, `transport_from_date`,`transport_end_date`, `pickup`, `pickup_type`, `drop`, `drop_type`, `vehicle_count`) values ('$max_entry_id', '$booking_id', '$transp_vehicle_arr[$i]', '$transp_start_date[$i]','$transp_end_date[$i]', '$pickup', '$pickup_type', '$drop', '$drop_type', '$trans_count_arr[$i]')");

        if(!$sq){
          $GLOBALS['flag'] = false;
          echo "Error at row".($i+1)." for Transport information.";
        }
    }
}
}
//Activity Save
function package_tour_exc_information_save($booking_id, $exc_city_arr, $exc_name_arr,$exc_entry_id_arr,$exc_date_arr,$transfer_arr,$adult_arr,$cwb_arr,$cwob_arr,$infant_arr){
  for($i=0; $i<sizeof($exc_city_arr); $i++){

    $exc_city_arr[$i] = mysqlREString($exc_city_arr[$i]);
    $exc_name_arr[$i] = mysqlREString($exc_name_arr[$i]);
    $exc_date_arr[$i] = mysqlREString($exc_date_arr[$i]);
    $transfer_arr[$i] = mysqlREString($transfer_arr[$i]);
    $adult_arr[$i] = mysqlREString($adult_arr[$i]);
    $cwb_arr[$i] = mysqlREString($cwb_arr[$i]);
    $cwob_arr[$i] = mysqlREString($cwob_arr[$i]);
    $infant_arr[$i] = mysqlREString($infant_arr[$i]);
    $exc_date_arr[$i] = get_datetime_db($exc_date_arr[$i]);

    if($exc_entry_id_arr[$i]!=''){
        $sq = mysqlQuery("update package_tour_excursion_master set  city_id = '$exc_city_arr[$i]', exc_id = '$exc_name_arr[$i]',exc_date='$exc_date_arr[$i]',transfer_option='$transfer_arr[$i]',adult='$adult_arr[$i]',chwb='$cwb_arr[$i]',chwob='$cwob_arr[$i]',infant='$infant_arr[$i]' where entry_id='$exc_entry_id_arr[$i]'");

        if(!$sq){
          $GLOBALS['flag'] = false;
          echo "Error at row".($i+1)." for Activity information.";
        }
    }
    else{
      $sq = mysqlQuery("select max(entry_id) as max from package_tour_excursion_master");
      $value = mysqli_fetch_assoc($sq);
      $max_entry_id = $value['max'] + 1;

      $sq = mysqlQuery("insert into package_tour_excursion_master (entry_id, booking_id, city_id, exc_id,exc_date,transfer_option,`adult`, `chwb`, `chwob`, `infant`) values ('$max_entry_id', '$booking_id', '$exc_city_arr[$i]', '$exc_name_arr[$i]','$exc_date_arr[$i]','$transfer_arr[$i]','$adult_arr[$i]','$cwb_arr[$i]','$cwob_arr[$i]','$infant_arr[$i]')");

      if(!$sq){
        $GLOBALS['flag'] = false;
        echo "Error at row".($i+1)." for Activity information.";
      }
  }
}
}

//Ititnerary Save
function package_tour_itinerary_inf_save($booking_id, $special_attraction_arr, $day_program_arr,$stay_arr,$meal_plan_arr,$iti_entry_id_arr){
  
  for($i=0; $i<sizeof($day_program_arr); $i++){
    
      $special_attraction_arr1 = addslashes($special_attraction_arr[$i]);
      $day_program_arr1 = addslashes($day_program_arr[$i]);
      $stay_arr1 = addslashes($stay_arr[$i]);

      if($iti_entry_id_arr[$i]!=''){
          $sq = mysqlQuery("update package_tour_schedule_master set attraction = '$special_attraction_arr1', day_wise_program = '$day_program_arr1',stay='$stay_arr1',meal_plan='$meal_plan_arr[$i]' where entry_id='$iti_entry_id_arr[$i]'");

          if(!$sq){
            $GLOBALS['flag'] = false;
            echo "Error at row".($i+1)." for Tour Itinerary information.";
          }
      }
      else{
        $sq = mysqlQuery("select max(entry_id) as max from package_tour_schedule_master");
        $value = mysqli_fetch_assoc($sq);
        $max_entry_id = $value['max'] + 1;

        $sq = mysqlQuery("insert into package_tour_schedule_master (entry_id, booking_id, attraction, day_wise_program, stay,meal_plan) values ('$max_entry_id', '$booking_id', '$special_attraction_arr1', '$day_program_arr1', '$stay_arr1', '$meal_plan_arr[$i]')");

        if(!$sq){
          $GLOBALS['flag'] = false;
          echo "Error at row".($i+1)." for Tour Itinerary information.";
        }
    }
  }
}

///////////////////////////////////***** Package Tour Member Information update start *********/////////////////////////////////////////////////////////////
function package_tour_travelers_details_master_update($booking_id, $m_honorific, $m_first_name, $m_middle_name, $m_last_name, $m_gender, $m_birth_date, $m_age, $m_adolescence, $m_passport_no, $m_passport_issue_date, $m_passport_expiry_date, $m_traveler_id)
{      
    
  for($i=0; $i<sizeof($m_first_name); $i++)
  {    

    $m_honorific[$i] = mysqlREString($m_honorific[$i]);
    $m_first_name[$i] = mysqlREString($m_first_name[$i]);
    $m_middle_name[$i] = mysqlREString($m_middle_name[$i]);
    $m_last_name[$i] = mysqlREString($m_last_name[$i]);
    $m_gender[$i] = mysqlREString($m_gender[$i]);
    $m_birth_date[$i] = mysqlREString($m_birth_date[$i]);
    $m_age[$i] = mysqlREString($m_age[$i]);
    $m_adolescence[$i] = mysqlREString($m_adolescence[$i]);    
    $m_traveler_id[$i] = mysqlREString($m_traveler_id[$i]);

    $m_birth_date[$i] = date('Y-m-d', strtotime($m_birth_date[$i]));
    $m_passport_issue_date[$i] = date("Y-m-d", strtotime($m_passport_issue_date[$i]));
    $m_passport_expiry_date[$i] = date("Y-m-d", strtotime($m_passport_expiry_date[$i]));

    $count_travelers = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where traveler_id='$m_traveler_id[$i]'"));
    if($count_travelers == 1){
        $sq = mysqlQuery("update package_travelers_details set  m_honorific = '$m_honorific[$i]', first_name = '$m_first_name[$i]', middle_name = '$m_middle_name[$i]', last_name = '$m_last_name[$i]', gender = '$m_gender[$i]', birth_date = '$m_birth_date[$i]', age = '$m_age[$i]', adolescence = '$m_adolescence[$i]', passport_no='$m_passport_no[$i]', passport_issue_date='$m_passport_issue_date[$i]', passport_expiry_date='$m_passport_expiry_date[$i]' where traveler_id='$m_traveler_id[$i]'");

        if(!$sq){
          $GLOBALS['flag'] = false;
          echo "Error at row".($i+1)." for traveler members.";
        }
    }
    else{
        $sq = mysqlQuery("select max(traveler_id) as max from package_travelers_details");
        $value = mysqli_fetch_assoc($sq);
        $max_traveler_id = $value['max'] + 1;

        $sq = mysqlQuery("insert into package_travelers_details (traveler_id, booking_id, m_honorific, first_name, middle_name, last_name, gender, birth_date, age, adolescence, passport_no, passport_issue_date, passport_expiry_date, status) values ('$max_traveler_id','$booking_id', '$m_honorific[$i]', '$m_first_name[$i]', '$m_middle_name[$i]', '$m_last_name[$i]', '$m_gender[$i]', '$m_birth_date[$i]', '$m_age[$i]', '$m_adolescence[$i]', '$m_passport_no[$i]', '$m_passport_issue_date[$i]', '$m_passport_expiry_date[$i]', 'Active')");

        if(!$sq){
          $GLOBALS['flag'] = false;
          echo "Error at row".($i+1)." for traveler members.";
        }
    }
  }

}
///////////////////////////////////***** Package Tour Member Information update end *********/////////////////////////////////////////////////////////////


///////////////////////////////////***** Package Tour Traveling Information Update start *********/////////////////////////////////////////////////////////////
 function package_tour_traveling_information_update( $booking_id, $train_travel_date, $train_from_location, $train_to_location, $train_train_no, $train_travel_class, $train_travel_priority, $train_amount, $train_seats, $train_id, $plane_travel_date, $from_city_id_arr, $plane_from_location, $to_city_id_arr, $plane_to_location, $plane_amount, $plane_seats, $plane_company, $plane_id, $arrval_arr, $cruise_dept_date_arr, $cruise_arrival_date_arr, $route_arr, $cabin_arr, $sharing_arr, $cruise_seats_arr, $cruise_amount_arr,$cruise_id_arr)
 {

      //**Saves Train Information    
      
      for($i=0; $i<sizeof($train_travel_date); $i++)
      {        

        $train_travel_date[$i] = mysqlREString($train_travel_date[$i]);
        $train_from_location[$i] = mysqlREString($train_from_location[$i]);
        $train_to_location[$i] = mysqlREString($train_to_location[$i]);
        $train_train_no[$i] = mysqlREString($train_train_no[$i]);
        $train_travel_class[$i] = mysqlREString($train_travel_class[$i]);
        $train_travel_priority[$i] = mysqlREString($train_travel_priority[$i]);
        $train_amount[$i] = mysqlREString($train_amount[$i]);
        $train_seats[$i] = mysqlREString($train_seats[$i]);


        $train_travel_date[$i] = date("Y-m-d H:i", strtotime($train_travel_date[$i]));

        $count_train_details = mysqli_num_rows(mysqlQuery("select * from package_train_master where train_id='$train_id[$i]'"));

        if($count_train_details == 1)
        {
            $sq = mysqlQuery("update package_train_master set date = '$train_travel_date[$i]', from_location = '$train_from_location[$i]', to_location = '$train_to_location[$i]', train_no = '$train_train_no[$i]', train_priority = '$train_travel_priority[$i]', train_class = '$train_travel_class[$i]', amount = '$train_amount[$i]', seats = '$train_seats[$i]'  where train_id = '$train_id[$i]' and booking_id = '$booking_id'");
            if(!$sq)
             {
                $GLOBALS['flag'] = false;
                echo "Train Details Not Saved";
                //exit;
             } 
        }  
        else
        {  
          $sq = mysqlQuery("select max(train_id) as max from package_train_master");
          $value = mysqli_fetch_assoc($sq);
          $max_train_id = $value['max'] + 1;;

          $sq = mysqlQuery(" insert into package_train_master (train_id, booking_id, date, from_location, to_location, train_no, amount, seats, train_priority, train_class ) values ('$max_train_id', '$booking_id', '$train_travel_date[$i]', '$train_from_location[$i]', '$train_to_location[$i]', '$train_train_no[$i]', '$train_amount[$i]', '$train_seats[$i]', '$train_travel_priority[$i]', '$train_travel_class[$i]') ");
            if(!$sq)
            {
                $GLOBALS['flag'] = false;
                echo "Error at row".($i+1)." for train information.";
                //exit;
            }   
        }


      }  
     

      //**Saves Plane Information    
      
      for($i=0; $i<sizeof($plane_travel_date); $i++)
      {
        
        $from_city_id_arr[$i] = mysqlREString($from_city_id_arr[$i]);
        $to_city_id_arr[$i] = mysqlREString($to_city_id_arr[$i]);
        $plane_travel_date[$i] = mysqlREString($plane_travel_date[$i]);
        $plane_from_location[$i] = mysqlREString($plane_from_location[$i]);
        $plane_to_location[$i] = mysqlREString($plane_to_location[$i]);
        $plane_amount[$i] = mysqlREString($plane_amount[$i]);
        $plane_seats[$i] = mysqlREString($plane_seats[$i]);
        $plane_company[$i] = mysqlREString($plane_company[$i]);
        $arrval_arr[$i] = mysqlREString($arrval_arr[$i]);

        $from_location = array_slice(explode(' - ', $plane_from_location[$i]), 1);
        $from_location = implode(' - ',$from_location);
        $to_location = array_slice(explode(' - ', $plane_to_location[$i]), 1);
        $to_location = implode(' - ',$to_location);

        $plane_travel_date[$i] = date("Y-m-d H:i", strtotime($plane_travel_date[$i]));

        $arrval_arr[$i] = date('Y-m-d H:i', strtotime($arrval_arr[$i]));

        $count_plane_details = mysqli_num_rows(mysqlQuery("select * from package_plane_master where plane_id='$plane_id[$i]'"));

        if($count_plane_details == 1)
        {
           
          $sq = mysqlQuery("update package_plane_master set date = '$plane_travel_date[$i]', from_location = '$from_location', to_location = '$to_location', company = '$plane_company[$i]', amount = '$plane_amount[$i]', seats = '$plane_seats[$i]', arraval_time = '$arrval_arr[$i]', from_city='$from_city_id_arr[$i]', to_city='$to_city_id_arr[$i]'  where plane_id = '$plane_id[$i]' and booking_id = '$booking_id'");
           if(!$sq)
           {
              $GLOBALS['flag'] = false;
              echo "Plane Details Not Saved";
              //exit;
           } 
        }  
        else
        {  
          $sq = mysqlQuery("select max(plane_id) as max from package_plane_master");
          $value = mysqli_fetch_assoc($sq);
          $max_plane_id = $value['max'] + 1;
          $sq = mysqlQuery(" insert into package_plane_master (plane_id, booking_id, date,from_city, to_city, from_location, to_location, company, amount, seats, arraval_time ) values ('$max_plane_id', '$booking_id', '$plane_travel_date[$i]', '$from_city_id_arr[$i]', '$to_city_id_arr[$i]', '$from_location', '$to_location', '$plane_company[$i]', '$plane_amount[$i]', '$plane_seats[$i]', '$arrval_arr[$i]') ");

          if(!$sq)
          {
            $GLOBALS['flag'] = false;
            echo "Error at row".($i+1)." for Flight information.";
            //exit;
          } 
        } 
      }

      //**Saves Cruise Information    
      for($i=0; $i<sizeof($cruise_dept_date_arr); $i++)
      {        
        $cruise_dept_date_arr[$i] = mysqlREString($cruise_dept_date_arr[$i]);
        $cruise_arrival_date_arr[$i] = mysqlREString($cruise_arrival_date_arr[$i]);
        $route_arr[$i] = mysqlREString($route_arr[$i]);
        $cabin_arr[$i] = mysqlREString($cabin_arr[$i]);
        $sharing_arr[$i] = mysqlREString($sharing_arr[$i]);
        $cruise_seats_arr[$i] = mysqlREString($cruise_seats_arr[$i]);
        $cruise_amount_arr[$i] = mysqlREString($cruise_amount_arr[$i]);
        $cruise_id_arr[$i] = mysqlREString($cruise_id_arr[$i]);
        $cruise_dept_date_arr[$i] = date("Y-m-d, H:i", strtotime($cruise_dept_date_arr[$i]));        
        $cruise_arrival_date_arr[$i] = date("Y-m-d, H:i", strtotime($cruise_arrival_date_arr[$i]));   

        if($cruise_id_arr[$i] != '')
        {
            $sq = mysqlQuery("update package_cruise_master set dept_datetime = '$cruise_dept_date_arr[$i]', arrival_datetime = '$cruise_arrival_date_arr[$i]', route = '$route_arr[$i]', cabin = '$cabin_arr[$i]', sharing = '$sharing_arr[$i]', seats = '$cruise_seats_arr[$i]', amount = '$cruise_amount_arr[$i]' where cruise_id = '$cruise_id_arr[$i]' and booking_id = '$booking_id'");
            if(!$sq)
             {
                $GLOBALS['flag'] = false;
                echo "Cruise Details Not Updated";
                //exit;
             } 
        }
        else
        {  
            $sq = mysqlQuery("select max(cruise_id) as max from package_cruise_master");
            $value = mysqli_fetch_assoc($sq);
            $max_cruise_id = $value['max'] + 1;

            $sq = mysqlQuery("insert into package_cruise_master (cruise_id, booking_id, dept_datetime, arrival_datetime, route, cabin,sharing, seats, amount ) values ('$max_cruise_id', '$booking_id', '$cruise_dept_date_arr[$i]', '$cruise_arrival_date_arr[$i]', '$route_arr[$i]', '$cabin_arr[$i]', '$sharing_arr[$i]', '$cruise_seats_arr[$i]', '$cruise_amount_arr[$i]') ");
            if(!$sq)
            {
                $GLOBALS['flag'] = false;
                echo "Error at row".($i+1)." for cruise information.";
                //exit;
            } 
        }

      }  
    

 }

///////////////////////////////////***** Package Tour Traveling Information Update end *********/////////////////////////////////////////////////////////////

///////////////////////////////***** Package Tour Hotel accomodation information update start*******/////////////////////////////////////////////////////////////

function package_tour_hotel_accomodation_information_update($booking_id, $city_id, $hotel_id, $hotel_from_date, $hotel_to_date, $hotel_rooms, $hotel_catagory, $room_type, $hotel_meal_plan, $confirmation_no, $hotel_acc_id)
 {

    for($i=0; $i<sizeof($hotel_id); $i++)
    {
      $hotel_from_date[$i] = date("Y-m-d H:i", strtotime($hotel_from_date[$i]));
      $hotel_to_date[$i] = date("Y-m-d H:i", strtotime($hotel_to_date[$i]));

      $city_id[$i] = mysqlREString($city_id[$i]);
      $hotel_id[$i] = mysqlREString($hotel_id[$i]);
      $hotel_from_date[$i] = mysqlREString($hotel_from_date[$i]);
      $hotel_to_date[$i] = mysqlREString($hotel_to_date[$i]);
      $hotel_rooms[$i] = mysqlREString($hotel_rooms[$i]);
      $hotel_catagory[$i] = mysqlREString($hotel_catagory[$i]);
      $room_type[$i] = mysqlREString($room_type[$i]);
      $hotel_meal_plan[$i] = mysqlREString($hotel_meal_plan[$i]);
      $confirmation_no[$i] = mysqlREString($confirmation_no[$i]);

      $count_hotel_details = mysqli_num_rows(mysqlQuery("select * from package_hotel_accomodation_master where id='$hotel_acc_id[$i]'"));

      if($count_hotel_details==1)
      {
        $sq_hotel = mysqlQuery("update package_hotel_accomodation_master set city_id='$city_id[$i]', hotel_id='$hotel_id[$i]', from_date='$hotel_from_date[$i]', to_date='$hotel_to_date[$i]', rooms='$hotel_rooms[$i]', catagory='$hotel_catagory[$i]', room_type='$room_type[$i]', meal_plan='$hotel_meal_plan[$i]', confirmation_no='$confirmation_no[$i]' where id='$hotel_acc_id[$i]'");
        if(!$sq_hotel)
        {
          $GLOBALS['flag'] = false;
          echo "Hotel accommodation information not updated.";
        } 
      } 
      else
      {
        $sq = mysqlQuery("select max(id) as max from package_hotel_accomodation_master");
        $value = mysqli_fetch_assoc($sq);
        $max_hotel_id = $value['max'] + 1;

        $sq_hotel = mysqlQuery("insert into package_hotel_accomodation_master (id, booking_id, city_id, hotel_id, from_date, to_date, rooms, catagory, room_type, meal_plan, confirmation_no) value ('$max_hotel_id', '$booking_id', '$city_id[$i]', '$hotel_id[$i]', '$hotel_from_date[$i]', '$hotel_to_date[$i]', '$hotel_rooms[$i]', '$hotel_catagory[$i]', '$room_type[$i]', '$hotel_meal_plan[$i]', '$confirmation_no[$i]')");
        if(!$sq_hotel)
        {
          $GLOBALS['flag'] = false;
          echo "Hotel accommodation information not updated.";
        }
      } 

        


    } 

 }

///////////////////////////////***** Package Tour Hotel accommodation information update end*******/////////////////////////////////////////////////////////////


}
?>