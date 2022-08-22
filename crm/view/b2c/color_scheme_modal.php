<?php
include_once('../../model/model.php');
$color_element = $_POST['color_element'];
if($color_element == 'text_primary_color'){
    $color_scheme = 'Text Primary Color';
    $col_name = 'text_primary_color';
}
else if($color_element == 'text_secondary_color'){
    $color_scheme = 'Text Secondary Color';
    $col_name = 'text_secondary_color';
}
else if($color_element == 'button_color'){
    $color_scheme = 'Button Color';
    $col_name = 'button_color';
}
$sq_color = mysqli_fetch_assoc(mysqlQuery("select $col_name from b2c_color_scheme where entry_id='1'"));
?>
<div class="modal fade" id="color_scheme_modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Select Your Color Scheme</h4>
        </div>
        <div class="modal-body">
            <form id="frm_color_scheme">

                <div class="panel panel-default panel-body pad_8 mg_bt_10 text-center">
                    <div class="row text-center">
                        <div class="col-md-12">
                        <label for=""><?= $color_scheme ?></label>
                        <input type="color" id="theme_color" name="theme_color" value="<?= $sq_color[$col_name] ?>">
                        <input type="hidden" id="color_element" name="color_element" value="<?= $color_element ?>">
                        </div>
                    </div>

                    <div class="row mg_tp_20">
                        <div class="col-md-12">
                            <button class="btn btn-success" id="btn_color_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                        </div>
                    </div>       
                </div>  
            </form>
        </div>
    </div>
</div>

<script>
    $('#color_scheme_modal').modal('show');
    $(function(){
        $('#frm_color_scheme').validate({
        rules:{
                theme_color : { required :true },
        },
        submitHandler:function(data){
            var base_url = $('#base_url').val();
            var theme_color = $('#theme_color').val();
            var color_element = $('#color_element').val();

            $('#btn_color_save').button('loading');
            $.ajax({
            type:'post',
            url: base_url+'controller/b2c_settings/cms_save.php',
            data:{ section : '19', theme_color : theme_color,color_element:color_element},
                success: function(message){
                $('#btn_color_save').button('reset');
                    var data = message.split('--');
                    success_msg_alert('Color scheme saved successfully!');
                    update_b2c_cache();
                    $('#color_scheme_modal').modal('hide');
                }
            });
            }
        });
    });
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>