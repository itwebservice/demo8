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
function get_emp_enq($id,$type){
    $query1 = "SELECT * FROM enquiry_master Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id left JOIN emp_master on enquiry_master.enquiry_id=emp_master.emp_id 
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.status != 'False' ".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);   
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_assoc($res))
    {
       $decode = json_decode($db['enquiry_content']);
    }
    global $total_enq_count;
    if($type == 'display')
    {
    $total_enq_count += $count;
         return  $count;
    }
    elseif($type == 'total')
    {
      return $total_enq_count;
    } 
}    

$total_converted =0;
function get_enq_etr_converted($id,$type){
    $query1 = " SELECT * FROM enquiry_master Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id left JOIN emp_master on enquiry_master.enquiry_id=emp_master.emp_id 
    where enquiry_master.assigned_emp_id='".$id."' and enquiry_master_entries.followup_status = 'Converted' and enquiry_master_entries.status != 'False' ".$_SESSION['dateqry'];
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
    $query=  "SELECT * FROM enquiry_master  Inner JOIN emp_master  on enquiry_master.enquiry_id=emp_master.emp_id   Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id";

}
else
{
    $query=  "SELECT * FROM enquiry_master  Inner JOIN emp_master  on enquiry_master.enquiry_id=emp_master.emp_id  Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id where enquiry_master.enquiry_date between '".$fromdate."' and '".$todate."'";

}

$type = 'display';
$result = mysqlQuery($query);
$count = 1;
    while($data = mysqli_fetch_assoc($result))
    {
        $temparr = array("data" => array
        (
            
                $data['first_name'] .' '.$data['last_name'],
                get_emp_enq($data['assigned_emp_id'],$type),
                get_enq_etr_converted($data['assigned_emp_id'],$type),
               
			    '<button class="btn btn-info btn-sm" onclick="view_usersale_modal('. $data['emp_id'] .')" data-toggle="tooltip" title="Preview"><i class="fa fa-eye"></i></button>'
                
        
        ),"bg" =>$bg );
        array_push($array_s, $temparr);
    }



$footer_data = array("footer_data" => array(
	'total_footers' => 5,

	
    'foot0' => "Total :",
	'class0' => "text-left info",

	'foot1' => " ".get_emp_enq($id,'total'),
	'class1' => "text-left success",

    'foot2' => " ".get_enq_etr_converted($id,'total'),
	'class2' => "text-left success",


	)
);

array_push($array_s, $footer_data);
echo json_encode($array_s);
