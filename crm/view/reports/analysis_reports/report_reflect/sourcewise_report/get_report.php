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
function get_source_enq($id,$type){
    $query1 = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
    where references_master.reference_id='".$id."'".$_SESSION['dateqry'];
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
function get_source_enq_strong($id,$type){
   $query1 = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
    INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where references_master.reference_id='".$id."' and enquiry_master_entries.followup_stage = 'Strong'  and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
 $res = mysqlQuery($query1);
 $budget = 0;
 $count = mysqli_num_rows($res);
 while($db = mysqli_fetch_assoc($res)) {
    $decodeec = json_decode($db['enquiry_content'],true);
   foreach($decodeec as $dc)
   {
        if($dc['name'] == 'budget')
        {
          $budget += (int)$dc['value'];
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
function get_source_enq_hot($id,$type){
    $query1 = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
    INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where references_master.reference_id='".$id."'and enquiry_master_entries.followup_stage = 'hot'  and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
$res = mysqlQuery($query1);
$budget = 0;
$count = mysqli_num_rows($res);
while($db = mysqli_fetch_assoc($res)) {
    $decodeec = json_decode($db['enquiry_content'],true);
   foreach($decodeec as $dc)
   {
        if($dc['name'] == 'budget')
        {
          $budget += (int)$dc['value'];
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
function get_source_enq_cold($id,$type){
    $query1 = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
        INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where references_master.reference_id='".$id."'and enquiry_master_entries.followup_stage = 'cold'  and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
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
    $query1 = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
        INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where references_master.reference_id='".$id."'and enquiry_master_entries.status != 'False'".$_SESSION['dateqry'];
    
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

$total_budget =0;
function get_enq_etr_convert($id,$type){
    $query1 = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
        INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where references_master.reference_id='".$id."'and enquiry_master_entries.status != 'False' and enquiry_master_entries.followup_status = 'Converted' ".$_SESSION['dateqry'];
    
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
if(!empty($fromdate) && !empty($todate))
{
    $query = "SELECT * FROM `references_master` INNER JOIN enquiry_master on references_master.reference_id = enquiry_master.reference_id
    INNER JOIN enquiry_master_entries ON enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where enquiry_master_entries.status != 'False'".$_SESSION['dateqry']."Group by references_master.reference_name";

    
}
else
{
$query = "select * from references_master";
 
}

$result = mysqlQuery($query);
$type = 'display';
$count = 1;

            while($db = mysqli_fetch_array($result))
            {    
        $temparr = array("data" => array
        (
            $count++,
        $db['reference_name'],
        get_source_enq($db['reference_id'],$type),
        get_source_enq_strong($db['reference_id'],$type),
        get_source_enq_hot($db['reference_id'],$type),
        get_source_enq_cold($db['reference_id'],$type),
        get_enq_etr_budget($db['reference_id'],$type),
        get_enq_etr_convert($db['reference_id'],$type), 
        '<button class="btn btn-info btn-sm" onclick="view_source_modal('. $db['reference_id'] .')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


        ),"bg" =>$bg );
        array_push($array_s, $temparr);
    }
        
   
    $footer_data = array("footer_data" => array(
        'total_footers' => 7,
        
        'foot0' => "",
        'class0' => "text-center info",

        'foot1' => "Total :",
        'class1' => "text-center info",
    
        'foot2' => get_source_enq($id,'total'),
        'class2' => "text-center success",
    
        'foot3' => get_source_enq_strong($id,'total'),
        'class3' => "text-center success",
    
        'foot4' => get_source_enq_hot($id,'total'),
        'class4' => "text-center success",
    
        'foot5' => get_source_enq_cold($id,'total'),
        'class5' => "text-center success",

        'foot6' => get_enq_etr_budget($id,'total'),
        'class6' => "text-center success",
        )
    );
    array_push($array_s, $footer_data);
    echo json_encode($array_s);

?>