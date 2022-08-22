<?php
include "../../../../../model/model.php";

$fromdate = !empty($_POST['fromdate']) ? get_date_db($_POST['fromdate']) :null;
$todate = !empty($_POST['todate']) ? get_date_db($_POST['todate']) :null;
$array_s = array();



if(empty($fromdate) && empty($todate))
{
       
        $_SESSION['aRcar'] = "";        
        $_SESSION['aRvisa'] = "";        
        $_SESSION['aRbus'] = "";        
        $_SESSION['aRexcursion'] = "";        
        $_SESSION['aRmiscellaneous'] = "";        
        $_SESSION['aRhotel'] = "";        
        $_SESSION['aRticket'] = "";        
        $_SESSION['aRtrain'] = "";        
        $_SESSION['aRtour'] = "";        
        $_SESSION['aRpackage'] = "";}
else
{
    if(!empty($fromdate) && !empty($todate))
    {
        $_SESSION['aRcar'] = "";        
        $_SESSION['aRvisa'] = "";        
        $_SESSION['aRbus'] = "";        
        $_SESSION['aRexcursion'] = "";        
        $_SESSION['aRmiscellaneous'] = "";        
        $_SESSION['aRhotel'] = "";        
        $_SESSION['aRticket'] = "";        
        $_SESSION['aRtrain'] = "";        
        $_SESSION['aRtour'] = "";        
        $_SESSION['aRpackage'] = "";
        $_SESSION['aRcar'] .= "and car_rental_booking.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRvisa'] .= "and visa_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRbus'] .= "and bus_booking_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRexcursion'] .= "and excursion_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRmiscellaneous'] .= "and miscellaneous_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRhotel'] .= "and hotel_booking_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRticket'] .= "and ticket_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRtrain'] .= "and train_ticket_master.created_at between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRtour'] .= "and tourwise_traveler_details.form_date between '".$fromdate."' and '".$todate."' ";        
        $_SESSION['aRpackage'] .= "and package_tour_booking_master.booking_date between '".$fromdate."' and '".$todate."' ";        
    }
}


function get_car_rental($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN car_rental_booking ON customer_master.customer_id = car_rental_booking.customer_id INNER JOIN vendor_estimate On car_rental_booking.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Car Rental' AND customer_master.customer_id='".$customer."'".$_SESSION['aRcar'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_car_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN car_rental_booking ON customer_master.customer_id = car_rental_booking.customer_id INNER JOIN vendor_estimate On car_rental_booking.booking_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRcar'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['total_cost']);
    }
      return $amount; 
}
function get_car_profit($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN car_rental_booking ON customer_master.customer_id = car_rental_booking.customer_id INNER JOIN vendor_estimate On car_rental_booking.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Car Rental' AND  customer_master.customer_id='".$customer."'".$_SESSION['aRcar'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['total_cost'] - $db['net_total']);
    }
      return $profit; 
}


function get_visa($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master  INNER JOIN visa_master ON customer_master.customer_id = visa_master.customer_id INNER JOIN vendor_estimate On visa_master.visa_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Visa Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRvisa'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}
function get_visa_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master  INNER JOIN visa_master ON customer_master.customer_id = visa_master.customer_id INNER JOIN vendor_estimate On visa_master.visa_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRvisa'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['visa_total_cost']);
    }
      return $amount; 
}

function get_visa_profit($customer){
   
    $query1 = "SELECT * FROM Customer_master  INNER JOIN visa_master ON customer_master.customer_id = visa_master.customer_id INNER JOIN vendor_estimate On visa_master.visa_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Visa Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRvisa'];
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['visa_total_cost'] - $db['net_total']);
    }
      return $profit; 
}

function get_bus($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master  INNER JOIN bus_booking_master ON customer_master.customer_id =  bus_booking_master.customer_id  INNER JOIN vendor_estimate On bus_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Bus Booking' AND  customer_master.customer_id='".$customer."'".$_SESSION['aRbus'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_bus_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN bus_booking_master ON customer_master.customer_id =  bus_booking_master.customer_id INNER JOIN vendor_estimate On bus_booking_master.booking_id = vendor_estimate.estimate_type_id  where customer_master.customer_id='".$customer."'".$_SESSION['aRbus'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['net_total']);
    }
      return $amount; 
}


function get_bus_profit($customer){
    
    $query1 = "SELECT bus_booking_master.net_total as total_cost,vendor_estimate.net_total FROM Customer_master INNER JOIN bus_booking_master ON customer_master.customer_id =  bus_booking_master.customer_id INNER JOIN vendor_estimate On bus_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Bus Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRbus'];
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['total_cost'] - $db['net_total']);
    }
      return $profit; 
}


