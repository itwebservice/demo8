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



});