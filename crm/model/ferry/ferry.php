<?php
class ferry{

    function ferry_save(){

        $ferry_type = $_POST['ferry_type'];
        $ferry_name = $_POST['ferry_name'];
        $seating_capacity = $_POST['seating_capacity'];
        $image_upload_url = $_POST['image_upload_url'];
        $childfrom = $_POST['childfrom'];
        $childto = $_POST['childto'];
        $infantfrom = $_POST['infantfrom'];
        $infantto = $_POST['infantto'];
        $inclusions = $_POST['inclusions'];
        $exclusions = $_POST['exclusions'];
        $terms = $_POST['terms'];

        $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from ferry_master where ferry_type='$ferry_type' and ferry_name='$ferry_name'"));
        if($sq_count > 0){
            echo 'error--Ferry already added';
            exit;
        }

        $inclusions = addslashes($inclusions);
        $exclusions = addslashes($exclusions);
        $terms = addslashes($terms);

        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from ferry_master"));
        $entry_id = $sq_max['max'] + 1;
        $sq_query = mysqlQuery("INSERT INTO `ferry_master`(`entry_id`, `ferry_type`, `ferry_name`, `seating_capacity`, `image_url`, `child_from`, `child_to`, `infant_from`, `infant_to`, `active_flag`,`inclusions`,`exclusions`,`terms`) VALUES ('$entry_id','$ferry_type','$ferry_name','$seating_capacity','$image_upload_url','$childfrom','$childto','$infantfrom','$infantto','Active','$inclusions','$exclusions','$terms')");
        if($sq_query){
            echo 'Ferry Details added succesfully';
            exit;
        }else{
            echo 'error--Ferry Details not added succesfully';
            exit;
        }
    }
    function ferry_update(){
        
        $entry_id = $_POST['entry_id'];
        $ferry_type = $_POST['ferry_type'];
        $ferry_name = $_POST['ferry_name'];
        $seating_capacity = $_POST['seating_capacity'];
        $image_upload_url = $_POST['image_upload_url'];
        $childfrom = $_POST['childfrom'];
        $childto = $_POST['childto'];
        $infantfrom = $_POST['infantfrom'];
        $infantto = $_POST['infantto'];
        $active_flag = $_POST['active_flag'];
        $inclusions = $_POST['inclusions'];
        $exclusions = $_POST['exclusions'];
        $terms = $_POST['terms'];

        $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from ferry_master where ferry_type='$ferry_type' and ferry_name='$ferry_name' and entry_id!='$entry_id'"));
        if($sq_count > 0){
            echo 'error--Ferry already added';
            exit;
        }
        $inclusions = addslashes($inclusions);
        $exclusions = addslashes($exclusions);
        $terms = addslashes($terms);

        $sq_query = mysqlQuery("update `ferry_master` set `ferry_type`='$ferry_type', `ferry_name`='$ferry_name', `seating_capacity`='$seating_capacity', `image_url`='$image_upload_url', `child_from`='$childfrom', `child_to`='$childto', `infant_from`='$infantfrom', `infant_to`='$infantto', `active_flag`='$active_flag',`inclusions`='$inclusions',`exclusions`='$exclusions',`terms`='$terms' where entry_id='$entry_id'");
        if($sq_query){
            echo 'Ferry Details updated succesfully';
            exit;
        }else{
            echo 'error--Ferry Details not updated succesfully';
            exit;
        }
    }
    function delete_image(){

        $image_id = $_POST['image_id'];
        $entry_id = $_POST['entry_id'];
        
        $row_image = mysqli_fetch_assoc(mysqlQuery("select image_url from ferry_master where entry_id='$entry_id'"));
        $image_url = explode(',',$row_image['image_url']);
        $ferry_image_array = array();

        for($i = 0; $i<sizeof($image_url); $i++){
            if($image_id != $i){
            array_push($ferry_image_array,$image_url[$i]);
            }
        }
        $ferry_image_array = implode(',',$ferry_image_array);
        $sq_delete = mysqlQuery("update ferry_master set `image_url`='$ferry_image_array' where entry_id='$entry_id'");    
        if($sq_delete){
            echo "Image Deleted--".json_encode($ferry_image_array);
        }
    }
    function tariff_save(){
        
        $ferry_id = $_POST['ferry_id'];
        $currency_id = $_POST['currency_id'];

        $no_seats_array = $_POST['no_seats_array'];
        $from_date_array = $_POST['from_date_array'];
        $to_date_array = $_POST['to_date_array'];
        $pickup_from_array = $_POST['pickup_from_array'];
        $drop_to_array = $_POST['drop_to_array'];
        $dep_date_array = $_POST['dep_date_array'];
        $arr_date_array = $_POST['arr_date_array'];
        $ferry_type_array = $_POST['ferry_type_array'];
        $adult_array = $_POST['adult_array'];
        $child_array = $_POST['child_array'];
        $infant_array = $_POST['infant_array'];
        $markup_in_array = $_POST['markup_in_array'];
        $markup_cost_array = $_POST['markup_cost_array'];
        $created_at = date('Y-m-d H:i');

        for($i=0;$i<sizeof($from_date_array);$i++){
            
            $from_date_array[$i] = get_date_db($from_date_array[$i]);
            $to_date_array[$i] = get_date_db($to_date_array[$i]);
            $dep_date_array[$i] = get_datetime_db($dep_date_array[$i]);
            $arr_date_array[$i] = get_datetime_db($arr_date_array[$i]);

            $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(tariff_id) as max from ferry_tariff"));
            $tariff_id = $sq_max['max'] + 1;
            $sq_query = mysqlQuery("INSERT INTO `ferry_tariff`(`tariff_id`, `entry_id`, `no_of_seats`, `valid_from_date`, `valid_to_date`, `from_location`, `to_location`, `dep_date`, `arr_date`, `category`, `adult_cost`, `child_cost`, `infant_cost`,`currency_id`,`created_at`,`markup_in`,`markup_cost`) VALUES ('$tariff_id','$ferry_id','$no_seats_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$pickup_from_array[$i]','$drop_to_array[$i]','$dep_date_array[$i]','$arr_date_array[$i]','$ferry_type_array[$i]','$adult_array[$i]','$child_array[$i]','$infant_array[$i]','$currency_id','$created_at','$markup_in_array[$i]','$markup_cost_array[$i]')");
        }
        if($sq_query){
            echo 'Tariff Details added succesfully';
            exit;
        }
        else{
            echo 'error--Tariff Details not added succesfully';
            exit;
        }
    }
    function tariff_csv_save(){
        
        $cust_csv_dir = $_POST['cust_csv_dir'];
        $pass_info_arr = array();
    
        $cust_csv_dir = explode('uploads', $cust_csv_dir);
        $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];
    
