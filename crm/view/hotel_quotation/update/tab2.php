<form id="frm_tab2">
	<div class="app_panel"> 
	<!--=======Header panel======-->
		<div class="app_panel_head mg_bt_20">
			<div class="container">
				<h2 class="pull-left"></h2>
				<div class="pull-right header_btn">
					<button>
						<a>
							<i class="fa fa-arrow-right"></i>
						</a>
					</button>
				</div>
			</div>
		</div> 
	<!--=======Header panel end======-->
	<div class="container">	
        <div class="row">
            <h3 class="editor_title main_block">Hotel Details</h3>
            <div class="row mg_bt_10" style="margin-right:0px">
                <div class="col-xs-12 text-right text_center_xs mg_tp_10">
                    <button type="button" class="btn btn-excel btn-sm" onClick="addRow('hotel_quotation_update');city_lzloading('.city_master_dropdown')"><i class="fa fa-plus"></i></button>
                </div>
                </div>
            
            <div class="col-md-12 col-sm-8 col-xs-12 no-pad table-responsive"> 
                <table style="width: 100%" id="hotel_quotation_update" name="hotel_quotation_update" class="table table-bordered table-hover table-striped no-marg pd_bt_51 mg_bt_0">
				<?php if($hotelDetails == ''){ ?>
					<tr>
						<td style="width: 50px;"><input class="css-checkbox mg_bt_10" id="chk_program-u_1" type="checkbox" checked><label class="css-label" for="chk_program-u_1"> <label></td>

						<td style="width: 50px;"><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control mg_bt_10" disabled />
						</td>

						<td><select id="city_name-u_1" name="city_name-u_1" class="city_master_dropdown" style="width:160px" onchange="hotel_name_list_load(this.id);" title="Select City Name">
							</select>
						</td>

						<td><select id="hotel_name-u_1" name="hotel_name-u_1" onchange="hotel_type_load(this.id);" style="width:160px" title="Select Hotel Name">
							<option value="">Hotel Name</option>
							</select>
						</td>

						<td><select name="room_cat-u_1" id="room_cat-u_1" style="width:145px;" title="Room Category" class="form-control app_select2" onchange=""><?php get_room_category_dropdown(); ?>
						</select>
						</td>

						<td><select name="meal_plan-u_1" id="meal_plan-u_1" style="width:145px;" title="Meal Plan" class="form-control app_select2"><?php get_mealplan_dropdown(); ?>
						</select>
						</td>

						<td><input type="text" style="width:150px;" class="app_datepicker" id="check_in-u_1" name="check_in-u_1" placeholder="Check-In Date" title="Check-In Date"  onchange="get_auto_to_date(this.id);" value="<?= $values['checkin'] ?>">
						</td>

						<td><input type="text" style="width:150px;" class="app_datepicker" id="check_out-u_1" name="check_out-u_1" placeholder="Check-Out Date" title="Check-Out Date" onchange="calculate_total_nights(this.id);validate_validDates(this.id);" value="<?= $values['checkout'] ?>">
						</td>

						<td><input type="text" id="hotel_type-u_1" name="hotel_type-1" placeholder="Hotel Category" title="Hotel Category" style="width:150px" value="<?= $values['hotel_type'] ?>" readonly>
						</td>

						<td><input type="text" id="hotel_stay_days-u_1" title="Total Nights" name="hotel_stay_days-u_1" placeholder="Total Nights" value="<?= $values['hotel_stay_days'] ?>" onchange="validate_balance(this.id);" style="width:150px;" readonly></td>

						<td><input type="text" id="no_of_rooms-u_1" title="Total Rooms" name="no_of_rooms-u_1" placeholder="Total Rooms" value="<?= $values['total_rooms'] ?>" onchange="validate_balance(this.id);" style="width:110px"></td>

						<td><input type="text" id="extra_bed-u_1" name="extra_bed-u_1" title="Extra Bed" placeholder="Extra Bed" onchange="validate_balance(this.id);" style="width:100px" value="<?= $values['extra_bed'] ?>"></td>

						<td class="hidden"><input type="hidden" id="hotel_cost-u_1" name="hotel_cost-u_1" placeholder="Hotel Cost" title="Hotel Cost" onchange="validate_balance(this.id)" style="width:100px;" value="<?= $values['hotel_cost'] ?>"></td> 
					</tr>
				<?php
				}
				else{
                    $count = 1;
                    foreach($hotelDetails as $values ){
                        $cityName = mysqli_fetch_assoc(mysqlQuery("SELECT `city_name` FROM `city_master` WHERE `city_id`=".$values['city_id']));
                        $hotelName = mysqli_fetch_assoc(mysqlQuery("SELECT `hotel_name` FROM `hotel_master` WHERE `hotel_id`=".$values['hotel_id']));
                		?>
						<tr>
							<td style="width: 50px;"><input class="css-checkbox mg_bt_10" id="chk_program-u_<?= $count ?>" type="checkbox" checked><label class="css-label" for="chk_program-u_<?= $count ?>"> <label></td>

							<td style="width: 50px;"><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control mg_bt_10" disabled />
							</td>

							<td><select id="city_name-u_<?= $count ?>" name="city_name-u_<?= $count ?>" class="city_master_dropdown" style="width:160px" onchange="hotel_name_list_load(this.id);" title="Select City Name">
								<option value="<?= $values['city_id'] ?>" selected><?= $cityName['city_name'] ?> </option>
								</select>
							</td>

							<td><select id="hotel_name-u_<?= $count ?>" name="hotel_name-u_<?= $count ?>" onchange="hotel_type_load(this.id);" style="width:160px" title="Select Hotel Name">
								<option value="<?= $values['hotel_id'] ?>" selected><?= $hotelName['hotel_name'] ?> </option>
								<option value="">Hotel Name</option>
								</select>
							</td>

							<td><select name="room_cat-u_<?= $count ?>" id="room_cat-u_<?= $count ?>" style="width:145px;" title="Room Category" class="form-control app_select2" onchange=""><?php get_room_category_dropdown(); ?>
							<option value="<?= $values['hotel_cat'] ?>" selected><?= $values['hotel_cat'] ?></option>
							</select>
							</td>

							<td><select name="meal_plan-u_<?= $count ?>" id="meal_plan-u_<?= $count ?>" style="width:145px;" title="Meal Plan" class="form-control app_select2"><?php get_mealplan_dropdown(); ?>
							<option value="<?= $values['meal_plan'] ?>" selected><?= $values['meal_plan'] ?></option>
							</select>
							</td>

							<td><input type="text" style="width:150px;" class="app_datepicker" id="check_in-u_<?= $count ?>" name="check_in-u_<?= $count ?>" placeholder="Check-In Date" title="Check-In Date"  onchange="get_auto_to_date(this.id);" value="<?= $values['checkin'] ?>">
							</td>

							<td><input type="text" style="width:150px;" class="app_datepicker" id="check_out-u_<?= $count ?>" name="check_out-u_<?= $count ?>" placeholder="Check-Out Date" title="Check-Out Date" onchange="calculate_total_nights(this.id);validate_validDates(this.id);" value="<?= $values['checkout'] ?>">
							</td>

							<td><input type="text" id="hotel_type-u_<?= $count ?>" name="hotel_type-1" placeholder="Hotel Category" title="Hotel Category" style="width:150px" value="<?= $values['hotel_type'] ?>" readonly>
							</td>

							<td><input type="text" id="hotel_stay_days-u_<?= $count ?>" title="Total Nights" name="hotel_stay_days-u_<?= $count ?>" placeholder="Total Nights" value="<?= $values['hotel_stay_days'] ?>" onchange="validate_balance(this.id);" style="width:150px;" readonly></td>

							<td><input type="text" id="no_of_rooms-u_<?= $count ?>" title="Total Rooms" name="no_of_rooms-u_<?= $count ?>" placeholder="Total Rooms" value="<?= $values['total_rooms'] ?>" onchange="validate_balance(this.id);" style="width:110px"></td>

							<td><input type="text" id="extra_bed-u_<?= $count ?>" name="extra_bed-u_<?= $count ?>" title="Extra Bed" placeholder="Extra Bed" onchange="validate_balance(this.id);" style="width:100px" value="<?= $values['extra_bed'] ?>"></td>

							<td class="hidden"><input type="hidden" id="hotel_cost-u_<?= $count ?>" name="hotel_cost-u_<?= $count ?>" placeholder="Hotel Cost" title="Hotel Cost" onchange="validate_balance(this.id)" style="width:100px;" value="<?= $values['hotel_cost'] ?>"></td> 
						</tr>
						<?php
						$count++; 
					} 
				} ?>
                </table>
            </div>
        </div>
    </div>
		    <div class="row text-center mg_tp_30 mg_bt_30" style="margin-right:0px">
			    <div class="col-xs-12">
				    <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
				    &nbsp;&nbsp;
				    <button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			    </div>
		    </div>
	    </div>
