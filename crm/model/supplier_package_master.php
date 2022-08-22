<?php 

class supplier_package_master{

public function package_save()
{

	$city_id = $_POST['city_id'];
	$supplier_id = $_POST['supplier_id'];
	$supplier_name = $_POST['supplier_name'];
    $active_flag = $_POST['active_flag'];
	$photo_upload_url =$_FILES['upload']['name'];
	$tmp_names = $_FILES['upload']['tmp_name'];
	$valid_from = $_POST['valid_from'];
	$valid_to = $_POST['valid_to'];
	$upload_url = $_POST['upload_url'];
	
	$created_at = date('Y-m-d H:i');
	$valid_from = get_date_db($valid_from);
	$valid_to = get_date_db($valid_to);

// 	//multi upload
// 	$year = date("Y");
// 	$month = date("M");
// 	$day = date("d");
// 	$timestamp = date('U');
// 	$year_status = false;
// 	$month_status = false;
// 	$day_status = false;

// 	$current_dir = '../../uploads/';
// 	$current_dir = $this->check_dir($current_dir ,'supplier_contracts');
// 	$current_dir = $this->check_dir($current_dir , $year);
// 	$current_dir = $this->check_dir($current_dir , $month);
// 	$current_dir = $this->check_dir($current_dir , $day);
// 	$current_dir = $this->check_dir($current_dir , $timestamp);


// //$file = $current_dir.basename($_FILES['uploadfile']['name']);
// /// end multi file upload
// $locs = array();
// for($i=0;$i<sizeof($photo_upload_url);$i++){
// 	$file = basename($photo_upload_url[$i]);
// 	if (move_uploaded_file($tmp_names[$i], $current_dir.basename($photo_upload_url[$i]))) { 

// 		$locs[$i] = $file;
// 		//echo $file; 
	  
// 	  } else {
	  
// 		  echo "error";exit;
	  
// 	  }
// }
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(package_id) as max from supplier_packages"));

	$id = $sq_max['max'] + 1;

	// $loc_str = mysqlREString(implode(";",$locs));
	$supplier_name = addslashes(($supplier_name));

	$sq_service = mysqlQuery("insert into supplier_packages (package_id, city_id, supplier_type, name,active_flag,file_prefix ,image_upload_url,valid_from,valid_to,created_at) values ('$id', '$city_id', '$supplier_id','$supplier_name','$active_flag','','$upload_url','$valid_from','$valid_to',  '$created_at')");

	if($sq_service){

		echo "Supplier contract has been successfully saved.";

		exit;

	}

	else{

		echo "error--Sorry, Contract not saved!";

		exit;

	}

}


function check_dir($current_dir, $type)
{	 	
	if(!is_dir($current_dir."/".$type)){
		mkdir($current_dir."/".$type);		
	}	
	$current_dir = $current_dir."/".$type."/";
	return $current_dir;	
}

public function package_update()

{

	$package_id = $_POST['package_id'];
	$city_id = $_POST['city_id'];
	$supplier_id = $_POST['supplier_id'];
	$supplier_name = $_POST['supplier_name'];
    $active_flag = $_POST['active_flag1'];
    $valid_from = $_POST['valid_from'];
	$valid_to = $_POST['valid_to'];
	$curl = $_POST['photo_upload_url_i1'];
	$photo_upload_url = $_FILES['upload1']['name'];
	$tmp_names = $_FILES['upload1']['tmp_name'];
	$upload_url = $_POST['upload_url1'];

	//multi upload
	$year = date("Y");
	$month = date("M");
	$day = date("d");
	$timestamp = date('U');
	$year_status = false;
	$month_status = false;
	$day_status = false;

	// $current_dir = '../../uploads/';
	// $current_dir = $this->check_dir($current_dir ,'supplier_contracts');
	// $current_dir = $this->check_dir($current_dir , $year);
	// $current_dir = $this->check_dir($current_dir , $month);
	// $current_dir = $this->check_dir($current_dir , $day);
	// $current_dir = $this->check_dir($current_dir , $timestamp);

	// $locs = array();
	// for($i=0;$i<sizeof($photo_upload_url);$i++){

	// 	$file = basename($photo_upload_url[$i]);
	// 	if($file != ''){
	// 		if (move_uploaded_file($tmp_names[$i], $current_dir.basename($photo_upload_url[$i])))
	// 			$locs[$i] = $file;
	// 			$loc_str = mysqlREString(implode(";",$locs));
	// 	}
	// 	else {
	// 		$loc_str = explode("--",$curl)[0];
	// 	}
	// }
	$valid_from = get_date_db($valid_from);
	$valid_to = get_date_db($valid_to);
	$supplier_name = addslashes(($supplier_name));

	$sq_service = mysqlQuery("update supplier_packages set city_id='$city_id', supplier_type='$supplier_id', name='$supplier_name',valid_from ='$valid_from',valid_to='$valid_to',image_upload_url='$upload_url',active_flag = '$active_flag',file_prefix='' where package_id='$package_id'");
	if($sq_service){

		echo "Supplier contract has been successfully updated.";

	}
	else{
		echo "error--Sorry, Contract updated!";
		exit;
	}
}
}

?>