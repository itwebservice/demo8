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
                  <select id="ferry_id" name="ferry_id" style="width:100%" title="Select Ferry/Cruise" data-toggle="tooltip" required>
                      <option value="">*Select Ferry/Cruise</option>
                      <?php
                      $sq_query = mysqlQuery("select entry_id,ferry_name,ferry_type from ferry_master where active_flag!='Inactive' order by ferry_name");
                      while($row_query = mysqli_fetch_assoc($sq_query)){
                      ?>
                      <option value="<?= $row_query['entry_id'] ?>"><?= $row_query['ferry_name'].'('.$row_query['ferry_type'].')' ?></option>
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
          <!-- <legend class="mg_tp_20 main_block text-center">Tariff</legend> -->
            <div class="col-md-12 text-right text_center_xs">
            <?php include_once 'get_tariff_rows.php'; ?>

          <div class="row text-center mg_tp_20"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="tariff_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
          </div> </div>
      </div>      
    </div>
  </div>
</div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#tariff_save_modal').modal('show');
$('#ferry_id,#currency_code1').select2();
//Airport Name dropdown
function seasonal_csv(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/ferry_tariff_import.csv";
}
transfer_tarrif_save();
function transfer_tarrif_save(){
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
          document.getElementById("ferry_tarrif_upload").value = response;
          status.text('Uploading...');
          ferry_tarrif1();
          status.text('');
          
        }
      }
    });
}

function ferry_tarrif1(){
  var cust_csv_dir = document.getElementById("ferry_tarrif_upload").value;
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/ferry/tariff_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){
            var pass_arr = JSON.parse(result);
            if(pass_arr.length !== 0){
                var table = document.getElementById("table_ferry_tarrif");
                if(table.rows.length == 1){
                    for(var k=1; k<table.rows.length; k++){
                            document.getElementById("table_ferry_tarrif").deleteRow(k);
                    }
                }else{
                    while(table.rows.length > 1){
                            document.getElementById("table_ferry_tarrif").deleteRow(k);
                            table.rows.length--;
                    }
                }
                for(var i=0; i<pass_arr.length; i++){
                    
                    var row = table.rows[i];
                    row.cells[2].childNodes[0].value = pass_arr[i]['no_of_seats'];
                    row.cells[3].childNodes[0].value = pass_arr[i]['from_date'];
                    row.cells[4].childNodes[0].value = pass_arr[i]['to_date'];
                    row.cells[5].childNodes[0].value = pass_arr[i]['from_location'];
                    row.cells[6].childNodes[0].value = pass_arr[i]['to_location'];
                    row.cells[7].childNodes[0].value = pass_arr[i]['dep_date'];
                    row.cells[8].childNodes[0].value = pass_arr[i]['arr_date'];		
                    row.cells[9].childNodes[0].value = pass_arr[i]['ferry_type'];		
                    row.cells[10].childNodes[0].value = pass_arr[i]['adult_cost'];
                    row.cells[11].childNodes[0].value = pass_arr[i]['child_cost'];
                    row.cells[12].childNodes[0].value = pass_arr[i]['infant_cost'];
                    row.cells[13].childNodes[0].value = pass_arr[i]['markup_in'];
                    row.cells[14].childNodes[0].value = pass_arr[i]['markup_cost'];

                    if(i!=pass_arr.length-1){
                        if(table.rows[i+1]==undefined){
                            addRow('table_ferry_tarrif');
                        }
                    }
                    $(row.cells[5].childNodes[0]).trigger('change');
                    $(row.cells[6].childNodes[0]).trigger('change');
                    $(row.cells[9].childNodes[0]).trigger('change');
                    $(row.cells[13].childNodes[0]).trigger('change');
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

    },
    submitHandler:function(form){

			$('#tariff_save').prop('disabled',true);
      var base_url = $('#base_url').val();
      var ferry_id = $('#ferry_id').val();
      var currency_id = $('#currency_code1').val();

      var count = 0;
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
      var markup_in_array = [];
      var markup_cost_array = [];

      var table = document.getElementById("table_ferry_tarrif");
      var rowCount = table.rows.length;
      
      for(var i=0; i<rowCount; i++){

        var row = table.rows[i];        
        if(row.cells[0].childNodes[0].checked){
        
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

          if(seats==''){
            error_msg_alert('Enter no of seats in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(from_date==''){
            error_msg_alert('Select valid from date in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(to_date==''){
            error_msg_alert('Select valid to date in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(pickup_from==''){
            error_msg_alert('Select from location in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(drop_to==''){
            error_msg_alert('Select to location in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(dep_date==''){
            error_msg_alert('Select departure datetime in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(arr_date==''){
            error_msg_alert('Select arrival datetime in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(ferry_type==''){
            error_msg_alert('Select ferry class in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(adult==''){
            error_msg_alert('Enter adult cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(child==''){
            error_msg_alert('Enter child cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(infant==''){
            error_msg_alert('Enter infant cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(markup_in==''){
            error_msg_alert('Select markup-in in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
          if(markup_cost==''){
            error_msg_alert('Enter markup cost in Row-'+(i+1));
            $('#tariff_save').prop('disabled',false);
            return false;
          }
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
          markup_in_array.push(markup_in); 
          markup_cost_array.push(markup_cost);
          count++;
        }
      }
      if(parseInt(count) == 0){
        error_msg_alert('Select atleast one tariff row!');
        $('#tariff_save').prop('disabled',false);
        return false;
      }
      $('#tariff_save').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/ferry/tariff_save.php',
        data: { ferry_id:ferry_id,currency_id:currency_id,
          no_seats_array:no_seats_array,from_date_array:from_date_array,to_date_array:to_date_array,pickup_from_array:pickup_from_array,drop_to_array:drop_to_array,dep_date_array:dep_date_array,arr_date_array:arr_date_array,ferry_type_array:ferry_type_array,adult_array:adult_array,child_array:child_array,infant_array:infant_array,markup_in_array:markup_in_array,markup_cost_array:markup_cost_array },
          success:function(result){
              var msg = result.split('--');
              if(msg[0]=='error'){
                  error_msg_alert(msg[1]);
                  $('#tariff_save').button('reset');
                  return false;
                }
              else{
                  msg_alert(result);
                  $('#tariff_save').prop('disabled',false);
				          update_b2c_cache();
                  $('#tariff_save').button('reset');
                  $('#tariff_save_modal').modal('hide');
                  reset_form('frm_tariff_save');
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