<?php
$sq1 = mysqlQuery("select * from travelers_details where traveler_group_id ='$traveler_group_id' and adolescence='Adult' and status='Active'");
$total_adult = mysqli_num_rows($sq1);

$sq1 = mysqlQuery("select * from travelers_details where traveler_group_id ='$traveler_group_id' and adolescence='Child With Bed' and status='Active' ");
$total_child_b = mysqli_num_rows($sq1);

$sq1 = mysqlQuery("select * from travelers_details where traveler_group_id ='$traveler_group_id' and adolescence='Child Without Bed' and status='Active' ");
$total_child_wb = mysqli_num_rows($sq1);

$sq1 = mysqlQuery("select * from travelers_details where traveler_group_id ='$traveler_group_id' and adolescence='Infant' and status='Active' ");
$total_infant = mysqli_num_rows($sq1);

$total_seats = $total_adult + $total_child_b + $total_child_wb + $total_infant;
?>
<form id="frm_tab_3">

<div class="app_panel"> 

<!--=======Header panel======-->
<div class="app_panel_head mg_bt_20">
    <div class="container">
        <h2 class="pull-left"></h2>
            <div class="pull-right header_btn">
            <button type="button" onclick="switch_back_tab_2()">
                <a>
                    <i class="fa fa-arrow-left"></i>
                </a>
            </button>
            </div>
            <div class="pull-right header_btn">
            <button>
                <a></a>
            </button>
            </div>
    </div>
</div> 

