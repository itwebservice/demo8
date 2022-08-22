<?php
class quotation_email_send_backoffice{


public function quotation_email_backoffice()
{
	global $app_cancel_pdf, $theme_color, $currency, $model;
	$quotation_id = $_POST['quotation_id'];
	$email_id = $_POST['email_id'];

	$quotation_no = base64_encode($quotation_id);
	$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
	$date = $sq_quotation['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
	$sq_cost =  mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id'"));

	$basic_cost = $sq_cost['basic_amount'];
	$service_charge = $sq_cost['service_charge'];
	$service_tax_amount = 0;
	
	$name = '';
	if($sq_cost['service_tax_subtotal'] !== 0.00 && ($sq_cost['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$sq_cost['service_tax_subtotal']);
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			$service_tax = explode(':',$service_tax_subtotal1[$i]);
			$service_tax_amount +=  $service_tax[2];
			$name .= $service_tax[0] . ' ';
		}
	}
	$quotation_cost = $basic_cost + $service_charge + $service_tax_amount + $sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
	////////////////Currency conversion ////////////
	$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],$quotation_cost);

	$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
	$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));

	if($sq_emp_info['first_name']==''){
		$emp_name = 'Admin';
	}
	else{
		$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
	}

	$sq_package_program = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id ='$sq_quotation[package_id]'"));

    if($app_cancel_pdf == ''){	$url =  BASE_URL.'view/package_booking/quotation/cancellaion_policy_msg.php'; }
	else{
		$url = explode('uploads', $app_cancel_pdf);
		$url = BASE_URL.'uploads'.$url[1];
	}	

	$content = '
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['customer_name'].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Package Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_package_program['package_name'].'(Package Tour)'.'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' to '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Quotation Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_amount1.'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
			</table>
		</tr>
		<tr>
			<td>
				<a style="font-weight:500;font-size:12px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width: 90px;text-align: center;margin:0px auto;margin-top:10px;" href="'.BASE_URL.'model/package_tour/quotation/quotation_email_template.php?quotation_id='.$quotation_no.'" >Booking Details</a>
			</td> 
			
		</tr>';
	$subject = 'Confirmed Quotation Details : ( Quotation ID : '.get_quotation_id($quotation_id,$year).', Name : '.$sq_quotation['customer_name'].' )';
	$model->app_email_send('7','Team',$email_id, $content,$subject,'1');
	echo "Quotation sent successfully!";
	exit;
}
}
?>