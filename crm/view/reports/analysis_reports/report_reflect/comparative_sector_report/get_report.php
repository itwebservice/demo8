<?php
include "../../../../../model/model.php";

$fromdate = !empty($_POST['fromdate']) ? get_date_db($_POST['fromdate']) :null;
$todate = !empty($_POST['todate']) ? get_date_db($_POST['todate']) :null;
$array_s = array();

if(isset($_SESSION['dateqry']) && isset($_SESSION['group_qry']) && isset($_SESSION['package_qry']))
{
    unset( $_SESSION['dateqry']);
   unset( $_SESSION['group_qry']);
   unset( $_SESSION['package_qry']);
}

if(empty($fromdate) && empty($todate) )
{
    $_SESSION['dateqry'] = "";
    $_SESSION['group_qry'] = "";
    $_SESSION['package_qry'] = "";
}
else
{
    
    if(!empty($fromdate) && !empty($todate))
    {
        $_SESSION['dateqry'] .= "and ticket_master.created_at between '".$fromdate."' and '".$todate."' ";    
        $_SESSION['group_qry'] .= "and tourwise_traveler_details.form_date between '".$fromdate."' and '".$todate."' ";    
        $_SESSION['package_qry'] .= "and package_tour_booking_master.tour_from_date between '".$fromdate."' and '".$todate."' ";    
    }
}




function get_total($sector_from, $sector_to){

    $query1 = "SELECT departure_city,arrival_city,count(*) as total FROM airline_master INNER JOIN ticket_trip_entries on airline_master.airline_code = ticket_trip_entries.flight_no inner join ticket_master on ticket_trip_entries.ticket_id = ticket_master.ticket_id where ticket_trip_entries.departure_city='".$sector_from."' AND ticket_trip_entries.arrival_city='".$sector_to."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $allTotal = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $allTotal+= $db['total'];
    }
    return  $allTotal;
}





function get_amount($sector_from, $sector_to){
   
    $query1 = "SELECT * FROM airline_master INNER JOIN ticket_trip_entries on airline_master.airline_code = ticket_trip_entries.flight_no inner join ticket_master on ticket_trip_entries.ticket_id = ticket_master.ticket_id where ticket_trip_entries.departure_city='".$sector_from."' AND ticket_trip_entries.arrival_city='".$sector_to."' ".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
   
    while($db = mysqli_fetch_array($res))
    {
            $amount+=$db['ticket_total_cost'];
    }
      return $amount; 
}


function get_group_total($sector_from, $sector_to){
   
    $query1 = "SELECT from_location,to_location,count(*) as total FROM plane_master INNER JOIN tourwise_traveler_details on plane_master.tourwise_traveler_id = tourwise_traveler_details.traveler_group_id INNER JOIN airline_master on plane_master.company = airline_master.airline_id INNER JOIN tour_master on tourwise_traveler_details.tour_id= tour_master.tour_id where plane_master.from_location='".$sector_from."'  AND plane_master.to_location='".$sector_to."' ".$_SESSION['group_qry'];
    $res = mysqlQuery($query1);
    $allTotal = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $allTotal+= $db['total'];
    }
    return  $allTotal;
}





function get_group_amount($sector_from, $sector_to){
   
    $query1 = "SELECT * FROM plane_master INNER JOIN tourwise_traveler_details on plane_master.tourwise_traveler_id = tourwise_traveler_details.traveler_group_id INNER JOIN airline_master on plane_master.company = airline_master.airline_id INNER JOIN tour_master on tourwise_traveler_details.tour_id= tour_master.tour_id where plane_master.from_location='".$sector_from."'  AND plane_master.to_location='".$sector_to."' ".$_SESSION['group_qry'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['plane_expense']);
    }
      return $amount; 
}

function get_package_total($sector_from, $sector_to){
   
    $query1 = "SELECT from_location,to_location,count(*) as total FROM package_plane_master INNER JOIN airline_master ON package_plane_master.company = airline_master.airline_id INNER JOIN package_tour_booking_master on package_plane_master.booking_id = package_tour_booking_master.booking_id INNER JOIN customer_master on package_tour_booking_master.customer_id = customer_master.customer_id where package_plane_master.from_location='".$sector_from."'  AND package_plane_master.to_location='".$sector_to."' ".$_SESSION['package_qry'];
    $res = mysqlQuery($query1);
    $allTotal = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $allTotal+= $db['total'];
    }
    return  $allTotal; 
}





function get_package_amount($sector_from, $sector_to){
   
    $query1 = "SELECT * FROM package_plane_master INNER JOIN airline_master ON package_plane_master.company = airline_master.airline_id  INNER JOIN package_tour_booking_master on package_plane_master.booking_id = package_tour_booking_master.booking_id INNER JOIN customer_master on package_tour_booking_master.customer_id = customer_master.customer_id where package_plane_master.from_location='".$sector_from."'  AND package_plane_master.to_location='".$sector_to."' ".$_SESSION['package_qry'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['amount']);
    }
      return $amount; 
}

