<?php
class book_master{

	public function calculate_cost(){

                global $app_contact_no,$currency;
                $type = $_POST['type'];
                $package_id = $_POST['package_id'];
                $travel_from = $_POST['travel_from'];
                $travel_to = $_POST['travel_to'];
                $adults = $_POST['adults'];
                $chwb = ($_POST['chwb'] == '') ? 0 : $_POST['chwb'];
                $chwob = ($_POST['chwob'] == '') ? 0 : $_POST['chwob'];
                $infant = ($_POST['infant'] == '') ? 0 : $_POST['infant'];
                $extra_bed = ($_POST['extra_bed'] == '') ? 0 : $_POST['extra_bed'];
                $package_typef = $_POST['package_typef'];
                $pax = intval($adults) + intval($chwb) + intval($chwob) + intval($extra_bed) + intval($infant);
                
                if($type == '1'){
                        $sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select currency_id,package_name from custom_package_master where `package_id`='$package_id'"));
                        $h_currency_id = $sq_tours_package['currency_id'];
                        $travel_from = get_date_db($travel_from);
                        $sq_count = mysqli_num_rows(mysqlQuery("select * from custom_package_tariff where (`from_date` <= '$travel_from' and `to_date` >= '$travel_from') and (`min_pax` <= '$pax' and `max_pax` >= '$pax') and `package_id`='$package_id'"));
                        if($sq_count > 0){

                                $sq_tariff = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_tariff where (`from_date` <= '$travel_from' and `to_date` >= '$travel_from') and (`min_pax` <= '$pax' and `max_pax` >= '$pax') and `package_id`='$package_id'"));
                                $total_cost1 = ($adults*floatval($sq_tariff['cadult'])) + ($chwob*floatval($sq_tariff['ccwob'])) + ($chwb*floatval($sq_tariff['ccwb'])) + ($infant*floatval($sq_tariff['cinfant'])) + ($extra_bed*floatval($sq_tariff['cextra']));
                                $total_cost1 = currency_conversion($h_currency_id,$currency,$total_cost1);
                                $total_cost1 = explode(' ',$total_cost1);
                                echo intval(preg_replace('/[^\d. ]/', '', $total_cost1[1])).'-'.$sq_tariff['cadult'].'-'.$sq_tariff['ccwob'].'-'.$sq_tariff['ccwb'].'-',$sq_tariff['cinfant'].'-',$sq_tariff['cextra'];
                                exit;
                        }else{
                                echo 'error--'.$package_typef.' package for '.$sq_tours_package['package_name'].' is not available, kindly contact on '.'<b>'.$app_contact_no.'</b>';
                        }
                }else{
                        $tour_group_id = $_POST['group_id'];
                        //Available seats                        
                        $sq = mysqlQuery("select capacity from tour_groups where tour_id='$package_id' and group_id='$tour_group_id' ");
                        if($row = mysqli_fetch_assoc($sq))
                        {
                                $total_seats = $row['capacity'];
                        }
                        //Tourwise traveller bookings
                        $traveler_group = array();
                        $sq_1 = mysqlQuery("select traveler_group_id from tourwise_traveler_details where tour_id='$package_id' and tour_group_id = '$tour_group_id'");
                        while($row_1 = mysqli_fetch_assoc($sq_1))
                        {
                        array_push($traveler_group,$row_1['traveler_group_id']);
                        }
                        $query = "select * from travelers_details where 1 ";
                        for($i=0; $i<sizeof($traveler_group); $i++)
                        {   
                            if($i>0){
                                $query = $query." or traveler_group_id= '$traveler_group[$i]'";
                            }
                            else{    
                                $query = $query." and (traveler_group_id= '$traveler_group[$i]'";
                            }
                        }
                        $query = $query." ) ";
                        $booked_seats = (sizeof($traveler_group) > 0) ? mysqli_num_rows(mysqlQuery($query)) : 0;  
                        //B2C Bookings
                        $b2c_booked_seats = 0;
                        $sq_group = mysqli_fetch_assoc(mysqlQuery("select from_date,to_date from tour_groups where group_id='$tour_group_id'"));
                        $from_date = $sq_group['from_date'];
                        $to_date = $sq_group['to_date'];

                        $sq_1 = mysqlQuery("select * from b2c_sale where service = 'Group Tour' and status!='Cancel'");
                        while($row_1 = mysqli_fetch_assoc($sq_1)){

                                $enq_data = json_decode($row_1['enq_data']);
                                
                                $efrom_date = date('Y-m-d', strtotime($enq_data[0]->travel_from));
                                $eto_date = date('Y-m-d', strtotime($enq_data[0]->travel_to));

                                if($package_id == $enq_data[0]->package_id && $efrom_date == $from_date && $eto_date == $to_date){
                                        $total_pax = intval($enq_data[0]->adults)+intval($enq_data[0]->chwob)+intval($enq_data[0]->chwb)+intval($enq_data[0]->infant)+intval($enq_data[0]->extra_bed);
                                        $b2c_booked_seats = $total_pax;
                                }
                        }
                        $available_seats = $total_seats - $booked_seats - $b2c_booked_seats;
                        if($pax <= $available_seats){

                                $total_cost1 = 0;
                                $sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where `tour_id`='$package_id'"));
                                $h_currency_id = $currency;
        
                                $adult_cost = $sq_tours_package['adult_cost'];
                                $child_without_cost = $sq_tours_package['child_without_cost'];
                                $child_with_cost = $sq_tours_package['child_with_cost'];
                                $with_bed_cost = $sq_tours_package['with_bed_cost'];
                                $infant_cost = $sq_tours_package['infant_cost'];
        
                                $adult_cost_total = intval($adults) * floatval($adult_cost);
                                $child_without_cost_total = intval($chwob) * floatval($child_without_cost);
                                $child_with_cost_total = intval($chwb) * floatval($child_with_cost);
                                $with_bed_cost_total = intval($extra_bed) * floatval($with_bed_cost);
                                $infant_cost_total = intval($infant) * floatval($infant_cost);
        
                                $total_cost1 = floatval($adult_cost_total) + floatval($child_without_cost_total) + floatval($child_with_cost_total) + floatval($with_bed_cost_total) + floatval($infant_cost_total);
                                if($total_cost1 != 0){
                
                                        echo intval($total_cost1).'-'.$adult_cost.'-'.$child_without_cost.'-'.$child_with_cost.'-',$infant_cost.'-',$with_bed_cost;
                                        exit;
                                }
                                else{
                                        echo 'error--'.'This tour is not available, kindly contact on '.'<b>'.$app_contact_no.'</b>';
                                }
                        }
                        else{
                                echo 'error--'.'This tour is not available, kindly contact on '.'<b>'.$app_contact_no.'</b>';
                        }
                }
	}
        public function session_save(){

                $_SESSION['type'] = $_POST['type'];
                $_SESSION['name'] = $_POST['name'];
                $_SESSION['email_id'] = $_POST['email_id'];
                $_SESSION['city_place'] = $_POST['city_place'];
                $_SESSION['country_code'] = $_POST['country_code'];
                $_SESSION['phone'] = $_POST['phone'];
                $_SESSION['enq_data_arr'] = $_POST['enq_data_arr'];
                $_SESSION['guest_arr'] = $_POST['guest_arr'];
                $_SESSION['costing_arr'] = $_POST['costing_arr'];

                $sq_settings = mysqli_fetch_assoc(mysqlQuery("select book_enquiry_button from b2c_settings"));
                $payment_gateway = json_decode($sq_settings['book_enquiry_button']);
                echo $payment_gateway[0]->p_gateway;
        }
        public function sale_save(){

                $type = $_SESSION['type'];
                $name = $_SESSION['name'];
                $email_id = $_SESSION['email_id'];
                $city_place = $_SESSION['city_place'];
                $country_code = $_SESSION['country_code'];
                $phone = $_SESSION['phone'];
                $enq_data_arr = $_SESSION['enq_data_arr'];
                $guest_arr = $_SESSION['guest_arr'];
                $costing_arr = $_SESSION['costing_arr'];
                $payment_details = $_SESSION['payment_details'];
                $date = date('Y-m-d');

                $payment_amount = $costing_arr[0]['payment_amount'];
                $total_cost = $costing_arr[0]['total_cost'];
                $total_tax = $costing_arr[0]['total_tax'];
                $tax_ledger = $costing_arr[0]['tax_ledger'];
                $coupon_amount = $costing_arr[0]['coupon_amount'];
                $net_total = $costing_arr[0]['net_total'];

                // Customer and ledger creation
                global $encrypt_decrypt, $secret_key;
                $contact_no = $encrypt_decrypt->fnEncrypt($phone, $secret_key);
                $email_id_e = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
                $sq_cust_count = mysqli_num_rows(mysqlQuery("select customer_id from customer_master where country_code = '$country_code' and contact_no = '$contact_no'"));
                if($sq_cust_count == 0){
                        $state = $costing_arr[0]['state'];
                        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(customer_id) as max from customer_master"));
                        $customer_id = $sq_max['max'] + 1;
                        
                        $sq_cust = mysqlQuery("insert into customer_master (customer_id,type,first_name, middle_name, last_name, gender, birth_date, age, country_code,contact_no,landline_no, email_id,alt_email,company_name, address, address2, city, active_flag, created_at,service_tax_no,state_id,pan_no, branch_admin_id,source) values ('$customer_id','Walkin', '$name', '', '', '', '1970-01-01', '', '$country_code','$contact_no','$phone', '$email_id_e','','', '','','$city_place', 'Active', '$date', '','$state','','1','Website')");
                        if($sq_cust){
                                $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(ledger_id) as max from ledger_master"));
                                $ledger_id = $sq_max['max'] + 1;
                                $ledger_name = $customer_id.'_'.$name;
                                
                                $sq_ledger = mysqlQuery("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type,status) values ('$ledger_id', '$ledger_name', '', '20', '0','Dr','$customer_id','customer','Active')"); 
                        }
                }else{
                        $sq_cust = mysqli_fetch_assoc(mysqlQuery("select customer_id from customer_master where country_code = '$country_code' and contact_no = '$contact_no'"));
                        $customer_id = $sq_cust['customer_id'];
                        $sq_ledger = mysqli_fetch_assoc(mysqlQuery("select ledger_id from ledger_master where customer_id='$customer_id' and user_type='customer'"));
                        $ledger_id = $sq_ledger['ledger_id'];
                }
                // Create B2C Booking
                if($sq_ledger){
                        // Booking
                        $created_at = date('Y-m-d H:i');
                        $phone_no = $country_code.$phone;
                        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(booking_id) as max from b2c_sale"));
                        $booking_id = $sq_max['max'] + 1;
                        $module_name = ($type == '1') ? 'Holiday' : 'Group Tour';

                        $enq_data_arr = json_encode($enq_data_arr,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                        $guest_arr = json_encode($guest_arr,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                        $costing_arr = json_encode($costing_arr,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

                        $sq_sale = mysqlQuery("INSERT INTO `b2c_sale`(`booking_id`, `service`, `name`, `email_id`, `city`, `phone_no`, `enq_data`, `guest_data`, `costing_data`, `created_at`, `customer_id`) VALUES ('$booking_id','$module_name','$name','$email_id','$city_place','$phone_no','$enq_data_arr','$guest_arr','$costing_arr','$created_at','$customer_id')");
                        
                        // Payment
                        if($sq_sale){
                                $payment_details = json_encode($payment_details);
                                $payment_details = json_decode($payment_details);
                                $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from b2c_payment_master"));
                                $entry_id1 = $sq_max['max'] + 1;

                                $sq_fin = mysqli_fetch_assoc(mysqlQuery("select max(financial_year_id) as max from financial_year"));
                                $sq_settings = mysqli_fetch_assoc(mysqlQuery("select book_enquiry_button from b2c_settings"));
                                $payment_gateway = json_decode($sq_settings['book_enquiry_button']);
                                $bank_id = $payment_gateway[0]->bank;

                                $sq_payment = mysqlQuery("insert into b2c_payment_master (`entry_id`, `payment_id`, `booking_id`, `branch_admin_id`, `financial_year_id`, `payment_date`, `payment_amount`, `payment_mode`,`bank_id`, `order_id`,`signature`) values ('$entry_id1','$payment_details->payment_id' ,'$booking_id', '1', '$sq_fin[max]', '$date', '$payment_amount', 'Online','$bank_id', '$payment_details->order_id', '$payment_details->signature') ");
                                
                                if($sq_payment){
                                        //Finance save
                                        $taxes = explode(',',$total_tax);
                                        $tax_amount = 0;
                                        for($i=0; $i<sizeof($taxes);$i++){
                                        
                                                $single_tax = explode(':',$taxes[$i]);
                                                $tax_amount += floatval($single_tax[1]);
                                        }
                                        $this->finance_save($type,$ledger_id,$booking_id,$date,'Online',$customer_id,$bank_id,$total_cost,$tax_amount,$tax_ledger,$coupon_amount,$net_total,$payment_amount);
                                        //Bank and Cash Book Save
                                        $this->bank_cash_book_save($booking_id,$date,'Online',$payment_amount,$customer_id,$entry_id1,$bank_id);
                                }
                                $this->send_booking_confirmation($booking_id,$name,$email_id,$phone,$net_total,$payment_amount,$date);
                                $this->payment_email_notification_send($booking_id, $payment_amount, 'Online', $date,$net_total,$email_id,$name);
                                //Redirection to index page
                                $url = BASE_URL;
                                $url = explode('crm',BASE_URL);
                                header("Location: ".$url[0]);
                        }
                }
        }
        public function finance_save($type,$cust_gl,$booking_id,$booking_date,$payment_mode,$customer_id,$bank_id,$total_cost,$total_tax,$tax_ledger,$coupon_amount,$net_total,$payment_amount1)
        {
                $row_spec = 'sales';
                $branch_admin_id = 1;
                $year1 = explode("-", $booking_date);
                $yr1 = $year1[0];
        
                //Getting cash/Bank Ledger
                $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
                $pay_gl = $sq_bank['ledger_id'];
                
                $service_ledger = ($type == '1') ? '91' : '59';
                global $transaction_master;
                ////////Total Amount//////
                $module_name = "B2C Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $net_total;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $net_total, $customer_id);
                $ledger_particular = get_ledger_particular('To','B2C Sales');
                $gl_id = $cust_gl;
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                ////////////Package Sale/////////////
                if($total_cost != 0){
                        $module_name = "B2C Booking";
                        $module_entry_id = $booking_id;
                        $transaction_id = "";
                        $payment_amount = $total_cost;
                        $payment_date = $booking_date;
                        $payment_particular = get_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $total_cost, $customer_id);
                        $ledger_particular = get_ledger_particular('To','B2C Sales');
                        $gl_id = $service_ledger;
                        $payment_side = "Credit";
                        $clearance_status = "";
                        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                }
                //Package Tax Amount
                if($tax_ledger != 0){
                        $tour_tax_ledgers = explode('+',$tax_ledger);
                        $total_tour_tax1 = $total_tax / 2;
                        if(sizeof($tour_tax_ledgers) == 1){
                                // Credit
                                $module_name = "B2C Booking";
                                $module_entry_id = $booking_id;
                                $transaction_id = "";
                                $payment_amount = $total_tax;
                                $payment_date = $booking_date;
                                $payment_particular = get_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $total_tax, $customer_id);    
                                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                                $gl_id = $tour_tax_ledgers[0];
                                $payment_side = "Credit";
                                $clearance_status = "";
                                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                        }
                        else{
                                for($i=0;$i<sizeof($tour_tax_ledgers);$i++){
                                        // Credit
                                        $module_name = "B2C Booking";
                                        $module_entry_id = $booking_id;
                                        $transaction_id = "";
                                        $payment_amount = $total_tour_tax1;
                                        $payment_date = $booking_date;
                                        $payment_particular = get_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $total_tour_tax1, $customer_id);    
                                        $ledger_particular = get_ledger_particular('By','Cash/Bank');
                                        $gl_id = $tour_tax_ledgers[$i];
                                        $payment_side = "Credit";
                                        $clearance_status = "";
                                        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                                }
                        }
                }
                /////////Discount////////
                $module_name = "B2C Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $coupon_amount;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $coupon_amount, $customer_id);;
                $ledger_particular = get_ledger_particular('To','B2C Sales');
                $gl_id = 36;
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                if($payment_amount1 != 0){
                        //////Bank Payment Amount///////
                        $module_name = "B2C Booking";
                        $module_entry_id = $booking_id;
                        $transaction_id = '';
                        $payment_amount = $payment_amount1;
                        $payment_date = $booking_date;
                        $payment_particular = get_sales_paid_particular('', $booking_date, $payment_amount1, $customer_id, 'Online', get_b2c_booking_id($booking_id,$yr1),'',''); 
                        $ledger_particular = get_ledger_particular('By','Cash/Bank');
                        $gl_id = $pay_gl;
                        $payment_side = "Debit";
                        $clearance_status = "";
                        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK RECEIPT');
                
                        //////Customer Payment Amount///////
                        $module_name = "B2C Booking";
                        $module_entry_id = $booking_id;
                        $transaction_id = '';
                        $payment_amount = $payment_amount1;
                        $payment_date = $booking_date;
                        $payment_particular = get_sales_paid_particular('', $booking_date, $payment_amount1, $customer_id, 'Online', get_b2c_booking_id($booking_id,$yr1),'','');
                        $ledger_particular = get_ledger_particular('By','Cash/Bank');
                        $gl_id = $cust_gl;
                        $payment_side = "Credit";
                        $clearance_status = "";
                        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK RECEIPT');
                }
        }
        
