<?php
class b2c_sale_cancel{
    function cancel(){
        
        $booking_id = $_POST['booking_id'];
        $sq_cancel = mysqlQuery("UPDATE `b2c_sale` SET `status` = 'Cancel' WHERE `booking_id` = $booking_id");
        if(!$sq_cancel){
			echo "error--Sorry, Cancellation not done!";
			exit;
        }
        else{
            echo "B2C booking has been successfully cancelled.";
        }
        //Cancellation notification mail send
        $this->cancel_mail_send($booking_id);
    }
    function cancel_mail_send($booking_id)
    {
        $sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from b2c_sale where booking_id='$booking_id'"));
        $enq_data = json_decode($sq_tour['enq_data']);
        
        $tour_name = $enq_data[0]->package_name;
        $travel_from = $enq_data[0]->travel_from;
        $travel_to = $enq_data[0]->travel_to;
        $tour_date = $travel_from. ' To '.$travel_to;
        
        $date = $sq_tour['created_at'];
        $yr = explode("-", $date);
        $year = $yr[0];
    
        $content = '
        <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr>
            <td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td>
            <tr>
            <td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_date .'</td>   
            </tr>   
            </table>
        </tr>';
        $subject = 'Tour Cancellation Confirmation. ( '.get_b2c_booking_id($booking_id,$year).' ,'.$tour_name.' )';
        global $model;
        $model->app_email_send('28',$sq_tour['name'],$sq_tour['email_id'], $content,$subject);
    }
}