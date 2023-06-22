// Off display dummy data in inputs/fields
$(function () {
	$('form').attr('autocomplete', 'off');
	$('input').attr('autocomplete', 'off');
});
//Visa Search From submit
$(function () {
	$('#frm_visa_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var base_url_b2c = $('#crm_base_url').val();
			var country_id = $('#visa_country_filter').val();

			var visa_array = [];
			visa_array.push({
				'country_id' : country_id
			})
			$.post(base_url_b2c+'controller/visa_master/search_session_save.php', { visa_array: visa_array }, function (data) {
				window.location.href = base_url + 'view/visa/visa-listing.php';
			});
		}
	});
});
