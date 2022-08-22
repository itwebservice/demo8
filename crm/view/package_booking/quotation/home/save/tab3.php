<form id="frm_tab3">
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
	<input type="hidden" name="pckg_id_arr" id="pckg_id_arr"/>
	<input type="hidden" name="pckg_day_id_arr" id="pckg_day_id_arr"/>
	<input type="hidden" name="pckg_img_arr" id="pckg_img_arr"/>
	<div class="row">
		<div class="col-md-12 app_accordion">
  			<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">

				<!-- Flight Information -->
				<div class="accordion_content main_block mg_bt_10">
					
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2" id="collapsed2">                  
					        	<div class="col-md-12"><span>Flight Information</span></div>
					        </div>
					    </div>
					    <div id="collapse2" class="panel-collapse collapse in main_block" role="tabpanel" aria-labelledby="heading2">
					        <div class="panel-body">
								<div class="row">
								    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
								        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_plane')"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_tour_quotation_dynamic_plane')"><i class="fa fa-trash"></i></button>
								    </div>
								</div>
								<div class="row">
								    <div class="col-xs-12">
								        <div class="table-responsive">
								        <table id="tbl_package_tour_quotation_dynamic_plane" name="tbl_package_tour_quotation_dynamic_plane" class="table mg_bt_0 table-bordered pd_bt_51">
								            <tr>
								                <td><input class="css-checkbox" id="chk_plan1" type="checkbox"><label class="css-label" for="chk_plan1"> <label></td>
								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>								                			
												<td><input type="text" name="from_sector-1" id="from_sector-1" placeholder="*From Sector" title="From Sector" style="width: 300px;">
												</td>
									        	<td><input type="text" name="to_sector-1" id="to_sector-1" placeholder="*To Sector" title="To Sector" style="width: 300px;">
												</td>
									            <td><select id="airline_name1" class="app_select2 form-control" name="airline_name1" title="Airline Name" style="width: 120px;">
									                    <option value="">Airline Name</option>
									                    <?php get_airline_name_dropdown(); ?>
									            </select></td>
									            <td><select name="plane_class" id="plane_class1" title="Class"  style="width: 120px;">
									            	<option value="">Class</option>
									            	<option value="Economy">Economy</option>
								                    <option value="Premium Economy">Premium Economy</option>
								                    <option value="Business">Business</option>
								                    <option value="First Class">First Class</option>
									            </select></td>	            
									            <td><input type="text" id="txt_dapart1" name="txt_dapart" class="app_datetimepicker" placeholder="*Departure Date and time" title="Departure Date and time" onchange="get_to_datetime(this.id,'txt_arrval1')" value="<?= date('d-m-Y H:i') ?>" style="width: 150px;" /></td>
												<td><input type="text" id="txt_arrval1" name="txt_arrval" class="app_datetimepicker"  placeholder="*Arrival Date and time" title="Arrival Date and time" value="<?= date('d-m-Y H:i') ?>" style="width: 150px;" onchange="validate_validDatetime('txt_dapart1',this.id)"/></td>
												<td><input type="hidden" id="from_city-1"></td>								
												<td><input type="hidden" id="to_city-1"></td>
								            </tr>                                
								        </table>
								        </div>
								    </div>
								</div> 
					        </div>
					    </div>
					</div>
				</div>
				<!-- Train Information -->
				<div class="accordion_content main_block mg_bt_10">
					
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1" id="collapsed1">          
					        	<div class="col-md-12"><span>Train Information</span></div>
					        </div>
					    </div>
					    <div id="collapse1" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading1">
					        <div class="panel-body">
					        	<div class="row">
								    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
								        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_train');city_lzloading('.train_from','*From', true);city_lzloading('.train_to','*To', true)"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_tour_quotation_dynamic_train')"><i class="fa fa-trash"></i></button>
								    </div>
								</div>
								<div class="row">
								    <div class="col-xs-12">
								        <div class="table-responsive">
								        <table id="tbl_package_tour_quotation_dynamic_train" name="tbl_package_tour_quotation_dynamic_train" class="table mg_bt_0 table-bordered pd_bt_51">
								            <tr>
								                <td><input class="css-checkbox" id="chk_tour_group1" type="checkbox"><label class="css-label" for="chk_tour_group1"> <label></td>
								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
								                <td class="col-md-2"><select id="train_from_location1" onchange="validate_location('train_to_location1','train_from_location1');" class="app_select2 form-control train_from" name="train_from_location1" title="From Location" style="width:100%">
										                <option value="" selected="selected">*From</option>
										            </select>
								                </td>
								                 <td class="col-md-2"><select id="train_to_location1"  onchange="validate_location('train_from_location1','train_to_location1');" class="app_select2 form-control train_to" title="To Location" name="train_to_location1" style="width:100%">
									                <option value="" selected="selected">*To</option>
									            </select></td>
									            <td class="col-md-2"><select name="train_class" id="train_class1" title="Class">
									            	<option value="">Class</option>
									            	<option value="1A">1A</option>
												    <option value="2A">2A</option>
												    <option value="3A">3A</option>
												    <option value="FC">FC</option>
												    <option value="CC">CC</option>
												    <option value="SL">SL</option>
												    <option value="2S">2S</option>
									            </select></td>
									            <td class="col-md-3"><input type="text" id="train_departure_date" name="train_departure_date" placeholder="Departure Date and time" title="Departure Date and time" class="app_datetimepicker" onchange="get_to_datetime(this.id,'train_arrival_date')" value="<?= date('d-m-Y H:i') ?>"  style="width:100%"></td>
									            <td class="col-md-3"><input type="text" id="train_arrival_date" name="train_arrival_date" placeholder="Arrival Date and time" title="Arrival Date and time" class="app_datetimepicker" value="<?= date('d-m-Y H:i') ?>" style="width:100%" onchange="validate_validDatetime('train_departure_date',this.id)"></td>
								            </tr>                                
								        </table>
								        </div>
								    </div>
								</div> 
					        </div>
					    </div>
					</div>
				</div>

				<!-- Hotel Information -->
				<div class="accordion_content main_block mg_bt_10">
					
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4" id="collapsed4">                  
					        	<div class="col-md-12"><span>Hotel Information</span></div>
					        </div>
					    </div>
					    <div id="collapse4" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading4">
					        <div class="panel-body">
								<div class="row">
									<div class="col-xs-12 text-right mg_bt_20_sm_xs">
										<button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_hotel');city_lzloading('.city_name1');"><i class="fa fa-plus"></i></button>
									</div>
								</div>
								<div class="row">
								    <div class="col-xs-12">
								        <div class="table-responsive">
								        <table id="tbl_package_tour_quotation_dynamic_hotel" name="tbl_package_tour_quotation_dynamic_hotel" class="table mg_bt_0 table-bordered mg_bt_10">
								            <tr>
								                <td><input class="css-checkbox" id="chk_hotel1" type="checkbox" onchange="get_hotel_cost();" checked readonly><label class="css-label" for="chk_hotel1"> <label></td>
								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
							                    <td><select id="package_type-1" name="package_type-1" class="form-control app_select2" style="width:160px" title="Select Package Type">
							                        <?php echo get_package_type_dropdown(); ?>
							                    	</select></td>
							                    <td><select id="city_name1" name="city_name1" class="city_master_dropdown city_name1" style="width:160px" title="Select City Name">
													</select></td>
							                    <td><select id="hotel_name-1" name="hotel_name-1" onchange="hotel_type_load(this.id);get_hotel_cost();" class="form-control app_select2" style="width:160px" title="Select Hotel Name">
							                        <option value="">*Hotel Name</option>
							                    	</select></td>
												<td><select name="room_cat-1" id="room_cat-1" style="width:145px;" title="Room Category" class="form-control app_select2" onchange="get_hotel_cost();"><?php get_room_category_dropdown(); ?></select></td>
												<td><input type="text" style="width:150px;" class="app_datepicker" id="check_in-1" name="check_in-1" placeholder="*Check-In Date" title="Check-In Date"  onchange="get_auto_to_date(this.id);get_hotel_cost();"></td>
    											<td><input type="text" style="width:150px;" class="app_datepicker" id="check_out-1" name="check_out-1" placeholder="*Check-Out Date" title="Check-Out Date" onchange="calculate_total_nights(this.id);validate_validDates(this.id);get_hotel_cost();"></td>
							                    <td><input type="text" id="hotel_type-1" name="hotel_type-1" placeholder="Hotel Category" title="Hotel Category" style="width:150px" readonly></td>
											    <td class="hidden"><input type="text" id="hotel_stay_days-1" title="Total Nights" name="hotel_stay_days-1" placeholder="Total Nights" onchange="validate_balance(this.id);" style="display:none;"></td>
											    <td><input type="text" id="no_of_rooms-1" title="Total Rooms" name="no_of_rooms-1" placeholder="*Total Rooms" onchange="validate_balance(this.id);get_hotel_cost();" style="width:110px"></td>
						                		<td><input type="text" id="extra_bed-1" name="extra_bed-1" title="Extra Bed" placeholder="Extra Bed" onchange="validate_balance(this.id);get_hotel_cost();" style="width:100px"></td>
								                <td class="hidden"><input type="text" id="package_name1" name="package_name1" placeholder="Package Name" title="Package Name" style="width:200px;display:none;" readonly></td>  
						                		<td class="hidden"><input type="text" id="hotel_cost1" name="hotel_cost1" placeholder="Hotel Cost" title="Hotel Cost" style="display: none" onchange="validate_balance(this.id)"></td> 
						                		<td class="hidden"><input type="text" id="package_id1" name="package_id1" placeholder="Package ID" title="Package ID" style="display:none;"></td> 
						                		<td class="hidden"><input type="text" id="extra_bed_cost-1" name="extra_bed_cost-1" placeholder="Extra bed cost" title="Extra bed cost"  style="display: none" onchange="validate_balance(this.id)"></td> 
								            </tr>
								        </table>
								        </div>
								    </div>
								</div>
					        </div>
					    </div>
					</div>
				</div>

				<!-- Transport Information -->
				<div class="accordion_content main_block mg_bt_10">
					
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapse5" id="collapsed5">                  
					        	<div class="col-md-12"><span>Transport Information</span></div>
					        </div>
					    </div>
					    <div id="collapse5" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading5">
					        <div class="panel-body">
								<div class="row">
									<div class="col-xs-12 text-right mg_bt_20_sm_xs">
										<button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_transport');destinationLoading('.pickup_from', 'Pickup Location');destinationLoading('.drop_to', 'Drop-off Location');"><i class="fa fa-plus"></i></button>
									</div>
								</div>
								<div class="row">
								    <div class="col-xs-12">
								        <div class="table-responsive">
								        <table id="tbl_package_tour_quotation_dynamic_transport" name="tbl_package_tour_quotation_dynamic_transport" class="table mg_bt_0 table-bordered mg_bt_10">
								            <tr>
								                <td><input class="css-checkbox" id="chk_transport-" type="checkbox" onchange="get_transport_cost();" checked readonly><label class="css-label" for="chk_transport1" > </label></td>
								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
								                <td><select id="transport_vehicle-"  name="transport_vehicle-" title="Select Transport" onchange="get_transport_cost();" class="form-control app_select2" style="width:200px"> 
										                <option value="">Transport Vehicle</option>
														<?php
														$sq_query = mysqlQuery("select * from b2b_transfer_master where status != 'Inactive' order by vehicle_name asc"); 
														while($row_dest = mysqli_fetch_assoc($sq_query)){ ?>
															<option value="<?php echo $row_dest['entry_id']; ?>"><?php echo $row_dest['vehicle_name']; ?></option>
														<?php } ?>
													</select></td>
											    <td><input type="text" id="transport_start_date-" name="transport_start_date-" placeholder="Start Date" title="Start Date" class="app_datepicker" style="width:150px" onchange="get_to_date(this.id,'transport_end_date-');get_transport_cost();"></td>
											    <td><input type="text" id="transport_end_date-" name="transport_end_date-" placeholder="End Date" title="End Date" class="app_datepicker" style="width:150px" onchange="validate_validDate('transport_start_date-','transport_end_date-');"></td>
											    <td><select name="pickup_from-" id="pickup_from-" data-toggle="tooltip" style="width:250px;" title="Pickup Location" class="form-control app_select2 pickup_from" onchange="get_transport_cost();">
												</select></td>
								                <td><select name="drop_to-" id="drop_to-" style="width:250px;" data-toggle="tooltip" title="Drop-off Location" class="form-control app_select2 drop_to" onchange="get_transport_cost();">
													</select></td>
								                <td><input type="text" id="no_vehicles-" name="no_vehicles-" placeholder="*No.Of vehicles" title="No.Of vehicles" style="width:150px" onchange="get_transport_cost();"></td>
								                <td style="display:none;"><input type="text" id="transport_cost-" name="transport_cost-" placeholder="Cost" title="Cost" style="width:150" style="display:none;" ></td> 
								                <td style="display:none;"><input type="text" id="package_name-" name="package_name-" placeholder="Package Name" title="Package Name" style="width:200px" style="display:none;" readonly></td>
								                <td><input type="text" id="package_id-" name="package_id-" placeholder="Package ID" title="Package ID" style="display:none;"></td> 
								                <td><input type="hidden" id="pickup_type-" name="pickup_type-" style="display:none;"></td> 
								                <td><input type="hidden" id="drop_type" name="drop_type" style="display:none;"></td> 
								            </tr>                                
								        </table>
								        </div>
								    </div>
								</div> 
					        </div>
					    </div>
					</div>
				</div>

				<!-- Activity Information -->
				<div class="accordion_content main_block mg_bt_10">
					
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="true" aria-controls="collapse6" id="collapsed6">                  
					        	<div class="col-md-12"><span>Activity Information</span></div>
					        </div>
					    </div>
					    <div id="collapse6" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading6">
					        <div class="panel-body">
								<div class="row">
								    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
								        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_excursion');city_lzloading('.exc_city')"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_tour_quotation_dynamic_excursion')"><i class="fa fa-trash"></i></button>
								    </div>
								</div>
								<div class="row">
								    <div class="col-xs-12">
								        <div class="table-responsive">
								        <table id="tbl_package_tour_quotation_dynamic_excursion" name="tbl_package_tour_quotation_dynamic_excursion" class="table mg_bt_0 table-bordered pd_bt_51">
								            <tr>
								                <td><input class="css-checkbox" id="chk_tour_group-1" type="checkbox" onchange="get_excursion_amount();"><label class="css-label" for="chk_tour_group2"> <label></td>
								                <td style="width:10%"><input maxlength="15" value="1" type="text" name="username1" placeholder="Sr. No." class="form-control" disabled /></td>
    											<td><input type="text" id="exc_date-1" name="exc_date-1" placeholder="Activity Date & Time" title="Activity Date & Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i') ?>" style="width:150px" onchange="get_excursion_amount();"></td>
								                <td><select id="city_name-1" class="form-control exc_city" name="city_name-1" title="City Name" style="width:150px" onchange="get_excursion_list(this.id);">
													</select>
												</td>
												<td><select id="excursion-1" class="app_select2 form-control" title="Activity Name" name="excursion-1" style="width:150px" onchange="get_excursion_amount(this.id);">
									                <option value="">*Activity Name</option>
									            </select></td>
												<td><select name="transfer_option-1" id="transfer_option-1" data-toggle="tooltip" class="form-contrl app_select2" title="Transfer Option" style="width:150px" onchange="get_excursion_amount();">
													<option value="Private Transfer">Private Transfer</option>
													<option value="Without Transfer">Without Transfer</option>
													<option value="Sharing Transfer">Sharing Transfer</option>
													<option value="SIC">SIC</option>
													</select></td>
									            <td><input type="number" id="adult-1" name="adult-1" placeholder="Adult(s)" title="Adult(s)" style="width:100px" onchange="get_excursion_amount();validate_balance(this.id);validate_pax_count(this.id,'Adult');"></td>
									            <td><input type="number" id="child-1" name="child-1" placeholder="Child With-Bed" title="Child With-Bed" style="width:150px" onchange="get_excursion_amount();validate_balance(this.id);validate_pax_count(this.id,'ChildWithBed');" ></td>
									            <td><input type="number" id="childwo-1" name="childwo-1" placeholder="Child Without-Bed" title="Child Without-Bed" style="width:150px" onchange="get_excursion_amount();validate_balance(this.id);validate_pax_count(this.id,'ChildWithoutBed');" ></td>
									            <td><input type="number" id="infant-1" name="infant-1" placeholder="Infant(s)" title="Infant(s)" style="width:100px" onchange="get_excursion_amount();validate_balance(this.id);validate_pax_count(this.id,'Infant');" ></td>
									            <td style="display:none"><input type="text" id="excursion_amount-1" name="excursion_amount-1" placeholder="Activity Amount" title="Activity Amount" style="width:100px;display:none;" onchange="validate_balance(this.id);"></td>
									            <td style="display:none"><input type="number" id="adult_total-1" name="adult_total-1" style="width:100px;display:none;" ></td>
									            <td style="display:none"><input type="number" id="child_total-1" name="child_total-1" style="width:100px;display:none;" ></td>
									            <td style="display:none"><input type="number" id="childwo_total-1" name="childwo_total-1" style="width:100px;display:none;" ></td>
									            <td style="display:none"><input type="number" id="infant_total-1" name="infant_total-1" style="width:100px;display:none;" ></td>
								            </tr>
								        </table>
								        </div>
								    </div>
								</div>
					        </div>
					    </div>
					</div>
				</div>
				<!-- Cruise Information -->
				<div class="accordion_content main_block mg_bt_10">
					
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3" id="collapsed3">                  
					        	<div class="col-md-12"><span>Cruise Information</span></div>
					        </div>
					    </div>
					    <div id="collapse3" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading3">
					        <div class="panel-body">
								<div class="row mg_bt_10">
								    <div class="col-md-12 text-right text_center_xs">
								        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_quotation')"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_dynamic_cruise_quotation')"><i class="fa fa-trash"></i></button>
								    </div>
								</div>
								<div class="row mg_bt_10">
								    <div class="col-md-12">
								        <div class="table-responsive">
								        <table id="tbl_dynamic_cruise_quotation" name="tbl_dynamic_cruise_quotation" class="table table-bordered no-marg">
								            <tr>
								                <td><input class="css-checkbox" id="chk_cruise1" type="checkbox"><label class="css-label" for="chk_cruise1"><label></td>
								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
									            <td><input type="text" id="cruise_departure_date"  name="cruise_departure_date" placeholder="Departure Date and time"  title="Departure Date and time" class="app_datetimepicker" onchange="get_to_datetime(this.id,'cruise_arrival_date')" value="<?= date('d-m-Y H:i') ?>"></td>
									            <td><input type="text" id="cruise_arrival_date" name="cruise_arrival_date" placeholder="Arrival Date and time" title="Arrival Date and time" class="app_datetimepicker" value="<?= date('d-m-Y H:i') ?>" onchange="validate_validDatetime('cruise_departure_date',this.id)"></td>
									            <td><input type="text" id="route" onchange="validate_spaces(this.id);validate_decimal(this.id);" name="route" placeholder="*Route" title="Route"></td>
									            <td><input type="text" id="cabin" onchange="validate_spaces(this.id);validate_decimal(this.id);" name="cabin" placeholder="*Cabin" title="Cabin"></td>
									            <td><select id="sharing" name="sharing" style="width:100%;" title="Sharing">
									            		<option value="">Sharing</option>
									            		<option value="Single">Single</option>
									            		<option value="Double">Double</option>
									            		<option value="Triple Quad">Triple Quad</option>
									                </select></td>
								            </tr>                                
								        </table>
								        </div>
								    </div>
								</div>
					        </div>
					    </div>
					</div>
				</div>

		</div>
	</div>
	</div>
	<input type="hidden" id='exc_adult_cost'/>
	<input type="hidden" id='exc_child_cost'/>
	<input type="hidden" id='exc_childwo_cost'/>
	<input type="hidden" id='exc_infant_cost'/>
	<div class="row text-center mg_tp_30 mg_bt_30">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
