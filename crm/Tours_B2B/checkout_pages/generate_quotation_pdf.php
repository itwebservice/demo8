<?php
include "../../model/model.php";
$register_id = $_SESSION['register_id'];
$cart_list_arr = $_POST['cart_list_arr'];
$timing_slots = $_POST['timing_slots'];
$global_currency = $_POST['global_currency'];
$unique_timestamp =  md5(uniqid());
?>
<form id="frm_pdf_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Quotation PDF</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        <input type="hidden" id="txt_unique_timestamp" name="unique_timestamp" value="<?php echo $unique_timestamp; ?>">
        <input type="hidden" id="register_id" value='<?= $register_id ?>'/>
        <input type="hidden" id="cart_list_arr" value='<?= json_encode($cart_list_arr,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>'/>
        <input type="hidden" id="timing_slots" value='<?= json_encode($timing_slots) ?>'/>
            <div class="c-travellerDtls container-iPad">
                <div class="row c-infoRow">
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <input type="text" id="cust_name" name="cust_name" placeholder="*Customer Name" class="infoRow_txtbox" title="Enter Customer Name" data-toggle="tooltip" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <input type="email" class="infoRow_txtbox" placeholder="*Email ID" id="email_id" name="email_id" title="Enter Email ID" data-toggle="tooltip" required/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="c-select2DD text-left">
                            <select class="infoRow_txtbox full-width" name="country_code1" id="country_code1" style="width:100%" required>
                                <?= get_country_code() ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <input type="number" minlength='4' maxlength='12' class="infoRow_txtbox" placeholder="*Contact Number" id="contact_no" name="contact_no" title="Enter Valid Contact Number" data-toggle="tooltip" required />
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row c-infoRow">
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <select class="form-control full-width" id="markup_in" name="markup_in" title="Select Markup In" data-toggle="tooltip" required>
                                <option value="">Select Markup In</option>
                                <option value="Percentage">Percentage</option>
                                <option value="Flat">Flat</option>
                            <select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <input type="number" class="infoRow_txtbox" placeholder="*Markup Amount" id="markup_amount" name="markup_amount" title="Enter Markup Amount" data-toggle="tooltip" required />
                        </div>
                    </div>
                </div>
                <div class="row c-infoRow">
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <select class="form-control full-width" id="tax_in" name="tax_in" title="Select Tax In" data-toggle="tooltip" required>
                                <option value="">Select Tax In</option>
                                <option value="Percentage">Percentage</option>
                                <option value="Flat">Flat</option>
                            <select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 for-iPad">
                        <div class="form-group">
                            <input type="number" class="infoRow_txtbox" placeholder="*Tax Amount" id="tax_amount" name="tax_amount" title="Enter Tax Amount" data-toggle="tooltip" required />
                        </div>
                    </div>
                </div>
                <div class='text-center loadMoreContainer' id="payment_div">
                    <button id="gpdf" title="Generate PDF" data-toggle="tooltip" class="loadBtn" value="pdf">Generate PDF</button>
                </div>
                <input type="hidden" id="quotation_currency" value="<?= $global_currency ?>"/>
            </div>
        </div>
        </div>
    </div>
</div>
<script>
$('#save_modal').modal('show');
$('#country_code1').select2();
//Print
function loadOtherPage (url) {
	$('<iframe>').attr('src', url).appendTo('body');
	//  window.location.href= url;

}
$(function(){
    $('#frm_pdf_save').validate({
    rules:{
        rules: {
            contact_no : {required:true, minlength:'4',maxlength:'12'},
        },
        messages: {
            contact_no: "Enter Contact Number(4 to 12 digits)"
        }
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var csv_base_url = $('#csv_base_url').val();
        var quotation_currency = $('#quotation_currency').val();
        var unique_timestamp = $('#txt_unique_timestamp').val();
        var cust_name = $('#cust_name').val();
        var email_id = $('#email_id').val();
        var contact_no = $('#contact_no').val();
        var country_code = $('#country_code1').val();
        var markup_in = $('#markup_in').val();
        var markup_amount = $('#markup_amount').val();
        var tax_in = $('#tax_in').val();
        var tax_amount = $('#tax_amount').val();
        var register_id = $('#register_id').val();
        var cart_list_arr = JSON.parse($('#cart_list_arr').val());
        var timing_slots = JSON.parse($('#timing_slots').val());
        
        if (typeof Storage !== 'undefined'){
            if (localStorage) {
            var payment_amount = localStorage.getItem('cart_grandtotal_list');
            } else {
            var payment_amount = window.sessionStorage.getItem('cart_grandtotal_list');
            }
        }
        var pdf_data_array = [];
        pdf_data_array.push({
            'register_id':register_id,
            'cust_name':cust_name,
            'email_id':email_id,
            'contact_no':country_code+contact_no,
            'markup_in':markup_in,
            'markup_amount':parseFloat(markup_amount),
            'tax_in':tax_in,
            'tax_amount':parseFloat(tax_amount),
            'grand_total':parseFloat(JSON.parse(payment_amount)),
            'timing_slots':timing_slots
        });
        
        $.post(base_url+'controller/b2b_customer/quotation_save.php', {unique_timestamp:unique_timestamp,register_id : register_id,pdf_data_array:pdf_data_array,cart_list_arr:cart_list_arr,quotation_currency:quotation_currency }, function(data){
            var url = base_url+'model/app_settings/print_html/quotation_html/quotation_html_2/b2b_quotation_html.php?pdf_data_array='+JSON.stringify(pdf_data_array)+'&cart_list_arr='+JSON.stringify(cart_list_arr)+'&quotation_currency='+quotation_currency+'&flag_value=false';
            setTimeout(() => {
                loadOtherPage(url);
            }, 800);
    	});

    }
    })
});
</script>