<?php
include_once('../../../model/model.php');
$entry_id = $_POST['entry_id'];
$sq_traveler_info = mysqli_fetch_assoc(mysqlQuery("select * from visa_master_entries where entry_id='$entry_id'"));
?>
<div class="mg_tp_20"></div>
<h3 class="editor_title">id proof Information</h3>
<div class="panel panel-default panel-body">
    <form id="frm_save">

    <?php
    $count=0;
    $download_url = preg_replace('/(\/+)/','/',$sq_traveler_info['id_proof_url']);
    $download_url = BASE_URL.str_replace('../', '', $download_url);
    $download_urlpan_card = preg_replace('/(\/+)/','/',$sq_traveler_info['pan_card_url']);
    $download_urlpan_card = BASE_URL.str_replace('../', '', $download_urlpan_card);

    $count++;
    ?>
    <div class="row mg_tp_20">
      <input type="hidden" name="traveler_id" id="traveler_id" value="<?php echo $entry_id; ?>">
      <div class="col-md-2">
        <input type="text" name="passport_no" id="passport_no" title="Passport No" class="form-control"  onchange="validate_passport(this.id);" value="<?= $sq_traveler_info['passport_id'] ?>" placeholder="*Passport No" title="Passport No" style="text-transform: uppercase;">
      </div>
      <div class="col-md-2">
        <input type="text" name="issue_date" id="issue_date" title="Issue Date" class="form-control" value="<?= ($sq_traveler_info['passport_issue_date']) == "1970-01-01" ? date('d-m-Y'): get_date_user($sq_traveler_info['issue_date']) ?>"  placeholder="*Issue Date"  title="Issue Date" onchange="get_to_date(this.id,'expiry_date');">
      </div>
      <div class="col-md-2">
        <input type="text" name="expiry_date" id="expiry_date" title="Expiry Date" class="form-control" value="<?= ($sq_traveler_info['passport_expiry_date']) == "1970-01-01" ? date('d-m-Y'): get_date_user($sq_traveler_info['expiry_date']) ?>"  placeholder="*Expiry Date" title="Expiry Date" onchange="validate_validDate('issue_date','expiry_date');">
        </div>
        <div class="col-md-2 col-sm-6 text_left_xs">
            <div class="div-upload col-md-8" style="margin-bottom: 5px;" id="div_upload_button">
                <div id="id_proof_upload" class="upload-button1"><span>ID Proof</span></div>
                <span id="id_proof_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="txt_id_proof_upload_dir" name="txt_id_proof_upload_dir">
            </div>
            <div class="col-md-2 col-sm-6 text_left_xs">          
            <?php if($sq_traveler_info['id_proof_url']!=""): ?>
            <a href="<?= $download_url ?>" class="btn btn-info btn-sm ico_left" title="Download ID Proof"  style="padding: 15px 24px;" download><i class="fa fa-download"></i></a>
            <?php endif; ?>
            </div>
        </div>
          
        <div class="col-md-2 col-sm-6 text_left_xs">
          <div class="div-upload col-md-8" style="margin-bottom: 5px;" id="div_upload_button">
            <div id="pan_card_upload" class="upload-button1"><span>ID Proof-2</span></div>
              <span id="pan_card_status" ></span>
              <ul id="files" ></ul>
            <input type="hidden" id="txt_pan_card_upload_dir" name="txt_pan_card_upload_dir">
          </div>
          <div class="col-md-2 col-sm-6 text_left_xs">          
            <?php if($sq_traveler_info['pan_card_url']!=""): ?>
            <a href="<?= $download_urlpan_card ?>" class="btn btn-info btn-sm ico_left" title="Download ID Proof-2"  style="padding: 15px 24px;" download><i class="fa fa-download"></i></a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-md-offset-5"><span class="note">(Note size : upto 5MB. Only pdf, jpg, png files)</span></div> 
    </div>
    <div class="row mg_tp_20">
        <div class="col-md-12 text-center">
          <button id="btn_save2" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
  </form> 
