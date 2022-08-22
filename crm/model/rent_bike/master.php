<?php
class master{

    function master_save(){
        
        $bike_type = $_POST['bike_type'];
        $bike_name = addslashes($_POST['bike_name']);
        $manufacturer = $_POST['manufacturer'];
        $model_name = $_POST['model_name'];
        $seating_capacity = $_POST['seating_capacity'];
        $pickup_time = $_POST['pickup_time'];
        $drop_time = $_POST['drop_time'];
        $image_upload_url = $_POST['image_upload_url'];
        $canc_policy = addslashes($_POST['canc_policy']);
        $incl = addslashes($_POST['incl']);
        $excl = addslashes($_POST['excl']);
        $terms = addslashes($_POST['terms']);
        
        $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from bike_master where bike_name='$bike_name' and bike_type='$bike_type'"));
        if($sq_count > 0){
            echo 'error--Bike name already added';
            exit;
        }

        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from bike_master"));
        $entry_id = $sq_max['max'] + 1;
        $sq_query = mysqlQuery("INSERT INTO `bike_master`(`entry_id`, `bike_type`, `bike_name`, `manufacturer`, `model_name`, `seating_capacity`, `pickup_time`, `drop_time`, `image_upload_url`, `incl`, `excl`, `terms`, `canc_policy`, `active_flag`) VALUES ('$entry_id','$bike_type','$bike_name','$manufacturer','$model_name','$seating_capacity','$pickup_time','$drop_time','$image_upload_url','$incl','$excl','$terms','$canc_policy','Active')");

        if($sq_query){
            echo 'Bike Details added succesfully';
            exit;
        }else{
            echo 'error--Bike Details not added succesfully';
            exit;
        }

    }
    function bike_type_save(){
        
        $bike_type = addslashes($_POST['bike_type']);
        $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from bike_type_master where bike_type='$bike_type'"));
        if($sq_count > 0){
            echo 'error--Bike type already added';
            exit;
        }
        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from bike_type_master"));
        $entry_id = $sq_max['max'] + 1;
        $sq_query = mysqlQuery("INSERT INTO `bike_type_master`(`entry_id`, `bike_type`,`active_flag`) VALUES ('$entry_id','$bike_type','Active')");

        if($sq_query){
            echo 'Bike type added succesfully';
            exit;
        }else{
            echo 'error--Bike type not added succesfully';
            exit;
        }
    }
    function master_update(){

        $entry_id = $_POST['entry_id'];
        $bike_type = $_POST['bike_type'];
        $bike_name = addslashes($_POST['bike_name']);
        $manufacturer = $_POST['manufacturer'];
        $model_name = $_POST['model_name'];
        $seating_capacity = $_POST['seating_capacity'];
        $pickup_time = $_POST['pickup_time'];
        $drop_time = $_POST['drop_time'];
        $image_upload_url = $_POST['image_upload_url'];
        $active_flag = $_POST['active_flag'];
        $canc_policy = addslashes($_POST['canc_policy']);
        $incl = addslashes($_POST['incl']);
        $excl = addslashes($_POST['excl']);
        $terms = addslashes($_POST['terms']);

        $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from bike_master where bike_name='$bike_name' and bike_type='$bike_type' and entry_id!='$entry_id'"));
        if($sq_count > 0){
            echo 'error--Bike name already added';
            exit;
        }
        $sq_query = mysqlQuery("UPDATE `bike_master` SET `bike_type`='$bike_type',`bike_name`='$bike_name',`manufacturer`='$manufacturer',`model_name`='$model_name',`seating_capacity`='$seating_capacity',`pickup_time`='$pickup_time',`drop_time`='$drop_time',`image_upload_url`='$image_upload_url',`incl`='$incl',`excl`='$excl',`terms`='$terms',`canc_policy`='$canc_policy',`active_flag`='$active_flag' where entry_id='$entry_id' ");
        if($sq_query){
            echo 'Bike Details updated succesfully';
            exit;
        }else{
            echo 'error--Bike Details not updated succesfully';
            exit;
        }

    }

