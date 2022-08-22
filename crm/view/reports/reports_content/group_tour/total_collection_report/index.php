<?php include "../../../../../model/model.php";

 ?>
<div class="app_panel_content Filter-panel mg_bt_10">
	
	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        <select id="tour_id_filter" name="tour_id_filter" onchange="tour_group_dynamic_reflect(this.id,'group_id_filter');" style="width:100%" title="Tour Name" class="form-control"> 
	            <option value="">Tour Name</option>
	            <?php
	                $sq=mysqlQuery("select tour_id,tour_name from tour_master where active_flag='Active' order by tour_name");
	                while($row=mysqli_fetch_assoc($sq))
	                {
	                  echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
	                }    
	            ?>
	        </select>
	      </div>
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        <select class="form-control" id="group_id_filter" name="group_id_filter"  title="Tour Group" onchange="travelers_booking_reflect(this.id,'tour_id_filter','booking_id_filter3');"> 
	            <option value="">Tour Group</option>        
	        </select>
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <select id="booking_id_filter3" name="booking_id_filter" style="width:100%" title="Booking ID" class="form-control" onchange="passanger_reflect()"> 
	          <?php get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id); ?>
	      </select>
		</div>
	    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
	        <button class="btn btn-sm btn-info ico_right" onclick="collection_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
	    </div>
</div>
<div id="div_list" class="main_block mg_tp_20">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="gtc_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<script>
	$('#tour_id_filter').select2();
	$('#booking_id_filter3,#tour_id_filter').select2();
	var column = [
	{ title: "S_No."},
    { title: "Tour_Name"},
    { title: "Tour_Date"},
    { title: "Booking_ID"},
    { title: "Payment_Date"},
    { title: "Mode"},
    { title: "Total_sale", className: "info "},
    { title: "Paid_Amount", className: "success"},
    { title: "Balance", className: "warning"}
];
	function collection_reflect(){
		var id = $('#booking_id_filter3').val();
		var tour_id = $('#tour_id_filter').val();
		var group_id = $('#group_id_filter').val();
		$.post('reports_content/group_tour/total_collection_report/total_collection_report.php', {id:id,tour_id : tour_id,group_id : group_id}, function(data){
			pagination_load(data, column, true, true, 20, 'gtc_tour_report');
	});
	}
	collection_reflect();
</script>