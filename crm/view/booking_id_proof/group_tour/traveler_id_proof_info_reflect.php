<?php 
include_once('../../../model/model.php');

$traveler_id = $_POST['traveler_id'];

$sq_traveler_info = mysqli_fetch_assoc(mysqlQuery("select * from travelers_details where traveler_id='$traveler_id'"));
$traveler_group_id = $sq_traveler_info['traveler_group_id'];
?>

<div class="mg_tp_20"></div>
<h3 class="editor_title">ID Proof Information</h3>
<div class="panel panel-default panel-body">
<form id="frm_save">
  <?php
  $count=0;
    $download_url = preg_replace('/(\/+)/','/',$sq_traveler_info['id_proof_url']);
    $download_url = BASE_URL.str_replace('../', '', $download_url);

  $pan_url= preg_replace('/(\/+)/','/',$sq_traveler_info['pan_card_url']);
    $pan_url = BASE_URL.str_replace('../', '', $pan_url); 

  $count++;

  $bg = ($sq_traveler_info['status']=="Cancel") ? "danger" : "";
  ?>
  <div class="row mg_tp_20">
      <input type="hidden" name="traveler_id" id="traveler_id" value="<?php echo $traveler_id; ?>">
      <div class="col-md-2 col-sm-4 mg_bt_10_xs">
        <input type="text" name="passport_no" onchange="validate_passport(this.id);" id="passport_no" class="form-control" value="<?= $sq_traveler_info['passport_no'] ?>" placeholder="*Passport No" title="Passport No" style="text-transform: uppercase;">
      </div>
      <div class="col-md-2 col-sm-4 mg_bt_10_xs">
        <input type="text" name="issue_date" id="issue_date" title="Issue Date" class="form-control" value="<?= ($sq_traveler_info['passport_issue_date']) == "1970-01-01" ? date('d-m-Y'): get_date_user($sq_traveler_info['passport_issue_date']) ?>" onchange="get_to_date(this.id,'expiry_date');" placeholder="*Issue Date">
      </div>
      <div class="col-md-2 col-sm-4 mg_bt_10_xs">
        <input type="text" name="expiry_date" id="expiry_date" title="Expiry Date" class="form-control" value="<?= ($sq_traveler_info['passport_expiry_date']) == "1970-01-01" ? date('d-m-Y'): get_date_user($sq_traveler_info['passport_expiry_date']) ?>"  placeholder="*Expire Date" onchange="validate_validDate('issue_date','expiry_date');">
      </div>
      <div class="col-md-2 col-sm-6 text_left_xs">
          <div  class="div-upload col-md-8" id="div_upload_button">
              <div id="id_proof_upload_g" class="upload-button1"><span>ID Proof</span></div>
              <span id="id_proof_status1" ></span>
              <ul id="files" ></ul>
              <input type="hidden" id="txt_id_proof_upload_dir1" name="txt_id_proof_upload_dir1">
          </div>
          <div class="text_left_xs col-md-2">          
            <?php if($sq_traveler_info['id_proof_url']!=""){ ?>
            <a href="<?= $download_url ?>" style="padding: 15px 24px;" title="Download ID Proof" class="btn btn-info ico_left" download><i class="fa fa-download"></i>
          </a>
            <?php } ?>
          </div>
      </div>   
      <div class="col-md-2 col-sm-6 text_left_xs">
        <div  class="div-upload col-md-8" style="margin-bottom: 5px;"  id="div_upload_button">
            <div id="pan_card_upload_g" class="upload-button1"><span>ID Proof-2</span></div>
            <span id="pan_card_status1" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="txt_pan_card_upload_dir1" name="txt_pan_card_upload_dir1">
        </div>
        <div class="col-md-2 col-sm-6 text_left_xs">          
          <?php if($sq_traveler_info['pan_card_url']!=""){ ?>
          <a href="<?= $pan_url ?>" style="padding: 15px 24px;" title="Download ID Proof-2" class="btn btn-info btn-sm ico_left" download><i class="fa fa-download"></i></a>
          <?php } ?>
        </div>
      </div> <div class="col-md-offset-5"><span class="note">(Note size : upto 5MB. Only pdf, jpg, png files)</span></div>
  </div>
  <div class="row mg_tp_20">
    <div class="col-md-12 text-center">
      <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
    </div>
  </div>

</form> 
</div>
<script type="text/javascript">
$('#issue_date,#expiry_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

function upload_tour_id_proof()
{
    var traveler_id = $('#traveler_id').val();
    var id_proof_url = $('#txt_id_proof_upload_dir1').val();

    if(traveler_id==""){
        error_msg_alert('Please select traveler to upload his id proof!');
        return false;
    }

    var base_url = $('#base_url').val();

    $.ajax({
        type:'post',
        url: base_url+'controller/id_proof/group_tour_id_proof_upload.php',
        data:{ traveler_id : traveler_id, id_proof_url : id_proof_url },
        success:function(result){
            msg_alert(result);
        }
    });
}
id_proof_upload1();

function upload_tour_pan_card()
{
    var traveler_id = $('#traveler_id').val();
    var id_proof_url = $('#txt_pan_card_upload_dir1').val();

    if(traveler_id==""){
        error_msg_alert('Please select traveler to upload his pan card!');
        return false;
    }

    var base_url = $('#base_url').val();

    $.ajax({
        type:'post',
        url: base_url+'controller/id_proof/group_tour_pan_card_upload.php',
        data:{ traveler_id : traveler_id, id_proof_url : id_proof_url },
        success:function(result){
            msg_alert(result);
            //traveler_id_proof_info_reflect();
        }
    });
}

pan_card_upload1();

function pan_card_upload1()
{
    var type="pan_card";
    var btnUpload=$('#pan_card_upload_g');
    $(btnUpload).find('span').text('ID Proof-2');
    var status=$('#pan_card_status1');
    new AjaxUpload(btnUpload, {
      action: 'group_tour/upload_pan_card_file.php',
      name: 'uploadfile1',
      onSubmit: function(file, ext){

         var tour_id = $("#cmb_tour_id").val();
          var id_proof_url = $("#txt_pan_card_upload_dir1").val();
          
          if(tour_id=='')
          {
            error_msg_alert('Please select tour name.');
            return false;
          }



         if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
            // extension is not allowed 
            error_msg_alert('Only JPG, PNG or pdf files are allowed');
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
          document.getElementById("txt_pan_card_upload_dir1").value = response1[1];
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

function id_proof_upload1()
{
    var type="id_proof";
    var btnUpload=$('#id_proof_upload_g');
      $(btnUpload).find('span').text('ID Proof');
    var status=$('#id_proof_status1');
    new AjaxUpload(btnUpload, {
      action: 'group_tour/upload_id_proof_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

          var tour_id = $("#cmb_tour_id").val();
          var id_proof_url = $("#txt_id_proof_upload_dir1").val();
          
          if(tour_id==''){
            error_msg_alert('Please select tour name.');
            return false;
          }
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
          document.getElementById("txt_id_proof_upload_dir1").value = response1[1];
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
            var traveler_id = $('#traveler_id').val();

            $('#btn_save').button('loading');

            $.ajax({
              type: 'post',
              url: base_url()+'controller/passport_id_details/info_save.php',
              data:{ passport_no : passport_no, issue_date : issue_date, expiry_date : expiry_date, traveler_id : traveler_id },
              success: function(result){
                msg_alert(result);
                $('#btn_save').button('reset');
                traveler_id_proof_info_reflect();
              }
          });
        }
}); 
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>