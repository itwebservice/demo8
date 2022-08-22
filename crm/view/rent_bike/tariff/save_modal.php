<?php
include "../../../model/model.php";
?>
<form id="frm_tariff_save">
<div class="modal fade" id="tariff_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width:85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tariff</h4>
      </div>
      <div class="modal-body">       
          
          <div class="row mg_bt_20">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select id="bike_id" name="bike_id" style="width:100%" title="Select Bike" data-toggle="tooltip" required>
                      <option value="">*Select Bike</option>
                      <?php
                      $sq_query = mysqlQuery("select entry_id,bike_name,bike_type from bike_master where active_flag!='Inactive' order by bike_name");
                      while($row_query = mysqli_fetch_assoc($sq_query)){
                        $sq_bike = mysqli_fetch_assoc(mysqlQuery("select bike_type from bike_type_master where entry_id='$row_query[bike_type]' and active_flag!='Inactive'"));
                      ?>
                      <option value="<?= $row_query['entry_id'] ?>"><?= $row_query['bike_name'].'('.$sq_bike['bike_type'].')' ?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select name="currency_code" id="currency_code1" title="Currency" style="width:100%" data-toggle="tooltip" required>
                      <option value=''>*Select Currency</option>
                      <?php
                      $sq_currency = mysqlQuery("select * from currency_name_master order by currency_code");
                      while($row_currency = mysqli_fetch_assoc($sq_currency)){
                      ?>
                      <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                      <?php } ?>
                  </select>
              </div>
          </div>
          <div class="row mg_bt_10">
            <legend class="mg_tp_20 main_block text-center">Seasonal Tariff</legend>
            <div class="col-md-12 text-right text_center_xs">
            <?php
            include_once 'get_tariff_rows.php'; ?>

            <div class="row mg_bt_10">
              <legend class="mg_tp_20 main_block text-center">Offers/Coupons</legend>
              <div class="col-md-12 text-right text_center_xs">
              
                <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_bike_tarrif_offer')" title="Add row"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('table_bike_tarrif_offer')" title="Delete row"><i class="fa fa-trash"></i></button>
              </div>
            </div>
            <div class="row mg_bt_10">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="table_bike_tarrif_offer" name="table_bike_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="width:100%">
                    <tr>
                      <td><input class="css-checkbox" id="chk_offer" type="checkbox"><label class="css-label" for="chk_offer"> </label></td>
                      <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                      <td><select name="offer_type" id="offer_type" style="width: 125px" title="Select Type" class="form-control app_select2">
                        <option value=''>*Select Type</option>
                        <option value='Offer'>Offer</option>
                        <option value='Coupon'>Coupon</option></td>
                      <td><input type="text" id="from_dateo" class="form-control" name="from_dateo" placeholder="*Valid From" title="Valid From" value="<?= date('d-m-Y') ?>" style="width: 120px;" onchange="get_to_date(this.id,'to_dateo')"/></td>
                      <td><input type="text" id="to_dateo" class="form-control" name="to_dateo" placeholder="*Valid To " title="Valid To" onchange="validate_validDate('from_dateo' ,'to_dateo')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
                      <td><select name="amount_in" id="amount_in" style="width: 125px" title="Amount In" class="form-control app_select2">
                        <option value=''>*Amount In</option>
                        <option value='Flat'>Flat</option>
                        <option value='Percentage'>Percentage</option></select></td>
                      <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 130px;"/></td>
                      <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;"/></td>
                      <td><select name="agent_type" id="agent_type" title="Agent Type" style="width: 135px" class="form-control app_select2" multiple>
                        <option value=''>Agent Type</option>
                        <option value='Platinum'>Platinum</option>
                        <option value='Gold'>Gold</option>
                        <option value='Silver'>Silver</option></select></td>
                      <td><input type="hidden" id="entry_id" name="entry_id" /></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row text-center mg_tp_20 mg_bt_20"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="tariff_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
          </div> </div>
      </div>      
    </div>
</div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#tariff_save_modal').modal('show');
$('#agent_type').select2();
$('#bike_id,#currency_code1').select2();
$('#to_dateo,#from_dateo').datetimepicker({ timepicker:false, format:'d-m-Y' });
//Airport Name dropdown
function seasonal_csv(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/bike_tariff_import.csv";
}
bike_tarrif_save();
function bike_tarrif_save(){
	var btnUpload=$('#b2btariff_csv_upload');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
      action: 'tariff/upload_tariff_csv.php',
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
        } else{
          document.getElementById("bike_tarrif_upload").value = response;
          status.text('Uploading...');
          bike_tarrif1();
          status.text('');
          
        }
      }
    });
}

