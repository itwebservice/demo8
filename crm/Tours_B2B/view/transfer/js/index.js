//Transfer Search From submit
$(function () {
	$('#frm_transfer_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var pickup_date = $('#pickup_date').val();
			var passengers = $('#passengers').val();
			var return_date = $('#return_date').val();
			
			var ele = document.getElementsByName('transfer_type');
			for(i = 0; i < 2; i++) { 
				if(ele[i].checked) {
					var trip_type = ele[i].value;
				}
			}
			if(trip_type === "roundtrip"){
				if(return_date == ""){ error_msg_alert('Please select Return Date & Time '); return false; }
				var valid = check_valid_date_trs();
				if (!valid) {
					error_msg_alert('Invalid Pickup and Return Date!');
					return false;
				}
			}else{
				return_date = '';
			}
			var pickup_type = 0;
			var pickup_from = 0;
			var drop_type = 0;
			var drop_to = 0;
			$('#pickup_location').find("option:selected").each(function(){
				pickup_type = ($(this).closest('optgroup').attr('value'));
				pickup_from = ($(this).closest('option').attr('value'));
			});
			$('#dropoff_location').find("option:selected").each(function(){
				drop_type = ($(this).closest('optgroup').attr('value'));
				drop_to = ($(this).closest('option').attr('value'));
			});
			if(pickup_from == ''){
				error_msg_alert("Select Pickup location");
				return false;
			}
			if(drop_to == ''){
				error_msg_alert("Select Drop-off location");
				return false;
			}
			if(pickup_date == ''){
				error_msg_alert("Please select Pickup Date & Time");
				return false;
			}
			if(passengers == ''){
				error_msg_alert("Please select passengers");
				return false;
			}
			var pick_drop_array = [];
			pick_drop_array.push({
				'trip_type':trip_type,
				'pickup_type':pickup_type,
				'pickup_from':pickup_from,
				'drop_type':drop_type,
				'drop_to':drop_to,
				'pickup_date':pickup_date,
				'return_date':return_date,
				'passengers':passengers
			})
			$.post(base_url+'controller/b2b_transfer/b2b/search_session_save.php', { pick_drop_array: pick_drop_array }, function (data) {
				window.location.href = base_url + 'Tours_B2B/view/transfer/transfer-listing.php';
			});
		}
	});
});

//Check valid dates
function check_valid_date_trs () {
	var from_date = $('#pickup_date').val();
	var to_date = $('#return_date').val();
	var edate = from_date.split(' ');
	var edate1 = edate[0].split('/');
	var edatetime = edate[1].split(':');
	e_date = new Date(edate1[2], edate1[0] - 1, edate1[1],edatetime[0],edatetime[1]).getTime();
	var edate2 = to_date.split(' ');
	var edate3 = edate2[0].split('/');
	var edatetime1 = edate2[1].split(':');
	var edate1 = to_date.split('/');
	e_date1 = new Date(edate3[2], edate3[0] - 1, edate3[1],edatetime1[0],edatetime1[1]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (to_date_ms < from_date_ms) {
		return false;
	}
	return true;
}

function fields_enable_disable(){
    var ele = document.getElementsByName('transfer_type');
    for(i = 0; i < 2; i++) { 
        if(ele[i].checked) {
            if(ele[i].value == 'oneway'){
                document.getElementById('return_date').readOnly = true;
                $('#return_date').datetimepicker('destroy');
            }
            else{
                document.getElementById('return_date').readOnly = false;
                $('#return_date').datetimepicker({ format:'m/d/Y H:i',minDate:new Date() });
            }
        }
    } 
}
//Get DateTime
function get_to_datetime (from_date, to_date) {
	var from_date1 = $('#' + from_date).val();
	if (from_date1 != '') {
		var edate = from_date1.split(' ');
		var edate1 = edate[0].split('/');
		var edatetime = edate[1].split(':');
		var e_date_temp = new Date(
			edate1[2],
			edate1[0] - 1,
			edate1[1],
			edatetime[0],
			edatetime[1]
		).getTime();

		var currentDate = new Date(new Date(e_date_temp).getTime() + 24 * 60 * 60 * 1000);
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		var hours = currentDate.getHours();
		var minute = currentDate.getMinutes();
		if (day < 10) {
			day = '0' + day;
		}
		if (month < 10) {
			month = '0' + month;
		}
		if (hours < 10) {
			hours = '0' + hours;
		}
		if (minute < 10) {
			minute = '0' + minute;
		}
		$('#' + to_date).val(month + '/' + day + '/' + year + ' ' + hours + ':' + minute);
	}
	else {
		$('#' + to_date).val('');
	}
}