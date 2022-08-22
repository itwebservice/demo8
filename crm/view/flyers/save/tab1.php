<?php
include "../../../model/model.php";
include_once('../../layouts/fullwidth_app_header.php');
?>
<div class="bk_tabs">
    <div id="tab1" class="bk_tab active">
    <form id="frm_tab2">

    <div class="app_panel"> 
      
    <div class="container-fluid">
		
        <div class="row mg_tp_20 text-center">
            <div class="col-md-12 mg_bt_10">
                <h3><u>Create New Flyer</u></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mg_bt_10">
                <input type="text" id="flyer_name" name="flyer_name" placeholder="*Flyer Name" title="Flyer Name" required>
            </div>
            <div class="col-md-2 col-sm-6 text-left">
                <div class="div-upload">
                <div id="back_upload_btn_p" class="upload-button1"><span>Background Image</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="back_upload_url" name="back_upload_url">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 text-left">
                <div class="div-upload">
                <div id="logo_upload_btn_p" class="upload-button1"><span>Upload Logo</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="logo_upload_url" name="logo_upload_url">
                </div>
                <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= "Only JPG, PNG or JPEG files are Allowed." ?></span>
            </div>
        </div>
        <div class="row mg_tp_10">
            <div class="col-md-6 mg_bt_10">
	  	  		<h3 class="editor_title">Add Title</h3>
                <textarea class="form-control" name="title" id="title" placeholder="Add Title" style="width:100% !important" rows="2"></textarea>
            </div>
            <div class="col-md-6 mg_bt_10">
	  	  		<h3 class="editor_title">Add Description</h3>
                <textarea class="form-control" name="desc" id="desc" placeholder="Add Description" style="width:100% !important" rows="2"></textarea>
            </div>
        </div>
        <div class="row mg_tp_10">
            <div class="col-md-6 mg_bt_10">
	  	  		<h3 class="editor_title">Add Content-1</h3>
                <textarea class="form-control" name="content1" id="content1" placeholder="Add Content-1" style="width:100% !important" rows="2"></textarea>
            </div>
            <div class="col-md-6 mg_bt_10">
	  	  		<h3 class="editor_title">Add Content-2</h3>
                <textarea class="form-control" name="content2" id="content2" placeholder="Add Content-2" style="width:100% !important" rows="2"></textarea>
            </div>
            <div class="col-md-12 mg_bt_10">
	  	  		<h3 class="editor_title">Add Content-3</h3>
                <textarea class="form-control" name="content3" id="content3" placeholder="Add Content-3" style="width:100% !important" rows="1"></textarea>
            </div>
        </div>
        <div class="row text-center mg_tp_20 mg_bt_20">
            <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
        </div>
    </div> 

</form>
<?= end_panel() ?>

<script>
CKEDITOR.replace('desc');
CKEDITOR.replace('title');
CKEDITOR.replace('content1');
CKEDITOR.replace('content2');
CKEDITOR.replace('content3');
function switch_to_tab1(){
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}
upload_logo();
function upload_logo(){

    var btnUpload=$('#back_upload_btn_p');
    $(btnUpload).find('span').text('*Background Image');
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
            $("#back_upload_url").val(response);
            }
        }
    });
}
upload_blogo();
function upload_blogo(){

    var btnUpload=$('#logo_upload_btn_p');
    $(btnUpload).find('span').text('Upload Logo');
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
            $("#logo_upload_url").val(response);
            }
        }
    });
}

$(function(){
    $('#frm_tab2').validate({
    rules:{
        logo_upload_url : { required : true },
        flyer_name : { required : true },
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();

        var back_url = $('#back_upload_url').val();
        if(back_url == ''){
            error_msg_alert("Please select background image!");
            return false;
        }
        var flyer_name = $('#flyer_name').val();
        var logo_upload_url = $('#logo_upload_url').val();
        var title = CKEDITOR.instances.title.getData();
        var desc = CKEDITOR.instances.desc.getData();
        var content1 = CKEDITOR.instances.content1.getData();
        var content2 = CKEDITOR.instances.content2.getData();
        var content3 = CKEDITOR.instances.content3.getData();

        $('#btn_save').button('loading');

        $.post(
            base_url+"controller/flyers/save.php",
            { back_url:back_url,flyer_name : flyer_name, logo_upload_url : logo_upload_url,title:title,desc:desc,content1:content1,content2:content2,content3:content3},
            function(data) {
            $('#btn_save').button('reset');
            var msg = data.split('--');
            if(msg[0]=="error"){
                error_msg_alert(msg[1]);
                return false;
            }else{
                $('#vi_confirm_box').vi_confirm_box({
                    false_btn: false,
                    message: data,
                    true_btn_text:'Ok',
                    callback: function(data1){
                        if(data1=="yes"){
                            window.location.href = '../index.php';
                        }
                    }
                });
            }
        });  
    }
    });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<?php
include_once('../../layouts/fullwidth_app_footer.php');
?>