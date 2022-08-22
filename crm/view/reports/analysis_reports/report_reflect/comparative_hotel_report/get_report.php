<?php
include "../../../../../model/model.php";
$cityid = !empty($_POST['cityid']) ? $_POST['cityid']:null;
$hotelid = !empty($_POST['hotelid']) ? $_POST['hotelid']:null;
$fromdate = !empty($_POST['fromdate']) ? get_date_db($_POST['fromdate']) :null;
$todate = !empty($_POST['todate']) ? get_date_db($_POST['todate']) :null;
$array_s = array();
if(isset($_SESSION['dateqry']) && isset($_SESSION['package_qry']))
{
    unset( $_SESSION['dateqry']);
   unset( $_SESSION['package_qry']);
}

if(empty($fromdate) && empty($todate) || empty($hotelid) || empty($cityid))
{
    $_SESSION['dateqry'] = "";
    $_SESSION['package_qry'] = "";
}
else
{
    if(!empty($hotelid))
    {
        $_SESSION['dateqry'] .= "and hotel_master.hotel_id ='".$hotelid."'";    
        $_SESSION['package_qry'] .= "and hotel_master.hotel_id ='".$hotelid."'";    
    }
    if(!empty($cityid))
    {
        $_SESSION['dateqry'] .= "and hotel_master.city_id ='".$cityid."'";    
        $_SESSION['package_qry'] .= "and hotel_master.city_id ='".$cityid."'";    
    }
    if(!empty($fromdate) && !empty($todate))
    {
        $_SESSION['dateqry'] .= "and hotel_booking_master.created_at between '".$fromdate."' and '".$todate."' ";   
        $_SESSION['package_qry'] .= "and package_tour_booking_master.booking_date between '".$fromdate."' and '".$todate."'";
    }
}


function package_hotel_rooms($id)
{
        $sql = "SELECT * FROM hotel_master  INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id inner join vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id WHERE hotel_master.hotel_id= '".$id."'";
        $res=mysqlquery($sql);
        $rooms = 0; 
        $count = mysqli_num_rows($res);
        while($db = mysqli_fetch_array($res))
        {
            $rooms+= (int)$db['rooms'];
        }
        return  $rooms; 
}
function package_hotel_nights($id)
{
    $sql = "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id inner join vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id WHERE hotel_master.hotel_id= '".$id."'";
    $res=mysqlquery($sql);
    $total_nights = 0; 
    $total_nights2 = 0; 
    $total_nightss = 0; 
    
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
        $total_nights=new datetime($db['from_date']);
        $total_nights2=new datetime($db['to_date']);
        $total_nightss += $total_nights->diff($total_nights2)->format("%r%a");
        
    }
    return $total_nightss; 

}


function hotel_rooms($id)
{
    $query1 = "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER JOIN hotel_booking_entries on hotel_master.hotel_id = hotel_booking_entries.hotel_id INNER JOIN hotel_booking_master on hotel_booking_entries.booking_id = hotel_booking_master.booking_id where hotel_master.hotel_id='$id'".$_SESSION['dateqry'];
    $res=mysqlQuery($query1);
    $rooms = 0;
   
    while($db = mysqli_fetch_array($res))
        {
            $rooms += (int) $db['rooms'];
        }
        return  $rooms;
}

function get_nights($id){
   
    $query1 = "SELECT * FROM hotel_master INNER JOIN hotel_booking_entries on hotel_master.hotel_id = hotel_booking_entries.hotel_id INNER JOIN  hotel_booking_master on hotel_booking_entries.booking_id = hotel_booking_master.booking_id where hotel_master.hotel_id='".$id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $nights = 0; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $nights+= $db['no_of_nights'];
    }
      return  $nights; 
}


function get_amount($id){
   
    $query1 = "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER JOIN hotel_booking_entries on hotel_master.hotel_id = hotel_booking_entries.hotel_id INNER JOIN hotel_booking_master on hotel_booking_entries.booking_id = hotel_booking_master.booking_id where hotel_master.hotel_id='$id'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['sub_total']);
    }
      return $amount; 
}
function get_package_amount($id){
   
    $query1 = "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id inner join vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id where hotel_master.hotel_id='".$id."' ". $_SESSION['package_qry'];
    $res = mysqlQuery($query1);
    $amount = 0.00; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $amount+=floatval($db['basic_cost']);
    }
      return $amount; 
}

//main qry

$main = array();



//hotel
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER JOIN hotel_booking_entries on hotel_master.hotel_id = hotel_booking_entries.hotel_id INNER JOIN hotel_booking_master on hotel_booking_entries.booking_id = hotel_booking_master.booking_id group by hotel_master.hotel_id ";
}
else
{                                                                                                                                                      
    $query=  "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER JOIN hotel_booking_entries on hotel_master.hotel_id = hotel_booking_entries.hotel_id INNER JOIN hotel_booking_master on hotel_booking_entries.booking_id = hotel_booking_master.booking_id ".$_SESSION['dateqry'];
}
$result = mysqlQuery($query);
$count = 1;
while($dataHotel = mysqli_fetch_assoc($result))
{
        $temp = [
            'hotel_name' => $dataHotel['hotel_name'],
            'city_name' =>  $dataHotel['city_name'],
            'hotel_id' =>  $dataHotel['hotel_id'],
           
        ];
        array_push($main,$temp);
}


//package
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id inner join vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id group by hotel_master.hotel_id ";

}
else
{                                                                                                                                                      
    $query=  "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id inner join vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id  where 1=1 ".$_SESSION['package_qry'];

}
$result = mysqlQuery($query);
$count = 1;
while($dataPackage = mysqli_fetch_assoc($result))
{

        $temp = [
            'hotel_name' => $dataPackage['hotel_name'],
            'city_name' =>  $dataPackage['city_name'],
            'hotel_id' =>  $dataPackage['hotel_id'],
           
        ];
        array_push($main,$temp);
    
}

$hotel_main = array();
$city_main = array();

$id_main = array();
$index = 0;
foreach($main as $data)
{
           
        if(!in_array($data['hotel_name'],$hotel_main))
        {
        array_push($hotel_main,$data['hotel_name']);
        array_push($city_main,$data['city_name']);
        array_push($id_main,$data['hotel_id']);
        }     
}


for($i=0;$i<=count($hotel_main)-1;$i++)
{
       
        $temparr = array("data" => array
        (
                $city_main[$i],
                $hotel_main[$i],
                hotel_rooms($id_main[$i]) + package_hotel_rooms($id_main[$i]),
                package_hotel_nights($id_main[$i]) +
                get_nights($id_main[$i]),
                get_amount($id_main[$i]) +get_package_amount($id_main[$i]) ,
			    '<button class="btn btn-info btn-sm" onclick="view_com_hotel_modal('. $id_main[$i] .')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>' 
        ),"bg" =>$bg );
      
       array_push($array_s, $temparr);
}



$footer_data = array("footer_data" => array(
	'total_footers' => 0,

	)
);

// //while $db
// //<option value="$db['hotelid]">hotelname</option>

array_push($array_s, $footer_data); 

echo json_encode($array_s);
