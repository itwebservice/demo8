<?php
include "../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Hotel Inventory</h4>
      </div>

      <div class="modal-body">
			<div class="row mg_bt_10">
				<div class="col-sm-4 mg_bt_10_xs">
					<input type="text" id="purchase_date" name="purchase_date" placeholder="*Purchase Date" title="Purchase Date">
				</div>
				<div class="col-sm-4 mg_bt_10_xs">
					<select name="city_id" id="city_id" title="Select City" style="width:100%" onchange="load_hotel_list(this.id); ">
					</select>
				</div>
				<div class="col-sm-4 mg_bt_10_xs">
					<select name="hotel_name1" id="hotel_name1" title="Select Hotel" style="width:100%">
						<option value="">Select Hotel</option>
					</select>
				</div>
			</div>
			<div class="row mg_bt_10">
				<div class="col-sm-4">
					<select id="room_type" name="room_type" title="*Category">
						<?php echo get_room_category_dropdown(); ?>
					</select>
				</div>
				<div class="col-sm-4">
					<input type="text" id="no_of_rooms" name="no_of_rooms" placeholder="*Total Rooms" title="Total Rooms" onchange="validate_balance(this.id);">
				</div>
				<div class="col-sm-4">
					<input type="text" id="rate" name="rate" placeholder="*Rate" title="Rate" onchange="validate_balance(this.id);">
				</div>
			</div>
		    <div class="row mg_bt_10">
				<div class="col-sm-4 mg_bt_10_xs">
					<input type="text" id="from_date" name="from_date" placeholder="*Valid From Date" title="Valid From Date" onchange="get_to_date(this.id,'to_date')">
				</div>
				<div class="col-sm-4 mg_bt_10_xs">
					<input type="text" id="to_date" name="to_date" placeholder="*Valid To Date" title="Valid To Date" onchange="validate_validDate('from_date','to_date')">
				</div>
				<div class="col-sm-4 mg_bt_10_xs">
					<input type="text" id="cancel_date" name="cancel_date" placeholder="Cancellation Date" title="Cancellation Date">
				</div>
			</div>
		   <div class="row mg_bt_10">
				<div class="col-sm-4 mg_bt_10_xs">
					<input type="text" id="reminder1" name="reminder1" placeholder="Reminder Date1" title="Reminder Date1">
				</div>
				<div class="col-sm-4 mg_bt_10_xs">
					<input type="text" id="reminder2" name="reminder2" placeholder="Reminder Date2" title="Reminder Date2">
				</div>
				<div class="col-sm-4 mg_bt_10_xs">
			 		<textarea placeholder="Note" title="Note" id="note" name="note" rows="2"></textarea>
				 </div>
			 </div>
			<div class="row mg_tp_20 text-center">
				<div class="col-md-12">
					<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
				</div>
			</div>
      </div>

    </div>

  </div>

</div>

</form>



<script>

city_lzloading('#city_id');
$('#purchase_date , #from_date , #to_date,#cancel_date,#reminder1,#reminder2').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#save_modal').modal('show');

/**Hotel Name load start**/
function load_hotel_list(id){
  var city_id = $("#"+id).val();
  var count = id.substring(10);
  $.get( "hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
    $ ("#hotel_name1"+count).html(data);
  });
}

$(function(){
	$('#frm_save').validate({
		rules:{
				city_id : { required : true },
				hotel_name1 : { required : true },
				no_of_rooms : { required : true },
				from_date : { required : true },
				to_date : { required : true },
				purchase_date : { required : true },
				room_type : { required : true },
				rate : { required : true }
		},
		submitHandler:function(form){

			var purchase_date = $('#purchase_date').val();
			var city_id = $('#city_id').val();
			var hotel_name = $('#hotel_name1').val();
			var room_type = $('#room_type').val();
			var no_of_rooms = $('#no_of_rooms').val();
			var rate = $('#rate').val();
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var cancel_date = $('#cancel_date').val();
			var reminder1 = $('#reminder1').val();
			var reminder2 = $('#reminder2').val();
			var note = $('#note').val();

			$('#btn_save').button('loading');
			$.ajax({
				type:'post',
				url: base_url()+'controller/inventory/hotel/inventory_save.php',
				data:{ purchase_date : purchase_date,city_id : city_id, hotel_name : hotel_name ,room_type : room_type,no_of_rooms : no_of_rooms,rate : rate , from_date : from_date , to_date : to_date,cancel_date:cancel_date,reminder1:reminder1,reminder2:reminder2,note:note},
				success:function(result){
					var msg = result.split('--');
					if(msg[0] == 'error'){
						error_msg_alert(msg[1]);
						$('#btn_save').button('reset');
						return false;
					}else{
						msg_alert(result);
						$('#save_modal').modal('hide');
						list_reflect();
					}
				}
			});
		}
	});
});
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>