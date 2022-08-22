<?php 

$flag = true;
class b2b_refund_estimate{

    function refund_estimate(){

        $row_spec='sales';
        $booking_id = $_POST['booking_id'];
        $cancel_amount = $_POST['cancel_amount'];
        $total_refund_amount = $_POST['total_refund_amount'];
        global $currency;
        $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
        $to_currency_rate = $sq_to['currency_rate'];
        begin_t();

        $sq_refund = mysqlQuery("update b2b_booking_master set cancel_amount='$cancel_amount', total_refund_amount='$total_refund_amount',estimate_flag='1'  where booking_id='$booking_id'");

        if($sq_refund){
        
            $sq_refund = mysqli_fetch_assoc(mysqlQuery("select customer_id,cart_checkout_data from b2b_booking_master where booking_id='$booking_id'"));
            // ////////////// Accoutning Reflections///////////////////////////////////////////////
            $cart_checkout_data = json_decode($sq_refund['cart_checkout_data']);
            $total_hotel_cost = 0;$total_transfer_cost = 0;$total_activity_cost = 0;$total_tour_cost = 0;$total_ferry_cost = 0;
            $total_hotel_tax = 0; $total_transfer_tax = 0; $total_activity_tax = 0; $total_tour_tax = 0; $total_ferry_tax = 0;
            $total_cost = 0;
            $hotel_list_arr = array();
            $transfer_list_arr = array();
            $activity_list_arr = array();
            $tours_list_arr = array();
            $ferry_list_arr = array();
            for($i=0;$i<sizeof($cart_checkout_data);$i++){
                if($cart_checkout_data[$i]->service->name == 'Hotel'){
                    array_push($hotel_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Transfer'){
                    array_push($transfer_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Activity'){
                    array_push($activity_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
                    array_push($tours_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Ferry'){
                    array_push($ferry_list_arr,$cart_checkout_data[$i]);
                }
            }
            for($i=0;$i<sizeof($hotel_list_arr);$i++){
                $tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
                $tax_amount = 0;
                for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
                    $room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
                    $room_cat = $room_types[1];
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
                    $hotel_tax_ledger = $tax_arr[1];
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                    $total_hotel_cost += $room_cost1;
                    $total_hotel_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($transfer_list_arr);$i++){
                //Applied Tax
                $services = ($transfer_list_arr[$i]->service!='') ? $transfer_list_arr[$i]->service : [];
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
                    $transfer_tax_ledger = $tax_arr[1];
                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_transfer_cost += $room_cost1;
                    $total_transfer_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($activity_list_arr);$i++){
                //Applied Tax
                $services = ($activity_list_arr[$i]->service!='') ? $activity_list_arr[$i]->service : [];
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
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $activity_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_activity_cost += $room_cost1;
                    $total_activity_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($tours_list_arr);$i++){
                //Applied Tax
                $services = ($tours_list_arr[$i]->service!='') ? $tours_list_arr[$i]->service : [];
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
                    $tour_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_tour_cost += $room_cost1;
                    $total_tour_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($ferry_list_arr);$i++){
                //Applied Tax
                $services = ($ferry_list_arr[$i]->service!='') ? $ferry_list_arr[$i]->service : [];
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
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $ferry_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_ferry_cost += $room_cost1;
                    $total_ferry_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            if($sq_refund['coupon_code'] != ''){
                $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$sq_refund[coupon_code]'"));
                if($sq_coupon['offer']=="Flat"){
                    $total_cost = $total_cost - $sq_coupon['offer_amount'];
                }else{
                    $total_cost = $total_cost - ($total_cost*$sq_coupon['offer_amount']/100);
                }
                
            }
            ///////////////////////////////////////////////////////////////////////////////
            //Finance save
            $this->finance_save($booking_id,$total_cost,$sq_refund['customer_id'],$total_hotel_cost,$total_transfer_cost,$total_activity_cost,$total_tour_cost,$hotel_tax_ledger,$transfer_tax_ledger,$activity_tax_ledger,$tour_tax_ledger,$total_hotel_tax,$total_transfer_tax,$total_activity_tax,$total_tour_tax,$row_spec,$total_ferry_cost,$total_ferry_tax,$ferry_tax_ledger);
            
            // $this->finance_save($booking_id,$row_spec);
            if($GLOBALS['flag']){
                commit_t();
                echo "Refund estimate has been successfully saved.";
                exit;
            }
            else{
                rollback_t();
                exit;
            }
        }
        else{
            rollback_t();
            echo "Refund estimate has not been saved!";
            exit;
        }
    }

    public function finance_save($booking_id,$total_cost,$customer_id,$total_hotel_cost,$total_transfer_cost,$total_activity_cost,$total_tour_cost,$hotel_tax_ledger,$transfer_tax_ledger,$activity_tax_ledger,$tour_tax_ledger,$total_hotel_tax,$total_transfer_tax,$total_activity_tax,$total_tour_tax,$row_spec,$total_ferry_cost,$total_ferry_tax,$ferry_tax_ledger){

    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];
    
    $final_total = $_POST['final_total'];
    $main_tax_total = $_POST['main_tax_total'];
    $taxation_type = $_POST['taxation_type'];
    $total_booking = $_POST['total_booking'];
    $branch_admin_id = $_SESSION['branch_admin_id'];

    $booking_date = date("Y-m-d");
    $year2 = explode("-", $booking_date);
    $yr1 =$year2[0];

    $sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_b2b_info['customer_id'];

    //Getting customer Ledger
    $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
    $cust_gl = $sq_cust['ledger_id'];

    global $transaction_master;
    ////////////Hotel Sales/////////////
    if($total_hotel_cost != 0){
        $module_name = "B2B Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $total_hotel_cost;
        $payment_date = $booking_date;
        $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_hotel_cost, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2B Sales');
        $gl_id = 64;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }
    //Hotel Tax Amount
    if($total_hotel_tax != 0){
        $hotel_tax_ledgers = explode('+',$hotel_tax_ledger);
        $total_hotel_tax1 = $total_hotel_tax / 2;
        if(sizeof($hotel_tax_ledgers) == 1){
            // Debit
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_hotel_tax;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_hotel_tax, $customer_id);    
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $hotel_tax_ledgers[0];
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
        }
        else{
            for($i=0;$i<sizeof($hotel_tax_ledgers);$i++){
                // Debit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_hotel_tax1;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_hotel_tax1, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $hotel_tax_ledgers[$i];
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
            }
        }
    }

    ////////////Trasnfer Sale/////////////
    if($total_transfer_cost != 0){
        $module_name = "B2B Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $total_transfer_cost;
        $payment_date = $booking_date;
        $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_transfer_cost, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2B Sales');
        $gl_id = 19;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }
    //Transfer Tax Amount
    if($total_transfer_tax != 0){
        $transfer_tax_ledgers = explode('+',$transfer_tax_ledger);
        $total_transfer_tax1 = $total_transfer_tax / 2;
        if(sizeof($transfer_tax_ledgers) == 1){
            // Debit
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_transfer_tax;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_transfer_tax, $customer_id);    
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $transfer_tax_ledgers[0];
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
        }
        else{
            for($i=0;$i<sizeof($transfer_tax_ledgers);$i++){
                // Debit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_transfer_tax1;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_transfer_tax1, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $transfer_tax_ledgers[$i];
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
            }
        }
    }

    ////////////Activity Sale/////////////
    if($total_activity_cost != 0){
        $module_name = "B2B Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $total_activity_cost;
        $payment_date = $booking_date;
        $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_activity_cost, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2B Sales');
        $gl_id = 45;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }
    //Activity Tax Amount
    if($total_activity_tax != 0){
        $activity_tax_ledgers = explode('+',$activity_tax_ledger);
        $total_activity_tax1 = $total_activity_tax / 2;
        if(sizeof($activity_tax_ledgers) == 1){
            // Debit
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_activity_tax;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_activity_tax, $customer_id);    
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $activity_tax_ledgers[0];
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
        }
        else{
            for($i=0;$i<sizeof($activity_tax_ledgers);$i++){
                // Debit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_activity_tax1;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_activity_tax1, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $activity_tax_ledgers[$i];
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
            }
        }
    }
    
    ////////////Package Sale/////////////
    if($total_tour_cost != 0){
        $module_name = "B2B Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $total_tour_cost;
        $payment_date = $booking_date;
        $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_tour_cost, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2B Sales');
        $gl_id = 92;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }
    //Transfer Tax Amount
    if($total_tour_tax != 0){
        $tour_tax_ledgers = explode('+',$tour_tax_ledger);
        $total_tour_tax1 = $total_tour_tax / 2;
        if(sizeof($tour_tax_ledgers) == 1){
            // Debit
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_tour_tax;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_tour_tax, $customer_id);    
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $tour_tax_ledgers[0];
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
        }
        else{
            for($i=0;$i<sizeof($tour_tax_ledgers);$i++){
                // Debit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_tour_tax1;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_tour_tax1, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $tour_tax_ledgers[$i];
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
            }
        }
    }
    
    ////////////Ferry Sale/////////////
    if($total_ferry_cost != 0){
        $module_name = "B2B Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $total_ferry_cost;
        $payment_date = $booking_date;
        $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_ferry_cost, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2B Sales');
        $gl_id = 45;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }
    //Activity Tax Amount
    if($total_ferry_tax != 0){
        $ferry_tax_ledgers = explode('+',$ferry_tax_ledger);
        $total_ferry_tax1 = $total_ferry_tax / 2;
        if(sizeof($ferry_tax_ledgers) == 1){
            // Debit
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_ferry_tax;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_ferry_tax, $customer_id);    
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $ferry_tax_ledgers[0];
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
        }
        else{
            for($i=0;$i<sizeof($ferry_tax_ledgers);$i++){
                // Debit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_ferry_tax1;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_ferry_tax1, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $ferry_tax_ledgers[$i];
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
            }
        }
    }

    ////////Customer Sale Amount//////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $final_total;
    $payment_date = $booking_date;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $final_total, $customer_id);
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'1',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $booking_date;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $customer_id);
    $ledger_particular = '';
    $gl_id = 161;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'1',$ledger_particular,'REFUND');    

    ////////Customer Cancel Amount//////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $booking_date;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $customer_id);
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'1',$ledger_particular,'REFUND'); 
}
}