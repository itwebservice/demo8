<?php
include "../../../model/model.php";
$register_id = $_POST['register_id'];
$customer_id = $_POST['customer_id'];
$booking_amount = $_POST['booking_amount'];
global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$sq_ccount = mysqli_num_rows(mysqlQuery("select credit_amount,payment_days from b2b_creditlimit_master where register_id='$register_id' and approval_status='Approved' order by entry_id desc"));
if($sq_ccount == 0){
    echo 'Credit Amount is not available to process the booking';
    exit;
}
else{
    //Get Approved Credit Limit Amount
    $sq_credit = mysqli_fetch_assoc(mysqlQuery("select credit_amount,payment_days from b2b_creditlimit_master where register_id='$register_id' and approval_status='Approved' order by entry_id desc"));
    //Get Booking + Payment amount to calculate outstanding amount
    $sq_booking = mysqlQuery("select * from b2b_booking_master where customer_id='$customer_id' and status!='Cancel'");
    $net_total = 0;
    $paid_amount = 0;
    while($row_booking = mysqli_fetch_assoc($sq_booking)){
        $hotel_total = 0;
        $transfer_total = 0;
        $activity_total = 0;
        $tours_total = 0;
        // $cart_checkout_data = json_decode($row_booking['cart_checkout_data']);
        $cart_checkout_data = ($row_booking['cart_checkout_data'] != '' && $row_booking['cart_checkout_data'] != 'null') ? json_decode($row_booking['cart_checkout_data']) : [];
        for($i=0;$i<sizeof($cart_checkout_data);$i++){
            if($cart_checkout_data[$i]->service->name == 'Hotel'){
                $tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
                    $room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
                    $room_cost = $room_types[2];
                    $h_currency_id = $room_types[3];
                    $tax_amount = 0;
                    
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
                    $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                
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
                    $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                
                    $transfer_total += $total_amount;
                }
            }
            if($cart_checkout_data[$i]->service->name == 'Activity'){
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
                    $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                
                    $activity_total += $total_amount;
                }
            }
            if($cart_checkout_data[$i]->service->name == 'Combo Tours'){

                $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                for($j=0;$j<count(array($services));$j++){

                    $tax_amount = 0;
                    $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                    $room_cost = $services->service_arr[$j]->total_cost;
                    $h_currency_id = $services->service_arr[$j]->currency_id;
                    
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
                    $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                
                    $tours_total += $total_amount;
                }
            }
        }
        $net_total += $hotel_total + $transfer_total + $activity_total + $tours_total;
        if($row_booking['coupon_code'] != ''){
            $sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
            if($sq_hotel_count > 0){
              $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
            }else{
              $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_booking[coupon_code]'"));
            }
            if($sq_coupon['offer']=="Flat"){
                $net_total = $net_total - $sq_coupon['offer_amount'];
            }else{
                $net_total = $net_total - ($net_total*$sq_coupon['offer_amount']/100);
            }
        }
        
        // Paid Amount
        $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $payment_amount = $sq_payment_info['sum'];
        $paid_amount +=$sq_payment_info['sum'];
        $booking_outstanding = $net_total - $payment_amount;

        //Overdue checking
        $booking_date = get_date_db($row_booking['created_at']);
        $payment_date = date('Y-m-d', strtotime("+".$sq_credit['payment_days']." days",strtotime($booking_date)));
        $todays_date = date('Y-m-d');
        
    }

    $outstanding =  $net_total - $paid_amount;
    $outstanding = ($outstanding < 0)? 0.00 : $outstanding;

    $outstanding = $outstanding + $booking_amount;
    $available_credit = $sq_credit['credit_amount'];
    if($outstanding > $available_credit){
        echo 'Your Credit limit is Lower to process the booking';
    }
    else{
        echo 'success';
    }
}
?>