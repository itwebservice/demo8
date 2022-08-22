<?php
$flag = true;
class custom_package{
   //save
   function package_master_save($tour_type,$dest_id,$package_code,$package_name,$total_days,$total_nights,$inclusions,$exclusions, $status ,$city_name_arr, $hotel_name_arr, $hotel_type_arr,$total_days_arr,$vehicle_name_arr,$drop_arr,$drop_type_arr,$pickup_arr,$pickup_type_arr,$day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$adult_cost,$child_cost,$infant_cost,$child_with,$child_without,$extra_bed,$currency_id,$taxation_type,$taxation_id,$service_tax,$note,$dest_image){

      $created_at =date('Y-m-d H:i');

      $tour_name_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where package_name='$package_name'"));
      if($tour_name_count>0){
      echo "error--This package name already exist.";
      return false;
      exit;
      }
      $tour_name_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where package_code='$package_code'"));
      if($tour_name_count>0){
      echo "error--This package code already exist.";
      return false;
      exit;
      }

      $sq = mysqlQuery("select max(package_id) as max from custom_package_master");
      $value = mysqli_fetch_assoc($sq);
      $max_tour_id = $value['max'] + 1;
      begin_t();

      $inclusions = addslashes($inclusions);
      $exclusions = addslashes($exclusions);
      $note = addslashes($note);
      $taxation = array();
      array_push($taxation,array(
         "taxation_type"=>$taxation_type,
         "taxation_id"=>$taxation_id,
         "service_tax"=>$service_tax
      ));
      $taxation = json_encode($taxation);
      $sq = mysqlQuery("insert into custom_package_master(package_id,dest_id, package_code, package_name, total_days, total_nights,adult_cost,child_cost,infant_cost,child_with,child_without,extra_bed,inclusions,exclusions, status,created_at,tour_type,currency_id,taxation,note,dest_image) values('$max_tour_id','$dest_id', '$package_code', '$package_name', '$total_days', '$total_nights','$adult_cost','$child_cost','$infant_cost','$child_with','$child_without','$extra_bed','$inclusions','$exclusions','$status','$created_at','$tour_type','$currency_id','$taxation','$note','$dest_image')");

      if($sq){

         for($i=0; $i<sizeof($day_program_arr); $i++){

            $sq = mysqlQuery("select max(entry_id) as max from custom_package_program");
            $value = mysqli_fetch_assoc($sq);
            $max_group_id = $value['max'] + 1;

            $meal_plan_arr[$i] = mysqlREString($meal_plan_arr[$i]);
            $special_attaraction1 = addslashes($special_attaraction_arr[$i]);
            $day_program_arr1 = addslashes($day_program_arr[$i]);
            $overnight_stay1 = addslashes($overnight_stay_arr[$i]);
            $sq1 = mysqlQuery("insert into custom_package_program( entry_id, package_id, attraction, day_wise_program, stay, meal_plan)values('$max_group_id','$max_tour_id','$special_attaraction1', '$day_program_arr1', '$overnight_stay1','$meal_plan_arr[$i]')");

            if(!$sq1){
            $GLOBALS['flag'] = false;
            echo "error--Error in Package Program!";
            }
         }

         //Hotel Details
         for($i=0; $i<sizeof($city_name_arr); $i++){

            $sq = mysqlQuery("select max(entry_id) as max from custom_package_hotels");
            $value = mysqli_fetch_assoc($sq);
            $max_hotel_id = $value['max'] + 1;

            $city_name_arr[$i] = mysqlREString($city_name_arr[$i]);
            $hotel_name_arr[$i] = mysqlREString($hotel_name_arr[$i]);
            $hotel_type_arr[$i] = mysqlREString($hotel_type_arr[$i]);
            $total_days_arr[$i] = mysqlREString($total_days_arr[$i]);

            $sq2 = mysqlQuery("insert into custom_package_hotels(entry_id, package_id, city_name, hotel_name, hotel_type,total_days,image_url)values('$max_hotel_id','$max_tour_id','$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_type_arr[$i]','$total_days_arr[$i]','')");

            if(!$sq2){
            $GLOBALS['flag'] = false;
            echo "error--Error in Hotel details!";
         }
      }

      //Transport Details
      for($i=0; $i<sizeof($vehicle_name_arr); $i++){

         $sq = mysqlQuery("select max(entry_id) as max from custom_package_transport");
         $value = mysqli_fetch_assoc($sq);
         $max_tr_id = $value['max'] + 1;

         $pickup_type = explode("-",$pickup_arr[$i])[0];
         $drop_type = explode("-",$drop_arr[$i])[0];
         $pickup = explode("-",$pickup_arr[$i])[1];
         $drop = explode("-",$drop_arr[$i])[1];
         
         $sq2 = mysqlQuery("INSERT INTO `custom_package_transport`(`entry_id`, `package_id`, `vehicle_name`, `pickup`, `drop`, `pickup_type`, `drop_type`) values('$max_tr_id','$max_tour_id','$vehicle_name_arr[$i]', '$pickup', '$drop', '$pickup_type', '$drop_type')");

         if(!$sq2){
            $GLOBALS['flag'] = false;
            echo "error--Error in Transport details!";
         }
      }

      $sq_def_image = mysqli_fetch_assoc(mysqlQuery("select image_url from default_package_images where dest_id='$dest_id'"));
      $image_url = $sq_def_image['image_url'];
      $sq = mysqlQuery("select max(image_entry_id) as max from custom_package_images");
      $value = mysqli_fetch_assoc($sq);
      $max_image_id = $value['max'] + 1;
      $sq3 = mysqlQuery("insert into custom_package_images(image_entry_id, image_url, package_id)values('$max_image_id','$image_url','$max_tour_id')");
      if(!$sq3){
         $GLOBALS['flag'] = false;
         echo "error--Error in Gallary!";
      }

      if($GLOBALS['flag']){
         commit_t();
         global $b2c_flag;
         $package_fname = str_replace(' ', '_', $package_name);
         if($b2c_flag == '1'){
            $file_name = '../../../package_tours/'.$package_fname.'-'.$max_tour_id.'.php';
            $this->create_tour_file($file_name);
         }
         echo "Package Tour has been successfully saved.";
         exit;
      }
      else{
         rollback_t();
      }        
   }      

   else{
   rollback_t();
   echo "error--Package Not Saved";
   }
}


//update
function package_master_update($package_id1,$dest_id,$package_code,$package_name,$total_days,$total_nights,$transport_id,$inclusions,$exclusions, $status ,$city_name_arr, $hotel_name_arr, $hotel_type_arr,$total_days_arr,$hotel_check_arr,$vehicle_name_arr,$vehicle_check_arr,$drop_arr,$drop_type_arr,$pickup_arr,$pickup_type_arr,$tr_entry_arr,$checked_programe_arr, $day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr, $entry_id_arr,$hotel_entry_id_arr,$adult_cost,$child_cost,$infant_cost,$child_with,$child_without,$extra_bed,$currency_id,$taxation_type,$taxation_id,$service_tax,$note,$dest_image){

   $package_code = mysqlREString($package_code);
   $package_name = mysqlREString($package_name);  
   $total_days = mysqlREString($total_days); 
   $total_nights = mysqlREString($total_nights);  
   $package_id = mysqlREString($package_id1);
   $status = mysqlREString($status);

   $taxation = array();
   $taxation = json_encode($taxation);

   begin_t();
   $sq_query_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where (package_name = '$package_name' and package_id != '$package_id')"));

   if($sq_query_count > 0){ 
      $GLOBALS['flag'] = false;
      echo "error--This package name already exist.";
      exit;
   }
   $sq_query_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where (package_code = '$package_code' and package_id != '$package_id')"));

   if($sq_query_count > 0){ 
      $GLOBALS['flag'] = false;
      echo "error--This package code already exist.";
      exit;
   }

   $inclusions = addslashes($inclusions);
   $exclusions = addslashes($exclusions);
   $note = addslashes($note);
   $sq = mysqlQuery("update custom_package_master set package_code ='$package_code', package_name = '$package_name', total_days = '$total_days', total_nights = '$total_nights',adult_cost='$adult_cost',child_cost='$child_cost',infant_cost='$infant_cost',child_with='$child_with',child_without='$child_without',extra_bed='$extra_bed',inclusions='$inclusions',exclusions ='$exclusions', status ='$status', currency_id='$currency_id',taxation='$taxation',note='$note',dest_image='$dest_image' where package_id = '$package_id'");
   global $b2c_flag;
   if($b2c_flag == '1'){
      
      $sq_query = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$package_id'"));
      if($sq_query['clone']=='yes' && $sq_query['update_flag']=='0'){

         $package_fname = str_replace(' ', '_', $package_name);
         $file_name = '../../../package_tours/'.$package_fname.'-'.$package_id.'.php';
         $this->create_tour_file($file_name);
      }
   }
   $sq = mysqlQuery("update custom_package_master set update_flag='1' where package_id = '$package_id'");

   if($sq){

      for($i=0; $i<sizeof($day_program_arr); $i++){

         $meal_plan_arr[$i] = mysqlREString($meal_plan_arr[$i]);
         $entry_id_arr[$i] = mysqlREString($entry_id_arr[$i]);
         $special_attaraction1 = addslashes($special_attaraction_arr[$i]);
         $day_program_arr1 = addslashes($day_program_arr[$i]);
         $overnight_stay1 = addslashes($overnight_stay_arr[$i]);

         if($checked_programe_arr[$i]=='true'){
         if($entry_id_arr[$i] == ''){
            $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from custom_package_program"));
            $id = $sq_max['max']+1;

            $sq1 = mysqlQuery("insert into custom_package_program( entry_id, package_id, attraction, day_wise_program, stay, meal_plan)values('$id','$package_id','$special_attaraction1', '$day_program_arr1', '$overnight_stay1','$meal_plan_arr[$i]')");
            if(!$sq1){
               echo "error--Tour Itinerary not saved!";
               exit;
               }
         }
         else{
            $query_pckg = "update custom_package_program set day_wise_program = '$day_program_arr1', attraction = '$special_attaraction1', stay = '$overnight_stay1',meal_plan='$meal_plan_arr[$i]' where entry_id='$entry_id_arr[$i]'";   
         
            $sq1 = mysqlQuery($query_pckg);
            if(!$sq1){
               $GLOBALS['flag'] = false;
               echo "error--Error in package program!";
            }
         }
      }else{
         $sq_iti = mysqlQuery("Delete from custom_package_program where entry_id='$entry_id_arr[$i]'");
         if(!$sq_iti){
            echo "error--Itinarary not updated!";
            exit;
            }
      }
      }
      //Hotel
      for($i=0; $i<sizeof($city_name_arr); $i++){

         $city_name_arr[$i] = mysqlREString($city_name_arr[$i]);
         $hotel_name_arr[$i] = mysqlREString($hotel_name_arr[$i]);
         $hotel_type_arr[$i] = mysqlREString($hotel_type_arr[$i]);
         $total_days_arr[$i] = mysqlREString($total_days_arr[$i]);
         $hotel_check_arr[$i] = mysqlREString($hotel_check_arr[$i]);
         $hotel_entry_id_arr[$i] = mysqlREString($hotel_entry_id_arr[$i]);

         if($hotel_check_arr[$i] == 'true'){
            if($hotel_entry_id_arr[$i] != ''){
               $sq2 = mysqlQuery("update custom_package_hotels set city_name = '$city_name_arr[$i]', hotel_name = '$hotel_name_arr[$i]', hotel_type = '$hotel_type_arr[$i]',total_days = '$total_days_arr[$i]' where entry_id='$hotel_entry_id_arr[$i]'");
            }
            else{
               $sq = mysqlQuery("select max(entry_id) as max from custom_package_hotels");
               $value = mysqli_fetch_assoc($sq);
               $max_hotel_id = $value['max'] + 1;
               $sq2 = mysqlQuery("insert into custom_package_hotels(entry_id, package_id, city_name, hotel_name, hotel_type,total_days,image_url)values('$max_hotel_id','$package_id','$city_name_arr[$i]', '$hotel_name_arr[$i]', '$hotel_type_arr[$i]','$total_days_arr[$i]','')");
            }
         }
         else{
            $sq2 = mysqlQuery("delete from custom_package_hotels where entry_id='$hotel_entry_id_arr[$i]'");
         }
         
         if(!$sq2){
         $GLOBALS['flag'] = false;
         echo "error--Error in Hotel details!";
         }
      }
      
      //Transport Details
      $pickup_arr[$i] = mysqlREString($pickup_arr[$i]);
      $pickup_type_arr[$i] = mysqlREString($pickup_type_arr[$i]);
      $drop_arr[$i] = mysqlREString($drop_arr[$i]);
      $drop_type_arr[$i] = mysqlREString($drop_type_arr[$i]);
      $vehicle_check_arr[$i] = mysqlREString($vehicle_check_arr[$i]);
      $vehicle_name_arr[$i] = mysqlREString($vehicle_name_arr[$i]);
      $tr_entry_arr[$i] = mysqlREString($tr_entry_arr[$i]);
      for($i=0; $i<sizeof($vehicle_name_arr); $i++){

         $pickup_type = explode("-",$pickup_arr[$i])[0];
         $drop_type = explode("-",$drop_arr[$i])[0];
         $pickup = explode("-",$pickup_arr[$i])[1];
         $drop = explode("-",$drop_arr[$i])[1];

         if($vehicle_check_arr[$i] == 'true'){

            if($tr_entry_arr[$i] != ''){

               $sq2 = mysqlQuery("update custom_package_transport set `vehicle_name` = '$vehicle_name_arr[$i]',`drop`='$drop',`drop_type`='$drop_type',`pickup`='$pickup',`pickup_type`='$pickup_type' where entry_id='$tr_entry_arr[$i]'");
            }
            else{
               $sq = mysqlQuery("select max(entry_id) as max from custom_package_transport");
               $value = mysqli_fetch_assoc($sq);
               $max_tr_id = $value['max'] + 1;

               $sq2 = mysqlQuery("INSERT INTO `custom_package_transport`(`entry_id`, `package_id`, `vehicle_name`, `pickup`, `pickup_type`, `drop`, `drop_type`)values('$max_tr_id','$package_id','$vehicle_name_arr[$i]', '$pickup','$pickup_type', '$drop', '$drop_type')");
               if(!$sq2){
               $GLOBALS['flag'] = false;
               echo "error--Error in Transport details!";
               }
            }
         }
         else{
            $sq2 = mysqlQuery("delete from custom_package_transport where entry_id='$tr_entry_arr[$i]'");
         }
      }

      if($GLOBALS['flag']){
         commit_t();
         echo "Package Tour has been successfully updated.";
         exit;
      }
      else{
         rollback_t();
      }
   }
   else{
   rollback_t();
   echo "error--Package Tour not updated!";
   }
}

function create_tour_file($file_name){

   global $b2c_flag;
   $myfile = fopen($file_name, "w");
   $txt = '<?php include "../tour-details.php"; ?>';

   fwrite($myfile, $txt);
   fclose($myfile);
}
  public function delete_hotel_image(){

    $image_id = $_POST['image_id'];

    $sq_delete = mysqlQuery("delete from hotel_vendor_images_entries where id='$image_id'");

    if($sq_delete){

      echo "Image Deleted";

    }



  }

}



