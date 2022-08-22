<?php
class package_master_tariff{

    function save(){

        $package_id = $_POST['package_id'];
        //TAB-1
        $hotel_type_array = $_POST['hotel_type_array'];
        $min_pax_array = $_POST['min_pax_array'];
        $max_pax_array = $_POST['max_pax_array'];
        $from_date_array = ($_POST['from_date_array']!='')?$_POST['from_date_array']:[];
        $to_date_array = ($_POST['from_date_array']!='')?$_POST['to_date_array']:[];
        $badult_array = $_POST['badult_array'];
        $bcwb_array = $_POST['bcwb_array'];
        $bcwob_array = $_POST['bcwob_array'];
        $binfant_array = $_POST['binfant_array'];
		$bextra_array = $_POST['bextra_array'];
        $cadult_array = $_POST['cadult_array'];
        $ccwb_array = $_POST['ccwb_array'];
        $cbcwob_array = $_POST['cbcwob_array'];
        $cinfant_array = $_POST['cinfant_array'];
		$cextra_array = $_POST['cextra_array'];
        
        //TAB-2
        $type_array = $_POST['type_array'];
        $offer_from_date_array = ($_POST['offer_from_date_array']!='')?$_POST['offer_from_date_array']:[];
        $offer_to_date_array = $_POST['offer_to_date_array'];
        $offer_array = $_POST['offer_array'];
        $coupon_code_array = $_POST['coupon_code_array'];
        $offer_amount_array = $_POST['offer_amount_array'];
        $agent_array = $_POST['agent_array'];
        
		for($i=0; $i<sizeof($hotel_type_array); $i++){

			$sq = mysqlQuery("select max(entry_id) as max from custom_package_tariff");
			$value = mysqli_fetch_assoc($sq);
			$max_entry_id = $value['max'] + 1;
			
			$hotel_type_array[$i] = mysqlREString($hotel_type_array[$i]);
			$min_pax_array[$i] = mysqlREString($min_pax_array[$i]);
			$max_pax_array[$i] = mysqlREString($max_pax_array[$i]);
			$from_date_array[$i] = mysqlREString($from_date_array[$i]);
			$to_date_array[$i] = mysqlREString($to_date_array[$i]);
			$badult_array[$i] = mysqlREString($badult_array[$i]);
			$bcwb_array[$i] = mysqlREString($bcwb_array[$i]);
			$bcwob_array[$i] = mysqlREString($bcwob_array[$i]);
			$binfant_array[$i] = mysqlREString($binfant_array[$i]);
			$bextra_array[$i] = mysqlREString($bextra_array[$i]);
			$cadult_array[$i] = mysqlREString($cadult_array[$i]);
			$ccwb_array[$i] = mysqlREString($ccwb_array[$i]);
			$cbcwob_array[$i] = mysqlREString($cbcwob_array[$i]);
			$cinfant_array[$i] = mysqlREString($cinfant_array[$i]);
			$cextra_array[$i] = mysqlREString($cextra_array[$i]);

			if($from_date_array[$i]!=""){  $from_date_array[$i] = date("Y-m-d", strtotime($from_date_array[$i])); }
			if($to_date_array[$i]!=""){  $to_date_array[$i] = date("Y-m-d", strtotime($to_date_array[$i])); }

			$sq1 = mysqlQuery("INSERT INTO `custom_package_tariff`(`entry_id`, `package_id`, `hotel_type`, `min_pax`, `max_pax`, `from_date`, `to_date`, `badult`, `bcwb`, `bcwob`, `binfant`, `cadult`, `ccwb`, `ccwob`, `cinfant`, `bextra`, `cextra`) VALUES ('$max_entry_id','$package_id','$hotel_type_array[$i]','$min_pax_array[$i]','$max_pax_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$badult_array[$i]','$bcwb_array[$i]','$bcwob_array[$i]','$binfant_array[$i]','$cadult_array[$i]','$ccwb_array[$i]','$cbcwob_array[$i]','$cinfant_array[$i]','$bextra_array[$i]','$cextra_array[$i]')");
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Package Tariff details not saved!";
			}
        }

