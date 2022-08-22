function total_passangers_calculate(offset = '') {
	var total_adult = $('#total_adult' + offset).val();
	var children_with_bed = $('#children_with_bed' + offset).val();
	var children_without_bed = $('#children_without_bed' + offset).val();
	var total_infant = $('#total_infant' + offset).val();

	if (total_adult == '') total_adult = 0;
	if (children_with_bed == '') children_with_bed = 0;
	if (children_without_bed == '') children_without_bed = 0;
	if (total_infant == '') total_infant = 0;


	var total_members = parseFloat(total_adult) + parseFloat(total_infant) + parseFloat(children_with_bed) + parseFloat(children_without_bed);
	$('#total_members' + offset).val(total_members);
}

function get_hotelenquiry_details(offset = '') {
	var enquiry_id = $('#enquiry_id' + offset).val();
	var base_url = $('#base_url').val();
	if(enquiry_id == 0){
		$('#customer_name' + offset).val('');
		$('#email_id' + offset).val('');
		$('#mobile_no' + offset).val('');
		$('#total_adult' + offset).val('');
		$('#total_infant' + offset).val('');
		$('#total_adult' + offset).val('');
		$('#children_without_bed' + offset).val('');
		$('#children_with_bed' + offset).val('');
		$('#hotel_requirements' + offset).wysiwyg("destroy")
		$('#hotel_requirements' + offset).val('');
		$('#hotel_requirements' + offset).wysiwyg({
			controls: 'bold,italic,|,undo,redo,image|h1,h2,h3,decreaseFontSize,highlight',
			initialContent: ''
		});
		$('#whatsapp_no' + offset).val('');
		$('#country_code' + offset).val('');
		$('#country_code' + offset).trigger('change');

		$('#total_members' + offset).val(0);
	}else{
		$.ajax({
			type: 'post',
			url: base_url + 'view/hotel_quotation/get_enquiry_details.php',
			dataType: 'json',
			data: { enquiry_id: enquiry_id },
			success: function (result) {
				
				$('#customer_name' + offset).val(result.name);
				$('#email_id' + offset).val(result.email_id);
				$('#mobile_no' + offset).val(result.landline_no);
				$('#total_adult' + offset).val(result.total_adult);
				$('#total_infant' + offset).val(result.total_infant);
				$('#total_adult' + offset).val(result.total_adult);
				$('#children_without_bed' + offset).val(result.total_cwob);
				$('#children_with_bed' + offset).val(result.total_cwb);
				$('#hotel_requirements' + offset).wysiwyg("destroy")
				$('#hotel_requirements' + offset).val(result.hotel_requirements);
				$('#hotel_requirements' + offset).wysiwyg({
					controls: 'bold,italic,|,undo,redo,image|h1,h2,h3,decreaseFontSize,highlight',
					initialContent: ''
				});
				var whatsapp = result.landline_no;
				whatsapp = whatsapp.split(result.country_code)[1];
				$('#whatsapp_no' + offset).val(result.landline_no);
				$('#country_code' + offset).val(result.country_code);
				$('#country_code').trigger('change');

				if (result.total_adult === undefined || result.total_adult === '') result.total_adult = 0;
				if (result.total_infant === undefined || result.total_infant === '') result.total_infant = 0;
				if (result.total_cwob === undefined || result.total_cwob === '') result.total_cwob = 0;
				if (result.total_cwb === undefined || result.total_cwb === '') result.total_cwb = 0;

				var total_pax = parseFloat(result.total_adult) + parseFloat(result.total_cwob) + parseFloat(result.total_cwb) + parseFloat(result.total_infant);
				if (total_pax == '') total_pax = 0;
				$('#total_members' + offset).val(total_pax);
			},
		});
	}
}
var resetFieldToDefault = function(offset) {
    var selectedOptions = document.getElementById('country_code' + offset).selectedOptions;
    for(var i = 0; i < selectedOptions.length; i++)
        selectedOptions[i].selected = false;
}
function options_dynamic_reflect(id) {
	var nofquotation = $('#' + id).val();
	var base_url = $('#base_url').val();
	$('#' + id).css('border','1px solid #e2e2e2');
	if(nofquotation == '' || Number(nofquotation) > 7 || Number(nofquotation) <= 0){
		error_msg_alert('Please Enter Valid Number of Quotations');
		$('#' + id).val('');
		$('#' + id).css('border','1px solid red');
		return false;
	}
	$.ajax({
		type: 'get',
		url: base_url + 'view/hotel_quotation/get_options.php',
		data: { nofquotation: nofquotation },
		success: function (result) {
			$('#options_div').html(result);
		}
	});
}

function hotel_name_list_load(id){
  var city_id = $("#"+id).val();
  var count = id.substring(9);
  var base_url = $('#base_url').val();
  $.get( base_url + "view/package_booking/quotation/home/hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name"+count).html( data );                     
  }) ;   
}

function get_auto_to_date(from_date) {
	var from_date1 = $('#' + from_date).val();
	var offset = from_date.substring(8);
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
		$('#check_out' + offset).val(day + '-' + month + '-' + year);
	}
	else {
		$('#check_out' + offset).val('');
	}
	calculate_total_nights('check_out' + offset);
}

function calculate_total_nights(to_date1) {

	var offset = to_date1.substring(9);
	var from_date = $('#check_in' + offset).val();
	var to_date = $('#' + to_date1).val();
	if (from_date != '' && to_date != '') {
		var edate = from_date.split('-');
		e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
		var edate1 = to_date.split('-');
		e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

		var one_day = 1000 * 60 * 60 * 24;

		var from_date_ms = new Date(e_date).getTime();
		var to_date_ms = new Date(e_date1).getTime();

		var difference_ms = to_date_ms - from_date_ms;
		var total_days = Math.round(Math.abs(difference_ms) / one_day);

		total_days = parseFloat(total_days);
		$('#hotel_stay_days' + offset).val(total_days);
	}
	else {
		$('#hotel_stay_days' + offset).val(0);
	}
}

