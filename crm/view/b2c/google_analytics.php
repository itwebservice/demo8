<?php
include '../../model/model.php';
$query = mysqli_fetch_assoc(mysqlQuery("SELECT google_analytics FROM `b2c_settings` where setting_id='1'"));
?>
<form id="section_ganalytics">
    <legend>Define Google analytics Code</legend>
    <div class="row mg_bt_20">
        <div class="col-md-12 mg_bt_10">
            <textarea id="google_ana" name="google_ana" class="form-control" placeholder="Google analytics Code" title="Google analytics Code"><?= $query['google_analytics'] ?></textarea>
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
$('#section_ganalytics').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var images_array = new Array();
    var google_ana = $("#google_ana").val();
    images_array.push({
        'google_ana_code':google_ana
    });
    $('#btn_save').button('loading');
    
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '21', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('21');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>