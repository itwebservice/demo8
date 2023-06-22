<?php
$tours_result_array = ($_POST['data'] != NULL) ? $_POST['data'] : [];
$coupon_list_arr = array();
$coupon_info_arr = array();
if (sizeof($tours_result_array) > 0) {

  for ($i = 0; $i < sizeof($tours_result_array); $i++) {

    $h_currency_id = $tours_result_array[$i]['currency_id'];
    $adult_count = $tours_result_array[$i]['adult_count'];
    $child_wocount = $tours_result_array[$i]['child_wocount'];
    $child_wicount = $tours_result_array[$i]['child_wicount'];
    $extra_bed_count = $tours_result_array[$i]['extra_bed_count'];
    $infant_count = $tours_result_array[$i]['infant_count'];
    $travel_date = $tours_result_array[$i]['travel_date'];
    $sp_cost = $tours_result_array[$i]['sp_cost_total'];

    $total_pax = intval($adult_count) + intval($child_wocount) + intval($child_wicount) + intval($extra_bed_count) + intval($infant_count);
    $adult_cost = ($total_pax > 1 ) ? floatval($tours_result_array[$i]['adult_cost']) : $sp_cost;
?>
    <input type="hidden" id="tour_id-<?= $tours_result_array[$i]['tour_id'] ?>" value="<?= $tours_result_array[$i]['tour_id'] ?>">
    <input type="hidden" id="group_id-<?= $tours_result_array[$i]['tour_id'] ?>" value="<?= $tours_result_array[$i]['group_id'] ?>">
    <input type="hidden" id="adult_count" value="<?= $adult_count ?>" />
    <input type="hidden" id="child_wocount" value="<?= $child_wocount ?>" />
    <input type="hidden" id="child_wicount" value="<?= $child_wicount ?>" />
    <input type="hidden" id="extra_bed_count" value="<?= $extra_bed_count ?>" />
    <input type="hidden" id="infant_count" value="<?= $infant_count ?>" />
    <input type="hidden" id="travel_date" value="<?= $travel_date ?>" />
    <!-- ***** Tours Card ***** -->
    <div class="c-cardList type-hotel">
      <div class="c-cardListTable">
        <!-- *** Tours Card image *** -->
        <div class="cardList-image">
          <img src="<?= $tours_result_array[$i]['image'] ?>" alt="iTours" />
          <input type="hidden" value="<?= $tours_result_array[$i]['image'] ?>" id="image-<?= $tours_result_array[$i]['tour_id'] ?>" />
          <div class="typeOverlay">
          </div>
        </div>
        <!-- *** Tours Card image End *** -->
        <!-- *** Tours Card Info *** -->
        <div class="cardList-info" role="button">
          <button class="expandSect">View Details</button>
          <div class="dividerSection type-1 noborder">
            <div class="divider s1" role="button" data-toggle="collapse" href="#collapseExample<?= $tours_result_array[$i]['tour_id'] ?>" aria-expanded="false" aria-controls="collapseExample">
              <h4 class="cardTitle"><span id="tour-<?= $tours_result_array[$i]['tour_id'] ?>"><?= $tours_result_array[$i]['tour_name'] ?></span>
              </h4>

              <div class="infoSection">
                <span class="cardInfoLine">
                  <?= $tours_result_array[$i]['dest_name'] ?>
                </span>
              </div>

              <div class="infoSection">
                <span class="cardInfoLine cust">
                  <i class="icon it itours-calendar"></i>
                  <?= $tours_result_array[$i]['travel_date'] ?>
                  <input type="hidden" value="<?= $tours_result_array[$i]['travel_date'] ?>" id="tour_date-<?= $tours_result_array[$i]['tour_id'] ?>" />
                </span>
              </div>

            </div>

            <div class="divider s2">
              <div class="priceTag">
                <div class="p-old">
                  <span class="o_lbl">Total Price(PP)</span>
                  <span class="price_main">
                    <span class="p_currency currency-icon"></span>
                    <span class="p_cost tours-currency-price" id="total_cost-<?= $tours_result_array[$i]['tour_id'] ?>"><?= $tours_result_array[$i]['total_cost'] ?></span>
                    <span class="c-hide tours-currency-id" id="h_currency_id-<?= $tours_result_array[$i]['tour_id'] ?>"><?= $h_currency_id ?></span>
                  </span>
                  <small>(exclusive of all taxes)</small>
                  <input type="hidden" id="tours-cost-<?= $tours_result_array[$i]['tour_id'] ?>" value='<?php echo $tours_result_array[$i]['total_cost'] . '-' . $h_currency_id ?>'>
                </div>
              </div>
            </div>
          </div>


        </div>
        <!-- *** Tours Card Info End *** -->
      </div>

      <!-- *** Tours Details Accordian *** -->
      <div class="collapse" id="collapseExample<?= $tours_result_array[$i]['tour_id'] ?>">
        <div class="cardList-accordian">
          <!-- ***** Tours Info Tabs ***** -->
          <div class="c-compTabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="itinerary-tab" data-toggle="tab" href="#itinerary-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tab" aria-controls="itinerary" aria-selected="true">Itinerary</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="travel-tab" data-toggle="tab" href="#travel-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tab" aria-controls="travel" aria-selected="true">Travel & Stay</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="inclusion-tab" data-toggle="tab" href="#inclusion-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tab" aria-controls="inclusion" aria-selected="true">INCLUSIONS/EXCLUSIONS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="costing-tab" data-toggle="tab" href="#costing-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tab" aria-controls="costing" aria-selected="true">Costing</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <!-- **** Tab costing **** -->
              <div class="tab-pane fade" id="costing-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tabpanel" aria-labelledby="costing-tab">

                <!-- **** Policies List **** -->
                <div class="clearfix m20-btm">
                  <div class="row">
                    <div class="col-12">
                      <div class="c-flexCards">

                        <div class="f_card">
                          <span class="currency_icon currency-icon"></span>
                          <span class="currency_amount adult_cost-currency-price"><?= floatval($adult_cost) / intval($adult_count) ?></span>
                          <span class="c-hide adult-currency-id"><?= $h_currency_id ?></span>
                          <span class="currency_for">For Adult (PP)</span>
                        </div>
                        <?php
                        if ($child_wocount > 0) { ?>
                          <div class="f_card">
                            <span class="currency_icon currency-icon"></span>
                            <span class="currency_amount childwio_cost-currency-price"><?= floatval($tours_result_array[$i]['child_wo_cost']) / intval($child_wocount) ?></span>
                            <span class="c-hide childwio-currency-id"><?= $h_currency_id ?></span>
                            <span class="currency_for">For Child Without Bed (PP)</span>
                          </div>
                        <?php } ?>
                        <?php
                        if ($child_wicount > 0) { ?>
                          <div class="f_card">
                            <span class="currency_icon currency-icon"></span>
                            <span class="currency_amount childwi_cost-currency-price"><?= floatval($tours_result_array[$i]['child_wi_cost']) / intval($child_wicount) ?></span>
                            <span class="c-hide childwi-currency-id"><?= $h_currency_id ?></span>
                            <span class="currency_for">For Child With Bed (PP)</span>
                          </div>
                        <?php } ?>
                        <?php
                        if ($extra_bed_count > 0) { ?>
                          <div class="f_card">
                            <span class="currency_icon currency-icon"></span>
                            <span class="currency_amount extrabed-currency-price"><?= floatval($tours_result_array[$i]['with_bed_cost']) / intval($extra_bed_count) ?></span>
                            <span class="c-hide extrabed-currency-id"><?= $h_currency_id ?></span>
                            <span class="currency_for">For Extra Bed (PP)</span>
                          </div>
                        <?php } ?>
                        <?php
                        if ($infant_count > 0) { ?>
                          <div class="f_card">
                            <span class="currency_icon currency-icon"></span>
                            <span class="currency_amount infant_cost-currency-price"><?= floatval($tours_result_array[$i]['infant_cost']) / intval($infant_count) ?></span>
                            <span class="c-hide infant_cost-currency-id"><?= $h_currency_id ?></span>
                            <span class="currency_for">For Infant (PP)</span>
                          </div>
                        <?php } ?>

                      </div>
                    </div>
                  </div>

                </div>
                <!-- **** Policies List End **** -->

              </div>
              <!-- **** Tab costing End **** -->

              <!-- **** Tab itenary **** -->
              <div class="tab-pane show active fade" id="itinerary-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tabpanel" aria-labelledby="itinerary-tab">

                <!-- **** Day Info List **** -->
                <div class="c-cardListInfo">
                  <div class="cardListInfo-row">
                    <!-- **** List **** -->
                    <?php for ($pi = 0; $pi < sizeof($tours_result_array[$i]['program_array']); $pi++) { ?>
                      <div class="ListInfo-col">

                        <div class="dayCount">
                          <span class="s1">DAY</span>
                          <span class="s2"><?= ($pi + 1) ?></span>
                        </div>

                        <div class="dayInfo">
                          <h5 class="h1"><?= $tours_result_array[$i]['program_array'][$pi]['attraction'] ?></h5>
                          <span class="staticText">
                            <?= $tours_result_array[$i]['program_array'][$pi]['day_wise_program'] ?>
                          </span>
                          <div class="itemList">
                            <span class="item">
                              <i class="icon it itours-bed"></i>
                              <?= $tours_result_array[$i]['program_array'][$pi]['stay'] ?>
                            </span>
                            <?php if ($tours_result_array[$i]['program_array'][$pi]['meal_plan'] != '') { ?>
                              <span class="item">
                                <i class="icon it itours-cutlery"></i>
                                <?= $tours_result_array[$i]['program_array'][$pi]['meal_plan'] ?>
                              </span>
                            <?php } ?>
                          </div>
                        </div>

                      </div>
                    <?php } ?>
                    <!-- **** List End **** -->
                  </div>
                </div>
                <!-- **** Day Info List **** -->
              </div>
              <!-- **** Tab itenary End **** -->

              <!-- **** Tab Tours Car **** -->
              <div class="tab-pane fade" id="travel-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tabpanel" aria-labelledby="travel-tab">
                <!-- **** Tab Hotel Car **** -->
                <div class="clearfix m20-btm">
                  <div class="row">
                    <div class="col-12 m20-btm">
                      <h3 class="c-heading">
                        Hotel Details
                      </h3>
                      <?php
                      $tours_result_array[$i]['hotels_array'] = ($tours_result_array[$i]['hotels_array']) ? $tours_result_array[$i]['hotels_array'] : [];
                      for ($hotel_i = 0; $hotel_i < sizeof($tours_result_array[$i]['hotels_array']); $hotel_i++) {
                      ?>
                        <!-- *** Hotel Card Info *** -->
                        <div class="c-cardListHolder">
                          <div class="c-cardListTable type-3">

                            <div class="cardList-info">
                              <div class="flexGrid">
                                <div class="gridItem">
                                  <div class="infoCard">
                                    <span class="infoCard_price"><?= $tours_result_array[$i]['hotels_array'][$hotel_i]['hotel'] ?></span>
                                    <span class="infoCard_data"><?= $tours_result_array[$i]['hotels_array'][$hotel_i]['city'] ?></span>
                                  </div>
                                </div>

                                <div class="gridItem">
                                  <div class="infoCard c-halfText m0">
                                    <span class="infoCard_label">Hotel Category</span>
                                    <span class="infoCard_price"><?= $tours_result_array[$i]['hotels_array'][$hotel_i]['hotel_type'] ?></span>
                                  </div>
                                </div>

                                <div class="gridItem styleForMobile M-m0">
                                  <div class="infoCard m5-btm">
                                    <span class="infoCard_label">Stay Duration</span>
                                    <span class="infoCard_price"><?= $tours_result_array[$i]['hotels_array'][$hotel_i]['nights'] ?> Nights</span>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                        <!-- *** Hotel Card Info End *** -->
                      <?php } ?>

                    </div>

                    <?php
                    $train_array = (isset($tours_result_array[$i]['train_array'])) ? $tours_result_array[$i]['train_array'] : [];
                    if (sizeof($train_array) > 0) { ?>
                      <div class="col-12 m20-btm">
                        <h3 class="c-heading">
                          Train Details
                        </h3>
                        <?php
                        for ($tr_i = 0; $tr_i < sizeof($train_array); $tr_i++) { ?>
                          <!-- *** Train Card Info *** -->
                          <div class="c-cardListHolder">
                            <div class="c-cardListTable type-3">

                              <div class="cardList-info">
                                <div class="flexGrid">
                                  <div class="gridItem">
                                    <div class="infoCard c-halfText m0">
                                      <span class="infoCard_label">From Location</span>
                                      <span class="infoCard_price"><?= $train_array[$tr_i]['from_location'] ?></span>
                                    </div>
                                  </div>

                                  <div class="gridItem styleForMobile M-m0">
                                    <div class="infoCard m5-btm">
                                      <span class="infoCard_label">To Location</span>
                                      <span class="infoCard_price"><?= $train_array[$tr_i]['to_location'] ?></span>
                                    </div>
                                  </div>
                                  <div class="gridItem styleForMobile M-m0">
                                    <div class="infoCard m5-btm">
                                      <span class="infoCard_label">Class</span>
                                      <span class="infoCard_price"><?= $train_array[$tr_i]['class'] ?></span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                          <!-- *** Train Card Info End *** -->
                        <?php } ?>
                      </div>
                    <?php } ?>

                    <?php
                    $tours_result_array[$i]['flight_array'] = (isset($tours_result_array[$i]['flight_array'])) ? $tours_result_array[$i]['flight_array'] : [];
                    if (sizeof($tours_result_array[$i]['flight_array']) > 0) { ?>
                      <div class="col-12 m20-btm">
                        <h3 class="c-heading">
                          Flight Details
                        </h3>
                        <?php
                        for ($tr_i = 0; $tr_i < sizeof($tours_result_array[$i]['flight_array']); $tr_i++) { ?>
                          <!-- *** Flight Card Info *** -->
                          <div class="c-cardListHolder">
                            <div class="c-cardListTable type-3">

                              <div class="cardList-info">
                                <div class="flexGrid">
                                  <div class="gridItem">
                                    <div class="infoCard c-halfText m0">
                                      <span class="infoCard_label">From Location</span>
                                      <span class="infoCard_price"><?= $tours_result_array[$i]['flight_array'][$tr_i]['from_location'] ?></span>
                                    </div>
                                  </div>

                                  <div class="gridItem styleForMobile M-m0">
                                    <div class="infoCard m5-btm">
                                      <span class="infoCard_label">To Location</span>
                                      <span class="infoCard_price"><?= $tours_result_array[$i]['flight_array'][$tr_i]['to_location'] ?></span>
                                    </div>
                                  </div>
                                  <div class="gridItem styleForMobile M-m0">
                                    <div class="infoCard m5-btm">
                                      <span class="infoCard_label">Airline</span>
                                      <span class="infoCard_price"><?= $tours_result_array[$i]['flight_array'][$tr_i]['airline'] ?></span>
                                    </div>
                                  </div>
                                  <div class="gridItem styleForMobile M-m0">
                                    <div class="infoCard m5-btm">
                                      <span class="infoCard_label">Class</span>
                                      <span class="infoCard_price"><?= $tours_result_array[$i]['flight_array'][$tr_i]['class'] ?></span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                          <!-- *** Flight Card Info End *** -->
                        <?php } ?>
                      </div>
                    <?php } ?>
                    <?php
                    $tours_result_array[$i]['cruise_array'] = (isset($tours_result_array[$i]['cruise_array']) != '') ? $tours_result_array[$i]['cruise_array'] : [];
                    if (sizeof($tours_result_array[$i]['cruise_array']) > 0) { ?>
                      <div class="col-12 m20-btm">
                        <h3 class="c-heading">
                          Cruise Details
                        </h3>
                        <?php
                        for ($tr_i = 0; $tr_i < sizeof($tours_result_array[$i]['cruise_array']); $tr_i++) { ?>
                          <!-- *** Cruise Card Info *** -->
                          <div class="c-cardListHolder">
                            <div class="c-cardListTable type-3">

                              <div class="cardList-info">
                                <div class="flexGrid">
                                  <div class="gridItem">
                                    <div class="infoCard c-halfText m0">
                                      <span class="infoCard_label">Route</span>
                                      <span class="infoCard_price"><?= $tours_result_array[$i]['cruise_array'][$tr_i]['route'] ?></span>
                                    </div>
                                  </div>

                                  <div class="gridItem styleForMobile M-m0">
                                    <div class="infoCard m5-btm">
                                      <span class="infoCard_label">Cabin</span>
                                      <span class="infoCard_price"><?= $tours_result_array[$i]['cruise_array'][$tr_i]['cabin'] ?></span>
                                    </div>
                                  </div>

                                </div>
                              </div>

                            </div>
                          </div>
                          <!-- *** Cruise Card Info End *** -->
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>

                <!-- **** Tab Hotel Car End **** -->
              </div>
              <!-- **** Tab Tours Car End **** -->
              <!-- **** Tab Policies **** -->
              <div class="tab-pane fade" id="inclusion-tab<?= $tours_result_array[$i]['tour_id'] ?>" role="tabpanel" aria-labelledby="inclusion-tab">
                <!-- **** Policies List **** -->
                <div class="clearfix margin20-bottom">
                  <?php if ($tours_result_array[$i]['inclusions'] != '') { ?>
                    <h3 class="c-heading">
                      Inclusions
                    </h3>
                    <div class="custom_texteditor">
                      <?= $tours_result_array[$i]['inclusions'] ?>
                    </div>
                  <?php } ?>
                  <?php if ($tours_result_array[$i]['exclusions'] != '') { ?>
                    <h3 class="c-heading">
                      Exclusions
                    </h3>
                    <div class="custom_texteditor">
                      <?= $tours_result_array[$i]['exclusions'] ?>
                    </div>
                  <?php } ?>
                  <?php if ($tours_result_array[$i]['terms'] != '') { ?>
                    <h3 class="c-heading">
                      Terms & Conditions
                    </h3>
                    <div class="custom_texteditor">
                      <?= $tours_result_array[$i]['terms'] ?>
                    </div>
                  <?php } ?>
                </div>
                <!-- **** Policies List End **** -->
              </div>
              <!-- **** Tab Policies End **** -->

              <div class="clearfix text-right">
                <button class="c-button md" id='<?= $tours_result_array[$i]['tour_id'] ?>' onclick='redirect_to_action_page("<?= $tours_result_array[$i]["tour_id"] ?>","2","",<?= $adult_count ?>,<?= $child_wocount ?>,<?= $child_wicount ?>,<?= $extra_bed_count ?>,<?= $infant_count ?>,"<?= $travel_date ?>","<?= $tours_result_array[$i]["group_id"] ?>")'><i class="fa fa-phone-square" aria-hidden="true"></i> Enquiry</button>
                <button class="c-button g-button md" id='<?= $tours_result_array[$i]['tour_id'] ?>' onclick='redirect_to_action_page("<?= $tours_result_array[$i]["tour_id"] ?>","2","",<?= $adult_count ?>,<?= $child_wocount ?>,<?= $child_wicount ?>,<?= $extra_bed_count ?>,<?= $infant_count ?>,"<?= $travel_date ?>","<?= $tours_result_array[$i]["group_id"] ?>")'><i class="fa fa-address-book" aria-hidden="true"></i> Book</button>
              </div>

            </div>
          </div>
          <!-- ***** Tours Info Tabs End***** -->
        </div>
      </div>
      <!-- *** Tours Details Accordian End *** -->
    </div>
    <!-- ***** Tours Card End ***** -->
<?php
  }
} //Activity arrays for loop
?>
<script>
  $(document).ready(function() {

    clearTimeout(b);
    var b = setTimeout(function() {

      var amount_list = document.querySelectorAll(".tours-currency-price");
      var amount_id = document.querySelectorAll(".tours-currency-id");

      var adult_price_list = document.querySelectorAll(".adult_cost-currency-price");
      var adult_price_cid = document.querySelectorAll(".adult-currency-id");

      var childwo_price_list = document.querySelectorAll(".childwio_cost-currency-price");
      var childwo_price_cid = document.querySelectorAll(".childwio-currency-id");

      var childwi_price_list = document.querySelectorAll(".childwi_cost-currency-price");
      var childwi_price_cid = document.querySelectorAll(".childwi-currency-id");

      var extrabed_price_list = document.querySelectorAll(".extrabed-currency-price");
      var extrabed_price_id = document.querySelectorAll(".extrabed-currency-id");

      var infant_price_list = document.querySelectorAll(".infant_cost-currency-price");
      var infant_price_id = document.querySelectorAll(".infant_cost-currency-id");

      //Tours Best Cost
      var amount_arr = [];
      for (var i = 0; i < amount_list.length; i++) {
        amount_arr.push({
          'amount': amount_list[i].innerHTML,
          'id': amount_id[i].innerHTML
        });
      }
      sessionStorage.setItem('tours_amount_list', JSON.stringify(amount_arr));

      //Adult cost prices
      var roomAmount_arr = [];
      for (var i = 0; i < adult_price_list.length; i++) {
        roomAmount_arr.push({
          'amount': adult_price_list[i].innerHTML,
          'id': adult_price_cid[i].innerHTML
        });
      }
      sessionStorage.setItem('adult_price_list', JSON.stringify(roomAmount_arr));

      //Child Wo cost prices
      var roomAmount_arr = [];
      for (var i = 0; i < childwo_price_list.length; i++) {
        roomAmount_arr.push({
          'amount': childwo_price_list[i].innerHTML,
          'id': childwo_price_cid[i].innerHTML
        });
      }
      sessionStorage.setItem('childwo_price_list', JSON.stringify(roomAmount_arr));

      //Child WI cost prices
      var roomAmount_arr = [];
      for (var i = 0; i < childwi_price_list.length; i++) {
        roomAmount_arr.push({
          'amount': childwi_price_list[i].innerHTML,
          'id': childwi_price_cid[i].innerHTML
        });
      }
      sessionStorage.setItem('childwi_price_list', JSON.stringify(roomAmount_arr));

      //Extra Bed Cost
      var offerAmount_arr = [];
      for (var i = 0; i < extrabed_price_list.length; i++) {
        offerAmount_arr.push({
          'amount': extrabed_price_list[i].innerHTML,
          'id': extrabed_price_id[i].innerHTML
        });
      }
      sessionStorage.setItem('extrabed_price_list', JSON.stringify(offerAmount_arr));

      //Infant Cost
      var offerAmount_arr = [];
      for (var i = 0; i < infant_price_list.length; i++) {
        offerAmount_arr.push({
          'amount': infant_price_list[i].innerHTML,
          'id': infant_price_id[i].innerHTML
        });
      }
      sessionStorage.setItem('infant_price_list', JSON.stringify(offerAmount_arr));
      var current_page_url = document.URL;
      group_tours_page_currencies(current_page_url);
    }, 500);
  });
</script>