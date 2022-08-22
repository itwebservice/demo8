<?php
include_once('../../model.php');
class quotation_email_send
{
	public function quotation_email(){

		$quotation_id_arr = $_POST['quotation_id_arr'];
		$email_option = $_POST['email_option'];
		global $currency;
		$i = 0;
		// $whatsapp_msg = '';

		global $app_name, $app_cancel_pdf,$model,$quot_note,$currency_logo,$theme_color;
		global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;	

		if($app_cancel_pdf == ''){	$url =  BASE_URL.'view/package_booking/quotation/cancellaion_policy_msg.php'; }

		else{

			$url = explode('uploads', $app_cancel_pdf);

			$url = BASE_URL.'uploads'.$url[1];

		}
		$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[0]'"));

		$sq_cost =  mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[0]'"));

		for($i=0;$i<sizeof($quotation_id_arr);$i++)
		{
			$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[$i]'"));
			$sq_cost =  mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[$i]'"));
			$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
			$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_quotation[emp_id]'"));

			if($sq_emp_info['first_name']==''){
				$emp_name = 'Admin';
			}
			else{
				$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
			}		
			
			$quotation_cost = $sq_cost['total_tour_cost'] + $sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
			////////////////Currency conversion ////////////
			$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
			
			$sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
			
			$quotation_no = base64_encode($quotation_id_arr[$i]);
			
			$content = '   
			
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Package Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_tours_package['package_name'].'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Duration</td>   <td style="text-align:left;border: 1px solid #888888;">'.($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D'.'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Quotation Cost</td><td style="text-align:left;border: 1px solid #888888;">'.$currency_amount1.'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">View Quotation</td><td style="text-align:left;border: 1px solid #888888;width:30%"><a style="color: '.$theme_color.';text-decoration: none;" href="'.BASE_URL.'model/package_tour/quotation/single_quotation.php?quotation='.$quotation_no.'">View</a></td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Travel Date</td> <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' To '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
				</table>
			</tr>	';
		}
		$content .= '
		<tr>
			<table style="width:100%;margin-top:20px">
				<tr>
					<td style="padding-left: 10px;border-bottom: 1px solid #eee;"><span style="font-weight: 600; color: '.$theme_color.'">'.$quot_note.'</span></td>
				</tr>
			</table>	
		<tr>';

		$subject = 'New Quotation : ('.$sq_tours_package['package_name'].' )';
		$model->app_email_send('8',$sq_quotation['customer_name'],$sq_quotation['email_id'], $content,$subject,'1');

		echo "Quotation successfully sent.";
		exit;
	}

	public function quotation_email_body(){

		$quotation_id_arr = $_POST['quotation_id_arr'];
		global $currency;
		$i = 0;
		// $whatsapp_msg = '';
		$base_url = BASE_URL;
		global $app_name, $app_cancel_pdf,$model,$quot_note,$currency_logo,$theme_color;
		global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;	

		if($app_cancel_pdf == ''){	$url =  BASE_URL.'view/package_booking/quotation/cancellaion_policy_msg.php'; }

		else{

			$url = explode('uploads', $app_cancel_pdf);

			$url = BASE_URL.'uploads'.$url[1];

		}
		$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[0]'"));

		$sq_cost =  mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[0]'"));

		for($i=0;$i<sizeof($quotation_id_arr);$i++)
		{
			$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[$i]'"));
			$sq_cost =  mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[$i]'"));
			$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
			$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_quotation[emp_id]'"));

			if($sq_emp_info['first_name']==''){
				$emp_name = 'Admin';
			}
			else{
				$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
			}		
			
			$quotation_cost = $sq_cost['total_tour_cost'] + $sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
			////////////////Currency conversion ////////////
			$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
			
			$sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
			
			$quotation_no = base64_encode($quotation_id_arr[$i]);
			$sq_cost =  mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[$i]'"));
			$sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
			

			$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
			$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));
			
			if($sq_emp_info['first_name']==''){
				$emp_name = 'Admin';
			}
			else{
				$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
			}

			$quotation_id=$quotation_id_arr[$i];
			$sq_package_program = mysqlQuery("select * from  package_quotation_program where quotation_id='$quotation_id_arr[$i]'");

			$sq_trans_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id_arr[$i]'"));
			$sq_hotel = mysqlQuery("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id_arr[$i]'");

			$sq_hotel_count1 = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id_arr[$i]'"));

			$sq_train_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id_arr[$i]'"));
			$sq_train = mysqlQuery("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id_arr[$i]'");
			
			$sq_plane_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id_arr[$i]'"));
  			$sq_plane = mysqlQuery("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id_arr[$i]'");

			$sq_cruise_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id_arr[$i]'"));
			$sq_train_cruise = mysqlQuery("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id_arr[$i]'");
			$sq_ex_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id_arr[$i]'"));
			$sq_ex = mysqlQuery("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id_arr[$i]'");
			$sq_query = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Quotation' and active_flag='Active'"));
			$sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
			////////////////Currency conversion ////////////
			$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
			$quotation_date = $sq_quotation['quotation_date'];
			$yr = explode("-", $quotation_date);
			$year = $yr[0];

			$discount1 = currency_conversion($currency,$sq_quotation['currency_code'],$sq_quotation['discount']);
			if($sq_quotation['discount']!=0){ $discount = $discount1.' Applied '; } else{ $discount = 'NA'; }
			$content = '   
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
					background: #009898;">PACKAGE DETAILS</td></tr>
				</table>
			</tr>
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Package Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_tours_package['package_name'].'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Duration</td>   <td style="text-align:left;border: 1px solid #888888;">'.($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D'.'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Travel Date</td> <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' To '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Quotation ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_quotation_id($sq_quotation['quotation_id'],$year).'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Discount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$discount.'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
				</table>
			</tr>	
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
					background: #009898;">PAX DETAILS</td></tr>
				</table>
			</tr>
			
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr>
						<td style="text-align:left;border: 1px solid #888888;width:30%">Adult</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['total_adult'].'</td>
						<td style="text-align:left;border: 1px solid #888888;width:30%">Child With Bed</td><td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['children_with_bed'].'</td>
					</tr>
					<tr>
						<td style="text-align:left;border: 1px solid #888888;width:30%">Child Without Bed</td> <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['children_without_bed'].'</td>
						<td style="text-align:left;border: 1px solid #888888;width:30%">Infant </td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['total_infant'].'</td>
					</tr>
					<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Total</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['total_passangers'].'</td></tr>
				</table>
			</tr>';
			$content .= '
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
					background: #009898;">TOUR ITINERARY</td></tr>
				</table>
			</tr>';
			
			$count = 0;
			
			while($row_itinarary = mysqli_fetch_assoc($sq_package_program)){
				
				$sq_day_image = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_images where quotation_id='$row_itinarary[quotation_id]' and package_id='$sq_quotation[package_id]'"));
				$day_url1 = explode(',',$sq_day_image['image_url']);
				$daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
				for($count1 = 0; $count1<sizeof($day_url1);$count1++){
					$day_url2 = explode('=',$day_url1[$count1]);
					if($day_url2[0]==$sq_quotation['package_id'] && $day_url2[1]==$row_itinarary['day_count']){
						$daywise_image = $day_url2[2];
					}
				}
					
				$count++;
				$content .= '<tr>
					<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:20%"><b>Day : </b> '.$count.'</td> 
							<td style="text-align:left;border: 1px solid #888888;width:60%"><b>Attraction : </b>'.$row_itinarary['attraction'].'</td>
						</tr>
						
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:20%"><img src="'.$daywise_image .'" class="img-responsive" style="width:200px;height:200px"></td>
							<td style="text-align:left;border: 1px solid #888888;width:60%">'.$row_itinarary['day_wise_program'].'</td> 
						</tr>
						
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:20%"><b>Overnight stay : </b>'.$row_itinarary['stay'].'</td>
							<td style="text-align:left;border: 1px solid #888888;width:60%"><b>Meal Plan : </b>'.$row_itinarary['meal_plan'].'</td>
						</tr>
					</table>
				</tr>
			';
			}
			$content .='
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
					background: #009898;">COSTING DETAILS</td></tr>
				</table>
			</tr>';
			if($sq_quotation['costing_type'] == 2){

				$sq_costing1 = mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id_arr[$i]' order by package_type");
				while($sq_costing = mysqli_fetch_assoc($sq_costing1)){

					$service_charge = $sq_costing['service_charge'];
					$total_pax = floatval($sq_quotation['total_adult'])+floatval($sq_quotation['children_with_bed'])+floatval($sq_quotation['children_without_bed'])+floatval($sq_quotation['total_infant']);
					$per_service_charge = floatval($service_charge)/floatval($total_pax);
			
					$adult_cost = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['adult_cost']+floatval($per_service_charge))));
					$child_with = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['child_with']+floatval($per_service_charge))));
					$child_without = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['child_without']+floatval($per_service_charge))));
					$infant_cost = currency_conversion($currency,$sq_quotation['currency_code'],(floatval($sq_costing['infant_cost']+floatval($per_service_charge))));
			
					$service_tax_amount = 0;
					$tax_show = '';
					$bsmValues = json_decode($sq_costing['bsmValues']);
					$name = '';
					if($sq_costing['service_tax_subtotal'] !== 0.00 && ($sq_costing['service_tax_subtotal']) !== ''){
						$service_tax_subtotal1 = explode(',',$sq_costing['service_tax_subtotal']);
						for($i1=0;$i1<sizeof($service_tax_subtotal1);$i1++){
						$service_tax = explode(':',$service_tax_subtotal1[$i1]);
						$service_tax_amount +=  $service_tax[2];
						$name .= $service_tax[0] . $service_tax[1] .', ';
						}
					}

					$travel_cost = floatval($sq_quotation['train_cost']) + floatval($sq_quotation['flight_cost']) + floatval($sq_quotation['cruise_cost']) + floatval($sq_quotation['visa_cost']) + floatval($sq_quotation['guide_cost']) + floatval($sq_quotation['misc_cost']);
					$travel_cost = currency_conversion($currency,$sq_quotation['currency_code'],$travel_cost);
					
					$basic_cost = $sq_costing['basic_amount'];
					$quotation_cost = $basic_cost + $service_charge + $service_tax_amount + $sq_quotation['train_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
					////////////////Currency conversion ////////////
					$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);

				$content .= '
				<tr>
					<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
						<tr>
							<td colspan="4" style="text-align:left;border: 1px solid #888888;width:30%">Package Type: '.$sq_costing['package_type'].' ('.$currency_amount1.')'.'</td>
						</tr>
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:30%">Adult Cost</td>  <td style="text-align:left;border: 1px solid #888888;">'.$adult_cost.'</td>
							<td style="text-align:left;border: 1px solid #888888;width:30%">Child with Bed Cost </td>   <td style="text-align:left;border: 1px solid #888888;">'.$child_with.'</td>
						</tr>
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:30%">Child w/o Bed Cost</td><td style="text-align:left;border: 1px solid #888888;">'.$child_without.'</td>
							<td style="text-align:left;border: 1px solid #888888;width:30%">Infant Cost</td> <td style="text-align:left;border: 1px solid #888888;">'.$infant_cost.'</td>
						</tr>
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:30%">Tax</td><td style="text-align:left;border: 1px solid #888888;">'.$sq_costing['service_tax_subtotal'].'</td>
							<td style="text-align:left;border: 1px solid #888888;width:30%">Travel + Other Cost </td> <td style="text-align:left;border: 1px solid #888888;">'.$travel_cost.'</td>
						</tr>
					</table>
				</tr>';
				}
			}else{
				$sq_costing1 = mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id_arr[$i]' order by package_type");
				while($sq_costing = mysqli_fetch_assoc($sq_costing1)){
					
					$basic_cost = $sq_costing['basic_amount'];
					$service_charge = $sq_costing['service_charge'];
					$tour_cost= $basic_cost + $service_charge;
					$service_tax_amount = 0;
					$bsmValues = json_decode($sq_costing['bsmValues']);
					$name = '';
					if($sq_costing['service_tax_subtotal'] !== 0.00 && ($sq_costing['service_tax_subtotal']) !== ''){
						$service_tax_subtotal1 = explode(',',$sq_costing['service_tax_subtotal']);
						for($i1=0;$i1<sizeof($service_tax_subtotal1);$i1++){
							$service_tax = explode(':',$service_tax_subtotal1[$i1]);
							$service_tax_amount +=  $service_tax[2];
							$name .= $service_tax[0] . $service_tax[1] .', ';
						}
					}
					$service_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$service_tax_amount);
					if($bsmValues[0]->service != ''){   //inclusive service charge
						$newBasic = $tour_cost + $service_tax_amount;
					}
					else{
						$newBasic = $tour_cost;
					}
					
					////////////Basic Amount Rules
					if($bsmValues[0]->basic != ''){ //inclusive markup
						$newBasic = $tour_cost + $service_tax_amount;
					}
					$quotation_cost = $basic_cost + $service_charge + $service_tax_amount + $sq_quotation['train_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
					////////////////Currency conversion ////////////
					$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);
					
					$newBasic = currency_conversion($currency,$sq_quotation['currency_code'],$newBasic);
					$travel_cost = floatval($sq_quotation['train_cost']) + floatval($sq_quotation['flight_cost']) + floatval($sq_quotation['cruise_cost']) + floatval($sq_quotation['visa_cost']) + floatval($sq_quotation['guide_cost'])+ floatval($sq_quotation['misc_cost']);
					$travel_cost = currency_conversion($currency,$sq_quotation['currency_code'],$travel_cost);
					$content .= '
					<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr><td colspan="4" style="text-align:left;border: 1px solid #888888;width:30%">'.$sq_costing['package_type'].'</td></tr>
							<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Tour Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$newBasic.'</td><td style="text-align:left;border: 1px solid #888888;width:30%">Tax </td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_costing['service_tax_subtotal'].'</td></tr>
							<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Travel and other cost</td><td style="text-align:left;border: 1px solid #888888;">'.$travel_cost.'</td><td style="text-align:left;border: 1px solid #888888;width:30%">Quotation Cost</td> <td style="text-align:left;border: 1px solid #888888;">'.$currency_amount1.'</td></tr>
						</table>
					</tr>';
				}
			}
			if($sq_hotel_count1>0){
				$content .= '   
				
				<tr>
					<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
						<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
						background: #009898;">ACCOMMODATION DETAILS</td></tr>
					</table>
				</tr>';
				$sq_package_type = mysqlQuery("select DISTINCT(package_type) from package_tour_quotation_hotel_entries where quotation_id='$quotation_id' order by package_type");
			
				while($row_hotel1 = mysqli_fetch_assoc($sq_package_type)){
				$content .= '
				<tr>
					<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<thead>
						<tr class="table-heading-row">
							<th colspan="6" style="text-align:left;border: 1px solid #888888;width:30%">Package Type - '.$row_hotel1['package_type'].'</th>
						</tr>
						<tr class="table-heading-row">
							<th style="text-align:left;border: 1px solid #888888;width:30%">City</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Hotel Name</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Hotel Category</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Check-In</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Check-Out</th>
						</tr>
					</thead>
					<tbody> 
					';
					$sq_package_type1 = mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id' and package_type='$row_hotel1[package_type]'");
					while($row_hotels = mysqli_fetch_assoc($sq_package_type1)){

						$hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotels[hotel_name]'"));
						$city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotels[city_name]'"));
					$content .='	
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:30%">'.$city_name['city_name'].'</td>
							<td style="text-align:left;border: 1px solid #888888;">'.$hotel_name['hotel_name'].'</td>
							<td style="text-align:left;border: 1px solid #888888;width:30%">'.$row_hotels['hotel_type'].'</td>   
							<td style="text-align:left;border: 1px solid #888888;">'.get_date_user($row_hotels['check_in']).'</td>
							<td style="text-align:left;border: 1px solid #888888;">'.get_date_user($row_hotels['check_out']).'</td>
						</tr>';
					}
					$content .='
						<tbody> 
					</table>
				</tr>';
				}
			}
			
			if($sq_trans_count>0){
			$content .= '   
			
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
					background: #009898;">TRANSPORT DETAILS</td></tr>
				</table>
			</tr>
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<thead>
					<tr class="table-heading-row">
						<th style="text-align:left;border: 1px solid #888888;width:30%">Vehicle</th>
						<th style="text-align:left;border: 1px solid #888888;width:30%">Start Date</th>
						<th style="text-align:left;border: 1px solid #888888;width:30%">End Date</th>
						<th style="text-align:left;border: 1px solid #888888;width:30%">Pickup Location</th>
						<th style="text-align:left;border: 1px solid #888888;width:30%">Drop Location</th>
						<th style="text-align:left;border: 1px solid #888888;width:30%">Total Vehicles</th>
					</tr>
				</thead>
				<tbody> 
				';
				while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
              
					$transport_name = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id='$row_hotel[vehicle_name]'"));
					// Pickup
					if($row_hotel['pickup_type'] == 'city'){
					  $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[pickup]'"));
					  $pickup = $row['city_name'];
					}
					else if($row_hotel['pickup_type'] == 'hotel'){
					  $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[pickup]'"));
					  $pickup = $row['hotel_name'];
					}
					else{
					  $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[pickup]'"));
					  $airport_nam = clean($row['airport_name']);
					  $airport_code = clean($row['airport_code']);
					  $pickup = $airport_nam." (".$airport_code.")";
					}
					//Drop-off
					if($row_hotel['drop_type'] == 'city'){
					  $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
					  $drop = $row['city_name'];
					}
					else if($row_hotel['drop_type'] == 'hotel'){
					  $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
					  $drop = $row['hotel_name'];
					}
					else{
					  $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
					  $airport_nam = clean($row['airport_name']);
					  $airport_code = clean($row['airport_code']);
					  $drop = $airport_nam." (".$airport_code.")";
					}
				$content .='	
					<tr>
						<td style="text-align:left;border: 1px solid #888888;width:30%">'.$transport_name['vehicle_name'].'</td>
						<td style="text-align:left;border: 1px solid #888888;">'.get_date_user($row_hotel['start_date']).'</td>
						<td style="text-align:left;border: 1px solid #888888;">'.get_date_user($row_hotel['end_date']).'</td>
						<td style="text-align:left;border: 1px solid #888888;width:30%">'.$pickup.'</td>   <td style="text-align:left;border: 1px solid #888888;">'.$drop.'</td>
						<td style="text-align:left;border: 1px solid #888888;">'.$row_hotel['vehicle_count'].'</td>
					</tr>';
				}
				$content .='
					<tbody> 
				</table>
			</tr>';
				
			}
			if($sq_plane_count>0){
				$content .= '   
				
				<tr>
					<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
						<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
						background: #009898;">FLIGHT DETAILS</td></tr>
					</table>
				</tr>
				<tr>
					<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<thead>
						<tr class="table-heading-row">
							<th style="text-align:left;border: 1px solid #888888;width:30%">From</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">To</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Airline</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Class</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Departure</th>
							<th style="text-align:left;border: 1px solid #888888;width:30%">Arrival</th>
						</tr>
					</thead>
					<tbody> 
					';
					while($row_plane = mysqli_fetch_assoc($sq_plane)){

						$sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_plane[airline_name]'"));
						$airline = ($row_plane['airline_name'] != '') ? $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' : 'NA';
						$class = ($row_plane['class']!='')?$row_plane['class']:'NA';
						
					$content .='	
						<tr>
							<td style="text-align:left;border: 1px solid #888888;width:30%">'.$row_plane['from_location'].'</td>
							<td style="text-align:left;border: 1px solid #888888;">'.$row_plane['to_location'].'</td>
							<td style="text-align:left;border: 1px solid #888888;width:30%">'.$airline.'</td> 
							<td style="text-align:left;border: 1px solid #888888;width:30%">'.$class.'</td>   
							<td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y H:i', strtotime($row_plane['dapart_time'])).'</td>
							<td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y H:i', strtotime($row_plane['arraval_time'])).'</td>
						</tr>';
					}
					$content .='
						<tbody> 
					</table>
				</tr>';
					
				}
				if($sq_train_count>0){
					$content .= '   
					<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
							background: #009898;">TRAIN DETAILS</td></tr>
						</table>
					</tr>
					<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
						<thead>
							<tr class="table-heading-row">
								<th style="text-align:left;border: 1px solid #888888;width:30%">From</th>
								<th style="text-align:left;border: 1px solid #888888;width:30%">To</th>
								<th style="text-align:left;border: 1px solid #888888;width:30%">Class Type</th>
								<th style="text-align:left;border: 1px solid #888888;width:30%">Departure</th>
								<th style="text-align:left;border: 1px solid #888888;width:30%">Arrival</th>
							</tr>
						</thead>
						<tbody> 
						';
						while($row_train = mysqli_fetch_assoc($sq_train)){
							
						$class = ($row_train['class']!='')?$row_train['class']:'NA';
							$content .='
								<tr>
									<td style="text-align:left;border: 1px solid #888888;width:30%">'.$row_train['from_location'].'</td>
									<td style="text-align:left;border: 1px solid #888888;">'.$row_train['to_location'].'</td>
									<td style="text-align:left;border: 1px solid #888888;width:30%">'.$class.'</td>   
									<td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y H:i', strtotime($row_train['departure_date'])).'</td>
									<td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y H:i', strtotime($row_train['arrival_date'])).'</td>
								</tr>';
							}
							$content .='
								<tbody> 
							</table>
						</tr>';
					}
						
						if($sq_cruise_count>0){
							$content .= '   
							
							<tr>
								<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
									<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
									background: #009898;">CRUISE DETAILS</td></tr>
								</table>
							</tr>
							<tr>
								<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
								<thead>
									<tr class="table-heading-row">
										<th style="text-align:left;border: 1px solid #888888;width:30%">Departure</th>
										<th style="text-align:left;border: 1px solid #888888;width:30%">Arrival</th>
										<th style="text-align:left;border: 1px solid #888888;width:30%">Route</th>
										<th style="text-align:left;border: 1px solid #888888;width:30%">Cabin</th>
										<th style="text-align:left;border: 1px solid #888888;width:30%">Sharing</th>
									</tr>
								</thead>
								<tbody> 
								';
								while($row_train = mysqli_fetch_assoc($sq_train_cruise)){ 
																		
								$content .='	
									<tr>
										<td style="text-align:left;border: 1px solid #888888;width:30%">'.get_datetime_user($row_train['dept_datetime']).'</td>
										<td style="text-align:left;border: 1px solid #888888;">'.get_datetime_user($row_train['arrival_datetime']).'</td>
										<td style="text-align:left;border: 1px solid #888888;width:30%">'.$row_train['route'].'</td> 
										<td style="text-align:left;border: 1px solid #888888;width:30%">'.$row_train['cabin'].'</td>   
										<td style="text-align:left;border: 1px solid #888888;">'.$row_train['sharing'].'</td>
									</tr>';
								}
								$content .='
									<tbody> 
								</table>
							</tr>';
								
							}
							
							if($sq_ex_count>0){
								$content .= '   
								
								<tr>
									<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
										<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
										background: #009898;">ACTIVITY DETAILS</td></tr>
									</table>
								</tr>
								<tr>
									<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
									<thead>
										<tr class="table-heading-row">
											<th style="text-align:left;border: 1px solid #888888;width:30%">Activity Date</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">City Name</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">Activity Name</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">Transfer option</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">Adult(s)</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">CWB</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">CWOB</th>
											<th style="text-align:left;border: 1px solid #888888;width:30%">Infant(s)</th>
										</tr>
									</thead>
									<tbody> 
									';
									while($row_ex = mysqli_fetch_assoc($sq_ex)){ 
										$sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_ex[city_name]'"));
              							$sq_ex_name = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff where entry_id='$row_ex[excursion_name]'"));
										
										$content .='	
											<tr>
												<td style="text-align:left;border: 1px solid #888888;width:30%">'.get_datetime_user($row_ex['exc_date']).'</td>
												<td style="text-align:left;border: 1px solid #888888;">'.$sq_city['city_name'].'</td>
												<td style="text-align:left;border: 1px solid #888888;width:30%">'.$sq_ex_name['excursion_name'].'</td> 
												<td style="text-align:left;border: 1px solid #888888;">'.$row_ex['transfer_option'].'</td>
												<td style="text-align:left;border: 1px solid #888888;">'.$row_ex['adult'].'</td>
												<td style="text-align:left;border: 1px solid #888888;">'.$row_ex['chwb'].'</td>
												<td style="text-align:left;border: 1px solid #888888;">'.$row_ex['chwob'].'</td>
												<td style="text-align:left;border: 1px solid #888888;">'.$row_ex['infant'].'</td>
											</tr>';
										}
										$content .='
										<tbody> 
									</table>
								</tr>';
									
								}
				$content .= '<tr>
							<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
								<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
								background: #009898;">TERMS AND CONDITION</td></tr>
							</table>
						</tr>
						<tr>
							<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
								<tr>
									<td style="text-align:left;border: 1px solid #888888;width:100%"><pre>'. $sq_query['terms_and_conditions'].'</pre></td></tr>
							</table>
						</tr>';
				$content .= '<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
							background: #009898;">INCLUSION</td></tr>
						</table>
					</tr>
					<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr>
								<td style="text-align:left;border: 1px solid #888888;width:100%"><pre>'. $sq_quotation['inclusions'].'</pre></td></tr>
						</table>
					</tr>';
					$content .= '<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
							background: #009898;">EXCLUSION</td></tr>
						</table>
					</tr>
					<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr>
								<td style="text-align:left;border: 1px solid #888888;width:100%"><pre>'. $sq_quotation['exclusions'].'</pre></td></tr>
						</table>
					</tr>';
					$content .= '<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr><td style="text-align:center;border: 1px solid #888888;width:1000%;color: #fff;
							background: #009898;">NOTE</td></tr>
						</table>
					</tr>
					<tr>
						<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
							<tr>
								<td style="text-align:left;border: 1px solid #888888;width:100%"><pre>'. $sq_tours_package['note'].'</pre></td></tr>
						</table>
					</tr>';
			// for cond end
		} 
		$content .= '
		<tr>
			<table style="width:100%;margin-top:20px">
				<tr>
					<td style="padding-left: 10px;border-bottom: 1px solid #eee;"><span style="font-weight: 600; color: '.$theme_color.'">'.$quot_note.'</span></td>
				</tr>
			</table>	
		<tr>';

		$subject = 'New Quotation : ('.$sq_tours_package['package_name'].' )';
		$model->app_email_send('8',$sq_quotation['customer_name'],$sq_quotation['email_id'], $content,$subject,'1');

		echo "Quotation successfully sent.";
		exit;
	}

	public function quotation_whatsapp(){

		$quotation_id_arr = $_POST['quotation_id_arr'];
		global $app_contact_no;
		
		$all_message = "";
		for($i=0;$i<sizeof($quotation_id_arr);$i++){
			$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[$i]'"));
			$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_quotation[emp_id]'"));
			if($sq_quotation['emp_id'] == 0){
				$contact = $app_contact_no;
			}
			else{
				$contact = $sq_emp_info['mobile_no'];
			}
			$sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));		

			$quotation_no = base64_encode($quotation_id_arr[$i]);
		$whatsapp_msg = rawurlencode('Hello Dear '.$sq_quotation['customer_name'].',
Hope you are doing great. This is package tour quotation details as per your request. We look forward to having you onboard with us.
*Destination* : '.$sq_tours_package['package_name'].'
*Duration* : '.($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D'.'
*Link* : '.BASE_URL.'model/package_tour/quotation/single_quotation.php?quotation='.$quotation_no.'
Please contact for more details : '.$contact.'
Thank you.');
			$all_message .=$whatsapp_msg;
		}
		$link = 'https://web.whatsapp.com/send?phone='.$sq_quotation['mobile_no'].'&text='.$all_message;
		echo $link;
	}
}
?>