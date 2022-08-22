<?php
include '../../../model/model.php';
global $currency;
$b2b_currency = $_SESSION['session_currency_id'];
$hotel_results_array = ($_POST['data']!='')?$_POST['data']:[];

if(sizeof($hotel_results_array)>0){
    for($hotel_i=0;$hotel_i<sizeof($hotel_results_array);$hotel_i++){
?>
    <!-- ***** Hotel Card ***** -->
    <div class="c-cardList type-hotel">
    <div class="c-cardListTable"
    role="button"
    data-toggle="collapse"
    href="#collapseExample<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>"
    aria-expanded="false"
    aria-controls="collapseExample">
        <!-- *** Hotel Card image *** -->
        <div class="cardList-image">
        <img src="<?= $hotel_results_array[$hotel_i]['hotel_image'] ?>" loading="lazy" alt="<?php echo $hotel_results_array[$hotel_i]['hotel_name']; ?>" />
        <?php if($hotel_results_array[$hotel_i]['hotel_type']!=''){?>
        <div class="typeOverlay">
            <span class="hotelType">
                <i class="icon it itours-building"></i>
                <?php echo $hotel_results_array[$hotel_i]['hotel_type'] ?>
            </span>
        </div>
        <?php } ?>
        <div class="c-discount c-hide" id='discount<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>'>
            <div class="discount-text">
                <span class="currency-icon"></span>
                <span class='offer-currency-price' id="offer-currency-price<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>&nbsp;&nbsp;<span id='discount_text<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>'></span>
                <span class='c-hide offer-currency-id' id="offer-currency-id<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>
                <span class='c-hide offer-currency-flag' id="offer-currency-flag<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>
            </div>
        </div>
        </div>
        <!-- *** Hotel Card image End *** -->

        <!-- *** Hotel Card Info *** -->
        <div class="cardList-info" role="button">

        <button class="expandSect">View Details</button>

        <div class="dividerSection type-1 noborder">
            <div class="divider s1">
            <h4 class="cardTitle">
                <?php echo $hotel_results_array[$hotel_i]['hotel_name']; ?>
                <?php if($hotel_results_array[$hotel_i]['star_category'] != ''){ ?>
                <div class="hotelStar">
                <div class="c-starRating cust s<?= $hotel_results_array[$hotel_i]['star_category'] ?>">
                    <span class="stars"></span>
                </div>
                </div>
                <?php } ?>
            </h4>

            <div class="infoSection">
                <?php if($hotel_results_array[$hotel_i]['hotel_address']!=''){?>
                <span class="cardInfoLine">
                <?php echo $hotel_results_array[$hotel_i]['hotel_address'] ?>
                </span>
                <?php } ?>
            </div>
            <div class="c-tagSection">
                <?php if($hotel_results_array[$hotel_i]['meal_plan']!=''){ ?>
                <span class="tag"><?= $hotel_results_array[$hotel_i]['meal_plan'] ?></span>
                <?php } ?>
            </div>

            <div class="c-aminityListBlock">
                <ul>
                <?php if($hotel_results_array[$hotel_i]['amenity'][0]!=''){ ?>
                <script>
                    var ameities = getObjects(amenities,'name','<?php echo $hotel_results_array[$hotel_i]['amenity'][0]; ?>');
                    document.getElementById("amenity1<?=$hotel_results_array[$hotel_i]['hotel_id']?>").src = '../../images/amenities/'+ameities[0]['image'];
                </script>
                <li>
                    <div class="amenity">
                    <img id='amenity1<?=$hotel_results_array[$hotel_i]['hotel_id']?>' alt=""  />
                    <span><?= $hotel_results_array[$hotel_i]['amenity'][0] ?></span>
                    </div>
                </li>
                <script>
                    var ameities2 = getObjects(amenities,'name','<?php echo $hotel_results_array[$hotel_i]['amenity'][1]; ?>');
                    document.getElementById("amenity2<?=$hotel_results_array[$hotel_i]['hotel_id']?>").src = '../../images/amenities/'+ameities2[0]['image'];
                </script>
                <?php } if($hotel_results_array[$hotel_i]['amenity'][1]!=''){ ?>
                <li>
                    <div class="amenity">
                    <img id='amenity2<?=$hotel_results_array[$hotel_i]['hotel_id']?>' alt=""  />
                    <span><?= $hotel_results_array[$hotel_i]['amenity'][1] ?></span>
                    </div>
                </li>
                <script>
                    var ameities3 = getObjects(amenities,'name','<?php echo $hotel_results_array[$hotel_i]['amenity'][2]; ?>');
                    document.getElementById("amenity3<?=$hotel_results_array[$hotel_i]['hotel_id']?>").src = '../../images/amenities/'+ameities3[0]['image'];
                </script>
                <?php } if($hotel_results_array[$hotel_i]['amenity'][2]!=''){ ?>
                <li>
                    <div class="amenity">
                    <img id='amenity3<?=$hotel_results_array[$hotel_i]['hotel_id']?>' alt=""  />
                    <span><?= $hotel_results_array[$hotel_i]['amenity'][2] ?></span>
                    </div>
                </li>
                <?php } ?>
                <?php
                $hotel_amenity = ($hotel_results_array[$hotel_i]['amenity']!='')?$hotel_results_array[$hotel_i]['amenity']:[];
                if(sizeof($hotel_amenity)-3 > 0){ ?>
                <li>
                    <div class="amenity st-last">
                    <span class="num">+<?= sizeof($hotel_amenity)-3 ?></span>
                    <span class="txt">more</span>
                    </div>
                </li>
                <?php } ?>
                </ul>
            </div>
            </div>

            <div class="divider s2">
            <span class="priceTag">
                <div class="p-old c-hide" id="old_price<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
                    <span class="o_lbl">Old Price</span>
                    <span class="o_price">
                        <span class="p_currency currency-icon"></span>
                        <span class="p_cost original-currency-price" id="price_sub<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>
                        <span class="c-hide original-currency-id" id="price_subid<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>
                    </span>
                </div>
                <div class="p-old">
                    <span class="o_lbl" >Best Price</span>
                    <span class="price_main">
                        <span class="p_currency currency-icon"></span>
                        <span class="p_cost currency-price" id="best_cost<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>
                        <span class="c-hide currency-id" id="best_cost_cid<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"></span>
                    </span>
                </div>
            </span>
            <div class="c-starRating r-3p5">
                <span class="stars"></span>
                <p class="rating">200 Rating</p>
            </div>
            </div>
        </div>
        </div>
        <!-- *** Hotel Card Info End *** -->
    </div>

    <!-- *** Hotel Details Accordian *** -->
    <div class="collapse" id="collapseExample<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>">
        <div class="cardList-accordian">
        <!-- ***** Hotel Info Tabs ***** -->
        <div class="c-compTabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a
                class="nav-link active"
                id="home-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                data-toggle="tab"
                href="#home<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tab"
                aria-controls="home"
                aria-selected="true"
                >Room Types</a
                >
            </li>
            <li class="nav-item">
                <a
                class="nav-link"
                id="description-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                data-toggle="tab"
                href="#description<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tab"
                aria-controls="description"
                aria-selected="true"
                >Description</a
                >
            </li>
            <li class="nav-item">
                <a
                class="nav-link"
                id="policies-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                data-toggle="tab"
                href="#policies<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tab"
                aria-controls="policies"
                aria-selected="true"
                >Policies</a
                >
            </li>
            <li class="nav-item">
                <a
                class="nav-link js-gallery"
                id="galleryTab-<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                data-toggle="tab"
                href="#gallery-<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tab"
                aria-controls="gallery"
                aria-selected="true"
                >Gallery</a
                >
            </li>
            <li class="nav-item">
                <a
                class="nav-link"
                id="reviews-tab<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>"
                data-toggle="tab"
                href="#reviews<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tab"
                aria-controls="reviews"
                aria-selected="true"
                >Reviews</a
                >
            </li>
            </ul>

            <div class="tab-content" id="myTabContent">
            <!-- **** Tab Hotel Listing **** -->
            <div
                class="tab-pane fade show active"
                id="home<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tabpanel"
                aria-labelledby="home-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
            >
            <?php
            //Room Type Result Final  Result Display
            $check_date_size = ($hotel_results_array[$hotel_i]['checkDate_array']!='')?$hotel_results_array[$hotel_i]['checkDate_array']:[];
            $last_date = sizeof($check_date_size)-2;
            $all_costs_array = array();
            $original_costs_array = array();
            for($i=0;$i<sizeof($hotel_results_array[$hotel_i]['final_room_type_array']);$i++){
                if($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['check_date'] == $check_date_size[$last_date]){
                
                    $room_cost_array = ($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['room_cost']!='')?($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['room_cost']):[];

                    $child_cost_array = ($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['child_cost']!='')?($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['child_cost']):[];

                    $daywise_exbcost_array = ($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['daywise_exbcost']!='')?($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['daywise_exbcost']):[];

                    $markup_type_array = ($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['markup_type']!='')?($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['markup_type']):[];
                    
                    $markup_amount_array = ($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['markup_amount']!='')?($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['markup_amount']):[];
                    
                    // Roomcost For loop
                    $room_cost_temp = 0;
                    $child_cost_temp = 0;
                    $exbed_cost_temp = 0;
                    $markup = 0;
                    $room_cost = 0;
                    for($m=0;$m<sizeof($room_cost_array);$m++){

                        $room_cost_temp = $room_cost_array[$m] + $child_cost_array[$m] + $daywise_exbcost_array[$m];
                        if($markup_type_array[$m] == 'Percentage'){
                            $markup = ($room_cost_temp * ($markup_amount_array[$m]/100));
                        }else{
                            $markup = ($markup_amount_array[$m]);
                        }
                        $room_cost = $room_cost + $room_cost_temp + $markup;
                    }
                    $room_cost = ceil($room_cost);
                    array_push($original_costs_array,$room_cost);
                    $h_currency_id = $hotel_results_array[$hotel_i]['final_room_type_array'][$i]['currency_id'];
                    if($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_type'] != ''){

                        $offer_amount = $hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_amount'];
                        $coupon_offer = 0;
                        if($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_type'] == 'Offer'){

                            if($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_in'] == 'Percentage'){
                                $text = '%';
                                $coupon_offer = ($room_cost * ($offer_amount/100));
                                $room_cost = $room_cost - $coupon_offer;
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
                                    $coupon_offer = ($to_currency_rate != '') ? $from_currency_rate / $to_currency_rate * $offer_amount : 0;
                                }
                                $room_cost = $room_cost - $coupon_offer;
                            }
                        }
                        else if($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_type'] == 'Coupon'){
                            if($hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_in'] == 'Percentage'){
                                $text = '%';
                            }
                            else{
                                $text = '';
                            }
                        }
                        $offer_text = $text.' '.$hotel_results_array[$hotel_i]['final_room_type_array'][$i]['offer_type'];
                    }else{
                        $offer_text = '';
                    }
                    $room_cost = ceil($room_cost);
                    array_push($all_costs_array,$room_cost);
                    ?>
                    <!-- ***** Hotel List Card ***** -->
                    <div class="c-cardListHolder">
                        <div class="c-cardListTable type-2" role="button">
                        <input class="btn-radio" type="radio" id="<?= $hotel_results_array[$hotel_i]['hotel_id'].$i ?>" name="result_day<?=$hotel_results_array[$hotel_i]['hotel_id'].$hotel_results_array[$hotel_i]['final_room_type_array'][$i]['room_count']?>" value='<?php echo "Room ".$hotel_results_array[$hotel_i]['final_room_type_array'][$i]['room_count'].'-'.$hotel_results_array[$hotel_i]['final_room_type_array'][$i]['category'].'-'.$room_cost.'-'.$h_currency_id ?>'>

                        <!-- *** Hotel Card Info *** -->
                        <label class="cardList-info" for="<?=$hotel_results_array[$hotel_i]['hotel_id'].$i?>" role="button">
                            <div class="flexGrid">
                                <div class="gridItem">
                                    <div class="infoCard">
                                    <span class="infoCard_data">
                                    <?php echo "Room-".$hotel_results_array[$hotel_i]['final_room_type_array'][$i]['room_count'].' : '.$hotel_results_array[$hotel_i]['final_room_type_array'][$i]['category'];?>
                                        <span class="infoCard_notifi m5-l">Check Availability</span>
                                    </span>
                                    </div>
                                    <div class="styleForMobile">
                                        <div class="infoCard c-halfText m0">
                                            <span class="sect">Max Guests:</span>
                                            <span class="sect s2"><?= $hotel_results_array[$hotel_i]['final_room_type_array'][$i]['max_occupancy']?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="gridItem">
                                    <div class="infoCard m0">
                                    <div class="M-infoCard">
                                        <span class="infoCard_label">Best Price</span>
                                        <span class="infoCard_price">
                                            <span class="p_currency currency-icon"></span>
                                            <span class="p_cost room-currency-price"><?= $room_cost ?></span>
                                            <span class="c-hide room-currency-id"><?= $h_currency_id ?></span>
                                        </span>
                                        <span class="infoCard_priceTax">(exclusive of all taxes)</span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <!-- *** Hotel Card Info End *** -->
                        </div>
                    </div>
                    <!-- ***** Hotel List Card End ***** -->
                <?php 
                }
            }
                $best_cost = (sizeof($all_costs_array))?min($all_costs_array):[];
                $original_cost = (sizeof($original_costs_array))?min($original_costs_array):[];
                ?>
                <script>
                setTimeout(function(){
                    document.getElementById('best_cost<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>').innerHTML='<?php echo sprintf("%.2f", $best_cost); ?>';
                    document.getElementById('best_cost_cid<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>').innerHTML='<?= $h_currency_id ?>';

                    if(parseFloat(<?= $original_cost ?>) != parseFloat(<?= $best_cost ?>)){
                        document.getElementById('old_price<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>').classList.remove('c-hide');
                        document.getElementById('price_sub<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>').innerHTML='<?php echo sprintf("%.2f", $original_cost); ?>';
                        document.getElementById('price_subid<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>').innerHTML='<?= $h_currency_id ?>';
                    }
                    else{
                        document.getElementById('old_price<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>').style.display='none';
                    }

                    //Offer red strip display
                    if('<?= $offer_text ?>' != ''){
                        document.getElementById("discount<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").classList.remove("c-hide");
                        document.getElementById("discount<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").classList.add("c-show");
                        if('<?= $text != '%' ?>' && (<?=$currency ?> != <?= $b2b_currency?>)){
                            document.getElementById("offer-currency-price<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").innerHTML= '<?= $offer_amount ?>';
                            document.getElementById("offer-currency-id<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").innerHTML= '<?= $currency ?>';
                        }else{
                            document.getElementById("offer-currency-price<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").innerHTML= '<?= number_format($offer_amount,2) ?>';
                            document.getElementById("offer-currency-id<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").innerHTML= '<?= $currency ?>';
                            document.getElementById("offer-currency-flag<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").innerHTML= 'no';
                        }
                        document.getElementById("discount_text<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").innerHTML='<?= $offer_text ?>';
                    }else{
                        document.getElementById("discount<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").classList.add("c-hide");
                    }
                }, 50);
                </script>

                <div class="clearfix text-right">
                    <button class="c-button md" id='<?=$hotel_results_array[$hotel_i]['hotel_id']?>' onclick="add_to_cart('<?=$hotel_results_array[$hotel_i]['hotel_id']?>','hotel');"><i class="icon it itours-shopping-cart"></i> Add To Cart</button>
                </div>
            </div>
            <!-- **** Tab Hotel Listing End **** -->

            <!-- **** Tab Description **** -->
            <div
                class="tab-pane fade"
                id="description<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tabpanel"
                aria-labelledby="description-tab<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>"
            >
                <!-- **** Description **** -->
                <div class="clearfix margin20-bottom">
                <p class="c-statictext">
                    <?= $hotel_results_array[$hotel_i]['description'] ?>
                </p>
                </div>
                <!-- **** Description End **** -->

                <!-- **** Amenities **** -->
                <?php
                $hotel_ame = ($hotel_results_array[$hotel_i]['amenity']!='')?$hotel_results_array[$hotel_i]['amenity']:[];
                if(sizeof($hotel_ame)>1){ ?>
                <div class="clearfix margin20-bottom">
                <h3 class="c-heading">
                    Amenities
                </h3>
                <div class="clearfix">
                    <ul class="row c-amenitiesType2">
                    <?php
                    for($i=0;$i<sizeof($hotel_ame);$i++){
                    ?>
                    <script>
                        var ameities3 = getObjects(amenities,'name','<?php echo $hotel_ame[$i]; ?>');
                        document.getElementById("ameities1<?=$i.$hotel_results_array[$hotel_i]['hotel_id']?>").className = 'icon '+ameities3[0]['icon'];
                    </script>
                    <li class="col-md-4 col-sm-6 col-12">
                        <div class="amenitiesList">
                        <i id="ameities1<?=$i.$hotel_results_array[$hotel_i]['hotel_id']?>"></i><?= $hotel_ame[$i] ?>
                        </div>
                    </li>
                    <?php } ?>
                    </ul>
                </div>
                </div>
                <?php } ?>
                <!-- **** Amenities **** -->
            </div>
            <!-- **** Tab Description End **** -->

            <!-- **** Tab Policies **** -->
            <div class="tab-pane fade"
                id="policies<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tabpanel"
                aria-labelledby="policies-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
                <!-- **** Policies List **** -->
                <div class="c-infoDivider">
                <div class="custom_texteditor">
                    <?php echo $hotel_results_array[$hotel_i]['policies']; ?>
                </div>
                </div>
                <!-- **** Policies List End **** -->
            </div>
            <!-- **** Tab Policies End **** -->

            <!-- **** Tab Gallery **** -->
            <div class="tab-pane fade"
                id="gallery-<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                role="tabpanel"
                aria-labelledby="gallery-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
                <!-- **** photo List **** -->
                <div class="clearfix">
                <div class="c-photoGallery js-dynamicLoad">
                    <div class="js-photoGallery owl-carousel">
                        <?php
                        $thotel_id = $hotel_results_array[$hotel_i]['hotel_id'];
                        $sq_hotelImage = mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$thotel_id'");
                        while($sq_singleImage = mysqli_fetch_assoc($sq_hotelImage)){
                        if($sq_singleImage['hotel_pic_url']!=''){
                            $image = $sq_singleImage['hotel_pic_url'];
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

            <!-- **** Tab Reviews **** -->
            <div class="tab-pane fade" id="reviews<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tabpanel"
                aria-labelledby="reviews-tab<?=$hotel_results_array[$hotel_i]['hotel_id'] ?>">
                <!-- **** Reviews List **** -->
                <div class="c-reviewDivider">
                <div class="infoTitle">
                    <div class="userImage">
                    <img src="http://placehold.it/270x263" />
                    </div>
                    <h4 class="userTitle">
                        Jessica Brown
                    </h4>
                    <span class="userDate">NOV, 12, 2013</span class="userTitle">
                </div>
                <div class="infoDescription">
                    <div class="row">
                    <div class="col-md-8">
                        <h4 class="reviewTitle">We had great experience while our stay and Hilton Hotels!</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="reviewRating">
                        <div class="c-starRating r-3p5">
                            <span class="stars"></span>
                        </div>
                        <span class="rating">3.5 / 5</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <span class="reviewText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's stand dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</span>
                    </div>
                    </div>
                </div>
                </div>
                <!-- **** Reviews List End **** -->

                <!-- **** Reviews List **** -->
                <div class="c-reviewDivider">
                <div class="infoTitle">
                    <div class="userImage">
                    <img src="http://placehold.it/270x263" />
                    </div>
                    <h4 class="userTitle">
                    Jessica Brown
                    </h4>
                    <span class="userDate">NOV, 12, 2013</span class="userTitle">
                </div>
                <div class="infoDescription">
                    <div class="row">
                    <div class="col-md-8">
                        <h4 class="reviewTitle">We had great experience while our stay and Hilton Hotels!</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="reviewRating">
                        <div class="c-starRating r-3p5">
                            <span class="stars"></span>
                        </div>
                        <span class="rating">3.5 / 5</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <span class="reviewText">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's stand dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</span>
                    </div>
                    </div>
                </div>
                </div>
                <!-- **** Reviews List End **** -->

            </div>
            <!-- **** Tab Reviews End **** -->

            </div>
        </div>
        <!-- ***** Hotel Info Tabs End***** -->
        </div>
    </div>
    <!-- *** Hotel Details Accordian End *** -->
    </div>
    </div>
    <!-- ***** Hotel Card End ***** -->
    <?php
    }
} //Hotel arrays for loop
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

    clearTimeout(b);
        var b = setTimeout(function() {
        var amount_list = document.querySelectorAll(".currency-price");
        var amount_id = document.querySelectorAll(".currency-id");

        var original_amt_list = document.querySelectorAll(".original-currency-price");
        var original_amt_id = document.querySelectorAll(".original-currency-id");

        var room_price_list = document.querySelectorAll(".room-currency-price");
        var room_price_cid = document.querySelectorAll(".room-currency-id");

        var offer_price_list = document.querySelectorAll(".offer-currency-price");
        var offer_price_id = document.querySelectorAll(".offer-currency-id");
        var offer_currency_flag = document.querySelectorAll(".offer-currency-flag");
        
        //Hotel Best Cost
        var amount_arr = [];
        for(var i=0;i<amount_list.length;i++){
            amount_arr.push({
                'amount':amount_list[i].innerHTML,
                'id':amount_id[i].innerHTML});
        }
        sessionStorage.setItem('amount_list',JSON.stringify(amount_arr));

        //Room categorywise prices
        var roomAmount_arr = [];
        for(var i=0;i<room_price_list.length;i++){
            roomAmount_arr.push({
                'amount':room_price_list[i].innerHTML,
                'id':room_price_cid[i].innerHTML});
        }
        sessionStorage.setItem('room_price_list',JSON.stringify(roomAmount_arr));

        //Hotel Original Cost
        var orgAmount_arr = [];
        for(var i=0;i<original_amt_list.length;i++){
            orgAmount_arr.push({
                'amount':original_amt_list[i].innerHTML,
                'id':original_amt_id[i].innerHTML});
        }
        sessionStorage.setItem('original_amt_list',JSON.stringify(orgAmount_arr));

        //Hotel Offer Cost
        var offerAmount_arr = [];
        for(var i=0;i<offer_price_list.length;i++){
            offerAmount_arr.push({
                'amount':offer_price_list[i].innerHTML,
                'id':offer_price_id[i].innerHTML,
                'flag':offer_currency_flag[i].innerHTML });
        }
        sessionStorage.setItem('offer_price_list',JSON.stringify(offerAmount_arr));

        currency_converter();
    },500);
});
</script>