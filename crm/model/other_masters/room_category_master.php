<?php 
class room_category_master{

public function category_save()
{
	$room_category = $_POST['room_category'];
	$status = $_POST['status'];

	$room_category1 = addslashes($room_category);
	$sq_count = mysqli_num_rows(mysqlQuery("select entry_id from room_category_master where room_category='$room_category1'"));
	if($sq_count>0){
		echo "error--".$room_category1." already exists!";
		exit;
	}

	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from room_category_master"));
	$entry_id = $sq_max['max'] + 1;
	$sq_insert = mysqlQuery("insert into room_category_master ( entry_id, room_category, active_status ) values ( '$entry_id', '$room_category1', '$status' )");
	if($sq_insert){
		echo "Room Category has been successfully saved.";
		exit;
	}
	else{
		echo "error--Room Category not saved!";
		exit;
	}
}

public function category_update()
{
	$entry_id = $_POST['entry_id'];
	$room_category = $_POST['room_category'];
	$active_flag = $_POST['status'];

	$room_category1 = addslashes($room_category);
	$q = "select * from room_category_master where room_category='$room_category1' and entry_id!='$entry_id'";
	$sq_count = mysqli_num_rows(mysqlQuery($q));

	if($sq_count>0){
		echo "error--".$room_category1." already exists!";
		exit;
	}

	$sq_insert = mysqlQuery("update room_category_master set room_category='$room_category1' , active_status='$active_flag'  where entry_id='$entry_id'");
	if($sq_insert){
		echo "Room Category has been successfully updated.";
		exit;
	}
	else{
		echo "error--Room Category not updated!";
		exit;
	}
}

}
?>