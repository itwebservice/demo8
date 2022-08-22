<?php 

class vendor_price_save{



public function vendor_price_save1()

{

	//$login_id = $_SESSION['login_id'];



	$without_bed_arr = $_POST['without_bed_arr'];

	$from_date_arr = $_POST['from_date_arr']; 

	$to_date_arr = $_POST['to_date_arr'];

	$single_bed_arr = $_POST['single_bed_arr'];

	$double_bed_arr = $_POST['double_bed_arr'];

	$triple_bed_arr = $_POST['triple_bed_arr'];

	$quad_bed_arr = $_POST['quad_bed_arr'];

	$with_bed_arr = $_POST['with_bed_arr'];

	$queen_arr = $_POST['queen_arr'];

	$king_arr = $_POST['king_arr'];

	$twin_arr = $_POST['twin_arr'];

	$meal_plan_arr = $_POST['meal_plan_arr'];



	$hotel_id = $_POST['hotel_id'];

	$city_id = $_POST['city_id'];

	$currency_code = $_POST['currency_code'];



	begin_t();



	$sq_max = mysqli_fetch_assoc(mysqlQuery("SELECT max(pricing_id) as max from hotel_vendor_price_master"));

	$pricing_id = $sq_max['max'] + 1;

	$created_at = date('Y-m-d H:i');

	$sq_login = mysqlQuery("insert into hotel_vendor_price_master (pricing_id, city_id,hotel_id, currency_id , created_at) values ('$pricing_id','$city_id','$hotel_id','$currency_code', '$created_at')");



	$sq = mysqlQuery("select max(pricing_id) as max from hotel_vendor_price_master");

    $value = mysqli_fetch_assoc($sq);

    $max_pricing_id = $value['max'];

	

	for($i=0; $i<sizeof($from_date_arr); $i++)

  	{

  			$sq = mysqlQuery("select max(entry_id) as max from hotel_vendor_price_list");

		    $value = mysqli_fetch_assoc($sq);

		    $max_entry_id = $value['max'] + 1;



		    $from_date_arr[$i] = mysqlREString($from_date_arr[$i]);

		    $to_date_arr[$i] = mysqlREString($to_date_arr[$i]);

		    $single_bed_arr[$i] = mysqlREString($single_bed_arr[$i]);

		    $double_bed_arr[$i] = mysqlREString($double_bed_arr[$i]);

		    $triple_bed_arr[$i] = mysqlREString($triple_bed_arr[$i]);

		    $quad_bed_arr[$i] = mysqlREString($quad_bed_arr[$i]);

		    $with_bed_arr[$i] = mysqlREString($with_bed_arr[$i]);

		    $without_bed_arr[$i] = mysqlREString($without_bed_arr[$i]);

		    $queen_arr[$i] = mysqlREString($queen_arr[$i]);

		    $king_arr[$i] = mysqlREString($king_arr[$i]);

		    $twin_arr[$i] = mysqlREString($twin_arr[$i]);

		    $meal_plan_arr[$i] = mysqlREString($meal_plan_arr[$i]);



		    if($from_date_arr[$i]!=""){  $from_date_arr[$i] = date("Y-m-d", strtotime($from_date_arr[$i])); }

		    if($to_date_arr[$i]!=""){  $to_date_arr[$i] = date("Y-m-d", strtotime($to_date_arr[$i])); }



		    $sq = mysqlQuery("insert into hotel_vendor_price_list (entry_id, pricing_id, from_date, to_date, single_bed_cost, double_bed_cost, triple_bed_cost, quad_bed_cost, with_bed_cost, without_bed_cost,queen, king, twin, meal_plan) values ('$max_entry_id','$max_pricing_id', '$from_date_arr[$i]', '$to_date_arr[$i]', '$single_bed_arr[$i]', '$double_bed_arr[$i]', '$triple_bed_arr[$i]','$quad_bed_arr[$i]', '$with_bed_arr[$i]', '$without_bed_arr[$i]','$queen_arr[$i]', '$king_arr[$i]', '$twin_arr[$i]', '$meal_plan_arr[$i]')");   

  	}

	if(!$sq_login or !$sq){

		$GLOBALS['flag'] = false;

		echo "error--Tariff details not saved!";

	}else

	{

		commit_t();

		

		//$this->vendor_acknowledge($login_id);

        /*$this->vendor_sign_up_sms($username, $password); */

        echo "Hotel Tariff details Saved!";

	}



}



function vendor_acknowledge($login_id)

{

	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

 	 global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

 	 $sq_request_id=mysqli_fetch_assoc(mysqlQuery("select * from vendor_login where login_id='$login_id'"));

 	 $sq_hotel_id=mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$sq_request_id[user_id]'"));

 	 $sq_city_id=mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$sq_hotel_id[city_id]'"));

	 $content = '
	 <style type="text/css">
		td,th
		{
			padding:15px; 
			border:0px solid #c5c5c5;
		}
	</style>
		<p>Dear Admin, Backoffice,</p>
	     <table style="border-collapse: collapse;">
		     <tr>
	            <td style="padding:7px;">You have received new hotel Tariff by <span style="color:green">'.$sq_hotel_id['hotel_name'].'</span>
	            </td>
	         <tr>
	         <tr>
	            <td style="padding:7px; ">City Name : &nbsp;<span>'.$sq_city_id['city_name'].'</span>
	            </td>
	         </tr>
	         <tr>
	            <td style="padding:7px; ">Country Name : &nbsp;<span>'.$sq_hotel_id['country'].'</span>
	            </td>
	         </tr>
          </table>
	     </p>
	    <p style="padding:7px;">
            <a href="'.BASE_URL.'/view/hotels/master/index.php" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">View Tariff</a>
          </p>
	  ';



	  global $model;

	  $subject = " Hotel Tariff Acknowledgement";

	  $model->app_email_master($app_email_id, $content, $subject);



}

public function vendor_price_update1()

{

	$login_id = $_SESSION['login_id'];

	$price_entry = $_POST['price_entry'];



	$without_bed_cost = $_POST['without_bed_cost'];

	$from_date = $_POST['from_date']; 

	$to_date = $_POST['to_date'];

	$single_bed_cost = $_POST['single_bed_cost'];

	$double_bed_cost = $_POST['double_bed_cost'];

	$triple_bed_cost = $_POST['triple_bed_cost'];

	$quad_bed_cost = $_POST['quad_bed_cost'];

	$with_bed_cost = $_POST['with_bed_cost'];

	$queen = $_POST['queen'];

	$king = $_POST['king'];

	$twin = $_POST['twin'];

	$meal_plan = $_POST['meal_plan'];
	$currency_code = $_POST['currency_code'];


	begin_t();

	$sq_query = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_price_list where entry_id = '$price_entry'"));



    if($from_date!=""){  $from_date = date("Y-m-d", strtotime($from_date)); }

    if($to_date!=""){  $to_date = date("Y-m-d", strtotime($to_date)); }

    $sq = mysqlQuery("update hotel_vendor_price_list set from_date = '$from_date', to_date = '$to_date', single_bed_cost = '$single_bed_cost', double_bed_cost = '$double_bed_cost', triple_bed_cost = '$triple_bed_cost', quad_bed_cost = '$quad_bed_cost', with_bed_cost =  '$with_bed_cost', without_bed_cost = '$without_bed_cost',queen = '$queen', king ='$king', twin = '$twin', meal_plan = '$meal_plan' where entry_id = '$price_entry' ");   



	$sq_login = mysqlQuery("update hotel_vendor_price_master set  currency_id = '$currency_code' where pricing_id = '$sq_query[pricing_id]'");

  	

	if(!$sq_login){

		$GLOBALS['flag'] = false;

		echo "error--Tariff details not Updated!";

	}else

	{

		commit_t();


        echo "Hotel Tariff details Updated!";

	}



}



function vendor_update_acknowledge($login_id)

{

	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

 	 global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

 	 $sq_request_id=mysqli_fetch_assoc(mysqlQuery("select * from vendor_login where login_id='$login_id'"));

 	 $sq_hotel_id=mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$sq_request_id[user_id]'"));

 	 $sq_city_id=mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$sq_hotel_id[city_id]'"));

	 $content = '
	 <style type="text/css">
		td,th
		{
			padding:15px; 
			border:0px solid #c5c5c5;
		}
	</style>
		<p>Dear Admin, Backoffice,</p>
	     <table style="border-collapse: collapse;">
		     <tr>
	            <td style="padding:7px;">The Tariff updated by <span style="color:green">'.$sq_hotel_id['hotel_name'].'</span>
	            </td>
	         <tr>
	         <tr>
	            <td style="padding:7px; ">City Name : &nbsp;<span>'.$sq_city_id['city_name'].'</span>
	            </td>
	         </tr>
	         <tr>
	            <td style="padding:7px; ">Country Name : &nbsp;<span>'.$sq_hotel_id['country'].'</span>
	            </td>
	         </tr>
          </table>
	     </p>
	    <p style="padding:7px;">
            <a href="'.BASE_URL.'/view/hotels/master/index.php" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">View New Tariff</a>
          </p>
	  ';



	  global $model;

	  $subject = " Hotel Tariff Acknowledgement";

	  $model->app_email_master($app_email_id, $content, $subject);



}
function tariff_csv_save(){
	$cust_csv_dir = $_POST['cust_csv_dir'];
    $pass_info_arr = array();

    $flag = true;

    $cust_csv_dir = explode('uploads', $cust_csv_dir);
    $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];

