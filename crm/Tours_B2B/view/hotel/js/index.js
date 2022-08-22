//Off display dummy data in inputs/fields
$(function () {
	$('form').attr('autocomplete', 'off');
	$('input').attr('autocomplete', 'off');
});

//Hotel list load
function hotel_names_load (id) {
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.post(base_url + 'Tours_B2B/view/hotel/inc/hotel_list_load.php', { city_id: city_id }, function (data) {
		$('#hotel_name_filter').html(data);
	});
}
//Calculate total stay
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

//Add Rooms on Search
function display_addRooms_modal () {
	var base_url = $('#base_url').val();
	var initial_array = [];
	initial_array.push({
		rooms : {
			room     : 1,
			adults   : 2,
			child    : 0,
			childAge : []
		}
	});
	var final_arr = sessionStorage.getItem('final_arr') || JSON.stringify(initial_array);
	$.post(base_url + 'Tours_B2B/view/hotel/display_addRooms_modal.php', { final_arr: final_arr }, function (data) {
		$('#display_addRooms_modal').html(data);
	});
}

//Hotel Search generate no-of-rooms
function generate_rooms () {
	var base_url = $('#base_url').val();
	var roomCount = $('#dynamic_room_count').val();

	$.post(base_url + 'Tours_B2B/view/hotel/inc/generate_hotel_rooms.php', { roomCount: roomCount }, function (data) {
		$('#roomListing1').append(data);
		roomCount = parseFloat(roomCount) + 1;
		$('#dynamic_room_count').val(roomCount);
		if (parseFloat(roomCount) > 1) document.getElementById('deleteRoom').style.display = 'inline-block';
		if (parseFloat(roomCount) >= 5) {
			document.getElementById('addRooms').style.display = 'none';
		}
	});
	initilizeDropdown();
}

//Hotel Search delete room
function delete_rooms () {
	var roomCount = $('#dynamic_room_count').val();
	document.getElementById('room-' + roomCount).remove();

	if (parseFloat(roomCount) <= 5) {
		document.getElementById('addRooms').style.display = 'inline-block';
	}
	roomCount = parseFloat(roomCount) - 1;
	$('#dynamic_room_count').val(roomCount);
	if (parseFloat(roomCount) == 1) {
		document.getElementById('deleteRoom').style.display = 'none';
	}
}

//Hotel child ages dropdowns
function generate_child_ages (noOfChilds, roomCount) {
	var base_url = $('#base_url').val();
	var noOfChild = $('#' + noOfChilds).val();

	$.post(
		base_url + 'Tours_B2B/view/hotel/inc/generate_child_ages.php',
		{ noOfChild: noOfChild, roomCount: roomCount },
		function (data) {
			$('#childAge-' + roomCount).html(data);
		}
	);
}
//Hotel Search From submit
$(function () {
	$('#frm_hotel_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var page_type = $('#page_type').val();
			var city_id = $('#hotel_city_filter').val();
			var hotel_id = $('#hotel_name_filter').val();
			var check_indate = $('#checkInDate').val();
			var check_outdate = $('#checkOutDate').val();

			var star_category_arr = [];
			$('input[name="star_category"]:checked').each(function () {
				if ($(this).val()) {
					var star_calue = "'" + $(this).val() + " Star'";
				}
				star_category_arr.push(star_calue);
			});
			if ((typeof city_id === 'object'|| city_id == '') && hotel_id == '') {
				error_msg_alert('Select atleast the City!');
				return false;
			}
			if (check_indate == '' || check_outdate == '') {
				error_msg_alert('Invalid Check-In Check-Out Date!');
				return false;
			}
			var valid = check_valid_dates();
			if (!valid) {
				error_msg_alert('Invalid Check-In Check-Out Date!');
				return false;
			}

			var dynamic_room_count = $('#dynamic_room_count').val();
			var adult_count = $('#adult_count').val();
			var child_count = $('#child_count').val();
			adult_count =

					adult_count == '' || typeof adult_count == 'NaN' ? 0 :
					adult_count;
			child_count =

					child_count == '' || typeof child_count == 'NaN' ? 0 :
					child_count;
			var final_arr = [];
			for (var i = 1; i <= dynamic_room_count; i++) {
				var room_count = $('#' + 'roomcount-' + i).html();
				var adult_count1 = $('#' + 'room-' + i + 'Adult').val();
				var child_count1 = $('#' + 'room-' + i + 'Child').val();
				if(sessionStorage.getItem('final_arr') === null){
					
					if (typeof room_count == 'undefined') {
						final_arr.push({
							rooms : {
								room     : parseInt(1),
								adults   : parseInt(2),
								child    : parseInt(0),
								childAge : []
							}
						});
						adult_count = 2;
						child_count = 0;
					}
					else{
						var child_age_arr = [];
						for (var j = 0; j < child_count1; j++) {
							var child_age = $('#' + 'child-' + i + j).val();
							if (typeof child_age != 'undefined') {
								child_age_arr.push(parseInt(child_age));
							}
						}
						final_arr.push({
							rooms : {
								room     : parseInt(room_count),
								adults   : parseInt(adult_count1),
								child    : parseInt(child_count1),
								childAge : child_age_arr
							}
						});
						adult_count = adult_count1;
						child_count = child_count1;
					}
				}
				else{
					final_arr = JSON.parse(sessionStorage.getItem('final_arr'));
					for (var n = 0; n < final_arr.length; n++) {
						adult_count = parseFloat(adult_count) + parseFloat(final_arr[n]['rooms']['adults']);
						child_count = parseFloat(child_count) + parseFloat(final_arr[n]['rooms']['child']);
					}
				}
			}
			final_arr = JSON.stringify(final_arr);
			// Store
			if (window.sessionStorage) {
				try {
					sessionStorage.setItem('final_arr', final_arr);
				} catch (e) {
					console.log(e);
				}
			}
			var nationality = $('#nationality').val();
			var hotel_array = [];
			hotel_array.push({
				'city_id' : city_id,
				'hotel_id' : hotel_id,
				'check_indate' : check_indate,
				'check_outdate' : check_outdate,
				'star_category_arr' : star_category_arr,
				'dynamic_room_count' : dynamic_room_count,
				'adult_count' : adult_count,
				'child_count' : child_count,
				'final_arr' : final_arr,
				'nationality' : nationality
			})
			$.post(base_url+'controller/hotel/b2b/search_session_save.php', { hotel_array: hotel_array }, function (data) {
				window.location.href = base_url + 'Tours_B2B/view/hotel/hotel-listing.php';
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

