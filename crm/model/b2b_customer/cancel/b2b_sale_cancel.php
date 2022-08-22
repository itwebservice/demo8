<?php
include "../../model.php";
class b2b_sale_cancel{
    function cancel(){
        
        $booking_id = $_POST['booking_id'];
        $sq_cancel = mysqlQuery("UPDATE `b2b_booking_master` SET `status` = 'Cancel' WHERE `booking_id` = $booking_id");
        if(!$sq_cancel){
			echo "error--Sorry, Cancellation not done!";
			exit;
        }
        else{
            echo "B2B booking has been successfully cancelled.";
        }
        //Cancelation notification mail send
        $this->cancel_mail_send($booking_id);
    }
    public function cancel_mail_send($booking_id){

        $sq_entry = mysqli_fetch_assoc(mysqlQuery("select created_at,fname,email_id,customer_id from b2b_booking_master where booking_id='$booking_id'"));
        $cust_email = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_entry[customer_id]'"));

        $date = $sq_entry['created_at'];
        $yr = explode("-", $date);
        $year = $yr[0];

        $subject = 'B2B Booking Cancellation Confirmation ('.get_b2b_booking_id($booking_id,$year).' )';
        global $model;

        $model->app_email_send('120',$cust_email['company_name'],$sq_entry['email_id'], '',$subject);

    }
}