<div class="modal fade" id="email_template_save_modal"  role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Email Template</h4>
      </div>
      <div class="modal-body">

		<form id="frm_email_group_save">

      	<div class="row">
      		<div class="col-md-4">
      			<input type="text" id="email_template_type" onchange="validate_specialChar(this.id)" name="email_template_type" placeholder="*Template Type" title="Template Type">
      		</div>
            <div class="col-md-4">
                <div class="div-upload">
                    <div id="id_upload_btn" class="upload-button1"><span>Upload Template</span></div>
                    <span id="id_proof_status" ></span>
                    <ul id="files" ></ul>
                    <input type="hidden" id="id_upload_url" name="id_upload_url1">
                </div> 
      		</div>
      		<div class="col-md-4">
      			<button class="btn btn-sm btn-success" id="save_loading"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
      		</div>
      	</div>
        
        <div class="row mg_tp_30">
          <div class="col-md-12">
      			  <p style="color:red">Note : Image size should be less than 100KB, resolution : 900X450., Type PNG/JPEG</p>
      		</div>
      	</div>
      	</form>
        
      </div>      
    </div>
  </div>
</div>

<script>
    upload_invoice_pic_attch();
    function upload_invoice_pic_attch()
{	
    
    var btnUpload=$('#id_upload_btn');
    $(btnUpload).find('span').text('Upload Template');

    $('#id_upload_url').val('');
    
    new AjaxUpload(btnUpload, {
      action: 'templates/upload_invoice_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
          error_msg_alert('Only JPG, PNG files are allowed');
          return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload Again');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $('#id_upload_url').val(response);
        }
      }
    });
}
$(function(){
  $('#frm_email_group_save').validate({
    rules:{ 
        email_template_type : { required:true }
    },
    submitHandler:function(form){

      var email_template_type = $('#email_template_type').val();
	    var invoice_url = $('#id_upload_url').val();
      var base_url = $('#base_url').val();
      if(invoice_url==""){
        error_msg_alert("File is not uploaded."); 
        return false;
      }
      $('#save_loading').button('loading');
      
      $.ajax({
        type:'post',
        url:base_url+'controller/promotional_email/template/template_details_save.php',
        data: { email_template_type : email_template_type, invoice_url:invoice_url },
        success:function(result){
          msg_alert(result);
          reset_form('frm_email_group_save');
          $('#save_loading').button('reset');
          $('#email_template_save_modal').modal('hide');
          list_reflect();
        }
      });

    }
  });
});
</script>