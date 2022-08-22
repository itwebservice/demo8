<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Rent a Bike Tariff',2) ?>
<?php
if($setup_package == '4' || $b2c_flag == '1'){ ?>
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_master" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_master" name="app_bike" checked>
      &nbsp;&nbsp;Bike
  </label>
  <label for="rd_tariff" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_tariff" name="app_bike">
      &nbsp;&nbsp;Tariff
  </label>
</div>

<div class="app_panel_content">
  <div class="row bike_panel">
    <div class="col-md-12">
        <div id="locations_panel">
            <?php include_once('master/index.php'); ?>
        </div>
    </div>
  </div>
  <div class="row bike_panel hidden">
    <div class="col-md-12">
        <div id="branches_panel">
        	<?php include_once('tariff/index.php'); ?>
        </div>
    </div>
  </div>
</div>

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
	$(function(){
		$('input[name="app_bike"]').change(function(){
			$('.bike_panel').toggleClass('hidden');
		});
	});
</script>
<?php } else{ ?>
  <div class="alert alert-danger" role="alert">
    Please upgrade the subscription to use this feature.
  </div>
<?php }?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>