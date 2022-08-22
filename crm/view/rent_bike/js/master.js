columns = [
	{ title: 'S_No.' },
	{ title: 'Bike_type' },
	{ title: 'Bike_name' },
	{ title: 'Manufacturer(Model)' },
	{ title: 'Seating_capacity' },
	{ title: 'Actions', className: 'text-center' }
];
function master_list_reflect () {
	
	var active_flag = $('#active_flag_filter').val();
	$.post('master/list_reflect.php', {active_flag:active_flag}, function (data) {
		setTimeout(() => {
			pagination_load(data, columns, true, false, 20, 'tbl_list');
		}, 1000);
	});
}
master_list_reflect();

function edit_modal (entry_id) {
	$.post('master/edit_modal.php', { entry_id: entry_id }, function (data) {
		$('#div_edit_modal').html(data);
	});
}

function bike_type_modal () {
	$.post('master/save_bike_type.php', {}, function (data) {
		$('#div_view_modal').html(data);
	});
}

$(function () {
	$('#frm_master_save').validate({
		rules : {},
		submitHandler : function (form) {
			
			$('#save').prop('disabled', true);

			var base_url = $('#base_url').val();
			var bike_type = $('#bike_type').val();
			var bike_name = $('#bike_name').val();
			var manufacturer = $('#manufacturer').val();
			var model_name = $('#model_name').val();
			var seating_capacity = $('#seating_capacity').val();
			var pickup_time = $('#pickup_time').val();
			var drop_time = $('#drop_time').val();
			var image_upload_url = $('#image_upload_url').val();
			var incl = $('#incl').val();
			var excl = $('#excl').val();
			var terms = $('#terms').val();
			var canc_policy = $('#canc_policy').val();
			$('#save').button('loading');
			$.ajax({
				type    : 'post',
				url     : base_url + 'controller/rent_bike/vehicle_save.php',
				data    : {
					bike_type: bike_type,
					bike_name: bike_name,
					manufacturer: manufacturer,
					model_name:model_name,
					seating_capacity:seating_capacity,
					pickup_time:pickup_time,
					drop_time:drop_time,
					image_upload_url:image_upload_url,
					incl:incl,
					excl:excl,
					terms:terms,
					canc_policy: canc_policy
				},
				success : function (result) {
					var msg = result.split('--');
					$('#save').button('reset');
					if (msg[0] == 'error') {
						error_msg_alert(msg[1]);
						$('#save').prop('disabled', false);
						return false;
					}
					else {
						msg_alert(result);
						update_b2c_cache();
						// master_list_reflect();
						location.reload();
						reset_form('frm_master_save');
						$('#save').prop('disabled', false);
						$('#master_save_modal').modal('hide');
					}
				}
			});
		}
	});
});
