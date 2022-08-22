<?php 
class upcoming_tour_offers_master{

///////////////////////***Upcoming Tour offers master save start*********//////////////

function upcoming_tour_offers_master_save($title, $description, $valid_date)
{
  
  global $secret_key,$encrypt_decrypt;
  $title = addslashes($title);
  $description = addslashes($description);
  $valid_date = mysqlREString($valid_date);

  $valid_date = date("Y-m-d", strtotime($valid_date));
  $entry_date = date("Y-m-d");
  
  $max_id = mysqli_fetch_assoc(mysqlQuery("select max(offer_id) as max from upcoming_tour_offers_master"));
  $max_id = $max_id['max']+1;

  $sq_offers = mysqlQuery("insert into upcoming_tour_offers_master (offer_id, title, description, valid_date, entry_date) values ('$max_id', '$title', '$description', '$valid_date', '$entry_date')");
  if($sq_offers)
  {
    echo "Information has been successfully saved.";
  }  
  else
  {
    echo "error--Information not saved!";
    exit;
  }  
  $sq_customer =mysqlQuery("select * from customer_master");
  while($sq_row = mysqli_fetch_assoc($sq_customer))
  {

    $name = $sq_row['first_name']."". $sq_row['last_name']; 
    $contact = $sq_row['contact_no'];
    $contact = $encrypt_decrypt->fnDecrypt($contact, $secret_key);
    $email= $sq_row['email_id'];
    $email = $encrypt_decrypt->fnDecrypt($email, $secret_key);
    $this->fourth_coming_attraction_email($name,$title,$description,$valid_date,$email);
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
      <p style="line-height: 24px;">We would like to inform you that <span>'.$app_name.'</span> coming up with an Exciting Offer for a Limited Period, details are as mentioned below.</p></td>';
      $content .='<tr><td colspan="2">
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left; width: 95px;">Title :</strong> <span>'.$title.'</span></p>
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left; width: 95px;">Valid Till :</strong><span> '.$valid_date1.'</span></p>
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left;    width: 95px;">Description : </strong><span style="float: left; width: 80%;">'.$description.'</span></p></td>';
  $content .='<tr><td colspan="2">
      <p style="line-height: 24px;">We hope that you will take full advantage of the respective offer to the fullest.</p>
      <p style="line-height: 24px;">Thank you for your kind patronage.</p></td>
    </tr>
  </table>';

  $subject = "Exciting Offer for you!";
  global $model;
  $model->app_email_master($email, $content, $subject,'1');
}

///////////////////////***Upcoming Tour offers master save end*********//////////////

///////////////////////***Upcoming Tour offers master update start*********//////////////

function upcoming_tour_offers_master_update($offer_id, $title, $description, $valid_date)
{
  global $secret_key,$encrypt_decrypt;
  $offer_id = mysqlREString($offer_id);
  $title = addslashes($title);
  $description = addslashes($description);
  $valid_date = mysqlREString($valid_date);

  $valid_date = date("Y-m-d", strtotime($valid_date));

  $sq_offers = mysqlQuery("update upcoming_tour_offers_master set title='$title', description='$description', valid_date='$valid_date' where offer_id='$offer_id'");
  if($sq_offers)
  {
    echo "Information has been successfully updated";
  }  
  else
  {
    echo "Information not updated!";
    exit;
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
  }

}

///////////////////////***Upcoming Tour offers master update end*********//////////////

///////////////////////***Upcoming Tour offer disable start*********//////////////

function upcoming_tour_offers_disable($offer_id)
{
  $offer_id = mysqlREString($offer_id);  

  $sq_offers = mysqlQuery("update upcoming_tour_offers_master set status='disabled' where offer_id='$offer_id'");
  if($sq_offers)
  {
    echo "Offer has been successfully disabled.";
  }  
  else
  {
    echo "Offer not disabled!";
    exit;
  }  
}

///////////////////////***Upcoming Tour offer disable end*********//////////////	

}
?>