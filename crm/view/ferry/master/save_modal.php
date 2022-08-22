<form id="frm_master_save">
<div class="modal fade" id="master_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" style="width: 1150px !important;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ferry/Cruise</h4>
      </div>
      <div class="modal-body">
        
          <div class="row">
            <div class="col-sm-4">
              <select id="ferry_type" name="ferry_type" style="width:100%" title="Ferry/Cruise Type" data-toggle="tooltip" class="form-control" required>
                <option value="">*Select Ferry/Cruise Type</option>
                <option value="Private Cruise">Private Cruise</option>
                <option value="Govt Ferry">Govt Ferry</option>
              </select>
            </div>
            <div class="col-sm-4">
              <input type="text" id="ferry_name" name="ferry_name" onkeypress="return blockSpecialChar(event);" placeholder="*Ferry/Cruise Name" title="Ferry/Cruise Name" required>
            </div>
            <div class="col-sm-4">
              <input type="number" id="seating_capacity" name="seating_capacity" placeholder="*Seating Capacity" title="Seating Capacity" required>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-sm-12">
              <div class="div-upload" role="button" title="Upload Ferry/Cruise Image" data-toggle="tooltip">
                <div id="image_upload_btn" class="upload-button1"><span>Ferry/Cruise Image</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="image_upload_url" name="image_upload_url" required>
              </div>&nbsp;(Upload Maximum 3 images)
            </div>
            <div class="col-sm-12">
              <div style="color: red;">Note : Upload Image size below 100KB, resolution : 450X225.</div>
            </div>
          </div>
          <div class="row mg_tp_20 hidden">
            <div class="col-sm-12">
              <h3 class="editor_title">Age criterias for Child and Infant Costing</h3>
              <div class="row mg_tp_10">
                <div class="col-sm-6">
                  <input type="number" id="childfrom" name="childfrom" placeholder="*Child From Age" title="Child From Age" required>
                </div>
                <div class="col-sm-6">
                  <input type="number" id="childto" name="childto" placeholder="*Child To Age" title="Child To Age" required>
                </div>
              </div>
              <div class="row mg_tp_10">
                <div class="col-sm-6">
                  <input type="number" id="infantfrom" name="infantfrom" placeholder="*Infant From Age" title="Infant From Age" required>
                </div>
                <div class="col-sm-6">
                  <input type="number" id="infantto" name="infantto" placeholder="*Infant To Age" title="Infant To Age" required>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="ferry_image_urls" id="ferry_image_urls">
          <div class="row mg_tp_20">
            <div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
              <h3 class="editor_title">Inclusions</h3>
              <textarea class="feature_editor" id="inclusions" name="inclusions" placeholder="Inclusions" title="Inclusions" rows="3"></textarea>
            </div>
            <div class="col-md-4 col-sm-4"> 
              <h3 class="editor_title">Exclusions</h3>
              <textarea class="feature_editor" id="exclusions" name="exclusions" class="form-control"  placeholder="Exclusions" title="Exclusions" rows="3"></textarea>
            </div>
            <div class="col-md-4 col-sm-4 mg_bt_10_sm_xs">
              <h3 class="editor_title">Terms & Conditions</h3>
              <textarea class="feature_editor" id="terms" name="terms" placeholder="Terms & Conditions" title="Terms & Conditions" rows="3"></textarea>
            </div>
          </div>
          <div class="row text-center mg_tp_30">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="tsave"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
            </div>
          </div>        
      </div>      
    </div>
  </div>
</div>
</form>
<script>
$('#ferry_type').select2();
upload_ferry_image();
function upload_ferry_image(){
    
    var img_array = [];
    var btnUpload=$('#image_upload_btn');
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
      onComplete: function(file, response1){
        
        if(response1==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Ferry/Cruise Image');
        }
        else if(response1==="error1"){       
          error_msg_alert("Max Filesize limit exceeds!");           
          $(btnUpload).find('span').text('Ferry/Cruise Image');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#image_upload_url").val(response1);
          img_array.push(response1);
          if(img_array.length==1) { image_text = 'image'; }else{ image_text = 'images'; }
          msg_alert(img_array.length+" "+image_text+" uploaded!");
        }
      
        if(img_array.length>3){
          error_msg_alert("Sorry, you can upload up to 3 images"); return false;
        }
        $("#ferry_image_urls").val(img_array); 
      }
    });
}
</script>
