<form id="frm_fourth_coming_attraction_save" class="no-marg">

	<div class="modal fade" id="fouth_coming_attractions_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">New Sightseeing Attraction</h4>
	      </div>
	      <div class="modal-body text-center">
          <div class="row">
            <div class="col-md-6 mg_bt_10">
              <input class="form-control" type="text" id="txt_title" onchange="validate_spaces(this.id);fname_validate(this.id);" name="txt_title" title="Title" placeholder="*Title">	
            </div>
            <div class="col-md-6 mg_bt_10">
              <input type="text" class="form-control" id="txt_valid_date" name="txt_valid_date" placeholder="Valid Till" title="*Valid Till" value="<?= date('d-m-Y')?>"/>    
            </div>
            <div class="col-md-12 mg_bt_10">
              <textarea class="form-control" id="txt_description"  onchange="validate_spaces(this.id);validate_limit(this.id);" name="txt_description" placeholder="*Description" title="Description"></textarea>  
            </div>
        </div>
        <div class="row mg_bt_10">  
          <div class="col-md-3 no-pad"> 
            <div class="div-upload">
              <div id="upload_btn" class="upload-button1"><span>Upload Images</span></div>
              <span id="id_proof_status" ></span>
              <ul id="files" ></ul>
              <input type="hidden" id="upload_url" name="upload_url">
          </div>
          </div>
          <div class="col-md-8 no-pad"> 
            <div style="color: red;">Note : Upload Image size below 300KB, resolution : 900X450. (Upload Maximum 3 images)</div>
          </div>
        </div>
        <input type="hidden" name="sight_image_path" id="sight_image_path">
        <div class="row text-center"> 
          <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="save_button"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>	
        </div>
      </div>
    </div>
  </div>
</div>
</form>      
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#txt_valid_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

upload_attr_attch();
function upload_attr_attch()
{
    var btnUpload=$('#upload_btn');
    var img_array = new Array(); 

    $(btnUpload).find('span').text('Upload Images');
    $("#upload_url").val('');
    
    new AjaxUpload(btnUpload, {
      action: 'upload_images.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  

        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
          error_msg_alert('Only JPG, PNG files are allowed');
          return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response)
      {
        var msg = response.split('--');
        if(msg[0]==="error"){          
          error_msg_alert(msg[1]);           
          $(btnUpload).find('span').text('Upload Images');
          $("#upload_url").val('');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $("#upload_url").val(response);
          img_array.push(response);
          if(img_array.length==1) { image_text = 'image'; }else{ image_text = 'images'; }
          msg_alert(img_array.length+" "+image_text+" uploaded!");
        }
        if(img_array.length>3){
          error_msg_alert("Sorry, you can upload up to 3 images");
          return false;
        }
        $("#sight_image_path").val(img_array); 
      }
    });
}

function upload_pic(){

  var base_url = $("#base_url").val();
  var sight_image_path_array = $('#sight_image_path').val();
  $.ajax({
    type:'post',
    url: base_url+'controller/attractions_offers_enquiry/attraction_img_save.php',
    data:{ sight_image_path_array : sight_image_path_array },
    success:function(result){
      msg_alert(result);
    }
  });
}
</script>