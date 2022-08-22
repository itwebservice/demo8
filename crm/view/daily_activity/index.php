<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='daily_activity/index.php'"));
$branch_status = $sq['branch_status']; 
?>
<?= begin_panel('User Activities',92) ?>


<div class="header_bottom">
  <div class="row mg_bt_10">
      <div class="col-md-12 text-right">
          <button class="btn btn-info btn-sm ico_left btn-primary" type="button" data-toggle="modal" data-target="#activity_save_modal" title="Add New Activity"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Activity</button>
      </div>
  </div>
</div>
<div class="app_panel_content Filter-panel">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
      <input type="text" id="from_date" name="from_date" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date')">
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs">
      <input type="text" id="to_date" name="to_date" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date')">
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 text-left">
      <button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
    </div>
  </div>
</div>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >



<div class="app_panel_content">
  <div class="row mg_tp_20"> <div class="col-md-12 no-pad">
    <div class="table-responsive" id="div_activity">
    </div>
  </div> </div>
</div>
<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script type="text/javascript">
 $('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
 function list_reflect()
{   
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();   
    var branch_status = $('#branch_status').val();
    $.post('list_reflect.php', { from_date : from_date, to_date : to_date,branch_status:branch_status }, function(data){
        $('#div_activity').html(data);
    });
}
list_reflect();
 </script>
<?= end_panel() ?>
<?php
require('save_modal.php');
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>