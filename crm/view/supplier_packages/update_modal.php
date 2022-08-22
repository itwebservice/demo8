<?php
include "../../model/model.php";
$package_id = $_POST['package_id'];
$sq_ser = mysqli_fetch_assoc(mysqlQuery("select * from supplier_packages where package_id='$package_id'"));
?>
<form id="frm_update" enctype="multipart/form-data">
<input type="hidden" id="package_id" name="package_id" value="<?= $package_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

	<div class="modal-dialog" role="document">

    <div class="modal-content">

    	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Update Contract</h4>
		</div>

		<div class="modal-body">
			<div class="row">
				<div class="col-sm-6 mg_bt_10">
					<select name="city_id" id="city_id" title="City Name" style="width:100%">
						<?php 
						$sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$sq_ser[city_id]'"));
						?>
						<option value="<?= $sq_ser['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
					</select>
				</div>
				<div class="col-sm-6 mg_bt_10">
					<select name="supplier_id" id="supplier_id" title="Select Supplier Type" style="width:100%">
						<option value="<?= $sq_ser['supplier_type'] ?>"><?= $sq_ser['supplier_type'] ?></option>	
						<option value="">Supplier Type</option>	
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
			<div class="row">		   	
				<div class="col-sm-6 mg_bt_10">
					<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" title="Supplier Name" value="<?= $sq_ser['name'] ?>">
				</div>
			    <div class="col-sm-6 mg_bt_10">
					<input type="text" id="valid_from" name="valid_from" onchange="get_to_date(this.id , 'valid_to')" placeholder="Valid From" value="<?php echo get_date_user($sq_ser['valid_from']);?>" title="Valid From">
				</div>
			</div>
			<div class="row">		   	
			    <div class="col-sm-6 mg_bt_10">
					<input type="text" id="valid_to" name="valid_to" onchange="validate_validDate('valid_from' , 'valid_to')" placeholder="Valid To" value="<?php echo get_date_user($sq_ser['valid_to']);?>" title="Valid To">
				</div>
				<div class="col-sm-6 mg_bt_10">
	            	<select name="active_flag1" id="active_flag1" title="Status">
						<option value="<?=$sq_ser['active_flag'] ?>"><?=$sq_ser['active_flag'] ?></option>
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
	            	</select>
	            </div>
			</div>
			<div class="row">		   	
				<div class="col-sm-12 mg_bt_20">     
					<div class="div-upload">
						<div id="upload_btn1" class="upload-button1"><span>Upload</span></div>
						<span id="id_proof_status" ></span>
						<ul id="files" ></ul>
						<input type="hidden" id="upload_url1" name="upload_url1" value="<?php echo $sq_ser['image_upload_url']; ?>">
					</div>
                </div> 
			</div>
			<div class="row mg_bt_20 text-center">
				<div class="col-md-12">
					<button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
				</div>
			</div>
    </div>      
    </div>
</div>
</div>

</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
city_lzloading('#city_id');
$('#valid_from,#valid_to').datetimepicker({timepicker:false, format:'d-m-Y'});

$('#update_modal').modal('show');
upload_pic_attch();
function upload_pic_attch()
{
    var img_array = new Array();
    var btnUpload = $('#upload_btn1');
    var upload_url = $("#upload_url1").val();
	var label = (upload_url != '') ? 'Uploaded' : 'Upload';
    $(btnUpload).find('span').text(label);

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
					$("#upload_url1").val(response);
				}
			}
		}
    });
}
// $('#photo_upload_btn_i1').click(function(){ $('#fileuploadingup').trigger('click'); });
// $('#fileuploadingup').change(function(){
// 	$('#photo_upload_btn_i1').find('span').text('Uploading');
// 	var ext = $(this).val().split('.').pop();
// 	if (! (ext && /^(xlsx|xls|csv|doc|docx|pdf)$/.test(ext))){ 
// 		$('#photo_upload_btn_i1').find('span').text('Upload');
// 		error_msg_alert('Only Word,Excel or PDF files are allowed');
// 		return false;
// 	}
// 	$('#photo_upload_btn_i1').find('span').text('Uploaded');
// });
$(function(){
	$('#frm_update').validate({
		rules:{
			city_id : { required : true },
			supplier_id : { required : true },
		},
		submitHandler:function(form){
			event.preventDefault();
			var package_id = $('#package_id').val();
			var city_id = $('#city_id').val();
			var supplier_id = $('#supplier_id').val();
			var active_flag = $('#active_flag1').val();
			var supplier_name = $('#supplier_name').val();
			var valid_from = $('#valid_from').val();
			var valid_to = $('#valid_to').val();
			var curl = $('#photo_upload_url_i1').val();
			var upload_url = $('#upload_url1').val();

			var formDataup = new FormData($('#frm_update')[0]);
			// for(var value of formDataup.values()){
			// 	if(typeof(value) == "object"){
			// 		var ext = value["name"].split('.').pop();
			// 		if(ext!=''){
			// 			if (! (ext && /^(xlsx|xls|doc|docx|pdf)$/.test(ext))){ 
			// 				error_msg_alert('Only Word,Excel or PDF files are allowed');
			// 				return false;
			// 			}
			// 		}
			// 	}
			// }
			$('#btn_update').button('loading');
			$.ajax({

				type:'post',
				processData: false,
				contentType: false,

				url: base_url()+'controller/supplier_packages/package_update.php',

				data : formDataup,

				success:function(result){

					msg_alert(result);

					$('#update_modal').modal('hide');

					list_reflect();

				}

			});



		}

	});

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>