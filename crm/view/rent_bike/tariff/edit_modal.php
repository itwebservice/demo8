<?php
include "../../../model/model.php";
$entry_id = $_POST['tariff_id'];
$sq_query = mysqli_fetch_assoc(mysqlQuery("select * from bike_tariff where entry_id='$entry_id'"));
$bike_id = $sq_query['bike_id'];
?>
<form id="frm_tariff_update">
<div class="modal fade" id="tariff_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width:85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Tariff</h4>
      </div>
      <div class="modal-body">       
          <input type="hidden" id="bentry_id" value="<?= $entry_id ?>"/>
          <div class="row mg_bt_20">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select id="bike_id1" name="bike_id1" style="width:100%" title="Bike Name" data-toggle="tooltip" disabled required>
                    <?php
                    $sq_veh = mysqli_fetch_assoc(mysqlQuery("select entry_id,bike_name,bike_type from bike_master where entry_id='$sq_query[bike_id]'"));
                    $sq_type = mysqli_fetch_assoc(mysqlQuery("select bike_type from bike_type_master where entry_id='$sq_veh[bike_type]'"));
                    ?>
                    <option value="<?= $sq_veh['entry_id'] ?>"><?= $sq_veh['bike_name'].'('.$sq_type['bike_type'].')' ?></option>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select name="currency_code" id="currency_code2" title="Currency" style="width:100%" data-toggle="tooltip" disabled required>
                      <?php
                      $sq_currency1 = mysqli_fetch_assoc(mysqlQuery("select currency_code,id from currency_name_master where id='$sq_query[currency_id]'"));
                      ?>
                      <option value="<?= $sq_currency1['id'] ?>"><?= $sq_currency1['currency_code'] ?></option>
                  </select>
              </div>
          </div>
          <div class="row mg_bt_10">
            <legend class="mg_tp_20 main_block text-center">Seasonal Tariff</legend>
            <div class="col-md-12 text-right text_center_xs">
                <?php
                $sq_tariff_count = mysqli_num_rows(mysqlQuery("select * from bike_tairff_entries where entry_id='$entry_id'"));
                if($sq_tariff_count == 0){
                  include_once 'get_tariff_rows.php'; 
                }
                else{
                  ?>
                    <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_bike_tarrif')" title="Add row"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="row mg_bt_10">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table_bike_tarrif" name="table_bike_tarrif" class="table table-bordered table-hover table-striped no-marg pd_bt_51" style="width:100%;">
                    <?php
                    $sq_query = mysqlQuery("select * from bike_tairff_entries where entry_id='$entry_id'");
                    $count = 0;
                    while($row_tariffentries = mysqli_fetch_assoc($sq_query)){

                      $count++;
                      $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_tariffentries[city_id]'"));
                      ?>
                      <tr>
                          <td><input class="css-checkbox" id="chk_transfer<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                          <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                          <td><select name="city_id" id="city_id<?= $count ?>-u" data-toggle="tooltip" style="width:150px;" title="Select City" class="form-control app_minselect2">
                              <option value="<?= $row['city_id'] ?>"><?= $row['city_name'] ?></option>
                              <?php get_cities_dropdown(); ?>
                          </select></td>
                          <td><input type="text" id="pickup_location<?= $count ?>-u" name="pickup_location" placeholder="*Pickup Location" title="Pickup Location" style="width: 200px;" value="<?= $row_tariffentries['pickup_location'] ?>" /></td>
                          <td><input type="text" id="from_date<?= $count ?>-u" class="form-control" name="from_date" placeholder="*Valid From" title="Valid From" value="<?= get_date_user($row_tariffentries['from_date']) ?>" onchange="get_to_date(this.id,'to_date<?= $count ?>-u')" style="width: 120px;" /></td>
                          <td><input type="text" id="to_date<?= $count ?>-u" class="form-control" name="to_date" placeholder="*Valid To " title="Valid To" value="<?= get_date_user($row_tariffentries['to_date']) ?>" onchange="validate_validDate('from_date<?= $count ?>-u' ,'to_date<?= $count ?>-u')" style="width: 120px;" /></td>
                          <td><input type="number" id="no_of_bike<?= $count ?>-us" name="no_of_bikes" placeholder="*No Of Bikes" title="No Of Bikes" style="width: 140px;" value="<?= $row_tariffentries['no_of_bikes'] ?>" /></td>
                          <td><select name="costing_type" id="costing_type<?= $count ?>-u" data-toggle="tooltip" style="width:150px;" title="Costing Type" class="form-control">
                              <option value="<?= $row_tariffentries['costing_type'] ?>"><?= $row_tariffentries['costing_type'] ?></option>
                              <option value="">*Costing Type</option>
                              <option value="Hourly">Hourly</option>
                              <option value="Daily">Daily</option>
                              <option value="Weekly">Weekly</option>
                              <option value="Monthly">Monthly</option>
                              <option value="Yearly">Yearly</option>
                          </select></td>
                          <td><input type="number" id="total_cost<?= $count ?>-u" value="<?= $row_tariffentries['total_cost'] ?>" name="total_cost<?= $count ?>-u" placeholder="*Total Cost" title="Total Cost" style="width: 120px;"/></td>
                          <td><input type="number" id="deposit<?= $count ?>-u" value="<?= $row_tariffentries['deposit'] ?>" name="deposit<?= $count ?>-u" placeholder="*Deposit" title="Deposit" onchange="validate_balance(this.id)" style="width: 100px;"/></td>
                          <td><select name="markup_in" id="markup_in<?= $count ?>-u" style="width:130px;" title="Markup In" data-toggle="tooltip" class="form-control app_select2">
                              <option value="<?= $row_tariffentries['markup_in'] ?>"><?= $row_tariffentries['markup_in'] ?></option>
                              <option value="">*Markup In</option>
                              <option value="Percentage">Percentage</option>
                              <option value="Flat">Flat</option>
                            </select></td>
                          <td><input type="text" id="markup_amount<?= $count ?>-u" name="markup_amount" placeholder="*Markup Amount" title="Markup Amount" value="<?= $row_tariffentries['markup_amount'] ?>" onchange="validate_balance(this.id)" style="width: 130px;" /></td>
                          <td><input type="hidden" id="entry_id" name="entry_id" value="<?= $row_tariffentries['tariff_id'] ?>" /></td>
                      </tr>
                      <script>
                        $('#city_id<?= $count ?>-u').select2({minimumInputLength:1});
                        $('#to_date<?= $count ?>-u,#from_date<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
                      </script>
                    <?php } ?>
                    </table>
                </div>
            </div>
            </div>

          <?php } ?>
          <!-- Offers -->
          <div class="col-md-12">
          <div class="row mg_bt_10">
              <legend class="mg_tp_20 main_block text-center">Offers/Coupons</legend>
              <div class="row text-right mg_bt_10">
                <div class="col-md-12 text-right text_center_xs">
                  <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_bike_tarrif_offer')" title="Add row"><i class="fa fa-plus"></i></button>
                </div>
              </div>
              <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="table_bike_tarrif_offer" name="table_bike_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="width:100%">
                  <?php
                  $sq_ocount = mysqli_num_rows(mysqlQuery("select * from bike_offers where bike_id='$bike_id'"));
                  if($sq_ocount == 0){
                  ?>
                    <tr>
                      <td><input class="css-checkbox" id="chk_offer" type="checkbox"><label class="css-label" for="chk_offer"> </label></td>
                      <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                      <td><select name="offer_type" id="offer_type" style="width: 125px" class="form-control app_select2">
                        <option value=''>Select Type</option>
                        <option value='Offer'>Offer</option>
                        <option value='Coupon'>Coupon</option></td>
                      <td><input type="text" id="from_dateo" class="form-control" name="from_dateo" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>" style="width: 120px;" onchange="get_to_date(this.id,'to_dateo')" /></td>
                      <td><input type="text" id="to_dateo" class="form-control" name="to_dateo" placeholder="Valid To " title="Valid To" onchange="validate_validDate('from_dateo','to_dateo')" value="<?= date('d-m-Y') ?>" style="width: 120px;" /></td>
                      <td><select name="amount_in" id="amount_in" style="width: 125px" class="form-control app_select2">
                        <option value=''>Amount In</option>
                        <option value='Flat'>Flat</option>
                        <option value='Percentage'>Percentage</option></select></td>
                      <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 130px;"/></td>
                      <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;"/></td>
                      <td><select name="agent_type" id="agent_type" style="width: 135px" title="Agent Type" class="form-control app_select2" multiple>
                        <option value=''>Agent Type</option>
                        <option value='Platinum'>Platinum</option>
                        <option value='Gold'>Gold</option>
                        <option value='Silver'>Silver</option></select></td>
                      <td><input type="hidden" id="entry_id" name="entry_id" /></td>
                    </tr>
                    <?php }
                    else{
                      $count=1;
                      $sq_offer = mysqlQuery("select * from bike_offers where bike_id='$bike_id'");
                      while($row_offer = mysqli_fetch_assoc($sq_offer)){ ?>
                        <tr>
                          <td><input class="css-checkbox" id="chk_offer<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_offer"> </label></td>
                          <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                          <td><select name="offer_type-u" id="offer_type-u<?= $count ?>" style="width: 125px" class="form-control app_select2">
                            <option value='<?= $row_offer['type'] ?>'><?= $row_offer['type'] ?></option>
                            <option value=''>Select Type</option>
                            <option value='Offer'>Offer</option>
                            <option value='Coupon'>Coupon</option></td>
                          <td><input type="text" id="ofrom_date-u<?= $count ?>" class="form-control" name="ofrom_date-u" placeholder="Valid From" title="Valid From" value="<?= get_date_user($row_offer['from_date']) ?>" style="width: 120px;" onchange="get_to_date(this.id,'oto_date-u<?= $count ?>')" /></td>
                          <td><input type="text" id="oto_date-u<?= $count ?>" class="form-control" name="oto_date" placeholder="Valid To " title="Valid To" onchange="validate_validDate('ofrom_date-u<?= $count ?>','oto_date-u<?= $count ?>')" value="<?= get_date_user($row_offer['to_date']) ?>" style="width: 120px;" /></td>
                          <td><select name="offer_in-u" id="offer_in-u<?= $count ?>" style="width: 120px" class="form-control app_select2">
                            <option value='<?= $row_offer['offer_in'] ?>'><?= $row_offer['offer_in'] ?></option>
                            <option value=''>Amount In</option>
                            <option value='Flat'>Flat</option>
                            <option value='Percentage'>Percentage</option></td>
                          <td><input type='text' id="coupon_code-u" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 130px;"value='<?= $row_offer['coupon_code'] ?>'/></td>
                          <td><input type="text" id="offer-u" name="offer-u" placeholder="*Amount" title="Amount" value='<?= $row_offer['offer_amount'] ?>' style="width: 120px;"/></td>
                          <td><select name="agent_type-u" id="agent_type-u<?= $count ?>" style="width: 130px" class="form-control app_select2" title="Agent Type" multiple>
                            <?php 
                            $agent_type = explode(',', $row_offer['agent_type']);
                            $sel = (in_array("Platinum", $agent_type)) ? "selected" : "" ?>
                            <option value='Platinum' <?= $sel ?>>Platinum</option>
                            <?php $sel = (in_array("Gold", $agent_type)) ? "selected" : "" ?>
                            <option value='Gold' <?= $sel ?>>Gold</option>
                            <?php $sel = (in_array("Silver", $agent_type)) ? "selected" : "" ?>
                            <option value='Silver' <?= $sel ?>>Silver</option>
                            </select></td>
                          <td><input type="hidden" id="entry_id" name="entry_id" value='<?= $row_offer['entry_id'] ?>' /></td>
                        </tr>
                      <script>
                        $('#ofrom_date-u<?= $count ?>,#oto_date-u<?= $count ?>').datetimepicker({ timepicker:false, format:'d-m-Y' });
                        $('#offer_type-u<?= $count ?>,#agent_type-u<?= $count ?>').select2();
                      </script>
                      <?php $count++; }
                    }?>
                  </table>
                </div>
              </div>
              </div>
          </div>
          </div>
          <div class="row text-center mg_tp_20"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="tariff_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>            
          </div> </div>
      </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#tariff_update_modal').modal('show');
$('#agent_type').select2();
$('#to_dateo,#from_dateo').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#bike_id1,#currency_code2').select2();
$(function(){
  $('#frm_tariff_update').validate({
    rules:{
      
    },
    submitHandler:function(form){

      $('#tariff_update').prop('disabled', true);
      var base_url = $('#base_url').val();
      var entry_id1 = $('#bentry_id').val();
      var bike_id = $('#bike_id1').val();
      var currency_id = $('#currency_code2').val();
      
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
			var bike_option_array = [];
			var basic_entryid_array = [];
      var count = 0;

      var table = document.getElementById("table_bike_tarrif");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++){
          
        var row = table.rows[i];
        var city = row.cells[2].childNodes[0].value;
        var pickup_location = row.cells[3].childNodes[0].value;
        var from_date = row.cells[4].childNodes[0].value;
        var to_date = row.cells[5].childNodes[0].value;
        var no_bikes = row.cells[6].childNodes[0].value;
        var cost_type = row.cells[7].childNodes[0].value;
        var total_cost = row.cells[8].childNodes[0].value;
        var deposit = row.cells[9].childNodes[0].value;
        var markup_in = row.cells[10].childNodes[0].value;
        var markup_amount = row.cells[11].childNodes[0].value;
        var entry_id = row.cells[12].childNodes[0].value;
        if(row.cells[0].childNodes[0].checked){
          if(city==''){
            error_msg_alert('Select city in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(pickup_location==''){
            error_msg_alert('Enter pickup location in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(from_date==''){
            error_msg_alert('Select valid from date in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(to_date==''){
            error_msg_alert('Select valid to date in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(no_bikes==''){
            error_msg_alert('Enter no of bikes in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(cost_type==''){
            error_msg_alert('Select costing type in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(total_cost==''){
            error_msg_alert('Enter total cost in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(deposit==''){
            error_msg_alert('Enter deposit cost in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(markup_in==''){
            error_msg_alert('Select markup in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          if(markup_amount==''){
            error_msg_alert('Enter markup cost in Row-'+(i+1));
            $('#tariff_update').prop('disabled', false);
            return false;
          }
          count++;
        }
        city_array.push(city);
        pickup_location_array.push(pickup_location);
        from_date_array.push(from_date);
        to_date_array.push(to_date);
        no_bikes_array.push(no_bikes);
        cost_type_array.push(cost_type);
        total_cost_array.push(parseFloat(total_cost).toFixed(2));
        deposit_array.push(deposit);
        markup_in_array.push(markup_in);
        markup_amount_array.push(markup_amount);
        basic_entryid_array.push(entry_id);
        bike_option_array.push(row.cells[0].childNodes[0].checked);
      }
      if(parseInt(count) == 0){
        error_msg_alert('Select atleast one seasonal tariff!');
        $('#tariff_update').prop('disabled', false);
        return false;
      }
      
      //Offers
			var offers_array = [];
			var type_array = new Array();
			var ofrom_date_array = new Array();
			var oto_date_array = new Array();
			var offer_in_array = new Array();
			var offer_array = new Array();
			var coupon_code_array = new Array();
			var agent_type_array = new Array();
			var offer_entryid_array = new Array();
			var table = document.getElementById("table_bike_tarrif_offer");
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++){
			var row = table.rows[i];           

        var type = row.cells[2].childNodes[0].value;
        var from_date = row.cells[3].childNodes[0].value;
        var to_date = row.cells[4].childNodes[0].value;
        var offer_in = row.cells[5].childNodes[0].value;
        var coupon_code = row.cells[6].childNodes[0].value;
        var offer = row.cells[7].childNodes[0].value;
        var entry_id = row.cells[9].childNodes[0].value;
        var agent_type = "";
        $(row.cells[8]).find('option:selected').each(function(){ agent_type += $(this).attr('value')+','; });
            agent_type = agent_type.trimChars(",");
          if(row.cells[0].childNodes[0].checked){

            if(type==''){
              error_msg_alert('Select Type in Row-'+(i+1));
              $('#tariff_update').prop('disabled', false);
              return false;
            }
            if(from_date==''){
              error_msg_alert('Select Valid From Date in Row-'+(i+1));
              $('#tariff_update').prop('disabled', false);
              return false;
            }
            if(to_date==''){
              error_msg_alert('Select Valid To Date in Row-'+(i+1));
              $('#tariff_update').prop('disabled', false)
              return false;
            }
            if(offer_in==''){
              error_msg_alert('Select Amount-In in Row-'+(i+1));
              $('#tariff_update').prop('disabled', false);
              return false;
            }
            if(type == 'Coupon' && coupon_code == ''){
              error_msg_alert('Enter Coupon Code in Row-'+(i+1));
              $('#tariff_update').prop('disabled', false);
              return false;
            }
            if(offer==''){
              error_msg_alert('Enter Amount in Row-'+(i+1));
              $('#tariff_update').prop('disabled', false);
              return false;
            }
          }

					type_array.push(type);
					ofrom_date_array.push(from_date);
					oto_date_array.push(to_date);
					offer_in_array.push(offer_in);
					coupon_code_array.push(coupon_code);
					offer_array.push(offer);
					agent_type_array.push(agent_type);
          offer_entryid_array.push(entry_id);
          offers_array.push(row.cells[0].childNodes[0].checked);
			}
      $('#tariff_update').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/rent_bike/tariff_update.php',
        data: { entry_id : entry_id1,bike_id:bike_id,currency_id:currency_id,city_array:city_array,pickup_location_array:pickup_location_array,from_date_array:from_date_array,to_date_array:to_date_array,no_bikes_array:no_bikes_array,cost_type_array:cost_type_array,total_cost_array:total_cost_array,deposit_array:deposit_array,markup_in_array:markup_in_array,markup_amount_array:markup_amount_array,type_array:type_array,ofrom_date_array:ofrom_date_array,oto_date_array:oto_date_array,offer_in_array:offer_in_array,offer_array:offer_array,coupon_code_array:coupon_code_array,agent_type_array:agent_type_array,offer_entryid_array:offer_entryid_array,offers_array:offers_array,bike_option_array:bike_option_array,basic_entryid_array:basic_entryid_array},
          success:function(result){
              var msg = result.split('--');
              if(msg[0]=='error'){
                  error_msg_alert(msg[1]);
                  $('#tariff_update').button('reset');
                  return false;
                }
              else{
                  msg_alert(result);
				          update_b2c_cache();
                  $('#tariff_update').button('reset');
                  $('#tariff_update_modal').modal('hide');
                  reset_form('frm_tariff_update');
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