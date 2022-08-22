<form id="frm_tab11_c">

	<div class="row">

		<input type="hidden" id="quotation_id1" name="quotation_id1" value="<?= $quotation_id ?>">


		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="hidden" id="login_id1" name="login_id1" value="<?= $login_id ?>">
			<select name="enquiry_id1" title="Enquiry No" id="enquiry_id1" style="width:100%" onchange="get_enquiry_details('1')">
				<?php 
				$sq_enq = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$sq_quotation[enquiry_id]' and enquiry_type='Car Rental'"));
					?>
					<option value="<?= $sq_enq['enquiry_id'] ?>">Enq<?= $sq_enq['enquiry_id'] ?> : <?= $sq_enq['name'] ?></option>
					<option value="0"><?= "New Enquiry" ?></option>
					<?php
				if($role=='Admin'){
					$sq_enq = mysqlQuery("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' order by enquiry_id desc");
				}else{
					if($branch_status=='yes'){
						if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
							$sq_enq = mysqlQuery("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
						}
						elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
							$q = "select * from enquiry_master where enquiry_type in('Car Rental') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
							$sq_enq = mysqlQuery($q);
						}
					}
					elseif($branch_status!='yes' && ($role=='Branch Admin' || $role_id=='7')){
						
						$sq_enq = mysqlQuery("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' order by enquiry_id desc");
					}
					elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
						$q = "select * from enquiry_master where enquiry_type in('Car Rental') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
						$sq_enq = mysqlQuery($q);
					}
				}
				while($row_enq = mysqli_fetch_assoc($sq_enq)){
					$sq_enq1 = mysqli_fetch_assoc(mysqlQuery("SELECT followup_status FROM `enquiry_master_entries` WHERE `enquiry_id` = '$row_enq[enquiry_id]' ORDER BY `entry_id` DESC"));
					if($sq_enq1['followup_status'] != 'Dropped'){
					?>
					<option value="<?= $row_enq['enquiry_id'] ?>">Enq<?= $row_enq['enquiry_id'] ?> : <?= $row_enq['name'] ?></option>
				<?php
					}
				}
				?>
			</select>

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="customer_name1" name="customer_name1" onchange="fname_validate(this.id)" placeholder="Customer Name" title="Customer Name" value="<?php echo $sq_quotation['customer_name'];?>" required>

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" onchange="validate_email(this.id)" value="<?= $sq_quotation['email_id'] ?>">
		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="mobile_no1" name="mobile_no1" onchange="mobile_validate(this.id)" placeholder="Whatsapp no with country code" title="Whatsapp no with country code" value="<?= $sq_quotation['mobile_no'] ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="total_pax1" name="total_pax1" placeholder="No Of Pax" onchange="validate_balance(this.id);get_basic_amount();" title="No Of Pax" value="<?php echo $sq_quotation['total_pax'];?>" >
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select class="form-control" name="travel_type1" id="travel_type1" title="Travel Type" onchange="reflect_feilds1();get_car_cost('1');">
				<option value="<?= $sq_quotation['travel_type'] ?>"><?= $sq_quotation['travel_type'] ?></option>
	            <option value="">Select Travel Type</option>
	            <option value="Local">Local</option>
	            <option value="Outstation">OutStation</option>
			</select>
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="vehicle_name1" id="vehicle_name1" title="Select vehicle name" class="form-control" onchange="get_capacity();get_car_cost('1');" required>
			<?php if( $sq_quotation['vehicle_name']!=""){?>
				<option value="<?= $sq_quotation['vehicle_name'] ?>"><?= $sq_quotation['vehicle_name'] ?></option>
                <option value="">*Select Vehicle</option>
                <?php
                    $sql = mysqlQuery("select * from b2b_transfer_master where status!='Inactive'");
                    while($row = mysqli_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php } }else{  ?>
					<option value="">*Select Vehicle</option>
                <?php
                    $sql = mysqlQuery("select * from b2b_transfer_master where status!='Inactive'");
                    while($row = mysqli_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php } } ?>
            </select>
	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="capacity1" name="capacity1"  placeholder="Capacity" title="Capacity"  value="<?= $sq_quotation['capacity'] ?>" onchange="get_basic_amount();">
	    </div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" class="form-control" id="local_places_to_visit1" name="local_places_to_visit1" placeholder="Route" onchange="validate_spaces(this.id)" title="Route" value="<?= $sq_quotation['local_places_to_visit'] ?>"> 
			<select name="places_to_visit1" id="places_to_visit1" title="Route" class="form-control" onchange="get_car_cost('1');">
				<?php
				if($sq_quotation['places_to_visit'] != ''){ ?>
					<option value="<?= $sq_quotation['places_to_visit'] ?>"><?= $sq_quotation['places_to_visit'] ?></option>
				<?php } ?>
				<option value="">Select Route</option>
					<?php
						$sql = mysqlQuery("select * from car_rental_tariff_entries where tour_type='Outstation'");
						while($row = mysqli_fetch_assoc($sql)){ 
						?>
							<option value="<?= $row['route']?>"><?= $row['route']?></option>
					<?php }  ?>
			</select>
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="extra_km_cost1" name="extra_km_cost1" placeholder="Extra KM Cost" title="Extra KM Cost" value="<?= $sq_quotation['extra_km_cost'] ?>" onchange="validate_balance(this.id);get_basic_amount();">
		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" class="form-control" id="extra_hr_cost1" name="extra_hr_cost1" placeholder="Extra Hr Cost" title="Extra Hr Cost" value="<?= $sq_quotation['extra_hr_cost'] ?>" onchange="validate_balance(this.id);get_basic_amount();"> 
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="rate1" name="rate1"  placeholder="*Rate" title="Rate" value="<?= $sq_quotation['rate'] ?>" onchange="get_basic_amount();">
	    </div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="from_date1" name="from_date1" placeholder="Travel From Date" title="Travel From Date" value="<?= get_date_user($sq_quotation['from_date'])?>" onchange="get_to_date(this.id,'to_date1');total_days_reflect()">
		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="to_date1" name="to_date1" placeholder="Travel To Date" title="Travel To Date" value="<?= get_date_user($sq_quotation['to_date'])?>" onchange="total_days_reflect();validate_validDate('from_date1','to_date1')">
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	     <input type="text" id="days_of_traveling1" name="days_of_traveling1" onchange="validate_balance(this.id);get_basic_amount();" placeholder="Days Of Travelling" title="Days Of Travelling" value="<?= $sq_quotation['days_of_traveling']?>" readonly>
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 update_field">
	      <input type="text" id="total_hr1" name="total_hr1"  placeholder="Total Hrs" title="Total Hrs" value="<?= $sq_quotation['total_hrs'] ?>" onchange=";validate_balance(this.id);get_basic_amount();">
	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 update_field">
	      	<input type="text" id="total_km1" name="total_km1"  placeholder="Total Km" title="Total Km" value="<?= $sq_quotation['total_km'] ?>" onchange=";validate_balance(this.id);get_basic_amount();">
	    </div>            
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      	<input type="text" id="total_max_km" name="total_max_km"  placeholder="Total Max Km" title="Total Max Km" onchange=";validate_balance(this.id);get_basic_amount();" value="<?= $sq_quotation['total_max_km']?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      	<input type="text" id="traveling_date1" name="traveling_date1" placeholder="Travelling Date" title="Travelling Date" value="<?= get_datetime_user($sq_quotation['traveling_date']) ?>">
	    </div>
	</div>
	<div class="row">
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      	<input type="text" class="form-control" id="quotation_date1" name="quotation_date1" placeholder="Quotation Date" title="Quotation Date" onchange="get_auto_values('quotation_date1','subtotal1','payment_mode','service_charge1','markup_cost1','update','true','basic', true);" value="<?= get_date_user($sq_quotation['quotation_date']) ?>"> 
	    </div>
	</div>
	<br><br>
	<div class="row text-center">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>