</form>


<script>
$('.app_datepicker').datetimepicker({ format:'d-m-Y',timepicker:false });
city_lzloading('.city_master_dropdown');
$('#dest_name').select2();
function switch_to_tab1(){ 
	$('#tab2_head').addClass('done');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
 }

$('#frm_tab2').validate({

	submitHandler:function(form,e)
	{
		e.preventDefault();
		var hotelcostArr = new Array();
		var hcount = 0;
	
		var table = document.getElementById("hotel_quotation_update");
		var rowCount = table.rows.length;

		var hcostTotal = 0;
		for(var i=0; i<rowCount; i++){

			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked){

				hcount++;
				var city_name = row.cells[2].childNodes[0].value;
				var hotel_id = row.cells[3].childNodes[0].value;  
				var hotel_cat = row.cells[4].childNodes[0].value;
				var check_in = row.cells[6].childNodes[0].value;  
				var checkout = row.cells[7].childNodes[0].value;        
				var hotel_stay_days1 = row.cells[9].childNodes[0].value;
				var total_rooms = row.cells[10].childNodes[0].value;
				var hotel_cost = row.cells[12].childNodes[0].value;  	      
				hcostTotal += Number(hotel_cost);

				if(city_name==""){
					error_msg_alert('Select Hotel city in Row '+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}

				if(hotel_id==""){
					error_msg_alert('Enter Hotel in Row '+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(hotel_cat==""){
					error_msg_alert('Enter Room Category in Row '+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(check_in==""){
					error_msg_alert('Select Check-In date in Row '+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(total_rooms==""){
					error_msg_alert('Enter total rooms in Row '+(i+1)+ ' in Option ' + quot);
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(checkout==""){
					error_msg_alert('Select Check-Out date in Row '+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(hotel_stay_days1==""){
					error_msg_alert('Enter Hotel total days in Row '+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
			}
		}
		if(parseInt(hcount) === 0){
			error_msg_alert("Atleast one hotel is required to proceed!");
			return false;
		}
		hotelcostArr.push(hcostTotal);
			
		$('#tab2_head').addClass('done');
		$('#tab3_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab3').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});
</script>