//Tours Search From submit
$(function () {
	$('#frm_ferry_search').validate({
		rules         : {},
		submitHandler : function (form) {

			var base_url = $('#base_url').val();
			var from_city = $('#ffrom_city_filter').val();
			var to_city = $('#fto_city_filter').val();
            var travel_date = $('#ftravelDate').val();
            var adult = $('#fadults').val();
            var children = $('#fchildren').val();
            var infant = $('#finfant').val();

			if (from_city == ''||from_city == null) {
				error_msg_alert('Enter from location!');
				return false;
            }
			if (to_city == ''||to_city == null) {
				error_msg_alert('Enter to location!');
				return false;
            }
			if (travel_date == '') {
				error_msg_alert('Enter travel date!');
				return false;
            }
            if(parseInt(adult) === 0){
				error_msg_alert('Enter No of. Adults!');
				return false;
            }
			if(children == '') { children = 0; }
			if(infant == '') { infant = 0; }
			
			var ferry_array = [];
			ferry_array.push({
				'from_city':from_city,
				'to_city':to_city,
				'travel_date':travel_date,
				'adult':parseInt(adult),
				'children':parseInt(children),
				'infant':parseInt(infant)
			})
			$.post(base_url+'controller/ferry/search_session_save.php', { ferry_array: ferry_array }, function (data) {
				window.location.href = base_url + 'Tours_B2B/view/ferry/ferry-listing.php';
			});
		}
	});
});