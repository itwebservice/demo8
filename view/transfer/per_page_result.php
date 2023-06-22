<?php
include '../../config.php';
$transfer_results_array = ($_POST['data']!='')?$_POST['data']:[];
?>
<!-- ***** Transfer Listing ***** -->
<?php
if(sizeof($transfer_results_array)>0){
    for($transfer_i=0;$transfer_i<sizeof($transfer_results_array);$transfer_i++){

        $trans_enq_data = array();
        $vehicle_name = $transfer_results_array[$transfer_i]['vehicle_name'];
        $vehicle_type = $transfer_results_array[$transfer_i]['vehicle_type'];
        $trip_type = $transfer_results_array[$transfer_i]['trip_type'];
        $pickup = $transfer_results_array[$transfer_i]['pickup'];
        $pickup_date = $transfer_results_array[$transfer_i]['pickup_date'];
        $drop = $transfer_results_array[$transfer_i]['drop'];
        $return_date = ($trip_type == 'roundtrip') ? $transfer_results_array[$transfer_i]['return_date'] : 'NA';
        $passengers = $transfer_results_array[$transfer_i]['passengers'];

        array_push($trans_enq_data,array('vehicle_name'=>$vehicle_name,'vehicle_type'=>$vehicle_type,'trip_type'=>$trip_type,'pickup'=>$pickup,'pickup_date'=>$pickup_date,'drop'=>$drop,'return_date'=>$return_date,'passengers'=>$passengers));
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
                <span class="o_lbl"></span>
                <span class="price_main">
                <span class="p_currency currency-icon"></span>
                <span class="p_cost"><?= 'Price On Request' ?></span>
            </div>
            </div>
            <button type="button" class="c-button md" id='<?=$transfer_results_array[$transfer_i]['vehicle_id']?>' onclick='enq_to_action_page("5",this.id,<?= json_encode($trans_enq_data)?>)'><i class="fa fa-phone-square" aria-hidden="true"></i>  Enquiry</button>
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

    // transfer_page_currencies();
    
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