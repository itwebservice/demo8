<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');

$start_date = date('01-m-Y');
$end_date = date('t-m-Y');

$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];

$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='booker_incentive/booker_incentive.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Incentive/Commission dashboard',84) ?>
<div class="app_panel_content Filter-panel">

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

				<select name="tour_type" id="tour_type" class="form-control" title="Tour Type" style="width: 100%;" onchange="booking_list_reflect()" title="Tour Type">
					<option value="Group Tour">Group Tour</option>
					<option value="Package Tour">Package Tour</option>
					<option value="Visa Booking">Visa Booking</option>     
					<option value="Ticket Booking">Ticket Booking</option>
					<option value="Train Booking">Train Booking</option>
					<option value="Hotel Booking">Hotel Booking</option>     
					<option value="Bus Booking">Bus Booking</option>
					<option value="Car Rental Booking">Car Rental Booking</option>
					<option value="Activity Booking">Activity Booking</option>
					<option value="Miscellaneous Booking">Miscellaneous Booking</option>
				</select>
			</div>
			<?php
			if($role=='Admin' || $role=='Branch Admin' || $role=='Accountant'){
				?>
				<?php
				if($role=='Admin'){
					$query = "select emp_id, first_name, last_name from emp_master where role_id !='1' and active_flag='Active' order by first_name";
				}
				else if(($role=='Branch Admin' || $role=='Accountant') && $branch_status=='yes'){
					$query = "select emp_id, first_name, last_name from emp_master where role_id !='1' and active_flag='Active' and branch_id='$branch_admin_id' order by first_name";
				}
				else{
					$query = "select emp_id, first_name, last_name from emp_master where role_id !='1' and active_flag='Active'";	
				}
				?>
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
					<select name="emp_id" id="emp_id1" onchange="booking_list_reflect()" class="form-control" style="width: 100%;" title="Select User" title="Sales User">
						<option value="">Select User</option>
						<?php
						$sq_booker = mysqlQuery($query);
						while($row_booker = mysqli_fetch_assoc($sq_booker)){
							?>
							<option value="<?= $row_booker['emp_id'] ?>"><?= $row_booker['first_name'].' '.$row_booker['last_name'] ?></option>
							<?php
						}
						?>
					</select>
				</div>
			<?php }else{
				?>
				<input type="hidden" value="" id="emp_id1"/>
			<?php } ?>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date');booking_list_reflect()">

			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">

				<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date');booking_list_reflect()">
				<input type="hidden" name="branch_status" id="branch_status" value="<?= $branch_status?>">
			</div>

	</div>

</div>		
<div class="row main_block mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="sales_incentive" class="table table-hover" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>
<div id="div_booker_incentive_reflect" class="main_block loader_parent">
<div id="div_incentive_save_popup"></div>
	

</div>
<style>
.action_width{
	width : 250px;
}
</style>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
	$('#emp_id1').select2();
	$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	var column = [
	{ title : "S_No."},
	{ title:"User_Name"},
	{ title : "Tour_Type"},
	{ title : "Booking_id"},
	{ title : "Tour_Name"},
	{ title : "Tour_Date"},
	{ title : "Booking_Date"},
	{ title : "Booking_Amount"},
	{ title : "Purchase_Amount"},
	{ title : "Profit/Loss"},
	{ title : "Incentive"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;Actions", className:"text-center action_width"}
	];
	function booking_list_reflect()
	{
		$('#div_booker_incentive_reflect').append('<div class="loader"></div>');
		var tour_type = $('#tour_type').val();
		var emp_id = $('#emp_id1').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var branch_status = $('#branch_status').val();
		$.post('booking_list_reflect.php', { tour_type : tour_type, emp_id : emp_id, from_date : from_date, to_date : to_date , branch_status : branch_status}, function(data){
			pagination_load(data, column, true, true, 20, 'sales_incentive');
			$('.loader').remove();
			// console.log(data)
		});
	}

	booking_list_reflect();



	function incentive_calculate(basic_amount, tds, total_id)
	{
		var basic_amount = $('#'+basic_amount).val();
		var tds = $('#'+tds).val();

		if(basic_amount==""){ basic_amount = 0; }
		if(tds==""){ tds = 0; }
		var tds = (parseFloat(basic_amount)/100)*parseFloat(tds);
		var total = parseFloat(basic_amount)-parseFloat(tds);
		var total1 = total.toFixed(2);
		
		$('#'+total_id).val(total1);
	}
		
	function incentive_save_modal(booking_id, emp_id,purchase)
	{
		
		$.post('package_tour_incentive_save_modal.php', { booking_id : booking_id, emp_id : emp_id,purchase:purchase }, function(data){
			$('#div_incentive_save_popup').html(data);	
		});
	}
	function incentive_edit_modal(booking_id, emp_id,booking_type)
	{
		$.post('package_tour_incentive_edit_modal.php', { booking_id : booking_id, emp_id : emp_id,booking_type:booking_type }, function(data){
			$('#div_incentive_save_popup').html(data);	
		});
	}
	function add_incentive(ele, booking_id,emp_id,purchase,booking_amt){

		var base_url = $('#base_url').val();
		
		$.post('get_incentive_basic_amount.php', { booking_id : booking_id, emp_id : emp_id, purchase:purchase}, function(data){    
				var basic_amount = data;
				
				$.ajax({
					type:'post',
					url: base_url+'controller/booker_incentive/package_tour_incentive_save.php',
					data:{ booking_id : booking_id, emp_id : emp_id, basic_amount : basic_amount },
					success:function(result){
						alert(result);
					}
				});
			});
			
		
	}

$(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>


<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>