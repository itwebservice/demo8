<div class="row">
    <div class="col-xs-12 text-right mg_bt_20_sm_xs">
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_quotation')"><i class="fa fa-plus"></i></button>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
        <table id="tbl_dynamic_cruise_quotation" name="tbl_dynamic_cruise_quotation" class="table mg_bt_0 table-bordered mg_bt_10">

        	<?php
        	$sq_cruise_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));
        	if($sq_cruise_count==0){
        		?>
				<tr>
	                <td><input class="css-checkbox" id="chk_cruise1" type="checkbox"><label class="css-label" for="chk_cruise1"><label></td>
	                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
		            <td><input type="text" id="cruise_departure_date" name="cruise_departure_date" placeholder="Departure Date and Time" title="Departure Date and Time" class="app_datetimepicker" onchange="get_to_datetime(this.id,'cruise_arrival_date')" value="<?= date('d-m-Y H:i') ?>"></td>
		            <td><input type="text" id="cruise_arrival_date"  name="cruise_arrival_date" placeholder="Arrival Date and Time" title="Arrival Date and Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i') ?>"></td>
		            <td><input type="text" id="route" name="route" onchange="validate_specialChar(this.id)" placeholder="*Route" title="Route"></td>
		            <td><input type="text" id="cabin" name="cabin" onchange="validate_specialChar(this.id)" placeholder="*Cabin" title="Cabin"></td>
		            <td><select id="sharing" name="sharing" style="width:100%;" title="Sharing">
		            		<option value="">Sharing</option>
		            		<option value="Single">Single</option>
		            		<option value="Double">Double</option>
		            		<option value="Triple Quad">Triple Quad</option>
		                </select></td>
			        <td class="hidden"><input type="text" value=""></td>
	            </tr> 

		            <script>
		            	$('#cruise_arrival_date, #cruise_departure_date').datetimepicker({ timepicker:true, format:'d-m-Y H:i' });
		            </script>          
        		<?php
        	    } 
        		else{
        		$count = 0;
        		$sq_q_cruise = mysqlQuery("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'");
        		while($row_q_cruise = mysqli_fetch_assoc($sq_q_cruise)){
        			$count++;
        			?>
					<tr>
		                <td><input class="css-checkbox" id="chk_cruise<?= $count ?>_1" type="checkbox" checked><label class="css-label" for="chk_cruise<?= $count ?>_1"> <label></td>
		                <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
			            <td><input type="text" id="cruise_departure_date<?= $count ?>_u" name="cruise_departure_date<?= $count ?>_u" placeholder="Departure Date and time" title="Departure Date and time" class="app_datetimepicker" onchange="get_to_datetime(this.id,'cruise_arrival_date<?= $count ?>_u')" value="<?= get_datetime_user($row_q_cruise['dept_datetime']) ?>"></td>
			            <td><input type="text" id="cruise_arrival_date<?= $count ?>_u" name="cruise_arrival_date<?= $count ?>_u" placeholder="Arrival Date and time" title="Arrival Date and time" class="app_datetimepicker" value="<?= get_datetime_user($row_q_cruise['arrival_datetime']) ?>"></td>
			            <td><input type="text" id="route<?= $count ?>_u" name="route<?= $count ?>_u" placeholder="*Route" title="Route" value="<?= ($row_q_cruise['route']) ?>" onchange="validate_specialChar(this.id)"></td>
			            <td><input type="text" id="cabin<?= $count ?>_u" name="cabin<?= $count ?>_u" placeholder="*Cabin" title="Cabin" value="<?= ($row_q_cruise['cabin']) ?>"  onchange="validate_specialChar(this.id)"></td>
			            <td><select id="sharing<?= $count ?>_u" name="sharing<?= $count ?>_u" style="width:100%;" title="Sharing">
						<?php if($row_q_cruise['sharing']!='') { ?><option value="<?= ($row_q_cruise['sharing']) ?>"><?= ($row_q_cruise['sharing']) ?></option><?php }?>
			            		<option value="">Sharing</option>
			            		<option value="Single">Single</option>
			            		<option value="Double">Double</option>
			            		<option value="Triple Quad">Triple Quad</option>
			                </select></td>
			            <td class="hidden"><input type="text" value="<?= $row_q_cruise['id'] ?>"></td>
		            </tr>          
		            <script>
		            	$('#cruise_arrival_date<?= $count ?>_u, #cruise_departure_date<?= $count ?>_u').datetimepicker({ timepicker:true, format:'d-m-Y H:i' });
		            </script>
        			<?php
        		}
        	}
        	?>
        	</table>
        </div>
    </div>
</div> 