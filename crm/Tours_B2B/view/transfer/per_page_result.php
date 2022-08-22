<?php
include '../../../model/model.php';
$transfer_results_array = ($_POST['data']!='')?$_POST['data']:[];
?>
<!-- ***** Transfer Listing ***** -->
<?php
if(sizeof($transfer_results_array)>0){
    for($transfer_i=0;$transfer_i<sizeof($transfer_results_array);$transfer_i++){
?>
<!-- ***** Car Card ***** -->
<div class="c-cardList type-transfer">
    <div class="c-cardListTable">
    <!-- *** Car Card image *** -->
    <div class="cardList-image">
        <img src="<?= $transfer_results_array[$transfer_i]['transfer_image'] ?>" loading="lazy" alt="iTours" />
        <input type="hidden" value="<?= $transfer_results_array[$transfer_i]['transfer_image'] ?>" id="image-<?= $transfer_results_array[$transfer_i]['vehicle_id'] ?>"/>
        <div class="typeOverlay">
        <span class="transferType c-hide">
            AC
        </span>
        </div>
    </div>
    <!-- *** Car Card image End *** -->

    <!-- *** Car Card Info *** -->
    <div class="cardList-info">
        <div class="dividerSection type-1 noborder">
        <div class="divider s1">
            <h4 class="cardTitle"><span id="vehicle_name-<?= $transfer_results_array[$transfer_i]['vehicle_id'] ?>"><?= $transfer_results_array[$transfer_i]['vehicle_name'] ?></span>
            <span class="tag" id="vehicle_type-<?=$transfer_results_array[$transfer_i]['vehicle_id']?>"><?= $transfer_results_array[$transfer_i]['vehicle_type'] ?></span>
            </h4>
            <div class="infoSection">
            <span class="cardInfoLine cust">
                <i class="icon itours-user"></i>
                Max Pax(s): <strong><?= $transfer_results_array[$transfer_i]['seating_capacity'] ?></strong>
            </span>
            </div>

            <div class="infoSection">
            <span class="cardInfoLine cust">
                <i class="icon itours-suitcase"></i>
                Max Luggage: <strong><?= $transfer_results_array[$transfer_i]['luggage'] ?></strong>
            </span>
            </div>

            <div class="infoSection">
            <span class="cardInfoLine cust">
                <i class="icon itours-clock"></i>
                Service Duration: <strong><?= $transfer_results_array[$transfer_i]['service_duration'] ?></strong>
            </span>
            </div>

            <div class="infoSection">
            <span class="cardInfoLine cust">
                <i class="icon itours-taxi"></i>
                No. of vehicles: <strong id="vehicle_count-<?=$transfer_results_array[$transfer_i]['vehicle_id']?>"><?= $transfer_results_array[$transfer_i]['vehicle_count'] ?></strong>
            </span>
            </div>

        </div>

        <div class="divider s2">
            <div class="priceTag">
            <div class="p-old">
                <span class="o_lbl">Total Price</span>
                <span class="price_main">
                <span class="p_currency currency-icon"></span>
                <span class="p_cost transfer-currency-price"><?= $transfer_results_array[$transfer_i]['total_cost'] ?></span>
                <span class="c-hide transfer-currency-id"><?= $transfer_results_array[$transfer_i]['currency_id'] ?></span>
                </span><small>(exclusive of all taxes)</small>
                <input type="hidden" id="transfer-<?= $transfer_results_array[$transfer_i]['vehicle_id'] ?>" value='<?php echo $transfer_results_array[$transfer_i]['total_cost'].'-'.$transfer_results_array[$transfer_i]['currency_id'] ?>'>
                <input type="hidden" id="taxation-<?= $transfer_results_array[$transfer_i]['vehicle_id'] ?>" value="<?php echo ($transfer_results_array[$transfer_i]['taxation'][0]['taxation_type']).'-'.($transfer_results_array[$transfer_i]['taxation'][0]['service_tax']) ?>"/>
            </div>
            </div>
            <button class="c-button md" id='<?=$transfer_results_array[$transfer_i]['vehicle_id']?>' onclick="add_to_cart('<?=$transfer_results_array[$transfer_i]['vehicle_id']?>','transfer');"><i class="icon it itours-shopping-cart"></i> Add To Cart</button>
        </div>
        </div>

    </div>
    <!-- *** Car Card Info End *** -->
    </div>

</div>
<!-- ***** Car Card End ***** -->

<?php }
} ?>
<!-- ***** Transfer Listing End ***** -->
<script>
setTimeout(() => {
      var amount_list = document.querySelectorAll(".transfer-currency-price");
      var amount_id = document.querySelectorAll(".transfer-currency-id");

      //Hotel Best Cost
      var amount_arr = [];
      for(var i=0;i<amount_list.length;i++){
        amount_arr.push({
            'amount':amount_list[i].innerHTML,
            'id':amount_id[i].innerHTML});
      }
      sessionStorage.setItem('transfer_amount_list',JSON.stringify(amount_arr));
      transfer_page_currencies();
      
      var vehicle_type_array = JSON.parse(document.getElementById('vehicle_type_array').value);
      var selected_vehicle_type_array = (document.getElementById('selected_vehicle_type_array').value).split(',');
      var html = '';
      for(var i=0;i<vehicle_type_array.length;i++){
        var checked_status = (selected_vehicle_type_array.includes(vehicle_type_array[i])) ? 'checked' : '';
        html += '<li><div class="checFilterOpt"><input name="vehicle_type" type="checkbox" id="'+(i+1)+'" class="filterChk" value="'+vehicle_type_array[i]+'" '+checked_status+'/><label for="'+(i+1)+'" class="lblfilterChk">'+vehicle_type_array[i]+'</label></div></li>';
      }
      $('#vehicle_types').html(html);
    
}, 500);
</script>