<input type="hidden" id="hotel_pp_costing" name="hotel_pp_costing"/>
</form>
<?= end_panel() ?>

<script>

$('#airline_name1,#room_cat1,#pickup_from-,#drop_to-,#transport_vehicle-').select2();
$('#cruise_departure_date,#cruise_arrival_date,#exc_date-1').datetimepicker({ format:"d-m-Y H:i" });
$('#check_in-1, #check_out-1,#transport_start_date-,#transport_end_date-').datetimepicker({ format:'d-m-Y',timepicker:false });
destinationLoading("#pickup_from-", 'Pickup Location');
destinationLoading("#drop_to-", 'Drop-off Location');
city_lzloading('#city_name1,#city_name-1');
city_lzloading('#train_to_location1', "*To", true);
city_lzloading('#train_from_location1', "*From", true);
event_airport('tbl_package_tour_quotation_dynamic_plane');
// App_accordion
jQuery(document).ready(function() {
	jQuery(".panel-heading").click(function(){ 
		jQuery('#accordion .panel-heading').not(this).removeClass('isOpen');
		jQuery(this).toggleClass('isOpen');
		jQuery(this).next(".panel-collapse").addClass('thePanel');
		jQuery('#accordion .panel-collapse').not('.thePanel').slideUp("slow"); 
		jQuery(".thePanel").slideToggle("slow").removeClass('thePanel'); 
	});
});

