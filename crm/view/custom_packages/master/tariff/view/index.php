<?php
include "../../../../../model/model.php";
$package_id = $_POST['package_id'];
$sq_query = mysqlQuery("select * from custom_package_tariff where package_id='$package_id'");

$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id='$package_id'")); 
?>
<div class="modal fade profile_box_modal" id="tariff_view_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body profile_box_padding">
				<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs responsive" role="tablist">
					<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Costing Details</a></li>
					<li role="presentation"><a href="#offers" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Offers/Coupon</a></li>
					<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
				</ul>
				<!-- Tab panes1 -->
				<div class="tab-content responsive">
					<!-- *****TAb1 start -->
					<div role="tabpanel" class="tab-pane active no-pad-sm" id="basic_information">
						<?php include "tab1.php"; ?>
					</div>
					<!-- ********Tab1 End******** -->
					<!-- ***Tab3 Start*** -->
					<div role="tabpanel" class="tab-pane no-pad-sm" id="offers">
						<?php include "tab2.php"; ?>
					</div>
					<!-- ***Tab3 End*** -->
				</div>
			</div>
		</div>
    	</div>
    </div>
</div>

<script>
$('#tariff_view_modal').modal('show');
$('#tariff_view_modal').on('shown.bs.modal', function () {
	fakewaffle.responsiveTabs(['xs', 'sm']);
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