        begin_t();
        $count = 1;
        $handle = fopen($cust_csv_dir, "r");
        if(empty($handle) === false) {
            while(($data = fgetcsv($handle, 6000,",")) !== FALSE){
                if($count == 1) { $count++; continue; }
                if($count>0){
                    $arr = array(
                        'no_of_seats' => $data[0],
                        'from_date' => $data[1],
                        'to_date' => $data[2],
                        'from_location' => $data[3],
                        'to_location' => $data[4],
                        'dep_date' => $data[5],
                        'arr_date' => $data[6],
                        'ferry_type' => $data[7],
                        'adult_cost' => $data[8],
                        'child_cost' => $data[9],
                        'infant_cost'  => $data[10],
                        'markup_in' => $data[11],
                        'markup_cost'  => $data[12],
                    );
                    array_push($pass_info_arr, $arr); 
                }
                $count++;    
            }
            fclose($handle);
        }
        echo json_encode($pass_info_arr);
    }
    function tariff_update(){
        
        $fentry_id = $_POST['fentry_id'];
        $entry_id_array = $_POST['entry_id_array'];
        $no_seats_array = $_POST['no_seats_array'];
        $from_date_array = $_POST['from_date_array'];
        $to_date_array = $_POST['to_date_array'];
        $pickup_from_array = $_POST['pickup_from_array'];
        $drop_to_array = $_POST['drop_to_array'];
        $dep_date_array = $_POST['dep_date_array'];
        $arr_date_array = $_POST['arr_date_array'];
        $ferry_type_array = $_POST['ferry_type_array'];
        $adult_array = $_POST['adult_array'];
        $child_array = $_POST['child_array'];
        $infant_array = $_POST['infant_array'];
        $checked_array = $_POST['checked_array'];
        $markup_in_array = $_POST['markup_in_array'];
        $markup_cost_array = $_POST['markup_cost_array'];
        $currency_arr = $_POST['currency_arr'];

        for($i=0;$i<sizeof($from_date_array);$i++){
            
			if($checked_array[$i] == 'true'){

                $from_date_array[$i] = get_date_db($from_date_array[$i]);
                $to_date_array[$i] = get_date_db($to_date_array[$i]);
                $dep_date_array[$i] = get_datetime_db($dep_date_array[$i]);
                $arr_date_array[$i] = get_datetime_db($arr_date_array[$i]);
				if($entry_id_array[$i] == ''){

                    $created_at = date('Y-m-d H:i');
                    $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(tariff_id) as max from ferry_tariff"));
                    $tariff_id = $sq_max['max'] + 1;
                    $sq_query = mysqlQuery("INSERT INTO `ferry_tariff`(`tariff_id`, `entry_id`, `no_of_seats`, `valid_from_date`, `valid_to_date`, `from_location`, `to_location`, `dep_date`, `arr_date`, `category`, `adult_cost`, `child_cost`, `infant_cost`,`currency_id`,`created_at`,`markup_in`,`markup_cost`) VALUES ('$tariff_id','$fentry_id','$no_seats_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$pickup_from_array[$i]','$drop_to_array[$i]','$dep_date_array[$i]','$arr_date_array[$i]','$ferry_type_array[$i]','$adult_array[$i]','$child_array[$i]','$infant_array[$i]','$currency_arr[$i]','$created_at','$markup_in_array[$i]','$markup_cost_array[$i]')");
                    if(!$sq_query){
                        echo 'error--Tariff Details not added succesfully';
                        exit;
                    }
                }
				else{
					$sq1 = mysqlQuery("UPDATE `ferry_tariff` SET `no_of_seats`='$no_seats_array[$i]',`valid_from_date`='$from_date_array[$i]',`valid_to_date`='$to_date_array[$i]',`from_location`='$pickup_from_array[$i]',`to_location`='$drop_to_array[$i]',`dep_date`='$dep_date_array[$i]',`arr_date`='$arr_date_array[$i]',`category`='$ferry_type_array[$i]',`adult_cost`='$adult_array[$i]',`child_cost`='$child_array[$i]',`infant_cost`='$infant_array[$i]',`markup_in`='$markup_in_array[$i]',`markup_cost`='$markup_cost_array[$i]',`currency_id`='$currency_arr[$i]' WHERE tariff_id='$entry_id_array[$i]'");
					if(!$sq1){
						$GLOBALS['flag'] = false;
						echo "error--Tariff details not updated!";
					}
				}
            }
			else{
				$sq1 = mysqlQuery("DELETE FROM `ferry_tariff` WHERE `tariff_id`='$entry_id_array[$i]'");
                if(!$sq1){
                    $GLOBALS['flag'] = false;
                    echo "error--Tariff details not deleted!";
                }
			}
        }
		commit_t();
		echo "Tariff details updated!";
    }
    function search_session_save(){
        $_SESSION['ferry_array'] = json_encode($_POST['ferry_array']);
    }
}
?>