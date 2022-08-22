<?php
include "../../../../../model/model.php";

$request_id = $_POST['request_id'];

$sq_req = mysqli_fetch_assoc(mysqlQuery("select * from vendor_request_master where request_id='$request_id'"));
$city_id_arr = explode(',',$sq_req['vendor_city_id']);
?>
<div class="modal fade profile_box_modal" id="quotation_request_view"  role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">General Information</a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>
              	<div class="panel panel-default panel-body fieldset profile_background">
              		<div role="tabpanel" class="tab-pane active" id="basic_information">
						<?php  include_once('basic_info.php'); ?>
						<?php  include_once('dmc_tbl.php'); ?>
						<?php  include_once('supplier_details.php'); ?>
					</div>
				</div>
			</div>
      </div>
    </div>
  </div>
</div>
<script>
$('#quotation_request_view').modal('show');
</script>