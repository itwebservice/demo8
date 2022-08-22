$('#quotation_date').datetimepicker({ timepicker: false, format: 'd-m-Y' });

function quotation_cost_calculate() {
	var quotation_cost = 0;
	var subtotal = $('#subtotal').val();
	var markup_cost = $('#markup_cost').val();
	var service_tax_markup = $('#service_tax_markup').val();
	var service_tax_subtotal = $('#service_tax_subtotal').val();
	var service_charge = $('#service_charge').val();
	var permit = $('#permit').val();
	var toll_parking = $('#toll_parking').val();
	var driver_allowance = $('#driver_allowance').val();
	var state_entry = $('#state_entry').val();
	var other_charges = $('#other_charges').val();

	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== '') {

		var service_tax_subtotal1 = service_tax_subtotal.split(",");
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}
	var markupservice_tax_amount = 0;
	if (parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== "") {
		var service_tax_markup1 = service_tax_markup.split(",");
		for (var i = 0; i < service_tax_markup1.length; i++) {
			var service_tax = service_tax_markup1[i].split(':');
			markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
		}
	}

	if (subtotal == '') {
		subtotal = 0;
	}
	if (permit == '') {
		permit = 0;
	}
	if (toll_parking == '') {
		toll_parking = 0;
	}
	if (driver_allowance == '') {
		driver_allowance = 0;
	}
	if (state_entry == '') {
		state_entry = 0;
	}
	if (other_charges == '') {
		other_charges = 0;
	}

	if (markup_cost == '') {
		markup_cost = 0;
	}
	subtotal = ($('#basic_show').html() == '&nbsp;') ? subtotal : parseFloat($('#basic_show').text().split(' : ')[1]);
	service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);
	markup_cost = ($('#markup_show').html() == '&nbsp;') ? markup_cost : parseFloat($('#markup_show').text().split(' : ')[1]);

	total_tour_cost =
		parseFloat(subtotal) +
		parseFloat(markupservice_tax_amount) +
		parseFloat(permit) +
		parseFloat(toll_parking) +
		parseFloat(driver_allowance) +
		parseFloat(state_entry) +
		parseFloat(other_charges) +
		parseFloat(service_tax_amount) +
		parseFloat(markup_cost) +
		parseFloat(service_charge);
	quotation_cost = parseFloat(total_tour_cost.toFixed(2));
	var roundoff = Math.round(quotation_cost) - quotation_cost;
	$('#roundoff').val(roundoff.toFixed(2));
	var total_cost = parseFloat(quotation_cost) + parseFloat(roundoff);
	$('#total_tour_cost').val(total_cost.toFixed(2));
}

