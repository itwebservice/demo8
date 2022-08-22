<?php
class entities_master{

public function entity_save()
{
	$entity_name_arr = $_POST['entity_name_arr'];
	$entity_for = $_POST['entity_for'];
	$dest_name = $_POST['dest_name'];

	if($entity_for == 'Group Tour' || $entity_for=='Package Tour'){
		$sq_count = mysqli_num_rows(mysqlQuery("select * from checklist_entities where entity_for = '$entity_for' and destination_name='$dest_name'"));
		$msg = "error--Checklist already exists for this destination!";
	}else{
		$sq_count = mysqli_num_rows(mysqlQuery("select * from checklist_entities where entity_for = '$entity_for' "));
		$msg = "error--Checklist already exists for ".$entity_for."!";
	}


	if($sq_count>0){
		rollback_t();
		echo $msg;
		exit;
	}else{
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entity_id) as max from checklist_entities"));
		$entity_id = $sq_max['max'] + 1;
	
		$sq_entity= mysqlQuery("insert into checklist_entities ( entity_id,entity_for,destination_name ) values ( '$entity_id', '$entity_for','$dest_name')");
	
		if($sq_entity)
		{
			$entity_name_arr = ($entity_name_arr == '') ? [] : $entity_name_arr;
			//to do entries
			for($i=0; $i<sizeof($entity_name_arr); $i++){
				$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from to_do_entries"));
	
					$id = $sq_max['max'] + 1;
					$entity_name_arr[$i] = addslashes($entity_name_arr[$i]);
					$sq="INSERT INTO to_do_entries (id, entity_id, entity_name) VALUES ('$id','$entity_id','$entity_name_arr[$i]')";
					$sq_entry = mysqlQuery($sq);
			}
			if($sq_entry){
				echo "Checklist has been successfully Saved.";
				exit;
			}
		}
		else{
			echo "error--Checklist not saved successfully!";
			exit;
		}
	
	}

}

///////////////////// Update Start //////////////////////////////
public function entity_update()
{
	$entity_id=$_POST['entity_id'];
	$entity_name_arr = $_POST['entity_name_arr'];
	$entry_id_arr = $_POST['entry_id_arr'];
	$checked_arr = $_POST['checked_arr'];


	for($i=0; $i<sizeof($entity_name_arr); $i++)
	{
		if($checked_arr[$i]=='true'){
			
			$entity_name_arr[$i] = addslashes($entity_name_arr[$i]);
			if($entry_id_arr[$i] != ''){
				$sq_entity = mysqlQuery("update to_do_entries set entity_name = '$entity_name_arr[$i]' where id = '$entry_id_arr[$i]'");	
			}
			else
			{
				$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from to_do_entries"));
				$id = $sq_max['max'] + 1;
				$sq_entity = mysqlQuery("INSERT INTO to_do_entries (id, entity_id, entity_name) VALUES ('$id','$entity_id','$entity_name_arr[$i]')");
			}	
		}else{
			$sql_delete = mysqlQuery("DELETE FROM `to_do_entries` WHERE id='$entry_id_arr[$i]'");
		}
	}
	if(!$sq_entity){		
		echo "error--Checklist not Updated!";
	}					
	else{
		echo "Checklist has been successfully updated.";
	}
}
/////////////////////////Update End////////////////////////////////////////////
}
?>