<!--=======Header panel end======-->
    <div class="app_panel_content no-pad">
        <div class="container">
            <div class="row"> 
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                        <legend>Costing Details</legend>
                        <div class="bg_white main_block panel-default-inner">
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Total Adult(s)</label>
                            <input type="text" id="txt_adult_seats" name="txt_adult_seats" value="<?php echo $total_adult; ?>" class="text-center" title="Total Adult(s)" readonly />            
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Total Child(ren) With Bed</label>
                            <input type="text" id="txt_child_b_seats" name="txt_child_b_seats" value="<?php echo $total_child_b; ?>" class="text-center" title="Total Child(ren) With Bed" readonly/>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Total Child(ren) Without Bed</label>
                            <input type="text" id="txt_child_wb_seats" name="txt_child_wb_seats" value="<?php echo $total_child_wb; ?>" class="text-center" title="Total Child(ren) Without Bed" readonly/>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Total Infant(s)</label>
                            <input type="text" id="txt_infant_seats" title="Total Infant(s)" name="txt_infant_seats" value="<?php echo $total_infant; ?>" class="text-center" readonly />           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center hidden">
                            <label>Total Passenger(s)</label>
                            <input type="text" id="txt_total_seats" title="Total Passenger(s)" name="txt_total_seats" value="<?php echo $total_seats; ?>" class="text-center" readonly />            
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Adult Cost</label>
                            <input type="text" id="txt_adult_expense" title="Adult Cost" name="txt_adult_expense" class="text-right" value="<?php echo $tourwise_details['adult_expense'] ?>" onchange="calculate_total_discount(); validate_balance(this.id)" />          
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Child With Bed Cost</label>
                            <input type="text" id="txt_child_bed_expense" title="Child With Bed Cost"  name="txt_child_bed_expense" class="text-right" value="<?php echo $tourwise_details['child_with_bed'] ?>" onchange="calculate_total_discount(); validate_balance(this.id)" />           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Child Without Bed Cost</label>
                            <input type="text" id="txt_child_wbed_expense" title="Child Without Bed Cost"  name="txt_child_wbed_expense" class="text-right" value="<?php echo $tourwise_details['child_without_bed'] ?>" onchange="calculate_total_discount(); validate_balance(this.id)" />           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Infant Cost</label>
                            <input type="text" id="txt_infant_expense" title="Infant Cost"  name="txt_infant_expense" class="text-right" value="<?php echo $tourwise_details['infant_expense'] ?>" onchange="calculate_total_discount(); validate_balance(this.id)" />         
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Total Amount</label>
                            <input type="text" id="txt_total_expense" title="Total Cost"  name="txt_total_expense" class="text-right amount_feild_highlight" value="<?php echo $tourwise_details['tour_fee'] ?>" />   
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Currency</label>
                            <select name="gcurrency_code1" id="gcurrency_code1" title="Currency" style="width:100%" data-toggle="tooltip" required>
                                <?php
                                $sq_currencyd = mysqli_fetch_assoc(mysqlQuery("SELECT `id`,`currency_code` FROM `currency_name_master` WHERE id=" . $tourwise_details['currency_code']));
                                ?>
                                <option value="<?= $sq_currencyd['id'] ?>"><?= $sq_currencyd['currency_code'] ?></option>
                                <option value=''>*Select Currency</option>
                                <?php
                                $sq_currency = mysqlQuery("select * from currency_name_master order by currency_code");
                                while($row_currency = mysqli_fetch_assoc($sq_currency)){
                                ?>
                                <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                </div>
            </div>   
            <div class="panel panel-default panel-body main_block bg_light mg_bt_30 hidden">
                    <legend>Visa & Insurance Details</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="text-center">
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_country_name" onchange="validate_city(this.id)" name="visa_country_name" placeholder="Country Name" title="Country Name" value="<?= $tourwise_details['visa_country_name'] ?>">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_amount" name="visa_amount" placeholder="Amount" title="Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="<?= $tourwise_details['visa_amount'] ?>">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_service_charge" name="visa_service_charge" title="Service Charge" class="text-right" onchange="validate_balance(this.id); calculate_total_discount()" value="<?= $tourwise_details['visa_service_charge'] ?>" />            
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <select name="visa_taxation_id" id="visa_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'visa_service_tax', 'calculate_total_discount');">
                                    
                                </select>
                                <input type="hidden" id="visa_service_tax" name="visa_service_tax" value="<?= $tourwise_details['visa_service_tax'] ?>">        
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_service_tax_subtotal" name="visa_service_tax_subtotal" value="<?= $tourwise_details['visa_service_tax_subtotal'] ?>" title="Tax Amount" readonly>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_total_amount" class="amount_feild_highlight text-right" name="visa_total_amount" placeholder="Total Amount" title="Total Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="<?= $tourwise_details['visa_total_amount'] ?>" readonly>
                            </div>    
                        </div>
                        <div class="text-center">
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_company_name" name="insuarance_company_name" onchange="validate_company(this.id)" placeholder="Insurance Company" title="Insurance Company" value="<?= $tourwise_details['insuarance_company_name'] ?>">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_amount" name="insuarance_amount" placeholder="Insurance Amount" title="Insurance Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="<?= $tourwise_details['insuarance_amount'] ?>">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_service_charge" title="Service Charge" name="insuarance_service_charge"  class="text-right" onchange="validate_balance(this.id); calculate_total_discount()" value="<?= $tourwise_details['insuarance_service_charge'] ?>" />            
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <select name="insuarance_taxation_id" id="insuarance_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'insuarance_service_tax', 'calculate_total_discount');">

                                </select>
                                <input type="hidden" id="insuarance_service_tax" name="insuarance_service_tax" value="<?= $tourwise_details['insuarance_service_tax'] ?>">        
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_service_tax_subtotal" name="insuarance_service_tax_subtotal" value="<?= $tourwise_details['insuarance_service_tax_subtotal'] ?>" placeholder="Tax Amount" title="Tax Amount" readonly>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_total_amount" class="amount_feild_highlight text-right" name="insuarance_total_amount" placeholder="Total Amount" title="Total Amount" onchange="validate_balance(this.id); calculate_total_discount()"  value="<?= $tourwise_details['insuarance_total_amount'] ?>" readonly>
                            </div>    
                        </div>
                    </div>
                </div>
                <?php
                $basic_cost = $tourwise_details['basic_amount'];
                $discount = $tourwise_details['total_discount'];

                $bsmValues = json_decode($tourwise_details['bsm_values']);
                $service_tax_amount = 0;
                if($tourwise_details['service_tax'] !== 0.00 && ($tourwise_details['service_tax']) !== ''){
                $service_tax_subtotal1 = explode(',',$tourwise_details['service_tax']);
                for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                $service_tax = explode(':',$service_tax_subtotal1[$i]);
                $service_tax_amount = $service_tax_amount + $service_tax[2];
                }
                }
                
                foreach($bsmValues[0] as $key => $value){
                switch($key){
                case 'basic' : $basic_cost = ($value != "") ? $basic_cost + $service_tax_amount : $basic_cost;$inclusive_b = $value;break;
                case 'discount' : $discount = ($value != "") ? $discount : $discount;$inclusive_d = $value;break;
                }
                }
                $readonly = ($inclusive_d != '') ? 'readonly' : '';
                // echo "<pre>";
                // var_dump($bsmValues)
                ?>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Tours and Travels Amount</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="text-right text_center_xs mg_tp_10">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Repeater's Discount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 text_center_xs">        
                                <input type="text" id="txt_repeater_discount" title="Repeater's Travelling Discount" name="txt_repeater_discount" class="text-right" placeholder="Repeaters Travelling Discount"  value="<?php echo $tourwise_details['repeater_discount'] ?>"  onchange="calculate_total_discount();validate_balance(this.id);" />
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Adjustment discount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 text_center_xs">        
                                <input type="text" id="txt_adjustment_discount" title="Adjustment discount" name="txt_adjustment_discount" class="text-right" placeholder="Adjustment Discount"  value="<?php echo $tourwise_details['adjustment_discount'] ?>"  onchange="calculate_total_discount();validate_balance(this.id);"/>
                            </div>

                            <?php $total_discount = $tourwise_details['total_discount']  ?>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Total Discount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 text_center_xs">      
                                <input type="text" id="txt_total_discount" name="txt_total_discount" title="Total Discount" class="text-right amount_feild_highlight" placeholder="Total Discount " value="<?php echo $total_discount ?>" readonly />
                                <small id="discount_show1" style="color:red"><?= ($inclusive_d == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_d ?></span></small>  
                            </div>
                        </div>
                        <div class="text-right text_center_xs">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Tour Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">        
                                <input type="text" id="txt_tour_fee" name="txt_tour_fee" class="text-right" title="Tour Amount" Placeholder="Tour Amount" readonly value="<?php echo $tourwise_details['tour_fee_subtotal_1'] ?>"/>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Travel Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                                <input type="text" id="txt_travel_total_expense1" name="txt_travel_total_expense" class="text-right" value="<?php echo $tourwise_details['total_travel_expense'] ?>" title= "Total Travel Amount"  onchange="calculate_total_discount(this.id)" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Basic Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                                <input type="text" id="basic_amount" name="basic_amount" class="text-right" value="<?= $basic_cost ?>" title= "Basic Amount" onchange="get_auto_values('txt_date','basic_amount','payment_mode','service_charge','markup','update','false','basic','basic')" readonly />
                                <small id="basic_show" style="color:#000000"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label>Tax(%)</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">        
                                <select name="tour_taxation_id" id="tour_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'service_tax_per', 'calculate_total_discount');">
                                    
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Tax Total</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">  
                                <input type="hidden" id="service_tax_per" name="service_tax_per" value="<?= $tourwise_details['service_tax_per'] ?>">
                                <input type="text" id="txt_service_charge" name="txt_service_charge" class="text-right" disabled value="<?php echo $tourwise_details['service_tax'] ?>"/>
                            </div>   
                        </div>
                        <div class="text-right text_center_xs hidden">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Total</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">        
                                <input type="text" id="txt_total_tour_fee1" name="txt_total_tour_fee1" class="text-right" placeholder="Total" title="Total" readonly value="<?php echo $tourwise_details['tour_fee_subtotal_2'] ?>"/>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label for="visa_total_amount1">Visa Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">        
                                <input type="text" id="visa_total_amount1" name="visa_total_amount1" placeholder="Visa Amount" title="Visa Amount" onchange="validate_balance(this.id)" value="<?= $tourwise_details['visa_total_amount'] ?>" readonly>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label for="insuarance_total_amount1">Insurance Amount</label></div>
                                <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">        
                                    <input type="text" id="insuarance_total_amount1" name="insuarance_total_amount1" placeholder="Insuarance Amount" title="Insurance Amount" placeholder="Insurance Amount" onchange="validate_balance(this.id);" value="<?= $tourwise_details['insuarance_total_amount'] ?>" readonly>
                                </div>
                        </div>
                        <div class="text-right text_center_xs mg_bt_10">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label for="insuarance_total_amount1">Roundoff</label></div>
                                <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 ">        
                                <input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" value="<?= $tourwise_details['roundoff'] ?> " readonly>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>TCS</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                                <?php
                                    $tcs_amount1 = $tourwise_details['tcs_tax']; //}
                                ?>
                                <input type="number" id="tcs_tax" name="tcs_tax" class="text-right" placeholder="TCS" title="TCS" onchange="calculate_total_discount(this.id);validate_balance(this.id)" <?= $tcs_readonly ?> value="<?= number_format($tcs_amount1,2) ?>"/>
                            </div>
                        </div>
                        <div class="text-right text_center_xs mg_bt_10">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Total Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">        
                                <input type="text" id="txt_total_tour_fee" name="txt_total_tour_fee" class="amount_feild_highlight text-right" placeholder="Total Amount" title="Total Amount" value="<?= $tourwise_details['net_total'] ?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Booking Summary</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <?php date_default_timezone_set('Asia/Kolkata'); ?>
                        <div class="text-center mg_bt_20">
                            <div class="col-xs-12">  
                                <textarea id="txt_special_request" name="txt_special_request" rows="2" placeholder="Enter your special request i.e Veg food, driver language : English" title="Enter your special request i.e Veg food, driver language : English"><?php echo $tourwise_details['special_request'] ?></textarea>
                            </div>
                            <input type="hidden" id="txt_date" name="txt_date" value="<?= date('d-m-Y', strtotime($tourwise_details['form_date'])) ?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="panel panel-default panel-body pad_8 text-center main_block bg_light mg_bt_0">
    <button type="button" class="btn btn-sm btn-info ico_left" onclick="switch_back_tab_2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button> &nbsp;&nbsp;&nbsp;
    <button class="btn btn-sm btn-success" id="btn_update_booking"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
</div>

</form>

<?= end_panel() ?>
<script>
    $('#txt_payment_date1, #txt_payment_date2, #txt_balance_due_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
    $('#txt_date').datetimepicker({ format:'d-m-Y H:i' });
    $('#gcurrency_code1').select2();
    /////////// Calculations for tour amount cal ///////////////////////////
    function tour_cost_calculate_u1()
    {
        var adult_expense = $('#txt_adult_expense').val();  
        var child_b_expense = $('#txt_child_bed_expense').val();
        var child_wb_expense = $('#txt_child_wbed_expense').val();
        var infant_expense = $('#txt_infant_expense').val();

        if(adult_expense==""){ adult_expense = 0;}
        if(child_b_expense==""){ child_b_expense = 0;}
        if(child_wb_expense==""){ child_wb_expense = 0;}
        if(infant_expense==""){infant_expense = 0;}
    // console.log(adult_expense +' '+child_b_expense+' '+child_wb_expense+' '+infant_expense);
        var total = parseFloat(adult_expense) + parseFloat(child_b_expense) + parseFloat(child_wb_expense) + parseFloat(infant_expense);

        $('#txt_total_expense').val(total.toFixed(2));
        
        $('#txt_total_tour_fee').val(total.toFixed(2));
        $('#txt_tour_fee').val(total.toFixed(2));
        $('#txt_total_tour_fee1').val(total.toFixed(2));
        calculate_total_discount(id);
    }
    function switch_back_tab_2()
    {
        $('#tab_3_head').removeClass('active');
        $('#tab_2_head').addClass('active');
        $('.bk_tab').removeClass('active');
        $('#tab_2').addClass('active');
        $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
    }
</script>
<script src="../js/booking_update.js"></script>
