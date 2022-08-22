<div class="row mg_bt_10">
    <div class="col-md-12 text-right text_center_xs">        
        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_group_tour_save_dynamic_train_update');city_lzloading('.trainfrom','*From',true);city_lzloading('.trainto','*To',true);"><i class="fa fa-plus"></i></button>
    </div>
</div>

<div class="row mg_bt_10">
    <div class="col-md-12">
        <div class="table-responsive">
			<table id="tbl_group_tour_save_dynamic_train_update" name="tbl_group_tour_save_dynamic_train_update" class="table table-bordered no-marg pd_bt_51">

				<?php 
				$sq_train_count = mysqli_num_rows(mysqlQuery("select * from group_train_entries where tour_id='$tour_id'"));
				if($sq_train_count==0){
					?>
					<tr>
						<td><input class="css-checkbox" id="chk_train1" type="checkbox"><label class="css-label" for="chk_train1"> <label></td>
						<td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
						<td class="col-md-4"><select id="train_from_location1" onchange="validate_location('train_from_location1','train_to_location1')" name="train_from_location1" class="app_select2 form-control trainfrom"  style="width: 100% !important;">
							</select>
						</td>
						<td class="col-md-4"><select id="train_to_location1" onchange="validate_location('train_to_location1','train_from_location1')" name="train_to_location1" class="app_select2 form-control trainto"  style="width: 100% !important;">
						</select></td>
						<td class="col-md-4"><select name="train_class" id="train_class1" title="Class">
									<option value="">Class</option>
									<?php get_train_class_dropdown(); ?>
						</select></td>
					</tr>      
					<?php
				}
				else{
					$count = 0;
					$sq_q_train = mysqlQuery("select * from group_train_entries where tour_id='$tour_id'");
					while($row_q_train = mysqli_fetch_assoc($sq_q_train)){
						$count++;
						?>
						<tr>
							<td><input class="css-checkbox" id="chk_train<?= $count ?>_1" type="checkbox" checked disabled><label class="css-label" for="chk_train<?= $count ?>_1"> <label></td>
							<td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
							<td><select id="train_from_location<?= $count ?>_1" onchange="validate_location('train_from_location<?= $count ?>_1','train_to_location<?= $count ?>_1')"  class="app_select2 form-control trainfrom" name="train_from_location" style="width: 300px!important;">
										<option value="<?= $row_q_train['from_location'] ?>"><?= $row_q_train['from_location'] ?></option>
								</select>
							</td>
							<td><select id="train_to_location<?= $count ?>_1" onchange="validate_location('train_to_location<?= $count ?>_1' , 'train_from_location<?= $count ?>_1')" class="app_select2 form-control trainto" name="train_to_location" style="width: 300px!important;">
									<option value="<?= $row_q_train['to_location'] ?>"><?= $row_q_train['to_location'] ?></option>	
							</select></td>
							<td><select name="train_class" id="train_class1" title="Class">
								<option value="<?= $row_q_train['class'] ?>"><?= $row_q_train['class'] ?></option>
								<?php get_train_class_dropdown(); ?>
							</select></td>
							<td class="hidden"><input type="text" value="<?= $row_q_train['id'] ?>"></td>
						</tr>          
						<?php
					}
				}
				?>
			</table>
        </div>
    </div>
</div> 
<script>
	$(document).ready(function(){
		city_lzloading('.trainfrom','*From',true);
		city_lzloading('.trainto','*To',true);
	});

</script>