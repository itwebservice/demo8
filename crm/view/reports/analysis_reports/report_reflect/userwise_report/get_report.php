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
function get_user_enq($id,$type){
    $query1 = "SELECT * FROM `roles` INNER JOIN enquiry_master on roles.id = enquiry_master.login_id 
    where enquiry_master.assigned_emp_id ='".$id."'".$_SESSION['dateqry'];
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
function get_user_enq_strong($id,$type){
    $query1 = "SELECT * FROM `roles` INNER JOIN enquiry_master on roles.id = enquiry_master.login_id 
        INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_stage = 'Strong'  and enquiry_master_entries.status!= 'False'".$_SESSION['dateqry'];
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
function get_user_enq_hot($id,$type){
    $query1 = "SELECT * FROM `roles` INNER JOIN enquiry_master on roles.id = enquiry_master.login_id 
        INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_stage = 'hot'
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
function get_user_enq_cold($id,$type){
    $query1 = "SELECT * FROM `roles` INNER JOIN enquiry_master on roles.id = enquiry_master.login_id 
    INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_stage = 'cold'
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
    $query1 = "SELECT * FROM roles INNER JOIN enquiry_master on roles.id = enquiry_master.login_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    
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
    $query1 = "SELECT * FROM roles INNER JOIN enquiry_master on roles.id = enquiry_master.login_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_status = 'Active' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
    $query1 = "SELECT * FROM roles INNER JOIN enquiry_master on roles.id = enquiry_master.login_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_status = 'In-Followup' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
    $query1 = "SELECT * FROM roles INNER JOIN enquiry_master on roles.id = enquiry_master.login_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_status = 'Dropped' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
function get_enq_etr_converted($id,$type){
    $query1 = "SELECT * FROM roles INNER JOIN enquiry_master on roles.id = enquiry_master.login_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_status = 'Converted' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
    $query = "SELECT * from roles INNER JOIN emp_master on roles.emp_id = emp_master.emp_id INNER JOIN enquiry_master on roles.id = enquiry_master.assigned_emp_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id  GROUP BY  emp_master.emp_id";

}
else
{
    $query= "SELECT * from roles INNER JOIN emp_master on roles.emp_id = emp_master.emp_id INNER JOIN enquiry_master on roles.id = enquiry_master.assigned_emp_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where enquiry_master.enquiry_date between '".$fromdate."' and '".$todate."' GROUP BY emp_master.emp_id";

}
$result = mysqlQuery($query);
$type = 'display';
$count = 1;
    while($data = mysqli_fetch_assoc($result))
    {
        $temparr = array("data" => array
        (
                 (int) ($count++),
                $data['first_name'],
                 get_user_enq($data['assigned_emp_id'],$type),
                 get_enq_etr_active($data['assigned_emp_id'],$type),
                 get_enq_etr_infollow($data['assigned_emp_id'],$type),
                 get_enq_etr_dropped($data['assigned_emp_id'],$type),
                 get_enq_etr_converted($data['assigned_emp_id'],$type),
                 get_enq_etr_budget($data['assigned_emp_id'],$type),
                get_user_enq_strong($data['assigned_emp_id'],$type),
                get_user_enq_hot($data['assigned_emp_id'],$type),
                get_user_enq_cold($data['assigned_emp_id'],$type),
                '<button class="btn btn-info btn-sm" onclick="view_user_modal('. $data['assigned_emp_id'] .')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);
    }

    $footer_data = array("footer_data" => array(
        'total_footers' => 11,
                
        'foot0' => " ",
        'class0' => "text-left info",
        
        'foot1' => "Total :",
        'class1' => "text-left info",
    
        'foot2' => " ".get_user_enq($id,'total'),
        'class2' => "text-left success",
    
        'foot3' => " ".get_enq_etr_active($id,'total'),
        'class3' => "text-left success",
    
        'foot4' => " ".get_enq_etr_infollow($id,'total'),
        'class4' => "text-left success",
    
        'foot5' => " ".get_enq_etr_dropped($id,'total'),
        'class5' => "text-left success",
    
        'foot6' => "".get_enq_etr_converted($id,'total'),
        'class6' => "text-left success",

        'foot7' => "".get_enq_etr_budget($id,'total'),
        'class7' => "text-left success",
    
        'foot8' => "".get_user_enq_strong($id,'total'),
        'class8' => "text-left success",
    
        'foot9' => "".get_user_enq_hot($id,'total'),
        'class9' => "text-left success",
    
        'foot10' => "".get_user_enq_cold($id,'total'),
        'class10' => "text-left success",
        )
    );
  
    array_push($array_s, $footer_data);
    echo json_encode($array_s);

?>