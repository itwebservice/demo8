<?php
class fourth_coming_attraction_master{

  function fourth_coming_attraction_master_save($title, $description, $valid_date,$sight_image_path_array)
  {
    global $secret_key,$encrypt_decrypt;
    $valid_date = mysqlREString($valid_date);
    $sight_image_path_array = mysqlREString($sight_image_path_array);
  
    $valid_date = date('Y-m-d', strtotime($valid_date));
    $created_at = date("Y-m-d");
  
    $title = addslashes($title);
    $description = addslashes($description);
    $max_id =  mysqli_fetch_assoc(mysqlQuery("select max(id) as max from fourth_coming_attraction_master"));
    $max_id = $max_id['max']+1;
    
    $sq = mysqlQuery("insert into fourth_coming_attraction_master (id, title, description, valid_date, created_at) values ('$max_id', '$title', '$description', '$valid_date', '$created_at')");
    if(!$sq){
      echo "error--Error while saving.";
      exit;
    }  
    else{
      $sight_image_path_array_new = explode(',',$sight_image_path_array);
      //Images save
      if(sizeof($sight_image_path_array_new)!= '0' && sizeof($sight_image_path_array_new)>3){
        echo 'error--Sorry, you can upload up to 3 images';
        exit;
      }
      for($i=0;$i<sizeof($sight_image_path_array_new);$i++){
    
        $max_id1 =  mysqli_fetch_assoc(mysqlQuery("select max(attr_id) as max from fourth_coming_att_images"));
        $max_entry_id = $max_id1['max']+1;
        $sq_img = mysqlQuery("INSERT INTO `fourth_coming_att_images`(`attr_id`, `fourth_id`, `upload`) VALUES ('$max_entry_id','$max_id','$sight_image_path_array_new[$i]')");
        if(!$sq_img){
          echo "error--Image Not Saved";
        }
      }
      echo "Sightseeing Attraction saved successfully.";
    } 
  
    $sq_customer =mysqlQuery("select * from customer_master");
    while($sq_row = mysqli_fetch_assoc($sq_customer))
    {
      $name = $sq_row['first_name']." ". $sq_row['last_name']; 
      $contact = $sq_row['contact_no'];
      $contact = $encrypt_decrypt->fnDecrypt($contact, $secret_key);
      $email= $sq_row['email_id'];
      $email = $encrypt_decrypt->fnDecrypt($email, $secret_key);
      $this->fourth_coming_attraction_email($name,$title,$description,$valid_date,$email);
      $this->fourth_coming_offers_sms($contact);
    }
  }
///////////////////////***Fourth Coming attraction master save end*********//////////////
///////////////////////***Fourth Coming attraction master update start*********//////////////
function fourth_coming_attraction_master_update($id, $title, $valid_date, $description)
{
  global $secret_key,$encrypt_decrypt;
  $valid_date = date('Y-m-d', strtotime($valid_date));

  $title = addslashes($title);
  $description = addslashes($description);

  $sq = mysqlQuery("update fourth_coming_attraction_master set title='$title', valid_date='$valid_date', description='$description' where id='$id'");
  if(!$sq)
  {
    echo "error--Error while saving.";
    exit;
  }  
  else
  {
    echo "Sightseeing Attraction has been successfully updated.";
  }  
  $sq_customer1 = mysqlQuery("select * from customer_master");
  while($sq_row = mysqli_fetch_assoc($sq_customer1))
  {

    $name = $sq_row['first_name']."". $sq_row['last_name']; 
    $contact = $sq_row['contact_no'];
		$contact = $encrypt_decrypt->fnDecrypt($contact, $secret_key);
    $email= $sq_row['email_id'];
		$email = $encrypt_decrypt->fnDecrypt($email, $secret_key);
    $this->fourth_coming_attraction_email($name,$title,$description,$valid_date,$email);
    $this->fourth_coming_offers_sms($contact);
  }
}
///////////////////////***Fourth Coming attraction master update end*********//////////////
///////////////////////***Fourth Coming attraction disable start*********//////////////
function fourth_coming_attraction_disable($id)
{
  $sq = mysqlQuery("update fourth_coming_attraction_master set status='Disabled' where id='$id'");
  if(!$sq)
  {
    echo "Error while saving.";
    exit;
  }  
  else
  {
    echo "Sightseeing Attraction has been successfully disabled.";
  }  
}
///////////////////////***Fourth Coming attraction disable end*********//////////////
function fourth_coming_attraction_email($name,$title,$description,$valid_date,$email)
{
  global $app_name;
  $valid_date1 = date('d-m-Y', strtotime($valid_date));
  $content='
  <table>
    <tr>
      <td colspan="2">
      <p style="line-height: 24px;">Hi '.$name.',</p>
      <p style="line-height: 24px;">We would like to inform you that <span>'.$app_name.'</span> coming up with an Exciting Attraction for a Limited Period, details are as mentioned below.</p></td>';
      $content .='<tr><td colspan="2">
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left; width: 95px;">Title :</strong> <span>'.$title.'</span></p>
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left; width: 95px;">Valid Till :</strong><span> '.$valid_date1.'</span></p>
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left;    width: 95px;">Description : </strong><span style="float: left; width: 80%;">'.$description.'</span></p></td>';
  $content .='<tr><td colspan="2">
      <p style="line-height: 24px;">We hope that you will take full advantage of the respective offer to the fullest.</p>
      <p style="line-height: 24px;">Thank you for your kind patronage.</p></td>
    </tr>
  </table>';

  $subject = "Announcement of Sightseeing Attraction";
  global $model;
  $model->app_email_master($email, $content, $subject,'1');
}
public function fourth_coming_offers_sms($contact)
{
  global $app_contact_no,$valid_date,$description,$title;
  $message = "We would like to inform you that our company will be having new forth coming attraction and it will end on ".$valid_date.". Contact :".$app_contact_no."Title : ".$title."
        Valid Date : ".$valid_date."
        Description : ".$description."";
  global $model;
  $model->send_message($contact, $message);
}
function img_delete($img_id){
  $sq_delete = mysqlQuery("delete from fourth_coming_att_images where attr_id='$img_id'");
  if($sq_delete){
    echo "Image Deleted";
  }
}
}
?>