<?php
include '../../../../model/model.php';
$quotation_id = $_GET['quotation_id'];
$readonly = ($quotation_id != '') ? 'disabled' : '';

?>
<select class="form-control" name="currency_code" id="hcurrency_code" title="Currency" style="width:100%" data-toggle="tooltip" required <?=$readonly?>>
    <?php
    if(($quotation_id != '')){

        $sq_currencyd = mysqli_fetch_assoc(mysqlQuery("SELECT `currency_code` FROM `hotel_quotation_master` WHERE quotation_id='$quotation_id'"));
        $sq_app_setting = mysqli_fetch_assoc(mysqlQuery("SELECT id FROM `currency_name_master` WHERE id=" . $sq_currencyd['currency_code']));
        $q_currency = $sq_app_setting['id'];
    }else{

        $sq_app_setting = mysqli_fetch_assoc(mysqlQuery("select currency from app_settings"));
        $q_currency = $sq_app_setting['currency'];
    }
    if($q_currency!=''){

        $sq_currencyd = mysqli_fetch_assoc(mysqlQuery("SELECT `id`,`currency_code` FROM `currency_name_master` WHERE id=" . $q_currency));
        ?>
        <option value="<?= $sq_currencyd['id'] ?>"><?= $sq_currencyd['currency_code'] ?></option>
    <?php } ?>
    <?php
    $sq_currency = mysqlQuery("select * from currency_name_master order by currency_code");
    while($row_currency = mysqli_fetch_assoc($sq_currency)){
    ?>
    <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
    <?php } ?>
</select>
<script>
$('#hcurrency_code').select2();
</script>