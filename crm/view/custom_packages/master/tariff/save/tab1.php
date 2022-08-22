<?php
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role_id= $_SESSION['role_id'];
?>
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
                    <select name="dest_id" id="dest_id" title="Select Destination" onchange="package_dynamic_reflect(this.id)" style="width:100%" required>
                        <option value="">*Select Destination</option>
                        <?php
                        $sq_query = mysqlQuery("select * from destination_master where status != 'Inactive'"); 
                        while($row_dest = mysqli_fetch_assoc($sq_query)){ ?>
                            <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <select name="package_id" id="package_id" title="Select Package" style="width:100%" required>
                    <option value=""><?php echo "*Select Package";  ?></option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="row mg_bt_10">
                <div class="col-md-12 text-right text_center_xs">
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-sm btnType st-custBtn" onclick="tariff_csv();" data-toggle="tooltip" title="Download CSV"><i class="icon fa fa-download"></i>CSV Format</button>

                        <div class="div-upload mg_bt_20" id="div_upload_button2" data-toggle="tooltip" title="Upload CSV">
                        <div id="b2btariff_csv_upload1" class="upload-button1"><span>CSV</span></div>
                        <span id="cust_status" ></span>
                        <ul id="files" ></ul>
                        <input type="hidden" id="hotel_tarrif_upload1" name="hotel_tarrif_upload1">
                        </div>
                    </div>
                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_package_tariff','2')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
                    <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_package_tariff','2')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tbl_package_tariff" name="tbl_package_tariff" class="table table-bordered table-hover table-striped pd_bt_51 no-marg" style="width: 1400px;">
                            <tr>
                                <td><input class="css-checkbox" id="chk_ticket1" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                                <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                                <td><select id="hotel_type" name="form-control" title="Select Hotel Type" style="width:170px;">
                                    <?php get_hotel_category_dropdown(); ?>
                                    </select></td>
                                <td><input type="number" id="min_pax" class="form-control" placeholder="*Min Pax" title="Min Pax" style="width:100px;" /></td>
                                <td><input type="number" id="max_pax" class="form-control" placeholder="*Max Pax" title="Max Pax" style="width:100px;" /></td>
                                <td><input type="text" id="from_date" class="form-control" placeholder="*From Date" title="Valid From Date" style="width:100px;" onchange="get_to_date(this.id,'to_date');"/></td>
                                <td><input type="text" id="to_date" class="form-control" placeholder="*To Date" title="Valid To Date" style="width:100px;" onchange="validate_validDate('from_date','to_date');" /></td>
                                <td><input type="number" id="badult_cost" class="form-control" placeholder="Adult PP" title="Adult PP Cost" style="width:120px;" /><span>B2B Cost</span></td>
                                <td><input type="number" id="bcwb_cost" class="form-control" placeholder="CWB PP" title="CWB PP Cost" style="width:120px;"/><span>B2B Cost</span></td>
                                <td><input type="number" id="bcwob_cost" class="form-control" placeholder="CWOB PP" title="CWOB PP Cost" style="width:120px;"/><span>B2B Cost</span></td>
                                <td><input type="number" id="binfant_cost" class="form-control" placeholder="Infant PP" title="Infant PP Cost" style="width:120px;"/><span>B2B Cost</span></td>
                                <td><input type="number" id="bextra_cost" class="form-control" placeholder="ExtraBed PP" title="ExtraBed PP Cost" style="width:120px;"/><span>B2B Cost</span></td>
                                <td><input type="number" id="cadult_cost" class="form-control" placeholder="Adult PP" title="Adult PP Cost" style="width:120px;"/><span>B2C Cost</span></td>
                                <td><input type="number" id="ccwb_cost" class="form-control" placeholder="CWB PP" title="CWB PP Cost" style="width:120px;"/><span>B2C Cost</span></td>
                                <td><input type="number" id="ccwob_cost" class="form-control" placeholder="CWOB PP" title="CWOB PP Cost" style="width:120px;"/><span>B2C Cost</span></td>
                                <td><input type="number" id="cinfant_cost" class="form-control" placeholder="Infant PP" title="Infant PP Cost" style="width:120px;"/><span>B2C Cost</span></td>
                                <td><input type="number" id="bextra_cost" class="form-control" placeholder="ExtraBed PP" title="ExtraBed PP Cost" style="width:120px;"/><span>B2C Cost</span></td>
                                <td><input type="hidden" id="entry_id" class="form-control" style="width:120px;"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 mg_tp_20 mg_bt_150">
                    <button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        <!-- </div> -->
    <!-- </div> -->
</form>
<?= end_panel() ?>

<script>
$('#dest_id').select2();
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

function tariff_csv(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/package_tariff_import.csv";
}

package_tarrif_save();
function package_tarrif_save(){
    var type="hotel_tariff_list";
	var btnUpload=$('#b2btariff_csv_upload1');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
        action: '../upload_tariff_csv.php',
        name: 'uploadfile',
        onSubmit: function(file, ext){
            if(!confirm('Do you want to import this file?')){
                return false;
            }
            if (! (ext && /^(csv)$/.test(ext))){ 
                error_msg_alert('Only CSV files are allowed');
                return false;
            }
            status.text('Uploading...');
        },
        onComplete: function(file, response){
            //On completion clear the status
            status.text('');
            //Add uploaded file to list
            if(response==="error"){          
                alert("File is not uploaded.");           
            }
            else{
                document.getElementById("hotel_tarrif_upload1").value = response;
                status.text('Uploading...');
                package_tarrif();
                status.text('');
            }
        }
    });
}

