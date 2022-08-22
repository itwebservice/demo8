<div class="row">
    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_package_tour_quotation_dynamic_plane');event_airport('tbl_package_tour_quotation_dynamic_plane');"><i class="fa fa-plus"></i></button>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
        <table id="tbl_package_tour_quotation_dynamic_plane" name="tbl_package_tour_quotation_dynamic_plane" class="table mg_bt_0 table-bordered mg_bt_10 pd_bt_51">
			<?php 
			$sq_plane_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'"));
			if($sq_plane_count==0){
				?>
				<tr>
	                <td><input class="css-checkbox" id="chk_plan1" type="checkbox"><label class="css-label" for="chk_plan1"> </label></td>
	                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
	                <td><input type="text" name="from_sector-1" id="from_sector-1" placeholder="*From Sector" title="From Sector" style="width: 150px;">
					</td>
					<td><input type="text" name="to_sector-1" id="to_sector-1" placeholder="*To Sector" title="To Sector" style="width: 150px;">
					</td>            
		            <td title="Airline Name"><select id="airline_name1" class="form-control app_select2"  title="Airline Name" name="airline_name1" style="width: 160px;">
		                    <option value="">Airline Name</option>
		                    <?php get_airline_name_dropdown(); ?>
		            </select></td>
		            <td title="Class"><select name="plane_class" id="plane_class1" title="Class" class="form-control" style="width:100px">
				            	<option value="">Class</option>
				            	<option value="Economy">Economy</option>
			                    <option value="Premium Economy">Premium Economy</option>
			                    <option value="Business">Business</option>
			                    <option value="First Class">First Class</option>
				            </select></td>
		            <td><input type="text" id="txt_dapart1" name="txt_dapart1"  class="app_datetimepicker" placeholder="Departure Date and time" onchange="get_to_datetime(this.id,'txt_arrval1')" title="Departure Date and time" style="width:130px" /></td>	           
		            <td><input type="text" id="txt_arrval1" name="txt_arrval1" class="app_datetimepicker" placeholder="Arrival Date and time" title="Arrival Date and time" style="width:130px" onchange="validate_validDatetime('txt_dapart1',this.id)"/></td>
					<td><input type="hidden" id="from_city-1"></td>
					<td><input type="hidden" id="to_city-1"></td>
		            <td><input type="hidden" id="txt_count1" name="txt_count1" value=""></td></tr>
		        </tr>
		        <script>
		            $('#txt_dapart1, #txt_arrval1').datetimepicker({ timepicker:true, format:'d-m-Y H:i' });
	            	$('#txt_arrval1, #txt_dapart1').datetimepicker({format:'d-m-Y H:i' });
	            </script>
				<?php
			}
			else{
				$count = 0;
				$sq_q_plane = mysqlQuery("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'");
				while($row_q_plane = mysqli_fetch_assoc($sq_q_plane)){
					$count++;
					$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id=".$row_q_plane['from_city']));
					$sq_city2 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id=".$row_q_plane['to_city']));
					?>
					<tr>
						<td><input class="css-checkbox" id="chk_plan<?= $count ?>_1" type="checkbox" checked><label class="css-label" for="chk_plan<?= $count ?>_1"> </label></td>
		                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
		                <td><input type="text" name="from_sector-1" id="from_sector-<?= $count ?>_1" placeholder="*From Sector" title="From Sector" style="width: 250px;" value="<?php echo ($sq_city['city_name']) ? $sq_city['city_name']." - ".$row_q_plane['from_location'] : ''; ?>">
						</td>
						<td><input type="text" name="to_sector-1" id="to_sector-<?= $count ?>_1" placeholder="*To Sector" title="To Sector" style="width: 250px;" value="<?php echo ($sq_city2['city_name']) ? $sq_city2['city_name']." - ".$row_q_plane['to_location'] : ''; ?>">
						</td>
			            <td title="Airline Name"><select id="airline_name<?= $count ?>_1" class="form-control app_select2" title="Airline Name" name="airline_name1" style="width: 110px;">
			            	<?php if($row_q_plane['airline_name']!=''){
			            	$sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_q_plane[airline_name]'"));?>
			            	    <option value="<?= $sq_airline['airline_id'] ?>"><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></option>
			                    <?php }?>
			                     <option value="">Airline Name</option>
			                    <?php get_airline_name_dropdown(); ?>
			            </select></td>	
			            <td><select name="plane_class" id="plane_class<?= $count ?>_1" title="Class" class="form-control" style="width:110px">
			            	<?php if($row_q_plane['class']!=''){ ?>
			            		<option value="<?= $row_q_plane['class'] ?>"><?= $row_q_plane['class'] ?></option>
				            	<option value="">Class</option>
				            	<option value="Economy">Economy</option>
			                    <option value="Premium Economy">Premium Economy</option>
			                    <option value="Business">Business</option>
			                    <option value="First Class">First Class</option>
			                <?php } else{?>
			                	<option value="">Class</option>
				            	<option value="Economy">Economy</option>
			                    <option value="Premium Economy">Premium Economy</option>
			                    <option value="Business">Business</option>
			                    <option value="First Class">First Class</option>
			                <?php } ?> 
				            </select></td>
			            <td><input type="text" id="txt_dapart<?= $count ?>_1" name="txt_dapart" class="app_datetimepicker" placeholder="Departure Date and time" title="Departure Date and time" onchange="get_to_datetime(this.id,'txt_arrval<?= $count ?>_1')" value="<?= date('d-m-Y H:i', strtotime($row_q_plane['dapart_time'])) ?>" style="width:130px" /></td>
			            <td><input type="text" id="txt_arrval<?= $count ?>_1" name="txt_arrval" class="app_datetimepicker" placeholder="Arrival Date and time" title="Arrival Date and time" value="<?= date('d-m-Y H:i', strtotime($row_q_plane['arraval_time'])) ?>" style="width:130px" onchange="validate_validDatetime('txt_dapart<?= $count ?>_1',this.id)"/></td>
						<td><input type="hidden" id="from_city-<?= $count ?>_1" value="<?= $row_q_plane['from_city'] ?>"></td>
						<td><input type="hidden" id="to_city-<?= $count ?>_1" value="<?= $row_q_plane['to_city'] ?>"></td>
			            <td><input type="hidden" value="<?= $row_q_plane['id'] ?>"></td></tr>
			        </tr>

		            <script>
		            	$('#txt_arrval<?= $count ?>_1, #txt_dapart<?= $count ?>_1').datetimepicker({ format:'d-m-Y H:i' });
		            	$('#airline_name<?= $count ?>_1').select2();
		            </script>
					<?php
				}
			}
			?>
        </table>
        </div>
    </div>
</div>
<script>
	event_airport('tbl_package_tour_quotation_dynamic_plane');
</script>
