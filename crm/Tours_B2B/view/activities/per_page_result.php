<?php
include '../../../model/model.php';
global $currency;
$b2b_currency = $_SESSION['session_currency_id'];
$activity_result_array = ($_POST['data']!='')?$_POST['data']:[];
$coupon_list_arr = array();
$coupon_info_arr= array();
if(sizeof($activity_result_array)>0){
    for($i=0;$i<sizeof($activity_result_array);$i++){
    $h_currency_id = $activity_result_array[$i]['currency_id'];
?>
<!-- ***** Activity Card ***** -->
<div class="c-cardList type-hotel">
    <div class="c-cardListTable" role="button" data-toggle="collapse" href="#collapseExample<?= $activity_result_array[$i]['exc_id']?>"
      aria-expanded="false" aria-controls="collapseExample">
      <!-- *** Activity Card image *** -->
      <div class="cardList-image">
        <img src="<?php echo $activity_result_array[$i]['image'] ?>" alt="iTours" />
        <input type="hidden" value="<?= $activity_result_array[$i]['image'] ?>" id="image-<?= $activity_result_array[$i]['exc_id'] ?>"/>
        <div class="typeOverlay"></div>
        <div class="c-discount c-hide" id='discount<?= $activity_result_array[$i]['exc_id'] ?>'>
            <div class="discount-text">
                <span class="currency-icon"></span>
                <span class='offer-currency-price' id="offer-currency-price<?= $activity_result_array[$i]['exc_id'] ?>"></span>&nbsp;&nbsp;<span id='discount_text<?= $activity_result_array[$i]['exc_id'] ?>'></span>
                <span class='c-hide offer-currency-id' id="offer-currency-id<?= $activity_result_array[$i]['exc_id'] ?>"></span>
                <span class='c-hide offer-currency-flag' id="offer-currency-flag<?= $activity_result_array[$i]['exc_id'] ?>"></span>
            </div>
        </div>
      </div>
      <!-- *** Activity Card image End *** -->

      <!-- *** Activity Card Info *** -->
      <div class="cardList-info" role="button">
        <button class="expandSect">Read More...</button>
        <div class="dividerSection type-1 noborder">
          <div class="divider s1">
            <h4 class="cardTitle" id="act_name-<?= $activity_result_array[$i]['exc_id'] ?>"><?php echo $activity_result_array[$i]['excursion_name'] ?></h4>

            <div class="infoSection">
              <span class="cardInfoLine cust">
                <i class="icon itours-clock"></i>
                Reporting Time: <strong id="rep_time-<?= $activity_result_array[$i]['exc_id'] ?>"><?php echo $activity_result_array[$i]['rep_time'] ?></strong>
              </span>
              <span class="cardInfoLine cust">
                <i class="icon itours-hour-glass"></i>
                Duration: <strong><?php echo $activity_result_array[$i]['duration'] ?></strong>
              </span>
            </div>

            <div class="infoSection">
              <span class="cardInfoLine cust">
                <i class="icon itours-pin-alt"></i>
                Pickup Point: <strong id="pick_point-<?= $activity_result_array[$i]['exc_id'] ?>"><?php echo $activity_result_array[$i]['departure_point'] ?></strong>
              </span>
            </div>

            <div class="infoSection">
              <span class="cardInfoLine cust">
                <i class="icon itours-align-left"></i>
                <span class="cardDescription">
                <?php echo substr($activity_result_array[$i]['description'],0,100) ?>
                </span>
              </span>
            </div>

          </div>

          <div class="divider s2">
            <div class="priceTag">
              <?php if($activity_result_array[$i]['best_org_cost']['org_cost'] != $activity_result_array[$i]['best_lowest_cost']['cost']) { ?>
                <div class="p-old" id="p-old-div<?= $activity_result_array[$i]['exc_id'] ?>">
                    <span class="o_lbl">Old Price</span>
                    <span class="o_price">
                    <span class="p_currency currency-icon"></span>
                    <span class="p_cost best-activity-orgamount"><?= $activity_result_array[$i]['best_org_cost']['org_cost']?></span>
                    <span class="c-hide best-activity-orgcurrency-id"><?= $h_currency_id ?></span>
                    </span>
                </div>
              <?php } ?>
              <div class="p-old">
                <span class="o_lbl">New Price</span>
                <span class="price_main">
                  <span class="p_currency currency-icon"></span>
                  <span class="p_cost best-activity-amount"><?= $activity_result_array[$i]['best_lowest_cost']['cost']?></span>
                  <span class="c-hide best-activity-currency-id"><?= $h_currency_id ?></span>
                </span>
                <small>per day</small>
              </div>

            </div>
          </div>
        </div>


      </div>
      <!-- *** Activity Card Info End *** -->
    </div>

    <!-- *** Activity Details Accordian *** -->
    <div class="collapse" id="collapseExample<?= $activity_result_array[$i]['exc_id']?>">
      <div class="cardList-accordian">
        <!-- ***** Activity Info Tabs ***** -->
        <div class="c-compTabs">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                aria-controls="home" aria-selected="true">Transfer Types</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="description-tab" data-toggle="tab" href="#description<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                aria-controls="description" aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="incl-tab" data-toggle="tab" href="#incl<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                aria-controls="incl" aria-selected="true">Inclusions/Exclusions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-gallery" id="termsTab" data-toggle="tab" href="#terms<?= $activity_result_array[$i]['exc_id']?>"
                role="tab" aria-controls="terms" aria-selected="true">Terms & Conditions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="policies-tab" data-toggle="tab" href="#policies<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                aria-controls="policies" aria-selected="true">Policies</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">
            <!-- **** Tab Activity Listing **** -->
            <div class="tab-pane fade show active" id="home<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="home-tab">
            <?php
            $original_costs_array = array();
            $text = '';
            for($ti=0;$ti<sizeof($activity_result_array[$i]['transfer_options']);$ti++){

                $room_cost = $activity_result_array[$i]['transfer_options'][$ti]['total_cost'];
                $org_cost = $activity_result_array[$i]['transfer_options'][$ti]['org_cost'];
                $coupon_offer = 0;

                if($activity_result_array[$i]['transfer_options'][$ti]['offer_type'] != ''){

                  $offer_amount = $activity_result_array[$i]['transfer_options'][$ti]['offer_amount'];
                  if($activity_result_array[$i]['transfer_options'][$ti]['offer_type'] == 'Offer'){

                    if($activity_result_array[$i]['transfer_options'][$ti]['offer_in'] == 'Percentage'){
                        $text = '%';
                    }
                    else{
                        $text = '';
                        if($currency != $b2b_currency){
                            $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
                            $from_currency_rate = $sq_from['currency_rate'];
                            $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$b2b_currency'"));
                            $to_currency_rate = $sq_to['currency_rate'];
                            $coupon_offer = ($to_currency_rate != '') ? $from_currency_rate / $to_currency_rate * $offer_amount : 0;
                        }else{
                            $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
                            $from_currency_rate = $sq_from['currency_rate'];
                            $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                            $to_currency_rate = $sq_to['currency_rate'];
                            $coupon_offer = $offer_amount;
                        }
                        $offer_amount = $coupon_offer;
                    }
                  }
                  else if($activity_result_array[$i]['transfer_options'][$ti]['offer_type'] == 'Coupon'){

                    if($activity_result_array[$i]['transfer_options'][$ti]['offer_in'] == 'Percentage'){
                        $text = '%';
                    }
                    else{
                        $text = '';
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$b2b_currency'"));
                        $to_currency_rate = $sq_to['currency_rate'];
                        $coupon_offer = ($to_currency_rate != '') ? $from_currency_rate / $to_currency_rate * $offer_amount : 0;
                        $offer_amount = $coupon_offer;
                    }
                  }
                  $offer_text = $text.' '.$activity_result_array[$i]['transfer_options'][$ti]['offer_type'];
                }
                else{
                    $offer_text = '';
                }
                array_push($original_costs_array,$org_cost);
                if($activity_result_array[$i]['transfer_options'][$ti]['offer_type'] == 'Coupon' && $activity_result_array[$i]['transfer_options'][$ti]['coupon_code'] != ""){
                  $arr = array(
                    'offer_in'=>$activity_result_array[$i]['transfer_options'][$ti]['offer_in'],
                    'offer_amount'=>$offer_amount,
                    'coupon_code'=>$activity_result_array[$i]['transfer_options'][$ti]['coupon_code'],
                    'agent_type'=>$activity_result_array[$i]['transfer_options'][$ti]['agent_type'],
                    'currency_id'=>$currency
                  );
                  array_push($coupon_info_arr, $arr);
                }
                $coupon_list_arr['coupon_info_arr'] = $coupon_info_arr;
            ?>
            <script>
                setTimeout(function(){
                    //Offer red strip display
                    if('<?= $offer_text ?>' != ''){

                        document.getElementById("discount<?= $activity_result_array[$i]['exc_id'] ?>").classList.remove("c-hide");
                        document.getElementById("discount<?= $activity_result_array[$i]['exc_id'] ?>").classList.add("c-show");
                        
                        document.getElementById("offer-currency-price<?= $activity_result_array[$i]['exc_id'] ?>").innerHTML= '<?= number_format($offer_amount,2) ?>';
                        document.getElementById("offer-currency-id<?= $activity_result_array[$i]['exc_id'] ?>").innerHTML= '<?= $currency ?>';
                        document.getElementById("offer-currency-flag<?= $activity_result_array[$i]['exc_id'] ?>").innerHTML= '<?= 'no' ?>';
                        document.getElementById("discount_text<?= $activity_result_array[$i]['exc_id'] ?>").innerHTML='<?= $offer_text ?>';
                    }else{
                        document.getElementById("discount<?= $activity_result_array[$i]['exc_id'] ?>").classList.add("c-hide");
                    } 
                      
                    if('<?= $activity_result_array[$i]['best_org_cost']['org_cost'] ?>' != '<?= $activity_result_array[$i]['best_lowest_cost']['cost'] ?>') {
                      if('<?= $org_cost ?>' == '<?= $room_cost ?>'){  
                        document.getElementById("p-old-div<?= $activity_result_array[$i]['exc_id'] ?>").classList.add("c-hide");
                      }
                    }
                }, 50);
            </script>
              <!-- ***** Activity List Card ***** -->
              <div class="c-cardListHolder">
                <div class="c-cardListTable type-2" role="button">
                  <input class="btn-radio" type="radio" id="<?= $activity_result_array[$i]['exc_id'].$ti ?>" name="result<?=$activity_result_array[$i]['exc_id'] ?>" value='<?php echo $activity_result_array[$i]['transfer_options'][$ti]['transfer_option'].'-'.$room_cost.'-'.$h_currency_id ?>'>
                  <input type="hidden" id="coupon-<?=$activity_result_array[$i]['exc_id'] ?>" value='<?php echo json_encode($coupon_list_arr); ?>'>
                  <!-- *** Activity Card Info *** -->
                  <label class="cardList-info" for="<?= $activity_result_array[$i]['exc_id'].$ti ?>" role="button">
                    <div class="flexGrid">
                      <div class="gridItem">
                        <div class="infoCard">
                          <span class="infoCard_data"><?php echo $activity_result_array[$i]['transfer_options'][$ti]['transfer_option'] ?></span>
                        </div>
                      </div>
                      <?php
                      if($org_cost !=0 && $org_cost != $room_cost){ ?>
                      <div class="gridItem">
                        <div class="infoCard m0">
                          <div class="M-infoCard">
                            <span class="infoCard_label">OLD PRICE</span>
                            <div class="infoCard_price strike">
                              <span class="p_currency currency-icon"></span>
                              <span class="p_cost activity-orgcurrency-price"><?= $org_cost ?></span>
                              <span class="c-hide activity-orgcurrency-id"><?= $h_currency_id ?></span>
                            </div>
                            <span class="infoCard_priceTax">(exclusive of all taxes)</span>
                          </div>
                        </div>
                      </div>
                      <?php } ?>

                      <div class="gridItem">
                        <div class="infoCard m0">
                          <div class="M-infoCard">
                            <span class="infoCard_label">New Price</span>
                            <div class="infoCard_price">
                              <span class="p_currency currency-icon"></span>
                              <span class="p_cost activity-currency-price"><?= $room_cost ?></span>
                              <span class="c-hide activity-currency-id"><?= $h_currency_id ?></span>
                            </div>
                            <span class="infoCard_priceTax">(exclusive of all taxes)</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </label>
                  <!-- *** Activity Card Info End *** -->
                </div>
              </div>
              <!-- ***** Activity List Card End ***** -->
            <?php } ?>  

              <div class="clearfix text-right">
                <button class="c-button md" onclick="add_to_cart('<?= $activity_result_array[$i]['exc_id'] ?>','Activity');"><i class="icon it itours-shopping-cart"></i> Add To Cart</button>
              </div>

            </div>
            <!-- **** Tab Activity Listing End **** -->

            <!-- **** Tab Description **** -->
            <div class="tab-pane fade" id="description<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="description-tab">
              <!-- **** Description **** -->
              <div class="clearfix margin20-bottom">

                <h3 class="c-heading">
                  Description
                </h3>
                <p class="c-statictext">
                    <?= $activity_result_array[$i]['description'];?>
                </p>
                <h3 class="c-heading">
                  Note
                </h3>
                <p class="c-statictext">
                <?= $activity_result_array[$i]['note']?>
                </p>
              </div>
              <!-- **** Description End **** -->
            </div>
            <!-- **** Tab Description End **** -->

            <!-- **** Tab Incl **** -->
            <div class="tab-pane fade" id="incl<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="incl-tab">
              <!-- **** Incl/Excl **** -->
              <div class="clearfix margin20-bottom">

                <h3 class="c-heading">
                  Inclusions
                </h3>
                <div class="custom_texteditor">
                    <?= $activity_result_array[$i]['inclusions']?>
                </div>
                <h3 class="c-heading">
                  Exclusions
                </h3>
                <div class="custom_texteditor">
                  <?= $activity_result_array[$i]['exclusions']?>
                </div>
              </div>
              <!-- **** Incl/Excl End **** -->
            </div>
            <!-- **** Tab Incl End **** -->

            <!-- **** Tab Terms **** -->
            <div class="tab-pane fade" id="terms<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="terms-tab">
              <!-- **** Terms **** -->
              <div class="clearfix margin20-bottom">

                <h3 class="c-heading">
                  Terms & Conditions
                </h3>
                <div class="custom_texteditor">
                    <?= $activity_result_array[$i]['terms_condition']?>
                </div>
                <h3 class="c-heading">
                  Usefull Information
                </h3>
                <div class="custom_texteditor">
                <?= $activity_result_array[$i]['useful_info']?>
                </div>
              </div>
              <!-- **** Terms End **** -->
            </div>
            <!-- **** Tab Terms End **** -->

            <!-- **** Tab Policies **** -->
            <div class="tab-pane fade" id="policies<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="policies-tab">
              <!-- **** Policies **** -->
              <div class="clearfix margin20-bottom">

                <h3 class="c-heading">
                  Booking Policy
                </h3>
                <div class="custom_texteditor">
                    <?= $activity_result_array[$i]['booking_policy']?>
                </div>
                <h3 class="c-heading">
                  Cancellation Policy
                </h3>
                <div class="custom_texteditor">
                <?= $activity_result_array[$i]['canc_policy']?>
                </div>
              </div>
              <!-- **** Policies End **** -->
              </div>

          </div>
        </div>
        <!-- ***** Activity Info Tabs End***** -->
      </div>
    </div>
    <!-- *** Activity Details Accordian End *** -->
    <input type="hidden" id="taxation-<?= $activity_result_array[$i]['exc_id'] ?>" value="<?php echo ($activity_result_array[$i]['taxation'][0]['taxation_type']).'-'.($activity_result_array[$i]['taxation'][0]['service_tax']) ?>"/>
  </div>
  <!-- ***** Activity Card End ***** -->
    <?php
    }
} //Activity arrays for loop
?>
<script>
$(document).ready(function () {

    clearTimeout(b);
    var b = setTimeout(function() {

      var bestorg_price_list = document.querySelectorAll(".best-activity-orgamount");
      var bestorg_price_cid = document.querySelectorAll(".best-activity-orgcurrency-id");

      var trans_price_list = document.querySelectorAll(".best-activity-amount");
      var trans_price_cid = document.querySelectorAll(".best-activity-currency-id");

      var amount_list = document.querySelectorAll(".activity-currency-price");
      var amount_id = document.querySelectorAll(".activity-currency-id");

      var original_amt_list = document.querySelectorAll(".activity-orgcurrency-price");
      var original_amt_id = document.querySelectorAll(".activity-orgcurrency-id");

      var offer_price_list = document.querySelectorAll(".offer-currency-price");
      var offer_price_id = document.querySelectorAll(".offer-currency-id");
      var offer_currency_flag = document.querySelectorAll(".offer-currency-flag");
      
      //Best low org cost prices
      var roomAmount_arr = [];
      for(var i=0;i<bestorg_price_list.length;i++){
        roomAmount_arr.push({
            'amount':bestorg_price_list[i].innerHTML,
            'id':bestorg_price_cid[i].innerHTML});
      }
      sessionStorage.setItem('bestorg_price_list',JSON.stringify(roomAmount_arr));

      //Best low cost prices
      var roomAmount_arr = [];
      for(var i=0;i<trans_price_list.length;i++){
        roomAmount_arr.push({
            'amount':trans_price_list[i].innerHTML,
            'id':trans_price_cid[i].innerHTML});
      }
      sessionStorage.setItem('trans_price_list',JSON.stringify(roomAmount_arr));

      //Activity Best Cost
      var amount_arr = [];
      for(var i=0;i<amount_list.length;i++){
        amount_arr.push({
            'amount':amount_list[i].innerHTML,
            'id':amount_id[i].innerHTML});
      }
      sessionStorage.setItem('transfer_amount_list',JSON.stringify(amount_arr));

      //Activity Original Cost
      var orgAmount_arr = [];
      for(var i=0;i<original_amt_list.length;i++){
        orgAmount_arr.push({
            'amount':original_amt_list[i].innerHTML,
            'id':original_amt_id[i].innerHTML});
      }
      sessionStorage.setItem('orgtransfer_amount_list',JSON.stringify(orgAmount_arr));

      //Activity Offer Cost
      var offerAmount_arr = [];
      for(var i=0;i<offer_price_list.length;i++){
        offerAmount_arr.push({
            'amount':offer_price_list[i].innerHTML,
            'id':offer_price_id[i].innerHTML,
            'flag':offer_currency_flag[i].innerHTML});
      }
      sessionStorage.setItem('transferoffer_price_list',JSON.stringify(offerAmount_arr));

      activties_page_currencies();
    },500);
});
</script>