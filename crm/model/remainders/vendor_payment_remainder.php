<?php
include_once('../model.php');
$due_date=date('Y-m-d');
$sq_vendor = mysqli_num_rows(mysqlQuery("select * from vendor_estimate where due_date='$due_date' and status!='Cancel'"));
if($sq_vendor > 0){

	$sq_vendor_details =  mysqlQuery("select * from vendor_estimate where due_date='$due_date' and status!='Cancel'");
	while($row_vendor=mysqli_fetch_assoc($sq_vendor_details)){

		$estimate_id = $row_vendor['estimate_id'];
		$total_cost = $row_vendor['net_total'];
		$vendor_type = $row_vendor['vendor_type'];
		$estimate_type = $row_vendor['estimate_type'];
		$vendor_type_id = $row_vendor['vendor_type_id'];

		$sq_total_paid =  mysqlQuery("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id' and estimate_type='$estimate_type' and estimate_type_id='$estimate_id'");

		while($row_paid=mysqli_fetch_assoc($sq_total_paid)){

			$paid_amount = $row_paid['sum'];
			$payment_remain = $total_cost - $paid_amount;
			if($vendor_type=="Hotel Vendor"){
				$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$vendor_type_id'"));
				$vendor_name = $sq_hotel['hotel_name'];
			}	
			if($vendor_type=="Transport Vendor"){
				$sq_transport = mysqli_fetch_assoc(mysqlQuery("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
				$vendor_name = $sq_transport['transport_agency_name'];
			}	
			if($vendor_type=="Car Rental Vendor"){
				$sq_cra_rental_vendor = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_cra_rental_vendor['vendor_name'];
			}
			if($vendor_type=="DMC Vendor"){
				$sq_dmc_vendor = mysqli_fetch_assoc(mysqlQuery("select * from dmc_master where dmc_id='$vendor_type_id'"));
				$vendor_name = $sq_dmc_vendor['company_name'];
			}
			if($vendor_type=="Visa Vendor"){
				$sq_visa_vendor = mysqli_fetch_assoc(mysqlQuery("select * from visa_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_visa_vendor['vendor_name'];
			}
			if($vendor_type=="Passport Vendor"){
				$sq_passport_vendor = mysqli_fetch_assoc(mysqlQuery("select * from passport_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_passport_vendor['vendor_name'];
			}
			if($vendor_type=="Ticket Vendor"){
				$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_vendor['vendor_name'];
			}
			if($vendor_type=="Train Ticket Vendor"){
				$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_vendor['vendor_name'];
			}
			if($vendor_type=="Itinerary Vendor"){
				$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_vendor['vendor_name'];
			}
			if($vendor_type=="Insurance Vendor"){
				$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_vendor['vendor_name'];
			}
			if($vendor_type=="Other Vendor"){
				$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from other_vendors where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_vendor['vendor_name'];
			}
			if($vendor_type=="Excursion Vendor"){
			  	$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
				$vendor_name = $sq_vendor['vendor_name'];
			}
			echo 'payment_remain : '.$payment_remain;
			if($payment_remain > 0){
				$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'vendor_payment_pending_remainder' and date='$due_date' and status='Done'"));
				if($sq_count==0){
					vendor_payment_remainder_mail($payment_remain, $estimate_id, $estimate_type, $vendor_type, $vendor_name );
				}
			}
		}
	}
	$row=mysqlQuery("SELECT max(id) as max from remainder_status");
	$value=mysqli_fetch_assoc($row);
	$max=$value['max']+1;
	$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','vendor_payment_pending_remainder','$due_date','Done')");
}

function vendor_payment_remainder_mail($payment_remain, $estimate_id, $estimate_type, $vendor_type, $vendor_name ){

	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
	global $secret_key,$encrypt_decrypt;

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select *from customer_master where customer_id='$cust_id'"));	
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$content = '
	<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Vendor name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$vendor_name.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Vendor Type</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$vendor_type.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Supplier Balance Remain</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '. $payment_remain.'</td></tr>
		</table>
		</tr>';
	$subject = 'Vendor Payment Reminder (Purchase ID :'.$estimate_id.' ).';
	global $model;
	$model->app_email_send('92',"Admin",$app_email_id, $content , $subject);
}
?>