<?php
include "../../../../../model/model.php";
date_default_timezone_set('Asia/Kolkata');
$selectedDate = !empty($_POST['date']) ? get_date_db($_POST['date']) : null;
$array_s = array();

function addDayInDate($date)
{
    $Date1 = $date;
    $date = new DateTime($Date1);
    $date->add(new DateInterval('P1D')); // P1D means a period of 1 day
    $Date2 = $date->format('Y-m-d');
    return $Date2;
}

function getTodaysItenaryByPackage($id,$selectedDate)
{
    
    $temp = array();
    $query =  "SELECT * FROM package_quotation_program inner join package_tour_booking_master on package_quotation_program.quotation_id=package_tour_booking_master.quotation_id where package_tour_booking_master.booking_id='$id'";
    $res = mysqlQuery($query);
    $first = 0;
    $i = 1;
    $usedId = 0;
    //date('Y-m-d', strtotime($Date. ' + 1 days'));
    while ($data = mysqli_fetch_assoc($res)) {
        
        if (!empty($selectedDate)) {
            if ($first == 0) {
                $date = new DateTime($data['tour_from_date']);
                // $date = $date->format('Y-m-d');
            }

            if ($date >= new DateTime($data['tour_from_date'])  &&  $date <= new DateTime($data['tour_to_date'])) {
                if ($date->format('Y-m-d') == $selectedDate) {
                         
                    if ($usedId != $data['booking_id']) {
                        //return $data[$field];
                        $getPassenger = getPassengers($data['booking_id']);
                        return  $temparr = array("data" => array(
                            (int) ($i++),
                            $data['booking_id']  ,
                            $data['contact_person_name'].' ['. json_encode($getPassenger).']',
                            $data['attraction'],
                            $data['day_wise_program'],
                            $data['stay'],
                            $data['meal_plan']


                            // '<button class="btn btn-info btn-sm" onclick="view_desti_wise_modal(' . $data['dest_id'] . ')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


                        ), "bg" => '');
                        $usedId = $data['booking_id'];
                    }
                }
                $date = addDayInDate($date->format('Y-m-d'));
                $date = new DateTime($date);
                $first = 1;
            }
        } else {
            if ($first == 0) {
                $date = new DateTime($data['tour_from_date']);
                // $date = $date->format('Y-m-d');
            }

            if ($date >= new DateTime($data['tour_from_date'])  &&  $date <= new DateTime($data['tour_to_date'])) {
                
                if ($date->format('Y-m-d') == date('Y-m-d')) {

                    if ($usedId != $data['booking_id']) {
                     
                        $getPassenger = getPassengers($data['booking_id']);
                        //return $data[$field];
                        return  $temparr = array("data" => array(
                            (int) ($i++),
                            $data['booking_id'],
                            $data['contact_person_name'].' ['. json_encode($getPassenger).']',
                            $data['attraction'],
                            $data['day_wise_program'],
                            $data['stay'],
                            $data['meal_plan']


                            // '<button class="btn btn-info btn-sm" onclick="view_desti_wise_modal(' . $data['dest_id'] . ')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


                        ), "bg" => '');
                        $usedId = $data['booking_id'];
                    }
                }
                $date = addDayInDate($date->format('Y-m-d'));
                $date = new DateTime($date);
                $first = 1;
            }
        }
    }
}