//main qry

$main = array();



//Airline
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM airline_master INNER JOIN ticket_trip_entries on airline_master.airline_code = ticket_trip_entries.flight_no inner join ticket_master on ticket_trip_entries.ticket_id = ticket_master.ticket_id INNER JOIN customer_master on ticket_master.customer_id = customer_master.customer_id ";
}
else
{                                                                                                                                                      
    $query=  "SELECT * FROM airline_master INNER JOIN ticket_trip_entries on airline_master.airline_code = ticket_trip_entries.flight_no inner join ticket_master on ticket_trip_entries.ticket_id = ticket_master.ticket_id INNER JOIN customer_master on ticket_master.customer_id = customer_master.customer_id where 1=1 ".$_SESSION['dateqry']."";
}
$result = mysqlQuery($query);
$count = 1;
while($dataAirlines = mysqli_fetch_assoc($result))
{
        $temp = [
            'sector_from' => $dataAirlines['departure_city'],
            'sector_to' => $dataAirlines['arrival_city'],
            'from_location' => $dataAirlines['departure_city'],
            'to_location' => $dataAirlines['arrival_city'],
        ];


        array_push($main,$temp);
}


//group
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM plane_master INNER JOIN tourwise_traveler_details on plane_master.tourwise_traveler_id = tourwise_traveler_details.traveler_group_id INNER JOIN airline_master on plane_master.company = airline_master.airline_id INNER JOIN customer_master on tourwise_traveler_details.customer_id = customer_master.customer_id INNER JOIN tour_master on tourwise_traveler_details.tour_id= tour_master.tour_id ";

}
else
{                                                                                                                                                      
    $query=  "SELECT * FROM plane_master INNER JOIN tourwise_traveler_details on plane_master.tourwise_traveler_id = tourwise_traveler_details.traveler_group_id INNER JOIN airline_master on plane_master.company = airline_master.airline_id INNER JOIN customer_master on tourwise_traveler_details.customer_id = customer_master.customer_id INNER JOIN tour_master on tourwise_traveler_details.tour_id= tour_master.tour_id where 1=1 ".$_SESSION['group_qry'];

}

$result = mysqlQuery($query);
$count = 1;
while($dataGroup = mysqli_fetch_assoc($result))
{

        $temp = [
           
            'sector_from' => $dataGroup['from_location'],
            'sector_to' =>$dataGroup['to_location'],
            'from_location' =>  $dataGroup['from_location'],
            'to_location' =>  $dataGroup['to_location'],
           
        ];
        array_push($main,$temp);
    
}

//package
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM package_plane_master INNER JOIN airline_master ON package_plane_master.company = airline_master.airline_id INNER JOIN package_tour_booking_master on package_plane_master.booking_id = package_tour_booking_master.booking_id INNER JOIN customer_master on package_tour_booking_master.customer_id = customer_master.customer_id  ";

}
else
{                                                                                                                                                      
    $query=  "SELECT * FROM package_plane_master INNER JOIN airline_master ON package_plane_master.company = airline_master.airline_id INNER JOIN package_tour_booking_master on package_plane_master.booking_id = package_tour_booking_master.booking_id INNER JOIN customer_master on package_tour_booking_master.customer_id = customer_master.customer_id where 1=1 ".$_SESSION['package_qry'];

}


$result = mysqlQuery($query);
$count = 1;
while($dataPackage = mysqli_fetch_assoc($result))
{

        $temp = [
            'sector_from' => $dataPackage['from_location'],
            'sector_to' =>$dataPackage['to_location'],
            'from_location' =>  $dataPackage['from_location'],
            'to_location' =>  $dataPackage['to_location'],
           
        ];

        array_push($main,$temp);
    
}

$From_location = array();
$to_location = array();
$main_location = array();
$id_main = array();
$index = 0;
foreach($main as $data)
{
           
        if(!in_array($data['sector_from'].'-'.$data['sector_to'],$main_location))
        {
        array_push($From_location,$data['sector_from']);
        array_push($to_location,$data['sector_to']);
        array_push($main_location,$data['sector_from'].'-'.$data['sector_to']);
        array_push($id_main,($data['from_location'].' '.$data['to_location']));
        }     
}

for($i=0;$i<=count($main_location)-1;$i++)
{
       
        $temparr = array("data" => array
        (
                $main_location[$i],
               
                get_total($From_location[$i],$to_location[$i]) + get_group_total($From_location[$i],$to_location[$i]) +  get_package_total($From_location[$i],$to_location[$i]),
                get_amount($From_location[$i],$to_location[$i]) + get_group_amount($From_location[$i],$to_location[$i]) + get_package_amount($From_location[$i],$to_location[$i]),
			    '<button class="btn btn-info btn-sm" onclick="view_com_sector_modal(`'.$From_location[$i].'`,`'.$to_location[$i] .'`)" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>' 
        ),"bg" =>$bg );
      
       array_push($array_s, $temparr);
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