//Get Hotel Cost
function get_hotel_cost(){
	
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

	var table = document.getElementById("tbl_package_tour_quotation_dynamic_hotel");
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];
		var hotel_id = row.cells[4].childNodes[0].value;
		var room_category = row.cells[5].childNodes[0].value;
		var check_in = row.cells[6].childNodes[0].value;
		var check_out = row.cells[7].childNodes[0].value;
		var total_nights = row.cells[9].childNodes[0].value;
		var total_rooms = row.cells[10].childNodes[0].value;
		var extra_bed = row.cells[11].childNodes[0].value;
		var package_id = row.cells[14].childNodes[0].value;
		
		hotel_id_arr.push(hotel_id);
		room_cat_arr.push(room_category);
		check_in_arr.push(check_in);
		check_out_arr.push(check_out);
		total_nights_arr.push(total_nights);
		total_rooms_arr.push(total_rooms);
		extra_bed_arr.push(extra_bed);
		package_id_arr.push(package_id);
		checked_arr.push(row.cells[0].childNodes[0].checked);
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
				if(row.cells[0].childNodes[0].checked){
					
					row.cells[13].childNodes[0].value = hotel_arr[i]['hotel_cost'];
					pp_arr.push({
						'adult_cost':hotel_arr[i]['adult_cost'],
						'child_with_bed':hotel_arr[i]['child_with_bed'],
						'child_without_bed':hotel_arr[i]['child_without_bed'],
						'package_id':hotel_arr[i]['package_id'],
						'flag':hotel_arr[i]['flag'],
						'package_type':row.cells[2].childNodes[0].value,
						'checked':true
					});
				}
				else{
					row.cells[13].childNodes[0].value = 0;
					pp_arr.push({
						'adult_cost':0,
						'child_with_bed':0,
						'child_without_bed':0,
						'package_id':hotel_arr[i]['package_id'],
						'package_type':row.cells[2].childNodes[0].value,
						'checked':false
					});
				}
			}
			//Tab-4 Per person costing
			$('#hotel_pp_costing').val(JSON.stringify(pp_arr));
		}
	});
}
$('#tbl_package_tour_quotation_dynamic_hotel').on('change', 'select[name="city_name1"]', function(){
    hotel_name_list_load(this.id);
});
//Get Transport Cost
function get_transport_cost(){

	var transport_id_arr = new Array();
	var travel_date_arr = new Array();
	var pickup_arr = new Array();
	var drop_arr = new Array();
	var pickup_id_arr = new Array();
	var drop_id_arr = new Array();
	var vehicle_count_arr = new Array();
	var ppackage_id_arr = new Array();
	var ppackage_name_arr = new Array();
	var table = document.getElementById("tbl_package_tour_quotation_dynamic_transport");

	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];		   
		var transport_id = row.cells[2].childNodes[0].value;
		var travel_date = row.cells[3].childNodes[0].value;
		var pickup = row.cells[5].childNodes[0].value;
		var drop = row.cells[6].childNodes[0].value;
		var pickup1 = pickup.split("-")[1];
		var drop1 = drop.split("-")[1];
		
    	var pickup_type = pickup.split("-")[0];
    	var drop_type = drop.split("-")[0];

		var vehicle_count = row.cells[7].childNodes[0].value; 
		var pname = row.cells[9].childNodes[0].value; 
		var pid = row.cells[10].childNodes[0].value; 

		transport_id_arr.push(transport_id);
		travel_date_arr.push(travel_date);
		pickup_arr.push(pickup1);
		drop_arr.push(drop1);
		pickup_id_arr.push(pickup_type);
		drop_id_arr.push(drop_type);
		vehicle_count_arr.push(vehicle_count);
		ppackage_id_arr.push(pid);
		ppackage_name_arr.push(pname);
	}
	$.ajax({
		type:'post',
		url: '../hotel/get_transport_cost.php',
		data:{ transport_id_arr : transport_id_arr,travel_date_arr:travel_date_arr,pickup_arr:pickup_arr,drop_arr:drop_arr,vehicle_count_arr:vehicle_count_arr ,pickup_id_arr:pickup_id_arr,drop_id_arr:drop_id_arr,ppackage_id_arr:ppackage_id_arr,ppackage_name_arr:ppackage_name_arr},
		success:function(result){
			var transport_arr = JSON.parse(result);
			var pp_arr = [];
			for(var i=0; i<transport_arr.length; i++){

				var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked){
					row.cells[8].childNodes[0].value = transport_arr[i]['total_cost'];	
					pp_arr.push({
						'total_cost':transport_arr[i]['total_cost'],
						'package_id':transport_arr[i]['package_id'],
						'checked':true
					});
				}
				else{
					row.cells[8].childNodes[0].value = 0;
					pp_arr.push({
						'total_cost':0,
						'package_id':transport_arr[i]['package_id'],
						'checked':false
					});
				}
			}
		}
	});
}

