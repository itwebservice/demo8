<form id="frm_tab1">
    <div class="app_panel">
        <!--=======Header panel======-->
        <div class="app_panel_head mg_bt_20">
            <div class="container">
                <h2 class="pull-left"></h2>
                <div class="pull-right header_btn">
                    <button>
                        <a title="Next"><i class="fa fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
        </div>
        <!--=======Header panel end======-->
        <div class="container">
            <div class="row mg_bt_10">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <select name="package_id" id="package_id" title="Package Name" style="width:100%" disabled>
                        <?php
                        $sq_tours = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$package_id'"));
                        ?>
                        <option value="<?= $sq_tours['package_id'] ?>"><?php echo $sq_tours['package_name'] ." (". $sq_tours['total_days']."D/".$sq_tours['total_nights']."N )" ?></option>';
                    </select>
                </div>
            </div>
            <hr/>
            <div class="row mg_bt_10">
                <div class="col-md-12 text-right text_center_xs">
                    <div class="col-md-6 text-left">
                    </div>
                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_package_tariff','2')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tbl_package_tariff" name="tbl_package_tariff" class="table table-bordered table-hover table-striped pd_bt_51 no-marg" style="width: 1400px;">
                        <?php
                        $count = 1;
                        $sq_tours = mysqlQuery("select * from custom_package_tariff where package_id = '$package_id'");
                        while($row_tours = mysqli_fetch_assoc($sq_tours)){

                            ?>
                            <tr>
                                <td><input class="css-checkbox" id="chk_ticket-u<?=$count?>" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                                <td><input maxlength="15" value="<?=$count?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                                <td><select id="hotel_type-u<?=$count?>" name="form-control" style="width:170px;" title="Select Hotel Type">
                                    <option value="<?= $row_tours['hotel_type'] ?>"><?= $row_tours['hotel_type'] ?></option>
                                    <?php get_hotel_category_dropdown(); ?>
                                    </select></td>
                                <td><input type="number" id="min_pax-u<?=$count?>" class="form-control" placeholder="*Min Pax" title="Min Pax" style="width:100px;" value="<?= $row_tours['min_pax'] ?>" /></td>
                                <td><input type="number" id="max_pax-u<?=$count?>" class="form-control" placeholder="*Max Pax" title="Max Pax" style="width:100px;" value="<?= $row_tours['max_pax'] ?>" /></td>
                                <td><input type="text" id="from_date-u<?=$count?>" class="form-control" placeholder="*From Date" title="Valid From Date" style="width:100px;" onchange="get_to_date(this.id,'to_date-u<?=$count?>');" value="<?= get_date_user($row_tours['from_date']) ?>"/></td>
                                <td><input type="text" id="to_date-u<?=$count?>" class="form-control" placeholder="*To Date" title="Valid To Date" style="width:100px;" onchange="validate_validDate('from_date-u<?=$count?>','to_date-u<?=$count?>');" value="<?= get_date_user($row_tours['to_date']) ?>" /></td>
                                <td><input type="number" id="badult_cost-u<?=$count?>" class="form-control" placeholder="Adult PP" title="Adult PP Cost" style="width:120px;" value="<?= $row_tours['badult'] ?>"/><span>B2B Cost</span></td>
                                <td><input type="number" id="bcwb_cost-u<?=$count?>" class="form-control" placeholder="CWB PP" title="CWB PP Cost" style="width:120px;" value="<?= $row_tours['bcwb'] ?>" /><span>B2B Cost</span></td>
                                <td><input type="number" id="bcwob_cost-u<?=$count?>" class="form-control" placeholder="CWOB PP" title="CWOB PP Cost" style="width:120px;" value="<?= $row_tours['bcwob'] ?>"/><span>B2B Cost</span></td>
                                <td><input type="number" id="binfant_cost-u<?=$count?>" class="form-control" placeholder="Infant PP" title="Infant PP Cost" style="width:120px;" value="<?= $row_tours['binfant'] ?>"/><span>B2B Cost</span></td>
                                <td><input type="number" id="bextra_cost-u<?=$count?>" class="form-control" placeholder="ExtraBed PP" title="ExtraBed PP Cost" style="width:120px;" value="<?= $row_tours['bextra'] ?>"/><span>B2B Cost</span></td>
                                <td><input type="number" id="cadult_cost-u<?=$count?>" class="form-control" placeholder="Adult PP" title="Adult PP Cost" style="width:120px;" value="<?= $row_tours['cadult'] ?>"/><span>B2C Cost</span></td>
                                <td><input type="number" id="ccwb_cost-u<?=$count?>" class="form-control" placeholder="CWB PP" title="CWB PP Cost" style="width:120px;" value="<?= $row_tours['ccwb'] ?>"/><span>B2C Cost</span></td>
                                <td><input type="number" id="ccwob_cost-u<?=$count?>" class="form-control" placeholder="CWOB PP" title="CWOB PP Cost" style="width:120px;" value="<?= $row_tours['ccwob'] ?>"/><span>B2C Cost</span></td>
                                <td><input type="number" id="cinfant_cost-u<?=$count?>" class="form-control" placeholder="Infant PP" title="Infant PP Cost" style="width:120px;" value="<?= $row_tours['cinfant'] ?>"/><span>B2C Cost</span></td>
                                <td><input type="number" id="bextra_cost-u<?=$count?>" class="form-control" placeholder="ExtraBed PP" title="ExtraBed PP Cost" style="width:120px;" value="<?= $row_tours['cextra'] ?>"/><span>B2C Cost</span></td>
                                <td><input type="hidden" id="entry_id-u<?=$count?>" class="form-control" value="<?= $row_tours['entry_id'] ?>"/></td>
                            </tr>
                            <script>
                                $('#from_date-u<?=$count?>, #to_date-u<?=$count?>').datetimepicker({ timepicker:false, format:'d-m-Y' });
                            </script>
                            <?php
                            $count++;
                        } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 mg_tp_20 mg_bt_150">
                    <button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
