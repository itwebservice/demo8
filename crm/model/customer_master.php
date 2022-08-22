<?php
class customer_master{

public function customer_master_save()
{
	$first_name = mysqlREString($_POST['first_name']);
	$middle_name = mysqlREString($_POST['middle_name']);
	$last_name = mysqlREString($_POST['last_name']);
	$gender = mysqlREString($_POST['gender']);
	$birth_date = $_POST['birth_date'];
  $age = mysqlREString($_POST['age']);
  $country_code = mysqlREString($_POST['country_code']);
	$contact_no = mysqlREString($_POST['contact_no']);
	$email_id = mysqlREString($_POST['email_id']);
	$address = mysqlREString($_POST['address']);
  $address2 = mysqlREString($_POST['address2']);
  $city = mysqlREString($_POST['city']);
	$gl_id = $_POST['gl_id'];
	$active_flag = $_POST['active_flag'];
	$service_tax_no = strtoupper($_POST['service_tax_no']);
	$landline_no = mysqlREString($_POST['landline_no']);
	$alt_email_id = mysqlREString($_POST['alt_email_id']);
	$company_name = mysqlREString($_POST['company_name']);
	$cust_type = mysqlREString($_POST['cust_type']);
  $state = mysqlREString($_POST['state']);
  $cust_pan = mysqlREString($_POST['cust_pan']);
  $branch_admin_id=mysqlREString($_POST['branch_admin_id']);
  $cust_source = mysqlREString($_POST['cust_source']);

  $contact_no = $country_code.$contact_no;

	$username = $contact_no;
  $password = $email_id;
  
  global $encrypt_decrypt, $secret_key;
  $contact_no = $encrypt_decrypt->fnEncrypt($contact_no, $secret_key);
  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

	$birth_date = get_date_db($birth_date);
  $created_at = date("Y-m-d");
  
  if($company_name != ''){
    $company_count = mysqli_num_rows(mysqlQuery("select * from customer_master where company_name='$company_name' and type not in('Corporate','B2B')"));
  }
  if($company_count>0){
    echo "error--Sorry, The Company has already been taken.";
    exit;
  }
  $cust_count = mysqli_num_rows(mysqlQuery("select * from customer_master where contact_no='$contact_no'"));
  if($cust_count>0)
  {
    echo "error--Sorry, The Customer already exist.";
    exit;
  }
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(customer_id) as max from customer_master"));
	$customer_id = $sq_max['max'] + 1;

  $sq_visa = mysqlQuery("insert into customer_master (customer_id,type,first_name, middle_name, last_name, gender, birth_date, age, country_code,contact_no,landline_no, email_id,alt_email,company_name, address, address2, city, active_flag, created_at,service_tax_no,state_id,pan_no, branch_admin_id,source) values ('$customer_id','$cust_type', '$first_name', '$middle_name', '$last_name', '$gender', '$birth_date', '$age', '$country_code','$contact_no','$landline_no', '$email_id','$alt_email_id','$company_name', '$address','$address2','$city', '$active_flag', '$created_at', '$service_tax_no','$state','$cust_pan','$branch_admin_id','$cust_source')");

  $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(ledger_id) as max from ledger_master"));
  $ledger_id = $sq_max['max'] + 1;
  if($cust_type == 'Corporate' || $cust_type == 'B2B'){
    $ledger_name = $company_name;
  }
  else{
    $ledger_name = $customer_id.'_'.$first_name.' '.$last_name;
  }

  $sq_ledger = mysqlQuery("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type,status) values ('$ledger_id', '$ledger_name', '', '20', '0','Dr','$customer_id','customer','Active')");

	if(!$sq_visa){
		echo "error--Sorry Customer information not saved successfully!";
		exit;
	}
	else{
		$this->employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id);
		echo "Customer has been successfully saved.==".$customer_id;
		exit;
	}
}

