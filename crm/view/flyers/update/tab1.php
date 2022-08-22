<?php
include "../../../model/model.php";
include_once('../../layouts/fullwidth_app_header.php');

$flyer_id = $_GET['iid'];
$sq_flyer = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM `flyers` WHERE `iid`='$flyer_id'"));
$ilogo = json_decode($sq_flyer['logo']);
$ititle = json_decode($sq_flyer['title']);
$idesc = json_decode($sq_flyer['desc']);
$content1 = json_decode($sq_flyer['content1']);
$content2 = json_decode($sq_flyer['content2']);
$content3 = json_decode($sq_flyer['content3']);

$ilogocss = "
    position: ".$ilogo->css->position.";
    top: ".$ilogo->css->top.";
    left:".$ilogo->css->left.";
    height:120px; 
";
$ititlecss = 
"
    position: ".$ititle->css->position.";
    top: ".$ititle->css->top.";
    left:".$ititle->css->left.";
    
";
$idesccss = 
"
    position: ".$idesc->css->position.";
    top: ".$idesc->css->top.";
    left:".$idesc->css->left.";
    
";
$content1_css = 
"
    position: ".$content1->css->position.";
    top: ".$content1->css->top.";
    left:".$content1->css->left.";
    
";
$content2_css = 
"
    position: ".$content2->css->position.";
    top: ".$content2->css->top.";
    left:".$content2->css->left.";
    
";
$content3_css = 
"
    position: ".$content3->css->position.";
    top: ".$content3->css->top.";
    left:".$content3->css->left.";
    
";
$image = $ilogo->data;
if($image != ''){
  $newUrl = preg_replace('/(\/+)/','/',$image);
  $newUrl = explode('uploads', $newUrl);
  $newUrl = BASE_URL.'uploads'.$newUrl[1];
}else{
  $newUrl = '';
}
if($sq_flyer['background_url'] != ''){
  
  $backUrl = preg_replace('/(\/+)/','/',$sq_flyer['background_url']);
  $backUrl = explode('uploads', $backUrl);
  $backUrl = BASE_URL.'uploads'.$backUrl[1];
}else{
  $backUrl = '';
}
?>

