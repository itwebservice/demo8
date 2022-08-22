<?php
include "../../../../model/model.php";
$entry_id = $_POST['entry_id'];
$sq_query = mysqlQuery("select * from ferry_tariff where entry_id='$entry_id'");
$row_req = mysqli_fetch_assoc(mysqlQuery("select * from ferry_master where entry_id='$entry_id'"));
?>
<div class="modal fade profile_box_modal" id="ferry_view_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-body profile_box_padding">
	<div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs responsive" role="tablist">
			<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name"><?= $row_req['ferry_name'].'('.$row_req['ferry_type'].')' ?></a></li>
			<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			</ul>
			<!-- Tab panes1 -->
			<div class="tab-content responsive">
				<!-- *****TAb1 start -->
				<div role="tabpanel" class="tab-pane active no-pad-sm" id="basic_information">
					<?php include "tab1.php"; ?>
				</div>
				<!-- ********Tab1 End******** -->
			</div>
        </div>
	</div>
	</div>
</div>
</div>

<script>
$('#ferry_view_modal').modal('show');
$('#ferry_view_modal').on('shown.bs.modal', function () {
	fakewaffle.responsiveTabs(['xs', 'sm']);
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

