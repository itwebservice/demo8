<?php
include '../../model/model.php';
$count = 55;
$sq_setting = mysqli_fetch_assoc(mysqlQuery("select assoc_logos from b2c_settings where 1"));
$logos = ($sq_setting['assoc_logos']!=''&&$sq_setting['assoc_logos']!='null')?json_decode($sq_setting['assoc_logos']):[];

$dir = 'https://itourscloud.com/destination_gallery/association-logo/';
for($i = 1; $i<=$count; $i++){
    
    $image_path = $dir.$i.'.png';
    if(in_array($i,$logos)){
        $checked = 'checked';
    }else{
        $checked = '';
    }
?>
<form id="section_logos">
<div class="gallary-image">
    <div class="col-sm-3">
    <div class="gallary-single-image mg_bt_30 mg_bt_10_sm_xs" style="width: 100%;">
        <img src="<?php echo $dir.$i.'.png'; ?>" id="image<?php echo $i; ?>" alt="title" class="img-responsive">
        <span class="img-check-btn">
            <input type="checkbox" id="image_select<?php echo $i; ?>" name="image_check" value="<?php echo $i ?>" <?= $checked ?>>
        </span>
    </div>
    </div>
</div>
<?php 
}
?>
<div class="row mg_tp_20">
    <div class="col-xs-12 text-center">
        <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
    </div>
</div>
</form>

<script>
$(function(){
$('#section_logos').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
	// var len = $('input[name="image_check"]:checked').val();
    var selected = [];
    $('input[name="image_check"]:checked').each(function(){
        selected.push($(this).val());
    });

    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '20', data : selected},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('20');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
