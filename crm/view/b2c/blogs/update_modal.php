<?php
include_once("../../../model/model.php");
$entry_id = $_POST['entry_id'];
$query = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM `b2c_blogs` where entry_id='$entry_id'"));
?>
<form id="section_blogs_form1">

    <div class="modal fade" id="blog_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Blog</h4>
                </div>
                <div class="modal-body">
                    <?php
                    // for($i = 0;$i < sizeof($blog_array);$i++){

                        $url = $query['image'];
                        $title = $query['title'];
                        $description = $query['description'];
                        ?>
                        <div class="row mg_bt_20">
                            <div class="col-md-8">
                                <input type="text" name="btitle1" placeholder="*Blog Title" id="btitle1" title="Blog Title" class="form-control" value="<?php echo $title; ?>" required/>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" id="active_flag" name="active_flag" title="Active status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mg_bt_20">
                            <div class="col-md-12">
                                <textarea name="desc1" placeholder="*Description" title="Description" class="form-control feature_editor" id="desc1" rows="5" required><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div class="row mg_bt_20">
                            <div class="col-md-1">
                                <div class="div-upload">
                                    <div id="id_upload_btn" class="upload-button1"><span><?php echo ($url=='') ?  'Upload' : 'Uploaded' ?></span></div>
                                    <span id="id_proof_status" ></span>
                                    <ul id="files"></ul>
                                    <input type="hidden" id="image_upload_url1" name="image_upload_url1" value="<?php echo $url; ?>">
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div style="color: red; padding-left:25px;">Note :Upload Image below 200KB, resolution :900X450, Format:JPEG, JPG, PNG</div>
                            </div>
                        </div>
                        <?php
                        $newUrl1 = preg_replace('/(\/+)/','/',$url); 
                        $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                    ?>
                    <img src="<?php echo $newUrl; ?>" class="img-responsive">
                    <input type="hidden" id="entry_id1" value="<?=$entry_id?>"/>

                    <div class="row mg_tp_20">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-success" id="btn_update1"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
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
$('#blog_update_modal').modal('show');
upload_blog_image1();
function upload_blog_image1(){
    var btnUpload=$('#id_upload_btn');
    var up_url = $("#image_upload_url1").val();
    var label = (up_url=='') ? 'Image': 'Uploaded';
    $(btnUpload).find('span').text(label);

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
                $(btnUpload).find('span').text('Upload');
            }
            else{
                $(btnUpload).find('span').text('Uploaded');
                $("#image_upload_url1").val(response);
            }
        }
    });
}
$(function(){
$('#section_blogs_form1').validate({
    rules:{
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var entry_id = $("#entry_id1").val();

        var btitle = $("#btitle1").val();
        var image = $("#image_upload_url1").val();
        var active_flag = $('#active_flag').val();
        var iframe = document.getElementById("desc1-wysiwyg-iframe");
        var description = iframe.contentWindow.document.body.innerHTML;
        var old_array = [];
        if(description==''||description=='<br>'){
            error_msg_alert("Enter description!");
            return false;
        }
        if(image === ''){
            error_msg_alert("Upload image!");
            return false;
        }
        old_array.push({
            'title':btitle,
            'image':image,
            'description':description,
            'entry_id':entry_id,
            'active_flag':active_flag
        });
        $('#btn_update1').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2c_settings/cms_save.php',
        data:{ section : '13', data : old_array},
            success: function(message){
                var data = message.split('--');
                if(data[0] == 'erorr'){
                    error_msg_alert(data[1]);
                    return false;
                }else{
                    success_msg_alert(data[1]);
                    $('#btn_update1').button('reset');
                    $('#blog_update_modal').modal('hide');
                    list_reflect();
                    update_b2c_cache();
                }
            }
        });
    }
});
});
</script>