//Get Hotel Cost
function get_hotel_cost(table_id){
	var hotel_id_arr = new Array();
	var room_cat_arr = new Array();
	var check_in_arr = new Array();
	var check_out_arr = new Array();
	var total_nights_arr = new Array();
	var total_rooms_arr = new Array();
	var extra_bed_arr = new Array();
	var checked_arr = [];
	var package_id_arr = [];
	var child_with_bed = $('#children_with_bed').val(); 
	var child_without_bed = $('#children_without_bed').val(); 
	var adult_count = $('#total_adult').val(); 
	
    adult_count = (adult_count == '') ? 0 : adult_count;
    child_without_bed = (child_without_bed == '') ? 0 : child_without_bed;
    child_with_bed = (child_with_bed == '') ? 0 : child_with_bed;

	var table = document.getElementById(table_id);
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];
		var hotel_id = row.cells[3].childNodes[0].value;
		var room_category = row.cells[4].childNodes[0].value;
		var check_in = row.cells[6].childNodes[0].value;
		var check_out = row.cells[7].childNodes[0].value;
		var total_nights = row.cells[9].childNodes[0].value;
		var total_rooms = row.cells[10].childNodes[0].value;
		var extra_bed = row.cells[11].childNodes[0].value;
		hotel_id_arr.push(hotel_id);
		room_cat_arr.push(room_category);
		check_in_arr.push(check_in);
		check_out_arr.push(check_out);
		total_nights_arr.push(total_nights);
		total_rooms_arr.push(total_rooms);
		extra_bed_arr.push(extra_bed);
		checked_arr.push(row.cells[0].childNodes[0].checked);
		package_id_arr.push(0);
	}
	var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url+'view/package_booking/quotation/home/hotel/get_hotel_cost.php',
		data:{ hotel_id_arr : hotel_id_arr,check_in_arr : check_in_arr,check_out_arr:check_out_arr,room_cat_arr:room_cat_arr,total_nights_arr:total_nights_arr,total_rooms_arr:total_rooms_arr,extra_bed_arr:extra_bed_arr,child_with_bed:child_with_bed,child_without_bed:child_without_bed,adult_count:adult_count,package_id_arr:package_id_arr,checked_arr:checked_arr },

		success:function(result){

			var hotel_arr = JSON.parse(result);
			var pp_arr = [];
			for(var i=0; i<hotel_arr.length; i++){

				var row = table.rows[i];
				row.cells[12].childNodes[0].value = hotel_arr[i]['hotel_cost'];
					
			}	
		}
	});
}

function hotel_type_load(id){
  var hotel_id = $("#"+id).val();
  var base_url = $('#base_url').val();

  var count = id.substring(10);
  $.get( base_url + "view/package_booking/quotation/home/hotel/hotel_type_load.php" , { hotel_id : hotel_id } , function ( data ) {
        $ ("#hotel_type"+count).val( data ) ;  
  } ) ;   
}

function validate_validDates(to) {

	var offset =  to.substring(9);
	var from_date = $('#check_in' + offset).val();
	var to_date1 = $('#' + to).val();

	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	var edate1 = to_date1.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('Date should not be greater than valid to date');
		$('#check_in' + offset).css({ border: '1px solid red' });
		$('#check_in' + offset).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#check_in' + offset).css({ border: '1px solid #ddd' });
		return true;
	}
}

function cost_calculate(id){
	var offset = id.split('-')[1];

    var service_tax_subtotal = $('#tax_amount-'+offset).val();
    var basic_cost = $('#basic_cost-'+offset).val();   
    var service_charge = $('#service_charge-'+offset).val();
    var markup = $('#markup_cost-'+offset).val();
    var service_tax_markup = $('#tax_markup-'+offset).val();

	if(basic_cost==""){ basic_cost = 0; }
    if(service_charge==""){ service_charge = 0; }
    if(markup==""){ markup = 0; }
    
	var service_tax_amount = 0;
    if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){

      var service_tax_subtotal1 = service_tax_subtotal.split(",");
      for(var i=0;i<service_tax_subtotal1.length;i++){
        var service_tax = service_tax_subtotal1[i].split(':');
        service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
      }
    }
    
    var markupservice_tax_amount = 0;
    if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== ""){
      var service_tax_markup1 = service_tax_markup.split(",");
      for(var i=0;i<service_tax_markup1.length;i++){
        var service_tax = service_tax_markup1[i].split(':');
        markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
      }
    }

	basic_cost = ($('#basic_show-'+offset).html() == '&nbsp;') ? basic_cost : parseFloat($('#basic_show-'+offset).text().split(' : ')[1]);
    service_charge = ($('#service_show-'+offset).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show-'+offset).text().split(' : ')[1]);
    markup = ($('#markup_show-'+offset).html() == '&nbsp;') ? markup : parseFloat($('#markup_show-'+offset).text().split(' : ')[1]);

	var total_amount = Number(basic_cost) + Number(service_tax_amount) + Number(markupservice_tax_amount) + Number(service_charge) + Number(markup);

	var total=total_amount.toFixed(2);
    var roundoff = Math.round(total)-total;
    $('#roundoff-'+offset).val(roundoff.toFixed(2));
    $('#total_amount-'+offset).val(parseFloat(total)+parseFloat(roundoff));
}