<form id="frm_tab2">
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12 mg_bt_20_xs">
			<strong>*Type Of Trip :</strong>&nbsp;&nbsp;&nbsp;
			<input type="radio" name="type_of_tour" id="type_of_tour-one_way" value="One Way">&nbsp;&nbsp;<label for="type_of_tour-one_way">One Way</label>
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="type_of_tour" id="type_of_tour-round_trip" onclick="addSection(this.id);" value="Round Trip">&nbsp;&nbsp;<label for="type_of_tour-round_trip">Round Trip</label>
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="type_of_tour" id="type_of_tour-multi_city" onclick="addSection(this.id);" value="Multi City">&nbsp;&nbsp;<label for="type_of_tour-multi_city">Multi City</label>
			&nbsp;&nbsp;&nbsp;
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12 text-right">
			<button type="button" class="btn btn-info btn-sm ico_left" onclick="addDyn('div_dynamic_ticket_info'); event_airport_s();copy_values()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>
		</div>
	</div>
	<div class="dynform-wrap" id="div_dynamic_ticket_info" data-counter="1">
		<div class="dynform-item">		
			<div class="row">
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="departure_datetime-1" name="departure_datetime" class="app_datetimepicker departure_datetime" placeholder="*Departure Date-Time" title="Departure Date-Time" value="<?php echo date('d-m-Y H:i') ?>" data-dyn-valid="required">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="arrival_datetime-1" name="arrival_datetime" class="app_datetimepicker arrival_datetime" placeholder="*Arrival Date-Time" onchange="validate_validDatetimeFlight(this.id)" title="Arrival Date-Time" value="<?php echo date('d-m-Y H:i') ?>" data-dyn-valid="required">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<select id="airlines_name-1" name="airlines_name" title="Airlines Name" style="width:100%" data-dyn-valid="required" class="app_select" onchange="get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount');">
						<option value="">Airline Name</option>
					<?php $sq_airline = mysqlQuery("SELECT airline_name,airline_code FROM airline_master WHERE active_flag!='Inactive' ORDER BY airline_name ASC");
						while($row_airline = mysqli_fetch_assoc($sq_airline)){
					?>
					    <option value="<?= $row_airline['airline_name'].' ('.$row_airline['airline_code'].')' ?>"><?= $row_airline['airline_name'].' ('.$row_airline['airline_code'].')' ?></option>
					<?php
					  }
					?>
				</select>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<select name="class" id="class-1" title="Cabin" data-dyn-valid="required" onchange="get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','service_charge','discount');">
						<option value="">Cabin</option>
						<option value="Economy">Economy</option>
						<option value="Business">Business</option>
						<option value="First Class">First Class</option>
						<option value="Other">Other</option>
					</select>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="sub_category-1" name="sub_category"  placeholder="Sub Category" title="Sub Category" >
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="flight_no-1" style="text-transform: uppercase;" name="flight_no" onchange="validate_specialChar(this.id)" placeholder="Flight No" title="Flight No" data-dyn-valid="">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="airlin_pnr-1" style="text-transform: uppercase;" onchange=" validate_specialChar(this.id)" name="airlin_pnr" placeholder="Airline PNR" title="Airline PNR" data-dyn-valid="">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input id="airpf-1" name="airpf" title="Enter Departure Airport" data-toggle="tooltip" class="form-control autocomplete airpf" placeholder="*Enter Departure Airport" data-dyn-valid="required">
					<input type="hidden" name="from_city" id="from_city-1" data-dyn-valid="required"/>
					<input type="hidden" name="departure_city" id="departure_city-1" data-dyn-valid="required">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="dterm-1" name="dterm" onchange="validate_specialChar(this.id)" placeholder="Departure Terminal" title="Departure Terminal" data-dyn-valid="">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10 ">
					<input id="airpt-1" name="airpt" class="form-control autocomplete airpt" title="Enter Arrival Airport" data-toggle="tooltip" placeholder="*Enter Arrival Airport" data-dyn-valid="required">
					<input type="hidden" name="to_city" id="to_city-1" data-dyn-valid="required"/>
					<input type="hidden" name="arrival_city" id="arrival_city-1" data-dyn-valid="required">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="aterm-1" name="aterm" onchange="validate_specialChar(this.id)" placeholder="Arrival Terminal" title="Arrival Terminal" data-dyn-valid="">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 hidden mg_bt_10">
					<input type="hidden" id="meal_plan-1" name="meal_plan" onchange="validate_specialChar(this.id)" placeholder="Meal Plan" title="Meal Plan" data-dyn-valid="">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="luggage-1" name="luggage" onchange="validate_specialChar(this.id)" placeholder="Luggage" title="Luggage" data-dyn-valid="">
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="no_of_pieces-1" name="no_of_pieces"  placeholder="No of pieces" title="No of pieces" >
				</div>
				<div class="col-md-3 col-sm-12 col-xs-12">
					<textarea name="special_note" id="special_note-1" onchange="validate_address(this.id)" rows="1" placeholder="Special Note" title="Special Note" data-dyn-valid=""></textarea>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="aircraft_type-1" name="aircraft_type"  placeholder="Aircraft Type" title="Aircraft Type" >
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="operating_carrier-1" name="operating_carrier"  placeholder="Operating carrier" title="Operating carrier" >
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<input type="text" id="frequent_flyer-1" name="frequent_flyer"  placeholder="Frequent Flyer" title="Frequent Flyer" >
				</div>
				<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
					<select name="ticket_status" id="ticket_status-1" title="Status of ticket"  >
						<option value="">Status of ticket</option>
						<option value="Hold">Hold</option>
						<option value="Confirmed">Confirmed</option>
					</select>
				</div>

			</div>
		</div>
	</div>
	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>



