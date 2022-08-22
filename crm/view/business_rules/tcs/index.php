<?php
include "../../../model/model.php";
?>

<div id="div_reflect" class="main_block"></div>

<script>

list_reflect();
function list_reflect(){
	var attendence_date = $('#attendence_date').val();
	var branch_status = $('#branch_status').val();
	if(attendence_date==""){
		error_msg_alert("Please select a Date!!!");
	}

    $.post('tcs/list_reflect.php',{ },function(data){
        $('#div_reflect').html(data);
    });
}
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>