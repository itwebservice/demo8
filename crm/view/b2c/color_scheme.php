<?php
include '../../model/model.php';
$query = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM `b2c_color_scheme` where 1"));
?>
<form id="section_color">
    <legend>Define Color Scheme</legend>
    <div class="row mg_bt_20">
        <div class="col-md-2">
            Text Primary Color 
        </div>
        <div class="col-md-9">
		    <a class="btn btn-info btn-sm ico_left" data-toggle="tooltip" data-placement="bottom" title="Setting" href="javascript:void(0)" onclick="color_scheme_save_modal('text_primary_color')"><i class="fa fa-cog"></i><span class="">&nbsp;&nbsp;Change</span></a>
        </div>
    </div>
    <div class="row mg_bt_20">
        <div class="col-md-2">
            Text Secondary Color 
        </div>
        <div class="col-md-9">
		    <a class="btn btn-info btn-sm ico_left" data-toggle="tooltip" data-placement="bottom" title="Setting" href="javascript:void(0)" onclick="color_scheme_save_modal('text_secondary_color')"><i class="fa fa-cog"></i><span class="">&nbsp;&nbsp;Change</span></a>
        </div>
    </div>
    <div class="row mg_bt_20">
        <div class="col-md-2">
            Button Color 
        </div>
        <div class="col-md-9">
		    <a class="btn btn-info btn-sm ico_left" data-toggle="tooltip" data-placement="bottom" title="Setting" href="javascript:void(0)" onclick="color_scheme_save_modal('button_color')"><i class="fa fa-cog"></i><span class="">&nbsp;&nbsp;Change</span></a>
        </div>
    </div>
    <div id="color_modal"></div>
</form>
<script>
function color_scheme_save_modal(color_element) {

    var base_url = $('#base_url').val();
    $.post('color_scheme_modal.php', {color_element:color_element}, function (data) {
        $('#color_modal').html(data);
    });
}
</script>