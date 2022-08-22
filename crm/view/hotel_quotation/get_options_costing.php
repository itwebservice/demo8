<?php
include "../../model/model.php";
$nofquotation = $_REQUEST['nofquotation'];
$hotelcostArr = $_REQUEST['hotelcostArr'];

for($quot=1; $quot <= $nofquotation; $quot++){
?>

    <div class="row mg_tp_10">
        <div class="col-xs-12">
            <h3 class="editor_title">Option-<?= $quot ?> Costing</h3>
            <div class="panel panel-default panel-body app_panel_style">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table id="dynamic_quotation_costing_h_<?= $quot ?>">

                                <td class="header_btn header_btn" style="padding:4px"><small style="color:red" id="basic_show-<?= $quot ?>">&nbsp;</small><input type="number" id="basic_cost-<?= $quot ?>" name="basic_cost-<?= $quot ?>" placeholder="Hotel Cost" title="Hotel Cost" value="<?= $hotelcostArr[$quot-1] ?>"  onchange="validate_balance(this.id);get_auto_values('quotation_date','basic_cost-<?= $quot ?>','payment_mode','service_charge-<?= $quot ?>','markup_cost-<?= $quot ?>','save','true','service_charge', true)"> </td>

                                <td class="header_btn header_btn" style="padding:4px"><small style="color:red" id="service_show-<?= $quot ?>">&nbsp;</small><input type="number" id="service_charge-<?= $quot ?>" name="service_charge-<?= $quot ?>" placeholder="Service Charge" title="Service Charge"   onchange="validate_balance(this.id);get_auto_values('quotation_date','basic_cost-<?= $quot ?>','payment_mode','service_charge-<?= $quot ?>','markup_cost-<?= $quot ?>','save','true','service_charge', true)"></td>

                                <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="text" id="tax_amount-<?= $quot ?>" name="tax_amount-<?= $quot ?>" placeholder="Tax Amount" title="Tax Amount"   onchange="validate_balance(this.id)" readonly> </td>

                                <td class="header_btn header_btn" style="padding:4px"><small style="color:red" id="markup_show-<?= $quot ?>">&nbsp;</small><input type="number" id="markup_cost-<?= $quot ?>" name="markup_cost-<?= $quot ?>" placeholder="Markup Cost" title="Markup Cost"   onchange="validate_balance(this.id);get_auto_values('quotation_date','basic_cost-<?= $quot ?>','payment_mode','service_charge-<?= $quot ?>','markup_cost-<?= $quot ?>','save','false','service_charge', true)" > </td>

                                <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="text" id="tax_markup-<?= $quot ?>" name="tax_markup-<?= $quot ?>" placeholder="Markup Tax" title="Markup Tax"   onchange="validate_balance(this.id)" readonly> </td>

                                <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="number" id="roundoff-<?= $quot ?>" class="form-control" name="total_amount-<?= $quot ?>" placeholder="Round Off" title="Round Off" readonly> </td>

                                <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="number" id="total_amount-<?= $quot ?>" class="amount_feild_highlight text-right form-control" name="total_amount-<?= $quot ?>" placeholder="Total Amount" title="Total Amount"   onchange="validate_balance(this.id)" readonly> </td>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $('#basic_cost-<?= $quot ?>').trigger('change');
</script>
<?php } ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>