<script>
$('#from_date1,#to_date1,#total_hr,#total_km,#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry1,#other_charges1,#local_places_to_visit1,#places_to_visit1').hide();
$('#traveling_date1').datetimepicker({ format:'d-m-Y H:i' });
$('#from_date1,#to_date1,#quotation_date1').datetimepicker({ timepicker: false, format: 'd-m-Y' });

$('input').keyup(function(){	$(this).removeAttr('style');	});

$('#frm_tab11_c').validate({

	rules:{
		enquiry_id : { required : true },
		extra_km_cost1	:	{	regex	:	/^[0-9\.]*$/	},
		extra_hr_cost1	:	{	regex	:	/^[0-9\.]*$/	},
	},
	messages:{
		extra_km_cost1	:	"Only Numbers Allowed",
		extra_hr_cost1	:	"Only Numbers Allowed",
	},
	onkeyup: false,
	errorPlacement: function(error, element) {
		$(element).css({ border: '1px solid red' });
		$(element).val('');
		error_msg_alert(error[0].innerText);
	},

	submitHandler:function(form){

		if($("#rate1").val() <= 0){
			error_msg_alert("Please enter correct rate!");
			return false;
		}
		$('a[href="#tab_2_c"]').tab('show');
	}

});
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
reflect_feilds1();
function get_basic_amount(){
	
	var travel_type = $('#travel_type1').val();
	var capacity = $('#capacity1').val();
	var rate = $('#rate1').val();
	var total_max_km = $('#total_max_km').val();
	var days_of_traveling = $('#days_of_traveling1').val();
	var total_pax = $('#total_pax1').val();
	if(capacity==""){ capacity = 0;}
	if(rate==""){ rate = 0;}
	if(days_of_traveling==""){ days_of_traveling = 0;}
	if(total_pax==""){ total_pax = 0;}
	var no_of_vehicle = Math.ceil(parseFloat(total_pax)/parseFloat(capacity)); 
	
	var basic_amount = parseFloat(rate)*parseFloat(days_of_traveling)*parseFloat(no_of_vehicle);
	
	$('#subtotal1').val(basic_amount.toFixed(2));
	$('#subtotal1').trigger('change');
	// $('#total_tour_cost').val(basic_amount.toFixed(2));
	quotation_cost_calculate1();
}
function total_days_reflect(offset=''){
    var from_date = $('#from_date1'+offset).val(); 
    var to_date = $('#to_date1'+offset).val(); 
	if(from_date != ''&&to_date != ''){
		var edate = from_date.split("-");
		e_date = new Date(edate[2],edate[1]-1,edate[0]).getTime();
		var edate1 = to_date.split("-");
		e_date1 = new Date(edate1[2],edate1[1]-1,edate1[0]).getTime();

		var one_day=1000*60*60*24;

		var from_date_ms = new Date(e_date).getTime();
		var to_date_ms = new Date(e_date1).getTime();
		
		var difference_ms = to_date_ms - from_date_ms;
		var total_days = Math.round(Math.abs(difference_ms)/one_day); 

		total_days = parseFloat(total_days)+1;
		
		$('#days_of_traveling1'+offset).val(total_days);
	}
}
function get_capacity(){

	var vehicle_name = $('#vehicle_name1').val();
	var travel_type = $('#travel_type1').val();
	var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url+'view/package_booking/quotation/car_flight/car_rental/get_capacity.php', 
		
		data: { travel_type : travel_type,vehicle_name:vehicle_name },
		success: function(result){
			
			$('#capacity1').val(result);
		quotation_cost_calculate1();
		}
	});
}

</script>

