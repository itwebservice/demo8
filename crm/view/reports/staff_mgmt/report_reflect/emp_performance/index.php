<?php
include "../../../../../model/model.php";
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='reports/staff_mgmt/index.php'"));
$branch_status = $sq['branch_status'];
/*======******Header******=======*/
// require_once('../../../../layouts/admin_header.php');
?>
 <div class="app_panel_content Filter-panel">
  <div class="row">
    <div class="col-md-3 col-sm-6 mg_bt_10_xs col-md-offset-4">
      <select name="year_filter" style="width: 100%" id="year_filter" title="Year" onchange="list_reflect();">
        <option value="">Year</option>
        <?php 
        for($year_count=2020; $year_count<2099; $year_count++){
          ?>
          <option value="<?= $year_count ?>"><?= $year_count ?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
</div>
<input type="hidden" id="branch_status1" name="branch_status1" value="<?= $branch_status ?>" >

<div id="div_list" class="main_block"></div>
<div id="div_modal"></div>
 
<script>
 $('#year_filter').select2();
function list_reflect()
{
  var year = $('#year_filter').val();
	var branch_status = $('#branch_status1').val(); 
	$.post('report_reflect/emp_performance/list_reflect.php',{ year : year,branch_status:branch_status}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
  
</script>
<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>