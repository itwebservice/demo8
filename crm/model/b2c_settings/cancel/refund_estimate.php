<?php 

$flag = true;
class b2c_refund_estimate{

    function refund_estimate(){

        $row_spec='sales';
        $booking_id = $_POST['booking_id'];
        $cancel_amount = $_POST['cancel_amount'];
        $total_refund_amount = $_POST['total_refund_amount'];
        begin_t();

        $sq_refund = mysqlQuery("update b2c_sale set cancel_amount='$cancel_amount', total_refund_amount='$total_refund_amount',estimate_flag='1' where booking_id='$booking_id'");

        if($sq_refund){
            $sq_b2c = mysqli_fetch_assoc(mysqlQuery("select * from b2c_sale where booking_id='$booking_id'"));
            $costing_data = json_decode($sq_b2c['costing_data']);

            $total_cost = $costing_data[0]->total_cost;
            $total_tax = $costing_data[0]->total_tax;
            $taxes = explode(',',$total_tax);
            $tax_amount = 0;
            for($i=0; $i<sizeof($taxes);$i++){
            
                    $single_tax = explode(':',$taxes[$i]);
                    $tax_amount += floatval($single_tax[1]);
            }

            $tax_ledger = $costing_data[0]->tax_ledger;
            $coupon_amount = $costing_data[0]->coupon_amount;
            $net_total = $costing_data[0]->net_total;

            ///////////////////////////////////////////////////////////////////////////////
            //Finance save
            $this->finance_save($booking_id,$sq_b2c['customer_id'],$total_cost,$tax_amount,$tax_ledger,$coupon_amount,$net_total,$row_spec,$sq_b2c['service']);
            
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

    public function finance_save($booking_id,$customer_id,$total_cost,$tax_amount,$tax_ledger,$coupon_amount,$final_total,$row_spec,$type){
        $cancel_amount = $_POST['cancel_amount'];
        $branch_admin_id = $_SESSION['branch_admin_id'];

        $booking_date = date("Y-m-d");
        $year2 = explode("-", $booking_date);
        $yr1 = $year2[0];

        //Getting customer Ledger
        $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
        $cust_gl = $sq_cust['ledger_id'];

        global $transaction_master;
        $service_ledger = ($type == 'Holiday') ? '92' : '60';
        
        ////////////Package Sale/////////////
        if($total_cost != 0){
            $module_name = "B2C Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_cost;
            $payment_date = $booking_date;
            $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $final_total, $customer_id);
            $ledger_particular = get_ledger_particular('To','B2C Sales');
            $gl_id = $service_ledger;
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
        }
        // Tax Amount
        if($tax_amount != 0){
            $tour_tax_ledgers = explode('+',$tax_ledger);
            $total_tour_tax1 = $tax_amount / 2;
            if(sizeof($tour_tax_ledgers) == 1){
                // Debit
                $module_name = "B2C Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $tax_amount;
                $payment_date = $booking_date;
                $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $final_total, $customer_id);
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $tour_tax_ledgers[0];
                $payment_side = "Debit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
            }
            else{
                for($i=0;$i<sizeof($tour_tax_ledgers);$i++){
                    // Debit
                    $module_name = "B2C Booking";
                    $module_entry_id = $booking_id;
                    $transaction_id = "";
                    $payment_amount = $total_tour_tax1;
                    $payment_date = $booking_date;
                    $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $final_total, $customer_id);
                    $ledger_particular = get_ledger_particular('By','Cash/Bank');
                    $gl_id = $tour_tax_ledgers[$i];
                    $payment_side = "Debit";
                    $clearance_status = "";
                    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
                }
            }
        }
        
        /////////Discount////////
        $module_name = "B2C Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $coupon_amount;
        $payment_date = $booking_date;
        $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $final_total, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2C Sales');
        $gl_id = 36;
        $payment_side = "Credit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

        ////////Customer Sale Amount//////
        $module_name = "B2C Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $final_total;
        $payment_date = $booking_date;
        $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $booking_date, $final_total, $customer_id);
        $ledger_particular = '';
        $gl_id = $cust_gl;
        $payment_side = "Credit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');    

        ////////Cancel Amount//////
        $module_name = "B2C Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $cancel_amount;
        $payment_date = $booking_date;
        $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $customer_id);
        $ledger_particular = '';
        $gl_id = 161;
        $payment_side = "Credit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');    

        ////////Customer Cancel Amount//////
        $module_name = "B2C Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $cancel_amount;
        $payment_date = $booking_date;
        $payment_particular = get_cancel_sales_particular(get_b2c_booking_id($booking_id,$yr1), $customer_id);
        $ledger_particular = '';
        $gl_id = $cust_gl;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND'); 
    }
}