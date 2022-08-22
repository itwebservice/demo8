<?php
include "../../../../model/model.php";
?>
<div class="row text-right mg_bt_10">
	<div class="col-xs-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>


<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<select name="exc_id" id="exc_id" style="width:100%" title="Booking ID">
		        <option value="">Booking ID</option>
		        <?php 
		        $sq_exc = mysqlQuery("select * from excursion_master where exc_id in ( select exc_id from excursion_master_entries where status='Cancel')order by exc_id desc");
		        while($row_exc = mysqli_fetch_assoc($sq_exc)){

					$date = $row_exc['created_at'];
					$yr = explode("-", $date);
					$year =$yr[0];
					$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_exc[customer_id]'"));
					if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
						$cust_name = $sq_customer['company_name'];
					}else{
						$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
					}
					?>
					<option value="<?= $row_exc['exc_id'] ?>"><?= get_exc_booking_id($row_exc['exc_id'],$year).' : '.$cust_name ?></option>
					<?php
		        }
		        ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="Payment From Date" title="Payment From Date" onchange="get_to_date(this.id,'payment_to_date_filter')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" id="payment_to_date_filter" name="payment_to_date_filter" placeholder="Payment To Date" title="Payment To Date" onchange="validate_validDate('payment_from_date_filter','payment_to_date_filter')">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 text-left">
			<button class="btn btn-sm btn-info ico_right" onclick="refund_report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>



<div id="div_report_refund" class="main_block"></div>


<script>
$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#exc_id').select2();
function refund_report_reflect()
{
	var exc_id = $('#exc_id').val();
	var payment_from_date = $('#payment_from_date_filter').val();
	var payment_to_date = $('#payment_to_date_filter').val();
	$.post('report/refund_report_reflect.php', { exc_id : exc_id, payment_from_date : payment_from_date, payment_to_date : payment_to_date }, function(data){
		$('#div_report_refund').html(data);
	});
}
function excel_report()
{
    var exc_id = $('#exc_id').val();
    var payment_from_date = $('#payment_from_date_filter').val();
	var payment_to_date = $('#payment_to_date_filter').val();
  	window.location = 'report/excel_report.php?exc_id='+exc_id+'&payment_from_date='+payment_from_date+'&payment_to_date='+payment_to_date;
}
refund_report_reflect();
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>