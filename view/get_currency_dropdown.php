<?php
include '../crm/model/model.php';
$currency_id = $_POST['currency_id'];
$_SESSION['session_currency_id'] = $currency_id;
if($currency_id == ''){
    $g_currency = mysqli_fetch_assoc(mysqlQuery("select currency from app_settings"));
    $currency_id = $g_currency['currency'];
}
?>           

<div class="c-select2DD st-clear">
    <select title='Select Currency' id='currency' name='currency' onchange='get_selected_currency()'>
        <?php $sq_curr = mysqli_fetch_assoc(mysqlQuery("select id,currency_code from currency_name_master where id='$currency_id'")); ?>
        <option value='<?= $sq_curr['id'] ?>'><?= $sq_curr['currency_code'] ?></option>
        <?php $sq_currency = mysqlQuery("select * from currency_name_master where id!='$currency_id' order by currency_code");
        while($row_currency = mysqli_fetch_assoc($sq_currency)){
        ?>
        <option value='<?= $row_currency['id'] ?>'><?= $row_currency['currency_code'] ?></option>
        <?php } ?>
    </select>
</div>

<script>
$(function(){
    if ($('.c-select2DD.st-clear').length){
        $('.c-select2DD.st-clear select').select2();
    }
})
</script>