<?php 
// include_once('../../../model/model.php');
?>
<div class="row mg_bt_10">

<div class="col-md-12 text-right">
  <button class="btn btn-info btn-sm ico_left" onclick="tariff_save_modal()" data-toggle="tooltip" title="Add new Tariff"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tariff</button>
</div>
</div>
<div id="div_tariffsave_modal"></div>
<div id="div_request_list" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="table-responsive">
        <table id="b2b_tarrif_tab" class="table table-hover" style="width:100%;margin: 20px 0 !important;">         
        </table>
    </div></div></div>
</div>

<script>
$('#from_date_filter,#to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function tariff_save_modal()
{
  	$.post('tariff/save_modal.php', {}, function(data){
      $('#div_tariffsave_modal').html(data);
    });
}
</script>

<script src="js/tariff.js"></script>