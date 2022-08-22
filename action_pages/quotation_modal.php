<?php
include "../config.php";
$otp = $_POST['otp'];
// Enquiry Details
$package_id = $_POST['package_id'];
$name = $_POST['name'];
$email_id = $_POST['email_id'];
$city_place = $_POST['city_place'];
$country_code = $_POST['country_code'];
$phone = $_POST['phone'];
$travel_from = $_POST['travel_from'];
$travel_to = $_POST['travel_to'];
$adults = $_POST['adults'];
$chwb = $_POST['chwb'];
$chwob = $_POST['chwob'];
$extra_bed = $_POST['extra_bed'];
$infant = $_POST['infant'];
$package_typef= $_POST['package_typef'];
$specification= $_POST['specification'];
$type = $_POST['type'];
?>
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Generate Quotation PDF</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick=""><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="frm_pdf_save">
                <input type="hidden" id="phone" name="phone" value="<?php echo $phone; ?>">
                <input type="hidden" id="email_id" value='<?= $email_id ?>'/>
                <input type="hidden" id="otp" value='<?= $otp ?>'/>
                <!-- Enquiry Details -->
                <input type="hidden" id="package_id" value='<?= $package_id ?>'/>
                <input type="hidden" id="name" value='<?= $name ?>'/>
                <input type="hidden" id="email_id" value='<?= $email_id ?>'/>
                <input type="hidden" id="city_place" value='<?= $city_place ?>'/>
                <input type="hidden" id="country_code" value='<?= $country_code ?>'/>
                <input type="hidden" id="phone" value='<?= $phone ?>'/>
                <input type="hidden" id="travel_from" value='<?= $travel_from ?>'/>
                <input type="hidden" id="travel_to" value='<?= $travel_to ?>'/>
                <input type="hidden" id="package_typef" value='<?= $package_typef ?>'/>
                <input type="hidden" id="adults" value='<?= $adults ?>'/>
                <input type="hidden" id="chwb" value='<?= $chwb ?>'/>
                <input type="hidden" id="chwob" value='<?= $chwob ?>'/>
                <input type="hidden" id="extra_bed" value='<?= $extra_bed ?>'/>
                <input type="hidden" id="infant" value='<?= $infant ?>'/>
                <input type="hidden" id="specification" value='<?= $specification ?>'/>
                <input type="hidden" id="type" value='<?= $type ?>'/>
                <p>A sign in attempt requires further verification because we did not recognize your device. To complete the download quotation, enter the verification code on the unrecognized device.</p>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="number" class="form-control" placeholder="*Enter verification code here sent on email-id..." id="vcode" name="vcode" minlength="6" maxlength="6" title="6 Digit Verification Code" required/>
                    </div>
                </div>
                <div class="form-row text-center">
                    <div class="form-group col-md-12">
                        <button type="submit" value="btn_quotg" id="btn_quotg" class="btn btn-info" title="Generate Quotation"><i class="fa fa-file-text-o" aria-hidden="true"></i>  Generate Quotation </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/scripts.js"></script>
<script>
$('#save_modal').modal('show');
$(function () {
	$('#frm_pdf_save').validate({
		rules : {
            vcode: { required: true, minlength:6, maxlength:6 },
        },
		submitHandler : function (form) {

			$('#btn_quotg').prop('disabled',true);
			
			var crm_base_url = $('#crm_base_url').val();
			var base_url = $('#base_url').val();
			var vcode = $('#vcode').val();
			var phone = $('#phone').val();
			var email_id = $('#email_id').val();
			var otp = JSON.parse($('#otp').val());

            if (typeof Storage !== 'undefined') {
                if (localStorage) {
                    var currency = localStorage.getItem('global_currency');
                } else {
                    var currency = window.sessionStorage.getItem('global_currency');
                }
            }
            var package_id = $('#package_id').val();
            var name = $('#name').val();
            var email_id = $('#email_id').val();
            var city_place = $('#city_place').val();
            var country_code = $('#country_code').val();
            var phone = $('#phone').val();
            var travel_from = $('#travel_from').val();
            var travel_to = $('#travel_to').val();
            var adults = $('#adults').val();
            var chwb = $('#chwb').val();
            var chwob = $('#chwob').val();
            var extra_bed = $('#extra_bed').val();
            var infant = $('#infant').val();
            var package_typef = $('#package_typef').val();
            var specification = $('#specification').val();
            var type = $('#type').val();

            var session_otp = otp[0]['otp'];
            var session_phone = otp[0]['phone'];
            var session_email_id = otp[0]['email_id'];
            
            if(parseInt(vcode) !== parseInt(session_otp)){
                
                error_msg_alert('Invalid OTP',base_url);
                $('#btn_quotg').prop('disabled',false);
                return false;
            }
            $.post(crm_base_url+'controller/b2c_settings/b2c/quotation_save.php', {
                currency:currency,
                package_id:package_id,
                name : name,
                email_id : email_id,
                city_place : city_place,
                country_code : country_code,
                phone : phone,
                travel_from : travel_from,
                travel_to : travel_to,
                adults : adults,
                chwb : chwb,
                chwob : chwob,
                extra_bed:extra_bed,
                infant : infant,
                package_typef:package_typef,
                specification:specification,
                type:type
            }, function(data){
                if(data!='error'){

                    $('#save_modal').modal('hide');
                    if (typeof Storage !== 'undefined') {
                        if (localStorage) {
                            localStorage.removeItem('otp_info');
                        } else {
                            window.sessionStorage.removeItem('otp_info');
                        }
                    }
                    var url = crm_base_url+"model/app_settings/print_html/quotation_html/quotation_html_5/b2c_quotation_html.php?quotation_id="+data;
                    loadOtherPage(url);
                }else{
                    error_msg_alert('Quotation not able to download',base_url);
                    return false;
                }
            });
        }
    });
});
</script>