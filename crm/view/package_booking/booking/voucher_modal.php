<?php
include "../../../model/model.php";
$booking_id = $_GET['booking_id'];
$count = 0;
$sq_count = mysqli_num_rows(mysqlQuery("select * from package_tour_transport_service_voucher where booking_id='$booking_id'"));
$sq_count_p = mysqli_num_rows(mysqlQuery("select * from package_tour_transport_master where booking_id='$booking_id'"));
$sq = mysqli_fetch_assoc( mysqlQuery("select * from package_tour_transport_service_voucher where booking_id='$booking_id'") );
$sq_transport = mysqli_fetch_assoc( mysqlQuery("select * from package_tour_transport_voucher_entries where booking_id='$booking_id'") );
?>
<form id="frm_service_voucher">
<div class="modal fade" id="voucher_modal1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Voucher Details</h4>
      </div>
      <div class="modal-body">
	  <div class="panel panel-default panel-body">
		<input type="hidden" id="cmb_booking_id" value='<?= $booking_id  ?>'>
	  <?php if($sq_count != 0 || $sq_count_p != 0){ ?>
		<?php
		$countVehicle = 0;
		$sq_package = mysqlQuery("select * from package_tour_transport_master where booking_id='$booking_id'");
		while($row_entry1 = mysqli_fetch_assoc($sq_package)){

			$count++;
			$q_transport = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id='$row_entry1[transport_bus_id]'"));
			
			$sq_count_v = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_transport_voucher_entries where booking_id='$booking_id' and transport_bus_id='$row_entry1[transport_bus_id]'"));
			if($sq_count_v == 0){
				
				$driver_name = '';
				$driver_contact = '';
				$confirm_by = '';
			}
			else{
				$entriesDriver = array();
				$sq_entry_n = mysqlQuery("select * from package_tour_transport_voucher_entries where booking_id='$booking_id'");
				while($rows = mysqli_fetch_assoc($sq_entry_n)){
					array_push($entriesDriver, $rows);
				}
				$driver_name = $entriesDriver[$countVehicle]['driver_name'];
				$driver_contact = $entriesDriver[$countVehicle]['driver_contact'];
				$confirm_by = $entriesDriver[$countVehicle]['confirm_by'];
			}
			?>
					<div class="row">
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="hidden" id="vehicle_name<?= $count?>" value='<?= $q_transport['entry_id']  ?>'>
							<input type="text" id="vehicle_names" title="Vehicle Name" name="vehicle_name" value="<?=$q_transport['vehicle_name']?>" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="text" id="driver_name<?= $count?>" name="driver_name" placeholder="Driver Name"   title="Driver Name" value="<?= $driver_name ?>">
						</div>
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="number" id="driver_contact<?= $count?>" name="driver_contact" placeholder="Driver Contact"    title="Driver Contact" value="<?= $driver_contact ?>">
						</div>
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="text" id="confirm_by<?= $count?>" name="confirm_by<?= $count?>"  placeholder="Confirmed by" title="Confirmed by" value="<?= $confirm_by ?>" />
						</div>
					</div>
		<?php $countVehicle++; } ?>
		<input type="hidden" id="count" value="<?= $count?>"/>
		<div class="row">
			<div class="col-md-6 col-sm-6 mg_bt_10">
				<textarea id="special_arrangments" name="special_arrangments" onchange="validate_address(this.id)" placeholder="Special Arrangements" title="Special Arrangements"><?= $sq['special_arrangments'] ?></textarea>
			</div>
			<div class="col-md-6 col-sm-6 mg_bt_10">
				<textarea id="inclusions" name="inclusions" placeholder="Inclusions" onchange="validate_address(this.id)" title="Inclusions"><?= $sq['inclusions'] ?></textarea>
			</div>
		</div>
		<?php } ?>
		<div class="row text-center mg_tp_20">
			<div class="col-md-12">
				<button class="btn btn-sm btn-info ico_left" title="Print"><i class="fa fa-print"></i>&nbsp;&nbsp;Voucher</button>
			</div>
		</div>
	</div>


    </div>      

    </div>

</div>

</div>



</form>

<script>
$('#city_id').select2({minimumInputLength: 1});
$('#voucher_modal1').modal('show');

$(function(){
	$('#frm_service_voucher').validate({
		rules:{
		},
		submitHandler:function(form, event){
				event.preventDefault();
				var base_url = $('#base_url').val();
				var count = $('#count').val();
				var booking_id = $('#cmb_booking_id').val();
				var vehicle_name_array = [];
				var pick_array = [];
				var driver_contact_array = [];
				var driver_name_array = [];
				var confirm_by_array = [];

				for(var i=1;i<=count;i++){
					var vehicle_name = $('#vehicle_name'+i).val();
					var pick_up_from = $('#pick_up_from'+i).val();
					var drop_to = $('#drop_to'+i).val();
					var driver_name = $('#driver_name'+i).val();
					var driver_contact = $('#driver_contact'+i).val();
					var confirm_by = $('#confirm_by'+i).val();
					if(vehicle_name == ''){
						error_msg_alert("Select Vehicle in row "+i); return false;
					}
					if(pick_up_from == ''){
						error_msg_alert("Enter Pick From in row "+i); return false;
					}
					if(vehicle_name == ''){
						error_msg_alert("Enter Drop To in row "+i); return false;
					}
					vehicle_name_array.push(vehicle_name);
					driver_name_array.push(driver_name);
					driver_contact_array.push(driver_contact);
					confirm_by_array.push(confirm_by);
				}
				var special_arrangments = $('#special_arrangments').val();
				var inclusions = $('#inclusions').val();
				for(var i=1;i<=count;i++){
					var flag1 = validate_address('special_arrangments');
					var flag2 = validate_address('inclusions');
					if(!flag1 || !flag2){
						return false;
					}
				}
				$.ajax({
					type:'post',
					url:base_url+'controller/package_tour/service_voucher/transport_service_voucher_save.php',
					data:{ booking_id : booking_id,vehicle_name_array:vehicle_name_array,driver_name_array : driver_name_array,driver_contact_array : driver_contact_array, special_arrangments : special_arrangments, inclusions : inclusions,confirm_by_array:confirm_by_array  },
					success: function(message){
						console.log(message);
						var msg = message.split('--');
						if(msg[0]=="error"){
							error_msg_alert(msg[1]);
							return false;
						}
						else
						{
							if(msg!=''){
								$('#vi_confirm_box').vi_confirm_box({
								false_btn: false,
								message: 'Information Saved Successfully',
								true_btn_text:'Ok',
								callback: function(data1){
										if(data1=="yes"){
											var url1 = base_url+'model/app_settings/print_html/voucher_html/fit_voucher.php?booking_id='+booking_id;
											loadOtherPage(url1);
											$('#voucher_modal1').modal('hide');
										}
									}
								});
							}else{
								var url1 = base_url+'model/app_settings/print_html/voucher_html/fit_voucher.php?booking_id='+booking_id;
											loadOtherPage(url1);
											$('#voucher_modal1').modal('hide');
							}
						}
					}
				});
		}
	});
});
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>