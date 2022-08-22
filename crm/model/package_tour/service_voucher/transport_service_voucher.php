<?php 
class transport_service_voucher{

	public function transport_service_voucher_save()
	{
		$booking_id = $_POST['booking_id'];
		$vehicle_name_array = $_POST['vehicle_name_array'];
		$driver_name_array = $_POST['driver_name_array'];
		$driver_contact_array = $_POST['driver_contact_array'];
		$confirm_by_array = $_POST['confirm_by_array'];

		$special_arrangments = $_POST['special_arrangments'];
		$inclusions = $_POST['inclusions'];


		$sq_service_voucher_count = mysqli_num_rows( mysqlQuery("select * from package_tour_transport_service_voucher where booking_id='$booking_id'") );

		$special_arrangments = addslashes($special_arrangments);
		$inclusions = addslashes($inclusions);
		if($sq_service_voucher_count!=0){

			$sq_delete = mysqlQuery("delete from package_tour_transport_voucher_entries where booking_id='$booking_id'");
			$sq = mysqlQuery("update package_tour_transport_service_voucher set special_arrangments='$special_arrangments', inclusions='$inclusions' where booking_id='$booking_id'");
		}
		$id = mysqli_fetch_assoc( mysqlQuery("select max(id) as max from package_tour_transport_service_voucher") );
		$id = $id['max'] + 1;

		$sq = mysqlQuery("insert into package_tour_transport_service_voucher (id, booking_id, special_arrangments, inclusions)  values ('$id', '$booking_id', '$special_arrangments', '$inclusions')");

		if($sq){
			for($i=0;$i<sizeof($vehicle_name_array);$i++){
				$entry_id = mysqli_fetch_assoc( mysqlQuery("select max(entry_id) as max from package_tour_transport_voucher_entries") );
				$entry_id1 = $entry_id['max'] + 1;

				$sq11 = mysqlQuery("INSERT INTO `package_tour_transport_voucher_entries`(`entry_id`, `booking_id`, `transport_bus_id`, `driver_name`, `driver_contact`,`confirm_by`) VALUES ('$entry_id1', '$booking_id','$vehicle_name_array[$i]', '$driver_name_array[$i]','$driver_contact_array[$i]','$confirm_by_array[$i]')");
			}
			if($sq11){
				echo "Service voucher information saved successfully.";
				exit;
			}
		}
		else{
			echo "error--Service voucher can not be generated.";
			exit;
		}
	}
}
?>