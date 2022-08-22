<?php
include "../../../model/model.php";
$sq_valid = mysqli_num_rows(mysqlQuery("select * from tcs_master where 1"));
$sq_query = mysqlQuery("select * from tcs_master where 1");
?>
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
	<table class="table table-hover no-marg-sm" id="tbl_tcs_list">
		<thead>
			<tr class="active table-heading-row">
				<th>SR.NO</th>
				<th>Service_Name</th>
				<th>Tax(%)</th>
				<th>Calculation_Mode</th>
				<th>Apply</th>
			</tr>
		</thead>
		<tbody>
            <?php
            if($sq_valid > 0){

                $count = 1;
                while($row_query = mysqli_fetch_assoc($sq_query)){
                    if($count == 1)
                        $service_name = 'Group Tour';
                    else if($count == 2)
                        $service_name = 'Package Tour';
                    else if($count == 3)
                        $service_name = 'Hotel';
                    else if($count == 4)
                        $service_name = 'Flight';
                    else if($count == 5)
                        $service_name = 'Train';
                    else if($count == 6)
                        $service_name = 'Visa';
                    else if($count == 7)
                        $service_name = 'Bus';
                    else if($count == 8)
                        $service_name = 'Car Rental';
                    else if($count == 9)
                        $service_name = 'Activity';
                    else if($count == 10)
                        $service_name = 'Miscellaneous';
                ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $service_name  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount<?=$count?>" name="tax_amount<?=$count?>" value="<?= $row_query['tax_amount'] ?>" />
                    <td>
                        <select name="calc<?=$count?>" id="calc<?=$count?>" title="Calculation" style="width: 139px;" class="form-control">
                            <?php
                            if($row_query['calc'] == '0')
                                $calc = 'Automatic';
                            else
                                $calc = 'Manual';
                            ?>
                            <option value="<?php echo $row_query['calc']; ?>"><?php echo $calc; ?></option>
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply<?=$count?>" id="apply<?=$count?>" title="Apply" style="width: 139px;" class="form-control">
                            <?php
                            if($row_query['apply'] == '0')
                                $calc = 'No';
                            else
                                $calc = 'Yes';
                            ?>
                            <option value="<?php echo $row_query['apply']; ?>"><?php echo $calc; ?></option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <?php $count++; 
                }
            }else{

                ?>
                <tr>
                    <td><?= '1' ?></td>
                    <td><?= 'Group Tour'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount1" name="tax_amount1" />
                    <td>
                        <select name="calc1" id="calc1" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply1" id="apply1" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '2' ?></td>
                    <td><?= 'Package Tour'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount2" name="tax_amount2" />
                    <td>
                        <select name="calc2" id="calc2" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply2" id="apply2" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '3' ?></td>
                    <td><?= 'Hotel'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount3" name="tax_amount3" />
                    <td>
                        <select name="calc3" id="calc3" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply3" id="apply3" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <!-- <tr>
                    <td><?= '4' ?></td>
                    <td><?= 'Flight'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount4" name="tax_amount5" />
                    <td>
                        <select name="calc4" id="calc4" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply4" id="apply4" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '5' ?></td>
                    <td><?= 'Train'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount5" name="tax_amount5" />
                    <td>
                        <select name="calc5" id="calc5" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply5" id="apply5" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '6' ?></td>
                    <td><?= 'Visa'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount6" name="tax_amount5" />
                    <td>
                        <select name="calc6" id="calc6" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply6" id="apply6" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '7' ?></td>
                    <td><?= 'Bus'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount7" name="tax_amount5" />
                    <td>
                        <select name="calc7" id="calc7" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply7" id="apply7" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '8' ?></td>
                    <td><?= 'Car Rental'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount8" name="tax_amount5" />
                    <td>
                        <select name="calc8" id="calc8" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply8" id="apply8" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '9' ?></td>
                    <td><?= 'Activity'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount9" name="tax_amount5" />
                    <td>
                        <select name="calc9" id="calc9" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply9" id="apply9" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?= '10' ?></td>
                    <td><?= 'Miscellaneous'  ?></td>
                    <td><input type="number" placeholder="TCS TAX(%)" title="TCS TAX(%)" id="tax_amount10" name="tax_amount5" />
                    <td>
                        <select name="calc10" id="calc10" title="Calculation" style="width: 139px;" class="form-control">
                            <option value="0">Automatic</option>
                            <option value="1">Manual</option>
                        </select>
                    </td>
                    <td>
                        <select name="apply10" id="apply10" title="Apply" style="width: 139px;" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                </tr> -->
            <?php } ?>
		</tbody>
	</table>
	</div> </div> </div>
	<div class="row mg_tp_20 text-center">
		<div class="col-md-4 col-md-offset-4 col-xs-4">
			<button id="btn_tcs_save" class="btn btn-sm btn-success" onclick="tcs_save()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;SAVE</button>
		</div>
	</div>

<script>
$('#tbl_tcs_list').dataTable({
    "pagingType": "full_numbers"
});

function tcs_save(){
	
	var base_url = $('#base_url').val();
	var tax_amount_arr = new Array();
	var calc_arr = new Array();
	var apply_arr = new Array();

    for(var i=1;i<=3;i++){

        var tax_amount = $('#tax_amount'+i).val();
        var calc = $('#calc'+i).val();
        var apply = $('#apply'+i).val();
        var service_name = '';
        if(parseInt(apply) == 1 && tax_amount == ''){
            if(parseInt(i) == 1 && tax_amount == ''){
                service_name = 'Group Tour';}
            else if(parseInt(i) == 2 &&  tax_amount == ''){
                service_name = 'Package Tour';}
            else if(parseInt(i) == 3 &&  tax_amount == ''){
                service_name = 'Hotel';}
            else if(parseInt(i) == 4 &&  tax_amount == ''){
                service_name = 'Flight';}
            else if(parseInt(i) == 5 &&  tax_amount == ''){
                service_name = 'Train';}
            else if(parseInt(i) == 6 &&  tax_amount == ''){
                service_name = 'Visa';}
            else if(parseInt(i) == 7 &&  tax_amount == ''){
                service_name = 'Bus';}
            else if(parseInt(i) == 8 &&  tax_amount == ''){
                service_name = 'Car Rental';}
            else if(parseInt(i) == 9 &&  tax_amount == ''){
                service_name = 'Activity';}
            else if(parseInt(i) == 10 &&  tax_amount == ''){
                service_name = 'Miscellaneous';
            }
            error_msg_alert('Enter tcs tax(%) for '+service_name);
            return false;
        }
        tax_amount_arr.push(tax_amount);
        calc_arr.push(calc);
        apply_arr.push(apply);
    }
	$('#btn_tcs_save').button('loading');
	$.ajax({
		type:'post',
		url:base_url+'controller/business_rules/tcs.php',
		data:{ tax_amount_arr : tax_amount_arr, calc_arr : calc_arr, apply_arr : apply_arr },
		success:function(result){
			msg_alert(result);
			$('#btn_tcs_save').button('reset');
			list_reflect();
		}
	});

}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>