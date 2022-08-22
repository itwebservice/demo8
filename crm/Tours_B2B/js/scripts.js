$(document).ready(function () {
	$(function () {
		$('form').attr('autocomplete', 'off');
		$('input').attr('autocomplete', 'off');
		
		//Lazy Load the cities
		city_lzloading('#hotel_city_filter,#activities_city_filter,#city,#ffrom_city_filter,#fto_city_filter');
	});

	if ($('.dropdown.selectable').length > 0) {
		$('.dropdown.selectable .dropdown-item').on('click', function(){
			var thisOption = $(this)[0].textContent;
			$(this).parents('.dropdown.selectable').children('.btn-dd')[0].textContent = thisOption;
		})
	}
	
	$('body').delegate('.c-userBlock .card .st-editProfile', 'click', function(){
		var thidParent = $(this).parents('.card');
		if(!thidParent.hasClass('st-editable')){
		thidParent.addClass('st-editable');
		thidParent.find('.formField').find('.txtBox').prop('readonly', false);
		thidParent.find('.formField').find('.txtBox').prop('disabled', false);
		}else{
		thidParent.removeClass('st-editable');
		thidParent.find('.formField').find('.txtBox').prop('readonly', true);
		thidParent.find('.formField').find('.txtBox').prop('disabled', true);
		}
	})
	$('.mobile_hamb, .closeSidebar').on('click',function(){
		$('body').addClass('st-sidebarOpen');
	});
	$('.closeSidebar').on('click',function(){
		$('body').removeClass('st-sidebarOpen');
	});
	// initilizeDropdown();
	if ($('.js-cardSlider').length > 0) {
		$('.js-cardSlider').owlCarousel({
			loop       : false,
			margin     : 16,
			nav        : true,
			dots       : false,
			responsive : {
				0    : {
					items : 1
				},
				560  : {
					items : 2
				},
				960  : {
					items : 3
				},
				1024 : {
					items : 4
				}
			}
		});
	}

	if ($('.js-mainSlider').length > 0) {
		$('.js-mainSlider').owlCarousel({
			margin             : 0,
			nav                : false,
			dots               : false,
			items              : 1,
			loop               : true,
			autoplay           : true,
			autoplayHoverPause : true,
			smartSpeed         : 1500
			});
	}

	// filters option
	$('.c-checkSquare .filterCheckbox').on('click', function () {
		//e.preventDefault();
		if ($(this).hasClass('st-checked')) {
			$(this).removeClass('st-checked');
		}
		else {
			$(this).addClass('st-checked');
		}
	});

	//**Site Tooltips
	$(function () {
		if($("[data-toggle='tooltip']").length > 0){
			$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
		}
	});

	if ($('.c-select2DD').length) {
		// 	$('.c-select2DD select').select2();
		$('.c-select2DD select').select2({
			minimumInputLength : 1
		});
	}
	
	// ------ Function to load gallery after inirialize
	$("body").delegate(".js-gallery", "click", function() {
		const tabID = $(this).attr("id");
		const galleryID = $("#gallery-" + tabID.split("-")[1]);
		if (galleryID.hasClass("loaded")) {
		  return;
		} else {
		  galleryID.prepend('<div class="galleryLoader"></div>');
		  setTimeout(function() {
			galleryID.children(".galleryLoader").remove();
			galleryID.find(".c-photoGallery").removeClass("js-dynamicLoad");
			galleryID.addClass("loaded");
		  }, 1500);
		}
	  });
});
function error_msg_alert(message){
	var base_url = $('#base_url').val();
	var class_name = 'alert-danger';
	$.post(base_url+'Tours_B2B/notification_modal.php', {message:message,class_name:class_name}, function(data){
		// $('#site_alert').html(data);
		$('#site_alert').empty(); // to only display one error message
		$('#site_alert').vialert({ type: 'error', title: 'Error', message: data, delay: 3000 });
	});
}
function success_msg_alert(message){
	var base_url = $('#base_url').val();
	var class_name = 'alert-success';
	$.post(base_url+'Tours_B2B/notification_modal.php', {message:message,class_name:class_name}, function(data){
		// $('#site_alert').html(data);
		$('#site_alert').empty(); // to only display one error message
		$('#site_alert').vialert({ message: data, delay: 3000 });
	});
}

function blockSpecialChar(e) {
	var k = e.keyCode;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32  || (k >= 48 && k <= 57));
}

