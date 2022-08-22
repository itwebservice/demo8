<?php 
include_once('../../../model/model.php');
$entry_id = $_POST['entry_id'];
$sq_ferry = mysqli_fetch_assoc(mysqlQuery("select * from ferry_master where entry_id='$entry_id'"));
$image_array = explode(',',$sq_ferry['image_url']);
?>
<form id="frm_update">
<input type="hidden" id="entry_id" name="entry_id" value="<?= $sq_ferry['entry_id'] ?>">

<div class="modal fade" id="update_modal" data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" style="width: 1150px !important;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Ferry/Cruise</h4>
      </div>
      <div class="modal-body">
        
      <div class="row">
            <div class="col-sm-4">
              <select id="ferry_type1" name="ferry_type1" style="width:100%" title="Ferry/Cruise Type" data-toggle="tooltip" class="form-control" required>
                <option value="<?= $sq_ferry['ferry_type'] ?>"><?= $sq_ferry['ferry_type'] ?></option>
                <option value="">*Select Ferry/Cruise Type</option>
                <option value="Private Cruise">Private Cruise</option>
                <option value="Govt Ferry">Govt Ferry</option>
              </select>
            </div>
            <div class="col-sm-4">
              <input type="text" id="ferry_name1" name="ferry_name1" onkeypress="return blockSpecialChar(event);" placeholder="*Ferry/Cruise Name" title="Ferry/Cruise Name" value="<?= $sq_ferry['ferry_name'] ?>" required>
            </div>
            <div class="col-sm-4">
              <input type="number" id="seating_capacity1" name="seating_capacity1" placeholder="*Seating Capacity" title="Seating Capacity" value="<?= $sq_ferry['seating_capacity'] ?>" required>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-sm-4">
              <select name="active_flag" id="active_flag" title="Status">
                <option value="<?= $sq_ferry['active_flag'] ?>"><?= $sq_ferry['active_flag'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-sm-12">
              <div class="div-upload" role="button" title="Upload Ferry/Cruise Image" data-toggle="tooltip">
                <div id="image_upload_btn1" class="upload-button1"><span>Ferry/Cruise Image</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="image_upload_url1" name="image_upload_url1" required>
              </div>&nbsp;(Upload Maximum 3 images)
            </div>
            <div class="col-sm-12">
              <div style="color: red;">Note : Upload Image size below 100KB, resolution : 450X225.</div>
            </div>
          </div>
        <div class="row mg_tp_20 mg_bt_20" id="images_list"></div>
        <input type="hidden" id="image_array1" value='<?= $sq_ferry['image_url'] ?>'/>
        <input type="hidden" id="img_array1"/>
          <div class="row mg_tp_20 hidden">
            <div class="col-sm-12">
              <h3 class="editor_title">Age criterias for Child and Infant Costing</h3>
              <div class="row mg_tp_10">
                <div class="col-sm-6">
                  <input type="number" id="childfrom1" name="childfrom" placeholder="*Child From Age" title="Child From Age"  value="<?= $sq_ferry['child_from'] ?>" required>
                </div>
                <div class="col-sm-6">
                  <input type="number" id="childto1" name="childto" placeholder="*Child To Age" title="Child To Age" value="<?= $sq_ferry['child_to'] ?>" required>
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6">
                  <input type="number" id="infantfrom1" name="infantfrom" placeholder="*Infant From Age" title="Infant From Age" value="<?= $sq_ferry['infant_from'] ?>" required>
                </div>
                <div class="col-sm-6">
                  <input type="number" id="infantto1" name="infantto" placeholder="*Infant To Age" title="Infant To Age" value="<?= $sq_ferry['infant_to'] ?>" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
              <h3 class="editor_title">Inclusions</h3>
              <textarea class="feature_editor" id="inclusions1" name="inclusions" placeholder="Inclusions" title="Inclusions" rows="3"><?= $sq_ferry['inclusions'] ?></textarea>
            </div>
            <div class="col-md-4 col-sm-4"> 
              <h3 class="editor_title">Exclusions</h3>
              <textarea class="feature_editor" id="exclusions1" name="exclusions" class="form-control"  placeholder="Exclusions" title="Exclusions" rows="3"><?= $sq_ferry['exclusions'] ?></textarea>
            </div>
            <div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
              <h3 class="editor_title">Terms & Conditions</h3>
              <textarea class="feature_editor" id="terms1" name="terms" placeholder="Terms & Conditions" title="Terms & Conditions" rows="3"><?= $sq_ferry['terms'] ?></textarea>
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

<script>
$('#update_modal').modal('show');
$('#farry_type1').select2();

function load_images(entry_id){
    var base_url = $("#base_url").val();
    $.ajax({
          type:'post',
          url: 'master/get_ferry_img.php',
          data:{entry_id : entry_id },
          success:function(result){
            $('#images_list').html(result);
          }
  });
}
load_images(<?= $entry_id ?>);

function delete_image(image_id,entry_id){
    var base_url = $("#base_url").val();
    $("#vi_confirm_box").vi_confirm_box({
          callback: function(result){
            if(result=="yes"){
              $.ajax({
                    type:'post',
                    url: base_url+'controller/ferry/delete_image.php',
                    data:{ image_id : image_id, entry_id : entry_id },
                    success:function(result)
                    {
                      var msg = result.split('--');
                      msg_alert(msg[0]);
                      console.log(JSON.parse(msg[1]));
                      $('#image_array1').val(JSON.parse(msg[1]));
                      load_images(entry_id);
                    }
              });    
            } }
    });
}

upload_ferry_image1();
function upload_ferry_image1(){

  var img_array = [];
  var img_count = 0;
  var btnUpload=$('#image_upload_btn1');
  var upload_count = 0;
  $(btnUpload).find('span').text('Ferry/Cruise Image');
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
            img_array.push(response);
            if(img_array.length==1) { image_text = 'image'; }else{ image_text = 'images'; }
            success_msg_alert(img_array.length+" "+image_text+" uploaded!");
            upload_count++;

            var image_upload_url = $('#image_array1').val();
            image_upload_url = image_upload_url.split(',');
            for(var i = 0;i < image_upload_url.length;i++){
              if(image_upload_url[i]!=''){
                img_count++;
              }
            }
            var total = parseInt(img_count) + parseInt(upload_count);
            if(total > 4){
              error_msg_alert("Sorry, you can upload up to 3 images"); return false;
            }else{
              $("#img_array1").val(img_array);
            }
            
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
      var image_upload_url = $('#image_array1').val();
      var image_upload_url1 = $('#img_array1').val();
      var ferry_type = $('#ferry_type1').val();
      var ferry_name = $('#ferry_name1').val();
      var seating_capacity = $('#seating_capacity1').val();
      var childfrom = $('#childfrom1').val();
      var childto = $('#childto1').val();
      var infantfrom = $('#infantfrom1').val();
      var infantto = $('#infantto1').val();
      var active_flag = $('#active_flag').val();
			var inclusions = $('#inclusions1').val();
			var exclusions = $('#exclusions1').val();
			var terms = $('#terms1').val();

      if(image_upload_url != '' || image_upload_url1 != ''){
        var url = image_upload_url+','+image_upload_url1;
      }else{
        var url = '';
      }
      
      $('#update').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/ferry/ferry_update.php',
        data: {entry_id:entry_id,
        ferry_type : ferry_type,
        ferry_name : ferry_name,
        seating_capacity : seating_capacity,
        image_upload_url: url,
        childfrom:childfrom,
        childto:childto,
        infantfrom:infantfrom,
        infantto:infantto,active_flag:active_flag,inclusions:inclusions,exclusions:exclusions,terms:terms},
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
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>