function get_enquiry_details(offset = '') {
	var enquiry_id = $('#enquiry_id' + offset).val();
	var base_url = $('#base_url').val();
	$.ajax({
		type: 'post',
		url: base_url + 'view/package_booking/quotation/car_flight/car_rental/get_enquiry_details.php',
		dataType: 'json',
		data: { enquiry_id: enquiry_id },
		success: function (result) {
			if (enquiry_id != '' && enquiry_id != '0') {
				let trav_date = result.traveling_date.split(' ');
				$('#customer_name' + offset).val(result.name);
				$('#email_id' + offset).val(result.email_id);
				$('#mobile_no' + offset).val(result.country_code+result.landline_no);
				$('#total_pax' + offset).val(result.total_pax);
				$('#days_of_traveling' + offset).val(result.days_of_traveling);
				$('#from_date' + offset).val(trav_date[0]);
				$('#to_date' + offset).val(trav_date[0]);
				$('#traveling_date' + offset).val(result.traveling_date);
				$('#vehicle_name' + offset).val(result.vehicle_type);
				$('#travel_type' + offset).val(result.travel_type);
				
				$('#local_places_to_visit' + offset).html(result.places_to_visit);
				// $('#travel_type' + offset).select2().trigger("change");
			}
			else {
				$('#customer_name' + offset).val('');
				$('#email_id' + offset).val('');
				$('#mobile_no' + offset).val('');
				$('#total_pax' + offset).val('');
				$('#days_of_traveling' + offset).val('');
				$('#from_date' + offset).val('');
				$('#to_date' + offset).val('');
				$('#traveling_date' + offset).val('');
				$('#vehicle_name' + offset).val('');
				$('#travel_type' + offset).val('');
				$('#local_places_to_visit' + offset).html('');
				$('#rate' + offset).val('');
				$('#total_hr' + offset).val('');
				$('#total_km' + offset).val('');
				
				if(offset!=''){
					$('#travel_type1').prop('disabled', false);
				}
			}
			if(offset==''){
				reflect_feilds();
			}else{
				reflect_feilds1();
			}
			get_car_cost();
			get_capacity();
		},
		error: function (result) {
			// alert(result);
			console.log(result.responseText);
		}
	});
	get_basic_amount()
}
function get_car_cost(offset='') {
	var travel_type = $('#travel_type'+offset).val();
	var vehicle_name = $('#vehicle_name'+offset).val();
	var places_to_visit = $('#places_to_visit'+offset).val();

	var base_url = $('#base_url').val();
	$.ajax({
		type: 'post',
		url: base_url + 'view/package_booking/quotation/car_flight/car_rental/get_car_cost.php',
		dataType: 'json',
		data: { travel_type: travel_type, vehicle_name: vehicle_name, places_to_visit: places_to_visit },
		success: function (result) {
			if(parseInt(result.length) != 0){
				$('#total_hr'+offset).val(result[0].total_hrs);
				$('#total_km'+offset).val(result[0].total_km);
				$('#extra_hr_cost'+offset).val(result[0].extra_hrs_rate);
				$('#extra_km_cost'+offset).val(result[0].extra_km_rate);
				$('#route'+offset).val(result[0].route);
				$('#total_max_km'+offset).val(result[0].total_max_km);
				$('#rate'+offset).val(result[0].rate);
				$('#driver_allowance'+offset).val(result[0].driver_allowance);
				$('#permit'+offset).val(result[0].permit_charges);
				$('#toll_parking'+offset).val(result[0].toll_parking);
				$('#state_entry'+offset).val(result[0].state_entry_pass);
				$('#other_charges'+offset).val(result[0].other_charges);
			}else{
				$('#total_hr'+offset).val('');
				$('#total_km'+offset).val('');
				$('#extra_hr_cost'+offset).val('');
				$('#extra_km_cost'+offset).val('');
				$('#route'+offset).val('');
				$('#total_max_km'+offset).val('');
				$('#rate'+offset).val('');
				$('#driver_allowance'+offset).val('');
				$('#permit'+offset).val('');
				$('#toll_parking'+offset).val('');
				$('#state_entry'+offset).val('');
				$('#other_charges'+offset).val('');
			}
		},
		error: function (result) {
		}
	});
}

function reflect_feilds() {

	var type = $('#travel_type').val();
	if (type == 'Local') {
		$('#total_hr,#total_km,#local_places_to_visit').show();
		$('#total_max_km,#driver_allowance,#permit,#toll_parking,#state_entry,#other_charges,#places_to_visit,#traveling_date').hide();
	}
	if (type == 'Outstation') {
		$('#total_hr,#total_km,#local_places_to_visit').hide();
		$('#total_max_km,#driver_allowance,#permit,#toll_parking,#state_entry,#other_charges,#places_to_visit,#traveling_date').show();
	}
}

function reflect_feilds1(){
	
	var type = $('#travel_type1').val();
	if(type=='Local'){
		$('#from_date1,#to_date1,#total_hr1,#total_km1,#local_places_to_visit1').show();
		$('#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry1,#other_charges1,#places_to_visit1,#traveling_date1').hide();
	}
	if(type=='Outstation'){
		$('.update_field,#local_places_to_visit1').hide();
		$('#from_date1,#to_date1,#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry1,#other_charges1,#places_to_visit1,#traveling_date1').show();
	}
}

