<?php
include '../../../model/model.php';
?>
<legend>Define Blogs</legend>
<div class="row text-right mg_tp_20">	
    <div class="col-md-12">
        <button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Blog</button>
    </div>
</div>
<div id="div_modal"></div>
<div id="div_list"></div>
<div id="div_update_modal"></div>

<script>
function save_modal(){

	$('#btn_save_modal').button('loading');
	$.post('blogs/save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function list_reflect(){

	$('#div_list').append('<div class="loader"></div>');
	$.post('blogs/list_reflect.php', {}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
function update_modal(entry_id){

	// $('#btn_save_modal').button('loading');
	$.post('blogs/update_modal.php', {entry_id:entry_id}, function(data){
		// $('#btn_save_modal').button('reset');
		$('#div_update_modal').html(data);
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>