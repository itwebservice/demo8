<?php 
class enquiry_master{

///////////////////////***Enquiry Master Save start*********//////////////
function enquiry_master_save()
{

  $mobile_no = $_POST["mobile_no"]; 
  $email_id = $_POST["email_id"]; 
    if($mobile_no!='' && $email_id!='')
    {
      $enquiry_count = mysqli_num_rows(mysqlQuery("select * from enquiry_master where mobile_no='$mobile_no' or email_id = '$email_id'")); 
      if($enquiry_count>0){
        echo "Sorry, mobile or email already exists.";
      }

    }else{
      echo "";
    }
  

}


}

?>