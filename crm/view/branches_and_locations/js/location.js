function locations_list_reflect()
{
	$.post('locations/locations_list_reflect.php', {}, function(data){
		$('#location_list_div').html(data);
	});
}
locations_list_reflect();

function location_edit_modal(location_id)
{
	$.post('locations/location_edit_modal.php', { location_id : location_id }, function(data){
		$('#div_location_edit_modal').html(data);
	});
}