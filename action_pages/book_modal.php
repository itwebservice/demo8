<?php
header('Content-type: text/plain');
include "../config.php";
global $currency_logo;
$sq_cms = mysqli_fetch_assoc(mysqlQuery("SELECT coupon_codes FROM b2c_settings where 1"));
$coupon_codes = ($sq_cms['coupon_codes'] != ''&&$sq_cms['coupon_codes'] != 'null') ? ($sq_cms['coupon_codes']) : json_encode([]);
$otp = $_POST['otp'];
// Enquiry Details
$type = $_POST['type'];
$package_id = $_POST['package_id'];
$package_name = $_POST['package_name'];
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
$result = explode('-',$_POST['result']);
$total_cost = floatval($result[0]);
$adult_cost = floatval($result[1]);
$chwob_cost = floatval($result[2]);
$chwb_cost = floatval($result[3]);
$infant_cost = floatval($result[4]);
$extrab_cost = floatval($result[5]);
$costing_desc = ($adults!='0') ? "Adult(PP): ".number_format($adult_cost,2)."\r\n" : '';
$costing_desc .= ($chwob!='0') ? "Child Without Bed(PP): ".number_format($chwob_cost,2)."\r\n" : '';
$costing_desc .= ($chwb!='0') ? 'Child With Bed(PP): '.number_format($chwb_cost,2)."\r\n" : '';
$costing_desc .= ($extra_bed!='0') ? 'Extra Bed(PP): '.number_format($extrab_cost,2)."\r\n" : '';
$costing_desc .= ($infant!='0') ? 'Infant(PP): '.number_format($infant_cost,2)."\r\n" : '';
$costing_desc = strip_tags($costing_desc);
?>
<div class="modal fade" id="book_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="max-width:1300px" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Book your Holiday plan!</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick=""><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="frm_pdf_save" class="needs-validation" novalidate>
                <!-- Enquiry Details -->
                <input type="hidden" id="type" value='<?= $type ?>'/>
                <input type="hidden" id="name" value='<?= $name ?>'/>
                <input type="hidden" id="email_id" value='<?= $email_id ?>'/>
                <input type="hidden" id="city_place" value='<?= $city_place ?>'/>
                <input type="hidden" id="country_code" value='<?= $country_code ?>'/>
                <input type="hidden" id="phone" value='<?= $phone ?>'/>
                <input type="hidden" id="package_id" value='<?= $package_id ?>'/>
                <input type="hidden" id="package_name" value='<?= $package_name ?>'/>
                <input type="hidden" id="travel_from" value='<?= $travel_from ?>'/>
                <input type="hidden" id="travel_to" value='<?= $travel_to ?>'/>
                <input type="hidden" id="adults" value='<?= $adults ?>'/>
                <input type="hidden" id="chwb" value='<?= $chwb ?>'/>
                <input type="hidden" id="chwob" value='<?= $chwob ?>'/>
                <input type="hidden" id="infant" value='<?= $infant ?>'/>
                <input type="hidden" id="extra_bed" value='<?= $extra_bed ?>'/>
                <input type="hidden" id="package_typef" value='<?= $package_typef ?>'/>
                <input type="hidden" id="specification" value='<?= $specification ?>'/>
                <!-- Enquiry Details End -->
                <input type="hidden" id="coupon_codes" value='<?= ($coupon_codes) ?>' />
                <div class="form-row">
                    <div class="form-group col-md-4" style="border-right:2px solid gray;">
                        <label> Tour Name: <?= $package_name.'('.$package_typef.')' ?> </label>
                    </div>
                    <div class="form-group col-md-4" style="border-right:2px solid gray;">
                        <label> Travel Date: <?= $travel_from.' To '.$travel_to ?> </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label> Total Guest(s): <?= intval($adults)+intval($chwb)+intval($chwob)+intval($infant) ?> </label>
                    </div>
                </div>
                <?php
                if($type == '1'){ ?>
                <legend>Basic Details</legend>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="*Pickup Location" id="pickup_from" name="pickup_from" title="Pickup Location" required/>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="*Pickup Date&Time" id="pickup_time" name="pickup_time" title="Pickup&Time" required/>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="*Dropoff Location" id="drop_to" name="drop_to" title="Dropoff Location" required/>
                    </div>
                </div>
                <?php } ?>
                <script>
                    var date = new Date();
                    var yest = date.setDate(date.getDate()-1);
                </script>
                <hr/>
                <legend>Guest Details</legend>
                <?php
                for($i=0;$i<intval($adults);$i++){
                    ?>
                    <label>Adult-<?=($i+1)?></label>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <select class="full-width" id="ahonorific<?=$i?>" title="Select Honorific" data-toggle="tooltip">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*First Name" id="afirst_name<?=$i?>" name="afirst_name<?=$i?>" title="First Name" required/>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*Last Name" id="alast_name<?=$i?>" name="alast_name<?=$i?>" title="Last Name" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" placeholder="Birthdate" id="abirthdate<?=$i?>" name="abirthdate<?=$i?>" title="Birthdate"/>
                        </div>
                    </div>
                    <script>
                        $('#abirthdate<?=$i?>').datetimepicker({format:'d-m-Y', maxDate:yest, timepicker:false });
                    </script>
                <?php } ?>
                <?php if(intval($chwob)!= 0){ ?><hr/> <?php } ?>
                <?php
                for($i=0;$i<intval($chwob);$i++){
                    ?>
                    <label>Child Without Bed-<?=($i+1)?></label>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <select class="full-width" id="ohonorific<?=$i?>" title="Select Honorific" data-toggle="tooltip">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*First Name" id="ofirst_name<?=$i?>" name="ofirst_name<?=$i?>" title="First Name" required/>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*Last Name" id="olast_name<?=$i?>" name="olast_name<?=$i?>" title="Last Name" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" placeholder="Birthdate" id="obirthdate<?=$i?>" name="obirthdate<?=$i?>" title="Birthdate"/>
                        </div>
                    </div>
                    <script>
                        $('#obirthdate<?=$i?>').datetimepicker({format:'d-m-Y', maxDate:yest, timepicker:false });
                    </script>
                <?php } ?>
                <?php if(intval($chwb)!= 0){ ?><hr/> <?php } ?>
                <?php
                for($i=0;$i<intval($chwb);$i++){
                    ?>
                    <label>Child With Bed-<?=($i+1)?></label>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <select class="full-width" id="whonorific<?=$i?>" title="Select Honorific" data-toggle="tooltip">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*First Name" id="wfirst_name<?=$i?>" name="wfirst_name<?=$i?>" title="First Name" required/>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*Last Name" id="wlast_name<?=$i?>" name="wlast_name<?=$i?>" title="Last Name" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" placeholder="Birthdate" id="wbirthdate<?=$i?>" name="wbirthdate<?=$i?>" title="Birthdate"/>
                        </div>
                    </div>
                    <script>
                        $('#wbirthdate<?=$i?>').datetimepicker({format:'d-m-Y', maxDate:yest, timepicker:false });
                    </script>
                <?php } ?>
                <?php if(intval($extra_bed)!= 0){ ?><hr/> <?php } ?>
                <?php
                for($i=0;$i<intval($extra_bed);$i++){
                    ?>
                    <label>Extra Bed-<?=($i+1)?></label>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <select class="full-width" id="ehonorific<?=$i?>" title="Select Honorific" data-toggle="tooltip">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*First Name" id="efirst_name<?=$i?>" name="efirst_name<?=$i?>" title="First Name" required/>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*Last Name" id="elast_name<?=$i?>" name="elast_name<?=$i?>" title="Last Name" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" placeholder="Birthdate" id="ebirthdate<?=$i?>" name="ebirthdate<?=$i?>" title="Birthdate"/>
                        </div>
                    </div>
                    <script>
                        $('#ebirthdate<?=$i?>').datetimepicker({format:'d-m-Y', maxDate:yest, timepicker:false });
                    </script>
                <?php } ?>
                <?php if(intval($infant)!= 0){ ?><hr/> <?php } ?>
                <?php
                for($i=0;$i<intval($infant);$i++){
                    ?>
                    <label>Infant-<?=($i+1)?></label>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <select class="full-width" id="ihonorific<?=$i?>" title="Select Honorific" data-toggle="tooltip">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Ms.">Ms.</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*First Name" id="ifirst_name<?=$i?>" name="ifirst_name<?=$i?>" title="First Name" required/>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" placeholder="*Last Name" id="ilast_name<?=$i?>" name="ilast_name<?=$i?>" title="Last Name" required/>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" placeholder="Birthdate" id="ibirthdate<?=$i?>" name="ibirthdate<?=$i?>" title="Birthdate"/>
                        </div>
                    </div>
                    <script>
                        $('#ibirthdate<?=$i?>').datetimepicker({format:'d-m-Y', maxDate:yest, timepicker:false });
                    </script>
                <?php } ?>
                <hr/>
                <legend style="width: 13%;display: contents;">Costing Details</legend><span> (Showing in <?= $currency_logo ?>)</span>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>*Select State</label>
                        <?php
                        $service = ($type == '1') ? 'Package Tour' : 'Group Tour'; ?>
                        <select name="state" id="state" title="Select State/Country" style="width : 100%" onchange="get_tax(this.id,'total_cost','<?= $service ?>');">
                        <?php get_states_dropdown() ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>*Total Cost</label>
                        <input type="text" class="form-control" id="total_cost" placeholder="*Total Cost" data-bs-toggle="tooltip" data-bs-placement="top" title="<?=$costing_desc?>" readonly/>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Total Tax</label>
                        <input type="text" class="form-control" id="total_tax" placeholder="Total Tax" title="Total Tax" readonly/>
                        <input type="hidden" class="form-control" id="tax_ledger" readonly/>
                    </div>
                    <div class="form-group col-md-2">
                        <label>*Grand Total</label>
                        <input type="number" class="form-control" id="grand_total" placeholder="*Grand Total" title="Grand Total" readonly/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Coupon Code</label>
                        <input type="text" class="form-control" id="coupon_code" placeholder="Coupon Code" title="Coupon Code" onchange="costing_calc()"/>
                        <input type="hidden" class="form-control" id="coupon_amount" />
                        <span class="btn-success" id="coupon_details"></span>
                    </div>
                    <div class="form-group col-md-3">
                        <label>*Net Total</label>
                        <input type="number" class="form-control" id="net_total" placeholder="*Net Total" title="Net Total" readonly/>
                    </div>
                    <div class="form-group col-md-3">
                        <label>*Payable Amount(30% of Net Total)</label>
                        <input type="number" class="form-control" id="payment_amount" value='<?= number_format(0,2) ?>' placeholder="Payable Amount" title="*Payable Amount" readonly/>
                    </div>
                </div>
                <div class="form-row text-center">
                    <div class="form-group col-md-12">
                        <button type="submit" value="btn_quotg" id="btn_quotg" class="btn btn-info" title="Book"><i class="fa fa-file-text-o" aria-hidden="true"></i>  Book </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
})();
</script>
<script type="text/javascript" src="../js/scripts.js"></script>
<script>
$('#book_modal').modal('show');
$('#pickup_time').datetimepicker({format:'d-m-Y H:i' });
$('#state').select2();
var exampleEl = document.getElementById('total_cost')
var tooltip = new bootstrap.Tooltip(exampleEl)

