<?php
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$sq_package_info = mysqli_fetch_assoc(mysqlQuery("select * from b2c_sale where booking_id='$booking_id'"));
$date = $sq_package_info['created_at'];
$yr = explode("-", $date);
$year = $yr[0];

$status = $sq_package_info['status'];
$bg_clr = ($status=='Cancel') ? 'danger': '';
$costing_data = json_decode($sq_package_info['costing_data']);
$enq_data = json_decode($sq_package_info['enq_data']);
$guest_data = json_decode($sq_package_info['guest_data']);
$total_pax = intval($enq_data[0]->adults)+intval($enq_data[0]->chwob)+intval($enq_data[0]->chwb)+intval($enq_data[0]->infant)+intval($enq_data[0]->extra_bed);
$state_id = $costing_data[0]->state;
$package_id = $enq_data[0]->package_id;
$sq_state = mysqli_fetch_assoc(mysqlQuery("select state_name from state_master where id='$state_id'"));
?>
<div class="modal fade profile_box_modal" id="package_display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-body profile_box_padding">
		
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#basic_information" aria-controls="basic_information" role="tab" data-toggle="tab" class="tab_name">General</a></li>
					<li role="presentation"><a href="#hotel_information" aria-controls="hotel_information" role="tab" data-toggle="tab" class="tab_name">Hotel/Transport</a></li>
					<li role="presentation"><a href="#booking_costing" aria-controls="booking_costing" role="tab" data-toggle="tab" class="tab_name">Costing Information</a></li>
					<li role="presentation"><a href="#payment_information" aria-controls="payment_information" role="tab" data-toggle="tab" class="tab_name">Receipt Information</a></li>
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
						<div role="tabpanel" class="tab-pane" id="hotel_information">
							<?php include "tab3.php"; ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="booking_costing">
							<?php include "tab4.php"; ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="payment_information">
							<?php include "tab5.php"; ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#package_display_modal').modal('show');
</script>