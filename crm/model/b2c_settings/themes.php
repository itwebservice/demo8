<?php
class cms_master{

	public function contact_form_mail_send(){

        global $app_email_id,$app_name;
        $name = $_POST['name'];
        $email_id = $_POST['email_id'];
        $phone = $_POST['phone'];
        $state = $_POST['state'];
        $message = $_POST['message'];
        $package_name = $_POST['package_name'];

        $content = '
            <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Phone Number</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$phone.'</td></tr>';
            if($state!=''){
                $content .= '<tr><td style="text-align:left;border: 1px solid #888888;"> Interested In</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$state.'</td></tr>';
            }
            if($package_name!=''){
                $content .= '<tr><td style="text-align:left;border: 1px solid #888888;"> Package Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$package_name.'</td></tr>';
            }
            $content .= '<tr><td style="text-align:left;border: 1px solid #888888;"> Message</td>   <td style="text-align:left;border: 1px solid #888888;">'.$message.'</td></tr>
            </table>
            </tr>';
        
        //Mail to Admin
        $subject = 'New message from website : '.$name;
        global $model;
        $model->app_email_send('122','Admin',$app_email_id, $content,$subject,'1');

        //Mail to Customer
        $subject = 'Thank you for reaching with us. ('.$app_name.')';
        $model->app_email_send('123',$name, $email_id, '',$subject,'1');
        echo 'Message sent successfully!';
	}
    function career_form_mail_send(){
        
        global $app_email_id,$app_name;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $file = $_POST['file'];
        $pos = $_POST['pos'];

        $content = '
            <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Contact Number</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$phone.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Position</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$pos.'</td></tr>
            </table>
            </tr>';
        
        //Mail to Admin
        $file_url = explode('crm',$file);
        $CoverURL=$file_url[1];
        $arrayAttachment=array();
        array_push($arrayAttachment,$CoverURL);
        $subject = 'New candidate profile request : '.$name;
        global $model;
        $model->new_app_email_send('124',$app_email_id,$subject,$arrayAttachment,$content,'1');

        //Mail to Customer 
        $subject = 'Thank you for reaching with us. ('.$app_name.')';
        $model->app_email_send('125',$name,$email, '',$subject,'1');
        echo 'Message sent successfully!';
    }
}