// Compare best low cost with price-range filter minmax values
function compare (best_lowest_cost, fromRange_cost, toRange_cost) {
	if (
		parseFloat(best_lowest_cost) >= parseFloat(fromRange_cost) &&
		parseFloat(best_lowest_cost) <= parseFloat(toRange_cost)
	)
		return 1;
}
// JQuery range slider
function reinit(bestlow_cost,besthigh_cost){
	var randno = 'slider_'+new Date().getTime();
	$('.slider-input').attr({
	  id: randno,
	  min: parseFloat(bestlow_cost).toFixed(2),
	  max: parseFloat(besthigh_cost).toFixed(2)
	});
	var valueText = parseFloat(bestlow_cost).toFixed(2) + ',' + parseFloat(besthigh_cost).toFixed(2); 
	$('#'+randno).val(valueText);
	
	var rangeMinValue = document.getElementById(randno).min;
	var rangeMaxValue = document.getElementById(randno).max;
	var rangeStep = $('#'+randno).data('step');
	
	$('#'+randno).jRange({
	  from       : rangeMinValue,
	  to         : rangeMaxValue,
	  step       : rangeStep,
	  showLabels : true,
	  isRange    : true,
	  width      : 230,
	  showScale  : true,
	  onbarclicked: function() { 
		passSliderValue();
	  },
	  ondragend: function() { 
		passSliderValue();
	  }
	});
}

