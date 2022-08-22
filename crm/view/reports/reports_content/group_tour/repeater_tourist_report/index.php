<?php
include "../../../../../model/model.php";
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='reports/reports_homepage.php'"));
$branch_status = $sq['branch_status'];
?>
<div class="app_panel_content Filter-panel mg_bt_10">
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
      <select id="tour_id_filter" name="tour_id_filter" onchange="tour_group_dynamic_reflect1();" style="width:100%" title="Tour Name"> 
        <?php get_customer_dropdown($role,$branch_admin_id,$branch_status);?>
      </select>
    </div>      
</div>
<div id="div_list" class="main_block mg_tp_20">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="package_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="travelr_details_popup"></div>
<script>
  $('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
  $('#tour_id_filter').select2();

</script>
<script type="text/javascript">
  var column = [
	{ title: "S_No." },
	{ title: "Customer_name" },
	{ title: "birth_date" },
	{ title: "gender" },
	{ title: "repeated_count_group" ,className:"text-center"},
	{ title: "details"}
];
function tour_group_dynamic_reflect1()
{
  var traveler_id = $('#tour_id_filter').val();
    $.post('reports_content/group_tour/repeater_tourist_report/repeater_tourist_report_filter.php', { traveler_id:traveler_id}, function(data){
      pagination_load(data, column, true, false, 20, 'package_tour_report');
    });
}
function travelers_details(id)
  {
    var base_url = $('#base_url').val();
    var traveler_group_id = $("#"+id).val();
    console.log(traveler_group_id);
    $.get('reports_content/group_tour/repeater_tourist_report/repeater_tourist_report_filter_popup.php', { traveler_group_id : traveler_group_id }, function(data){
      console.log(data);
        $('#travelr_details_popup').html(data);
    });
  } 
tour_group_dynamic_reflect1();
</script>