public function customer_master_update(){

	$customer_id = mysqlREString($_POST['customer_id']);
	$first_name = mysqlREString($_POST['first_name']);
	$middle_name = mysqlREString($_POST['middle_name']);
	$last_name = mysqlREString($_POST['last_name']);
	$gender = mysqlREString($_POST['gender']);
	$birth_date = $_POST['birth_date'];
  $age = mysqlREString($_POST['age']);
  $country_code = $_POST['country_code'];
	$contact_no = mysqlREString($_POST['contact_no']);
	$email_id = $_POST['email_id'];
	$address = mysqlREString($_POST['address']);
  $address2 = mysqlREString($_POST['address2']);
  $city = mysqlREString($_POST['city']);
	$active_flag = $_POST['active_flag'];
	$service_tax_no1 = strtoupper($_POST['service_tax_no1']);
	$landline_no = mysqlREString($_POST['landline_no']);
	$alt_email_id = $_POST['alt_email_id'];
	$company_name = mysqlREString($_POST['company_name']);
	$cust_type = $_POST['cust_type'];
  $state = mysqlREString($_POST['cust_state']);
  $cust_pan = $_POST['cust_pan'];
  $cust_source = $_POST['cust_source'];

  $contact_no = $country_code.$contact_no;
  global $encrypt_decrypt, $secret_key;
  $contact_no = $encrypt_decrypt->fnEncrypt($contact_no, $secret_key);
  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);

	$birth_date = date('Y-m-d', strtotime($birth_date));
  $created_at = date("Y-m-d");
  
  if($company_name != ''){
    $company_count = mysqli_num_rows(mysqlQuery("select * from customer_master where company_name='$company_name' and customer_id!='$customer_id'")); 
  }
  if($company_count>0){
    echo "error--Sorry, The Company has already been taken.";
    exit;
  }
  
	$sq_visa = mysqlQuery("update customer_master set type = '$cust_type',first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', birth_date='$birth_date', age='$age', country_code = '$country_code', contact_no='$contact_no',landline_no = '$landline_no', email_id='$email_id',alt_email = '$alt_email_id',company_name = '$company_name', address='$address', address2='$address2', city='$city', active_flag='$active_flag', service_tax_no='$service_tax_no1', state_id='$state', pan_no ='$cust_pan',source='$cust_source' where customer_id='$customer_id'");

	//update customer leder
	if($cust_type == 'Corporate' || $cust_type == 'B2B'){
	  $ledger_name = $company_name;
	}
	else{
	  $ledger_name = $customer_id.'_'.$first_name.'_'.$last_name;
	}
	$sq_visa = mysqlQuery("update ledger_master set ledger_name='$ledger_name' where user_type='customer' and customer_id='$customer_id'");

	if(!$sq_visa){
		echo "error--Sorry Customer information not update!";
		exit;
	}
	else{
		echo "Customer has been successfully updated.";
		exit;

	}
}