//Generate uuid for each item
function uuidv4() {
	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
	var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
	return v.toString(16);
	});
}
//Display Cart
function display_cart(cart_item_count){
	var base_url = $('#base_url').val();
	var register_id = $('#register_id').val();
	var cart_item_count = $('#'+cart_item_count).html();
	
	if (typeof Storage !== 'undefined') {
		if (localStorage) {
			var cart_list_arr = JSON.parse(localStorage.getItem('cart_list_arr'));
		} 
		else {
			var cart_list_arr = JSON.parse(window.sessionStorage.getItem('cart_list_arr'));	
		}
	}
	$.post(base_url + 'Tours_B2B/cart_data_modal.php', { cart_list_arr : cart_list_arr,register_id:register_id }, function (data) {
		$('#cart_div').html(data);
	}) 
}
//Get Cart data items
function get_cart_items(cart_list_arr){
	var base_url = $('#base_url').val();
    $.post(base_url + 'Tours_B2B/get_cart_items.php', { cart_list_arr : cart_list_arr }, function (data) {
		$('#cart_items').html(data);
	});
}
//Get checkout page cart data items
function get_checkoutpage_cart(){
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
		}
		else {
			var cart_list_arr = JSON.parse(window.sessionStorage.getItem('cart_list_arr'));	
		}
	}

    $.post(base_url + 'Tours_B2B/checkout_pages/get_checkoutpage_cart.php', { cart_list_arr : cart_list_arr,currency : currency_id}, function (data) {
		$('#get_checkoutpage_cart').html(data);
	});
}
//Checkout page country selection
function get_country_code(country_id,country_code){
	var base_url = $('#base_url').val();
	var country_id = $('#'+country_id).val();

	$.post(base_url + 'Tours_B2B/view/get_country_code.php', { country_id : country_id}, function (data) {
		$('#country_code').val(data);
	});
}
function get_select_hotel(city_id,hotel_id,check_indate,check_outdate){

	var base_url = $('#base_url').val();
	var final_arr = [];
	final_arr.push({
		rooms : {
			room     : parseInt(1),
			adults   : parseInt(2),
			child    : parseInt(0),
			childAge : []
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
		'city_id' : city_id,
		'hotel_id' : hotel_id,
		'check_indate' : check_indate,
		'check_outdate' : check_outdate,
		'star_category_arr' : [],
		'dynamic_room_count' : parseInt(1),
		'adult_count' : adult_count,
		'child_count' : child_count,
		'final_arr' : final_arr,
		'nationality' : ''
	})
	$.post(base_url+'controller/hotel/b2b/search_session_save.php', { hotel_array: hotel_array }, function (data) {
		window.location.href = base_url + 'Tours_B2B/view/hotel/hotel-listing.php';
	});
}
function get_select_activity(activity_city_id,activities_id,checkDate){
	
	var base_url = $('#base_url').val();
	var adult = 1;
	var child = 0;
	var infant = 0;
	
	var activity_array = [];
	activity_array.push({
		'activity_city_id':activity_city_id,
		'activities_id':activities_id,
		'checkDate':checkDate,
		'adult':parseInt(adult),
		'child':parseInt(child),
		'infant':parseInt(infant)
	})
	$.post(base_url+'controller/b2b_excursion/b2b/search_session_save.php', { activity_array: activity_array }, function (data) {
		window.location.href = base_url + 'Tours_B2B/view/activities/activities-listing.php';
	});
}
function get_select_package(dest_id,tour_id,tour_date){
	
	var base_url = $('#base_url').val();
	var adult = 2;
	
	if (dest_id == '' && tour_id == '') {
		error_msg_alert('Select atleast Destination!');
		return false;
	}
	if(parseInt(adult) === 0){
		error_msg_alert('Select No of. Adults!');
		return false;
	}
	
	var tours_array = [];
	tours_array.push({
		'dest_id':dest_id,
		'tour_id':tour_id,
		'tour_date':tour_date,
		'adult':parseInt(adult),
		'child_wobed':parseInt(0),
		'child_wibed':parseInt(0),
		'extra_bed':parseInt(0),
		'infant':parseInt(0)
	})
	$.post(base_url+'controller/custom_packages/search_session_save.php', { tours_array: tours_array }, function (data) {
		window.location.href = base_url + 'Tours_B2B/view/tours/tours-listing.php';
	});
}
function get_select_hotel_guest(city_id,hotel_id,check_indate,check_outdate){
	var base_url = $('#base_url').val();

	var final_arr = [];
	final_arr.push({
		rooms : {
			room     : parseInt(1),
			adults   : parseInt(2),
			child    : parseInt(0),
			childAge : []
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
	const url  = 'city_id=' +
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
	
	window.location.href = base_url +'Tours_B2B/view/hotel_guest/hotel-listing.php?'+url;
}
function pagination_load(dataset, columns, bg_stat = false,footer_string = false,pg_length = 20,table_id){ //1. dataset,2.columns titles,3.if want bg color,4.if want footer,5.manual pagelength change
	var html = "";
	var dataset_main = JSON.parse(dataset);
	if(bg_stat){
		var table_data = [];
		var bg = [];
		$.each(dataset_main, function(i, item) {
			table_data.push(dataset_main[i].data) // keeping different arrays for data and background color
			bg.push(dataset_main[i].bg)
		});
		table_data = JSON.parse(JSON.stringify(table_data));
	}
	else{
		var table_data = JSON.parse(dataset);
	}
	if(footer_string){
		table_data.pop();
		if($.trim($('#'+table_id+' tfoot').html())){
			document.getElementById(table_id).deleteTFoot();
		}
		for(var i=0;i<parseInt(dataset_main[dataset_main.length - 1].footer_data['total_footers']);i++){
			html += "<td colspan='"+dataset_main[dataset_main.length - 1].footer_data['col'+i]+"'>"+dataset_main[dataset_main.length - 1].footer_data['namecol'+i]+" : "+dataset_main[dataset_main.length - 1].footer_data['foot'+i]+"</td>";
		}
		html = "<tfoot><tr>"+html+"</tr></tfoot>";
	}
	if($.fn.DataTable.isDataTable("#"+table_id)) {
		$('#'+table_id).DataTable().clear().destroy(); // for managin error
	}

	var table = $('#'+table_id).DataTable({
		data: table_data,
		"pageLength": pg_length,
		columns: columns,
		"searching": true,
		createdRow: function (row, data, dataIndex) { // adds bg color for every invalid point
		if(bg){
			$(row).addClass(bg[dataIndex]);
		}
		}
	});
	$('#'+table_id).append(html);
}
//City Dropdown Lazy Loading
function city_lzloading(element){
	var base_url = $("#base_url").val();
	url = base_url+'/view/load_data/generic_city_loading.php';
	
	$(element).select2({
		placeholder: "City Name",
		ajax: {
			url: url,
			dataType: 'json',
			type: 'GET',
			data: function(params) { return { term: params.term , page: params.page || 0 }},
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
function get_currency_rates(to,from){
	var cache_currencies = JSON.parse($('#cache_currencies').val());

	var to_currency = (cache_currencies.find(el => el.currency_id == to) !== undefined ) ? cache_currencies.find(el => el.currency_id == to) : '0';
	var from_currency = (cache_currencies.find(el => el.currency_id == from) !== undefined ) ? cache_currencies.find(el => el.currency_id == from) : '0';

	return to_currency.currency_rate+'-'+from_currency.currency_rate;
}
function get_service_tax(result){
	
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
							if(condition === "1"){
								var place_flag = null;
									place_flag_array = [];
									$.ajax({
										async: false,
										type: 'POST',
										global: false,
										dataType: 'html',
										url: '../../view/get_states.php',
										data: {  },
										success: (data) => {
											data = data.split('-');
											switch (for1) {
												case '!=' :
													if (data[0] !== value) place_flag = true;
													else place_flag = false;
													break;
												case '==' :
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
						if(flag === true)applied_rules.push(rule);
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
				applied_taxes = applied_taxes + '+' + name + ':' + rate + ':' +rate_in;
				ledger_posting = ledger_posting + '+' + ledger_id;
			}
			else {
				applied_taxes += name + ':' + rate + ':' +rate_in;
				ledger_posting += ledger_id;
			}
		});
		return applied_taxes+','+ledger_posting;
}

//Add to Cart
function add_to_cart (id,type){

	var base_url = $('#base_url').val();
	var register_id = $('#register_id').val();
	var service_data_array = [];
	if(type === "hotel"){

		var city_id = $('#hotel_city_filter').val();
		var check_indate = $('#check_indate').val();
		var check_outdate = $('#check_outdate').val();

		var result = get_other_rules ('Hotel', check_indate);
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
			'check_indate':check_indate,
			'check_outdate':check_outdate
		});
		var final_arr = JSON.parse(sessionStorage.getItem('final_arr'));
		const huuid = uuidv4();
		$.post(
			base_url + 'Tours_B2B/view/get_hotel_tax.php',
			{ register_id:register_id,huuid:huuid,id : id,city_id:city_id, check_indate : check_indate,check_outdate:check_outdate,room_type_arr:room_type_arr,final_arr:final_arr,applied_taxes:applied_taxes },
			function (data) {
				var data = JSON.parse(data);
				try {
					var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));
					cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];
					cart_list_arr1.push({
						service : {
							uuid      : huuid,
							name      : 'Hotel',
							id        : id,
							city_id   : city_id,
							check_in  : check_indate,
							check_out : check_outdate,
							hotel_arr : data,
							item_arr  : room_type_arr,
							final_arr : final_arr
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
	}
	else if(type === "transfer"){
		
		var image = $('#image-'+id).val();
		var no_of_vehicles = $('#vehicle_count-'+id).html();
		var vehicle_name = $('#vehicle_name-'+id).html();
		var vehicle_type = $('#vehicle_type-'+id).html();
		var transfer_cost = $('#transfer-'+id).val();
		var pickup_date = $('#pickup_date').val();
		var return_date = $('#return_date').val();
		var passengers = $('#passengers').val();
		
		var result = get_other_rules ('Car Rental', pickup_date);
		var applied_taxes = get_service_tax(result);

		var ele = document.getElementsByName('transfer_type');
		for(i = 0; i < 2; i++) { 
			if(ele[i].checked) {
				var trip_type = ele[i].value;
			}
		}
		if(trip_type === "roundtrip"){
			if(return_date == ""){ error_msg_alert('Please select Return Date & Time '); return false; }
			var valid = check_valid_date_trs();
			if (!valid) {
				error_msg_alert('Invalid Pickup and Return Date!');
				return false;
			}
		}else{
			return_date = '';
		}
		var pickup_type = 0;
		var pickup_from = 0;
		var drop_type = 0;
		var drop_to = 0;
		$('#pickup_location').find("option:selected").each(function(){
			pickup_type = ($(this).closest('optgroup').attr('value'));
			pickup_from = ($(this).closest('option').attr('value'));
		});
		$('#dropoff_location').find("option:selected").each(function(){
			drop_type = ($(this).closest('optgroup').attr('value'));
			drop_to = ($(this).closest('option').attr('value'));
		});
		service_data_array.push({
			'trip_type':trip_type,
			'pickup_type':pickup_type,
			'pickup_from':pickup_from,
			'drop_type':drop_type,
			'drop_to':drop_to,
			'pickup_date':pickup_date,
			'return_date':return_date,
			'passengers':passengers,
			'no_of_vehicles':no_of_vehicles,
			'vehicle_name':vehicle_name,
			'vehicle_type':vehicle_type,
			'transfer_cost':transfer_cost,
			'image' : image,
			'taxation':applied_taxes
		});
		try {
			var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));
			cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];
			cart_list_arr1.push({
				service : {
					uuid      : uuidv4(),
					name      : 'Transfer',
					id        : id,
					service_arr : service_data_array
				}
			});
			localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));
			document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;
			$.post(base_url+'controller/b2b_customer/update_cart.php', { register_id : register_id,cart_list_arr:cart_list_arr1 }, function (data){
				success_msg_alert('Transfer successfully added into the cart!');
			});
		} catch (e) {
			console.error(e);
		}
	}
	else if(type === "Activity"){
		var image = $('#image-'+id).val();
		var act_name = $('#act_name-'+id).html();
		var rep_time = $('#rep_time-'+id).html();
		var pick_point = $('#pick_point-'+id).html();
		var checkDate = $('#checkDate').val();
		var total_pax = $('#total_pax').val();
		
		var result = get_other_rules ('Activity', checkDate);
		var applied_taxes = get_service_tax(result);

		var input_name = 'result' + id;
		var coupon = JSON.parse($('#coupon-'+id).val());
		var transfer_type = '';
		$('input[name=' + input_name + ']:checked').each(function () {
			transfer_type = ($(this).val());
		});
		if (transfer_type == '') {
			error_msg_alert('Please select at least one Transfer Type!');
			return false;
		}
		service_data_array.push({
			'id':id,
			'image':image,
			'act_name':act_name,
			'rep_time':rep_time,
			'pick_point':pick_point,
			'taxation':applied_taxes,
			'checkDate':checkDate,
			'total_pax':total_pax,
			'transfer_type':transfer_type,
			'coupon':coupon
		});
		try {
			var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));
			cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];
			cart_list_arr1.push({
				service : {
					uuid      : uuidv4(),
					name      : 'Activity',
					id        : id,
					service_arr : service_data_array
				}
			});
			localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));
			document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;
			$.post(base_url+'controller/b2b_customer/update_cart.php', { register_id : register_id,cart_list_arr:cart_list_arr1 }, function (data){
				success_msg_alert('Activity successfully added into the cart!');
			});
		} catch (e) {
			console.error(e);
		}
	}	
	else if(type === "Tours"){

		var image = $('#image-'+id).val();
		var package = $('#package-'+id).html();
		var package_code = $('#package_code-'+id).html();
		var currency_id = $('#h_currency_id-'+id).html();
		var days = $('#days-'+id).val();
		days = days.split('-');
		var total_passengers = $('#total_passengers').val();
		total_passengers = total_passengers.split('-');
		var travel_date = $('#travelDate').val();
		var note = document.getElementById("note"+id).textContent.replace(/\n/g, '');

		var result = get_other_rules ('Package Tour', travel_date);
		var applied_taxes = get_service_tax(result);

		var package_type = '';
		var input_name = 'result' + id;
		$('input[name=' + input_name + ']:checked').each(function () {
			package_type = ($(this).val());
		});
		if (package_type == '') {
			error_msg_alert('Please select at least one package!');
			return false;
		}
		var coupon = JSON.parse($('#coupon-'+id).val());
		service_data_array.push({
			'id':id,
			'image':image,
			'package':package,
			'package_code':package_code,
			'travel_date':travel_date,
			'nights':parseInt(days[0]),
			'days':parseInt(days[1]),
			'adult':parseInt(total_passengers[0]),
			'childwo':parseInt(total_passengers[1]),
			'childwi':parseInt(total_passengers[2]),
			'extra_bed':parseInt(total_passengers[3]),
			'infant':parseInt(total_passengers[4]),
			'taxation' :applied_taxes,
			'currency_id':currency_id,
			'note':note,
			'package_type':package_type,
			'coupon':coupon
		});
		try {
			var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));
			cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];
			cart_list_arr1.push({
				service : {
					uuid      : uuidv4(),
					name      : 'Combo Tours',
					id        : id,
					service_arr : service_data_array
				}
			});
			localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));
			document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;
			$.post(base_url+'controller/b2b_customer/update_cart.php', { register_id : register_id,cart_list_arr:cart_list_arr1 }, function (data){
				success_msg_alert('Tour successfully added into the cart!');
			});
		} catch (e) {
			console.error(e);
		}
	}
	else if(type === "ferry"){

		var from_loc_city = $('#from_loc_city').html();
		var to_loc_city = $('#to_loc_city').html();
		var image = $('#image-'+id).val();
		var no_of_vehicles = $('#vehicle_count-'+id).html();
		var ferry_name = $('#ferry_name-'+id).html();
		var ferry_type = $('#ferry_type-'+id).html();
		var total_cost = $('#ferry-'+id).val();
		var total_pax = $('#total_pax'+id).val();
		total_pax = total_pax.split('-');
		var result = get_other_rules ('Activity', pickup_date);
		var applied_taxes = get_service_tax(result);
		var travel_date = $('#travel_date'+id).val();
		var dep_date = $('#dep_date'+id).val();
		var arr_date = $('#arr_date'+id).val();

		var pickup_type = 0;
		var pickup_from = 0;
		var drop_type = 0;
		var drop_to = 0;
		$('#pickup_location').find("option:selected").each(function(){
			pickup_type = ($(this).closest('optgroup').attr('value'));
			pickup_from = ($(this).closest('option').attr('value'));
		});
		$('#dropoff_location').find("option:selected").each(function(){
			drop_type = ($(this).closest('optgroup').attr('value'));
			drop_to = ($(this).closest('option').attr('value'));
		});
		service_data_array.push({
			'ferry_name':ferry_name,
			'ferry_type':ferry_type,
			'total_cost':total_cost,
			'image' : image,
			'taxation':applied_taxes,
			'adults' : total_pax[0],
			'children' : total_pax[1],
			'infants' : total_pax[2],
			"travel_date" : travel_date,
			"dep_date" : dep_date,
			"arr_date" : arr_date,
			"from_loc_city": from_loc_city,
			"to_loc_city" : to_loc_city
		});
		try {
			var cart_list_arr1 = JSON.parse(localStorage.getItem('cart_list_arr'));
			cart_list_arr1 = cart_list_arr1 !== null ? cart_list_arr1 : [];
			cart_list_arr1.push({
				service : {
					uuid      : uuidv4(),
					name      : 'Ferry',
					id        : id,
					service_arr : service_data_array
				}
			});
			localStorage.setItem('cart_list_arr', JSON.stringify(cart_list_arr1));
			document.getElementById('cart_item_count').innerHTML = cart_list_arr1.length;
			$.post(base_url+'controller/b2b_customer/update_cart.php', { register_id : register_id,cart_list_arr:cart_list_arr1 }, function (data){
				success_msg_alert('Ferry successfully added into the cart!');
			});
		} catch (e) {
			console.error(e);
		}
	}
}
function cart_error_pop(){
	var base_url = $('#base_url').val();
	error_msg_alert('Please <a target="_blank" href="'+base_url+'view/b2b_customer/registration/index.php">Register</a> or <a target="_blank" href="'+base_url+'Tours_B2B/login.php">Login</a> here for the bookings.');
}
//Print
function loadOtherPage (url) {
	$('<iframe>').attr('src', url).appendTo('body');
	// window.location.href= url;
}
function get_other_rules (travel_type, invoice_date) {

	// convert date to y/m/data
	var data = new Date(invoice_date);
	let month = data.getMonth() + 1;
	let day = data.getDate();
	let year = data.getFullYear();
	if(day<=9)
		day = '0' + day;
	if(month<10)
		month = '0' + month;
	invoice_date =  year + '-' + month + '-' + day;

	var cache_rules = JSON.parse($('#cache_currencies').val());
	var taxes = [];
	taxes = (cache_rules.filter( (el)=>
		el.entry_id !== '' && el.rule_id === undefined && el.entry_id !== undefined && el.currency_id === undefined
	));

	//Taxes
	var taxes1 = taxes.filter((tax) => {
		return tax['status'] === 'Active';
	});

	//Tax Rules
	var tax_rules = [];
	tax_rules = (cache_rules.filter( (el)=>
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
function get_to_date1 (from_date, to_date) {
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
	}
	else {
		$('#' + to_date).val('');
	}
}
//function for valid date tariff
function validate_validDate1 (from, to) {
	
	var from_date = $('#' + from).val();
	var to_date = $('#' + to).val();

	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	var edate1 = to_date.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('Date should not be greater than valid to date');
		$('#' + from).css({ border: '1px solid red' });
		document.getElementById(from).value = '';
		$('#' + from).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + from).css({ border: '1px solid #ddd' });
		return true;
	}
	return true;
}