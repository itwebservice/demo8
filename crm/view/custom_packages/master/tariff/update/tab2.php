<?php
$sq_tab5 = mysqlQuery("select * from custom_package_offers where package_id = '$package_id'");
$sq_count5 = mysqli_num_rows(mysqlQuery("select * from custom_package_offers where package_id = '$package_id'"));
?>
<form id="frm_tab2">
  <div class="app_panel">
    <div class="container">
    <h5 class="booking-section-heading main_block text-center">Offers/Coupon</h5>
    <?php if($sq_count5 == 0){ ?>
    <div class="row mg_bt_10">
          <div class="col-md-12 text-right text_center_xs">
            <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_package_tarrif_offer','2')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('table_package_tarrif_offer','2')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">

            <table id="table_package_tarrif_offer" name="table_package_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="width:100%">
                <tr>
                  <td><input class="css-checkbox" id="chk_offer" type="checkbox"><label class="css-label" for="chk_offer"> </label></td>
                  <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td><select name="offer_type" id="offer_type" data-toggle="tooltip" title="Offer Type" style="width: 150px" class="form-control app_select2">
                      <option value=''>*Offer Type</option>
                      <option value='Offer'>Offer</option>
                      <option value='Coupon'>Coupon</option></td>
                  <td><input type="text" id="from_date_h" class="form-control" name="from_date_h" placeholder="Valid From" title="Valid From" onchange="get_to_date(this.id,'to_date_h')" value="<?= date('d-m-Y') ?>" style="width: 130px;" /></td>
                  <td><input type="text" id="to_date_h" class="form-control" name="to_date_h" placeholder="Valid To " title="Valid To" onchange="validate_validDate('from_date_h' ,'to_date_h')" value="<?= date('d-m-Y') ?>" style="width: 130px;" /></td>
                  <td><select name="amount_in" id="amount_in" data-toggle="tooltip" title="Amount In"style="width: 150px" class="form-control app_select2">
                      <option value=''>*Amount In</option>
                      <option value='Flat'>Flat</option>
                      <option value='Percentage'>Percentage</option></select></td>
                  <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 150px;"/></td>
                  <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;"/></td>
                  <td><select name="agent_type" id="agent_type" title="Agent Type" style="width: 150px" class="form-control app_select2" multiple>
                      <option value=''>Agent Type</option>
                      <option value='Platinum'>Platinum</option>
                      <option value='Gold'>Gold</option>
                      <option value='Silver'>Silver</option></select></td>
                  <td><input type="hidden" id="entry_id" name="entry_id" value="" /></td>   
                </tr>
                    <script>
                    $('#agent_type').select2();
                    $('#to_date_h1,#from_date_h1').datetimepicker({ timepicker:false, format:'d-m-Y' });
                    </script>
            </table>
          </div>
        </div>
      </div>
		<?php }
		else{ ?>
      <div class="row mg_bt_10">
        <div class="col-md-12 text-right text_center_xs">
          <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_package_tarrif_offer','2')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
        </div>
      </div>
      <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
        <table id="table_package_tarrif_offer" name="table_package_tarrif_offer" class="table table-bordered no-marg pd_bt_51" style="min-width:1500px">
        <?php
          $count = 1;
          while($row_tab5 = mysqli_fetch_assoc($sq_tab5)){ ?>
              <tr>
                  <td><input class="css-checkbox" id="chk_offer<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_offer"> </label></td>
                  <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                  <td><select name="offer_type" id="offer_type" data-toggle="tooltip" title="Offer Type" style="width: 150px" class="form-control app_select2">
                      <option value='<?= $row_tab5['type']?>'><?= $row_tab5['type']?></option>
                      <option value=''>*Offer Type</option>
                      <option value='Offer'>Offer</option>
                      <option value='Coupon'>Coupon</option></td>
                  <td><input type="text" id="from_date_h<?= $count ?>-u" class="form-control" name="from_date_h<?= $count ?>-u" placeholder="Valid From" title="Valid From" onchange="get_to_date(this.id,'to_date_h<?= $count ?>-u')" value='<?= get_date_user($row_tab5['from_date']) ?>' style="width: 130px;" /></td>
                  <td><input type="text" id="to_date_h<?= $count ?>-u" class="form-control" name="to_date_h" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date_h<?= $count ?>-u' ,'to_date_h<?= $count ?>-u')"  value='<?= get_date_user($row_tab5['to_date']) ?>' style="width: 130px;" /></td>
                  <td><select name="amount_in" id="amount_in" style="width: 150px" class="form-control app_select2" data-toggle="tooltip" title="Amount In">
                      <option value='<?= $row_tab5['offer_in']?>'><?= $row_tab5['offer_in']?></option>
                      <option value=''>*Amount In</option>
                      <option value='Flat'>Flat</option>
                      <option value='Percentage'>Percentage</option></select></td>
                  <td><input type='text' id="coupon_code" name="coupon_code" placeholder="Coupon Code" title="Coupon Code" style="width: 150px;" value="<?= $row_tab5['coupon_code']?>"/></td>
                  <td><input type='number' id="amount" name="amount" placeholder="*Amount" class="form-control" title="Amount" style="width: 100px;" value="<?= $row_tab5['offer_amount']?>"/></td>
                  <td><select name="agent_type<?= $count ?>-u" id="agent_type<?= $count ?>-u" style="width: 150px" class="form-control app_select2" title="Agent Type" multiple>
                      <?php 
                          $agent_type = explode(',', $row_tab5['agent_type']);
                      ?>
                      <?php $sel = (in_array("Platinum", $agent_type)) ? "selected" : "" ?>
                      <option value='Platinum' <?= $sel ?>>Platinum</option>
                      <?php $sel = (in_array("Gold", $agent_type)) ? "selected" : "" ?>
                      <option value='Gold' <?= $sel ?>>Gold</option>
                      <?php $sel = (in_array("Silver", $agent_type)) ? "selected" : "" ?>
                      <option value='Silver' <?= $sel ?>>Silver</option></select></td>
                  <td><input type="hidden" id="entry_id" name="entry_id" value='<?= $row_tab5['entry_id']?>' /></td>
              </tr>
              <script>
                  $('#agent_type<?= $count ?>-u').select2();
                  $('#to_date_h<?= $count ?>-u,#from_date_h<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
              </script>
          <?php $count++; } ?>
          </table>
          </div>
      </div>
      </div>
    <?php } ?>
      <div class="row text-center mg_tp_20 mg_bt_150">
        <div class="col-xs-12">
          <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
          &nbsp;&nbsp;
          <button class="btn btn-sm btn-success" id="btn_price_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
        </div>
  </div>
</form>
<?= end_panel() ?>

<script>
$('#to_date_h,#from_date_h').datetimepicker({ timepicker:false, format:'d-m-Y' });

function switch_to_tab2(){ 
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$('#frm_tab2').validate({
	rules:{

	},
	submitHandler:function(form){

		var base_url = $('#base_url').val();
    var dest_id = $('#dest_id').val();
    var package_id = $('#package_id').val();

    //TAB-1
    var checked_array = [];
    var hotel_type_array = [];
    var min_pax_array = [];
    var max_pax_array = [];
    var to_date_array = [];
    var from_date_array = [];
    var badult_array = [];
    var bcwb_array = [];
    var bcwob_array = [];
    var binfant_array = [];
    var bextra_array = [];
    var cadult_array = [];
    var ccwb_array = [];
    var cbcwob_array = [];
    var cinfant_array = [];
    var cextra_array = [];
    var entry_id_array = [];

    var table = document.getElementById("tbl_package_tariff");
    var rowCount = table.rows.length;
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
        var binfant = row.cells[10].childNodes[0].value;
        var bextrabed = row.cells[11].childNodes[0].value;
        var cadult = row.cells[12].childNodes[0].value;
        var ccwb = row.cells[13].childNodes[0].value;
        var ccwob = row.cells[14].childNodes[0].value;
        var cinfant = row.cells[15].childNodes[0].value;
        var cextrabed = row.cells[16].childNodes[0].value;
        var entry_id = row.cells[17].childNodes[0].value;

        checked_array.push(row.cells[0].childNodes[0].checked);
        hotel_type_array.push(hotel_type);
        min_pax_array.push(min_pax);
        max_pax_array.push(max_pax);
        from_date_array.push(from_date);
        to_date_array.push(to_date);
        badult_array.push(badult);
        bcwb_array.push(bcwb);
        bcwob_array.push(bcwob);
        binfant_array.push(binfant);
        bextra_array.push(bextrabed);
        cadult_array.push(cadult);
        ccwb_array.push(ccwb);
        cbcwob_array.push(ccwob);
        cinfant_array.push(cinfant);
        cextra_array.push(cextrabed);
        entry_id_array.push(entry_id);
    }
    //TAB-5
    var offer_checked_id_array = [];
    var type_array = [];
    var offer_from_date_array = [];
    var offer_to_date_array = [];
    var offer_array = [];
    var agent_array = [];
    var coupon_code_array = [];
    var offer_amount_array = [];
    var offer_id_array = [];

    var table = document.getElementById("table_package_tarrif_offer");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
      
      var row = table.rows[i];
      var type = row.cells[2].childNodes[0].value;
      var from_date = row.cells[3].childNodes[0].value;
      var to_date = row.cells[4].childNodes[0].value;
      var offer_in = row.cells[5].childNodes[0].value;
      var coupon_code = row.cells[6].childNodes[0].value;
      var offer_amount = row.cells[7].childNodes[0].value;
      var entry_id = row.cells[9].childNodes[0].value;
      
      if(row.cells[0].childNodes[0].checked == true){
        if(type==''){
          error_msg_alert('Select Type in Row-'+(i+1));
          return false;
        }
        if(from_date==''){
          error_msg_alert('Select Valid From Date in Row-'+(i+1));
          return false;
        }
        if(to_date==''){
          error_msg_alert('Select Valid To Date in Row-'+(i+1));
          return false;
        }
        if(type == 'Coupon'){
          if(offer_in==''){
            error_msg_alert('Select Coupon Amount-in in Row-'+(i+1));
            return false;
          }
          if(coupon_code==''){
            error_msg_alert('Enter Coupon code in Row-'+(i+1));
            return false;
          }
          if(offer_amount==''){
            error_msg_alert('Enter Coupon amount in Row- '+(i+1));
            return false;
          }
        }
        if(type == 'Offer'){
          if(offer_in==''){
            error_msg_alert('Select Offer Amount-in in Row-'+(i+1));
            return false;
          }
          if(offer_amount==''){
            error_msg_alert('Enter Offer amount in Row- '+(i+1));
            return false;
          }
        }
      }
      var agent_type = "";
      $(row.cells[8]).find('option:selected').each(function(){ agent_type += $(this).attr('value')+','; });
      agent_type = agent_type.trimChars(",");
        
      offer_checked_id_array.push(row.cells[0].childNodes[0].checked);
      type_array.push(type);
      offer_from_date_array.push(from_date);
      offer_to_date_array.push(to_date);
      offer_array.push(offer_in);
      coupon_code_array.push(coupon_code);
      offer_amount_array.push(offer_amount);
      agent_array.push(agent_type);
      offer_id_array.push(entry_id);
    }

    $('#btn_price_update').button('loading');
    $.ajax({
      type:'post',
      url: base_url+'controller/custom_packages/tarrif_update.php',
      data:{ package_id : package_id,checked_array:checked_array,hotel_type_array:hotel_type_array,min_pax_array:min_pax_array,max_pax_array:max_pax_array,from_date_array:from_date_array,to_date_array:to_date_array,badult_array:badult_array,bcwb_array:bcwb_array,bcwob_array:bcwob_array,binfant_array:binfant_array,cadult_array:cadult_array,ccwb_array:ccwb_array,cbcwob_array:cbcwob_array,cinfant_array:cinfant_array,entry_id_array:entry_id_array,type_array:type_array,offer_from_date_array:offer_from_date_array,offer_to_date_array:offer_to_date_array,offer_array:offer_array,coupon_code_array:coupon_code_array,offer_amount_array:offer_amount_array,agent_array:agent_array,offer_id_array:offer_id_array,offer_checked_id_array:offer_checked_id_array,bextra_array:bextra_array,cextra_array:cextra_array},
      success:function(result){
        $('#btn_price_update').button('reset');
        var msg = result.split('--');
        if(msg[0]=="error"){
          error_msg_alert(msg[1]);
        }
        else{
            $('#vi_confirm_box').vi_confirm_box({
              false_btn: false,
              message: result,
              true_btn_text:'Ok',
              callback: function(data1){
                if(data1=="yes"){
                  update_b2c_cache();
                  window.location.href = base_url+'view/custom_packages/master/index.php?activeid=3';
                }
              }
            });
        }
      }
    });
	}
});
</script>