</form>
<?= end_panel() ?>

<script>
$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

function package_dynamic_reflect(dest_name) {
	var dest_id = $('#' + dest_name).val();
	var base_url = $('#base_url').val();

	$.ajax({
		type: 'post',
		url: base_url + 'view/custom_packages/master/tariff/save/get_package_name.php',
		data: { dest_id: dest_id },
		success: function (result) {
			$('#package_id').html(result);
		},
		error: function (result) {
			console.log(result.responseText);
		}
	});
}

$('#frm_tab1').validate({
	rules:{ },
	submitHandler:function(form){
        
        var base_url = $('#base_url').val();
        var package_id = $('#package_id').val();
        
        var table = document.getElementById("tbl_package_tariff");
	    var rowCount = table.rows.length;
        var count = 0;
        for(var i=0; i<rowCount; i++){
            var row = table.rows[i];
            if(row.cells[0].childNodes[0].checked){
                count++;
            }
        }
        if(parseInt(count) === 0){
            error_msg_alert('Enter information in atleast one row!');
            return false;
        }
        
        for(var i=0; i<rowCount; i++){

            var row = table.rows[i];

            var hotel_type = row.cells[2].childNodes[0].value;
            var min_pax = row.cells[3].childNodes[0].value;
            var max_pax = row.cells[4].childNodes[0].value;
            var from_date = row.cells[5].childNodes[0].value;
            var to_date = row.cells[6].childNodes[0].value;
            var badult = row.cells[7].childNodes[0].value;
            var bcwb = row.cells[8].childNodes[0].value;
            var bcwob = row.cells[9].childNodes[0].value;
            var binfant = row.cells[10].childNodes[0].value
            var bextrabed = row.cells[11].childNodes[0].value;
            var cadult = row.cells[12].childNodes[0].value;
            var ccwb = row.cells[13].childNodes[0].value;
            var ccwob = row.cells[14].childNodes[0].value;
            var cinfant = row.cells[15].childNodes[0].value;
            var cextrabed = row.cells[16].childNodes[0].value;
            
            if(row.cells[0].childNodes[0].checked == true){
                if(hotel_type== ''){
                    error_msg_alert('Select hotel type in row '+(i+1));
                    return false;
                }
                if(min_pax== ''){
                    error_msg_alert('Enter minimum pax in row '+(i+1));
                    return false;
                }
                if(max_pax== ''){
                    error_msg_alert('Enter maximum pax in row '+(i+1));
                    return false;
                }
                if(from_date== ''){
                    error_msg_alert('Select from date in row '+(i+1));
                    return false;
                }
                if(to_date== ''){
                    error_msg_alert('Select to date in row '+(i+1));
                    return false;
                }
                if(badult == '' && cadult == ''){
                    error_msg_alert('Enter atleast b2b adult or b2c adult cost');
                    return false;
                }
            }
        }
        $('#tab1_head').addClass('done');
        $('#tab2_head').addClass('active');
        $('.bk_tab').removeClass('active');
        $('#tab2').addClass('active');
        $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}
});
</script>

