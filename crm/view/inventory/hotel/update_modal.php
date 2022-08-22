<?php
include "../../../model/model.php";
$entry_id = $_POST['entry_id'];
$str="select * from hotel_inventory_master where entry_id='$entry_id'";
$query = mysqli_fetch_assoc(mysqlQuery($str));
$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id='$query[city_id]'"));
$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name,hotel_id from hotel_master where hotel_id='$query[hotel_id]'"));
?>
<form id="frm_save">
<div class="modal fade" id="inventory_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Update Inventory</h4>
		</div>

		<div class="modal-body">
				<div class="row mg_bt_10">
				<input type="hidden" value="<?= $entry_id?>" id="entry_id"/>
					<div class="col-sm-4 mg_bt_10_xs">
						<input type="text" id="purchase_date1" name="purchase_date1" placeholder="Purchase Date" title="Purchase Date" value="<?= get_date_user($query['purchase_date'])?>">
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<select name="city_id1" id="city_id1" title="Select City" style="width:100%" disabled>
						<option value="<?= $sq_city['city_id']?>"><?= $sq_city['city_name']?></option>
						</select>
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<select name="hotel_name2" id="hotel_name2" title="Select Hotel" style="width:100%" disabled>
						<option value="<?= $sq_hotel['hotel_id']?>"><?= $sq_hotel['hotel_name']?></option>
							<option value="">Select Hotel</option>
				</select>
					</div>
				</div>
				<div class="row mg_bt_10">
					<div class="col-sm-4">
						<select id="room_type1" name="room_type1" placeholder="Category" title="Category">
						<option value="<?= $query['room_type']?>"><?= $query['room_type']?></option>
						<?php echo get_room_category_dropdown(); ?>				
						</select>
					</div>
					<div class="col-sm-4">
						<input type="text" id="no_of_rooms1" name="no_of_rooms1" placeholder="Total Rooms" title="Total Rooms" onchange="validate_balance(this.id);" value="<?= ($query['total_rooms'])?>">
					</div>
					<div class="col-sm-4">
						<input type="text" id="rate1" name="rate1" placeholder="Rate" title="Rate" onchange="validate_balance(this.id);" value="<?= ($query['rate'])?>">
					</div>
			</div>
				<div class="row mg_bt_10">
					<div class="col-sm-4 mg_bt_10_xs">
						<input type="text" id="from_date1" name="from_date1" placeholder="Valid From Date" title="Valid From Date" value="<?= get_date_user($query['valid_from_date'])?>">
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<input type="text" id="to_date1" onchange="validate_validDate('from_date1','to_date1')" name="to_date1" placeholder="Valid To Date" title="Valid To Date" value="<?= get_date_user($query['valid_to_date'])?>">
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<input type="text" id="cancel_date1" name="cancel_date1" placeholder="Cancellation Date" title="Cancellation Date" value="<?= get_date_user($query['cancel_date'])?>">
					</div>
				</div>
			<div class="row mg_bt_10">
					<div class="col-sm-4 mg_bt_10_xs">
						<input type="text" id="reminder11" name="reminder11" placeholder="Reminder Date1" title="Reminder Date1" value="<?= get_date_user($query['reminder1'])?>">
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<input type="text" id="reminder21" name="reminder21" placeholder="Reminder Date2" title="Reminder Date2" value="<?= get_date_user($query['reminder2'])?>">
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<textarea placeholder="Note" title="Note" id="note1" name="note1" rows="2"><?= ($query['note'])?></textarea>
					</div>
					<div class="col-sm-4 mg_bt_10_xs">
						<select class="hidden" name="active_flag" id="active_flag" title="Active status" style="width:100%">
							<option value="<?= $query['active_flag']?>"><?= $query['active_flag']?></option>
							<option value="Active">Active</option>
							<option value="Inactive">Inactive</option>
						</select>
					</div>
				</div>
				<div class="row mg_tp_20 text-center">
					<div class="col-md-12">
						<button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
					</div>
				</div>
		</div>

		</div>

	</div>

</div>

</form>



<script>
$('#purchase_date1 , #from_date1 , #to_date1,#cancel_date1,#reminder11,#reminder21').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#inventory_update_modal').modal('show');
city_lzloading('#city_id1');

$(function(){
	$('#frm_save').validate({
		rules:{
				city_id1 : { required : true },
				hotel_name2 : { required : true },
		},
		submitHandler:function(form, e){
			e.preventDefault();
			var entry_id=$('#entry_id').val();
			var purchase_date = $('#purchase_date1').val();
			var city_id = $('#city_id1').val();
			var hotel_name = $('#hotel_name2').val();
			var room_type = $('#room_type1').val();
			var no_of_rooms = $('#no_of_rooms1').val();
			var rate = $('#rate1').val();
			var from_date = $('#from_date1').val();
			var to_date = $('#to_date1').val();
			var cancel_date = $('#cancel_date1').val();
			var reminder1 = $('#reminder11').val();
			var reminder2 = $('#reminder21').val();
			var note = $('#note1').val();
			var active_flag = $('#active_flag').val();

			$('#btn_update').button('loading');
			$.ajax({
				type:'post',
				url: base_url()+'controller/inventory/hotel/inventory_update.php',
				data:{ purchase_date : purchase_date,city_id : city_id, hotel_name : hotel_name ,room_type : room_type,no_of_rooms : no_of_rooms,rate : rate , from_date : from_date , to_date : to_date,cancel_date:cancel_date,reminder1:reminder1,reminder2:reminder2,note:note,entry_id:entry_id,active_flag:active_flag},
				success:function(result){
					var msg = result.split('--');
					if(msg[0] == 'error'){
						error_msg_alert(msg[1]);
						$('#btn_update').button('reset');
						return false;
					}else{
						msg_alert(result);
						$('#inventory_update_modal').modal('hide');
						list_reflect();
					}
				}
			});
		}
	});
});
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>