function get_excursion($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master  INNER JOIN  excursion_master ON customer_master.customer_id = excursion_master.customer_id  INNER JOIN vendor_estimate on excursion_master.exc_id = vendor_estimate.estimate_type_id  where vendor_estimate.estimate_type = 'Excursion Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRexcursion'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_excursion_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master  INNER JOIN  excursion_master ON customer_master.customer_id = excursion_master.customer_id INNER JOIN vendor_estimate on excursion_master.exc_id = vendor_estimate.estimate_type_id  where customer_master.customer_id='".$customer."'".$_SESSION['aRexcursion'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['exc_total_cost']);
    }
      return $amount; 
}

function get_excursion_profit($customer){
   
    $query1 = "SELECT * FROM Customer_master  INNER JOIN  excursion_master ON customer_master.customer_id = excursion_master.customer_id  INNER JOIN vendor_estimate on excursion_master.exc_id = vendor_estimate.estimate_type_id  where vendor_estimate.estimate_type = 'Excursion Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRexcursion'];
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['exc_total_cost'] - $db['net_total']);
    }
      return $profit; 
}

function get_misc($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN miscellaneous_master ON customer_master.customer_id = miscellaneous_master.customer_id INNER JOIN vendor_estimate on miscellaneous_master.misc_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Miscellaneous Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRmiscellaneous'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_misc_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN miscellaneous_master ON customer_master.customer_id = miscellaneous_master.customer_id INNER JOIN vendor_estimate on miscellaneous_master.misc_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRmiscellaneous'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['misc_total_cost']);
    }
      return $amount; 
}
function get_misc_profit($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN miscellaneous_master ON customer_master.customer_id = miscellaneous_master.customer_id INNER JOIN vendor_estimate on miscellaneous_master.misc_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Miscellaneous Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRmiscellaneous'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['misc_total_cost'] - $db['net_total']);
    }
      return $profit; 
}


function get_hotel($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN hotel_booking_master ON customer_master.customer_id = hotel_booking_master.customer_id INNER JOIN vendor_estimate on hotel_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Hotel Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRhotel'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_hotel_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN hotel_booking_master ON customer_master.customer_id = hotel_booking_master.customer_id INNER JOIN vendor_estimate on hotel_booking_master.booking_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRhotel'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['total_fee']);
    }
      return $amount; 
}
function get_hotel_profit($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN hotel_booking_master ON customer_master.customer_id = hotel_booking_master.customer_id INNER JOIN vendor_estimate on hotel_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Hotel Booking' AND  customer_master.customer_id='".$customer."'".$_SESSION['aRhotel'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['total_fee'] - $db['net_total']);
    }
      return $profit; 
}

function get_ticket($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN ticket_master ON customer_master.customer_id = ticket_master.customer_id INNER JOIN vendor_estimate on ticket_master.ticket_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Ticket Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRticket'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_ticket_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN ticket_master ON customer_master.customer_id = ticket_master.customer_id INNER JOIN vendor_estimate on ticket_master.ticket_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRticket'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['ticket_total_cost']);
    }
      return $amount; 
}
function get_ticket_profit($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN ticket_master ON customer_master.customer_id = ticket_master.customer_id INNER JOIN vendor_estimate on ticket_master.ticket_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Ticket Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRticket'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['ticket_total_cost'] - $db['net_total']);
    }
      return $profit; 
}

function get_train($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN train_ticket_master ON customer_master.customer_id = train_ticket_master.customer_id INNER JOIN vendor_estimate on train_ticket_master.train_ticket_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Train Ticket Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRtrain'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_train_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN train_ticket_master ON customer_master.customer_id = train_ticket_master.customer_id INNER JOIN vendor_estimate on train_ticket_master.train_ticket_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRtrain'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['net_total']);
    }
      return $amount; 
}
function get_train_profit($customer){
   
    $query1 = "SELECT train_ticket_master.net_total as total_cost,vendor_estimate.net_total FROM Customer_master INNER JOIN train_ticket_master ON customer_master.customer_id = train_ticket_master.customer_id INNER JOIN vendor_estimate on train_ticket_master.train_ticket_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Train Ticket Booking' AND customer_master.customer_id='".$customer."'".$_SESSION['aRtrain'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['total_cost'] - $db['net_total']);
    }
      return $profit; 
}

