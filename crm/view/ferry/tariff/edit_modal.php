<?php
include "../../../model/model.php";
$entry_id = $_POST['entry_id'];
$sq_ferry = mysqli_fetch_assoc(mysqlQuery("select * from ferry_master where entry_id='$entry_id'"));
$sq_tariffentries = mysqlQuery("select * from ferry_tariff where entry_id='$entry_id'");

$sq_tariff = mysqli_fetch_assoc(mysqlQuery("select * from ferry_tariff where entry_id='$entry_id'"));
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
          <input type="hidden" id="entry_id" value="<?= $entry_id ?>"/>
          <div class="row mg_bt_20">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select id="ferry_id1" name="ferry_id1" style="width:100%" title="Ferry/Cruise Name" data-toggle="tooltip" required disabled>
                      <option value="<?= $sq_ferry['entry_id'] ?>"><?= $sq_ferry['ferry_name'].'('.$sq_ferry['ferry_type'].')' ?></option>
                      <option value="">*Select Ferry/Cruise</option>
                      <?php
                      $sq_query = mysqlQuery("select entry_id,ferry_name,ferry_type from ferry_master where active_flag!='Inactive' order by ferry_name");
                      while($row_query = mysqli_fetch_assoc($sq_query)){
                      ?>
                      <option value="<?= $row_query['entry_id'] ?>"><?= $row_query['ferry_name'].'('.$row_query['ferry_type'].')' ?></option>
                      <?php } ?>
                  </select>
              </div>
          </div>
          <div class="row mg_bt_10">
            <div class="col-md-12 text-right text_center_xs">
                <?php
                $sq_tariff_count = mysqli_num_rows(mysqlQuery("select * from ferry_tariff where entry_id='$entry_id'"));
                if($sq_tariff_count == 0){
                  include_once 'get_tariff_rows.php'; 
                }
                else{
                  ?>
                    <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_ferry_tarrif_update')" title="Add row"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="row mg_bt_10">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table_ferry_tarrif_update" name="table_ferry_tarrif_update" class="table table-bordered table-hover table-striped no-marg pd_bt_51" style="width:100%;">
                    <?php
                    $count = 0;
                    while($row_tariffentries = mysqli_fetch_assoc($sq_tariffentries)){
                      
                      $count++;
                      $sq_from_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_tariffentries[from_location]'"));
                      $sq_to_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_tariffentries[to_location]'"));
                      
                      $sq_currency1 = mysqli_fetch_assoc(mysqlQuery("select * from currency_name_master where id='$row_tariffentries[currency_id]'"));
                      ?>
                      <tr>
                          <td><input class="css-checkbox" id="chk_ferry<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                          <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                          <td><input type="number" id="seats<?= $count ?>-u" name="seats<?= $count ?>-u" placeholder="*No Of Seats" title="No Of Seats" style="width: 128px;" value="<?= $row_tariffentries['no_of_seats'] ?>"/></td>
                          <td><input type="text" id="from_date<?= $count ?>-u" class="form-control" name="from_date" placeholder="*Valid From" value="<?= get_date_user($row_tariffentries['valid_from_date']) ?>" title="Valid From" onchange="get_to_date(this.id,'to_date<?= $count ?>-u')" style="width: 120px;" /></td>
                          <td><input type="text" id="to_date<?= $count ?>-u" class="form-control" name="to_date" placeholder="*Valid To" value="<?= get_date_user($row_tariffentries['valid_to_date']) ?>" title="Valid To" onchange="validate_validDate('from_date<?= $count ?>-u' ,'to_date<?= $count ?>-u')" style="width: 120px;" /></td>
                          <td><select name="pickup_from" id="pickup_from<?= $count ?>-u" data-toggle="tooltip" style="width:150px;" title="From Location" class="form-control app_minselect2">
                            <option value="<?= $sq_from_city['city_id'] ?>"><?= $sq_from_city['city_name'] ?></option>
                              <option value="">*From Location</option>
                              <?php get_cities_dropdown(); ?>
                          </select></td>
                          <td><select name="drop_to" id="drop_to<?= $count ?>-u" style="width:155px;" data-toggle="tooltip" title="To Location" class="form-control app_minselect2">
                            <option value="<?= $sq_to_city['city_id'] ?>"><?= $sq_to_city['city_name'] ?></option>
                              <option value="">*To Location</option>
                              <?php get_cities_dropdown(); ?>
                          </select></td>
                          <td><input type="text" id="dept_date<?= $count ?>-u" class="form-control" name="from_date" placeholder="*Departure Datetime" value="<?= get_datetime_user($row_tariffentries['dep_date']) ?>" title="Departure Datetime" onchange="get_to_datetime(this.id,'arrival_date<?= $count ?>-u')" style="width: 140px;" /></td>
                          <td><input type="text" id="arrival_date<?= $count ?>-u" class="form-control" name="arrival_date" placeholder="*Arrival Datetime" value="<?= get_datetime_user($row_tariffentries['arr_date']) ?>" title="Arrival Datetime" onchange="validate_validDatetime('dept_date<?= $count ?>-u' ,'arrival_date<?= $count ?>-u')" style="width: 140px;" /></td>
                          <td><select name="category" id="category<?= $count ?>-u" title="Select Ferry/Cruise Class" data-toggle="tooltip" class="form-control app_select2" style="width: 155px;">
                            <option value="<?= $row_tariffentries['category'] ?>"><?= $row_tariffentries['category'] ?></option>
                            <?php echo get_ferry_types(); ?>
                          </select></td>
                          <td><input type="text" id="adult_cost<?= $count ?>-u" name="adult_cost" placeholder="*Adult Cost" title="Adult Cost" onchange="validate_balance(this.id)" style="width: 110px;" value="<?= $row_tariffentries['adult_cost'] ?>"/></td>
                          <td><input type="text" id="child_cost<?= $count ?>-u" name="child_cost" placeholder="*Child Cost" title="Child Cost" onchange="validate_balance(this.id)" style="width: 110px;" value="<?= $row_tariffentries['child_cost'] ?>"/></td>
                          <td><input type="text" id="infant_cost<?= $count ?>-u" name="infant_cost" placeholder="*Infant Cost" title="Infant Cost" onchange="validate_balance(this.id)" style="width: 110px;" value="<?= $row_tariffentries['infant_cost'] ?>"/></td>
                          <td><select name="markup_in" id="markup_in<?= $count ?>-u" style="width: 125px" class="form-control app_select2" title="Markup In">
                            <option value="<?= $row_tariffentries['markup_in'] ?>"><?= $row_tariffentries['markup_in'] ?></option>
                            <option value=''>Markup In</option>
                            <option value='Flat'>Flat</option>
                            <option value='Percentage'>Percentage</option></select></td>
                          <td><input type='number' id="amount<?= $count ?>-u" name="amount" placeholder="*Markup Amount" value='<?= $row_tariffentries['markup_cost'] ?>' class="form-control" title="Markup Amount" style="width: 147px;"/></td>
                          <td><select name="ucurrency_code" id="ucurrency_code<?= $count ?>-u" title="Currency" style="width:130px" class="form-control app_select2">
                                <option value="<?= $sq_currency1['id'] ?>"><?= $sq_currency1['currency_code'] ?></option>
                                <option value=''>*Select Currency</option>
                                <?php
                                $sq_currency = mysqlQuery("select * from currency_name_master order by currency_code");
                                while($row_currency = mysqli_fetch_assoc($sq_currency)){
                                ?>
                                <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                                <?php } ?>
                            </select></td>
                          <td><input type="hidden" id="entry_id<?= $count ?>-u" name="entry_id" value="<?= $row_tariffentries['tariff_id'] ?>" /></td>
                      </tr>
                      <script>
                      $('#pickup_from<?= $count ?>-u,#drop_to<?= $count ?>-u').select2({minimumInputLength:1});
                      $('#to_date<?= $count ?>-u,#from_date<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
                      $('#dept_date<?= $count ?>-u,#arrival_date<?= $count ?>-u').datetimepicker({ timepicker:true, format:'d-m-Y H:i' });
                      $('#category<?= $count ?>-u,#ucurrency_code<?= $count ?>-u').select2();
                      </script>
                    <?php } ?>
                    </table>
                </div>
            </div>
            </div>

          <?php } ?>

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
$('#ferry_id1,#ucurrency_code').select2();
$(function(){
  $('#frm_tariff_update').validate({
    rules:{

    },
    submitHandler:function(form){

      $('#tariff_update').prop('disabled',true);
      var base_url = $('#base_url').val();
      var fentry_id = $('#entry_id').val();

      var checked_array = [];
      var no_seats_array = [];
      var from_date_array = [];
      var to_date_array = [];
      var pickup_from_array = [];
      var drop_to_array = [];
      var dep_date_array = [];
      var arr_date_array = [];
      var ferry_type_array = [];
      var adult_array = [];
      var child_array = [];
      var infant_array = [];
      var entry_id_array = [];
      var markup_in_array = [];
      var markup_cost_array = [];
      var currency_arr = [];

      var table = document.getElementById("table_ferry_tarrif_update");
      var rowCount = table.rows.length;
      
      for(var i=0; i<rowCount; i++){

          var row = table.rows[i];        
        
          var seats = row.cells[2].childNodes[0].value;
          var from_date = row.cells[3].childNodes[0].value;
          var to_date = row.cells[4].childNodes[0].value;
          var pickup_from = row.cells[5].childNodes[0].value;
          var drop_to = row.cells[6].childNodes[0].value;
          var dep_date = row.cells[7].childNodes[0].value;
          var arr_date = row.cells[8].childNodes[0].value;
          var ferry_type = row.cells[9].childNodes[0].value;
          var adult = row.cells[10].childNodes[0].value;
          var child = row.cells[11].childNodes[0].value;
          var infant = row.cells[12].childNodes[0].value;
          var markup_in = row.cells[13].childNodes[0].value;
          var markup_cost = row.cells[14].childNodes[0].value;
          var currency = row.cells[15].childNodes[0].value;
          if(row.cells[16]){
            var entry_id = row.cells[16].childNodes[0].value;
          }else{
            var entry_id = '';
          }

          if(row.cells[0].childNodes[0].checked){
            count++;
            if(seats==''){
              error_msg_alert('Enter no of seats in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(from_date==''){
              error_msg_alert('Select valid from date in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(to_date==''){
              error_msg_alert('Select valid to date in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(pickup_from==''){
              error_msg_alert('Select from location in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(drop_to==''){
              error_msg_alert('Select to location in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(dep_date==''){
              error_msg_alert('Select departure datetime in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(arr_date==''){
              error_msg_alert('Select arrival datetime in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(ferry_type==''){
              error_msg_alert('Select ferry class in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(adult==''){
              error_msg_alert('Enter adult cost in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(child==''){
              error_msg_alert('Enter child cost in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(infant==''){
              error_msg_alert('Enter infant cost in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(markup_in==''){
              error_msg_alert('Select markup-in in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(markup_cost==''){
              error_msg_alert('Enter markup cost in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
            if(currency==''){
              error_msg_alert('Select currency in Row-'+(i+1));
              $('#tariff_update').prop('disabled',false);
              return false;
            }
          }
          checked_array.push(row.cells[0].childNodes[0].checked);
          no_seats_array.push(seats); 
          from_date_array.push(from_date); 
          to_date_array.push(to_date); 
          pickup_from_array.push(pickup_from); 
          drop_to_array.push(drop_to); 
          dep_date_array.push(dep_date); 
          arr_date_array.push(arr_date); 
          ferry_type_array.push(ferry_type); 
          adult_array.push(adult); 
          child_array.push(child); 
          infant_array.push(infant);
          entry_id_array.push(entry_id);
          markup_in_array.push(markup_in); 
          markup_cost_array.push(markup_cost);
          currency_arr.push(currency);
      }
      if(parseInt(count) == 0){
        error_msg_alert('Select atleast one tariff row!');
        $('#tariff_update').prop('disabled',false);
        return false;
      }
      $('#tariff_update').button('loading');
      
      $.ajax({
        type:'post',
        url: base_url+'controller/ferry/tariff_update.php',
        data: {fentry_id:fentry_id,no_seats_array:no_seats_array,from_date_array:from_date_array,to_date_array:to_date_array,pickup_from_array:pickup_from_array,drop_to_array:drop_to_array,dep_date_array:dep_date_array,arr_date_array:arr_date_array,ferry_type_array:ferry_type_array,adult_array:adult_array,child_array:child_array,infant_array:infant_array,entry_id_array:entry_id_array,checked_array:checked_array,markup_in_array:markup_in_array,markup_cost_array:markup_cost_array,currency_arr:currency_arr},
        success:function(result){
            var msg = result.split('--');
            if(msg[0]=='error'){
              $('#tariff_update').prop('disabled',false);
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