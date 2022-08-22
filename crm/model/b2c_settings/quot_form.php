<?php
class quot_master{

	public function actions_qout_otp(){

        $name = $_POST['name'];
        $email_id = $_POST['email_id'];
        // $country_code = $_POST['country_code'];
        // $phone = $_POST['phone'];

        $six_digit_random_number = mt_rand(100000, 999999);
        $content = '
            <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="text-align: left;color: #888888;margin-top:20px; min-width: 100%;" role="presentation">
            <tr>
                <td colspan=2><b>Dear '.$name.',</b></td> 
            </tr>
            <tr></tr>
            <tr>
                <td colspan=2><b>A sign in attempt requires further verification because we did not recognize your device. To complete the download quotation, enter the verification code on the unrecognized device.</b></td> 
            </tr>
            </table>
            <table width="85%" cellspacing="0" cellpadding="5" style="text-align: left;color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Verification code</td>   <td style="text-align:left;border: 1px solid #888888;">'.$six_digit_random_number.'</td></tr>
            </table>
            </tr>';
        
            //Mail to Admin
            $subject = 'Please verify your device';
            global $model;
            $model->app_email_master($email_id, $content, $subject,'1');
            echo $six_digit_random_number;
	}
    function quotation_save(){

        $currency = $_POST['currency'];
        $package_id= $_POST['package_id'];
        $name = $_POST['name'];
        $email_id = $_POST['email_id'];
        $city_place = $_POST['city_place'];
        $country_code = $_POST['country_code'];
        $phone = $_POST['phone'];
        $travel_from = $_POST['travel_from'];
        $travel_to = $_POST['travel_to'];
        $adults = $_POST['adults'];
        $chwb = $_POST['chwb'];
        $chwob = $_POST['chwob'];
        $extra_bed = $_POST['extra_bed'];
        $infant = $_POST['infant'];
        $package_typef= $_POST['package_typef'];
        $specification = $_POST['specification'];
        $type = $_POST['type'];
        $date = date('Y-m-d H:i');
        
        $contact = $country_code.$phone;
        $travel_from = get_date_db($travel_from);
        $travel_to = get_date_db($travel_to);

        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from b2c_quotations"));
        $entry_id = $sq_max['max']+1;
        
        $sq_query = mysqlQuery("INSERT INTO `b2c_quotations`(`entry_id`,`type`,`package_id`, `name`, `email`,`city`, `phone`, `travel_from_date`, `travel_to_date`, `adults`, `chwob`, `chwb`, `extra_bed`, `infant`, `package_type`, `specification`, `created_at`,`currency`) VALUES ('$entry_id','$type','$package_id','$name','$email_id','$city_place','$contact','$travel_from','$travel_to','$adults','$chwob','$chwb','$extra_bed','$infant','$package_typef','$specification','$date','$currency')");
        if($sq_query){
            echo $entry_id;
        }else{
            echo 'error';
        }
    }
    function delete_quot(){
        
        $quotation_id = $_POST['quotation_id'];
        $sq_query = mysqlQuery("update `b2c_quotations` set status='1' where entry_id='$quotation_id'");
        if($sq_query){
            echo 'Quotation has been deleted successfully!';
        }else{
            echo 'error';
        }
    }
}