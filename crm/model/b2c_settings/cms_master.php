<?php
class cms_master{

	public function save(){

		$section = $_POST['section'];
		$data = json_encode($_POST['data']);
		$sq_settings = mysqli_num_rows(mysqlQuery("select * from b2c_settings"));
		if($sq_settings == '0'){

			if($section == '1'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, banner_images) values ( '1', '$data')");
			}
			
			if($section == '2'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, popular_dest) values ( '1', '$data')");
			}
			if($section == '3'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, popular_hotels) values ( '1', '$data')");
			}
			if($section == '4'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, popular_activities) values ( '1', '$data')");
			}
			if($section == '5'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, fit_tours) values ( '1', '$data')");
			}
			if($section == '6'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, footer_holidays) values ( '1', '$data')");
			}
			if($section == '7'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, book_enquiry_button) values ( '1', '$data')");
			}
			if($section == '9'){

				$data = json_decode($data);
				$terms_of_use = addslashes($data[0]->terms_of_use);
				$privacy_policy = addslashes($data[0]->privacy_policy);
				$cancellation_policy = addslashes($data[0]->cancellation_policy);
				$refund_policy = addslashes($data[0]->refund_policy);
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id,cancellation_policy,refund_policy,privacy_policy,terms_of_use) values ( '1', '$cancellation_policy','$refund_policy','$privacy_policy','$terms_of_use')");
			}
			if($section == '10'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, social_media) values ( '1', '$data')");
			}
			if($section == '11'){
				$data = json_decode($data);
				$header_strip_note = addslashes($data[0]->header_strip_note);
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, header_strip_note) values ( '1', '$header_strip_note')");
			}
			if($section == '12'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, git_tours) values ( '1', '$data')");
			}
			if($section == '14'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, gallery) values ( '1', '$data')");
			}
			if($section == '16'){
				$data = json_decode($data);
				$google_map_script = addslashes($data[0]->google_map_script);
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, google_map_script) values ( '1', '$google_map_script')");
			}
			if($section == '17'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, coupon_codes) values ( '1', '$data')");
			}
			if($section == '20'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, assoc_logos) values ( '1', '$data')");
			}
			if($section == '21'){
				$data = json_decode($data);
				$google_ana_code = addslashes($data[0]->google_ana_code);
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, google_analytics) values ( '1', '$google_ana_code')");
			}
			if($section == '21'){
				$data = json_decode($data);
				$tidio_chats = addslashes($data[0]->tidio_chats);
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, tidio_chat) values ( '1', '$tidio_chats')");
			}
			if($section == '23'){
				$sq_setting = mysqlQuery("insert into b2c_settings ( setting_id, popular_tours) values ( '1', '$data')");
			}
			if(($section == '1' ||$section == '2' ||$section == '3' ||$section == '4' ||$section == '5' ||$section == '6' ||$section == '7' ||$section == '9' ||$section == '10' ||$section == '11' ||$section == '12' ||$section == '14' ||$section == '16' ||$section == '17' ||$section == '20')){
				if($sq_setting){
					echo "sucess--B2C CMS settings saved.";
					exit;
				}
				else{
					echo "error--Sorry, B2C CMS Settings are not saved!";
				}
			}
		}
		else{
			if($section == '1'){
				$sq_setting = mysqlQuery("update b2c_settings set banner_images = '$data' where setting_id='1'");
			}
			if($section == '2'){
				$sq_setting = mysqlQuery("update b2c_settings set popular_dest = '$data' where setting_id='1'");
			}
			if($section == '3'){
				$sq_setting = mysqlQuery("update b2c_settings set popular_hotels = '$data' where setting_id='1'");
			}
			if($section == '4'){
				$sq_setting = mysqlQuery("update b2c_settings set popular_activities = '$data' where setting_id='1'");
			}
			if($section == '5'){
				$sq_setting = mysqlQuery("update b2c_settings set fit_tours = '$data' where setting_id='1'");
			}
			if($section == '6'){
				$sq_setting = mysqlQuery("update b2c_settings set footer_holidays = '$data' where setting_id='1'");
			}
			if($section == '7'){
				$sq_setting = mysqlQuery("update b2c_settings set book_enquiry_button = '$data' where setting_id='1'");
			}
			if($section == '23'){
				$sq_setting = mysqlQuery("update b2c_settings set popular_tours = '$data' where setting_id='1'");
			}
			if($section == '9'){

				$data = json_decode($data);
				$terms_of_use = addslashes($data[0]->terms_of_use);
				$privacy_policy = addslashes($data[0]->privacy_policy);
				$cancellation_policy = addslashes($data[0]->cancellation_policy);
				$refund_policy = addslashes($data[0]->refund_policy);
				$sq_setting = mysqlQuery("update b2c_settings set cancellation_policy = '$cancellation_policy',refund_policy='$refund_policy',privacy_policy='$privacy_policy',terms_of_use='$terms_of_use' where setting_id='1'");
			}
			if($section == '10'){
				$sq_setting = mysqlQuery("update b2c_settings set social_media = '$data' where setting_id='1'");
			}
			if($section == '11'){
				$data = json_decode($data);
				$header_strip_note = addslashes($data[0]->header_strip_note);
				$sq_setting = mysqlQuery("update b2c_settings set header_strip_note = '$header_strip_note' where setting_id='1'");
			}
			if($section == '12'){
				$sq_setting = mysqlQuery("update b2c_settings set git_tours = '$data' where setting_id='1'");
			}
			if($section == '14'){
				$sq_setting = mysqlQuery("update b2c_settings set gallery = '$data' where setting_id='1'");
			}
			if($section == '16'){
				$data = json_decode($data);
				$google_map_script = addslashes($data[0]->google_map_script);
				$sq_setting = mysqlQuery("update b2c_settings set google_map_script = '$google_map_script' where setting_id='1'");
			}
			if($section == '21'){
				$data = json_decode($data);
				$google_ana_code = addslashes($data[0]->google_ana_code);
				$sq_setting = mysqlQuery("update b2c_settings set google_analytics = '$google_ana_code' where setting_id='1'");
			}
			if($section == '22'){
				$data = json_decode($data);
				$tidio_chats = addslashes($data[0]->tidio_chats);
				$sq_setting = mysqlQuery("update b2c_settings set tidio_chat = '$tidio_chats' where setting_id='1'");
			}
			if($section == '17'){
				$sq_setting = mysqlQuery("update b2c_settings set coupon_codes = '$data' where setting_id='1'");
			}
			if($section == '20'){
				$sq_setting = mysqlQuery("update b2c_settings set assoc_logos = '$data' where setting_id='1'");
			}
		}
		if($section == '8'){
			
			$data = json_decode($data);
			for($j=0;$j<sizeof($data);$j++){

				$status = $data[$j]->status;
				$entry_id = $data[$j]->entry_id;
				$name = $data[$j]->name;
				$designation = $data[$j]->designation;
				$image = $data[$j]->image;
				$testm = addslashes($data[$j]->testm);

				if($status == 'true'){
					if($entry_id==''){

						$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as entry_id from b2c_testimonials"));
						$max_entry_id = $sq_max['entry_id'] + 1;
						$sq_setting = mysqlQuery("INSERT INTO `b2c_testimonials`(`entry_id`, `name`, `designation`, `testm`,`image`) VALUES ('$max_entry_id','$name','$designation','$testm','$image')");
					}else{
						$sq_setting = mysqlQuery("update `b2c_testimonials` set name='$name',designation='$designation',testm='$testm',image='$image' where entry_id='$entry_id'");
					}
				}else{
					
					$sq_setting = mysqlQuery("delete from b2c_testimonials where entry_id='$entry_id'");
					if(!$sq_setting){
						echo "error--Testimonial information not deleted!";
						exit;
					}
				}
			}
		}
		if($section == '13'){
			
			$data = json_decode($data);
			$j = 0;

			$entry_id = $data[$j]->entry_id;
			$title = $data[$j]->title;
			$image = $data[$j]->image;
			$description = addslashes($data[$j]->description);

			if($entry_id==''){
				$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as entry_id from b2c_blogs"));
				$max_entry_id = $sq_max['entry_id'] + 1;
				$sq_setting = mysqlQuery("INSERT INTO `b2c_blogs`(`entry_id`, `title`, `description`, `image`) VALUES ('$max_entry_id','$title','$description','$image')");
				if($sq_setting){
					echo "success--B2C CMS settings saved.";
					exit;
				}
				else{
					echo "error--Sorry, B2C CMS Settings are not saved!";
				}
			}else{
				$active_flag = ($data[$j]->active_flag == 'Inactive') ? '1' : '0';
				$sq_setting = mysqlQuery("update `b2c_blogs` set title='$title',description='$description',image='$image', active_flag='$active_flag' where entry_id='$entry_id'");
				if($sq_setting){
					echo "success--B2C CMS settings updated.";
					exit;
				}
				else{
					echo "error--Sorry, B2C CMS Settings are not updated!";
				}
			}
		}
		if($section == '18'){
			
			$data = json_decode($data);
			for($j=0;$j<sizeof($data);$j++){
				$entry_id = $data[$j]->entry_id;
				$page = $data[$j]->page;
				$title = addslashes($data[$j]->title);
				$desc = addslashes($data[$j]->desc);
				$keyword = addslashes($data[$j]->keyword);

				if($entry_id==''){
					$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as entry_id from b2c_meta_tags"));
					$max_entry_id = $sq_max['entry_id']+1;
					$sq_setting = mysqlQuery("INSERT INTO `b2c_meta_tags`(`entry_id`, `page`, `title`, `descriiption`, `keywords`) VALUES ('$max_entry_id','$page','$title','$desc','$keyword')");
				}else{
					$sq_setting = mysqlQuery("UPDATE `b2c_meta_tags` SET `page`='$page',`title`='$title',`descriiption`='$desc',`keywords`='$keyword' WHERE entry_id='$entry_id'");
				}
			}
		}
		
		if($section == '19'){

			$color_element = $_POST['color_element'];
			$theme_color = $_POST['theme_color'];

			if($color_element == 'text_primary_color'){
				$col_name = 'text_primary_color';
			}
			else if($color_element == 'text_secondary_color'){
				$col_name = 'text_secondary_color';
			}
			else if($color_element == 'button_color'){
				$col_name = 'button_color';
			}
			$sq_count = mysqli_num_rows(mysqlQuery("select entry_id from b2c_color_scheme"));
			if($sq_count > 0){
				$sq_color = mysqlQuery("update b2c_color_scheme set `$col_name`= '$theme_color' where entry_id='1'");
			}
			else{
				$sq_color = mysqlQuery("insert into b2c_color_scheme (`entry_id`,`$col_name`) values('1','$theme_color') ");
			}
		}
		if($section != '19'){
			if($sq_setting){
				echo "success--B2C CMS settings updated.";
				exit;
			}
			else{
				echo "error--Sorry, B2C CMS Settings are not updated!";
			}
		}else{

			if($sq_color){
				echo "Color saved successfully.";
				exit;
			}else{

				echo "Color not saved successfully.";
				exit;
			}
		}
	}

	public function delete(){
		$section_name = $_POST['section_name'];
		$banner_images = json_encode($_POST['banner_images']);
		$banner_images = json_decode($banner_images);
		if($section_name == '1'){
			$new_array = array();
			if($banner_images!=NULL){
				for($j=0;$j<sizeof($banner_images);$j++){
					$temp_object1['banner_count'] = $j+1;
					$temp_object1['image_url'] = $banner_images[$j]->image_url;
					array_push($new_array,$temp_object1);
				}
			}
			$new_array = json_encode($new_array);
			$sq_setting = mysqlQuery("update b2c_settings set banner_images = '$new_array' where setting_id='1'");
		}
		if($section_name == '14'){

			$banner_images = json_encode($_POST['banner_images']);
			$banner_images = json_decode($banner_images);
			$new_array = array();
			if($banner_images!=NULL){
				for($j=0;$j<sizeof($banner_images);$j++){
					$temp_object1['dest_id'] = $banner_images[$j]->dest_id;
					$temp_object1['image_url'] = $banner_images[$j]->image_url;
					array_push($new_array,$temp_object1);
				}
			}
			$new_array = json_encode($new_array);
			$sq_setting = mysqlQuery("update b2c_settings set gallery = '$new_array' where setting_id='1'");
		}
		if($sq_setting){
			echo "Image Deleted successfully.";
			exit;
		}
		else{
			echo "error--Sorry, Image is not deleted!";
		}
	}

}