function get_tax(state_id,total_cost1,travel_type){
    
    var cust_state = $('#'+state_id).val();
    var total_cost = $('#'+total_cost1).val();
    var tax_string = '';

	const rules = get_other_rules(travel_type);
    var applied_taxes = rules && get_service_tax(rules,cust_state);
    applied_taxes = applied_taxes.split(',');
    if(applied_taxes.length !== 0){
        var taxes = applied_taxes[0].split('+');
        for(var i=0; i<taxes.length;i++){
            if(taxes[i] != ''){

                var single_tax = taxes[i].split(':');
                tax_string += single_tax[0];
                if(single_tax[2] == 'Percentage'){
                    var tax_amount = parseFloat(total_cost) * (parseFloat(single_tax[1])/100);
                    tax_string += ':'+(tax_amount).toFixed(2)+' ('+single_tax[1]+'%) ';
                }
                else{
                    var tax_amount = parseFloat(single_tax[1]);
                    tax_string += ':'+(tax_amount).toFixed(2)+' ('+single_tax[1]+')';
                }
                if(i != (taxes.length-1)){
                    tax_string += ', ';
                }
            }
        }
        $('#tax_ledger').val(applied_taxes[1]);
    }else{
        $('#tax_ledger').val(parseFloat(0));
    }
    $('#total_tax').val(tax_string);
    costing_calc();
}
function get_today_date(){
    
    // convert date to y/m/data
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy +'/' +  mm + '/' + dd;
    return today;
}
function get_other_rules(travel_type) {

    var today = get_today_date();
    var data = new Date(today);
    let month = data.getMonth() + 1;
    let day = data.getDate();
    let year = data.getFullYear();
    if (day <= 9)
        day = '0' + day;
    if (month < 10)
        month = '0' + month;
    invoice_date = year + '-' + month + '-' + day;

    var cache_rules = JSON.parse($('#cache_currencies').val());
    var taxes = [];
    taxes = (cache_rules.filter((el) =>
        el.entry_id !== '' && el.rule_id === undefined && el.entry_id !== undefined && el.currency_id === undefined
    ));

    //Taxes
    var taxes1 = taxes.filter((tax) => {
        return tax['status'] === 'Active';
    });

    //Tax Rules
    var tax_rules = [];
    tax_rules = (cache_rules.filter((el) =>
        el.rule_id !== '' && el.rule_id !== undefined
    ));

    invoice_date = new Date(invoice_date).getTime();
    var tax_rules1 = tax_rules.filter((rule) => {
        var from_date = new Date(rule['from_date']).getTime();
        var to_date = new Date(rule['to_date']).getTime();

        return (
            rule['status'] === 'Active' &&
            (rule['travel_type'] === travel_type || rule['travel_type'] === 'All') &&
            (rule['validity'] == 'Permanent' || (invoice_date >= from_date && invoice_date <= to_date))
        );
    });

    var result = taxes1.concat(tax_rules1);
    return result;
}
function get_service_tax(result,cust_state) {

    //////////////////////////////
    var taxes_result = result && result.filter((rule) => {
        var { entry_id, rule_id } = rule;
        return entry_id !== '' && !rule_id;
    });
    //////////////////////////////
    var final_taxes_rules = [];
    taxes_result &&
        taxes_result.filter((tax_rule) => {
            var tax_rule_array = [];
            result &&
                result.forEach((rule) => {
                    if (parseInt(tax_rule['entry_id']) === parseInt(rule['entry_id']) && rule['rule_id'])
                        tax_rule_array.push(rule);
                });
            final_taxes_rules.push({ entry_id: tax_rule['entry_id'], tax_rule_array });
        });
    ///////////////////////////
    let applied_rules = [];
    final_taxes_rules &&
        final_taxes_rules.map((tax) => {
            var entry_id_rules = tax['tax_rule_array'];
            var flag = false;
            var conditions_flag_array = [];
            entry_id_rules &&
                entry_id_rules.forEach((rule) => {

                    if (rule['applicableOn'] == '1')
                        return;
                    var condition = JSON.parse(rule['conditions']);
                    condition &&
                        condition.forEach((cond) => {
                            var condition = cond.condition;
                            var for1 = cond.for1;
                            var value = cond.value;
                            if (condition === "1") {
                                var place_flag = null;
                                place_flag_array = [];
                                switch (for1) {
                                    case '!=':
                                        if (cust_state !== value) place_flag = true;
                                        else place_flag = false;
                                        break;
                                    case '==':
                                        if (cust_state === value) place_flag = true;
                                        else place_flag = false;
                                        break;
                                    default:
                                        place_flag = false;
                                }
                                flag = place_flag;
                            }
                        })
                    if (flag === true) applied_rules.push(rule);
                });
        });
    ////////////////////////////////////////
		var applied_taxes = '';
		var ledger_posting = '';
		applied_rules && applied_rules.map((rule) => {
			var tax_data = taxes_result.find((entry_id_tax) => entry_id_tax['entry_id'] === rule['entry_id']);
			var {  ledger1,ledger2, name1,name2,amount1,amount2 } = tax_data;
			var { name } = rule;
			if (applied_taxes == '') {
				applied_taxes = name1 + ':' + amount1 + ':' + 'Percentage';
				ledger_posting = ledger1;
				if (name2 != '') {
					applied_taxes += '+' + name2 + ':' + amount2 + ':' + 'Percentage';
					ledger_posting += '+' + ledger2;
				}
			}
			else {
				applied_taxes += name1 + ':' + amount1 + ':' + 'Percentage';
				ledger_posting = ledger_posting + '+' + ledger1;
				if (name2 != '') {
					applied_taxes += '+' + name2 + ':' + amount2 + ':' + 'Percentage';
					ledger_posting += '+' + ledger2;
				}
			}
		});
    return applied_taxes + ',' + ledger_posting;
}
function costing_calc(){
    
    var base_url = $('#base_url').val();
    $('#total_cost').val(parseFloat(<?= $total_cost ?>).toFixed(2));
    var total_cost = $('#total_cost').val();
    var total_tax = $('#total_tax').val();
    var coupon_code = $('#coupon_code').val();
    var coupon_amount = $('#coupon_amount').val();
    var advance_amount = $('#advance_amount').val();
    var coupon_codes = JSON.parse($('#coupon_codes').val());

    if(total_cost == ''){ total_cost = 0; }
    if(coupon_amount == ''){ coupon_amount = 0; }
    if(net_total == ''){ net_total = 0; }
    if(advance_amount == ''){ advance_amount = 0; }

    //Calculating tax amount
    var taxes = total_tax && total_tax.split(',');
    var tax_amount = 0;
    for(var i=0; i<taxes.length;i++){

        var single_tax = taxes[i].split(':');
        tax_amount += parseFloat(single_tax[1]);
    }
    
    var grand_cost = parseFloat(total_cost) + parseFloat(tax_amount);
    $('#grand_total').val(parseFloat(grand_cost).toFixed(2));
    /////////////////////////

    //Coupon code calculation
    var today = new Date(); // Today's date in milliseconds to compare
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = dd+'-'+mm+'-'+yyyy;
    var parts1 = today.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);
    var today_ms = date1.getTime();

    var valid_coupon = [];
    var copon_final_cost = 0;
    if(parseInt(coupon_codes.length) > 0){
        valid_coupon = coupon_codes.filter((c,i)=> {
            
            var parts1 = c['valid_date'].split('-'); // Coupon's date in milliseconds to compare
            var date1 = new Date();
            var new_month1 = parseInt(parts1[1])-1;
            date1.setFullYear(parts1[2]);
            date1.setDate(parts1[0]);
            date1.setMonth(new_month1);
            var to_date_ms = date1.getTime();
            return (c['coupon_code'] == coupon_code && today_ms <= to_date_ms)// If coupon code matches and date is valid then return obj
        });
    }
    if(parseInt(valid_coupon.length)==0 && coupon_code!=''){
        error_msg_alert('Invalid Coupon code!',base_url);
        $('#coupon_code').val('');
        $('#coupon_amount').val('');
        $('#coupon_details').html('');
    }else{
        if(coupon_code!=''){
            if(valid_coupon[0]['amount_in'] == 'Flat'){
                copon_final_cost = valid_coupon[0]['amount'];
                $('#coupon_amount').val(parseFloat(copon_final_cost).toFixed(2));
                var c_details = 'Flat '+valid_coupon[0]['amount']+' applied';
            }else{
                copon_final_cost = parseFloat(grand_cost) * parseFloat(valid_coupon[0]['amount']) / 100;
                $('#coupon_amount').val(parseFloat(copon_final_cost).toFixed(2));
                var c_details = valid_coupon[0]['amount']+'% '+'applied';
            }
            $('#coupon_details').html(c_details);
        }else{
            $('#coupon_code').val('');
            $('#coupon_amount').val('');
            $('#coupon_details').html('');
        }
    }
    //////////////////////////
    var net_total = parseFloat(grand_cost) - parseFloat(copon_final_cost);
    $('#net_total').val(parseFloat(net_total).toFixed(2));
    
    var payment_amount = parseFloat(net_total) * 30 / 100; // Advance 30% on net total
    $('#payment_amount').val(parseFloat(payment_amount).toFixed(2));
}
costing_calc();
$(function () {
	$('#frm_pdf_save').validate({
		rules : {
            vcode: { required: true, minlength:6, maxlength:6 },
        },
		submitHandler : function (form) {

			$('#btn_quotg').prop('disabled',true);
			
			var crm_base_url = $('#crm_base_url').val();
			var base_url = $('#base_url').val();
            // Enquiry Details
            var type = $('#type').val();
            var name = $('#name').val();
            var email_id = $('#email_id').val();
            var city_place = $('#city_place').val();
            var country_code = $('#country_code').val();
            var phone = $('#phone').val();
            var package_id = $('#package_id').val();
            var package_name = $('#package_name').val();
            var travel_from = $('#travel_from').val();
            var travel_to = $('#travel_to').val();
            var adults = $('#adults').val();
            var chwb = $('#chwb').val();
            var chwob = $('#chwob').val();
            var extra_bed = $('#extra_bed').val();
            var infant = $('#infant').val();
            var package_typef= $('#package_typef').val();
            var specification= $('#specification').val();
            
            //Basic Details
            var pickup_from = (type == '1') ? $('#pickup_from').val() : '';
            var pickup_time = (type == '1') ? $('#pickup_time').val() : '';
            var drop_to = (type == '1') ? $('#drop_to').val() : '';

            var enq_data_arr = [];
            enq_data_arr.push({'package_id':package_id,'package_name':package_name,'travel_from':travel_from,'travel_to':travel_to,'adults':adults,'chwob':chwob,'chwb':chwb,'extra_bed':extra_bed,'infant':infant,'package_type':package_typef,'specification':specification,'pickup_from':pickup_from,'pickup_time':pickup_time,'drop_to':drop_to});

            //Guest Details
            var adult_info_arr = [];
            for(var i=0;i<parseInt(adults);i++){

                var honorific= $('#ahonorific'+i).val();
                var first_name= $('#afirst_name'+i).val();
                var last_name= $('#alast_name'+i).val();
                var birthdate= $('#abirthdate'+i).val();
                adult_info_arr.push({'honorific':honorific,'first_name':first_name,'last_name':last_name,'birthdate':birthdate});
            }
            var chwob_info_arr = [];
            for(var i=0;i<parseInt(chwob);i++){

                var honorific= $('#ohonorific'+i).val();
                var first_name= $('#ofirst_name'+i).val();
                var last_name= $('#olast_name'+i).val();
                var birthdate= $('#obirthdate'+i).val();
                chwob_info_arr.push({'honorific':honorific,'first_name':first_name,'last_name':last_name,'birthdate':birthdate});
            }
            var chwb_info_arr = [];
            for(var i=0;i<parseInt(chwb);i++){

                var honorific= $('#whonorific'+i).val();
                var first_name= $('#wfirst_name'+i).val();
                var last_name= $('#wlast_name'+i).val();
                var birthdate= $('#wbirthdate'+i).val();
                chwb_info_arr.push({'honorific':honorific,'first_name':first_name,'last_name':last_name,'birthdate':birthdate});
            }
            var extrab_info_arr = [];
            for(var i=0;i<parseInt(extra_bed);i++){

                var honorific= $('#ehonorific'+i).val();
                var first_name= $('#efirst_name'+i).val();
                var last_name= $('#elast_name'+i).val();
                var birthdate= $('#ebirthdate'+i).val();
                extrab_info_arr.push({'honorific':honorific,'first_name':first_name,'last_name':last_name,'birthdate':birthdate});
            }
            var infant_info_arr = [];
            for(var i=0;i<parseInt(infant);i++){

                var honorific= $('#ihonorific'+i).val();
                var first_name= $('#ifirst_name'+i).val();
                var last_name= $('#ilast_name'+i).val();
                var birthdate= $('#ibirthdate'+i).val();
                infant_info_arr.push({'honorific':honorific,'first_name':first_name,'last_name':last_name,'birthdate':birthdate});
            }
            var guest_arr = [];
            guest_arr.push({'adult':adult_info_arr,'chwob':chwob_info_arr,'chwb':chwb_info_arr,'infant':infant_info_arr,'extra_bed':extrab_info_arr});

            //Costing Details
            var state = $('#state').val();
            var total_cost= $('#total_cost').val();
            var total_tax = $('#total_tax').val();
            var tax_ledger = $('#tax_ledger').val();
            var grand_total = $('#grand_total').val();
            var coupon_code = $('#coupon_code').val();
            var coupon_amount = $('#coupon_amount').val();
            var coupon_details = $('#coupon_details').html();
            var net_total = $('#net_total').val();
            var payment_amount = $('#payment_amount').val();
            var costing_arr = [];
            costing_arr.push({'state':state,'total_cost':total_cost,'total_tax':total_tax,'tax_ledger':tax_ledger,'grand_total':grand_total,'coupon_code':coupon_code,'coupon_amount':coupon_amount,'coupon_details':coupon_details,'net_total':net_total,'payment_amount':payment_amount});
            
            $.post(crm_base_url+'controller/b2c_settings/b2c/payment_gateway.php', {
                name : name,
                email_id : email_id,
                city_place : city_place,
                country_code : country_code,
                phone : phone,
                enq_data_arr : enq_data_arr,
                guest_arr : guest_arr,
                costing_arr : costing_arr,
                type:type
            }, function(data){
                console.log(data);
                $('#btn_quotg').prop('disabled',false);
               //RAZORPay
                if(data == ''){
                    error_msg_alert('Payment Gateway not selected.You can not proceed!',base_url);
                    return false;
                }
                else{
                    if(data == "RazorPay"){
                        window.location.href = base_url + 'payments/razor-pay/index.php';
                    }
                }
            });
        }
    });
});
</script>