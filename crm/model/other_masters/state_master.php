<?php 

$flag = true;

class state_master{



	public function state_save()
	{
		$state_name = $_POST['state_name'];
		$active_flag_arr = $_POST['active_flag_arr'];
		begin_t();

		for($i=0; $i<sizeof($state_name); $i++){
			$state_name_temp = addslashes($state_name[$i]);
			$sq_count = mysqli_num_rows(mysqlQuery("select id from state_master where state_name='$state_name_temp'"));
			if($sq_count>0){

				$GLOBALS['flag'] = false;
				echo "error--".$state_name_temp." State already exists!";
				exit;
			}

			$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from state_master"));
			$state_id = $sq_max['max'] + 1;
			$sq_state = mysqlQuery("insert into state_master (id, state_name, active_flag) values ('$state_id','$state_name[$i]', '$active_flag_arr[$i]')");

			if(!$sq_state){
				$GLOBALS['flag'] = false;
				echo "error--Some entries not saved";
				exit;
			}
		}

		if($GLOBALS['flag']){

			commit_t();

			echo "State has been successfully saved.";

			exit;

		}

		else{

			rollback_t();

			exit;

		}

	}



	public function state_update()

	{

		$state_id = $_POST['state_id'];

		$state_name = $_POST['state_name'];

		$active_flag = $_POST['active_flag'];


		$state_name_t = addslashes($state_name);
		$sq_count = mysqli_num_rows(mysqlQuery("select id from state_master where state_name='$state_name_t' and id != '$state_id'"));

		if($sq_count>0){

			$GLOBALS['flag'] = false;

			echo "error--".$state_name_t." State already exists!";
			exit;

		}
		



		$sq_airline = mysqlQuery("update state_master set state_name='$state_name', active_flag='$active_flag' where id='$state_id'");

		if($sq_airline){

			echo "State has been successfully updated.";

			exit;

		}

		else{

			echo "error--State not updated";

			exit;

		}



	}



}

?>