        public function bank_cash_book_save($booking_id,$used_at,$payment_mode,$payment_amount,$customer_id,$payment_id,$bank_id)
        {
                global $bank_cash_book_master;
                $payment_date = date("Y-m-d", strtotime($used_at));
                $year1 = explode("-", $payment_date);
                $yr1 =$year1[0];
                
                $module_name = "B2C Booking";
                $module_entry_id = $payment_id;
                $payment_date = $payment_date;
                $payment_amount = $payment_amount;
                $payment_mode = $payment_mode;
                $bank_name = '';
                $transaction_id = '';
                $bank_id = $bank_id;
                $particular = get_sales_paid_particular('', $payment_date, $payment_amount, $customer_id, 'Online', get_b2c_booking_id($booking_id,$yr1),'','');
                $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
                $payment_side = "Debit";
                $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

                $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type,'1');
        }
        public function send_booking_confirmation($booking_id,$name,$email_id,$phone,$net_total,$payment_amount,$date){

                global $currency;
                $enq_data_arr = $_SESSION['enq_data_arr'];
                $package_name = $enq_data_arr[0]['package_name'];
                $travel_from = $enq_data_arr[0]['travel_from'];
                $travel_to = $enq_data_arr[0]['travel_to'];
                $travel_date = $travel_from.' To '.$travel_to;
                $adults = $enq_data_arr[0]['adults'];
                $chwob = $enq_data_arr[0]['chwob'];
                $chwb = $enq_data_arr[0]['chwb'];
                $extra_bed = $enq_data_arr[0]['extra_bed'];
                $infant = $enq_data_arr[0]['infant'];
                $childs = intval($chwob) + intval($chwb);

                $yr = explode("-", $date);
                $year = $yr[0];
                $subject = 'Booking confirmation acknowledgement! ('.get_b2c_booking_id($booking_id,$year). ' )';

                $balance_amount = floatval($net_total) - floatval($payment_amount);
                $net_total = currency_conversion($currency,$currency,$net_total);
                $payment_amount = currency_conversion($currency,$currency,$payment_amount);
                $balance_amount = currency_conversion($currency,$currency,$balance_amount);
                
                $content ='
                <tr>
                        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                        <tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$package_name.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $travel_date.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;">Total Guest</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.' Adult(s),'.$childs.' Child(ren),'.$infant.' Infant(s),'.$extra_bed.' Extra Bed(s)</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$net_total.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$payment_amount.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;">Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$balance_amount.'</td></tr>
                        </table>
                </tr>';

                global $model,$app_email_id;
                //Customer mail
                $model->app_email_send('14',$name,$email_id, $content, $subject);
                if($app_email_id!=""){
                        //Admin mail
                        $model->app_email_send('14',"Team",$app_email_id, $content, $subject);
                }
        }

        public function payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date,$net_total,$email_id,$name){
                
                global $currency,$model;
                $yr = explode("-", $payment_date);
                $year = $yr[0];

                $subject = 'Payment Acknowledgement (Booking ID : '.get_b2c_booking_id($booking_id,$year).' )';
                $model->generic_payment_mail('45',$payment_amount, $payment_mode, $net_total, $payment_amount, $payment_date, '',$email_id, $subject,$name,$currency);
        }
}