    function tariff_save(){
        $bike_id = $_POST['bike_id'];
        $currency_id = $_POST['currency_id'];

        $city_array = ($_POST['city_array']!='')?$_POST['city_array']:[];
        $pickup_location_array = $_POST['pickup_location_array'];
        $from_date_array = $_POST['from_date_array'];
        $to_date_array = $_POST['to_date_array'];
        $no_bikes_array = $_POST['no_bikes_array'];
        $cost_type_array = $_POST['cost_type_array'];
        $total_cost_array = $_POST['total_cost_array'];
        $deposit_array = $_POST['deposit_array'];
        $markup_in_array = $_POST['markup_in_array'];
        $markup_amount_array = $_POST['markup_amount_array'];

        $type_array = ($_POST['type_array']!='')?$_POST['type_array']:[]; 
        $ofrom_date_array = $_POST['ofrom_date_array'];
        $oto_date_array = $_POST['oto_date_array'];
        $offer_in_array = $_POST['offer_in_array'];
        $coupon_code_array = $_POST['coupon_code_array'];
        $offer_array = $_POST['offer_array'];
        $agent_type_array = $_POST['agent_type_array'];
        
        $created_at = date('Y-m-d');
        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from bike_tariff"));
        $entry_id = $sq_max['max'] + 1;
        $sq_query = mysqlQuery("INSERT INTO `bike_tariff`(`entry_id`,`bike_id`, `currency_id`,`created_at`) VALUES ('$entry_id','$bike_id','$currency_id','$created_at')");
        if($sq_query){

            for($i=0;$i<sizeof($city_array);$i++){

                $from_date_array[$i] = get_date_db($from_date_array[$i]);
                $to_date_array[$i] = get_date_db($to_date_array[$i]);
                $pickup_location_array[$i] = addslashes($pickup_location_array[$i]);

                $sq_max1 = mysqli_fetch_assoc(mysqlQuery("select max(tariff_id) as max from bike_tairff_entries"));
                $tariff_id = $sq_max1['max'] + 1;
        
                $sq_query1 = mysqlQuery("INSERT INTO `bike_tairff_entries`(`tariff_id`, `entry_id`, `city_id`, `pickup_location`, `from_date`, `to_date`, `no_of_bikes`,`costing_type`,`total_cost`,`deposit`,`markup_in`,`markup_amount`) VALUES ('$tariff_id','$entry_id','$city_array[$i]','$pickup_location_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$no_bikes_array[$i]','$cost_type_array[$i]','$total_cost_array[$i]','$deposit_array[$i]','$markup_in_array[$i]','$markup_amount_array[$i]')");
                if(!$sq_query1){
                    echo 'error--Tariff Details not added succesfully';
                    exit;
                }
            }
            
            //Offers/coupon Save
            for($i=0;$i<sizeof($type_array);$i++){
                $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from bike_offers"));
                $offer_entry = $sq_max['max'] + 1;
                $ofrom_date_array[$i] = get_date_db($ofrom_date_array[$i]);
                $oto_date_array[$i] = get_date_db($oto_date_array[$i]);
                $sq_offer = mysqlQuery("INSERT INTO `bike_offers`(`entry_id`, `bike_id`, `type`, `from_date`, `to_date`, `offer_in`,`coupon_code`, `offer_amount`, `agent_type`) VALUES ('$offer_entry', '$bike_id','$type_array[$i]','$ofrom_date_array[$i]','$oto_date_array[$i]','$offer_in_array[$i]','$coupon_code_array[$i]','$offer_array[$i]','$agent_type_array[$i]')");
                if(!$sq_offer){
                    echo "error--Sorry, Bike Offers/coupon not saved!";
                    exit;
                }
            }
            echo 'Tariff Details added succesfully';
            exit;
        }
        else{
            echo 'error--Tariff Details not added succesfully';
            exit;
        }

    }
    
