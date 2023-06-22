//Transfer Search From submit
$(function () {
	$('#frm_transfer_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var crm_base_url = $('#crm_base_url').val();
			var pickup_date = $('#pickup_date').val();
			var passengers = $('#passengers').val();
			var return_date = $('#return_date').val();
			
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
				error_msg_alert("Select Pickup location",base_url);
				return false;
			}
			if(pickup_date == ''){
				error_msg_alert("Please select Pickup Date & Time",base_url);
				return false;
			}
			var pickup_time = pickup_date.split(' ');
			console.log(typeof pickup_time[1]);
			if(pickup_time[1] === undefined){
				error_msg_alert("Select Pickup time",base_url);
				return false;
			}
			if(drop_to == ''){
				error_msg_alert("Select Drop-off location",base_url);
				return false;
			}
			if(passengers == ''){
				error_msg_alert("Please select passengers",base_url);
				return false;
			}
			var ele = document.getElementsByName('transfer_type');
			for(i = 0; i < 2; i++) { 
				if(ele[i].checked) {
					var trip_type = ele[i].value;
				}
			}
			if(trip_type === "roundtrip"){
				if(return_date == ""){ error_msg_alert('Please select Return Date & Time',base_url); return false; }
			}else{
				return_date = '';
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
			$.post(crm_base_url+'controller/b2b_transfer/b2b/search_session_save.php', { pick_drop_array: pick_drop_array }, function (data) {
				window.location.href = base_url + 'view/transfer/transfer-listing.php';
			});
		}
	});
});

//Check valid dates
function check_valid_date_trs () {
	var from = 'pickup_date';
	var to = 'return_date';
	var base_url = $('#base_url').val();
    var from_date = $('#' + from).val();
    var to_date = $('#' + to).val();

    var edates = from_date.split(' ');
    var edate = edates[0].split('/');
    e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
    var edatet = to_date.split(' ');
    var edate1 = edatet[0].split('/');
    e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

    var from_date_ms = new Date(e_date).getTime();
    var to_date_ms = new Date(e_date1).getTime();
    if (from_date_ms > to_date_ms) {
        error_msg_alert('Date should not be greater than valid to date',base_url);
        $('#' + from).css({ border: '1px solid red' });
        document.getElementById(from).value = '';
        $('#' + from).focus();
        g_validate_status = false;
        return false;
    } else {
        $('#' + from).css({ border: '1px solid #ddd' });
        return true;
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