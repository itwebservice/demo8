<?php 
class references_master{

public function reference_save()
{
	$reference_name = $_POST['reference'];
	$status = $_POST['status'];
	$created_at = date("Y-m-d H:i:S");

	$reference_name1 = addslashes($reference_name);
	$sq_count = mysqli_num_rows(mysqlQuery("select reference_id from references_master where reference_name='$reference_name1'"));
	if($sq_count>0){
		echo "error--".$reference_name1." already exists!";
		exit;
	}

	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(reference_id) as max from references_master"));
	$reference_id = $sq_max['max'] + 1;

	$sq_insert = mysqlQuery("insert into references_master ( reference_id, reference_name, created_at, active_flag ) values ( '$reference_id', '$reference_name1', '$created_at', '$status' )");
	if($sq_insert){
		echo "References has been successfully saved.";
		exit;
	}
	else{
		echo "error--Reference not saved!";
		exit;
	}
}

public function reference_update()
{
	$reference_id = $_POST['reference_id'];
	$reference_name = $_POST['reference'];
	$active_flag = $_POST['status'];

	$reference_name1 = addslashes($reference_name);
	
	$sq_count = mysqli_num_rows(mysqlQuery("select reference_id from references_master where reference_name='$reference_name1' and reference_id!='$reference_id'"));
	if($sq_count>0){
		echo "error--".$reference_name1." already exists!";
		exit;
	}

	$sq_insert = mysqlQuery("update references_master set reference_name='$reference_name1' , active_flag='$active_flag'  where reference_id='$reference_id'");
	if($sq_insert){
		echo "References has been successfully updated.";
		exit;
	}
	else{
		echo "error--Reference not updated!";
		exit;
	}
}

}
?>