<div class="bk_tabs">

    <div id="tab1" class="bk_tab active">
      
      <form id="frm_tab2_u">
        <input type="hidden" id="flyer_id" value="<?= $flyer_id ?>"/>
        <div class="app_panel"> 

            <!--=======Header panel======-->
            <div class="app_panel_head mg_bt_20">
                <div class="container">
                    <h2 class="pull-left"></h2>
                    <div class="pull-right header_btn">
                    </div>
                </div>
            </div> 
            <!--=======Header panel end======-->
            <div class="container-fluid">
            
                <div class="row text-right mg_bt_20">
                    <div class="col-md-9 mg_bt_10">
                        <input type="text" id="flyer_name" name="flyer_name" placeholder="*Flyer Name" title="Flyer Name" value="<?= $sq_flyer['flyer_name'] ?>" disabled required>
                    </div>
                    <div class="col-xs-3">
                        <button class="btn btn-info btn-sm ico_left" type="submit" title="Apply changes"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Apply</button>
                        <button class="btn btn-success btn-sm ico_left" id="btn_export" onclick="downloadimage()" type="button" title="Export to png"><i class="fa fa-download"></i>&nbsp;&nbsp;Export</button>
                        <button class="btn btn-danger btn-sm ico_left" id="btn_clse" type="button" onclick="close_image()" title="Close "><i class="fa fa-close"></i>&nbsp;&nbsp;Close</button>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-5 mg_bt_10">
                    <div id="divis">
                      <img src="<?php echo $backUrl; ?>" style="<?php echo $sq_flyer['igencss']; ?>" alt="">
                      <?php if($newUrl != ''){ ?><img src="<?php echo $newUrl; ?>" style="<?php echo $ilogocss; ?>" alt="" ><?php } ?>
                      <span style ="<?php echo $ititlecss; ?>"><?php echo $sq_flyer['title_data']; ?></span>
                      <span style ="<?php echo $idesccss; ?>"><?php echo $sq_flyer['desc_data']; ?></span>
                      <span style ="<?php echo $content1_css; ?>"><?php echo $sq_flyer['content1_data']; ?></span>
                      <span style ="<?php echo $content2_css; ?>"><?php echo $sq_flyer['content2_data']; ?></span>
                      <span style ="<?php echo $content3_css; ?>"><?php echo $sq_flyer['content3_data']; ?></span>

                    </div>
                  </div>
                  <div class="col-md-7 mg_bt_10" style="height: 600px;overflow-y: auto;border:1px solid #f5f5f5;">
                    
                    <div class="row mg_tp_10">
                      <div class="col-md-4 col-sm-6 text-left">
                      <span style="color: red;line-height: 30px;" data-original-title="" title="" class="note"><?= "Only JPG, PNG or JPEG files are Allowed." ?></span>
                          <div class="div-upload">
                          <div id="logo_upload_btn_p1" class="upload-button1"><span>Upload Logo</span></div>
                          <span id="photo_status" ></span>
                          <ul id="files" ></ul>
                          <input type="hidden" id="logo_upload_url1" name="logo_upload_url1" value="<?= $ilogo->data ?>">
                          </div>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <label>Logo Left(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $ilogo->css->left ?>" id="logoleft" name="logoleft" placeholder="Logo Left" title="Logo Left">
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <label>Logo Top(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $ilogo->css->top ?>" id="logotop" name="logotop" placeholder="Logo Top" title="Logo Top">
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <label>Delete Logo</label><br/>
                        <button type="button" class="btn btn-excel btn-sm" title="Delete Logo" onClick="delete_logo()"><i class="fa fa-close"></i></button>
                      </div>
                    </div><hr/>

                    <div class="row mg_tp_10">
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Title Left(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $ititle->css->left ?>" id="titleleft" name="titleleft" placeholder="Title Left" title="Title Left">
                      </div>
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Title Top(eg. 100px)</label>
                        <input type="text" class="form-control" value="<?= $ititle->css->top ?>" id="titletop" name="titletop" placeholder="Title Top" title="Title Top">
                      </div>
                      <div class="col-md-12 mg_bt_10">
                        <h3 class="editor_title">Add Title</h3>
                        <textarea class="editor" name="title_data" id="title_data" placeholder="Add Title" style="width:100% !important" rows="15"><?= $sq_flyer['title_data'] ?></textarea>
                      </div>
                    </div><hr/>
                    <div class="row mg_tp_10">
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Description Left(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $idesc->css->left ?>" id="descleft" name="descleft" placeholder="Description Left" title="Description Left">
                      </div>
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Description Top(eg. 100px)</label>
                        <input type="text" class="form-control" value="<?= $idesc->css->top ?>" id="desctop" name="desctop" placeholder="Description Top" title="Description Top">
                      </div>
                      <div class="col-md-12 mg_bt_10">
                        <h3 class="editor_title">Add Description</h3>
                        <textarea class="editor" name="description_data" id="description_data" placeholder="Add Description" style="width:100% !important" rows="15"><?= $sq_flyer['desc_data'] ?></textarea>
                      </div>
                    </div><hr/>
                    <div class="row mg_tp_10">
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Content-1 Left(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $content1->css->left ?>" id="content1left" name="content1left" placeholder="Content-1 Left" title="Content-1 Left">
                      </div>
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Content-1 Top(eg. 100px)</label>
                        <input type="text" class="form-control" value="<?= $content1->css->top ?>" id="content1top" name="content1top" placeholder="Content-1 Top" title="Content-1 Top">
                      </div>
                      <div class="col-md-12 mg_bt_10">
                        <h3 class="editor_title">Add Content-1</h3>
                        <textarea class="editor" name="content1_data" id="content1_data" placeholder="Add Content-1" style="width:100% !important" rows="15"><?= $sq_flyer['content1_data'] ?></textarea>
                      </div>
                    </div><hr/>
                    <div class="row mg_tp_10">
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Content-2 Left(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $content2->css->left ?>" id="content2left" name="content2left" placeholder="Content-2 Left" title="Content-2 Left">
                      </div>
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Content-2 Top(eg. 100px)</label>
                        <input type="text" class="form-control" value="<?= $content2->css->top ?>" id="content2top" name="content2top" placeholder="Content-2 Top" title="Content-2 Top">
                      </div>
                      <div class="col-md-12 mg_bt_10">
                        <h3 class="editor_title">Add Content-2</h3>
                        <textarea class="editor" name="content2_data" id="content2_data" placeholder="Add Content-2" style="width:100% !important" rows="15"><?= $sq_flyer['content2_data'] ?></textarea>
                      </div>
                    </div><hr/>
                    <div class="row mg_tp_10">
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Content-3 Left(eg. 250px)</label>
                        <input type="text" class="form-control" value="<?= $content3->css->left ?>" id="content3left" name="content3left" placeholder="Content-3 Left" title="Content-3 Left">
                      </div>
                      <div class="col-md-4 mg_bt_10 col-sm-6">
                        <label>Content-3 Top(eg. 100px)</label>
                        <input type="text" class="form-control" value="<?= $content3->css->top ?>" id="content3top" name="content3top" placeholder="Content-3 Top" title="Content-3 Top">
                      </div>
                      <div class="col-md-12 mg_bt_10">
                        <h3 class="editor_title">Add Content-3</h3>
                        <textarea class="editor" name="content3_data" id="content3_data" placeholder="Add Content-3" style="width:100% !important" rows="15"><?= $sq_flyer['content3_data'] ?></textarea>
                      </div>
                    </div>
                </div>

            </div> 

        </form>
    </div>
</div> 
<?= end_panel() ?>
<script>
CKEDITOR.replace('description_data');

CKEDITOR.disallowedContent = 'span{font,font-size,font-family}';
CKEDITOR.replace('title_data');
CKEDITOR.replace('content1_data');
CKEDITOR.replace('content2_data');
CKEDITOR.replace('content3_data');
upload_logo1();
function upload_logo1(){

    var btnUpload=$('#logo_upload_btn_p1');
    if('<?= $ilogo->data ?>' != ''){
      var btntext = 'Uploaded';
    }else{
      var btntext = 'Upload Logo';
    }
    $(btnUpload).find('span').text(btntext);
    new AjaxUpload(btnUpload, {

        action: '../upload_logo.php',
        name: 'uploadfile',
        onSubmit: function(file, ext)
        {  
            if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
            error_msg_alert('Only JPG, PNG or JPEG files are Allowed !!');
            return false;
            }
            $(btnUpload).find('span').text('Uploading...');
        },

        onComplete: function(file, response){
            if(response==="error"){          
            error_msg_alert("File is not uploaded.");           
            $(btnUpload).find('span').text('Upload');
            }else
            { 
            $(btnUpload).find('span').text('Uploaded');
            $("#logo_upload_url1").val(response);
            }
        }
    });
}
function delete_logo(){
  var url = $("#logo_upload_url1").val();
  if(url!=''){
    $("#logo_upload_url1").val('');
    if($("#logo_upload_url1").val() == ''){
      success_msg_alert('Logo deleted click on "Apply" !');
    }
  }else{
    error_msg_alert('Logo not uploaded!');
  }
}

function close_image(){
  location.replace('../index.php');
}

function downloadimage() {
    
    $('#btn_export').prop('disabled',true);
    var flyer_name = $('#flyer_name').val();
    $('#btn_export').button('loading');
    const screenshootTarget = document.getElementById('divis');
    html2canvas(screenshootTarget).then((canvas) => {
        const base64image = canvas.toDataURL("image/png");
        var anchor = document.createElement('a');
        anchor.setAttribute("href",base64image);
        anchor.setAttribute("download",flyer_name+".png");
        anchor.click();
        anchor.remove();
      $('#btn_export').prop('disabled',false);
      $('#btn_export').button('reset');
    }
    );
}

$(function(){
    $('#frm_tab2_u').validate({
    rules:{
        logo_upload_url1 : { required : true },
        flyer_name : { required : true },
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var flyer_id = $('#flyer_id').val();
        var title_data = CKEDITOR.instances.title_data.getData();
        var description_data = CKEDITOR.instances.description_data.getData();
        var content1_data = CKEDITOR.instances.content1_data.getData();
        var content2_data = CKEDITOR.instances.content2_data.getData();
        var content3_data = CKEDITOR.instances.content3_data.getData();
        
        var logo_array = [];
        var title_array = [];
        var desc_array = [];
        var content1_array = [];
        var content2_array = [];
        var content3_array = [];
        logo_array.push({
            'data' : $('#logo_upload_url1').val(),
            'css'  : [{'left' : $('#logoleft').val(),'top' : $('#logotop').val()}]
        });
        title_array.push({
            'css'  : [{'left' : $('#titleleft').val(),'top' : $('#titletop').val()}]
        });
        desc_array.push({
            'css'  : [{'left' : $('#descleft').val(),'top' : $('#desctop').val()}]
        });
        content1_array.push({
            'css'  : [{'left' : $('#content1left').val(),'top' : $('#content1top').val()}]
        });
        content2_array.push({
            'css'  : [{'left' : $('#content2left').val(),'top' : $('#content2top').val()}]
        });
        content3_array.push({
            'css'  : [{'left' : $('#content3left').val(),'top' : $('#content3top').val()}]
        });
        $('#btn_save').button('loading');
        $.post(
            base_url+"controller/flyers/update.php",
            { flyer_id:flyer_id,logo_array : logo_array,title_array:title_array,desc_array:desc_array,content1_array:content1_array,content2_array:content2_array,content3_array:content3_array,title_data:title_data,description_data:description_data,content1_data:content1_data,content2_data:content2_data,content3_data:content3_data},
            function(data) {
            $('#btn_save').button('reset');
            var msg = data.split('--');
            if(msg[0]=="error"){
                error_msg_alert(msg[1]);
                return false;
            }else{
              location.replace('tab1.php?iid='+flyer_id);
            }
        });  
    }
    });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/html2canvas.min.js"></script>
<?php
include_once('../../layouts/fullwidth_app_footer.php');
?>