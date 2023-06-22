//activities list load
function activities_names_load (id) {
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.post(base_url + 'view/activities/inc/activities_list_load.php', { city_id: city_id }, function (data) {
		$('#activities_name_filter').html(data);
	});
}
//Transfer Search From submit
$(function () {
	$('#frm_activities_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var crm_base_url = $('#crm_base_url').val();
			var activity_city_id = $('#activities_city_filter').val();
			var activities_id = $('#activities_name_filter').val();
            var checkDate = $('#checkDate').val();
            var adult = $('#adult').val();
            var child = $('#child').val();
            var infant = $('#infant').val();
			if ((typeof activity_city_id === 'object'|| activity_city_id == '') && activities_id == '') {
				error_msg_alert('Select atleast the City!',base_url);
				return false;
            }
            if(parseInt(adult) === 0){
				error_msg_alert('Select No of. Adults!',base_url);
				return false;
            }
            
			var activity_array = [];
			activity_array.push({
				'activity_city_id':activity_city_id,
				'activities_id':activities_id,
				'checkDate':checkDate,
				'adult':parseInt(adult),
				'child':parseInt(child),
				'infant':parseInt(infant)
			})
			$.post(crm_base_url+'controller/b2b_excursion/b2b/search_session_save.php', { activity_array: activity_array }, function (data) {
				window.location.href = base_url + 'view/activities/activities-listing.php';
			});
		}
	});
});