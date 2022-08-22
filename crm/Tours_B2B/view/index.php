<?php
include '../../model/model.php';
$service = $_GET['service'];
$b2b_agent_code = $_SESSION['b2b_agent_code'];
$username = $_SESSION['b2b_username'];
$password = $_SESSION['b2b_password'];
$register_id = $_SESSION['register_id'];
$customer_id = $_SESSION['customer_id'];
if(isset($b2b_agent_code)&&isset($username)&&isset($password)){
  global $app_contact_no;
  $sq_cms_q = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM `b2b_settings`"));
  //Include header
  include '../layouts/header.php';
  $date = date('m-d-Y');
  $date1 = str_replace('-', '/', $date);
?>
        <!-- ********** Component :: Main Slider ********** -->
        <div class="c-mainSlider">
          <div class="js-mainSlider owl-carousel">
            <!-- SLIDE  -->
            <!-- Slide1 -->
            <?php
            $images = ($sq_cms_q['banners']!='')?json_decode($sq_cms_q['banners']):[];
            for($i=0;$i<sizeof($images);$i++){
                $url = $images[$i]->image_url;
                $pos = strstr($url,'uploads');
                if ($pos != false){
                    $newUrl1 = preg_replace('/(\/+)/','/',$images[$i]->image_url); 
                    $download_url = BASE_URL.str_replace('../', '', $newUrl1);
                }else{
                    $download_url =  $images[$i]->image_url; 
                }
            ?>
            <div class="item">
              <img src="<?php echo $download_url ?>" alt="<?= $app_name ?>" />
            </div>
            <?php } ?>
          </div>
        </div>
        <!-- ********** Component :: Main Slider End ********** -->

      <!-- ********** Component :: Info Section ********** -->
      <section class="dataContainer">
        <!-- ********** Search From ********** -->
        <div class="c-searchContainer">
          <div class="search-box container">

            <!-- ***** Search From Tabs ****** -->
            <ul class="c-search-tabs nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  data-toggle="tab"
                  href="#hotel-tab"
                  role="tab"
                  aria-controls="profile"
                  aria-selected="false"
                  data-service='Hotels'
                  >HOTELS</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#activities-tab"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true"
                  data-service='Activities'
                  >ACTIVITIES</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#transfer-tab"
                  role="tab"
                  aria-controls="contact"
                  aria-selected="false"
                  data-service='Transfer'
                  >TRANSFER</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#tours-tab"
                  role="tab"
                  aria-controls="contact"
                  aria-selected="false"
                  data-service='ComboTours'
                  >HOLIDAY</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#ferry-tab"
                  role="tab"
                  aria-controls="contact"
                  aria-selected="false"
                  data-service='Ferry'
                  >FERRY</a
                >
              </li>
            </ul>
            <!-- ***** Search From Tabs End ****** -->

            <!-- ***** Search Form Fields ****** -->
            <div class="search-tab-content tab-content">

              <!-- ***** Tab Hotel ****** -->
              <div class="tab-pane fade show active" data-service='Hotels' role="tabpanel" id="hotel-tab">
                <?php include 'hotel/hotel-search.php'; ?>
              </div>
              <!-- ************************** Tab Hotel End ***************************************** -->

              <div class="tab-pane fade" role="tabpanel"  data-service='Activities' id="activities-tab">
                <?php include 'activities/activities-search.php'; ?>
              </div>
              <div class="tab-pane fade" role="tabpanel"  data-service='Transfer' id="transfer-tab">
                <?php include 'transfer/transfer-search.php'; ?>
              </div>
              <div class="tab-pane fade" role="tabpanel"  data-service='ComboTours' id="tours-tab">
                <?php include 'tours/tours-search.php'; ?>
              </div>
              <div class="tab-pane fade" role="tabpanel"  data-service='Ferry' id="ferry-tab">
                <?php include 'ferry/ferry-search.php'; ?>
              </div>

            </div>
            <!-- ***** Search Form Fields End ****** -->
          </div>
        </div>
        <!-- ********** Search From ********** -->
      </section>
      <!-- ********** Component :: Info Section End ********** -->

      <!-- ********** Component :: Info Section ********** -->
      <?php if($sq_cms_q['why_choose_flag'] != 'Hide'){ ?>
      <section class="c-graySection">
        <div class="container">
          <h2 class="c-heading lg">Why Choose Us?</h2>

          <!-- *** Component :: Card Pallet ***** -->
          <div class="c-cardPallet">
            <div class="overflow-hidden">
              <div class="cardPalletBox column-5-no-margin">
              <?php
              $images = ($sq_cms_q['why_choose_us']!='')?json_decode($sq_cms_q['why_choose_us']):[];
              for($i=0;$i<sizeof($images);$i++){
                  $url = $images[$i]->image_url;
                  $pos = strstr($url,'uploads');
                  if ($pos != false){
                      $newUrl1 = preg_replace('/(\/+)/','/',$images[$i]->image_url); 
                      $download_url = BASE_URL.str_replace('../', '', $newUrl1);
                  }else{
                      $download_url =  $images[$i]->image_url; 
                  }
              ?>
                <article class="icon-box">
                  <div class="imageBox">
                    <img src="<?= $download_url ?>" alt="img" />
                  </div>
                  <h5 class="boxTitle"><?= $images[$i]->title ?></h5>
                  <p class="boxSubTitle">
                    <?= $images[$i]->description ?>
                  </p>
                </article>
              <?php } ?>
              </div>
            </div>
          </div>
          <!-- *** Component :: Card Pallet End ***** -->
        </div>
      </section>
      <?php } ?>
      <!-- ********** Component :: Info Section ********** -->

      <!-- ********** Component :: Destination Ideas Section ********** -->
      <?php if($sq_cms_q['amazing_destideas_flag'] != 'Hide'){
              $amazing_dest_ideas = ($sq_cms_q['amazing_dest_ideas']!='')?json_decode($sq_cms_q['amazing_dest_ideas']):[];
      ?>
        <div class="c-destinatioBanner">
          <div class="container">
            <div class="sectionTitle">
              <?= $amazing_dest_ideas[0]->heading ?>
            </div>
            <div class="row">
            <?php
            for($i=0;$i<sizeof($amazing_dest_ideas[0]->icon_list);$i++){
              ?>
              <div class="col-6 col-sm-4 col-md-2">
                <div class="icon-box">
                  <i class="<?= $amazing_dest_ideas[0]->icon_list[$i]->icon ?>"></i>
                  <h4 class="box-title"><?= $amazing_dest_ideas[0]->icon_list[$i]->title ?></h4>
                  <p class="description">
                    <?= $amazing_dest_ideas[0]->icon_list[$i]->description ?>
                  </p>
                </div>
              </div>
            <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>
      <!-- ********** Component :: Destination Ideas Section End ********** -->

      <div class="c-graySection">
        <!-- ********** Component :: Destination Slider Section ********** -->
        <?php if($sq_cms_q['popular_dest_flag'] != 'Hide'){
          $popular_dest = ($sq_cms_q['popular_dest']!='' && $sq_cms_q['popular_dest']!='null')?json_decode($sq_cms_q['popular_dest']):[];
          ?>
            <div class="container">
              <div class="block">
                <h2 class="c-heading lg">Popular Destinations</h2>
                <div class="c-cardSlider">
                  <div class="js-cardSlider owl-carousel">
                  <?php
                  for($i=0;$i<sizeof($popular_dest);$i++){
                      $dest_id=$popular_dest[$i]->dest_id;
                      $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_id,dest_name from destination_master where dest_id='$dest_id'"));
                      $package_id=$popular_dest[$i]->package_id;
                      $sq_package = mysqli_fetch_assoc(mysqlQuery("select dest_image,package_id,package_name from custom_package_master where package_id='$package_id'"));
                      //Destination package Image
                      if($sq_package['dest_image'] != '0'){

                        $row_gallary = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id = '$sq_package[dest_image]'"));
                        $url = $row_gallary['image_url'];
                        $pos = strstr($url,'uploads');
                        $entry_id =$row_gallary['entry_id'];
                        if ($pos != false)   {
                            $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 
                            $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                        }
                        else{
                            $newUrl =  $row_gallary['image_url']; 
                        }
                      }
                      else{
                        $sq_dest1 = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_images where package_id='$package_id'"));
                        $pos = strstr($url,'uploads');
                        if ($pos != false)   {
                            $newUrl1 = preg_replace('/(\/+)/','/',$sq_dest1['image_url']); 
                            $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                        }
                        else{
                            $newUrl =  $sq_dest1['image_url']; 
                        }
                      }
                    ?>
                    <div class="item">
                      <!-- *** Component :: Card Type - 1 **** -->
                      <article class="c-cardType-01">
                        <figure>
                          <img src="<?=$newUrl?>" alt="image" />
                        </figure>
                        <div class="cardDetails">
                          <a  class="c-link">
                            <h4 class="cardTitle">
                            <?= $sq_package['package_name'] ?>
                              <small><?php echo $sq_dest['dest_name']; ?></small>
                            </h4>
                          </a>
                        </div>
                      </article>
                      <!-- *** Component :: Card Type - 1 End **** -->
                    </div>

                  <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <!-- ********** Component :: Destination Slider Section End ********** -->
        <?php } ?>
      </div>

      <!-- ********** Component :: Destination Type 02 ********** -->
      <?php if($sq_cms_q['popular_honey_hotels_flag'] != 'Hide'){
        $popular_honey_hotels = ($sq_cms_q['popular_honey_hotels']!='' && $sq_cms_q['popular_honey_hotels']!='null')?json_decode($sq_cms_q['popular_honey_hotels']):[];
      ?>
      <div class="c-destinatioBanner">
        <div class="container">
          <div class="col-sm-12">
            <h3 class="sectionTitle text-center">
              <?php echo $popular_honey_hotels[0]->heading; ?>
            </h3>

            <p class="sectionSubTitle text-center">
              <?php echo $popular_honey_hotels[0]->title; ?>
            </p>

            <div class="row">
            <?php
            for($i=0;$i<sizeof($popular_honey_hotels[0]->hotel);$i++){
              $city_id=$popular_honey_hotels[0]->hotel[$i]->city_id;
              $hotel_id=$popular_honey_hotels[0]->hotel[$i]->hotel_id;
              if($hotel_id != ''){
                $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name,description,rating_star from hotel_master where hotel_id='$hotel_id'"));
                //Single Hotel Image
                $sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$hotel_id'"));
                if($sq_singleImage['hotel_pic_url']!=''){
                  $newUrl1 = explode('uploads', preg_replace('/(\/+)/','/',$sq_singleImage['hotel_pic_url']));
                  $newUrl = BASE_URL.'uploads'.$newUrl1[1];
                }else{
                  $newUrl = BASE_URL.'images/dummy-image.jpg';
                }
                //Description only 150chars display
                if(strlen($sq_hotel['description']) > 150){
                  $des_offset = 150;
                }
                else{
                    $des_offset = strlen($sq_hotel['description']);
                }
                $pos = ($sq_hotel['description']!='') ? strpos($sq_hotel['description'],'',$des_offset):false;
                //Rating stars display
                $star_category = explode(' ', $sq_hotel['rating_star']);
                $star_category = (sizeof($star_category) > 1) ? $star_category[0] : '';
                ?>
              
            <div class="col-sms-6 col-sm-6 col-md-3">
                <!-- *** Component :: Card Type - 1 **** -->
                <article class="c-cardType-01">
                  <figure>
                    <img src="<?= $newUrl ?>" alt="image" />                  
                      <div class="c-discount c-hide" id='discount<?= $hotel_id ?>'>
                          <div class="discount-text">
                              <span class="currency-icon"></span>
                              <span class='offer-currency-price' id="offer-currency-price<?= $hotel_id ?>"></span>&nbsp;&nbsp;<span id='discount_text<?= $hotel_id ?>'></span>
                          </div>
                      </div>
                  </figure>
                <?php
                ///////////////////////////Costing//////////////////////////
                //Get default currency rate
                global $currency;
                $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
                $to_currency_rate = $sq_to['currency_rate'];
                //Fetch Hotel Tariff for Room Categories(Room Types)
                $sq_tariff_master = mysqlQuery("select * from hotel_vendor_price_master where 1 and hotel_id='$hotel_id'");
                $room_cost=0;
                $checkDate = date('Y/m/d',strtotime($date1 . '+1 days'));
                $day = date("l", strtotime($checkDate));
                $offer_text = '';
                $text = '';
                while($row_tariff_master = mysqli_fetch_assoc($sq_tariff_master)){
                    $currency_id = $row_tariff_master['currency_id'];
              
                    //################### Black-dated rates ########################//
                    $blackdated_count = mysqli_num_rows(mysqlQuery("select * from hotel_blackdated_tarrif where pricing_id='$row_tariff_master[pricing_id]' and (from_date <='$checkDate' and to_date>='$checkDate')"));
                    $weekenddated_count = mysqli_num_rows(mysqlQuery("select * from hotel_weekend_tarrif where pricing_id='$row_tariff_master[pricing_id]' and day='$day'"));
                    if($blackdated_count>0){
                      $row_tariff = mysqli_fetch_assoc(mysqlQuery("select * from hotel_blackdated_tarrif where pricing_id='$row_tariff_master[pricing_id]' and (from_date <='$checkDate' and to_date>='$checkDate') "));

                          if($row_tariff['markup_per']!='0'){
                            $markup_amount = ($row_tariff['double_bed']*$row_tariff['markup_per'])/100;
                          }else{
                            $markup_amount = $row_tariff['markup'];
                          }
                          $room_cost = $row_tariff['double_bed'] + $markup_amount;
                          //Checking discount applied or not
                          $sq_offers_count = mysqli_num_rows(mysqlQuery("select * from hotel_offers_tarrif where (from_date <='$checkDate' and to_date>='$checkDate' and hotel_id='$hotel_id')"));
                          if($sq_offers_count>0){
                            $row_offers = mysqli_fetch_assoc(mysqlQuery("select * from hotel_offers_tarrif where (from_date <='$checkDate' and to_date>='$checkDate' and hotel_id='$hotel_id')"));
                            
                            $offer_amount1 = $row_offers['offer_amount'];
                            if($row_offers['type'] == 'Offer'){
                              if($row_offers['offer']=='Percentage'){
                                $offer_amount = ($room_cost*$row_offers['offer_amount'])/100;
                                $text = '%';
                              }
                              else{
                                $offer_amount = $row_offers['offer_amount'];
                                $text = '';
                              }
                            }else{
                              if($row_offers['offer']=='Percentage'){
                                $text = '%';
                              }
                              else{
                                $text = '';
                              }
                            }
                            $room_cost = $room_cost - $offer_amount;
                            $offer_text = $text.' '.$row_offers['type'];

                          }else{
                            $offer_text = '';
                          }
                    }
                    //################# Black-dated rates End #####################//
                    //################### Weeknend rates ########################//
                    else if($weekenddated_count>0){
                      $row_tariff = mysqli_fetch_assoc(mysqlQuery("select * from hotel_weekend_tarrif where pricing_id='$row_tariff_master[pricing_id]' and day='$day'"));

                          if($row_tariff['markup_per']!='0'){
                            $markup_amount = ($row_tariff['double_bed']*$row_tariff['markup_per'])/100;
                          }else{
                            $markup_amount = $row_tariff['markup'];
                          }
                          $room_cost = $row_tariff['double_bed'] + $markup_amount;
                          //Checking discount applied or not
                          $sq_offers_count = mysqli_num_rows(mysqlQuery("select * from hotel_offers_tarrif where (from_date <='$checkDate' and to_date>='$checkDate' and hotel_id='$hotel_id')"));
                          if($sq_offers_count>0){
                            $row_offers = mysqli_fetch_assoc(mysqlQuery("select * from hotel_offers_tarrif where (from_date <='$checkDate' and to_date>='$checkDate' and hotel_id='$hotel_id')"));

                            $offer_amount1 = $row_offers['offer_amount'];
                            if($row_offers['type'] == 'Offer'){
                              if($row_offers['offer']=='Percentage'){
                                $offer_amount = ($room_cost*$row_offers['offer_amount'])/100;
                                $text = '%';
                              }
                              else{
                                $offer_amount = $row_offers['offer_amount'];
                                $text = '';
                              }
                            }else{
                              if($row_offers['offer']=='Percentage'){
                                $text = '%';
                              }
                              else{
                                $text = '';
                              }
                            }
                            $room_cost = $room_cost - $offer_amount;
                            $offer_text = $text.' '.$row_offers['type'];

                          }else{
                            $offer_text = '';
                          }
                    } 
                    //################# Weeknend-dated rates End #####################//
                    //################### Contracted rates ########################//
                    else{
                      $row_tariff = mysqli_fetch_assoc(mysqlQuery("select * from hotel_contracted_tarrif where pricing_id='$row_tariff_master[pricing_id]' and (from_date <='$checkDate' and to_date>='$checkDate')"));

                          if($row_tariff['markup_per']!='0'){
                            $markup_amount = ($row_tariff['double_bed']*$row_tariff['markup_per'])/100;
                          }else{
                            $markup_amount = $row_tariff['markup'];
                          }
                          $room_cost = $row_tariff['double_bed'] + $markup_amount;
                          //Checking discount applied or not
                          $sq_offers_count = mysqli_num_rows(mysqlQuery("select * from hotel_offers_tarrif where (from_date <='$checkDate' and to_date>='$checkDate' and hotel_id='$hotel_id')"));
                          if($sq_offers_count>0){
                            $row_offers = mysqli_fetch_assoc(mysqlQuery("select * from hotel_offers_tarrif where (from_date <='$checkDate' and to_date>='$checkDate' and hotel_id='$hotel_id')"));
                            
                            $offer_amount1 = $row_offers['offer_amount'];
                            if($row_offers['type'] == 'Offer'){
                              if($row_offers['offer']=='Percentage'){
                                $offer_amount = ($room_cost*$row_offers['offer_amount'])/100;
                                $text = '%';
                              }
                              else{
                                $offer_amount = $row_offers['offer_amount'];
                                $text = '';
                              }
                            }else{
                              if($row_offers['offer']=='Percentage'){
                                $text = '%';
                              }
                              else{
                                $text = '';
                              }
                            }
                            $room_cost = $room_cost - $offer_amount;
                            $offer_text = $text.' '.$row_offers['type'];

                          }else{
                            $offer_text = '';
                          }
                    }
                  //################# Contracted rates End #####################//
                }
                ?>
                <script>
                      //Offer red strip display
                      if('<?= $offer_text ?>' != ''){
                          document.getElementById("discount<?= $hotel_id ?>").classList.remove("c-hide");
                          document.getElementById("discount<?= $hotel_id ?>").classList.add("c-show");
                          
                          document.getElementById("offer-currency-price<?= $hotel_id ?>").innerHTML= '<?= $offer_amount1 ?>';
                          document.getElementById("discount_text<?= $hotel_id ?>").innerHTML='<?= $offer_text ?>';
                      }else{
                          document.getElementById("discount<?= $hotel_id ?>").classList.add("c-hide");
                      }
                </script>
                    <div class="cardDetails">
                      <a class="c-link clearfix m10-btm">
                        <div class="dividerSection type-1">
                          <div class="divider s1">
                            <h4 class="cardTitle">
                            <?php echo $sq_hotel['hotel_name']; ?>
                              <small><?php echo $sq_city['city_name']; ?></small>
                            </h4>
                          </div>
                          <div class="divider s2">
                            <span class="priceTag">
                              <span class="currency-icon"></span><span class="currency-hotel-price"><?= $room_cost ?> </span>
                              <span class="c-hide currency-hotel-id"><?= $currency_id ?></span>
                              <small>per / Night</small>
                            </span>
                          </div>
                        </div>
                      </a>
                      <div class="vSection">
                        <div class="dividerSection">
                          <div class="divider s1">
                            <div class="c-starRating cust s<?= $star_category ?>">
                              <span class="stars"></span>
                            </div>
                          </div>
                          <div class="divider s2 text-right">
                            <span class="c-staticText sm t-uppercase"
                              >270 reviews</span
                            >
                          </div>
                        </div>
                      </div>
                      <div class="vSection">
                        <div class="dividerSection">
                          <div class="divider">
                            <span class="c-staticText"
                              ><?php echo substr($sq_hotel['description'],0,150).'...'; ?></span
                            >
                          </div>
                        </div>
                      </div>
                      <div class="vSection">
                        <div class="dividerSection">
                          <div class="divider s1">
                            <a class="c-button lg" onclick="get_select_hotel('<?=$city_id ?>','<?=$hotel_id ?>','<?= date('m/d/Y',strtotime($date1 . '+1 days')) ?>','<?=date('m/d/Y',strtotime($date1 . '+2 days'))?>');">Select</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                  <!-- *** Component :: Card Type - 1 End **** -->
                </div>
              <?php
            }
            } ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <!-- ********** Component :: Destination Type 02 End ********** -->

      <!-- ********** Component :: Destination Slider Section ********** -->
      <?php if($sq_cms_q['popular_activities_flag'] != 'Hide'){
        $popular_activities = ($sq_cms_q['popular_activities']!='' && $sq_cms_q['popular_activities']!='null')?json_decode($sq_cms_q['popular_activities']):[];
      ?>
      <div class="c-graySection">
        <div class="container">
          <div class="block">
            <h2 class="c-heading lg">Popular Activities</h2>
            <div class="c-cardSlider">
              <div class="js-cardSlider owl-carousel">
              <?php
              for($i=0;$i<sizeof($popular_activities);$i++){

                  $city_id = $popular_activities[$i]->city_id;
                  $exc_id = $popular_activities[$i]->exc_id;
                  $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                  $sq_exc = mysqli_fetch_assoc(mysqlQuery("select entry_id from excursion_master_tariff where excursion_name='$exc_id'"));
                  //Activity Image
                  $sq_dest1 = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_images where exc_id='$sq_exc[entry_id]'"));
                  $newUrl1 = preg_replace('/(\/+)/','/',$sq_dest1['image_url']); 
                  $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                ?>
                <div class="item">
                  <!-- *** Component :: Card Type - 1 **** -->
                  <article class="c-cardType-01">
                    <figure>
                      <img src="<?= $newUrl ?>" alt="image"/>
                    </figure>
                    <div class="cardDetails">
                      <a class="c-link">
                        <h4 class="cardTitle"><?= $exc_id.'('.$sq_city['city_name'].')' ?></h4>
                      </a>
                    </div>
                  </article>
                  <!-- *** Component :: Card Type - 1 End **** -->
                </div>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <!-- ********** Component :: Destination Slider Section End ********** -->

      <!-- ********** Component :: Add banner Section ********** -->
      <?php
      if($sq_cms_q['call_to_action_flag'] != 'Hide'){
        $call_to_action = ($sq_cms_q['call_to_action']!='')?json_decode($sq_cms_q['call_to_action']):[];
        $url = $call_to_action[0]->image_url;
        $pos = strstr($url,'uploads');
        if ($pos != false){
            $newUrl1 = preg_replace('/(\/+)/','/',$call_to_action[0]->image_url); 
            $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
        }else{
            $newUrl =  $call_to_action[0]->image_url; 
        }
      ?>
      <div class="c-destinatioBanner c-addBanner pad0">
        <div class="container">
          <div class="row">
            <div class="dividerSection vAlign-mid">
              <div class="col-md-3 col-sm-12 divider noFloat onlyForDesktop">
                <img src="<?= $newUrl ?>" alt="" />
              </div>
              <div class="col-md-9 col-sm-12 divider noFloat">
                <div class="dividerSection vAlign-mid">
                  <div class="divider M-m20-btm">
                    <span class="c-heading col-white md txt-light">
                    <?php echo $call_to_action[0]->title; ?>
                    </span>
                    <span class="c-heading col-white lg txt-bold m0">
                      <em><?php echo $call_to_action[0]->subtitle; ?></em>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <!-- ********** Component :: Add banner Section End ********** -->

      <!-- ********** Component :: Hotel Slider Section ********** -->
      <?php
      if($sq_cms_q['popular_hotels_flag'] != 'Hide'){
        $popular_hotels = ($sq_cms_q['popular_hotels']!='' && $sq_cms_q['popular_hotels']!='null')?json_decode($sq_cms_q['popular_hotels']):[];
        ?>
          <div class="c-graySection">
            <div class="container">
              <div class="block">
                <h2 class="c-heading lg">Popular Hotels</h2>
                <div class="c-cardSlider">
                  <div class="js-cardSlider owl-carousel">
                    <?php
                    for($i=0;$i<sizeof($popular_hotels);$i++){

                      $city_id=$popular_hotels[$i]->city_id;
                      $hotel_id=$popular_hotels[$i]->hotel_id;
                      $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                      $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name,description,rating_star from hotel_master where hotel_id='$hotel_id'"));
                      //Single Hotel Image
                      $sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$hotel_id'"));
                      if($sq_singleImage['hotel_pic_url']!=''){
                        $newUrl1 = explode('uploads', preg_replace('/(\/+)/','/',$sq_singleImage['hotel_pic_url']));
                        $newUrl = BASE_URL.'uploads'.$newUrl1[1];
                      }else{
                        $newUrl = BASE_URL.'images/dummy-image.jpg';
                      }
                      //Description only 150chars display
                      $pos = ($sq_hotel['description']!='') ? substr($sq_hotel['description'],0,150):false;
                      //Rating stars display
                      $star_category = explode(' ', $sq_hotel['rating_star']);
                      $star_category = (sizeof($star_category) > 1) ? $star_category[0] : '';
                      ?>
                      <div class="item">
                      <!-- *** Component :: Card Type - 1 **** -->
                        <article class="c-cardType-01">
                          <a class="c-link clearfix" onclick="get_select_hotel('<?=$city_id ?>','<?=$hotel_id ?>','<?= date('m/d/Y',strtotime($date1 . '+1 days')) ?>','<?= date('m/d/Y',strtotime($date1 . '+2 days')) ?>');">
                            <figure>
                              <img src="<?= $newUrl ?>" alt="image" />
                            </figure>
                            <div class="cardDetails">
                                <div class="dividerSection type-1">
                                  <div class="divider s1">
                                    <h4 class="cardTitle">
                                      <?= $sq_hotel['hotel_name'] ?>
                                      <small><?= $sq_city['city_name'] ?></small>
                                    </h4>
                                  </div>
                                  <div class="divider s2">
                                    <div class="c-starRating cust s<?= $star_category ?>">
                                      <span class="stars"></span>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </a>
                        </article>
                        <!-- *** Component :: Card Type - 1 End **** -->
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php } ?>
      <!-- ********** Component :: Hotel Slider Section End ********** -->

      <!-- ********** Component :: Destination Type 02 ********** -->
      <?php if($sq_cms_q['popular_honey_dest_flag'] != 'Hide'){
              $popular_honey_dest = ($sq_cms_q['popular_honey_dest']!='' && $sq_cms_q['popular_honey_dest']!='null')?json_decode($sq_cms_q['popular_honey_dest']):[];
        ?>
      <div class="c-destinatioBanner pad0-btm M-p50-btm">
        <div class="container">
          <div class="col-md-6 col-12 pull-right">
            <h3 class="sectionTitle text-left">
              Popular Destinations for Honeymoon
            </h3>
            <p class="sectionSubTitle text-left">
            <?php echo $popular_honey_dest[0]->description; ?>
            </p>
            <div class="row">
            <?php 
            $destinations = ($popular_honey_dest[0]->destination!='' && $popular_honey_dest[0]->destination!='null')?($popular_honey_dest[0]->destination):[];
            for($i=0;$i<sizeof($destinations);$i++){

              $dest_id = $popular_honey_dest[0]->destination[$i]->dest_id;
              $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_id,dest_name from destination_master where dest_id='$dest_id'"));
              
              $url = $destinations[$i]->image_url;
              $pos = strstr($url,'uploads');
              if ($pos != false){
                  $newUrl = $url;
              }else{
                  $newUrl =  $destinations[$i]->image_url; 
              }
              $sq_count = mysqli_num_rows(mysqlQuery("select package_id from custom_package_master where dest_id='$dest_id'"));
            ?>
              <div class="col-4">
                <article class="c-cardType-01">
                  <figure>
                    <a title="">
                      <img src="<?=$newUrl?>" alt=""
                    /></a>
                  </figure>
                  <div class="cardDetails">
                    <a class="c-link">
                      <h4 class="cardTitle">
                        <?= $sq_dest['dest_name'] ?><small>(<?=$sq_count?> PACKAGES)</small>
                      </h4>
                    </a>
                  </div>
                </article>
              </div>
            <?php } ?>
            </div>
          </div>
          <div class="col-md-6 image-container no-margin onlyForDesktop">
            <img src="../images/couple.png" alt="" />
          </div>
        </div>
      </div>
      <?php } ?>
      <!-- ********** Component :: Destination Type 02 End ********** -->
<?php include '../layouts/footer.php';?>
<script type="text/javascript" src="hotel/js/index.js"></script>
<script type="text/javascript" src="transfer/js/index.js"></script>
<script type="text/javascript" src="activities/js/index.js"></script>
<script type="text/javascript" src="tours/js/index.js"></script>
<script type="text/javascript" src="ferry/js/index.js"></script>
<script type="text/javascript" src="../js/scripts.js"></script>
<script>
  $( document ).ready(function() {
    $('#checkInDate, #checkOutDate, #checkDate, #travelDate').datetimepicker({ timepicker:false,format:'m/d/Y',minDate:new Date() });
    $('#pickup_date,#ftravelDate').datetimepicker({ format:'m/d/Y H:i',minDate:new Date() });
    document.getElementById('return_date').readOnly = true;

  
    var service = '<?php echo $service; ?>';
    if(service && (service !== '' || service !== undefined)){
      var checkLink = $('.c-searchContainer .c-search-tabs li');
      var checkTab = $('.c-searchContainer .search-tab-content .tab-pane');
      checkLink.each(function(){
        var child = $(this).children('.nav-link');
        if(child.data('service') === service){
          $(this).siblings().children('.nav-link').removeClass('active');
          child.addClass('active');
        }
      });
      checkTab.each(function(){
        if($(this).data('service') === service){
          $(this).addClass('active show').siblings().removeClass('active show');
        }
      })
    }
    
    var amount_list = document.querySelectorAll(".currency-hotel-price");
    var amount_id = document.querySelectorAll(".currency-hotel-id");
    var amount_arr = [];
    for(var i=0;i<amount_list.length;i++){
      amount_arr.push({
      'amount':amount_list[i].innerHTML,
      'id':amount_id[i].innerHTML});
    }
    sessionStorage.setItem('hotel_price',JSON.stringify(amount_arr));
    setTimeout(() => {
      index_page_currencies();
    },1000);
});
</script>
<?php
}
else{
?>
<script>
  window.location.href = "../login.php";
</script>
<?php } ?>