
        <div class="col-md-6 text-left">
            <button type="button" class="btn btn-sm btnType st-custBtn" onclick="seasonal_csv();" data-toggle="tooltip" title="Download CSV"><i class="icon fa fa-download"></i>CSV Format</button>

            <div class="div-upload  mg_bt_20" data-toggle="tooltip" title="Upload CSV" id="div_upload_button1">
                <div id="b2btariff_csv_upload" role='button' class="upload-button1"><span>CSV</span></div>
                <span id="cust_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="ferry_tarrif_upload" name="ferry_tarrif_upload">
            </div>
        </div>
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_ferry_tarrif')" title="Add row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('table_ferry_tarrif')" title="Delete row"><i class="fa fa-trash"></i></button>
    </div>
</div>
<div class="row mg_bt_10">
<div class="col-md-12">
    <div class="table-responsive">
        <table id="table_ferry_tarrif" name="table_ferry_tarrif" class="table table-bordered table-hover table-striped no-marg pd_bt_51" style="width:100%;">
        <tr>
            <td><input class="css-checkbox" id="chk_ferry1" type="checkbox" checked><label class="css-label" for="chk_ferry"> </label></td>
            <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><input type="number" id="seats" name="seats" placeholder="*No Of Seats" title="No Of Seats" style="width: 128px;" /></td>
            <td><input type="text" id="from_date" class="form-control" name="from_date" placeholder="*Valid From" title="Valid From" value="<?= date('d-m-Y') ?>"  onchange="get_to_date(this.id,'to_date')" style="width: 120px;" /></td>
            <td><input type="text" id="to_date" class="form-control" name="to_date" placeholder="*Valid To " title="Valid To" onchange="validate_validDate('from_date' ,'to_date')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
            <td><select name="pickup_from" id="pickup_from" data-toggle="tooltip" style="width:150px;" title="From Location" class="form-control app_minselect2">
                <option value="">*From Location</option>
                <?php get_cities_dropdown(); ?>
            </select></td>
            <td><select name="drop_to" id="drop_to" style="width:155px;" data-toggle="tooltip" title="To Location" class="form-control app_minselect2">
                <option value="">*To Location</option>
                <?php get_cities_dropdown(); ?>
            </select></td>
            <td><input type="text" id="dept_date" class="form-control" name="from_date" placeholder="*Departure Datetime" title="Departure Datetime" value="<?= date('d-m-Y H:i') ?>"  onchange="get_to_datetime(this.id,'arrival_date')" style="width: 140px;" /></td>
            <td><input type="text" id="arrival_date" class="form-control" name="arrival_date" placeholder="*Arrival Datetime" title="Arrival Datetime" onchange="validate_validDatetime('dept_date' ,'arrival_date')" value="<?= date('d-m-Y H:i') ?>" style="width: 140px;" /></td>
            <td><select name="category" id="category" title="Select Ferry/Cruise Class" data-toggle="tooltip" class="form-control app_select2" style="width: 155px;">
            <?php echo get_ferry_types(); ?>
            </select></td>
            <td><input type="text" id="adult_cost" name="adult_cost" placeholder="*Adult Cost" title="Adult Cost" onchange="validate_balance(this.id)" style="width: 110px;"/></td>
            <td><input type="text" id="child_cost" name="child_cost" placeholder="*Child Cost" title="Child Cost" onchange="validate_balance(this.id)" style="width: 110px;"/></td>
            <td><input type="text" id="infant_cost" name="infant_cost" placeholder="*Infant Cost" title="Infant Cost" onchange="validate_balance(this.id)" style="width: 110px;"/></td>
            <td><select name="markup_in" id="markup_in" style="width: 125px" class="form-control app_select2" title="Markup In">
                <option value=''>Markup In</option>
                <option value='Flat'>Flat</option>
                <option value='Percentage'>Percentage</option></select></td>
            <td><input type='number' id="amount" name="amount" placeholder="*Markup Amount" class="form-control" title="Markup Amount" style="width: 147px;"/></td>
        </tr>
        <script>
        $('#pickup_from,#drop_to').select2({minimumInputLength:1});
        $('#to_date,#from_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
        $('#dept_date,#arrival_date').datetimepicker({ timepicker:true, format:'d-m-Y H:i' });
        $('#category').select2();
        </script>
        </table>
    </div>
</div>
</div>