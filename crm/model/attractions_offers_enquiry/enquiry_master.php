  <?php
  class enquiry_master{

  ///////////////////////***Enquiry Master Save start*********//////////////
  function enquiry_master_save(){

    $login_id = $_POST["login_id"]; 
    $enquiry_type = $_POST['enquiry_type'];
    $enquiry = $_POST['enquiry'];
    $name = $_POST["name"]; 
    $mobile_no = $_POST["mobile_no"]; 
    $landline_no = $_POST["landline_no"];
    $country_code = $_POST['country_code'];
    $email_id = $_POST["email_id"];
    $location = $_POST["location"];
    $assigned_emp_id = $_POST['assigned_emp_id'];
    $enquiry_specification = $_POST["enquiry_specification"]; 
    $enquiry_date = $_POST["enquiry_date"]; 
    $followup_date = $_POST["followup_date"];
    $reference_id = $_POST['reference_id'];
    $enquiry_content = $_POST['enquiry_content'];
    $branch_admin_id = $_POST['branch_admin_id'];
    $financial_year_id = $_POST['financial_year_id'];
    $customer_name = $_POST['customer_name'];
    $by = $_POST['by']; //enquiries saved by customer 
    $enquiry_content = json_encode($enquiry_content);

    $customer_fill = (isset($_POST['customer_fill'])) ?  true : false;
    $landline_no = $landline_no;
    if($customer_fill){
      $followup_date =  date("Y-m-d H:i");
      $enquiry_date = date("Y-m-d H:i");
      $assigned_emp_id = 1;
    }
    if($by == 'cust'){
      $cur_date = date('Y-m-d');
      $sq_fin = mysqli_fetch_assoc(mysqlQuery("select financial_year_id from financial_year where `from_date` <= '$cur_date' and `to_date` >= '$cur_date' order by `financial_year_id` desc"));
      $financial_year_id = $sq_fin['financial_year_id'];
      $enquiry = 'Strong';
    }
      if($financial_year_id == ''){
        echo "error--Sorry! Add Financial year first then take enquiry.";
        exit;
      }
    
      $sq_max_id = mysqli_fetch_assoc(mysqlQuery("select max(enquiry_id) as max from enquiry_master"));
      $enquiry_id = $sq_max_id['max']+1;

      $enquiry_date = date("Y-m-d", strtotime($enquiry_date));
      $followup_date = date("Y-m-d H:i", strtotime($followup_date));

      $name = addslashes($name);
      $enquiry_specification = addslashes($enquiry_specification);
      $sq_enquiry = mysqlQuery("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, country_code,email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content,customer_name ) values ('$enquiry_id', '$login_id', '$branch_admin_id','$financial_year_id', '$enquiry_type','$enquiry', '$name', '$mobile_no', '$landline_no', '$country_code','$email_id','$location', '$assigned_emp_id', '$enquiry_specification', '$enquiry_date', '$followup_date', '$reference_id', '$enquiry_content','$customer_name')");

      $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from enquiry_master_entries"));
      $entry_id = $sq_max['max'] + 1;

      $sq_followup = mysqlQuery("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '$followup_date','$enquiry', '$enquiry_date')");
      $sq_entryid = mysqlQuery("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id'");

      if(!$sq_enquiry){
        echo "error--Enquiry Information Not Saved.";
        exit;
      }  
      else{
        if($by != "cust"){
          $this->send_enquiry_mail($enquiry_id, $email_id, $name, $enquiry_type, $enquiry_specification,$assigned_emp_id,$mobile_no,'0');
          $this->send_sms_enquiry_master($enquiry_id, $mobile_no,$name);
        }
        echo $enquiry_type." Enquiry has been successfully saved.";
        
      }
  }
  ///////////////////////***Enquiry Master Save end*********//////////////
  function send_sms_enquiry_master($enquiry_id, $mobile_no,$name){
    global $app_contact_no;
    $message = "We have received your enquiry. Pls, contact below for more details. Inq No.".$enquiry_id."  Contact : ".$app_contact_no."";
    
    
    global $model;
    $model->send_message($mobile_no, $message);
    
  }
  ///////////////////////***Enquiry Email send start*********//////////////
  function send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name1, $enquiry_specification,$assigned_emp_id,$mobile_no,$update_flag){

    global $app_name,$app_email_id,$theme_color,$app_contact_no;
    $enqDetails = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id = ".$enquiry_id));
    $name = addslashes($name);

    $date = $enqDetails['enquiry_date'];
    $yr = explode("-", $date);
    $year =$yr[0];
		$enquiry_id_f = get_enquiry_id($enquiry_id,$year);
    $enq_content = json_decode($enqDetails['enquiry_content']);
    foreach($enq_content as $rows){
      switch($rows->name){
        case 'tour_name' : $tour_name = $rows->value;break;
        case 'total_adult' : $tour_adults = $rows->value;break;
        case 'travel_from_date' : $travel_from_date = $rows->value;break;
        case 'travel_to_date' : $travel_to_date = $rows->value;break;
        case 'children_with_bed' : $children_with_bed = $rows->value;break;
        case 'children_without_bed' : $children_without_bed = $rows->value;break;
        case 'total_infant' : $tour_infants = $rows->value;break;
      }
    }
    if($assigned_emp_id == "0"){  //md5 of "admin"
      $ass_email_id = $app_email_id;
      $ass_emp = $app_name;
      $ass_mobile = $app_contact_no;
    }
    else{
    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$assigned_emp_id'"));
    $ass_email_id = $sq_emp['email_id'];
    $ass_emp = $sq_emp['first_name'].' '.$sq_emp['last_name'];
    $ass_mobile = $sq_emp['mobile_no'];
    }
    $content = '
      <tr>
          <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_id_f.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Executive Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$ass_emp.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Mobile Number</td>   <td style="text-align:left;border: 1px solid #888888;">'.$ass_mobile.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$ass_email_id.'</td></tr>';
            if($enqDetails['enquiry_type'] == 'Package Booking' || $enqDetails['enquiry_type'] == 'Group Booking'){

              $content .= '<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$travel_from_date.' To '.$travel_to_date.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_adults.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total CWB</td>   <td style="text-align:left;border: 1px solid #888888;">'.$children_with_bed.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total CWOB</td>   <td style="text-align:left;border: 1px solid #888888;">'.$children_without_bed.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_infants.'</td></tr>';
            }
            $content  .= '</table>
              </tr>';

          if($enqDetails['enquiry_type'] == 'Package Booking'){

            $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_id from destination_master where dest_name = '$tour_name'"));
            
            $from_date = strtotime($travel_from_date);
            $to_date = strtotime($travel_to_date);
            $datediff = $to_date - $from_date;

            $total_nights = round($datediff / (60 * 60 * 24));
            $sq_package_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where dest_id = '$sq_dest[dest_id]' and total_nights='$total_nights'"));
            if($sq_package_count > 0){

              $query_p = "select * from custom_package_master where dest_id = '$sq_dest[dest_id]' and total_nights='$total_nights'";
            }else{
              
              $sq_package_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where dest_id = '$sq_dest[dest_id]' limit 0,2"));
              if($sq_package_count > 0){
                $query_p = "select * from custom_package_master where dest_id = '$sq_dest[dest_id]' limit 0,3";
              }
            }
            if($sq_package_count > 0){

              $sq_package = mysqlQuery($query_p);
              $content .= '
                <tr>
                  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                    <tr><td colspan="2" style="text-align:left;border: 1px solid #888888;">Discover related packages for '.$tour_name.'</td></tr>';
                    
                while($row_package = mysqli_fetch_assoc($sq_package)){

                  $package_id = base64_encode($row_package['package_id']);
                  $enquiry_id1 = base64_encode($enquiry_id);
                  $content .= '<tr><td style="text-align:left;border: 1px solid #888888;">'.$row_package['package_name'].' ('.$row_package['total_nights'].'N / '.$row_package['total_days'].'D)'.'</td>   <td style="text-align:left;border: 1px solid #888888;"><a style="color: '.$theme_color.';text-decoration: none;" href="'.BASE_URL.'model/attractions_offers_enquiry/package_tours_show.php?package_id='.$package_id.'&enquiry_id='.$enquiry_id1.'">View</a></td></tr>';
                }
                $content  .= '</table>
                  </tr>';
            }
        }

    $subject = 'Enquiry Acknowledgment (Enquiry ID : '.$enquiry_id_f.' ).';
    global $model;
    $this->send_emp_enquiry_mail($enquiry_id,$assigned_emp_id,$name);
    if($update_flag == '0'){
      $model->app_email_send('4',$name,$email_id, $content,$subject,'1');
    }
  }
  ///////////////////////***Enquiry Email send end*********//////////////


  ///////////////////////***Enquiry Assighned Email send start*********//////////////
  function send_emp_enquiry_mail($enquiry_id, $assigned_emp_id,$name)
  {
    global $app_email_id,$theme_color;
    $sq_enquiry_details = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));
    $date = $sq_enquiry_details['enquiry_date'];
    $yr = explode("-", $date);
    $year = $yr[0];
		$enquiry_id1 = get_enquiry_id($enquiry_id,$year);
    $name = addslashes($name);

    $reference = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM `references_master` where reference_id = ".$sq_enquiry_details['reference_id']));
    $Cust_name = $sq_enquiry_details['name'];
    $enquiry_type = $sq_enquiry_details['enquiry_type'];
    $assigned_emp_id = $sq_enquiry_details['assigned_emp_id'];
    $enq_content = json_decode($sq_enquiry_details['enquiry_content']);
    foreach($enq_content as $rows){
      switch($rows->name){
        case 'tour_name' : $tour_name = $rows->value;break;
        case 'total_adult' : $tour_adults = $rows->value;break;
        case 'travel_from_date' : $travel_from_date = $rows->value;break;
        case 'travel_to_date' : $travel_to_date = $rows->value;break;
        case 'total_infant' : $tour_infants = $rows->value;break;
        case 'children_with_bed' : $children_with_bed = $rows->value;break;
        case 'children_without_bed' : $children_without_bed = $rows->value;break;
        case 'hotel_type' : $hotel_type = $rows->value;break;
      }
      }

    if($assigned_emp_id == "0"){  
      $ass_email_id = $app_email_id;
      $emp_name = "Admin";
    }
    else{
    $sq_ass_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$assigned_emp_id'"));
    $emp_name = $sq_ass_emp['first_name'].' '.$sq_ass_emp['last_name'];
    $ass_email_id = $sq_ass_emp['email_id'];
    }
    $content = '
        <tr>
          <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_id1.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($sq_enquiry_details['enquiry_date']).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Customer Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$Cust_name.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Mobile No</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_enquiry_details['mobile_no'].'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_enquiry_details['email_id'].'</td></tr>';

            if($sq_enquiry_details['enquiry_type'] == 'Package Booking' || $sq_enquiry_details['enquiry_type'] == 'Group Booking'){
              $content .= '<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$travel_from_date.' To '.$travel_to_date.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_adults.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total CWB</td>   <td style="text-align:left;border: 1px solid #888888;">'.$children_with_bed.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total CWOB</td>   <td style="text-align:left;border: 1px solid #888888;">'.$children_without_bed.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Total Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_infants.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Preferred Hotels</td>   <td style="text-align:left;border: 1px solid #888888;">'.$hotel_type.'</td></tr>';
              }

  $content .= '
            <tr><td style="text-align:left;border: 1px solid #888888;">Tour Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_type.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Reference </td>   <td style="text-align:left;border: 1px solid #888888;">'.$reference['reference_name'].'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Followup Time</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_datetime_user($sq_enquiry_details['followup_date']).'</td></tr>
          
            
          </table>
        </tr>
        <tr>
          <td>
            <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                <tr>
                  <td colspan="2">
                    <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width:95px;text-align:center" href="'.BASE_URL.'" target="_blank">Sign In</a>
                  </td>
                </tr> 
            </table>
          </td>
        </tr>
    ';

  $subject = 'Enquiry Assignment : ( Enquiry ID : '.$enquiry_id1. ' , Customer Name : '.$name. ' )';

    global $model;
    $model->app_email_send('5',$emp_name,$ass_email_id, $content,$subject,'1');
  }
  ///////////////////////***Enquiry Master Update start*********//////////////
  function enquiry_master_update()
  {
    $enquiry_id = $_POST["enquiry_id"]; 
    $enquiry= $_POST["enquiry"]; 
    $mobile_no = $_POST["mobile_no"]; 
    $email_id = $_POST["email_id"];
    $location = $_POST["location"];
    $landline_no = $_POST["landline_no"];
    $country_code = $_POST['country_code'];
    $enquiry_date = $_POST['enquiry_date'];
    $followup_date = $_POST['followup_date'];
    $reference_id = $_POST['reference'];
    $enquiry_content = $_POST['enquiry_content'];
    $enquiry_content = json_encode($enquiry_content);
    $enquiry_specification = $_POST['enquiry_specification'];
    $assigned_emp_id = $_POST['assigned_emp_id'];
    $enquiry_type = $_POST['enquiry_type'];
    $name = $_POST['name'];
    $customer_dropdown = $_POST['customer_dropdown'];
    $landline_no = $landline_no;
    $enquiry_date = date('Y-m-d', strtotime($enquiry_date));
    $followup_date = date('Y-m-d H:i', strtotime($followup_date));

    $name = addslashes($name);
    $enquiry_specification = addslashes($enquiry_specification);

    $sq_enquiry = mysqlQuery("update enquiry_master set name='$name', country_code = '$country_code', mobile_no='$mobile_no',landline_no = '$landline_no',email_id='$email_id',location='$location', enquiry = '$enquiry', enquiry_date='$enquiry_date', followup_date='$followup_date', reference_id='$reference_id', enquiry_content='$enquiry_content', enquiry_specification='$enquiry_specification', assigned_emp_id ='$assigned_emp_id',customer_name='$customer_dropdown' where enquiry_id='$enquiry_id'");

    $sq_enquiry = mysqlQuery("update enquiry_master_entries set followup_date='$followup_date' where enquiry_id='$enquiry_id'");

    if(!$sq_enquiry){
      echo "error--Enquiry Information Not Updated.";
      exit;
    }  
    else{
      $this->send_enquiry_mail($enquiry_id, $email_id, $name, $enquiry_type, $enquiry_specification,$assigned_emp_id,$mobile_no,'1');
      echo $enquiry_type." Enquiry has been successfully updated.";
    }
  }
  ///////////////////////***Enquiry Master Update end*********//////////////


  ///////////////////////***Enquiry status update start*********//////////////
  function enquiry_status_update($enquiry_id)
  {
    $sq = mysqlQuery("update enquiry_master set status='Done' where enquiry_id='$enquiry_id'");
    if(!$sq){
      echo "Sorry, Status not updated.";
      exit;
    }
    else{
      echo "Enquiry has been successfully updated.";
      exit;
    }

  }
  ///////////////////////***Enquiry status update end*********//////////////


  ///////////////////////***Enquiry status update start*********//////////////
  function enquiry_status_disable($enquiry_id)
  {
    $sq = mysqlQuery("update enquiry_master set status='Disabled' where enquiry_id='$enquiry_id'");
    if(!$sq){
      echo "Sorry, Not Disabled.";
      exit;
    }
    else{
      echo "Enquiry has been successfully deleted.";
      exit;
    }
  }
  ///////////////////////***Enquiry status update end*********//////////////

  ///////////////////////***Enquiry followup save start*********//////////////
  public function followup_reply_save()
  {
    $enquiry_id = $_POST['enquiry_id'];
    $followup_reply = $_POST['followup_reply'];
    $followup_date = $_POST['followup_date'];
    $followup_type = $_POST['followup_type'];
    $followup_status = $_POST['followup_status'];
    $followup_stage = $_POST['followup_stage'];

    $followup_stage = ($followup_status == 'Converted' && $followup_stage == '') ? 'Strong' : $followup_stage;
    $followup_stage = ($followup_status == 'Dropped' && $followup_stage == '') ? 'Cold' : $followup_stage;

    
    $followup_reply = addslashes($followup_reply);
    $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from enquiry_master_entries"));
    $entry_id = $sq_max['max'];

    $created_at = date('Y-m-d H:i');
    $followup_date = date('Y-m-d H:i', strtotime($followup_date));

    $sq_entery_count = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master_entries where enquiry_id='$enquiry_id'"));
    $name = $sq_entery_count['name'];

    if($sq_entery_count['followup_reply']!=""){
      $sq_followup = mysqlQuery("update enquiry_master_entries set status='False' where enquiry_id='$enquiry_id'");
    }

    if($sq_entery_count['followup_reply']==""){
      $sq_followup = mysqlQuery("update enquiry_master_entries set followup_reply='$followup_reply',followup_date='$followup_date',followup_type='$followup_type',followup_status='$followup_status', created_at='$created_at', followup_stage='$followup_stage' where enquiry_id='$enquiry_id'");
    }
    else
    {
      $entry_id1 = $sq_max['max'] + 1;
      $sq_followup_add = mysqlQuery("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply, followup_status, followup_type, followup_date, followup_stage, created_at) values('$entry_id1', '$enquiry_id', '$followup_reply', '$followup_status','$followup_type', '$followup_date', '$followup_stage', '$created_at')");
      
      
      $sq_entryids = mysqlQuery("update enquiry_master set entry_id='$entry_id1' where enquiry_id='$enquiry_id'");
    }
    if($sq_followup_add or $sq_followup){

      if($followup_status=="Converted"){
        $this->send_enquiry_coverted_mail($enquiry_id);
        $sq_enq = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));
        $name = $sq_enq['name'];
        $this->enquiry_converted_sms_send($enquiry_id,$name);
      }

      echo "Followup status has been successfully saved";
      exit;

    }
    else{
      echo "error--Followup status not saved successfully!";
      exit;
    }

  }
  ///////////////////////***Enquiry followup save end*********//////////////

  ///////////////////////***Enquiry converted sms send start*********//////////////
  public function enquiry_converted_sms_send($enquiry_id,$name)
  {
    global $app_contact_no,$app_name;
    $sq_enquiry = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));
    $mobile_no = $sq_enquiry['mobile_no'];
    $assigned_emp_id = $sq_enquiry['assigned_emp_id'];
    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$assigned_emp_id'"));
    $first_name = $sq_emp['first_name'];
    $last_name = $sq_emp['last_name']; 


    $message = "We're thank you for enquiry with us and interested in providing the best services to make your journey awesome. Contact : ".$app_contact_no."";
    global $model;

    $model->send_message($mobile_no, $message);
  }
  ///////////////////////***Enquiry converted sms send end*********//////////////

  ///////////////////////***Enquiry converted mail send start*********//////////////
  function send_enquiry_coverted_mail($enquiry_id)
  {
    global $app_name,$app_email_id,$backoffice_email_id;
    global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

    $sq_enquiry_details = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));
    $date = $sq_enquiry_details['enquiry_date'];
    $yr = explode("-", $date);
    $year =$yr[0];
		$enquiry_id1 = get_enquiry_id($enquiry_id,$year);
    $Cust_name = $sq_enquiry_details['name'];
    $enquiry_type = $sq_enquiry_details['enquiry_type'];
    $assigned_emp_id = $sq_enquiry_details['assigned_emp_id'];

    $sq_ass_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$assigned_emp_id'"));
    $emp_name = ($assigned_emp_id == '0')? "Admin" : $sq_ass_emp['first_name'].' '.$sq_ass_emp['last_name'];

    $content = '
    <tr>
              <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_type.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enquiry_id1.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Customer Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$Cust_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Mobile No</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_enquiry_details['mobile_no'].'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_enquiry_details['email_id'].'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Executive Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
              
              </table>
            </tr>
    ';
    $subject = 'The new lead converted successfully! ( Enquiry ID : '.$enquiry_id1.' , Customer Name : '.$Cust_name.' )';
    global $model;

    $model->app_email_send('10','Admin',$app_email_id, $content,$subject,'1');

  }
  ///////////////////////***Enquiry coverted mail send end*********//////////////

  public function enquiry_csv_save()
  {
      $enq_csv_dir = $_POST['obj'];
      $branch_admin_id=$_SESSION['branch_admin_id'];
      $financial_year_id=$_SESSION['financial_year_id'];
      $login_id = $_SESSION['login_id'];
      $flag = true;

      $enq_csv_dir = explode('uploads', $enq_csv_dir);
      $enq_csv_dir = CSV_READ_URL.'uploads'.$enq_csv_dir[1];

      begin_t();
      $unprocessedArray=array();
      $arrResult  = array();
      $validCount=0;
      $invalidCount=0;
      $count = 1;
      $created_at = date('Y-m-d');

      $handle = fopen($enq_csv_dir, "r");
      if(empty($handle) === false) {
          while(($data = fgetcsv($handle,0 , ",")) !== FALSE){
            if($count == 1) { $count++; continue; }

              if($count>0){
                  
                  $sq_max_id =  mysqli_fetch_assoc(mysqlQuery("select max(enquiry_id) as max from enquiry_master"));
                  $enquiry_id = $sq_max_id['max']+1;

                  $enquiry_type = "Package Booking";
                  $name = $data[0];
                  $mobile_no = $data[1];
                  $landline_no = $data[2];
                  $email_id = $data[3];
                  $enquiry_date = $data[13];
                  $followup_date = $data[14];
                  $reference_id = $data[15];
                  $assigned_emp_id =  $data[16];
                  $enquiry = $data[17];
                  $enquiry_specification = $data[18];
                  $tour_name=$data[4];
                  $location = $data[19];
                  $enquiry_content = array(
                    array('name'=>'tour_name', 'value'=>$data[4]),
                    array('name'=>'travel_from_date', 'value'=>$data[5]),
                    array('name'=>'travel_to_date', 'value'=>$data[6]),
                    array('name'=>'budget', 'value'=>$data[7]),
                    array('name'=>'total_adult', 'value'=>$data[8]),
                    array('name'=>'children_without_bed', 'value'=>$data[9]),
                    array('name'=>'children_with_bed', 'value'=>$data[10]),
                    array('name'=>'total_infant', 'value'=>$data[11]),
                    array('name'=>'total_members', 'value'=>$data[12]),
                    array('name'=>'hotel_type', 'value'=>$data[20])
                  );
                  $enquiry_content = json_encode($enquiry_content);

                  $enquiry_date1 = date('Y-m-d', strtotime($enquiry_date));
                  $followup_date1 = date('Y-m-d H:i', strtotime($followup_date));
                  $sq_fin = mysqli_fetch_assoc(mysqlQuery("select * from financial_year where financial_year_id='$financial_year_id'"));
                
                  if($enquiry_date1 >= $sq_fin['from_date'] && $enquiry_date1 <= $sq_fin['to_date']){
                    
                    if(preg_match('/^[0-9]*$/', $assigned_emp_id) && !empty($enquiry)  && !empty($assigned_emp_id) && !empty($reference_id) && !empty($name) && !empty($data[4]) && !empty($followup_date) && !empty($data[5])){

                        $validCount++;
                        $query = "insert into enquiry_master (enquiry_id, login_id, branch_admin_id,financial_year_id, enquiry_type, enquiry, name, mobile_no,landline_no, email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content) values ('$enquiry_id', '$login_id', '$branch_admin_id','$financial_year_id', '$enquiry_type', '$enquiry', '$name', '$mobile_no', '$landline_no', '$email_id','$location', '$assigned_emp_id', '$enquiry_specification', '$enquiry_date1', '$followup_date1', '$reference_id', '$enquiry_content')";
                        $sq_enquiry = mysqlQuery($query);

                        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from enquiry_master_entries"));
                        $entry_id = $sq_max['max'] + 1;

                        $sq_followup = mysqlQuery("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '$followup_date1', '$enquiry', '$enquiry_date1')");
                        
                        $sq_entryicsv = mysqlQuery("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id'");

                        if(!$sq_enquiry){
                          echo "error--Enquiry Information Not Saved.";
                        }
                        else{
                          if($mobile_no != ''){
                            //$this->send_sms_enquiry_master($enquiry_id, $mobile_no,$name);
                          }
                        }
                    }
                    else{
                        $invalidCount++;
                        array_push($unprocessedArray, $data);
                    }
                  }
                  else{
                      $invalidCount++;
                      array_push($unprocessedArray, $data);
                  }
              }
              $count++;
            }
        
          fclose($handle);
          if(isset($unprocessedArray) && !empty($unprocessedArray))
          {
            //print_r($unprocessedArray); die;
            $filePath='../../download/unprocessed_enquiry_records'.$created_at.'.csv';
            $save = preg_replace('/(\/+)/','/',$filePath);
            //echo $save;
            $downloadurl='../../../download/unprocessed_enquiry_records'.$created_at.'.csv';
            //echo $downloadurl;
            header("Content-type: text/csv ; charset:utf-8");
            header("Content-Disposition: attachment; filename=file.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $output = fopen($save, "w");  
            fputcsv($output, array('Customer Name' , 'Contact No' , 'Whatsapp No' , 'Gmail Id', 'Interested Tour' , 'Travel From Date' , 'Travel To Date' , 'Budget' , 'Total Adults' , 'Total Childerns' , 'Total Infant' , 'Total Passangers' , 'Child Without Bed' ,'Child With Bed' , 'Enquiry Date' , 'Followup Date' , 'Reference' , 'Assigned Emp Id' , 'Enquiry Type' , 'Other Specification','Location','Hotel Type'));
            
            foreach($unprocessedArray as $row){
              fputcsv($output, $row);  
            }
              
            fclose($output); 
            echo "<script> window.location ='$downloadurl'; </script>";  
          } 
      }

      if($flag){
        commit_t();
        if($validCount>0)
        {
            echo  $validCount." records successfully imported<br>
            ".$invalidCount." records are failed.";
        }
        else
        {
          echo "error--No Enquiries imported"; 
        }
        exit;
      }
      else{
        rollback_t();
        exit;
      }

  }


  function enq_form_send(){

    global $theme_color;
    $email_id = $_POST['email_id'];
    $mobile_no = $_POST['mobile_no'];
    $login_id = $_POST['login_id'];
    $financial_year_id = $_POST['financial_year_id'];
    $content = '             
      <tr>
        <td>
          <table style="width:100%">
            <tr>
                <td>
                  <a style="font-weight:500;font-size:12px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width: 86px;text-align: center;" href="'.BASE_URL.'model/attractions_offers_enquiry/tour_enquiry.php?l_id='.$login_id.'&fid='.$financial_year_id.'">Enquiry Details</a>
                </td> 
            </tr>
          </table>
        </td>
      </tr>
    ';

    global $model;
    $message = "Please provide general information of your tour enquiry to prepare best proposal & organise services . Use this link :- ".BASE_URL.'model/attractions_offers_enquiry/tour_enquiry.php';

    $model->send_message($mobile_no, $message);
    $subject = "";

    $model->app_email_send('6','Customer',$email_id, $content,$subject,'1');
    echo "Enquiry Form has been successfully sent.";
  }

  }
