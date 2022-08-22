<?php 
include "../../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];

$sq_hotel_info = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$booking_id'"));
$date = $sq_hotel_info['created_at'];
$yr = explode("-", $date);
$year =$yr[0];
//Paid
$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum ,sum(credit_charges) as sumc from hotel_booking_payment where booking_id='$sq_hotel_info[booking_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
?>
<div class="modal fade profile_box_modal" id="hotel_display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		<div class="modal-body profile_box_padding">
			
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">General Information</a></li>
					<li role="presentation"><a href="#payment_information" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Receipt Information</a></li>
					<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
				</ul>

				<div class="panel panel-default panel-body fieldset profile_background">

					<!-- Tab panes1 -->
					<div class="tab-content">

						<!-- *****TAb1 start -->
						<div role="tabpanel" class="tab-pane active" id="basic_information">
						<?php include "tab1.php"; ?>
						</div>
						<!-- ********Tab1 End******** --> 
						
						<!-- ***Tab2 Start*** -->
						<div role="tabpanel" class="tab-pane" id="payment_information">
						<?php include "tab2.php"; ?>
						</div>
						<!-- ***Tab2 End*** -->

					</div>

				</div>
			</div>
			
		</div>
		
		</div>
	</div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#hotel_display_modal').modal('show');
</script>