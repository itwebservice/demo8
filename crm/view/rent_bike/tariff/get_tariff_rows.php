    <div class="col-md-6 text-left">
        <button type="button" class="btn btn-sm btnType st-custBtn" onclick="seasonal_csv();" data-toggle="tooltip" title="Download CSV"><i class="icon fa fa-download"></i>CSV Format</button>

        <div class="div-upload  mg_bt_20" data-toggle="tooltip" title="Upload CSV" id="div_upload_button1">
            <div id="b2btariff_csv_upload" role='button' class="upload-button1"><span>CSV</span></div>
            <span id="cust_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="bike_tarrif_upload" name="bike_tarrif_upload">
        </div>
    </div>
    <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_bike_tarrif')" title="Add row"><i class="fa fa-plus"></i></button>
    <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('table_bike_tarrif')" title="Delete row"><i class="fa fa-trash"></i></button>
</div>
</div>
<div class="row mg_bt_10">
<div class="col-md-12">
    <div class="table-responsive">
        <table id="table_bike_tarrif" name="table_bike_tarrif" class="table table-bordered table-hover table-striped no-marg pd_bt_51" style="width:100%;">
        <tr>
            <td><input class="css-checkbox" id="chk_bike1" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
            <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="city_id" id="city_id" data-toggle="tooltip" style="width:150px;" title="Select City" class="form-control app_minselect2">
                <?php get_cities_dropdown(); ?>
            </select></td>
            <td><input type="text" id="pickup_location" name="pickup_location" placeholder="*Pickup Location" title="Pickup Location" style="width: 200px;" /></td>
            <td><input type="text" id="from_date" class="form-control" name="from_date" placeholder="*Valid From" title="Valid From" value="<?= date('d-m-Y') ?>"  onchange="get_to_date(this.id,'to_date')" style="width: 120px;" /></td>
            <td><input type="text" id="to_date" class="form-control" name="to_date" placeholder="*Valid To " title="Valid To" onchange="validate_validDate('from_date' ,'to_date')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
            <td><input type="number" id="no_of_bikes" name="no_of_bikes" placeholder="*No Of Bikes" title="No Of Bikes" style="width: 140px;" /></td>
            <td><select name="costing_type" id="costing_type" data-toggle="tooltip" style="width:150px;" title="Costing Type" class="form-control">
                <option value="">*Costing Type</option>
                <option value="Hourly">Hourly</option>
                <option value="Daily">Daily</option>
                <option value="Weekly">Weekly</option>
                <option value="Monthly">Monthly</option>
                <option value="Yearly">Yearly</option>
            </select></td>
            <td><input type="number" id="total_cost" name="total_cost" placeholder="*Total Cost" title="Total Cost" onchange="validate_balance(this.id)" style="width: 120px;"/></td>
            <td><input type="number" id="deposit" name="deposit" placeholder="*Deposit" title="Deposit" onchange="validate_balance(this.id)" style="width: 100px;"/></td>
            <td><select name="markup_in" id="markup_in" style="width:130px;" title="Markup In" data-toggle="tooltip" class="form-control app_select2">
            <option value="">*Markup In</option>
            <option value="Percentage">Percentage</option>
            <option value="Flat">Flat</option>
            </select></td>
            <td><input type="text" id="markup_amount" name="markup_amount" placeholder="*Markup Amount" title="Markup Amount" onchange="validate_balance(this.id)" style="width: 130px;" /></td>
        </tr>
        <script>
        $('#city_id').select2({minimumInputLength:1});
        $('#to_date,#from_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
        </script>
        </table>
    </div>
</div>
</div>