function getTodaysItenary($id,$selectedDate)
{
    $temp = array();
    $query =  "SELECT * FROM package_tour_schedule_master inner join package_tour_booking_master on package_tour_schedule_master.booking_id=package_tour_booking_master.booking_id where package_tour_schedule_master.booking_id='$id'";
    $res = mysqlQuery($query);
    $first = 0;
    $i = 1;
    $usedId = 0;
    //date('Y-m-d', strtotime($Date. ' + 1 days'));
    while ($data = mysqli_fetch_assoc($res)) {

        if (!empty($selectedDate)) {
            if ($first == 0) {
                $date = new DateTime($data['tour_from_date']);
                // $date = $date->format('Y-m-d');
            }

            if ($date >= new DateTime($data['tour_from_date'])  &&  $date <= new DateTime($data['tour_to_date'])) {
                if ($date->format('Y-m-d') == $selectedDate) {
                         
                    if ($usedId != $data['booking_id']) {
                        //return $data[$field];
                        $getPassenger = getPassengers($data['booking_id']);
                        return  $temparr = array("data" => array(
                            (int) ($i++),
                            $data['booking_id'] ,
                            $data['contact_person_name'].' ['. json_encode($getPassenger).']',
                            $data['attraction'],
                            $data['day_wise_program'],
                            $data['stay'],
                            $data['meal_plan']


                            // '<button class="btn btn-info btn-sm" onclick="view_desti_wise_modal(' . $data['dest_id'] . ')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


                        ), "bg" => '');
                        $usedId = $data['booking_id'];
                    }
                }
                $date = addDayInDate($date->format('Y-m-d'));
                $date = new DateTime($date);
                $first = 1;
            }
        } else {
            if ($first == 0) {
                $date = new DateTime($data['tour_from_date']);
                // $date = $date->format('Y-m-d');
            }

            if ($date >= new DateTime($data['tour_from_date'])  &&  $date <= new DateTime($data['tour_to_date'])) {
                if ($date->format('Y-m-d') == date('Y-m-d')) {

                    if ($usedId != $data['booking_id']) {
                        //return $data[$field];
                        $getPassenger = getPassengers($data['booking_id']);
                        return  $temparr = array("data" => array(
                            (int) ($i++),
                            $data['booking_id'] ,
                            $data['contact_person_name'] .' ['. json_encode($getPassenger).']',
                            $data['attraction'],
                            $data['day_wise_program'],
                            $data['stay'],
                            $data['meal_plan']


                            // '<button class="btn btn-info btn-sm" onclick="view_desti_wise_modal(' . $data['dest_id'] . ')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


                        ), "bg" => '');
                        $usedId = $data['booking_id'];
                    }
                }
                $date = addDayInDate($date->format('Y-m-d'));
                $date = new DateTime($date);
                $first = 1;
            }
        }
    }
}

function getPassengers($bookingId)
{
    $names = array();
    $query = "select * from package_travelers_details inner join package_tour_booking_master on package_travelers_details.booking_id=package_tour_booking_master.booking_id where package_tour_booking_master.booking_id='$bookingId'";
    $run = mysqlQuery($query);
    if(mysqli_num_rows($run)>0)
    {
        while($data = mysqli_fetch_array($run))
        {
                array_push($names,$data['first_name'].' '.$data['last_name']);
        }
    }
    if(!empty($names))
    {
        return $names[0];
    } 
}

    $query =  "SELECT * FROM package_tour_schedule_master inner join package_tour_booking_master on package_tour_schedule_master.booking_id=package_tour_booking_master.booking_id";
    $query2 =  "SELECT * FROM package_quotation_program inner join package_tour_booking_master on package_quotation_program.quotation_id=package_tour_booking_master.quotation_id";


$type = 'display';
$result = mysqlQuery($query);
$result2 = mysqlQuery($query2);
$count = 1;
$usedId = array();
$usedId2 = array();
while ($data = mysqli_fetch_assoc($result)) {
    if (!in_array((int)$data['booking_id'],$usedId)) {
        $temparr =  getTodaysItenary($data['booking_id'],$selectedDate);
        if(!empty($temparr))
        {
                      array_push($array_s, $temparr);
        }
        array_push($usedId,(int)$data['booking_id']);
    }
}

while ($data2 = mysqli_fetch_assoc($result2)) {
    if (!in_array((int)$data2['booking_id'],$usedId2)) {
        $temparr =  getTodaysItenaryByPackage($data2['booking_id'],$selectedDate);
        if(!empty($temparr))
        {
                      array_push($array_s, $temparr);
        }
        array_push($usedId2,(int)$data2['booking_id']);
    }
}



$footer_data = array(
    "footer_data" => array()
);

array_push($array_s, $footer_data);
echo json_encode($array_s);
