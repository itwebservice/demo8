<?php 
class sac_master{

public function sac_master_save()
{
	$service_name = $_POST['service_name'];
	$hsn_sac_code = $_POST['hsn_sac_code'];
	 
	$created_at = date('Y-m-d H:i');

	$sq_count = mysqli_num_rows(mysqlQuery("select service_name from sac_master where service_name='$service_name'"));
	if($sq_count>0){
		echo "error--".$service_name." already exists!";
		exit;
	} 

	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(sac_id) as max from sac_master"));
	$sac_id = $sq_max['max'] + 1;

	begin_t();

	$sq_bank = mysqlQuery("insert into sac_master (sac_id, service_name, hsn_sac_code, created_at) values ('$sac_id', '$service_name', '$hsn_sac_code','$created_at')");
	if($sq_bank){
		commit_t();
		echo "SAC has been successfully saved.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, SAC not saved!";
		exit;
	}

}

public function sac_master_update()
{
	$sac_id = $_POST['sac_id'];
	$service_name = $_POST['service_name'];
	$hsn_sac_code = $_POST['hsn_sac_code'];
	$sq_count = mysqli_num_rows(mysqlQuery("select * from sac_master where service_name='$service_name' and sac_id!='$sac_id'"));
	if($sq_count>0){
		echo "error--".$service_name." already exists!";
		exit;
	}

	begin_t();

	$sq_bank = mysqlQuery("update sac_master set service_name='$service_name', hsn_sac_code='$hsn_sac_code' where sac_id='$sac_id'");
	if($sq_bank){
		commit_t();
		echo "SAC has been successfully updated.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, SAC not updated!";
		exit;
	}

}

}
?>