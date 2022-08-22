<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Vehicle Supplier Information',20) ?>
	<div class="header_bottom">
	<div class="row text-center">
		<label for="rd_car" class="app_dual_button active" data-id="1">
			<input type="radio" id="rd_car" name="rd_car_tarrif1" checked onchange="hotel_tarrif_reflect()">
			&nbsp;&nbsp;Vehicle
		</label>   
		<label for="rd_tarrif" class="app_dual_button" data-id="2">
			<input type="radio" id="rd_tarrif" name="rd_car_tarrif1" onchange="hotel_tarrif_reflect()">
			&nbsp;&nbsp;Tariff
		</label>
	</div>
	</div> 
<!--=======Header panel end======-->
<!-- <div class="app_panel_content"> -->
<div id="div_hotel_tarrif"></div>
<!-- </div> -->
<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
function hotel_tarrif_reflect(){
	
	var id = $('input[name="rd_car_tarrif1"]:checked').attr('id');
	if(id=="rd_car"){
		$.post('vendor/index.php', {}, function(data){
			$('#div_hotel_tarrif').html(data);
		});
	}
	if(id=="rd_tarrif"){
		$.post('tariff/index.php', {}, function(data){
			$('#div_hotel_tarrif').html(data);
		});
	}
}
hotel_tarrif_reflect();
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>