<?php
include '../../../model/model.php';
$query = mysqli_fetch_assoc(mysqlQuery("SELECT book_enquiry_button FROM `b2c_settings` where setting_id='1'"));
$book_enquiry_button = json_decode($query['book_enquiry_button']);
$p_gateway = $book_enquiry_button[0]->p_gateway;
?>
<form id="section_enqbk">
    <legend>Define Payment Gateway</legend>
    <div class="row mg_bt_20">
        <div class="col-md-3 mg_bt_10">
            <select name="p_gateway" id="p_gateway" title="Select Payment Gateway" class='form-control' style='width:100%' onchange="get_credentials()" data-toggle="tooltip"required>
                <?php if($p_gateway!=''){?>
                    <option value="<?= $p_gateway ?>"><?= $p_gateway ?></option>
                <?php } ?>
                <option value="">*Select Payment Gateway</option>
                <option value="RazorPay">RazorPay</option>
            </select>
        </div>
        <div class="col-md-3 mg_bt_10">
            <select id="bank_id" name="bank_id" style="width:100%" title="*Select Creditor Bank" class="form-control" required>
                <?php if($book_enquiry_button[0]->bank!=''){
                        $bank_id = $book_enquiry_button[0]->bank;
                        $sq_bank = mysqli_fetch_assoc(mysqlQuery("select bank_name from bank_master where bank_id='$bank_id'"));
                    ?>
                    <option value="<?= $book_enquiry_button[0]->bank ?>"><?= $sq_bank['bank_name'] ?></option>
                <?php } ?>
                <?php get_bank_dropdown(); ?>
            </select>
        </div>
        <div id="payment_gateway_data"></div>
    </div>
    
    <div id="payment_credentials"></div>
    
    <div class="row mg_tp_20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <h5>Please make the registration in Tidio website and add the API key :</h5>
            <ul>
                <a href="https://www.tidio.com/"> Tidio </a>
            </ul>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
function reflect_payment(button_type){

    var button = $('#'+button_type).val();
    if(button === "book"){
        $.ajax({
        type:'post',
        url: 'enquiry_or_book/reflect_payment_gateways.php',
        data:{ payment_gateway : ''},
        success:function(result){
            $('#payment_gateway_data').html(result);
        }
        });
    }else{
        $('#payment_gateway_data').html('');
        $('#payment_credentials').html('');
    }
}
// reflect_payment('button_type');
function get_credentials(){

    var p_gateway = $('#p_gateway').val();
    $.ajax({
    type:'post',
    url: 'enquiry_or_book/get_paymentgateway_credentials.php',
    data:{ p_gateway : p_gateway},
    success:function(result){
        $('#payment_credentials').html(result);
    }
    });
}
get_credentials();

$(function(){
$('#section_enqbk').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var button_type = "book";
    var images_array = [];
    
    if(button_type === "book"){
        
        var p_gateway = $('#p_gateway').val();
        var bank_id = $('#bank_id').val();
        var cred_array = [];
        if(p_gateway == "RazorPay"){
            var api_key = $('#api_key').val();
            var api_secret = $('#api_secret').val();
            if(api_key==''){
                error_msg_alert("Enter API Key"); return false;
            }
            if(api_secret==''){
                error_msg_alert("Enter API Secret"); return false;
            }
            cred_array.push({
                'api_key' : api_key,
                'api_secret':api_secret
            });
        }
        if(p_gateway == "CCAvenue"){
            var merchant_id = $('#merchant_id').val();
            var access_code = $('#access_code').val();
            var enc_key = $('#enc_key').val();
            if(merchant_id==''){
                error_msg_alert("Enter Merchant ID"); return false;
            }
            if(access_code==''){
                error_msg_alert("Enter Access Code"); return false;
            }
            if(enc_key==''){
                error_msg_alert("Enter Encryption Key"); return false;
            }
            cred_array.push({
                'merchant_id' : merchant_id,
                'access_code':access_code,
                'enc_key':enc_key,
            })
        }
        images_array.push({
            'p_gateway':p_gateway,
            'bank':bank_id,
            'cred_array' : cred_array
        });
    }
    $('#btn_save').button('loading');
    
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '7', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('7');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>