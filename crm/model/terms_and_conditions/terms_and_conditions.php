<?php 
class terms_and_conditions
{

public function terms_and_conditions_save()
{
	$type = $_POST['type'];
	$dest_id = $_POST['dest_id'];
	$title = $_POST['title'];
	$terms_and_conditions = $_POST['terms_and_conditions'];
	$active_flag = $_POST['active_flag'];
	$branch_admin_id=$_POST['branch_admin_id'];

	$query = "select * from terms_and_conditions where type = '$type' and active_flag='Active'";
	if($type == 'Package Quotation'){
		$query .= " and dest_id='$dest_id'";
	}
	$sq_count = mysqli_num_rows(mysqlQuery($query));
	if($sq_count>0){
		echo "error--Sorry, Terms & conditions already exits!";
		exit;
	}

	$created_at = date('Y-m-d H:i');
	$terms_and_conditions1 = addslashes($terms_and_conditions);
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(terms_and_conditions_id) as max from terms_and_conditions"));
	$terms_and_conditions_id = $sq_max['max']+1;

	$sq_entry = mysqlQuery("insert into terms_and_conditions (terms_and_conditions_id,branch_admin_id, type, title, terms_and_conditions, active_flag, created_at,dest_id) values ( '$terms_and_conditions_id','$branch_admin_id', '$type','$title', '$terms_and_conditions1', '$active_flag', '$created_at','$dest_id')");
	if($sq_entry){
		echo "Terms & Conditions has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Terms & Conditions not saved!";
		exit;
	}
}

public function terms_and_conditions_update()
{
	$terms_and_conditions_id = $_POST['terms_and_conditions_id'];
	$title = $_POST['title'];
	$type = $_POST['type'];
	$dest_id = $_POST['dest_id'];
	$terms_and_conditions = $_POST['terms_and_conditions'];
	$active_flag = $_POST['active_flag'];

	if($active_flag == "Active"){
		
		$query = "select * from terms_and_conditions where type = '$type' and active_flag='Active' and terms_and_conditions_id!='$terms_and_conditions_id'";
		if($type == 'Package Quotation'){
			$query .= " and dest_id='$dest_id'";
		}
		$sq_active_count = mysqli_num_rows(mysqlQuery($query));

		if($sq_active_count > 0){
			echo "error--Sorry, Terms and Conditions already exits!";
			exit;
		}
		else{
			$terms_and_conditions1 = addslashes($terms_and_conditions);
			$sq_entry = mysqlQuery("update terms_and_conditions set type = '$type', title='$title', 	terms_and_conditions='$terms_and_conditions1', active_flag='$active_flag',dest_id='$dest_id' where 	terms_and_conditions_id='$terms_and_conditions_id'");
			if($sq_entry){
				echo "Terms & Conditions has been successfully updated.";
				exit;
			}
			else{
				echo "error--Sorry, Terms & Conditions not updated!";
				exit;
			}
		}
	}
	if($active_flag == "Inactive"){
		$terms_and_conditions1 = addslashes($terms_and_conditions);
		$sq_entry = mysqlQuery("update terms_and_conditions set type = '$type', title='$title', 	terms_and_conditions='$terms_and_conditions1', active_flag='$active_flag',dest_id='$dest_id' where 	terms_and_conditions_id='$terms_and_conditions_id'");
		if($sq_entry){
			echo "Terms & Conditions has been successfully updated.";
			exit;
		}
		else{
			echo "error--Sorry, Terms & Conditions not updated!";
			exit;
		}
	}
}

}
?>