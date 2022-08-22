<?php include "../../model/model.php";
global $encrypt_decrypt,$secret_key;
$username=mysqlREString($_POST['username']);
$password=mysqlREString($_POST['password']);

$username = $encrypt_decrypt->fnEncrypt($username, $secret_key);
$password = $encrypt_decrypt->fnEncrypt($password, $secret_key);
$financial_year_id=$_POST['financial_year_id'];

$row_count = mysqli_num_rows(mysqlQuery("select * from roles where user_name='$username' and password='$password' and active_flag!='Inactive'"));
if($row_count>0){
	$_SESSION['itours_app'] = $app_name;
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;	
	$_SESSION['financial_year_id'] = $financial_year_id;
	$_SESSION['app_version'] = $app_version;

	$sq = mysqlQuery("select * from roles where user_name='$username' and password='$password' ");
	if($row= mysqli_fetch_assoc($sq)){
		$sq_role = mysqli_fetch_assoc(mysqlQuery("select * from role_master where role_id='$row[role_id]'"));

		$_SESSION['emp_id'] = $row['emp_id'];
		$_SESSION['role_id'] = $row['role_id'];
		$_SESSION['role'] = $sq_role['role_name'];
		$_SESSION['login_id'] = $row['id'];	
		$_SESSION['branch_admin_id'] = $row['branch_admin_id'];

		if($sq_role['role_name'] == "Booker"){        
	    	$_SESSION['booker_id']=$row['emp_id']; 
	    }

	    $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(log_id) as max from user_logs"));
	    $log_id = $sq_max['max'] + 1;
	    $login_id = $row['id'];
	    $login_date = date('Y-m-d');
	    $login_time = date('H:i');
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$sq_query = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id='1' "));
		if($sq_query['ip_addresses']!=''){
			$ip_addresses = $sq_query['ip_addresses'];
			$ip_address_arr = explode(',',$ip_addresses);
			if(in_array($user_ip, $ip_address_arr)){

				$sq_log = mysqlQuery("insert into user_logs ( log_id, login_id, login_date, login_time, status, user_ip ) values ( '$log_id', '$login_id', '$login_date', '$login_time', 'Present', '$user_ip' )");
				if(!$sq_log){
					echo "Sorry log entry is not done!";
					exit;
				}
			}
			else{
				echo 'Unable to Login!
				Check your IP address mentioned in Administration > Company Profile > Credentials > IP Address';
				exit;
			}
		}
		else{
			$sq_log = mysqlQuery("insert into user_logs ( log_id, login_id, login_date, login_time, status, user_ip ) values ( '$log_id', '$login_id', '$login_date', '$login_time', 'Present', '$user_ip' )");
			if(!$sq_log){
				echo "Sorry log entry is not done!";
				exit;
			}
		}
	}

	echo "valid";
}	
else
{
	echo "Your Username and/or password do not match!";
}
?>