function get_flight_enquiry_details(offset = '') {
	var enquiry_id = $('#enquiry_id' + offset).val();
	var base_url = $('#base_url').val();
	if (enquiry_id != '' && enquiry_id != 0) {
		$.ajax({
			type: 'GET',
			url: base_url + 'view/package_booking/quotation/car_flight/flight/get_enquiry_details.php',
			dataType: 'json',
			data: { enquiry_id: enquiry_id },
			success: function (result) {
				$('#customer_name' + offset).val(result.name);
				$('#email_id' + offset).val(result.email_id);
				$('#mobile_no' + offset).val(result.country_code+result.landline_no);
				var enquiry_content = JSON.parse(result.enquiry_content);
				var count_td = 1;
				var table = document.getElementById('tbl_flight_quotation_dynamic_plane');
				// $('#tbl_flight_quotation_dynamic_plane').empty()
				$("#tbl_flight_quotation_dynamic_plane").find("tr:gt(0)").remove();
				$.each(enquiry_content, function (index, value) {

					var rows = table.rows;
					var table_offset = rows[rows.length - 1].cells[0].childNodes[0].getAttribute('id').split('-')[1];
					$('#from_sector-' + table_offset).val(value.sector_from);
					$('#to_sector-' + table_offset).val(value.sector_to);
					$('#plane_class-' + table_offset).val(value.class_type);
					$('#airline_name-' + table_offset).val(value.preffered_airline);
					$('#airline_name-'+table_offset).trigger('change');
					$('#txt_dapart-' + table_offset).val(value.travel_datetime);
					$('#txt_arrval-' + table_offset).val(value.travel_datetime);
					$('#adult-' + table_offset).val(value.total_adults_flight);
					$('#child-' + table_offset).val(value.total_child_flight);
					$('#infant-' + table_offset).val(value.total_infant_flight);
					$('#from_city-' + table_offset).val(value.from_city_id_flight);
					$('#to_city-' + table_offset).val(value.to_city_id_flight);
					if (enquiry_content.length > count_td++)
						addRow('tbl_flight_quotation_dynamic_plane');
				});
			},
			error: function (result) {
				console.log(result.responseText);
			}
		});
	}
	else {
		$('#customer_name' + offset).val('');
		$('#email_id' + offset).val('');
		$('#mobile_no' + offset).val('');
		var table = document.getElementById('tbl_flight_quotation_dynamic_plane');
		if (table.rows.length == 1) {
			for (var k = 1; k < table.rows.length; k++) {
				document.getElementById("tbl_flight_quotation_dynamic_plane").deleteRow(k);
			}
		} else {
			while (table.rows.length > 1) {
				document.getElementById("tbl_flight_quotation_dynamic_plane").deleteRow(k);
				table.rows.length--;
			}
		}
		var row = table.rows[0];
		row.cells[1].childNodes[0].value = '1';
		row.cells[2].childNodes[0].value = '';
		row.cells[3].childNodes[0].value = '';
		row.cells[4].childNodes[0].value = '';
		row.cells[5].childNodes[0].value = '';
		row.cells[6].childNodes[0].value = '';
		row.cells[7].childNodes[0].value = '';
		row.cells[8].childNodes[0].value = '';
		row.cells[9].childNodes[0].value = '';
		row.cells[10].childNodes[0].value = '';
	}
}

function flight_quotation_cost_calculate(offset = '') {
	var quotation_cost = 0;
	var subtotal = $('#subtotal' + offset).val();
	var service_charge = $('#service_charge' + offset).val();
	var service_tax_subtotal = $('#service_tax' + offset).val();
	var markup_cost = $('#markup_cost' + offset).val();
	var service_tax_markup = $('#markup_cost_subtotal' + offset).val();

	if (subtotal == '') {
		subtotal = 0;
	}
	if (markup_cost == '') {
		markup_cost = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}

	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== '') {

		var service_tax_subtotal1 = service_tax_subtotal.split(",");
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}
	var markupservice_tax_amount = 0;
	if (parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== "") {
		var service_tax_markup1 = service_tax_markup.split(",");
		for (var i = 0; i < service_tax_markup1.length; i++) {
			var service_tax = service_tax_markup1[i].split(':');
			markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
		}
	}

	subtotal = ($('#basic_show' + offset).html() == '&nbsp;') ? subtotal : parseFloat($('#basic_show' + offset).text().split(' : ')[1]);
	service_charge = ($('#service_show' + offset).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show' + offset).text().split(' : ')[1]);
	markup_cost = ($('#markup_show' + offset).html() == '&nbsp;') ? markup_cost : parseFloat($('#markup_show' + offset).text().split(' : ')[1]);

	total_tour_cost = parseFloat(subtotal) + parseFloat(service_charge) + parseFloat(service_tax_amount) + parseFloat(markup_cost) + parseFloat(markupservice_tax_amount);

	var roundoff = Math.round(total_tour_cost) - total_tour_cost;
	$('#roundoff' + offset).val(roundoff.toFixed(2));

	quotation_cost = parseFloat(total_tour_cost) + parseFloat(roundoff);

	$('#total_tour_cost' + offset).val(quotation_cost.toFixed(2));
}
