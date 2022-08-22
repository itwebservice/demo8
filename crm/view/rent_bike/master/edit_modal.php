<?php 
include_once('../../../model/model.php');
$entry_id = $_POST['entry_id'];
$sq_bike = mysqli_fetch_assoc(mysqlQuery("select * from bike_master where entry_id='$entry_id'"));
$sq_bike_type = mysqli_fetch_assoc(mysqlQuery("select * from bike_type_master where entry_id='$sq_bike[bike_type]'"));
$pickup_time = date('H:i', strtotime($sq_bike['pickup_time']));
$drop_time = date('H:i', strtotime($sq_bike['drop_time']));
?>
<form id="frm_update">
<input type="hidden" id="entry_id" name="entry_id" value="<?= $entry_id ?>">

<div class="modal fade" id="update_modal" data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Bike</h4>
      </div>
      <div class="modal-body">
        
      <div class="row">
          <div class="col-sm-3">
            <select id="bike_type1" name="bike_type" style="width:100%" title="Bike Type" data-toggle="tooltip" class="form-control" required>
              <option value="<?= $sq_bike_type['entry_id']; ?>"><?= $sq_bike_type['bike_type']; ?></option>
              <?php get_bike_types(); ?>
            </select>
          </div>
          <div class="col-sm-3">
            <input type="text" id="bike_name1" name="bike_name" onchange="locationname_validate(this.id);" placeholder="*Bike Name" title="Bike Name" value="<?= $sq_bike['bike_name']; ?>" onkeypress="return blockSpecialChar(event);" required>
          </div>
          <div class="col-sm-3">
            <input type="text" id="manufacturer1" name="manufacturer" onchange="locationname_validate(this.id);" placeholder="*Manufacturer Name" title="Manufacturer Name" value="<?= $sq_bike['manufacturer']; ?>" onkeypress="return blockSpecialChar(event);" required>
          </div>
          <div class="col-sm-3">
            <input type="text" id="model_name1" name="model_name" onchange="locationname_validate(this.id);" placeholder="*Model Name" title="Model Name" value="<?= $sq_bike['model_name']; ?>" onkeypress="return blockSpecialChar(event);" required>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3 mg_tp_10">
            <input type="number" id="seating_capacity1" name="seating_capacity" max_length="20" placeholder="*Seating Capacity" title="Seating Capacity" value="<?= $sq_bike['seating_capacity']; ?>" required>
          </div>
          <div class="col-sm-3 mg_tp_10">
            <input type="text" id="pickup_time1" name="pickup_time" placeholder="*Pickup Time" title="Pickup Time"  value="<?= $pickup_time; ?>"required>
          </div>
          <div class="col-sm-3 mg_tp_10">
            <input type="text" id="drop_time1" name="drop_time" placeholder="*Drop Time" title="Drop Time" value="<?= $drop_time; ?>" required>
          </div>
          <div class="col-sm-3 mg_tp_10">
            <select id="active_flag" name="active_flag" style="width:100%" title="Status" data-toggle="tooltip" class="form-control" required>
              <option value="<?= $sq_bike['active_flag']; ?>"><?= $sq_bike['active_flag']; ?></option>
              <option value="<?= 'Active' ?>"><?= 'Active' ?></option>
              <option value="<?= 'Inactive' ?>"><?= 'Inactive' ?></option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 mg_tp_10">
            <div class="div-upload" role="button" title="Upload Bike Image" data-toggle="tooltip">
              <div id="image_upload_btn1" class="upload-button1"><span><?= $upload ?></span></div>
              <span id="photo_status" ></span>
              <ul id="files" ></ul>
              <input type="hidden" id="image_upload_url1" name="image_upload_url" value="<?= $sq_bike['image_upload_url']; ?>" required>
            </div>
            <div style="color: red;">Note : Upload Image size below 100KB, resolution : 900X450.</div>
          </div>
        </div>
        <div class="row mg_tp_20">
          <div class="col-sm-6">
            <h3 class="editor_title">Inclusions</h3>
            <textarea class="feature_editor" name="incl" id="incl1" style="width:100% !important" rows="2"><?= $sq_bike['incl']; ?></textarea>
          </div>
          <div class="col-sm-6">
            <h3 class="editor_title">Exclusions</h3>
            <textarea class="feature_editor" name="excl" id="excl1" style="width:100% !important" rows="2"><?= $sq_bike['excl']; ?></textarea>
          </div>
        </div>
        <div class="row mg_tp_20">
          <div class="col-sm-6">
            <h3 class="editor_title">Terms & Conditions</h3>
            <textarea class="feature_editor" name="terms" id="terms1" style="width:100% !important" rows="2"><?= $sq_bike['terms']; ?></textarea>
          </div>
          <div class="col-sm-6">
            <h3 class="editor_title">Cancellation Policy</h3>
            <textarea class="feature_editor" name="canc_policy" id="canc_policy1" style="width:100% !important" rows="2"><?= $sq_bike['canc_policy']; ?></textarea>
          </div>
        </div>
        <div class="row text-center mg_tp_30">
          <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>            
          </div>
        </div>   
      </div>
    </div>
  </div>