		//TAB-5
		for($i=0; $i<sizeof($offer_from_date_array); $i++){
	
			$sq = mysqlQuery("select max(entry_id) as max from custom_package_offers");
			$value = mysqli_fetch_assoc($sq);
			$max_entry_id = $value['max'] + 1;
			$type_array[$i] = mysqlREString($type_array[$i]);
			$offer_from_date_array[$i] = mysqlREString($offer_from_date_array[$i]);
			$offer_to_date_array[$i] = mysqlREString($offer_to_date_array[$i]);
			$offer_array[$i] = mysqlREString($offer_array[$i]);
			$agent_array[$i] = mysqlREString($agent_array[$i]);
			$coupon_code_array[$i] = mysqlREString($coupon_code_array[$i]);
			$offer_amount_array[$i] = mysqlREString($offer_amount_array[$i]);
			
			if($offer_from_date_array[$i]!=""){  $offer_from_date_array[$i] = date("Y-m-d", strtotime($offer_from_date_array[$i])); }
			if($offer_to_date_array[$i]!=""){  $offer_to_date_array[$i] = date("Y-m-d", strtotime($offer_to_date_array[$i])); }
			$sq1 = mysqlQuery("INSERT INTO `custom_package_offers`(`entry_id`, `package_id`, `type`, `from_date`, `to_date`, `offer_in`, `coupon_code`, `offer_amount`, `agent_type`) VALUES ('$max_entry_id','$package_id','$type_array[$i]','$offer_from_date_array[$i]','$offer_to_date_array[$i]','$offer_array[$i]','$coupon_code_array[$i]','$offer_amount_array[$i]','$agent_array[$i]')");
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Offers/Coupon Tariff details not saved!";
			}
		}
		commit_t();
		echo "Package Tariff details Saved!";
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
					
				$arr = array(
					'hotel_type' => $data[0],
					'min_pax' => $data[1],
					'max_pax' => $data[2],
					'from_date' => $data[3],
					'to_date' => $data[4],
					'badult' => $data[5],
					'bcwb' => $data[6],
					'bcwob' => $data[7],
					'binfant' => $data[8],
					'bextra' => $data[9],
					'cadult'  => $data[10],
					'ccwb' => $data[11],
					'ccwob' => $data[12],
					'cinfant' => $data[13],
					'cextra' => $data[14]
					);
				array_push($pass_info_arr, $arr); 
				}
				$count++;
			}
			fclose($handle);
		}
		echo json_encode($pass_info_arr);
	}
	function update(){
		
        $package_id = $_POST['package_id'];
        //TAB-1
        $hotel_type_array = $_POST['hotel_type_array'];
        $min_pax_array = $_POST['min_pax_array'];
        $max_pax_array = $_POST['max_pax_array'];
        $from_date_array = ($_POST['from_date_array']!='')?$_POST['from_date_array']:[];
        $to_date_array = ($_POST['from_date_array']!='')?$_POST['to_date_array']:[];
        $badult_array = $_POST['badult_array'];
        $bcwb_array = $_POST['bcwb_array'];
        $bcwob_array = $_POST['bcwob_array'];
        $binfant_array = $_POST['binfant_array'];
		$bextra_array = $_POST['bextra_array'];
        $cadult_array = $_POST['cadult_array'];
        $ccwb_array = $_POST['ccwb_array'];
        $cbcwob_array = $_POST['cbcwob_array'];
        $cinfant_array = $_POST['cinfant_array'];
        $checked_array = $_POST['checked_array'];
        $entry_id_array = $_POST['entry_id_array'];
		$cextra_array = $_POST['cextra_array'];
        
        //TAB-2
        $type_array = $_POST['type_array'];
        $offer_from_date_array = ($_POST['offer_from_date_array']!='')?$_POST['offer_from_date_array']:[];
        $offer_to_date_array = $_POST['offer_to_date_array'];
        $offer_array = $_POST['offer_array'];
        $coupon_code_array = $_POST['coupon_code_array'];
        $offer_amount_array = $_POST['offer_amount_array'];
        $agent_array = $_POST['agent_array'];
        $offer_id_array = $_POST['offer_id_array'];
        $offer_checked_id_array = $_POST['offer_checked_id_array'];
        
		for($i=0; $i<sizeof($hotel_type_array); $i++){

			if($checked_array[$i] == 'true'){

				$from_date_array[$i] = mysqlREString($from_date_array[$i]);
				$to_date_array[$i] = mysqlREString($to_date_array[$i]);
				if($from_date_array[$i]!=""){  $from_date_array[$i] = date("Y-m-d", strtotime($from_date_array[$i])); }
				if($to_date_array[$i]!=""){  $to_date_array[$i] = date("Y-m-d", strtotime($to_date_array[$i])); }

				if($entry_id_array[$i] == ''){
					$sq = mysqlQuery("select max(entry_id) as max from custom_package_tariff");
					$value = mysqli_fetch_assoc($sq);
					$max_entry_id = $value['max'] + 1;
					
					$hotel_type_array[$i] = mysqlREString($hotel_type_array[$i]);
					$min_pax_array[$i] = mysqlREString($min_pax_array[$i]);
					$max_pax_array[$i] = mysqlREString($max_pax_array[$i]);
					$badult_array[$i] = mysqlREString($badult_array[$i]);
					$bcwb_array[$i] = mysqlREString($bcwb_array[$i]);
					$bcwob_array[$i] = mysqlREString($bcwob_array[$i]);
					$binfant_array[$i] = mysqlREString($binfant_array[$i]);
					$bextra_array[$i] = mysqlREString($bextra_array[$i]);
					$cadult_array[$i] = mysqlREString($cadult_array[$i]);
					$ccwb_array[$i] = mysqlREString($ccwb_array[$i]);
					$cbcwob_array[$i] = mysqlREString($cbcwob_array[$i]);
					$cinfant_array[$i] = mysqlREString($cinfant_array[$i]);
					$cextra_array[$i] = mysqlREString($cextra_array[$i]);

					$sq1 = mysqlQuery("INSERT INTO `custom_package_tariff`(`entry_id`, `package_id`, `hotel_type`, `min_pax`, `max_pax`, `from_date`, `to_date`, `badult`, `bcwb`, `bcwob`, `binfant`, `cadult`, `ccwb`, `ccwob`, `cinfant`, `bextra`, `cextra`) VALUES ('$max_entry_id','$package_id','$hotel_type_array[$i]','$min_pax_array[$i]','$max_pax_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$badult_array[$i]','$bcwb_array[$i]','$bcwob_array[$i]','$binfant_array[$i]','$cadult_array[$i]','$ccwb_array[$i]','$cbcwob_array[$i]','$cinfant_array[$i]','$bextra_array[$i]','$cextra_array[$i]')");
					if(!$sq1){
						$GLOBALS['flag'] = false;
						echo "error--Package Tariff details not saved!";
					}
				}
				else{

					$sq1 = mysqlQuery("UPDATE `custom_package_tariff` SET `hotel_type`='$hotel_type_array[$i]',`min_pax`='$min_pax_array[$i]',`max_pax`='$max_pax_array[$i]',`from_date`='$from_date_array[$i]',`to_date`='$to_date_array[$i]',`badult`='$badult_array[$i]',`bcwb`='$bcwb_array[$i]',`bcwob`='$bcwob_array[$i]',`binfant`='$binfant_array[$i]',`cadult`='$cadult_array[$i]',`ccwb`='$ccwb_array[$i]',`ccwob`='$cbcwob_array[$i]',`cinfant`='$cinfant_array[$i]', `bextra`='$bextra_array[$i]', `cextra`='$cextra_array[$i]' WHERE entry_id='$entry_id_array[$i]'");
					if(!$sq1){
						$GLOBALS['flag'] = false;
						echo "error--Package Tariff details not updated!";
					}
				}
			}
			else{
				$sq1 = mysqlQuery("DELETE FROM `custom_package_tariff` WHERE `entry_id`='$entry_id_array[$i]'");
			}
        }

		//TAB-2
		for($i=0; $i<sizeof($offer_from_date_array); $i++){
	
			if($offer_checked_id_array[$i] == 'true'){

				$offer_from_date_array[$i] = mysqlREString($offer_from_date_array[$i]);
				$offer_to_date_array[$i] = mysqlREString($offer_to_date_array[$i]);
				if($offer_from_date_array[$i]!=""){  $offer_from_date_array[$i] = date("Y-m-d", strtotime($offer_from_date_array[$i])); }
				if($offer_to_date_array[$i]!=""){  $offer_to_date_array[$i] = date("Y-m-d", strtotime($offer_to_date_array[$i])); }

				if($offer_id_array[$i] == ''){
					$sq = mysqlQuery("select max(entry_id) as max from custom_package_offers");
					$value = mysqli_fetch_assoc($sq);
					$max_entry_id = $value['max'] + 1;
					$type_array[$i] = mysqlREString($type_array[$i]);
					$offer_array[$i] = mysqlREString($offer_array[$i]);
					$agent_array[$i] = mysqlREString($agent_array[$i]);
					$coupon_code_array[$i] = mysqlREString($coupon_code_array[$i]);
					$offer_amount_array[$i] = mysqlREString($offer_amount_array[$i]);
					
					$sq1 = mysqlQuery("INSERT INTO `custom_package_offers`(`entry_id`, `package_id`, `type`, `from_date`, `to_date`, `offer_in`, `coupon_code`, `offer_amount`, `agent_type`) VALUES ('$max_entry_id','$package_id','$type_array[$i]','$offer_from_date_array[$i]','$offer_to_date_array[$i]','$offer_array[$i]','$coupon_code_array[$i]','$offer_amount_array[$i]','$agent_array[$i]')");
					if(!$sq1){
						$GLOBALS['flag'] = false;
						echo "error--Offers/Coupon Tariff details not saved!";
					}
				}else{

					$sq1 = mysqlQuery("UPDATE `custom_package_offers` SET `type`='$type_array[$i]',`from_date`='$offer_from_date_array[$i]', `to_date`='$offer_to_date_array[$i]',`offer_in`='$offer_array[$i]',`coupon_code`='$coupon_code_array[$i]', `offer_amount`='$offer_amount_array[$i]',`agent_type`='$agent_array[$i]' WHERE `entry_id`='$offer_id_array[$i]'");
					if(!$sq1){
						$GLOBALS['flag'] = false;
						echo "error--Offers/Coupon details not updated!";
					}
				}
			}else{
				$sq1 = mysqlQuery("DELETE FROM `custom_package_offers` WHERE `entry_id`='$offer_id_array[$i]'");
			}
		}
		commit_t();
		echo "Package Tariff details updated!";
	}
}