public function customer_master_csv_save()
{
  global $encrypt_decrypt, $secret_key;
  $cust_csv_dir = $_POST['cust_csv_dir'];
  $branch_admin_id=$_POST['branch_admin_id'];
  $flag = true;

  $cust_csv_dir = explode('uploads', $cust_csv_dir);
  $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];

  begin_t();

  $count = 1;
  $validCount=0;
  $invalidCount=0;
  $unprocessedArray=array();
  $arrResult  = array();
  $handle = fopen($cust_csv_dir, "r");
  if(empty($handle) === false) {

      while(($data = fgetcsv($handle, 8000,",")) !== FALSE){

          if($count == 1) { $count++; continue; }
          if($count>0){
              
              $cust_type = $data[0];
              $first_name = $data[1];
              $middle_name = $data[2];
              $last_name = $data[3];
              $gender = $data[4];
              $birth_date = $data[5];
              $age = $data[6];
              $country_code = $data[7];
              $country_code = str_replace("`","",$country_code);
              $contact_no = $data[8];
              $email_id = $data[9];
              $company_name = $data[10];
              $landline_no = $data[11];
              $address = $data[12];
              $address2 = $data[13];
              $city = $data[14];
              $state_id = $data[15];
              $service_tax_no= $data[16];
              $pan_no = $data[17];
              $source = $data[18];
              $created_at = date("Y-m-d");
              $birth_date1 = date('Y-m-d',strtotime($birth_date));
              $username = $contact_no;
              $password = $email_id;
              if(($cust_type =='Corporate' || $cust_type =='B2B') && $company_name != ''){
                  $company_count = mysqli_num_rows(mysqlQuery("select * from customer_master where company_name='$company_name'")); 
              }
              if(($cust_type =='Corporate' || $cust_type =='B2B') && $company_name == ''){
                  $invalidCount++;
                  array_push($unprocessedArray, $data);
              }
              else if($company_count!=0){
                  $invalidCount++;
                  array_push($unprocessedArray, $data);
              }
              else{

                if( !empty($cust_type) && preg_match('/^[a-zA-Z0-9 \s]*$/', $cust_type) && !empty($first_name) && preg_match('/^[a-zA-Z \s]*$/', $first_name) && preg_match('/^[a-zA-Z \s]*$/', $last_name) &&  preg_match('/^[a-zA-Z \s]*$/', $gender) && preg_match('/^[0-9 \s]{6,20}+$/', $contact_no) && preg_match('/^[0-9]*$/', $state_id) && !empty($country_code) && filter_var($email_id, FILTER_VALIDATE_EMAIL) )
                {
                  $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(customer_id) as max from customer_master"));
                  $customer_id = $sq_max['max'] + 1;
                  
                  $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(ledger_id) as max from ledger_master"));
                  $ledger_id = $sq_max['max'] + 1;
                  if($cust_type == 'Corporate' || $cust_type == 'B2B'){
                    $ledger_name = $company_name;
                  }
                  else{
                    $ledger_name = $customer_id.'_'.$first_name.'_'.$last_name;
                  }

                  $contact_no = $country_code.$contact_no;
                  $contact_no1 = $encrypt_decrypt->fnEncrypt($contact_no, $secret_key);
                  $email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
                  $cust_count = mysqli_num_rows(mysqlQuery("select * from customer_master where contact_no='$contact_no1'"));
                  if($cust_count>0){
                      $invalidCount++;
                      array_push($unprocessedArray, $data);
                  }
                  else{

                      $validCount++;
                      mysqlQuery("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type) values ('$ledger_id', '$ledger_name', '', '20', '0','Dr','$customer_id','customer')");
    
                      $sq_cust = mysqlQuery("insert into customer_master (customer_id,branch_admin_id, type,first_name, middle_name, last_name, gender, birth_date, age, contact_no,landline_no, email_id,alt_email,company_name, address,address2,city, active_flag, created_at,service_tax_no,state_id,pan_no,source,country_code) values ('$customer_id', '$branch_admin_id', '$cust_type', '$first_name', '$middle_name', '$last_name', '$gender', '$birth_date1', '$age', '$contact_no1','$landline_no', '$email_id','','$company_name', '$address', '$address2', '$city', 'Active', '$created_at', '$service_tax_no','$state_id','$pan_no','$source','$country_code')");
                    
                      if(!$sq_cust){
                        echo "error--Sorry Customer information not saved successfully!";
                        exit;
                      }
                      else{
                        $this->employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id);
                      }
                  }
                }
                else{
                    $invalidCount++;
                    array_push($unprocessedArray, $data);
                }
              }
          }
          $count++;
      }

        fclose($handle);

        if(isset($unprocessedArray) && !empty($unprocessedArray))
        {
            $filePath='../../download/unprocessed_customer_records'.$created_at.'.csv';
            $save = preg_replace('/(\/+)/','/',$filePath);
            $downloadurl='../../download/unprocessed_customer_records'.$created_at.'.csv';
            header("Content-type: text/csv ; charset:utf-8");
            header("Content-Disposition: attachment; filename=file.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $output = fopen($save, "w");  
            fputcsv($output, array('Customer Type' , 'First Name' , 'Middle Name' , 'Last Name' , 'Gender' , 'Birthdate' , 'Age' , 'Country Code','Contact No' ,'Email Id' , 'Company Name' , 'Landline No' , 'Address' , 'Address2' , 'City_id' , 'State_id' , 'Tax No' , 'PAN No', 'Source'));  
          
          foreach($unprocessedArray as $row){
          fputcsv($output, $row);  
          }
          fclose($output); 
          $downloadurl1 =  "<script> window.location ='$downloadurl'; </script>";  
        }
    }

    if($flag){
      commit_t();
      if($validCount>0){
        echo  $validCount." records successfully imported<br>
        ".$invalidCount." records are failed.".$downloadurl1;
      }
      else{
        echo "error--No Customer information imported".$downloadurl1;
      }
      exit;
    }
    else{
      rollback_t();
      exit;
    }

}

public function employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id)
{
  global $secret_key,$encrypt_decrypt;
  $link = BASE_URL.'view/customer';
  $email_id = $encrypt_decrypt->fnDecrypt($email_id, $secret_key);
  
  $content = mail_login_box($username, $password, $link);
  $subject = 'Welcome aboard!';
  global $model;
  
  $model->app_email_send('2',$first_name,$email_id, $content,$subject,'1');
}

public function whatsapp_send(){

  global $app_contact_no;
  $first_name = $_POST['first_name'];
  $username = $_POST['contact_no'];
  $password = $_POST['email_id'];

  $contact = $app_contact_no;
  $link = BASE_URL.'view/customer';
  $whatsapp_msg = 'Dear%20'.rawurlencode($first_name).',%0aHope%20you%20are%20doing%20great.%0aYour%20Login%20Details%20!.%0a*Username*%20:%20'.rawurlencode($username).'%0a*Password*%20:%20'.rawurlencode($password).'%0a*Link*%20:%20'.$link.
  

'%0aWe%20look%20forward%20to%20having%20you%20onboard%20with%20us.%0aPlease%20contact%20for%20more%20details%20:%20'.$contact.'%0aThank%20you.%0a';

  $link = 'https://web.whatsapp.com/send?phone='.$username.'&text='.$whatsapp_msg;
  echo $link;
}

}
?>