function package_tarrif(){
    var cust_csv_dir = document.getElementById("hotel_tarrif_upload1").value;
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/custom_packages/package_csv_tariff.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){

            var pass_arr = JSON.parse(result);

            var table = document.getElementById("tbl_package_tariff");
            if(table.rows.length == 1){
                for(var k=1; k<table.rows.length; k++){
                    document.getElementById("tbl_package_tariff").deleteRow(k);
                }
            }else{
                while(table.rows.length > 1){
                    document.getElementById("tbl_package_tariff").deleteRow(k);
                    table.rows.length--;
                }
            }
            
            for(var i=0; i<pass_arr.length; i++){

                var row = table.rows[i];
                row.cells[2].childNodes[0].value = pass_arr[i]['hotel_type'];
                row.cells[3].childNodes[0].value = pass_arr[i]['min_pax'];
                row.cells[4].childNodes[0].value = pass_arr[i]['max_pax'];
                row.cells[5].childNodes[0].value = pass_arr[i]['from_date'];
                row.cells[6].childNodes[0].value = pass_arr[i]['to_date'];
                row.cells[7].childNodes[0].value = pass_arr[i]['badult'];
                row.cells[8].childNodes[0].value = pass_arr[i]['bcwb'];			
                row.cells[9].childNodes[0].value = pass_arr[i]['bcwob'];
                row.cells[10].childNodes[0].value = pass_arr[i]['binfant'];
                row.cells[11].childNodes[0].value = pass_arr[i]['bextra'];
                row.cells[12].childNodes[0].value = pass_arr[i]['cadult'];				
                row.cells[13].childNodes[0].value = pass_arr[i]['ccwb'];
                row.cells[14].childNodes[0].value = pass_arr[i]['ccwob'];
                row.cells[15].childNodes[0].value = pass_arr[i]['cinfant'];
                row.cells[16].childNodes[0].value = pass_arr[i]['cextra'];
            
                if(i!=pass_arr.length-1){
                    if(table.rows[i+1]==undefined){
                        addRow('tbl_package_tariff');
                    }
                }
                $(row.cells[2].childNodes[0]).trigger('change');
            }
        }
    });
}

$('#frm_tab1').validate({
	rules:{ },
	submitHandler:function(form){
        
        var base_url = $('#base_url').val();
        var dest_id = $('#dest_id').val();
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
            if(row.cells[0].childNodes[0].checked){

                var hotel_type = row.cells[2].childNodes[0].value;
                var min_pax = row.cells[3].childNodes[0].value;
                var max_pax = row.cells[4].childNodes[0].value;
                var from_date = row.cells[5].childNodes[0].value;
                var to_date = row.cells[6].childNodes[0].value;
                var badult = row.cells[7].childNodes[0].value;
                var bcwb = row.cells[8].childNodes[0].value;
                var bcwob = row.cells[9].childNodes[0].value;
                var binfant = row.cells[10].childNodes[0].value;
                var bextrabed = row.cells[11].childNodes[0].value;
                var cadult = row.cells[12].childNodes[0].value;
                var ccwb = row.cells[13].childNodes[0].value;
                var ccwob = row.cells[14].childNodes[0].value;
                var cinfant = row.cells[15].childNodes[0].value;
                var cextrabed = row.cells[16].childNodes[0].value;

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

