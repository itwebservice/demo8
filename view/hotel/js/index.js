// Off display dummy data in inputs/fields
$(function () {
	$('form').attr('autocomplete', 'off');
	$('input').attr('autocomplete', 'off');
});
// Hotel list load
function hotel_names_load (id) {
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.post(base_url + 'view/hotel/inc/hotel_list_load.php', { city_id: city_id }, function (data) {
		$('#hotel_name_filter').html(data);
	});
}
// Calculate total stay
function total_nights_reflect (offset = '') {
	var from_date = $('#checkInDate' + offset).val();
	var to_date = $('#checkOutDate' + offset).val();
	var edate = from_date.split('/');
	e_date = new Date(edate[2], edate[0] - 1, edate[1]).getTime();
	var edate1 = to_date.split('/');
	e_date1 = new Date(edate1[2], edate1[0] - 1, edate1[1]).getTime();

	var one_day = 1000 * 60 * 60 * 24;

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	var difference_ms = to_date_ms - from_date_ms;
	var total_days = Math.round(Math.abs(difference_ms) / one_day);
	total_days =

			typeof total_days === NaN ? 0 :
			parseFloat(total_days);
	var night =

			total_days == 1 ? total_days + ' NIGHT' :
			total_days + ' NIGHTS';
	document.getElementById('total_stay').style.display = 'block';
	$('#total_stay').html(night);
}
//Check valid dates
function check_valid_dates () {
	var from_date = $('#checkInDate').val();
	var to_date = $('#checkOutDate').val();
	var edate = from_date.split('/');
	e_date = new Date(edate[2], edate[0] - 1, edate[1]).getTime();
	var edate1 = to_date.split('/');
	e_date1 = new Date(edate1[2], edate1[0] - 1, edate1[1]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (to_date_ms < from_date_ms) {
		return false;
	}
	return true;
}
//Auto checkout date calculate
function get_to_date (from_date, to_date) {
	var from_date1 = $('#' + from_date).val();
	if (from_date1 != '') {
		var edate = from_date1.split('/');
		e_date = new Date(edate[2], edate[0] - 1, edate[1]).getTime();
		var currentDate = new Date(new Date(e_date).getTime() + 24 * 60 * 60 * 1000);
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) {
			day = '0' + day;
		}
		if (month < 10) {
			month = '0' + month;
		}
		$('#' + to_date).val(month + '/' + day + '/' + year);
	}
	else {
		$('#' + to_date).val('');
	}
	total_nights_reflect();
}

//Hotel Search From submit
$(function () {
	$('#frm_hotel_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var base_url_b2c = $('#crm_base_url').val();
			var page_type = $('#page_type').val();
			var city_id = $('#hotel_city_filter').val();
			var hotel_id = $('#hotel_name_filter').val();
			var check_indate = $('#checkInDate').val();
			var check_outdate = $('#checkOutDate').val();
			var total_rooms = $('#total_rooms').val();

			var star_category_arr = [];
			$('input[name="star_category"]:checked').each(function () {
				if ($(this).val()) {
					var star_calue = "'" + $(this).val() + " Star'";
				}
				star_category_arr.push(star_calue);
			});
			if ((typeof city_id === 'object'|| city_id == '') && hotel_id == '') {
				error_msg_alert('Select atleast the City!',base_url);
				return false;
			}
			if (check_indate == '' || check_outdate == '') {
				error_msg_alert('Invalid Check-In Check-Out Date!',base_url);
				return false;
			}
			var valid = check_valid_dates();
			if (!valid) {
				error_msg_alert('Invalid Check-In Check-Out Date!',base_url);
				return false;
			}
			var hotel_array = [];
			hotel_array.push({
				'city_id' : city_id,
				'hotel_id' : hotel_id,
				'check_indate' : check_indate,
				'check_outdate' : check_outdate,
				'star_category_arr' : star_category_arr,
				'total_rooms' : total_rooms
			})
			$.post(base_url_b2c+'controller/hotel/b2c_search_session_save.php', { hotel_array: hotel_array }, function (data) {
				window.location.href = base_url + 'view/hotel/hotel-listing.php';
			});
		}
	});
});

//Get Amenities by mathcing name
function getObjects (obj, key, val) {
	var objects = [];
	for (var i in obj) {
		if (!obj.hasOwnProperty(i)) continue;
		if (typeof obj[i] == 'object') {
			objects = objects.concat(getObjects(obj[i], key, val));
		}
		else if ((i == key && obj[i] == val) || (i == key && val == '')) {
			//if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
			//
			objects.push(obj);
		}
		else if (obj[i] == val && key == '') {
			//only add if the object is not already in the array
			if (objects.lastIndexOf(obj) == -1) {
				objects.push(obj);
			}
		}
	}
	return objects;
}