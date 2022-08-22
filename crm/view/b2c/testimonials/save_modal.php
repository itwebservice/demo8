<?php
include_once("../../../model/model.php");
?>
<form id="section_testm">
    <div class="modal fade" id="testm_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Customer Testimonial</h4>
                </div>

                <div class="modal-body">
                    <div class="row mg_bt_20">
                        <div class="col-md-6">
                            <input type="text" id="name" name="name" title="Customer Name" placeholder="*Customer Name" class="form-control" required/>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="designation" name="designation" placeholder="Designation" title="Designation" class="form-control"/>
                        </div>
                    </div>
                    <div class="row mg_bt_20">
                        <div class="col-md-12">
                            <textarea name="testm" placeholder="*Testimonial(Upto 1000 chars)" title="Testimonial" class="form-control" id="testm" onchange="validate_char_size('testm',1000);" ></textarea>
                        </div>
                    </div>
                    <div class="row mg_bt_20">
                        <div class="col-md-1">          
                            <div class="div-upload">
                                <div id="id_upload_btn" class="upload-button1"><span>Upload</span></div>
                                <span id="id_proof_status" ></span>
                                <ul id="files"></ul>
                                <input type="hidden" id="image_upload_url_testm" name="image_upload_url_testm">
                            </div>
                        </div>
                        <div class="col-md-10">
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
$('#testm_save_modal').modal('show');
upload_testm_image();
function upload_testm_image(){
    var btnUpload=$('#id_upload_btn');
    $(btnUpload).find('span').text('Image');

    new AjaxUpload(btnUpload, {
        action: 'testimonials/upload_testm_img.php',
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
                $("#image_upload_url_testm").val(response);
            }
        }
    });
}
$(function(){
$('#section_testm').validate({
    rules:{
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var name = $("#name").val();
        var designation = $('#designation').val();
        var testm = $("#testm").val();
        var image = $("#image_upload_url_testm").val();
        if(testm==''){
            error_msg_alert("Enter testimonial!");
            return false;
        }
        if(image === ''){
            error_msg_alert("Upload image!");
            return false;
        }
        var flag1 = validate_char_size('testm',1000);
        if(!flag1){
            return false;
        }

        var images_array = [];        
        images_array.push({
            'name':name,
            'designation':designation,
            'testm':testm,
            'image':image,
            'entry_id':'',
            'status':true
        });
        $('#btn_save1').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2c_settings/cms_save.php',
        data:{ section : '8', data : images_array},
            success: function(message){
                var data = message.split('--');
                console.log(message);
                if(data[0] == 'erorr'){
                    error_msg_alert(data[1]);
                    return false;
                }else{
                    success_msg_alert(data[1]);
                    $('#btn_save1').button('reset');
                    $('#testm_save_modal').modal('hide');
                    list_reflect();
                    update_b2c_cache();
                }
            }
        });
    }
});
});
</script>
