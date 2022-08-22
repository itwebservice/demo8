<form id="frm_tab2">

	

	<div class="row">

		<div class="col-md-8 col-sm-12 col-xs-12 mg_bt_20_xs">

			<strong>Type Of Trip :</strong>&nbsp;&nbsp;&nbsp;

			<input type="radio" name="type_of_tour" id="type_of_tour-one_way"  value="One Way">&nbsp;&nbsp;<label for="type_of_tour-one_way">One Way</label>

			&nbsp;&nbsp;&nbsp;

			<input type="radio" name="type_of_tour" id="type_of_tour-return_trip" onclick="addSection(this.id);" value="Return Trip">&nbsp;&nbsp;<label for="type_of_tour-return_trip">Return Trip</label>

			&nbsp;&nbsp;&nbsp;			

		</div>

		<div class="col-md-4 col-sm-12 col-xs-12 text-right">

			<button type="button" class="btn btn-info btn-sm ico_left" onclick="addDyn('div_dynamic_ticket_info');copy_values()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Section</button>

		</div>

	</div>



	<div class="dynform-wrap" id="div_dynamic_ticket_info" data-counter="1">

		

		<div class="dynform-item">		

			

			<div class="row">

				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

					<input type="text" id="travel_datetime-1" name="travel_datetime" placeholder="Departure Date-Time" title="Departure Date-Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i') ?>" data-dyn-valid="required" onchange="get_arrival_dateid(this.id);">

				</div>

				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

					<input type="text" id="arriving_datetime-1" name="arriving_datetime" placeholder="Arrival Date-Time" title="Arrival Date-Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i') ?>" data-dyn-valid="required">

				</div>

				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

					<input type="text" id="travel_from-1" onchange="fname_validate(this.id);" name="travel_from" placeholder="*Travel From" title="Travel From" data-dyn-valid="required">

				</div>

				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

					<input type="text" id="travel_to-1" name="travel_to" onchange="fname_validate(this.id);"  placeholder="*Travel To" title="Travel To" data-dyn-valid="required">

				</div>

				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

					<input type="text" id="train_name-1" name="train_name" placeholder="Train Name" title="Train Name" data-dyn-valid="">

				</div>



				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

					<input type="text" id="train_no-1" name="train_no" onchange="validate_balance(this.id)" placeholder="Train No" title="Train No" data-dyn-valid="">

				</div>	
			</div>	

			<div class="row">
				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">

					<select name="ticket_status" id="ticket_status-1" title="Ticket Status" data-dyn-valid="">

						<option value="">Ticket Status</option>

						<option value="Confirm">Confirm</option>

						<option value="Waiting">Waiting</option>

						<option value="RAC">RAC</option>

						<option value="Open">Open</option>

					</select>

				</div>

				<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">

					<select name="class" id="class-1" title="Class" data-dyn-valid="">

						<option value="">Class</option>

						<?php get_train_class_dropdown(); ?>

					</select>

				</div>

				

				<div class="col-md-2 col-sm-4 col-xs-12">

					<input type="text" id="boarding_at-1" name="boarding_at" title="Boarding Point" placeholder="Boarding Point" onchange="validate_address(this.id)" data-dyn-valid="">

				</div>

			</div>



		</div>



	</div>



	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>



<script>

$('#arriving_datetime-1, #departure_datetime-1, #travel_datetime-1').datetimepicker({ format:'d-m-Y H:i' });

$('#frm_tab2').validate({

	rules:{

			//type_of_tour : { required : true },

	},

	submitHandler:function(form){		



		var status = dyn_validate('div_dynamic_ticket_info');
		var type_of_tour = $('input[name="type_of_tour"]:checked').val();
		var msg = "Type of trip is required"; 
		if(type_of_tour == undefined) { error_msg_alert(msg); return false;}

		if(!status){ return false; }



		$('a[href="#tab3"]').tab('show');



	}

});
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

function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }

</script>