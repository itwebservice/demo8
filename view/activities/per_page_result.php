<?php
include '../../config.php';
$activity_result_array = ($_POST['data']!='')?$_POST['data']:[];
$global_currency = $_SESSION['global_currency'];
$coupon_list_arr = array();
$coupon_info_arr= array();
if(sizeof($activity_result_array)>0){
  for($i=0;$i<sizeof($activity_result_array);$i++){

    $h_currency_id = $activity_result_array[$i]['currency_id'];

    $act_enq_data = array();
    $adult_count = $activity_result_array[$i]['adult_count'];
    $child_count = $activity_result_array[$i]['child_count'];
    $infant_count = $activity_result_array[$i]['infant_count'];
    $actDate = $activity_result_array[$i]['actDate'];
    $excursion_name = $activity_result_array[$i]['excursion_name'];

    array_push($act_enq_data,array('excursion_name'=>$excursion_name,'actDate'=>$actDate,'adult_count'=>$adult_count,'child_count'=>$child_count,'infant_count'=>$infant_count));
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
                </div>
            </div>
          </div>
          <!-- *** Activity Card image End *** -->

          <!-- *** Activity Card Info *** -->
          <div class="cardList-info" role="button">
            <button class="expandSect">Read More...</button>
            <div class="dividerSection type-1 noborder">
              <div class="divider s1">
                <h4 class="cardTitle" id="act_name-<?= $activity_result_array[$i]['exc_id'] ?>"><?php echo $activity_result_array[$i]['excursion_name'].' ('.$activity_result_array[$i]['city_name'].')' ?></h4>

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
                    <?php echo substr($activity_result_array[$i]['description'],0,90).' ...' ?>
                    </span>
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
                    </span>
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
                <li class="nav-item active">
                  <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                    aria-controls="description" aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="incl-tab" data-toggle="tab" href="#incl<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                    aria-controls="incl" aria-selected="true">INCLUSIONS/EXCLUSIONS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link js-gallery" id="termsTab" data-toggle="tab" href="#terms<?= $activity_result_array[$i]['exc_id']?>"
                    role="tab" aria-controls="terms" aria-selected="true">Terms & Conditions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="policies-tab" data-toggle="tab" href="#policies<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                    aria-controls="policies" aria-selected="true">Policies</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="timing-tab" data-toggle="tab" href="#timing<?= $activity_result_array[$i]['exc_id']?>" role="tab"
                    aria-controls="timing" aria-selected="true">Timing Slots</a>
                </li>
                <li class="nav-item">
                    <a
                    class="nav-link js-gallery"
                    id="galleryTab-<?= $activity_result_array[$i]['exc_id'] ?>"
                    data-toggle="tab"
                    href="#gallery-<?= $activity_result_array[$i]['exc_id'] ?>"
                    role="tab"
                    aria-controls="gallery"
                    aria-selected="true"
                    >Gallery</a
                    >
                </li>
              </ul>

              <div class="tab-content" id="myTabContent">

                <!-- **** Tab Description **** -->
                <div class="tab-pane fade active show" id="description<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="description-tab">
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
                <!-- **** Tab Timing **** -->
                <div class="tab-pane fade" id="timing<?= $activity_result_array[$i]['exc_id']?>" role="tabpanel" aria-labelledby="timing-tab">
                  <!-- **** Policies **** -->
                  <div class="clearfix margin20-bottom">

                    <div class="custom_texteditor">
                      <?php
                      $timing_slots = ($activity_result_array[$i]['timing_slots'] != '' && $activity_result_array[$i]['timing_slots']!= 'null') ? json_decode($activity_result_array[$i]['timing_slots']) : [];
                      if(sizeof($timing_slots) == 0){
                        echo 'NA';
                      }
                      for($t = 0; $t < sizeof($timing_slots);$t++){
                        ?>
                        <!-- *** timing slots Info *** -->
                        <div class="c-cardListHolder">
                          <div class="c-cardListTable type-3">

                            <div class="cardList-info">
                              <div class="flexGrid">
                                <div class="gridItem">
                                  <div class="infoCard c-halfText m0">
                                    <span class="infoCard_label">SR.No</span>
                                    <span class="infoCard_price"><?= ($t+1) ?></span>
                                  </div>
                                </div>
                                <div class="gridItem">
                                  <div class="infoCard c-halfText m0">
                                    <span class="infoCard_label">From Time</span>
                                    <span class="infoCard_price"><?= $timing_slots[$t]->from_time ?></span>
                                  </div>
                                </div>

                                <div class="gridItem styleForMobile M-m0">
                                  <div class="infoCard m5-btm">
                                    <span class="infoCard_label">To Time</span>
                                    <span class="infoCard_price"><?= $timing_slots[$t]->to_time ?></span>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                        <!-- *** timing slots End *** -->
                      <?php } ?>
                    </div>
                  </div>
                  <!-- **** Policies End **** -->
                </div>

                <!-- **** Tab Gallery **** -->
                <div class="tab-pane fade" id="gallery-<?= $activity_result_array[$i]['exc_id'] ?>" role="tabpanel" aria-labelledby="galleryTab-">
                    <!-- **** photo List **** -->
                    <div class="clearfix">
                      <div class="c-photoGallery js-dynamicLoad">
                          <div class="js-photoGallery owl-carousel">
                              <?php
                              $exc_id = $activity_result_array[$i]['exc_id'];
                              $sq_singleImage1 = mysqlQuery("select * from excursion_master_images where exc_id='$exc_id'");
                              while($sq_singleImage = mysqli_fetch_assoc($sq_singleImage1)){
                                if($sq_singleImage['image_url']!=''){
                                    $image = $sq_singleImage['image_url'];
                                    $newUrl1 = preg_replace('/(\/+)/','/',$image);
                                    $newUrl1 = explode('uploads', $newUrl1);
                                    $newUrl = BASE_URL.'uploads'.$newUrl1[1];
                                }else{
                                    $newUrl = BASE_URL.'images/dummy-image.jpg';
                                }
                                ?>
                                <div class="item">
                                    <img src="<?= $newUrl ?>" alt=""/>
                                </div>
                              <?php } ?>
                          </div>
                      </div>
                    </div>
                    <!-- **** photo List End **** -->
                </div>
                <!-- **** Tab Gallery End **** -->
              </div>
              <div class="clearfix text-right">
                  <button type="button" class="c-button md" id='<?=$activity_result_array[$i]['exc_id']?>' onclick='enq_to_action_page("4",this.id,<?= json_encode($act_enq_data)?>)'><i class="fa fa-phone-square" aria-hidden="true"></i>  Enquiry</button>
              </div>
            <!-- ***** Activity Info Tabs End***** -->
          </div>
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
    if ($('.js-photoGallery').length > 0) {

		$('.js-photoGallery').owlCarousel({
			loop       : false,
			margin     : 16,
			nav        : true,
			dots       : false,
            lazyLoad   : true,
            checkVisible : true,
			slideBy    : 2,
			navText    : [
				'<i class="icon it itours-arrow-left"></i>',
				'<i class="icon it itours-arrow-right"></i>'
			],
			responsive : {
				0   : {
					items : 1
				},
				768 : {
					items : 2
                }
            },
		});
    }
    // activties_page_currencies();
});
</script>