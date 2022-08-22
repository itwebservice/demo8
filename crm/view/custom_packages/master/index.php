<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Package Tour Information',15) ?>
<div class="header_bottom">
        <div class="row text-center">
            <label for="rd_package" class="app_dual_button active" data-id="1">
		        <input type="radio" id="rd_package" name="rd_package_tarrif" checked onchange="package_list_reflect()">
		        &nbsp;&nbsp;Package
		    </label>
			<?php
			if($setup_package == '4' || $b2c_flag == '1'){ ?>
				<label for="rd_tarrif" class="app_dual_button" data-id="3">
					<input type="radio" id="rd_tarrif" name="rd_package_tarrif" onchange="package_list_reflect()">
					&nbsp;&nbsp;Tariff
				</label>
			<?php } ?>
        </div>
	</div>
	<div id="div_custom_package"></div>
<?= end_panel() ?>

<script>
function package_list_reflect(){

	const urlParams = new URLSearchParams(window.location.search);
	const myParam = urlParams.get('activeid');

	if(myParam){
		const tab_index = $('.app_dual_button').each(function() {
			if($(this).data('id') === parseInt(myParam)){
				$(this).addClass('active').siblings().removeClass('active');
				$(this).find('input').attr('checked',true)
			}
		});
	}
	var id = $('input[name="rd_package_tarrif"]:checked').attr('id');
	if(id=="rd_package"){
		$.post('package_index.php', {}, function(data){
			$('#div_custom_package').html(data);
		});
	}
	if(id=="rd_tarrif"){
		$.post('tariff/index.php', {}, function(data){
			$('#div_custom_package').html(data);
		});
	}
}
package_list_reflect();
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>