<?php
include "../../../../../model/model.php"; 
$fromdate = !empty($_POST['fromdate']) ? get_date_db($_POST['fromdate']) :null;
$todate = !empty($_POST['todate']) ? get_date_db($_POST['todate']) :null;
$array_s = array();

if(empty($fromdate) && empty($todate))
{
    $_SESSION['dateqry'] = "";
}
else
{
    $_SESSION['dateqry'] = "and enquiry_master.enquiry_date between '".$fromdate."' and '".$todate."'";

}
$total_enq_count=0;
function get_service_enq($enq,$type){
    $query1 = "SELECT * FROM `enquiry_master` where enquiry_master.enquiry_type='".$enq."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
        $decode = json_decode($db['enquiry_content']);
        }
        global $total_enq_count;
        if($type == 'display')
        {
        $total_enq_count += $count;    
    
        return $count ;
        }
        elseif($type == 'total')
        {
        return $total_enq_count ;
        } 
   
}
$total_strong =0;
function get_service_enq_strong($enq,$type){
    $query1 = "SELECT * FROM `enquiry_master` INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_stage = 'Strong'
   and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
     }
   global $total_strong;
   global $total_strong_count;
   if($type == 'display')
   {
       $total_strong += $budget;    
       $total_strong_count += $count;    
       return $count .' ('.$budget .')';
   }
   elseif($type == 'total')
   {
    return $total_strong_count .'('. $total_strong.')';
   }

}
$total_hot =0;
function get_service_enq_hot($enq,$type){
    $query1 = "SELECT * FROM `enquiry_master` INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_stage = 'Hot'
    and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
     }
   global $total_hot;
   global $total_hot_count;
   if($type == 'display')
   {
       $total_hot += $budget;   
       $total_hot_count += $count;    

       return $count .' ('.$budget .')';
   }
   elseif($type == 'total')
   {
    return $total_hot_count .'('. $total_hot.')';

   }
}
$total_cold =0;
function get_service_enq_cold($enq,$type){
    $query1 = "SELECT * FROM `enquiry_master` INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_stage = 'cold'
     and enquiry_master_entries.status != 'False' ".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
     }
   global $total_cold;
   global $total_cold_count;
   if($type == 'display')
   {
       $total_cold += $budget;    
       $total_cold_count += $count;    

       return $count .' ('.$budget .')';
   }
   elseif($type == 'total')
   {
       return  $total_cold_count.'('. $total_cold.')';
   }
}
$total_active =0;
function get_enq_etr_active($enq,$type){
    $query1 = "SELECT * FROM `enquiry_master` Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_status = 'Active'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
     }
   global $total_active;
   global $total_active_count;
   if($type == 'display')
   {
       $total_active += $budget;  
       $total_active_count += $count;    

       return $count .' ('.$budget .')';
   }
   elseif($type == 'total')
   {
       return $total_active_count.'('. $total_active.')';
   }
}
$total_infollow =0;
 function get_enq_etr_infollow($enq,$type){
    $query1 = "SELECT * FROM enquiry_master Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_status = 'In-Followup' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
     }
   global $total_infollow;
   global $total_infollow_count;
    if($type == 'display')
    {
        $total_infollow += $budget;  
       $total_infollow_count += $count;    

        return $count .' ('.$budget .')';
    }
    elseif($type == 'total')
    {
        return $total_infollow_count.'('. $total_infollow.')';

    }
}
$total_dropped =0;
function get_enq_etr_dropped($enq,$type){
    $query1 = "SELECT * FROM enquiry_master Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_status = 'Dropped' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
     }
   global $total_dropped;
   global $total_dropped_count;
   if($type == 'display')
   {
       $total_dropped += $budget;  
       $total_dropped_count += $count;    

       return $count .' ('.$budget .')';
   }
   elseif($type == 'total')
   {
    return $total_dropped_count.'('. $total_dropped.')';

   }
    
}
$total_converted =0;
function get_enq_etr_converted($enq,$type){
    $query1 = "SELECT * FROM enquiry_master Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.enquiry_type='".$enq."' and enquiry_master_entries.followup_status = 'Converted' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $budget = 0;
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res)) {
       if($db['enquiry_type'] == 'Flight Ticket')
        {
        $tourdetail  = json_decode($db['enquiry_content'],true);
            foreach($tourdetail as $detail)
            {
                $budget += (int)$detail['budget'];
            }
        }
        else{
        $tourdetail  = json_decode($db['enquiry_content'],true);
        foreach($tourdetail as $dc)
             {
              if($dc['name'] == 'budget')
              {
                  $budget += (int)$dc['value'];
              }  
              if($dc['name'] == 'tour_name')
              {
                
                $tourname = $dc['value'];
              }
              
            }
        }
    }
   global $total_converted;
   global $total_converted_count;

   if($type == 'display')
   {
       $total_converted += $budget;   
       $total_converted_count += $count;    

       return $count .' ('.$budget .')';
   }
   elseif($type == 'total')
   {
       return $total_converted_count .'('. $total_converted.')';
   }
}


