<?php
include_once("../../../model/model.php");
?>
<form id="section_blogs">
    <div class="modal fade" id="blog_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Blog</h4>
                </div>

                <div class="modal-body">
                    <div class="row mg_bt_20">
                        <div class="col-md-12">
                            <input type="text" name="btitle" placeholder="*Blog Title" id="btitle" title="Blog Title" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row mg_bt_20">
                        <div class="col-md-12">
                            <h5>*Description</h5>
                            <textarea name="desc" placeholder="*Description" title="Description" class="form-control feature_editor" id="desc" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="row mg_bt_20">
                        <div class="col-md-1">          
                            <div class="div-upload">
                                <div id="id_upload_btn" class="upload-button1"><span>Upload</span></div>
                                <span id="id_proof_status" ></span>
                                <ul id="files"></ul>
                                <input type="hidden" id="image_upload_url" name="image_upload_url">
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div style="color: red; padding-left:25px;">Note :Upload Image below 200KB, resolution :900X450, Format:JPEG, JPG, PNG</div>
                        </div>
                    </div>
                    <div class="row mg_tp_20">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-success" id="btn_save1"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#blog_save_modal').modal('show');
upload_blog_image();
function upload_blog_image(){
    var btnUpload=$('#id_upload_btn');
    $(btnUpload).find('span').text('Image');

    new AjaxUpload(btnUpload, {
        action: 'blogs/upload_blog_img.php',
        name: 'uploadfile',
        onSubmit: function(file, ext)
        {
            if (! (ext && /^(png|jpeg|jpg)$/.test(ext))){ 
            error_msg_alert('Only JPG,JPEG,PNG files are allowed');
            return false;
            }
            $(btnUpload).find('span').text('Uploading...');
        },
        onComplete: function(file, response){
            var response1 = response.split('--');
            if(response1[0]=="error"){
                error_msg_alert(response1[1]);
                $(btnUpload).find('span').text('Image');
            }
            else{
                $(btnUpload).find('span').text('Uploaded');
                $("#image_upload_url").val(response);
            }
        }
    });
}
$(function(){
$('#section_blogs').validate({
    rules:{
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var btitle = $("#btitle").val();
        var image = $("#image_upload_url").val();
        var iframe = document.getElementById("desc-wysiwyg-iframe");
        var description = iframe.contentWindow.document.body.innerHTML;
        if(description==''||description=='<br>'){
            error_msg_alert("Enter description!");
            return false;
        }
        if(image === ''){
            error_msg_alert("Upload image!");
            return false;
        }
        var blogs = [];
        blogs.push({
            'title':btitle,
            'image':image,
            'description':description,
            'entry_id':''
        });

        $('#btn_save1').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2c_settings/cms_save.php',
        data:{ section : '13', data : blogs},
            success: function(message){
                var data = message.split('--');
                if(data[0] == 'erorr'){
                    error_msg_alert(data[1]);
                    return false;
                }else{
                    success_msg_alert(data[1]);
                    $('#btn_save1').button('reset');
                    $('#blog_save_modal').modal('hide');
                    list_reflect();
                    update_b2c_cache();
                }
            }
        });
    }
});
});
</script>
