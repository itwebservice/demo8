<?php
include '../../model/model.php';
$query = mysqli_fetch_assoc(mysqlQuery("SELECT google_map_script FROM `b2c_settings` where setting_id='1'"));
?>
<form id="section_scm">
    <legend>Define Google Map Script</legend>
    <div class="row mg_bt_20">
        <div class="col-md-12 mg_bt_10">
            <textarea id="google_map" name="google_map" class="form-control" placeholder="Please do not paste complete iframe script. Only paste source link." title="Google Map Script"><?= $query['google_map_script'] ?></textarea>
        </div>
    </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>

$(function(){
$('#section_scm').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var images_array = new Array();
    var google_map = $("#google_map").val();
    images_array.push({
        'google_map_script':google_map
    });
    $('#btn_save').button('loading');
    
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '16', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('16');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>