<?php
include "../../model/model.php";

$booking_id = $_POST['booking_id'];
$emp_id = $_POST['emp_id'];
$booking_type = $_POST['booking_type'];
$financial_year_id = $_SESSION['financial_year_id'];

$sq_incentive = mysqli_fetch_assoc(mysqlQuery("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id' and service_type = '$booking_type'"));
?>

<form id="frm_incentive_edit">
<div class="modal fade" id="package_tour_incentive_edit_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= $booking_type?> Incentive Edit</h4>
      </div>
      <div class="modal-body text-center">
	  <input type="hidden" id='booking_type' name='booking_type' value='<?= $booking_type ?>'>
		<input type='hidden' id='financial_year_id' name='financial_year_id' value='<?= $financial_year_id ?>' />
		<div class="row ">
			<div class="col-md-4"></div>
			<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10 hidden">
				<input type="text" class="form-control" id="basic_amount" name="basic_amount" placeholder="Basic Amount" title="Basic Amount" onchange="validate_balance(this.id);incentive_calculate('basic_amount', 'tds', 'incentive_amount')" >
			</div>
			<div class="col-md-4"></div>
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10 hidden">
				<input type="text" class="form-control" id="tds" name="tds" placeholder="TDS(%)" title="TDS" onchange="validate_balance(this.id);incentive_calculate('basic_amount', 'tds', 'incentive_amount')" >
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
				<input type="text" class="form-control" id="incentive_amount" name="incentive_amount" placeholder="Incentive Amount" title="Incentive Amount" >
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<button class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
			</div>
		</div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
	$('#package_tour_incentive_edit_modal').modal('show');
	$(function(){
		$('#frm_incentive_edit').validate({
			rules:{
				basic_amount: { required : true, number:true },
				tds: { required : true, number:true },
				incentive_amount: { required:true },
			},
			submitHandler:function(form){
				var booking_id = <?= $booking_id ?>;
				var booking_type = $('#booking_type').val();
				var emp_id = <?= $emp_id ?>;
				var basic_amount = $('#basic_amount').val();
				var tds = $('#tds').val();
				var incentive_amount = $('#incentive_amount').val();
				var financial_year_id = $('#financial_year_id').val();
				var base_url = $('#base_url').val();
				var incentive_arr = [];
				incentive_arr.push({
					booking_type:booking_type,
					booking_id : booking_id,
					emp_id : emp_id,
					basic_amount : basic_amount,
					incentive_amount:incentive_amount,
					financial_year_id:financial_year_id
				})
				var incentive_arr = JSON.stringify(incentive_arr);
			
				$.ajax({
					type:'post',
					url: base_url+'controller/booker_incentive/incentive_update.php',
					data:{ incentive_arr:incentive_arr},
					success:function(result){
						$('#package_tour_incentive_edit_modal').modal('hide');
						$('#package_tour_incentive_edit_modal').on('hidden.bs.modal', function () {
						    msg_alert(result);
							booking_list_reflect();
						});
					}
				});
			}
			
			});
	});
</script>