function bike_tarrif1(){
  var cust_csv_dir = document.getElementById("bike_tarrif_upload").value;
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/rent_bike/tariff_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){
            var pass_arr = JSON.parse(result);
            if(pass_arr[0]['room_cat']!=''){
                var table = document.getElementById("table_bike_tarrif");
                if(table.rows.length == 1){
                    for(var k=1; k<table.rows.length; k++){
                            document.getElementById("table_bike_tarrif").deleteRow(k);
                    }
                }else{
                    while(table.rows.length > 1){
                            document.getElementById("table_bike_tarrif").deleteRow(k);
                            table.rows.length--;
                    }
                }
                for(var i=0; i<pass_arr.length; i++){

                    var row = table.rows[i];

                    row.cells[2].childNodes[0].value = pass_arr[i]['city_id'];
                    row.cells[3].childNodes[0].value = pass_arr[i]['pickup_location'];
                    row.cells[4].childNodes[0].value = pass_arr[i]['from_date'];
                    row.cells[5].childNodes[0].value = pass_arr[i]['to_date'];
                    row.cells[6].childNodes[0].value = pass_arr[i]['no_of_bikes'];
                    row.cells[7].childNodes[0].value = pass_arr[i]['costing_type'];
                    row.cells[8].childNodes[0].value = pass_arr[i]['total_cost'];
                    row.cells[9].childNodes[0].value = pass_arr[i]['deposit'];
                    row.cells[10].childNodes[0].value = pass_arr[i]['markup_in'];
                    row.cells[11].childNodes[0].value = pass_arr[i]['markup_amount'];

                    if(i!=pass_arr.length-1){
                        if(table.rows[i+1]==undefined){
                          addRow('table_bike_tarrif');
                        }
                    }
                    $(row.cells[2].childNodes[0]).trigger('change');
                    $(row.cells[7].childNodes[0]).trigger('change');
                    $(row.cells[10].childNodes[0]).trigger('change');
                }
            }else{
                error_msg_alert('No Records in CSV!'); return false;
            }
        }
    });
}
$(function(){
  $('#frm_tariff_save').validate({
    rules:{
      service_tax : {required:true}
    },
    submitHandler:function(form){
	  
      $('#tariff_save').prop('disabled', true);
      var base_url = $('#base_url').val();
      var bike_id = $('#bike_id').val();
      var currency_id = $('#currency_code1').val();
      
      var city_array = [];
      var pickup_location_array = [];
      var from_date_array = [];
      var to_date_array = [];
      var no_bikes_array = [];
      var cost_type_array = [];
      var total_cost_array = [];
      var deposit_array = [];
      var markup_in_array = [];
      var markup_amount_array = [];      
      var count = 0;

      var table = document.getElementById("table_bike_tarrif");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];        
        if(row.cells[0].childNodes[0].checked){
          
          var city = row.cells[2].childNodes[0].value;
          var pickup_location = row.cells[3].childNodes[0].value;
          var from_dateo = row.cells[4].childNodes[0].value;
          var to_dateo = row.cells[5].childNodes[0].value;
          var no_bikes = row.cells[6].childNodes[0].value;
          var cost_type = row.cells[7].childNodes[0].value;
          var total_cost = row.cells[8].childNodes[0].value;
          var deposit = row.cells[9].childNodes[0].value;
          var markup_in = row.cells[10].childNodes[0].value;
          var markup_amount = row.cells[11].childNodes[0].value;

          if(city==''){
            error_msg_alert('Select city in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(pickup_location==''){
            error_msg_alert('Enter pickup location in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(from_dateo==''){
            error_msg_alert('Select valid from date in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(to_dateo==''){
            error_msg_alert('Select valid to date in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(no_bikes==''){
            error_msg_alert('Enter no of bikes in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(cost_type==''){
            error_msg_alert('Select costing type in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(total_cost==''){
            error_msg_alert('Enter total cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(deposit==''){
            error_msg_alert('Enter deposit cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(markup_in==''){
            error_msg_alert('Select markup in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          if(markup_amount==''){
            error_msg_alert('Enter markup cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
            return false;
          }
          city_array.push(city);
          pickup_location_array.push(pickup_location);
          from_date_array.push(from_dateo);
          to_date_array.push(to_dateo);
          no_bikes_array.push(no_bikes);
          cost_type_array.push(cost_type);
          total_cost_array.push(parseFloat(total_cost).toFixed(2));
          deposit_array.push(deposit);
          markup_in_array.push(markup_in);
          markup_amount_array.push(markup_amount);
          count++;
        }
      }
      if(parseInt(count) === 0){
        error_msg_alert('Select atleast one seasonal tariff!');
        $('#tariff_save').prop('disabled', false);
        return false;
      }
      
      //Offers
			var type_array = new Array();
			var ofrom_date_array = new Array();
			var oto_date_array = new Array();
			var offer_in_array = new Array();
			var offer_array = new Array();
			var coupon_code_array = new Array();
			var agent_type_array = new Array();
			var table = document.getElementById("table_bike_tarrif_offer");
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++){
			var row = table.rows[i];           

				if(row.cells[0].childNodes[0].checked){
					var type = row.cells[2].childNodes[0].value;
					var from_dateo = row.cells[3].childNodes[0].value;
					var to_dateo = row.cells[4].childNodes[0].value;
					var offer_in = row.cells[5].childNodes[0].value;
					var coupon_code = row.cells[6].childNodes[0].value;
					var offer = row.cells[7].childNodes[0].value;
					var agent_type = "";
					$(row.cells[8]).find('option:selected').each(function(){ agent_type += $(this).attr('value')+','; });
					agent_type = agent_type.trimChars(",");

					if(type==''){
						error_msg_alert('Select Type in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
						return false;
					}
					if(from_dateo==''){
						error_msg_alert('Select Valid From Date in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
						return false;
					}
					if(to_dateo==''){
						error_msg_alert('Select Valid To Date in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
						return false;
					}
					if(offer_in==''){
						error_msg_alert('Select Amount-In in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
						return false;
					}
					if(type == 'Coupon' && coupon_code == ''){
						error_msg_alert('Enter Coupon Code in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
						return false;
					}
					if(offer==''){
						error_msg_alert('Enter Amount in Row-'+(i+1));
            $('#tariff_save').prop('disabled', false);
						return false;
					}

					type_array.push(type);
					ofrom_date_array.push(from_dateo);
					oto_date_array.push(to_dateo);
					offer_in_array.push(offer_in);
					coupon_code_array.push(coupon_code);
					offer_array.push(offer);
					agent_type_array.push(agent_type);
				}
			}

      $('#tariff_save').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/rent_bike/tariff_save.php',
        data: {bike_id:bike_id,currency_id:currency_id,
          city_array:city_array,pickup_location_array:pickup_location_array,from_date_array:from_date_array,to_date_array:to_date_array,no_bikes_array:no_bikes_array,cost_type_array:cost_type_array,total_cost_array:total_cost_array,deposit_array:deposit_array,markup_in_array:markup_in_array,markup_amount_array:markup_amount_array,type_array:type_array,ofrom_date_array:ofrom_date_array,oto_date_array:oto_date_array,offer_in_array:offer_in_array,offer_array:offer_array,coupon_code_array:coupon_code_array,agent_type_array:agent_type_array},
          success:function(result){
            var msg = result.split('--');
            if(msg[0]=='error'){
              error_msg_alert(msg[1]);
              $('#tariff_save').button('reset');
              $('#tariff_save').prop('disabled', false);
              return false;
            }
            else{
              msg_alert(result);
              update_b2c_cache();
              $('#tariff_save').button('reset');
              $('#tariff_save_modal').modal('hide');
              reset_form('frm_tariff_save');
              $('#tariff_save').prop('disabled', false);
              tariff_list_reflect();
            }
          }
      });
      return false;
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>