    function tariff_update(){
        
        $entry_id = $_POST['entry_id'];
        $bike_id = $_POST['bike_id'];
        $currency_id = $_POST['currency_id'];

        $city_array = ($_POST['city_array']!='')?$_POST['city_array']:[];
        $pickup_location_array = $_POST['pickup_location_array'];
        $from_date_array = $_POST['from_date_array'];
        $to_date_array = $_POST['to_date_array'];
        $no_bikes_array = $_POST['no_bikes_array'];
        $cost_type_array = $_POST['cost_type_array'];
        $total_cost_array = $_POST['total_cost_array'];
        $deposit_array = $_POST['deposit_array'];
        $markup_in_array = $_POST['markup_in_array'];
        $markup_amount_array = $_POST['markup_amount_array'];
        $basic_entryid_array = $_POST['basic_entryid_array'];
        $bike_option_array = $_POST['bike_option_array'];

        $type_array = ($_POST['type_array']!='')?$_POST['type_array']:[]; 
        $ofrom_date_array = $_POST['ofrom_date_array'];
        $oto_date_array = $_POST['oto_date_array'];
        $offer_in_array = $_POST['offer_in_array'];
        $coupon_code_array = $_POST['coupon_code_array'];
        $offer_array = $_POST['offer_array'];
        $agent_type_array = $_POST['agent_type_array'];
        $offer_entryid_array = $_POST['offer_entryid_array'];
        $offers_array = $_POST['offers_array'];

        $sq_query = mysqlQuery("Update `bike_tariff` set `bike_id`='$bike_id', `currency_id`='$currency_id' where entry_id='$entry_id'");
        if($sq_query){

            for($i=0;$i<sizeof($city_array);$i++){
                $from_date_array[$i] = get_date_db($from_date_array[$i]);
                $to_date_array[$i] = get_date_db($to_date_array[$i]);
                $pickup_location_array[$i] = addslashes($pickup_location_array[$i]);
                
                if($bike_option_array[$i] == 'true'){

                    if($basic_entryid_array[$i] == ''){

                        $sq_max1 = mysqli_fetch_assoc(mysqlQuery("select max(tariff_id) as max from bike_tairff_entries"));
                        $tariff_id = $sq_max1['max'] + 1;
                        $sq_query1 = mysqlQuery("INSERT INTO `bike_tairff_entries`(`tariff_id`, `entry_id`, `city_id`, `pickup_location`, `from_date`, `to_date`, `no_of_bikes`,`costing_type`,`total_cost`,`deposit`,`markup_in`,`markup_amount`) VALUES ('$tariff_id','$entry_id','$city_array[$i]','$pickup_location_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$no_bikes_array[$i]','$cost_type_array[$i]','$total_cost_array[$i]','$deposit_array[$i]','$markup_in_array[$i]','$markup_amount_array[$i]')");
                    }else{
                        $sq_query1 = mysqlQuery("UPDATE `bike_tairff_entries` SET `city_id`='$city_array[$i]',`pickup_location`='$pickup_location_array[$i]',`from_date`='$from_date_array[$i]',`to_date`='$to_date_array[$i]',`no_of_bikes`='$no_bikes_array[$i]',`costing_type`='$cost_type_array[$i]',`total_cost`='$total_cost_array[$i]',`deposit`='$deposit_array[$i]',`markup_in`='$markup_in_array[$i]',`markup_amount`='$markup_amount_array[$i]' WHERE tariff_id='$basic_entryid_array[$i]'");
                    }
                }else{
                    $sq_query1 = mysqlQuery("DELETE FROM `bike_tairff_entries` WHERE `tariff_id`='$basic_entryid_array[$i]'");
                }
                if(!$sq_query1){
                    echo 'error--Tariff Details not updated succesfully';
                    exit;
                }
            }
            
            //TAB-5
            for($i=0; $i<sizeof($ofrom_date_array); $i++){
                if($offers_array[$i] == 'true'){

                    $type_array[$i] = mysqlREString($type_array[$i]);
                    $ofrom_date_array[$i] = mysqlREString($ofrom_date_array[$i]);
                    $oto_date_array[$i] = mysqlREString($oto_date_array[$i]);
                    $offer_array[$i] = mysqlREString($offer_array[$i]);
                    $agent_type_array[$i] = mysqlREString($agent_type_array[$i]);
                    $coupon_code_array[$i] = mysqlREString($coupon_code_array[$i]);
                    $offer_array[$i] = mysqlREString($offer_array[$i]);
                    $ofrom_date_array[$i] = get_date_db($ofrom_date_array[$i]);
                    $oto_date_array[$i] = get_date_db($oto_date_array[$i]);

                    if($offer_entryid_array[$i] == ''){

                        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from bike_offers"));
                        $offer_entry = $sq_max['max'] + 1;
                        $sq_offer = mysqlQuery("INSERT INTO `bike_offers`(`entry_id`, `bike_id`, `type`, `from_date`, `to_date`, `offer_in`,`coupon_code`, `offer_amount`, `agent_type`) VALUES ('$offer_entry', '$bike_id','$type_array[$i]','$ofrom_date_array[$i]','$oto_date_array[$i]','$offer_in_array[$i]','$coupon_code_array[$i]','$offer_array[$i]','$agent_type_array[$i]')");
                        if(!$sq_offer){
                            $GLOBALS['flag'] = false;
                            echo "error--Offers/Coupon Tariff details not saved!";
                        }
                    }
                    else{
                        $sq1 = mysqlQuery("UPDATE `bike_offers` SET `bike_id`='$bike_id',`type`='$type_array[$i]',`from_date`='$ofrom_date_array[$i]', `to_date`='$oto_date_array[$i]',`offer_in`='$offer_in_array[$i]', `agent_type`='$agent_type_array[$i]',`coupon_code`='$coupon_code_array[$i]',`offer_amount`='$offer_array[$i]' WHERE entry_id='$offer_entryid_array[$i]'");
                        if(!$sq1){
                            $GLOBALS['flag'] = false;
                            echo "error--Offers/Coupon Tariff details not updated!";
                        }
                    }
                }
                else{
                    $sq1 = mysqlQuery("DELETE FROM `bike_offers` WHERE `entry_id`='$offer_entryid_array[$i]'");
                    if(!$sq1){
                        $GLOBALS['flag'] = false;
                        echo "error--Offers/Coupon Tariff details not deleted!";
                    }
                }
		    }
            echo 'Tariff Details updated succesfully';
            exit;
        }
        else{
            echo 'error--Tariff Details not updated succesfully';
            exit;
        }

    }
    function tariff_csv_save(){
        $cust_csv_dir = $_POST['cust_csv_dir'];
        $pass_info_arr = array();
    
        $flag = true;    
        $cust_csv_dir = explode('uploads', $cust_csv_dir);
        $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];
    
        begin_t();
    
        $count = 1;    
        $handle = fopen($cust_csv_dir, "r");
        if(empty($handle) === false) {
            while(($data = fgetcsv($handle, 6000,",")) !== FALSE){
                if($count == 1) { $count++; continue; }
                if($count>0){

                    // Pickup
                        $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$data[1]'"));
                        $city_name = $row['city_name'];

                    $arr = array(
                        'city_id' => $data[0],
                        'city_name' => $city_name,
                        'pickup_location' => $data[1],
                        'from_date' => $data[2],
                        'to_date' => $data[3],
                        'no_of_bikes' => $data[4],
                        'costing_type' => $data[5],
                        'total_cost' => $data[6],
                        'deposit' => $data[7],
                        'markup_in'  => $data[8],
                        'markup_amount' => $data[9]
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
?>