    begin_t();

    $count = 1;

    $arrResult  = array();
    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {
        while(($data = fgetcsv($handle,3000, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }
            if($count>0){
                
            $sq = mysqlQuery("select max(pricing_id) as max from hotel_vendor_price_master");
            $value = mysqli_fetch_assoc($sq);
            $pricing_id = $value['max'] + 1;
            $arr = array(
                'room_cat' => $data[0],
                'from_date' => $data[1],
                'to_date' => $data[2],
                'single_bed' => $data[3],
                'double_bed' => $data[4],
                'triple_bed' => $data[5],
                'quad_bed' => $data[6],
                'extra_bed' => $data[7],
                'queen_bed' => $data[8],
								'king_bed'  => $data[9],
								'twin_bed' => $data[10],
								'meal_plan' => $data[11]
                );

            array_push($pass_info_arr, $arr); 
            }  
            

            $count++;

        }
       
        fclose($handle);
    }
echo json_encode($pass_info_arr);
}

function b2btariff_csv_save(){
	$cust_csv_dir = $_POST['cust_csv_dir'];
    $pass_info_arr = array();
    $flag = true;
    $cust_csv_dir = explode('uploads', $cust_csv_dir);
    $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];
    begin_t();
    $count = 1;

    $arrResult  = array();
    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {
        while(($data = fgetcsv($handle,3000, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }
            if($count>0){
                
			$arr = array(
                'room_cat' => $data[0],
                'max_occ' => $data[1],
                'from_date' => $data[2],
                'to_date' => $data[3],
                'double_bed' => $data[4],
                'cwbed' => $data[5],
                'cwobed' => $data[6],
                'with_bed' => $data[7],
				'markup_per'  => $data[8],
				'flat_markup' => $data[9],
				'meal_plan' => $data[10]
                );
            array_push($pass_info_arr, $arr); 
            }
            $count++;
        }
        fclose($handle);
    }
echo json_encode($pass_info_arr);
}

function b2btariff_weekend_rates(){
	$cust_csv_dir = $_POST['cust_csv_dir'];
    $pass_info_arr = array();
    $flag = true;
    $cust_csv_dir = explode('uploads', $cust_csv_dir);
    $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];
    begin_t();
    $count = 1;

    $arrResult  = array();
    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {
        while(($data = fgetcsv($handle,3000, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }
            if($count>0){
                
			$arr = array(
                'room_cat' => $data[0],
                'max_occ' => $data[1],
                'day' => $data[2],
                'double_bed' => $data[3],
                'cwbed' => $data[4],
                'cwobed' => $data[5],
                'with_bed' => $data[6],
				'markup_per'  => $data[7],
				'flat_markup' => $data[8],
				'meal_plan' => $data[9]
                );
            array_push($pass_info_arr, $arr); 
            }
            $count++;
        }
        fclose($handle);
    }
echo json_encode($pass_info_arr);
}

}