$query=  "SELECT * FROM enquiry_master  Inner JOIN enquiry_master_entries on enquiry_master.enquiry_type = enquiry_master_entries.enquiry_id where enquiry_master.enquiry_date between '".$fromdate."' and '".$todate."' GROUP BY enquiry_master.enquiry_type";
$type = 'display';
$result = mysqlQuery($query);
$count = 1;
$grptype = 'Group Booking';
        $temparr = array("data" => array
        (  
               'Group Booking',
                get_service_enq('Group Booking',$type),
                get_enq_etr_active('Group Booking',$type),
                get_enq_etr_infollow('Group Booking',$type),
                get_enq_etr_dropped('Group Booking',$type),
                get_enq_etr_converted('Group Booking',$type),
                get_service_enq_strong('Group Booking',$type),
                get_service_enq_hot('Group Booking',$type),
                get_service_enq_cold('Group Booking',$type),
                
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Group Booking`)" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);
  
        $temparr = array("data" => array
        (
                 
               'Package Booking',
                get_service_enq('Package Booking',$type),
                get_enq_etr_active('Package Booking',$type),
                get_enq_etr_infollow('Package Booking',$type),
                get_enq_etr_dropped('Package Booking',$type),
                get_enq_etr_converted('Package Booking',$type),
                get_service_enq_strong('Package Booking',$type),
                get_service_enq_hot('Package Booking',$type),
                get_service_enq_cold('Package Booking',$type),
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Package Booking`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);

        $temparr = array("data" => array
        (
                 
               'Flight Ticket',
                get_service_enq('Flight Ticket',$type),
                get_enq_etr_active('Flight Ticket',$type),
                get_enq_etr_infollow('Flight Ticket',$type),
                get_enq_etr_dropped('Flight Ticket',$type),
                get_enq_etr_converted('Flight Ticket',$type),
                get_service_enq_strong('Flight Ticket',$type),
                get_service_enq_hot('Flight Ticket',$type),
                get_service_enq_cold('Flight Ticket',$type),                
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Flight Ticket`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);
  
        $temparr = array("data" => array
        (
                 
               'Hotel',
                get_service_enq('Hotel',$type),
                get_enq_etr_active('Hotel',$type),
                get_enq_etr_infollow('Hotel',$type),
                get_enq_etr_dropped('Hotel',$type),
                get_enq_etr_converted('Hotel',$type),
                get_service_enq_strong('Hotel',$type),
                get_service_enq_hot('Hotel',$type),
                get_service_enq_cold('Hotel',$type),               
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Hotel`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);


        $temparr = array("data" => array
        (
                 
               'Car Rental',
                get_service_enq('Car Rental',$type),
                get_enq_etr_active('Car Rental',$type),
                get_enq_etr_infollow('Car Rental',$type),
                get_enq_etr_dropped('Car Rental',$type),
                get_enq_etr_converted('Car Rental',$type),
                get_service_enq_strong('Car Rental',$type),
                get_service_enq_hot('Car Rental',$type),
                get_service_enq_cold('Car Rental',$type),    
                
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Car Rental`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);
        $temparr = array("data" => array
        (
                 
               'Train Ticket',
                get_service_enq('Train Ticket',$type),
                get_enq_etr_active('Train Ticket',$type),
                get_enq_etr_infollow('Train Ticket',$type),
                get_enq_etr_dropped('Train Ticket',$type),
                get_enq_etr_converted('Train Ticket',$type),
                 get_service_enq_strong('Train Ticket',$type),
                get_service_enq_hot('Train Ticket',$type),
                get_service_enq_cold('Train Ticket',$type),
              
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Train Ticket`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);

        $temparr = array("data" => array
        (
                 
               'Bus',
                get_service_enq('Bus',$type),
                get_enq_etr_active('Bus',$type),
                get_enq_etr_infollow('Bus',$type),
                get_enq_etr_dropped('Bus',$type),
                get_enq_etr_converted('Bus',$type),
                get_service_enq_strong('Bus',$type),
                get_service_enq_hot('Bus',$type),
                get_service_enq_cold('Bus',$type),
                
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Bus`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);

        $temparr = array("data" => array
        (
                 
               'Visa',
                get_service_enq('Visa',$type),
                get_enq_etr_active('Visa',$type),
                get_enq_etr_infollow('Visa',$type),
                get_enq_etr_dropped('Visa',$type),
                get_enq_etr_converted('Visa',$type),
                get_service_enq_strong('Visa',$type),
                get_service_enq_hot('Visa',$type),
                get_service_enq_cold('Visa',$type),
                
			    '<button class="btn btn-info btn-sm" onclick="view_service_modal(`Visa`)" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);

    

       

    


$footer_data = array("footer_data" => array(
	'total_footers' => 9,
	
    'foot0' => "Total :",
	'class0' => "text-left info",

	'foot1' => " ".get_service_enq($enq,'total'),
	'class1' => "text-left success",

    'foot2' => " ".get_service_enq_strong($enq,'total'),
	'class2' => "text-left success",

    'foot3' => "".get_service_enq_hot($enq,'total'),
	'class3' => "text-left success",

    'foot4' => "".get_service_enq_cold($enq,'total'),
	'class4' => "text-left success",

    'foot5' => "".get_enq_etr_active($enq,'total'),
	'class5' => "text-left success",

    'foot6' => " ".get_enq_etr_infollow($enq,'total'),
	'class6' => "text-left success",

    'foot7' => " ".get_enq_etr_dropped($enq,'total'),
	'class7' => "text-left success",

	'foot8' => "".get_enq_etr_converted($enq,'total'),
	'class8' => "text-left success",
	)
);

array_push($array_s, $footer_data);
echo json_encode($array_s);

?>
