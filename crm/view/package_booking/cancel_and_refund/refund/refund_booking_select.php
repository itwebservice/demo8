<?php
include "../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
<div class="row">
	
<div class="row">
	<div class="col-md-12 col-xs-12">
	<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
		<select id="booking_id" name="booking_id" style="width:100%" title="Select Booking" onchange="refund_booking_reflect();" class="form-control"> 
		    <option value="">Select Booking</option>
			<?php 
			$sq_hotel = mysqlQuery("select * from package_tour_booking_master where booking_id in ( select booking_id from package_travelers_details where status='Cancel') order by booking_id desc");
			while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
				$date = $row_hotel['booking_date'];
				$yr = explode("-", $date);
				$year =$yr[0];
				$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_hotel[customer_id]'"));
				if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
					$customer_name = $sq_customer['company_name'];
				}else{
					$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				}
				?>
				<option value="<?= $row_hotel['booking_id'] ?>"><?= get_package_booking_id($row_hotel['booking_id'],$year).' : '.$customer_name ?></option>
				<?php } ?>
		</select>
	</div>
	</div>
</div>
</div>

</div>
<div id="div_cancel_booking_reflect" class="mg_tp_10"></div>
<script>
	$("#booking_id").select2();
	//$('#frm_refund_booking').validate();
	function refund_booking_reflect(){
		var booking_id = $("#booking_id").val();
		if(booking_id!=''){
			$.post('../refund/refund_booking.php', { booking_id : booking_id }, function(data){
				$('#div_cancel_booking_reflect').html(data);
			});
		}else{
			$('#div_cancel_booking_reflect').html('');
		}
	}
	// function validate_submit()
	// {
	//     var tourwise_traveler_id = $("#booking_id").val();

	//     if(tourwise_traveler_id=="")
	//     {
	//         error_msg_alert("Please select Booking ID.");
	//         return false;
	//     }
	    
	// }
</script>