</div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
  $('#update_modal').modal('show');
  $('#pickup_time1,#drop_time1').datetimepicker({ datepicker:false,timepicker:true, format:"H:i" });
  $('#vehicle_type1').select2();

  upload_vehicle_image1();
  function upload_vehicle_image1(){

      var btnUpload=$('#image_upload_btn1');
      var image_upload_url = $("#image_upload_url1").val();
      var upload = (image_upload_url != '') ? 'Uploaded' : 'Bike Image';

      $(btnUpload).find('span').text(upload);
      new AjaxUpload(btnUpload, {

        action: 'master/upload_image.php',
        name: 'uploadfile',
        onSubmit: function(file, ext){
          if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
          error_msg_alert('Only JPG, PNG files are allowed');
          return false;
          }
          $(btnUpload).find('span').text('Uploading...');
        },
        onComplete: function(file, response){
          if(response==="error"){          
            error_msg_alert("File is not uploaded.");           
            $(btnUpload).find('span').text('Upload Image');
          }
          else{ 
              if(response=="error1"){

                $(btnUpload).find('span').text('Upload Image');
                error_msg_alert('Maximum size exceeds');
                return false;
              }else{

                $(btnUpload).find('span').text('Uploaded');
                $("#image_upload_url1").val(response);
            }
          }
      }
    });
  }
  $(function(){
    $('#frm_update').validate({
      rules:{
      },
      submitHandler:function(form){

        var base_url = $('#base_url').val();
        var entry_id = $('#entry_id').val();
        var bike_type = $('#bike_type1').val();
        var bike_name = $('#bike_name1').val();
        var manufacturer = $('#manufacturer1').val();
        var model_name = $('#model_name1').val();
        var seating_capacity = $('#seating_capacity1').val();
        var pickup_time = $('#pickup_time1').val();
        var drop_time = $('#drop_time1').val();
        var image_upload_url = $('#image_upload_url1').val();
        var incl = $('#incl1').val();
        var excl = $('#excl1').val();
        var terms = $('#terms1').val();
        var canc_policy = $('#canc_policy1').val();
        var active_flag = $('#active_flag').val();

        $('#update').button('loading');
        $.ajax({
          type:'post',
				  url: base_url+'controller/rent_bike/vehicle_update.php',
          data: {entry_id:entry_id,
					bike_type: bike_type,
					bike_name: bike_name,
					manufacturer: manufacturer,
					model_name:model_name,
					seating_capacity:seating_capacity,
					pickup_time:pickup_time,
					drop_time:drop_time,
					image_upload_url:image_upload_url,
					incl:incl,
					excl:excl,
					terms:terms,
					canc_policy: canc_policy,active_flag:active_flag},
          success:function(result){
          var msg = result.split('--');
            $('#update').button('reset');				
            if(msg[0]=='error'){
              error_msg_alert(msg[1]);
              return false;
            }
            else{
              msg_alert(result);
				      update_b2c_cache();
              $('#update_modal').modal('hide');
              $('#update_modal').on('hidden.bs.modal', function () {
                master_list_reflect();
              });
            }
            
          }
        });
      }
    });
  });
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>