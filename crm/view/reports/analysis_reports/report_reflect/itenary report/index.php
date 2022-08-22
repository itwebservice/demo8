


<div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3 col-sm-4 mg_bt_10_sm_xs">
			    <input type="text" id="from_date"  name="from_date" class="form-control" placeholder="*Date" title="Date">
			</div>
			
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<button class="btn btn-sm btn-info ico_right" onclick="report_reflect(true)">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
		</div>
	</div>
	

<div id="div_list" class="main_block mg_tp_20">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="gpd_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="other_des_wise_display">

</div>
<script>
$( "#from_date, #to_date" ).datetimepicker({ timepicker:false, format:'d-m-Y' });        

	
	function report_reflect(data){
		
		if(data != true)
		{
		var fromdate = null;
	
			
	}
		else
		{
		var fromdate = $('#from_date').val();
		
				
		}
		var column = [
	{ title : "Sr.No."},
	{ title : "Booking Id"},
	{ title : "Customer Name"},
	{ title : "Special Attraction"},
	{ title : "Program Details"},
	{ title : "Overnight Stay"},
	{ title : "Meal Plan"}
	
	
];
		$.post('report_reflect/itenary report/get_report.php', { date : fromdate}, function(data){
		// $('#div_list').html(data);
		pagination_load(data, column, true, true, 20, 'gpd_tour_report');
	});
	}
	
	report_reflect(false);


	function view_desti_wise_modal(dest_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/reports/analysis_reports/report_reflect/destination_wise_report/view_desti_wise_modal.php', { dest_id : dest_id}, function(data){
		$('#other_des_wise_display').html(data);
	});
}
</script>