$(function(){
	$('#frm_tab3').validate({
		rules:{
		},
		submitHandler:function(form,e){
		e.preventDefault();
		
		var child_with_bed = $('#children_with_bed').val(); 
		var child_without_bed = $('#children_without_bed').val(); 
		var adult_count = $('#total_adult').val(); 
		var total_infant = $('#total_infant').val();
		
		//Train Info
	    var table = document.getElementById("tbl_package_tour_quotation_dynamic_train");
		var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++)
		{
		var row = table.rows[i];
			
		if(row.cells[0].childNodes[0].checked)
		{
			var train_from_location1 = row.cells[2].childNodes[0].value;         
			var train_to_location1 = row.cells[3].childNodes[0].value;         
			var train_class = row.cells[4].childNodes[0].value;         
			var train_arrival_date = row.cells[5].childNodes[0].value;         
			var train_departure_date = row.cells[6].childNodes[0].value;         
			
			if(train_from_location1=="")
			{
				error_msg_alert('Enter train from location in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_train').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(train_to_location1=="")
			{
				error_msg_alert('Enter train to location in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_train').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

		}      
		}

		 // Flight Info
		var table = document.getElementById("tbl_package_tour_quotation_dynamic_plane");
		var rowCount = table.rows.length;
		
		for(var i=0; i<rowCount; i++){
		    var row = table.rows[i];

		    if(row.cells[0].childNodes[0].checked){

		       var plane_from_location1 = row.cells[2].childNodes[0].value;			             
		       var plane_to_location1 = row.cells[3].childNodes[0].value;
		       var airline_name = row.cells[4].childNodes[0].value;  
		       var plane_class = row.cells[5].childNodes[0].value;  
		       var dapart1 = row.cells[6].childNodes[0].value;       
			   var arraval1 = row.cells[7].childNodes[0].value;
			   var plane_from_city = row.cells[8].childNodes[0].value;
			   var plane_to_city = row.cells[9].childNodes[0].value;   

		       if(plane_from_location1 == ""){
		          error_msg_alert('Enter from sector in row'+(i+1));
		          $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }

		       if(plane_to_location1 == ""){
		          error_msg_alert('Enter to sector in row'+(i+1));
		          $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }

				if(dapart1==""){ 
					error_msg_alert("Departure Datetime is required in row:"+(i+1));
		          $('.accordion_content').removeClass("indicator"); 
	          	  $('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
				  return false;
				}

			if(arraval1==""){
				error_msg_alert('Arrival Datetime is required in row:'+(i+1)); 
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}	
		}
		}

		
		//Cruise Information
		var table = document.getElementById("tbl_dynamic_cruise_quotation");
		var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++)
		{
		var row = table.rows[i];	 
		if(row.cells[0].childNodes[0].checked)
		{
			var cruise_from_date = row.cells[2].childNodes[0].value;    
			var cruise_to_date = row.cells[3].childNodes[0].value;    
			var route = row.cells[4].childNodes[0].value;    
			var cabin = row.cells[5].childNodes[0].value;  
			var sharing = row.cells[6].childNodes[0].value;        

			if(cruise_from_date=="")
			{
				error_msg_alert('Enter cruise Departure datetime in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

			if(cruise_to_date=="")
			{
				error_msg_alert('Enter cruise Arrival datetime  in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(route=="")
			{
				error_msg_alert('Enter route in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(cabin=="")
			{
				error_msg_alert('Enter cabin in row'+(i+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}

		}
		}

		//Hotel Information 
		var package_id_arr = [];
		var package_type_arr = [];
		var hotel_cost_arr = [];
		var extra_bed_cost_arr = [];
		var table = document.getElementById("tbl_package_tour_quotation_dynamic_hotel");
		var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++){

			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked){

				var package_type = row.cells[2].childNodes[0].value;
				var city_name = row.cells[3].childNodes[0].value;
				var hotel_id = row.cells[4].childNodes[0].value;  
				var hotel_cat = row.cells[5].childNodes[0].value;
				var check_in = row.cells[6].childNodes[0].value;  
				var checkout = row.cells[7].childNodes[0].value;        
				var hotel_stay_days1 = row.cells[9].childNodes[0].value;
				var total_rooms = row.cells[10].childNodes[0].value;
				var package_name1 = row.cells[12].childNodes[0].value;
				var hotel_cost = row.cells[13].childNodes[0].value;
				var package_id1 = row.cells[14].childNodes[0].value;
				var extra_bed_cost = row.cells[15].childNodes[0].value;
				
				if(package_type==""){
					error_msg_alert('Select Package Type in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(city_name==""){
					error_msg_alert('Select Hotel city in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(hotel_id==""){
					error_msg_alert('Enter Hotel in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(hotel_cat==""){
					error_msg_alert('Enter Room Category in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(check_in==""){
					error_msg_alert('Select Check-In date in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(checkout==""){
					error_msg_alert('Select Check-Out date in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(hotel_stay_days1==""){
					error_msg_alert('Enter Hotel total days in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(total_rooms == ""){
					error_msg_alert('Enter Hotel total rooms in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				package_id_arr.push(package_id1);
				package_type_arr.push(package_type);
				extra_bed_cost_arr.push(extra_bed_cost);
				hotel_cost_arr.push(hotel_cost);
			}
		}
		var unique_package_type_arr = [];
		for(var ptype_i = 0; ptype_i<package_type_arr.length; ptype_i++){
			var cost = 0;
			if(ptype_i == 0){
				unique_package_type_arr.push(package_type_arr[ptype_i]);
			}else{
				if(unique_package_type_arr.indexOf(package_type_arr[ptype_i]) == -1){
					unique_package_type_arr.push(package_type_arr[ptype_i]);
				}
			}
		}
		
		var uniquepackages = [];		
		$('input[name="custom_package"]:checked').each(function(){
			uniquepackages.push($(this).val());
		});

		var unique_package_id_arr = new Array();
		var hotel_main_arr = [];
		var hotel_per_person_arr = [];
		var per_person_costing = JSON.parse($('#hotel_pp_costing').val());
		
		//Creating unique package id wise array
		for(var i = 0; i<unique_package_type_arr.length; i++){

			var hotel_cost_total = 0;
			var hotel_data_arr = [];
			var checked_arr = [];
			var hotel_cost1 = 0;
			// if(!added){
				for(var k=0; k<rowCount; k++){

					var row = table.rows[k];
					var hotel_cost = row.cells[13].childNodes[0].value;
					var package_type = row.cells[2].childNodes[0].value;
					if(hotel_cost == ''){ hotel_cost = 0; }

					if(row.cells[0].childNodes[0].checked){
						
						if(package_type===unique_package_type_arr[i]){
							if(hotel_cost == 0){
								hotel_cost1 = 0;
								break;
							}else{
								hotel_cost1 += parseFloat(hotel_cost);
							}
						}
					}
				}
				var adult_cost_total = 0;
				var cwb_cost_total = 0;
				var cwob_cost_total = 0;
				var adult_cost_total1 = 0;
				var cwb_cost_total1 = 0;
				var cwob_cost_total1 = 0;
				var hotel_perperson_data_arr = [];
				for(var k=0; k < per_person_costing.length; k++){

					if(per_person_costing[k]['checked'] === true){
							
						adult_cost_total = parseFloat(per_person_costing[k]['adult_cost']);
						cwb_cost_total = parseFloat(per_person_costing[k]['child_with_bed']);
						cwob_cost_total = parseFloat(per_person_costing[k]['child_without_bed']);

						adult_cost_total = (isNaN(adult_cost_total)) ? 0 : adult_cost_total;
						cwb_cost_total = (isNaN(cwb_cost_total)) ? 0 : cwb_cost_total;
						cwob_cost_total = (isNaN(cwob_cost_total)) ? 0 : cwob_cost_total;
						console.log(per_person_costing[k]['package_type']);
						console.log(unique_package_type_arr[i]);
						if(per_person_costing[k]['package_type']==unique_package_type_arr[i]){
							if(adult_cost_total == 0){
								adult_cost_total1 = 0;
								cwb_cost_total1 = 0;
								cwob_cost_total1 = 0;
								// break;
							}else{
								adult_cost_total1 += parseFloat(adult_cost_total);
								cwb_cost_total1 += parseFloat(cwb_cost_total);
								cwob_cost_total1 += parseFloat(cwob_cost_total);
							}
						}
					}
				}
				hotel_per_person_arr.push({
					'package_id':package_id1,
					'adult_cost':adult_cost_total1,
					'cwb_cost':cwb_cost_total1,
					'cwob_cost':cwob_cost_total1,
					'type':unique_package_type_arr[i],
					'checked':false
				});
				console.log(hotel_per_person_arr);
				hotel_main_arr.push({
					'id':package_id1,
					'type':unique_package_type_arr[i],
					'cost':parseFloat(hotel_cost1),
					'checked':true
				});
		}
		if(hotel_per_person_arr.length === 0){
			var package_type_arr = 1; 
		}else{
			var package_type_arr = hotel_per_person_arr.length; 
		}
		//Group Costing
		var table = document.getElementById("tbl_package_tour_quotation_dynamic_costing");
		if(table.rows.length == 1){
			for(var k=1; k<table.rows.length; k++){
				document.getElementById("tbl_package_tour_quotation_dynamic_costing").deleteRow(k);
			}
		}else{
			while(table.rows.length > 1){
				document.getElementById("tbl_package_tour_quotation_dynamic_costing").deleteRow((table.rows.length-1));
				table.rows.length--;
			}
		}
		if(table.rows.length!=hotel_main_arr.length){
			for(var i=1; i<hotel_main_arr.length; i++){
				addRow('tbl_package_tour_quotation_dynamic_costing');
			}
		}
		if(hotel_per_person_arr.length === 0){
			var row = table.rows[0];
			row.cells[2].childNodes[1].value = 'NA';
			row.cells[3].childNodes[1].value = 0;
		}
		for(var k=0; k<hotel_main_arr.length; k++){
			var row = table.rows[k];
			row.cells[2].childNodes[1].value = hotel_main_arr[k]['type'];
			row.cells[3].childNodes[1].value = hotel_main_arr[k]['cost'];
		}
		var per_adult = [];
		var per_cwb = [];
		var per_cwob = [];
		var per_infant = [];

		//Adult & Child Per Person Costing
		var table = document.getElementById("tbl_package_tour_quotation_adult_child");
		if(table.rows.length == 1){
			for(var k=1; k<table.rows.length; k++){
				document.getElementById("tbl_package_tour_quotation_adult_child").deleteRow(k);
			}
		}else{
			while(table.rows.length > 1){
				document.getElementById("tbl_package_tour_quotation_adult_child").deleteRow((table.rows.length-1));
				table.rows.length--;
			}
		}
		if(table.rows.length!=hotel_per_person_arr.length){
			for(var i=1; i<hotel_per_person_arr.length; i++){

				addRow('tbl_package_tour_quotation_adult_child');
			} 
		}
		if(hotel_per_person_arr.length === 0){
			var row = table.rows[0];
			row.cells[0].childNodes[0].value = 'NA';
			row.cells[1].childNodes[0].value = 0;
		}
		for(var k=0; k<hotel_per_person_arr.length; k++){

			var row = table.rows[k];
			row.cells[0].childNodes[0].value = hotel_per_person_arr[k]['type'];
			row.cells[1].childNodes[0].value = hotel_per_person_arr[k]['adult_cost'];
			row.cells[2].childNodes[0].value = hotel_per_person_arr[k]['cwb_cost'];
			row.cells[3].childNodes[0].value = hotel_per_person_arr[k]['cwob_cost'];
			row.cells[4].childNodes[0].value = 0;
			per_adult.push(hotel_per_person_arr[k]['adult_cost']);
			per_cwb.push(hotel_per_person_arr[k]['cwb_cost']);
			per_cwob.push(hotel_per_person_arr[k]['cwob_cost']);
			per_infant.push(0);
		}
		////////////////////Hotel End//////////////////////////
		//Transport Information
		var package_id_arr1 = new Array();

		var table = document.getElementById("tbl_package_tour_quotation_dynamic_transport");
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++){

			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked){

				var transport_id = row.cells[2].childNodes[0].value;
				var travel_date = row.cells[3].childNodes[0].value;
				var end_date = row.cells[4].childNodes[0].value;
				var pickup = row.cells[5].childNodes[0].value;
				var drop = row.cells[6].childNodes[0].value;
				var vehicle_count = row.cells[7].childNodes[0].value; 
				var vehicle_cost = row.cells[8].childNodes[0].value; 
				var pname = row.cells[9].childNodes[0].value; 
				var pid = row.cells[10].childNodes[0].value; 
				
				if(transport_id==""){
					error_msg_alert('Select Transport Vehicle in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(travel_date==""){
					error_msg_alert('Enter Start date in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(end_date==""){
					error_msg_alert('Enter End date in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(pickup==""){
					error_msg_alert('Select pickup location in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(drop==""){
					error_msg_alert('Select drop location in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(vehicle_count==""){
					error_msg_alert('Enter vehicle count in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				if(vehicle_cost==""){
					error_msg_alert('Enter vehicle cost in row'+(i+1));
					$('.accordion_content').removeClass("indicator");
					$('#tbl_package_tour_quotation_dynamic_transport').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
				package_id_arr1.push(pid);
			}
		}

		var unique_package_id_arr = new Array();
		var transport_cost_total = 0;
		for(var k=0; k<rowCount; k++){

			var row = table.rows[k];
			var package_id1 = row.cells[10].childNodes[0].value;  
			if(row.cells[0].childNodes[0].checked){

				var transport_cost1 = row.cells[8].childNodes[0].value;  
				transport_cost_total = parseFloat(transport_cost_total) + parseFloat(transport_cost1);
			}
		}	  
		unique_package_id_arr.push({
			package_id: uniquepackages[i],
			transport_cost: (isNaN(transport_cost_total) ? 0 : transport_cost_total )
		});
		var total_passangers = $('#total_passangers').val();
		var per_person_tr_arr = [];
		for(var t=0;t<unique_package_id_arr.length;t++){
			per_person_tr_arr.push(parseFloat(unique_package_id_arr[t]['transport_cost']) / parseInt(total_passangers));
		}
		var table = document.getElementById("tbl_package_tour_quotation_adult_child");
		var rowCount = table.rows.length;
		if(per_adult.length == 0){
			
			for(var j=0; j<rowCount; j++){
				per_adult.push(0);
				per_cwb.push(0);
				per_cwob.push(0);
				per_infant.push(0);
			}
		}
		for(var j=0; j<package_type_arr; j++){

			var row = table.rows[j];
			var adult_cost_total1 = (per_adult[j]) ? per_adult[j] : 0;
			var cwb_cost_total1 = (per_cwb[j]) ? per_cwb[j] : 0;
			var cwob_cost_total1 = (per_cwob[j]) ? per_cwob[j] : 0;
			var infant_cost_total1 = (per_infant[j]) ? per_infant[j] : 0;

			var hadult_cost = (parseInt(adult_count) !== 0) ? per_person_tr_arr[0] : 0;
			var child_with_bed_coste = (parseInt(child_with_bed) !== 0) ? per_person_tr_arr[0] : 0;
			var child_without_bede = (parseInt(child_without_bed) !== 0) ? per_person_tr_arr[0] : 0;
			var exc_infant_coste = (parseInt(total_infant) !== 0) ? per_person_tr_arr[0] : 0;
			row.cells[1].childNodes[0].value = parseFloat(hadult_cost) + parseFloat(adult_cost_total1);
			row.cells[2].childNodes[0].value = parseFloat(child_with_bed_coste) + parseFloat(cwb_cost_total1);
			row.cells[3].childNodes[0].value = parseFloat(child_without_bede) + parseFloat(cwob_cost_total1);
			row.cells[4].childNodes[0].value = parseFloat(exc_infant_coste) + parseFloat(infant_cost_total1);
		}
		
		if(unique_package_id_arr.length !== 0){
			per_adult = [];
			per_cwb = [];
			per_cwob = [];
			per_infant = [];
			for(var j=0; j<rowCount; j++){
				var row = table.rows[j];
				per_adult.push(row.cells[1].childNodes[0].value);
				per_cwb.push(row.cells[2].childNodes[0].value);
				per_cwob.push(row.cells[3].childNodes[0].value);
				per_infant.push(row.cells[4].childNodes[0].value);
			}
		}
	////////////////// Transport End ///////////////////////
	var total_adult = $('#total_adult').val();
	var children_with_bed = $('#children_with_bed').val();
	var children_without_bed = $('#children_without_bed').val();
	var total_infant = $('#total_infant').val();
	var table = document.getElementById("tbl_package_tour_quotation_dynamic_excursion");
	var rowCount = table.rows.length;
	var total_amount = 0;
	var exc_adult_cost = 0;
	var exc_child_cot = 0;
	var exc_childwo_cot = 0;
	var exc_infant_cost = 0;
	for(var e=0; e<rowCount; e++)
	{
		var row = table.rows[e];
		if(row.cells[0].childNodes[0].checked){

			var exc_date = row.cells[2].childNodes[0].value;
			var city_name = row.cells[3].childNodes[0].value;
			var excursion_name = row.cells[4].childNodes[0].value;
			var transfer_option = row.cells[5].childNodes[0].value;

			if(exc_date=="") {
				error_msg_alert('Select Activity date in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 
			if(city_name=="") {
				error_msg_alert('Select Activity city in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			if(excursion_name=="") {
				error_msg_alert('Select Activity name in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			} 	
			if(transfer_option=="") {
				error_msg_alert('Select Transfer option in row'+(e+1));
				$('.accordion_content').removeClass("indicator");
				$('#tbl_package_tour_quotation_dynamic_excursion').parent('div').closest('.accordion_content').addClass("indicator");
				return false;
			}
			var e_amount = row.cells[10].childNodes[0].value;
			total_amount = parseFloat(total_amount) + parseFloat(e_amount);
			//For per person costing
			exc_adult_cost = parseFloat(exc_adult_cost) + parseFloat(row.cells[11].childNodes[0].value);
			exc_child_cot = parseFloat(exc_child_cot) + parseFloat(row.cells[12].childNodes[0].value);
			exc_childwo_cot = parseFloat(exc_childwo_cot) + parseFloat(row.cells[13].childNodes[0].value);
			exc_infant_cost = parseFloat(exc_infant_cost) + parseFloat(row.cells[14].childNodes[0].value);
		}
	}
	//Group costing
	var table = document.getElementById("tbl_package_tour_quotation_dynamic_costing");
	var rowCount = table.rows.length;
	for(var j=0; j<package_type_arr; j++){
		var row = table.rows[j];
		row.cells[5].childNodes[1].value = total_amount;
	}
	//Per person costing//Adult/Child costing
	var adult_cost_total = 0;
	var cwb_cost_total = 0;
	var cwob_cost_total = 0;
	var infant_cost_total = 0;

	var hadult_cost = parseFloat(exc_adult_cost) / parseInt(adult_count);
	var child_with_bed_coste = (parseInt(child_with_bed) !== 0) ? parseFloat(exc_child_cot) / parseInt(child_with_bed) : 0;
	var child_without_bede = (parseInt(child_without_bed) !== 0) ? parseFloat(exc_childwo_cot) / parseInt(child_without_bed) : 0;
	var exc_infant_coste = (parseInt(total_infant) !== 0) ? parseFloat(exc_infant_cost) / parseInt(total_infant) : 0;

	var table = document.getElementById("tbl_package_tour_quotation_adult_child");
	var rowCount = table.rows.length;
	if(per_adult.length == 0){
		
		for(var j=0; j<rowCount; j++){
			per_adult.push(0);
			per_cwb.push(0);
			per_cwob.push(0);
			per_infant.push(0);
		}
	}
	for(var j=0; j<package_type_arr; j++){

		var row = table.rows[j];
		var adult_cost_total1 = (per_adult[j]) ? per_adult[j] : 0;
		var cwb_cost_total1 = (per_cwb[j]) ? per_cwb[j] : 0;
		var cwob_cost_total1 = (per_cwob[j]) ? per_cwob[j] : 0;
		var infant_cost_total1 = (per_infant[j]) ? per_infant[j] : 0;
		row.cells[1].childNodes[0].value = parseFloat(parseFloat(hadult_cost) + parseFloat(adult_cost_total1)).toFixed(2);
		row.cells[2].childNodes[0].value = parseFloat(parseFloat(child_with_bed_coste) + parseFloat(cwb_cost_total1)).toFixed(2);
		row.cells[3].childNodes[0].value = parseFloat(parseFloat(child_without_bede) + parseFloat(cwob_cost_total1)).toFixed(2);
		row.cells[4].childNodes[0].value = parseFloat(parseFloat(exc_infant_coste) + parseFloat(infant_cost_total1)).toFixed(2);
	}

	var table = document.getElementById("tbl_package_tour_quotation_dynamic_costing");
	var rowCount = table.rows.length;
	for(var j=0; j<package_type_arr; j++){

		var row = table.rows[j];
		var package_id2 = row.cells[11].childNodes[1].value;
		var hotel_cost = row.cells[3].childNodes[1].value;
		row.cells[4].childNodes[1].value = unique_package_id_arr[0]['transport_cost'];
		var total_tour_cost = parseFloat(unique_package_id_arr[0]['transport_cost'])  + parseFloat(hotel_cost);
		
		row.cells[9].childNodes[1].value = total_tour_cost;
		
		var total_cost = row.cells[9].childNodes[1].value;
		var exc_cost = row.cells[5].childNodes[1].value;
		row.cells[6].childNodes[1].value = parseFloat(total_cost)+parseFloat(exc_cost);
		row.cells[9].childNodes[1].value = parseFloat(total_cost)+parseFloat(exc_cost);
		$(row.cells[6].childNodes[1]).trigger('change');
	}

	$('.accordion_content').removeClass("indicator");
	$('#tab3_head').addClass('done');
	$('#tab4_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab4').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);  
}	
});
});
function switch_to_tab2(){
	$('#tab3_head').removeClass('active');
	$('#tab_daywise_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab_daywise').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200); 
}
</script>

