<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Flyers','') ?>

<div class="row text-right">
    <div class="col-md-12">
		<form action="save/tab1.php" method="POST">
            <a target="_blank" href="https://itwebservice.in/flyers/index.php" class="btn btn-info btn-sm ico_left" title="Download Flyers"><i class="fa fa-download"></i>&nbsp;&nbsp;Flyers</a>
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" title="Add New Flyer"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Flyer</button>
        </form>
    </div>
</div>

<div id="div_modal" class="main_block"></div>
<div id="div_list_content" class="main_block"></div>
<div id="exp_html"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function save_modal()
{
    $('#btn_save_modal').button('loading');
    $.post('save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}

function list_reflect()
{
	$.post('list_reflect.php', {}, function(data){
        $('#div_list_content').html(data);
    });
}
list_reflect();
function delete_flyer(entry_id){

    var base_url = $('#base_url').val();
    $('#btn_delete'+entry_id).button('loading');
    $('#vi_confirm_box').vi_confirm_box({
        callback: function (result) {
            if (result == 'yes') {
            $.post(
                base_url+"controller/flyers/delete.php",
                { flyer_id:entry_id},
                function(data) {
                $('#btn_delete'+entry_id).button('reset');
                var msg = data.split('--');
                if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                    return false;
                }else{
                    success_msg_alert(msg[0]);
                    list_reflect();
                }
                });
            }
            else {
                $('#btn_delete'+entry_id).button('reset');
            } 
        }
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/html2canvas.min.js"></script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>