<script>

$('#departure_datetime-1, #arrival_datetime-1').datetimepicker({ format:'d-m-Y H:i:s' });

$('#airlines_name-1,#plane_from_location-1,#plane_to_location-1').select2();

$('#frm_tab2').validate({
	submitHandler:function(form, e){
		e.preventDefault();
		var base_url = $('#base_url').val();
		var type_of_tour = $('input[name="type_of_tour"]:checked').val();
		var msg = "Type of trip is required"; 
		var airpf = $('.airpf');
		var airpt = $('.airpt');
		var departure_datetime = $('.departure_datetime');
		var arrival_datetime = $('.arrival_datetime');

		var airpf_flag    = false;
		var airpt_flag    = false;
		var dd_flag       = false;
		var ad_flag       = false;
		var date_mismatch = false;
		for(let i = 0; i < airpf.length ; i++){
			if(airpf[i].value == "")	airpf_flag = true;
			if(airpt[i].value == "")	airpt_flag = true;
			if(departure_datetime[i].value == "")	dd_flag = true;
			if(arrival_datetime[i].value == "")	ad_flag = true;
			if(departure_datetime[i].value != "" && arrival_datetime[i].value != "" && Date.parse(departure_datetime[i].value) >= Date.parse(arrival_datetime[i].value)){
				date_mismatch = true;
			}
		}
		var err_msg = "";
		if(airpf_flag){
			err_msg += "Please Enter Departure Airport<br>";
		}
		if(airpt_flag){
			err_msg += "Please Enter Arrival Airport<br>";
		}
		if(dd_flag){
			err_msg += "Please Enter Departure Date and Time<br>";
		}
		if(ad_flag){
			err_msg += "Please Enter Arrival Date and Time<br>";
		}
		if(date_mismatch){
			err_msg += "Please Enter Departure and Arrival Date and Time";
		}

		if(airpf_flag || airpt_flag || dd_flag || ad_flag){
			error_msg_alert(err_msg); return false
		}


		if(type_of_tour == undefined) { error_msg_alert(msg); return false;}
		
		var airlin_pnr_arr = getDynFields('airlin_pnr');
		$.ajax({
			type: 'post',
			url: base_url+'controller/visa_passport_ticket/ticket/ticket_pnr_check.php',
			data:{ airlin_pnr_arr : airlin_pnr_arr,type:'save',entry_id:'' },
			success: function(result){
				if(result==''){
					$('a[href="#tab3"]').tab('show');
				}
				else{
					var msg = result.split('--');
					error_msg_alert(msg[1]);
					return false;
				}
			}
		});
	}

});

function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }

function event_airport_s(count = 2){
	if(count == 1)	{id1 = "airpf-1"; id2 = "airpt-1"}
	else	{id1 = "airpf-"+$('#div_dynamic_ticket_info').attr('data-counter');id2 = "airpt-"+$('#div_dynamic_ticket_info').attr('data-counter');}
	ids = [{"dep" : id1}, {"arr" : id2}];
	airport_load_main_sale(ids);
}
event_airport_s(1);
function copy_values(){
	var count = $('#div_dynamic_ticket_info').attr('data-counter');
	$('#meal_plan-'+count).val($('#meal_plan-1').val());
	$('#luggage-'+count).val($('#luggage-1').val());
	$('#airpf-'+count).val($('#airpt-1').val());
	$('#from_city-'+count).val($('#to_city-1').val());
	$('#departure_city-'+count).val($('#arrival_city-1').val());
	$('#airpt-'+count).val($('#airpf-1').val());
	$('#to_city-'+count).val($('#from_city-1').val());
	$('#arrival_city-'+count).val($('#departure_city-1').val());
}
function addSection(id){
	if($('#div_dynamic_ticket_info').attr('data-counter') == 1){
		addDyn('div_dynamic_ticket_info');
		if(id == 'type_of_tour-round_trip'){
			copy_values();
		}
		event_airport_s();
	}
}
</script>