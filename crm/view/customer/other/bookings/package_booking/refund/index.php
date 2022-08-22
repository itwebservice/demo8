<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select id="booking_idp1" name="booking_idp1" onchange="refund_list_reflect();" required style="width: 100%"> 
				    <option value="">Select Booking</option>
				    <?php 
				        $sq_booking = mysqlQuery("select booking_id,booking_date,customer_id from package_tour_booking_master where customer_id='$customer_id'");
				        while($row_booking = mysqli_fetch_assoc($sq_booking))
				        {
							$date = $row_booking['booking_date'];
							$yr = explode("-", $date);
							$year =$yr[0];
							$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
				             ?>
							 <option value="<?= $row_booking['booking_id'] ?>"><?= get_package_booking_id($row_booking['booking_id'],$year) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
				             <?php  
				        }    
				     ?>
				</select>
			</div>
		</div>
	  </div>
<div id="div_refund_estimate" class="main_block"></div>
<div id="div_refund_list" class="main_block"></div>
<script>
$('#booking_idp1').select2();
function refund_list_reflect()
{
	var booking_id = $('#booking_idp1').val();
	$.post('bookings/package_booking/refund/refund_list_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_refund_list').html(data);
	});
}
refund_list_reflect();
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>