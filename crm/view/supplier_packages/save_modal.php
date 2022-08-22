<?php
include "../../model/model.php";
?>
<form id="frm_save" enctype="multipart/form-data">

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">New Contract</h4>
		</div>
		<div class="modal-body">        	
			<div class="row mg_bt_10">
				<div class="col-sm-6 mg_bt_10_xs">
					<select name="city_id" id="city_id" title="Select City" style="width:100%">
		            </select>
				</div>
				<div class="col-sm-6 mg_bt_10_xs">
					<select name="supplier_id" id="supplier_id" title="Select Supplier Type" style="width:100%">
						<option value="">*Supplier Type</option>
						<option value="Hotel">Hotel</option>
						<option value="Transport">Transport</option>
						<option value="Vehicle">Vehicle</option>
						<option value="DMC">DMC</option>
						<option value="Visa">Visa</option>
						<option value="Ticket">Flight</option>
						<option value="Activity">Activity</option>
						<option value="Insurance">Insurance</option>
						<option value="Train Ticket">Train Ticket</option>
						<option value="Other">Other</option>
						<option value="Bus">Bus</option>
		            </select>
				</div>
			</div>
			<div class="row mg_bt_10">		   	
				<div class="col-sm-6 mg_bt_10_xs">
					<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" title="Supplier Name">
				</div>
				<div class="col-sm-6 mg_bt_10_xs">
					<input type="text" id="valid_from" name="valid_from" onchange="get_to_date(this.id , 'valid_to')" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>">
				</div>
			</div>
			<div class="row mg_bt_10">		   	
			    <div class="col-sm-6 mg_bt_10_xs">
					<input type="text" id="valid_to" name="valid_to" placeholder="Valid To" title="Valid To" value="<?= date('d-m-Y') ?>" onchange="validate_validDate('valid_from','valid_to')">
				</div>
				<div class="col-sm-6">					
					<select name="active_flag" id="active_flag" title="Status" class="hidden">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>
			
				<div class="col-md-6 col-sm-6 text-left">
					<div class="div-upload">
						<div id="upload_btn" class="upload-button1"><span>Upload</span></div>
						<span id="id_proof_status" ></span>
						<ul id="files" ></ul>
						<input type="Hidden" id="upload_url" name="upload_url">
					</div>    
	                <!-- <div class="div-upload">
						<div id="photo_upload_btn_i" class="upload-button1"><span>Upload</span></div>
						<input type="file" name="upload[]" id="fileuploading" style="display:none" multiple="multiple">
						<span id="photo_status" ></span>
						<ul id="files" ></ul>
						<input type="hidden" id="photo_upload_url_i" name="photo_upload_url_i">
	                </div> -->
                </div> 
			</div>
			<div class="row mg_tp_20 text-center">
				<div class="col-md-12">
					<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
				</div>
			</div>
    	</div>      
    </div>
	</div>
</div>

</form>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#save_modal').modal('show');
city_lzloading('#city_id');
$('#valid_from,#valid_to').datetimepicker({timepicker:false, format:'d-m-Y'});

upload_pic_attch();
function upload_pic_attch()
{
    var img_array = new Array(); 

    var btnUpload=$('#upload_btn');
    $(btnUpload).find('span').text('Upload');
    $("#upload_url").val('');

    new AjaxUpload(btnUpload, {
		action: 'upload_image_proof.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){  
			if (! (ext && /^(xlsx|xls|doc|docx|pdf)$/.test(ext))){ 
			error_msg_alert('Only Word,Excel or PDF files are allowed');
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
				if(response=="error1")
				{
					$(btnUpload).find('span').text('Upload');
					error_msg_alert('Maximum size exceeds');
					return false;
				}else
				{
					$(btnUpload).find('span').text('Uploaded'); 
					$("#upload_url").val(response);
				}
			}
		}
    });
}
// $('#photo_upload_btn_i').click(function(){ 
// 	$('#fileuploading').trigger('click'); 
// });
// $('#fileuploading').change(function(){
// 	$('#photo_upload_btn_i').find('span').text('Uploading');
// 	var ext = $(this).val().split('.').pop();
// 	if (! (ext && /^(xlsx|xls|doc|docx|pdf)$/.test(ext))){
		
// 		$('#photo_upload_btn_i').find('span').text('Upload');
// 		error_msg_alert('Only Word,Excel or PDF files are allowed');
// 		return false;
// 	}
// 	$('#photo_upload_btn_i').find('span').text('Uploaded');
// });
$(function(){
	$('#frm_save').validate({
		rules:{
			city_id : { required : true },
			supplier_id : { required : true },
		},
		submitHandler:function(form){
			
			$('#btn_save').prop('disabled',true);
			var city_id = $('#city_id').val();
			var supplier_id = $('#supplier_id').val();
			var active_flag = $('#active_flag').val();
			var supplier_name = $('#supplier_name').val();
			var valid_from = $('#valid_from').val();
			var valid_to = $('#valid_to').val();
			var upload_url = $('#upload_url').val();
			
			if(upload_url == ''){
				error_msg_alert('Upload file is required');
				$('#btn_save').prop('disabled',false);
				return false;
			}
			var formData = new FormData($('#frm_save')[0]);
			$('#btn_save').button('loading');
			$.ajax({

				type:'post',
				processData: false,
				contentType: false,
				url: base_url()+'controller/supplier_packages/package_save.php',

				data: formData,
				success:function(result){
					
					$('#btn_save').prop('disabled',false);
					msg_alert(result);
					$('#save_modal').modal('hide');
					list_reflect();
				}
			});
		}
	});
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>