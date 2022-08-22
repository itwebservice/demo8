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
function get_branch_enq($id,$type){
    $query1 = "SELECT * FROM `branches` INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id 
    where branches.branch_id='".$id."'".$_SESSION['dateqry'];
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
function get_branch_enq_strong($id,$type){
   
    $query1 = "SELECT * FROM `branches` INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id 
   INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where branches.branch_id='".$id."' and enquiry_master_entries.followup_stage = 'Strong'
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
function get_branch_enq_hot($id,$type){
    $query1 = "SELECT * FROM `branches` INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id 
    INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where branches.branch_id='".$id."' and enquiry_master_entries.followup_stage = 'hot'
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
function get_branch_enq_cold($id,$type){
    $query1 = "SELECT * FROM `branches` INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id 
     INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where branches.branch_id='".$id."' and enquiry_master_entries.followup_stage = 'cold'
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
$total_budget =0;
function get_enq_etr_budget($id,$type){
    $query1 = "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where branches.branch_id='".$id."' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
   global $total_budget;

   if($type == 'display')
   {                                        
       $total_budget += $budget;     
       return ' ('.$budget .')';
   }
   elseif($type == 'total')
   {
       return '('. $total_budget.')';
   }
}
$total_active =0;
function get_enq_etr_active($id,$type){
    $query1 = "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where branches.branch_id='".$id."' and enquiry_master_entries.followup_status = 'Active'".$_SESSION['dateqry'];
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
 function get_enq_etr_infollow($id,$type){
    $query1 = "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where branches.branch_id='".$id."' and enquiry_master_entries.followup_status = 'In-Followup' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
function get_enq_etr_dropped($id,$type){
    $query1 = "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where branches.branch_id='".$id."' and enquiry_master_entries.followup_status = 'Dropped' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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

function getColor($id)
{
    $query1 = "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where branches.branch_id='".$id."' and enquiry_master_entries.status != 'False' ".$_SESSION['dateqry'];
    $run = mysqlQuery($query1);
    if(mysqli_num_rows($run))
    { 
        $e = mysqli_fetch_array($run)['followup_status'];
        if($e == 'converted')
        {
            return 'success';
        }
        elseif($e == 'Dropped')
        {
            return 'danger';
        }
        else
        {
            return '';
        }
        //and enquiry_master_entries.followup_status = 'Converted'
        
    }
}
function get_enq_etr_converted($id,$type){
    $query1 = "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where branches.branch_id='".$id."' and enquiry_master_entries.followup_status = 'Converted' and enquiry_master_entries.status != 'False' ".$_SESSION['dateqry'];
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
if(empty($fromdate) && empty($todate))
{
    $query=  "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id GROUP BY enquiry_master.branch_admin_id";

}
else
{
    $query=  "SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where enquiry_master.enquiry_date between '".$fromdate."' and '".$todate."' GROUP BY enquiry_master.branch_admin_id";

}

$type = 'display';
$result = mysqlQuery($query);
$count = 1;
    while($data = mysqli_fetch_assoc($result))
    {
        $temparr = array("data" => array
        (
                 (int) ($count++),
                $data['branch_name'],
                get_branch_enq($data['branch_id'],$type),
                get_enq_etr_active($data['branch_id'],$type),
                get_enq_etr_infollow($data['branch_id'],$type),
                get_enq_etr_dropped($data['branch_id'],$type),
                get_enq_etr_converted($data['branch_id'],$type),
                get_enq_etr_budget($data['branch_id'],$type),
                get_branch_enq_strong($data['branch_id'],$type),
                get_branch_enq_hot($data['branch_id'],$type),
                get_branch_enq_cold($data['branch_id'],$type),
			    '<button class="btn btn-info btn-sm" onclick="view_branch_modal('. $data['branch_id'] .')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>getColor($data['branch_id']));
        array_push($array_s, $temparr);
    }



$footer_data = array("footer_data" => array(
	'total_footers' => 11,
			
	'foot0' => "Total :",
	'class0' => "text-left info",
	
    'foot1' => "",
	'class1' => "text-left info",

	'foot2' => get_branch_enq($id,'total'),
	'class2' => "text-left success",

    'foot3' => get_enq_etr_active($id,'total'),
	'class3' => "text-left success",

    'foot4' => get_enq_etr_infollow($id,'total'),
	'class4' => "text-left success",

    'foot5' => get_enq_etr_dropped($id,'total'),
	'class5' => "text-left success",

	'foot6' => get_enq_etr_converted($id,'total'),
	'class6' => "text-left success",

    'foot7' => get_enq_etr_budget($id,'total'),
	'class7' => "text-left success",

    'foot8' => get_branch_enq_strong($id,'total'),
	'class8' => "text-left success",

    'foot9' => get_branch_enq_hot($id,'total'),
	'class9' => "text-left success",

    'foot10' => get_branch_enq_cold($id,'total'),
	'class10' => "text-left success",
	)
);

array_push($array_s, $footer_data);
echo json_encode($array_s);