</div>
<script type="text/javascript">
$('#issue_date,#expiry_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#frm_save').validate({
  rules:{
    passport_no : { required : true },
    issue_date : { required : true },
    expiry_date : { required : true },
  },
  submitHandler:function(){

            var passport_no = $('#passport_no').val();
            var issue_date = $('#issue_date').val();
            var expiry_date = $('#expiry_date').val();
            var entry_id = $('#traveler_id').val();
            var base_url = $('#base_url').val();

            $('#btn_save2').button('loading');
            $.ajax({
              type: 'post',
              url: base_url+'controller/passport_id_details/visa_passport_details.php',
              data:{ passport_no : passport_no, issue_date : issue_date, expiry_date : expiry_date, entry_id : entry_id },
              success: function(result){                
                msg_alert(result);
                $('#btn_save2').button('reset');
                traveler_id_proof_info_reflect();
              }
          });

        }
}); 
id_proof_upload();
function id_proof_upload()
{
    var type="id_proof";
    var btnUpload=$('#id_proof_upload');
    $(btnUpload).find('span').text('ID Proof');
    var status=$('#id_proof_status');
    new AjaxUpload(btnUpload, {
      action: 'visa/upload_id_proof_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
           // extension is not allowed 
            error_msg_alert('Only JPG, PNG or PDF files are allowed');
            return false;
        }
      $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        var response1 = response.split('--');
        //Add uploaded file to list
        if(response1[0]=="error"){     
          error_msg_alert("File size exceeds");    
          $(btnUpload).find('span').text('ID Proof');
          return false;         
        }else if(response1[0]=="success"){ 
          document.getElementById("txt_id_proof_upload_dir").value = response1[1];
          $(btnUpload).find('span').text('Uploaded');
          upload_tour_id_proof();
        }else{
          error_msg_alert("File not uploaded");    
          $(btnUpload).find('span').text('ID Proof');
          return false;
        }
      }
    });
}

function upload_tour_id_proof()
{
    var entry_id = $('#traveler_id').val();
    var id_proof_url = $('#txt_id_proof_upload_dir').val();
    var base_url = $('#base_url').val();

    $.ajax({
        type:'post',
        url: base_url+'controller/id_proof/visa_ticket_id_proof_upload.php',
        data:{ entry_id : entry_id, id_proof_url : id_proof_url },
        success:function(result){
            msg_alert(result);
        }
    });
}

pan_card_upload();
function pan_card_upload()
{
    var type="pan_card";
    var btnUpload=$('#pan_card_upload');
    $(btnUpload).find('span').text('ID Proof-2');
    var status=$('#pan_card_status');
    new AjaxUpload(btnUpload, {
      action: 'visa/upload_pan_card_file.php',
      name: 'uploadfile1',
      onSubmit: function(file, ext){

        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
           // extension is not allowed 
            error_msg_alert('Only JPG, PNG or PDF files are allowed');
            return false;
        }
      $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        
        var response1 = response.split('--');
        //Add uploaded file to list
        if(response1[0]=="error"){     
          error_msg_alert("File size exceeds");    
          $(btnUpload).find('span').text('ID Proof-2');
          return false;         
        }else if(response1[0]=="success"){ 
          document.getElementById("txt_pan_card_upload_dir").value = response1[1];
          $(btnUpload).find('span').text('Uploaded');
          upload_tour_pan_card();
        }else{
          error_msg_alert("File not uploaded");    
          $(btnUpload).find('span').text('ID Proof-2');
          return false;
        }
      }
    });
}

function upload_tour_pan_card()
{
    var entry_id = $('#traveler_id').val();
    var id_proof_url = $('#txt_pan_card_upload_dir').val();
    var base_url = $('#base_url').val();

    $.ajax({
        type:'post',
        url: base_url+'controller/id_proof/visa_ticket_pan_card_upload.php',
        data:{ entry_id : entry_id, id_proof_url : id_proof_url },
        success:function(result){
            msg_alert(result);
        }
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>