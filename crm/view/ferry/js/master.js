var columns = [
	{ title: 'S_No.' },
	{ title: 'Ferry/Cruise_type' },
	{ title: 'Ferry/Cruise_name' },
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

$(function () {
	$('#frm_master_save').validate({
		rules         : {},
		submitHandler : function (form) {

			$('#tsave').prop('disabled',true);
			var base_url = $('#base_url').val();
			var image_upload_url = $('#ferry_image_urls').val();
			var ferry_type = $('#ferry_type').val();
			var ferry_name = $('#ferry_name').val();
			var seating_capacity = $('#seating_capacity').val();
			var childfrom = $('#childfrom').val();
			var childto = $('#childto').val();
			var infantfrom = $('#infantfrom').val();
			var infantto = $('#infantto').val();
			var inclusions = $('#inclusions').val();
			var exclusions = $('#exclusions').val();
			var terms = $('#terms').val();

			$('#save').button('loading');
			$.ajax({
				type  : 'post',
				url   : base_url + 'controller/ferry/ferry_save.php',
				data  : {
					ferry_type : ferry_type,
					ferry_name : ferry_name,
					seating_capacity : seating_capacity,
					image_upload_url: image_upload_url,
					childfrom:childfrom,
					childto:childto,
					infantfrom:infantfrom,
					infantto:infantto,
					inclusions:inclusions,
					exclusions:exclusions,
					terms:terms
				},
				success : function (result) {
					var msg = result.split('--');
					$('#save').button('reset');
					if (msg[0] == 'error') {
						error_msg_alert(msg[1]);
						$('#tsave').prop('disabled',false);
						return false;
					}
					else {
						msg_alert(result);
						update_b2c_cache();
						master_list_reflect();
						$('#tsave').prop('disabled',false);
						reset_form('frm_master_save');
						$('#master_save_modal').modal('hide');
					}
				}
			});
		}
	});
});