function get_tourwise($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN tourwise_traveler_details ON customer_master.customer_id = tourwise_traveler_details.customer_id INNER JOIN vendor_estimate on tourwise_traveler_details.id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Group Tour' AND customer_master.customer_id='".$customer."'".$_SESSION['aRtour'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_tourwise_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN tourwise_traveler_details ON customer_master.customer_id = tourwise_traveler_details.customer_id INNER JOIN vendor_estimate on tourwise_traveler_details.id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRtour'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['net_total']);
    }
      return $amount; 
}
function get_tourwise_profit($customer){
   
    $query1 = "SELECT tourwise_traveler_details.net_total as total_cost,vendor_estimate.net_total FROM Customer_master INNER JOIN tourwise_traveler_details ON customer_master.customer_id = tourwise_traveler_details.customer_id INNER JOIN vendor_estimate on tourwise_traveler_details.id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Group Tour' AND customer_master.customer_id='".$customer."'".$_SESSION['aRtour'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['total_cost'] - $db['net_total']);
    }
      return $profit; 
}

function get_package($customer){
   
    $query1 = "SELECT customer_master.customer_id, count(*) as booking FROM Customer_master INNER JOIN package_tour_booking_master ON customer_master.customer_id = package_tour_booking_master.customer_id INNER JOIN vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Package Tour' AND customer_master.customer_id='".$customer."'".$_SESSION['aRpackage'];
    $res = mysqlQuery($query1);
    $booking = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $booking+= $db['booking'];
    }
      return  $booking; 
}

function get_package_amount($customer){
   
    $query1 = "SELECT * FROM Customer_master INNER JOIN package_tour_booking_master ON customer_master.customer_id = package_tour_booking_master.customer_id INNER JOIN vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id where customer_master.customer_id='".$customer."'".$_SESSION['aRpackage'];  
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['net_total']);
    }
      return $amount; 
}
function get_package_profit($customer){
   
    $query1 = "SELECT package_tour_booking_master.net_total as total_cost,vendor_estimate.net_total FROM Customer_master INNER JOIN package_tour_booking_master ON customer_master.customer_id = package_tour_booking_master.customer_id INNER JOIN vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Package Tour' AND customer_master.customer_id='".$customer."'".$_SESSION['aRpackage'];  
    $res = mysqlQuery($query1);
    $profit = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $profit+=floatval($db['total_cost'] - $db['net_total']);
    }
      return $profit; 
}

//main qry

$main = array();



//Airline
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM Customer_master";
}
else
{                                                                                                                                                      
    $query=  "SELECT * FROM Customer_master";
}

$result = mysqlQuery($query);
$count = 1;
while($db = mysqli_fetch_assoc($result))
{
     
    $totalBookings = get_car_rental($db['customer_id']) + get_visa($db['customer_id']) +  get_bus($db['customer_id']) +  get_excursion($db['customer_id']) + get_misc($db['customer_id']) + get_hotel($db['customer_id']) + get_ticket($db['customer_id'])  + get_train($db['customer_id']) + get_tourwise($db['customer_id']) + get_package($db['customer_id']);
    if($totalBookings >= 1)
    {
    $temparr = array("data" => array
        (
                (int) ($count++),
                $db['first_name'].' '.$db['last_name'] ,
                $totalBookings,
                get_car_amount($db['customer_id']) + get_visa_amount($db['customer_id']) + get_bus_amount($db['customer_id']) + get_excursion_amount($db['customer_id']) + get_misc_amount($db['customer_id']) + get_hotel_amount($db['customer_id']) + get_ticket_amount($db['customer_id']) + get_train_amount($db['customer_id']) + get_tourwise_amount($db['customer_id']) + get_package_amount($db['customer_id']),

                get_car_profit($db['customer_id'])+ get_visa_profit($db['customer_id']) + get_bus_profit($db['customer_id']) + get_excursion_profit($db['customer_id']) + get_misc_profit($db['customer_id']) + get_hotel_profit($db['customer_id']) + get_ticket_profit($db['customer_id']) + get_train_profit($db['customer_id']) + get_tourwise_profit($db['customer_id']) + get_package_profit($db['customer_id']),
                
                '<button class="btn btn-info btn-sm" onclick="view_rep_customer_modal('.$db['customer_id'] .')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>' 
        ),"bg" =>$bg );
      
       array_push($array_s, $temparr);
    }
}


    
    

$footer_data = array("footer_data" => array(
	// 'total_footers' => 2,
			
	// 'foot0' => " ",
	// 'class0' => "text-left info",
	
    // 'foot1' => "Total :",
	// 'class1' => "text-left info",

	
	)
);


array_push($array_s, $footer_data); 
echo json_encode($array_s);
