<?php include "../../model/model.php"; ?>
<?php
  $payment_id = $_POST['payment_id'];  

  $sq_payment = mysqli_fetch_assoc(mysqlQuery("select date from payment_master where payment_id='$payment_id'"));

  echo date('d-m-Y', strtotime($sq_payment['date']));
  
?>
