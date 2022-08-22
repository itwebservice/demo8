<?php
include_once('../model.php');
global $model,$currency;

//Get default currency rate
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$today = date('Y-m-d');
$sq_booking = mysqlQuery("select * from b2b_booking_master where 1");
while($row_booking = mysqli_fetch_assoc($sq_booking)){
    $sq_regs = mysqli_fetch_assoc(mysqlQuery("select register_id,email_id,cp_first_name,cp_last_name,company_name from b2b_registration where customer_id='$row_booking[customer_id]' and approval_status='Approved'"));
    $sq_count = mysqli_num_rows(mysqlQuery("select * from b2b_creditlimit_master where register_id='$sq_regs[register_id]' and approval_status='Approved'"));
    if($sq_count != 0){
        $hotel_total = 0;
        $cart_checkout_data = json_decode($row_booking['cart_checkout_data']);
        for($i=0;$i<sizeof($cart_checkout_data);$i++){
            if($cart_checkout_data[$i]->service->name == 'Hotel'){
                $hotel_flag = 1;
                $tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
                $tax_amount = 0;
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
                    $room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
                    $room_cost = $room_types[2];
                    $h_currency_id = $room_types[3];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                                $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                                $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
    
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $total_amount = ($to_currency_rate!='') ? ($from_currency_rate / $to_currency_rate * $total_amount) : 0;
                
                    $hotel_total += $total_amount;
                }
            }
            if($cart_checkout_data[$i]->service->name == 'Transfer'){
    
                $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                for($j=0;$j<count(array($services));$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$services->service_arr[$j]->transfer_cost);
                    $room_cost = $transfer_cost[0];
                    $h_currency_id = $transfer_cost[1];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                                $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                                $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
    
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $total_amount = ($to_currency_rate!='') ? ($from_currency_rate / $to_currency_rate * $total_amount) : 0;
                
                    $transfer_total += $total_amount;
                }
            }
            if($cart_checkout_data[$i]->service->name == 'Activity'){
                $activity_flag = 1;
                $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                for($j=0;$j<count(array($services));$j++){
                
                    $tax_amount = 0;
                    $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$services->service_arr[$j]->transfer_type);
                    $room_cost = $transfer_cost[1];
                    $h_currency_id = $transfer_cost[2];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] === "Percentage"){
                                $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                                $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
    
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $total_amount = ($to_currency_rate!='') ? ($from_currency_rate / $to_currency_rate * $total_amount) : 0;
                
                    $activity_total += $total_amount;
                }
            }
            if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
                $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                for($j=0;$j<count(array($services));$j++){
                
                    $tax_amount = 0;
                    $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                    $package_item = explode('-',$services->service_arr[$j]->package_type);
                    $room_cost = $package_item[1];
                    $h_currency_id = $package_item[2];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                                $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                                $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
    
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $total_amount = ($to_currency_rate!='') ? ($from_currency_rate / $to_currency_rate * $total_amount) : 0;
                
                    $tours_total += $total_amount;
                }
            }
            if($cart_checkout_data[$i]->service->name == 'Ferry'){
                $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                for($j=0;$j<count(array($services));$j++){
                
                    $tax_amount = 0;
                    $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                    $package_item = explode('-',$services->service_arr[$j]->total_cost);
                    $room_cost = $package_item[0];
                    $h_currency_id = $package_item[1];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                                $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                                $tax_amount = $tax_amount + ($room_cost + $tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
    
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $total_amount = ($to_currency_rate!='') ? ($from_currency_rate / $to_currency_rate * $total_amount) : 0;
                
                    $ferry_total += $total_amount;
                }
            }
        }
        $servie_total = $servie_total + $hotel_total + $transfer_total + $activity_total + $tours_total + $ferry_total;
        if($row_booking['coupon_code'] != ''){
            $sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
            $sq_exc_count = mysqli_num_rows(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_booking[coupon_code]'"));
            if($sq_hotel_count > 0){
                $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
            }else if($sq_exc_count > 0){
                $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_booking[coupon_code]'"));
            }else{
                $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from custom_package_offers where coupon_code='$row_booking[coupon_code]'"));
            }
            if($sq_coupon['offer']=="Flat"){
                $servie_total = $servie_total - $sq_coupon['offer_amount'];
            }else{
                $servie_total = $servie_total - ($servie_total*$sq_coupon['offer_amount']/100);
            }
        }
        //Paid Amount
        $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $payment_amount = $sq_payment_info['sum'];
        
        if($row_booking['status'] == 'Cancel'){
            if($payment_amount > 0){
                if($cancel_amount >0){
                    if($payment_amount > $cancel_amount){
                        $booking_outstanding = 0;
                    }else{
                        $booking_outstanding = $cancel_amount - $payment_amount;
                    }
                }else{
                    $booking_outstanding = 0;
                }
            }
            else{
                $booking_outstanding = $cancel_amount;
            }
        }
        else{
            $booking_outstanding = $servie_total - $payment_amount;
        }
        
        // $booking_outstanding = $hotel_total - $sq_payment_info['sum'];
        if($booking_outstanding>0){
            // Get Approved Credit Limit Amount
            $sq_credit = mysqli_fetch_assoc(mysqlQuery("select credit_amount,payment_days from b2b_creditlimit_master where register_id='$sq_regs[register_id]' and approval_status='Approved' order by entry_id desc"));
            //Overdue checking
            $booking_date = get_date_db($row_booking['created_at']);
            $payment_date = date('Y-m-d', strtotime("+".$sq_credit['payment_days']." days",strtotime($booking_date)));
            //Date comparison
            if($today>$payment_date && $booking_outstanding>0){
                $yr = explode("-", $booking_date);
                $invoice_no = get_b2b_booking_id($row_booking['booking_id'],$yr[0]);
                email($invoice_no,$sq_regs['company_name'],$booking_outstanding,$sq_regs['email_id']);
            }
        }
    }
}

function email($invoice_no,$name,$booking_outstanding,$email_id){
    
    global $app_name;
    $content = '
    <tr>
        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
        <tr><td style="text-align:left;border: 1px solid #888888;">Booking ID </td>   <td style="text-align:left;border: 1px solid #888888;">'.$invoice_no.'</td></tr>
        <tr><td style="text-align:left;border: 1px solid #888888;">Outstanding Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.number_format($booking_outstanding,2).'</td></tr>
        </table>
    </tr>';
    global $model;
    $subject = 'Credit Payment Overdue Reminder : '.$app_name;
    $model->app_email_send('115',$name,$email_id, $content, $subject);
}

$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','b2b_credit_payment_overdue','$today','Done')");
?>