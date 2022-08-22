<?php
class exc_service_voucher{
public function exc_service_voucher_save(){
	$booking_id = $_POST['booking_id']; 
	$booking_type = $_POST['booking_type'];
	$note = $_POST['note'];

	$note = addslashes($note);

	$sq_service_voucher_count = mysqli_num_rows( mysqlQuery("select * from excursion_service_voucher where booking_id='$booking_id'"));	
	if($sq_service_voucher_count==0){
		$id = mysqli_fetch_assoc( mysqlQuery("select max(id) as max from excursion_service_voucher") );
		$id = $id['max'] + 1;

		$sq = mysqlQuery("insert into excursion_service_voucher (id, booking_type,booking_id, note )  values ('$id','$booking_type', '$booking_id', '$note')");
		if($sq){
			echo "Service voucher information saved successfully.";
			exit;
		}
		else{
			echo "error--Service voucher can not be generated.";
			exit;
		}

	}else{
		$sq = mysqlQuery("update excursion_service_voucher set note='$note' where booking_id='$booking_id' and booking_type='$booking_type'");
		if($sq){
			echo "Service voucher information updated successfully.";
			exit;
		}
		else{
			echo "error--Service voucher can not be generated.";
			exit;
		}
	}
}

}
?>