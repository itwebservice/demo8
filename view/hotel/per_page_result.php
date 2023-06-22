<?php
include '../../config.php';
$hotel_results_array = ($_POST['data'] != '') ? $_POST['data'] : [];
if (sizeof($hotel_results_array) > 0) {

    for ($hotel_i = 0; $hotel_i < sizeof($hotel_results_array); $hotel_i++) {

        $hotel_enq_data = array();
        $check_in = $hotel_results_array[$hotel_i]['check_in'];
        $check_out = $hotel_results_array[$hotel_i]['check_out'];
        $total_rooms = $hotel_results_array[$hotel_i]['total_rooms'];
        $hotel_name = $hotel_results_array[$hotel_i]['hotel_name'];

        array_push($hotel_enq_data, array('hotel_name' => $hotel_name, 'check_in' => $check_in, 'check_out' => $check_out, 'total_rooms' => $total_rooms));
?>
        <!-- ***** Hotel Card ***** -->
        <div class="c-cardList type-hotel">
            <div class="c-cardListTable" role="button" data-toggle="collapse" href="#collapseExample<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" aria-expanded="false" aria-controls="collapseExample">
                <!-- *** Hotel Card image *** -->
                <div class="cardList-image">
                    <img src="<?= $hotel_results_array[$hotel_i]['hotel_image'] ?>" loading="lazy" alt="<?php echo $hotel_results_array[$hotel_i]['hotel_name']; ?>" />
                    <?php if ($hotel_results_array[$hotel_i]['hotel_type'] != '') { ?>
                        <div class="typeOverlay">
                            <span class="hotelType">
                                <i class="icon it itours-building"></i>
                                <?php echo $hotel_results_array[$hotel_i]['hotel_type'] ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>
                <!-- *** Hotel Card image End *** -->

                <!-- *** Hotel Card Info *** -->
                <div class="cardList-info" role="button">

                    <button class="expandSect">View Details</button>

                    <div class="dividerSection type-1 noborder">
                        <div class="divider s1">
                            <h4 class="cardTitle">
                                <?php echo $hotel_results_array[$hotel_i]['hotel_name'] . ' (' . $hotel_results_array[$hotel_i]['city_name'] . ')'; ?>
                                <?php if ($hotel_results_array[$hotel_i]['star_category'] != '') { ?>
                                    <div class="hotelStar">
                                        <div class="c-starRating cust s<?= $hotel_results_array[$hotel_i]['star_category'] ?>">
                                            <span class="stars"></span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </h4>

                            <div class="infoSection">
                                <?php if ($hotel_results_array[$hotel_i]['hotel_address'] != '') { ?>
                                    <span class="cardInfoLine">
                                        <?php echo $hotel_results_array[$hotel_i]['hotel_address'] ?>
                                    </span>
                                <?php } ?>
                            </div>
                            <div class="c-tagSection">
                                <?php if ($hotel_results_array[$hotel_i]['meal_plan'] != '') { ?>
                                    <span class="tag"><?= $hotel_results_array[$hotel_i]['meal_plan'] ?></span>
                                <?php } ?>
                            </div>

                            <div class="c-aminityListBlock">
                                <ul>
                                    <?php if ($hotel_results_array[$hotel_i]['amenity'][0] != '') { ?>
                                        <script>
                                            var ameities = getObjects(amenities, 'name', '<?php echo $hotel_results_array[$hotel_i]['amenity'][0]; ?>');
                                            document.getElementById("amenity1<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").src = '../../images/amenities/' + ameities[0]['image'];
                                        </script>
                                        <li>
                                            <div class="amenity">
                                                <img id='amenity1<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>' alt="" />
                                                <span><?= $hotel_results_array[$hotel_i]['amenity'][0] ?></span>
                                            </div>
                                        </li>
                                        <script>
                                            var ameities2 = getObjects(amenities, 'name', '<?php echo $hotel_results_array[$hotel_i]['amenity'][1]; ?>');
                                            document.getElementById("amenity2<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").src = '../../images/amenities/' + ameities2[0]['image'];
                                        </script>
                                    <?php }
                                    if ($hotel_results_array[$hotel_i]['amenity'][1] != '') { ?>
                                        <li>
                                            <div class="amenity">
                                                <img id='amenity2<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>' alt="" />
                                                <span><?= $hotel_results_array[$hotel_i]['amenity'][1] ?></span>
                                            </div>
                                        </li>
                                        <script>
                                            var ameities3 = getObjects(amenities, 'name', '<?php echo $hotel_results_array[$hotel_i]['amenity'][2]; ?>');
                                            document.getElementById("amenity3<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>").src = '../../images/amenities/' + ameities3[0]['image'];
                                        </script>
                                    <?php }
                                    if ($hotel_results_array[$hotel_i]['amenity'][2] != '') { ?>
                                        <li>
                                            <div class="amenity">
                                                <img id='amenity3<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>' alt="" />
                                                <span><?= $hotel_results_array[$hotel_i]['amenity'][2] ?></span>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    $hotel_amenity = ($hotel_results_array[$hotel_i]['amenity'] != '') ? $hotel_results_array[$hotel_i]['amenity'] : [];
                                    if (sizeof($hotel_amenity) - 3 > 0) { ?>
                                        <li>
                                            <div class="amenity st-last">
                                                <span class="num">+<?= sizeof($hotel_amenity) - 3 ?></span>
                                                <span class="txt">more</span>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
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
                <!-- *** Hotel Card Info End *** -->
            </div>

            <!-- *** Hotel Details Accordian *** -->
            <div class="collapse" id="collapseExample<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
                <div class="cardList-accordian">
                    <!-- ***** Hotel Info Tabs ***** -->
                    <div class="c-compTabs">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" id="description-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" data-toggle="tab" href="#description<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tab" aria-controls="description" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="policies-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" data-toggle="tab" href="#policies<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tab" aria-controls="policies" aria-selected="true">Policies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link js-gallery" id="galleryTab-<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" data-toggle="tab" href="#gallery-<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tab" aria-controls="gallery" aria-selected="true">Gallery</a>
                            </li>
                            <!-- <li class="nav-item">
                    <a
                    class="nav-link"
                    id="reviews-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                    data-toggle="tab"
                    href="#reviews<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>"
                    role="tab"
                    aria-controls="reviews"
                    aria-selected="true"
                    >Reviews</a>
                </li>-->
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <!-- **** Tab Hotel Listing **** -->

                            <!-- **** Tab Description **** -->
                            <div class="tab-pane fade show active" id="description<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tabpanel" aria-labelledby="description-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
                                <!-- **** Description **** -->
                                <div class="clearfix margin20-bottom">
                                    <p class="c-statictext">
                                        <?= $hotel_results_array[$hotel_i]['description'] ?>
                                    </p>
                                </div>
                                <!-- **** Description End **** -->

                                <!-- **** Amenities **** -->
                                <?php
                                $hotel_ame = ($hotel_results_array[$hotel_i]['amenity'] != '') ? $hotel_results_array[$hotel_i]['amenity'] : [];
                                if (sizeof($hotel_ame) > 1) { ?>
                                    <div class="clearfix margin20-bottom">
                                        <h3 class="c-heading">
                                            Amenities
                                        </h3>
                                        <div class="clearfix">
                                            <ul class="row c-amenitiesType2">
                                                <?php
                                                for ($i = 0; $i < sizeof($hotel_ame); $i++) {
                                                ?>
                                                    <script>
                                                        var ameities3 = getObjects(amenities, 'name', '<?php echo $hotel_ame[$i]; ?>');
                                                        document.getElementById("ameities1<?= $i . $hotel_results_array[$hotel_i]['hotel_id'] ?>").className = 'icon ' + ameities3[0]['icon'];
                                                    </script>
                                                    <li class="col-md-4 col-sm-6 col-12">
                                                        <div class="amenitiesList">
                                                            <i id="ameities1<?= $i . $hotel_results_array[$hotel_i]['hotel_id'] ?>"></i><?= $hotel_ame[$i] ?>
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
                            <div class="tab-pane fade" id="policies<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tabpanel" aria-labelledby="policies-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
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
                            <div class="tab-pane fade" id="gallery-<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>" role="tabpanel" aria-labelledby="gallery-tab<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>">
                                <!-- **** photo List **** -->
                                <div class="clearfix">
                                    <div class="c-photoGallery js-dynamicLoad">
                                        <div class="js-photoGallery owl-carousel">
                                            <?php
                                            $thotel_id = $hotel_results_array[$hotel_i]['hotel_id'];
                                            $sq_hotelImage = mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$thotel_id'");
                                            while ($sq_singleImage = mysqli_fetch_assoc($sq_hotelImage)) {
                                                if ($sq_singleImage['hotel_pic_url'] != '') {
                                                    $image = $sq_singleImage['hotel_pic_url'];
                                                    $newUrl1 = preg_replace('/(\/+)/', '/', $image);
                                                    $newUrl1 = explode('uploads', $newUrl1);
                                                    $newUrl = BASE_URL . 'uploads' . $newUrl1[1];
                                                } else {
                                                    $newUrl = BASE_URL . 'images/dummy-image.jpg';
                                                }
                                            ?>
                                                <div class="item">
                                                    <img src="<?= $newUrl ?>" alt="" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- **** photo List End **** -->
                            </div>
                            <!-- **** Tab Gallery End **** -->

                        </div>
                    </div>
                    <div class="clearfix text-right">
                        <button type="button" class="c-button md" id='<?= $hotel_results_array[$hotel_i]['hotel_id'] ?>' onclick='enq_to_action_page("3",this.id,<?= json_encode($hotel_enq_data) ?>)'><i class="fa fa-phone-square" aria-hidden="true"></i> Enquiry</button>
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
    $(document).ready(function() {
        if ($('.js-photoGallery').length > 0) {

            $('.js-photoGallery').owlCarousel({
                loop: false,
                margin: 16,
                nav: true,
                dots: false,
                lazyLoad: true,
                checkVisible: true,
                slideBy: 2,
                navText: [
                    '<i class="icon it itours-arrow-left"></i>',
                    '<i class="icon it itours-arrow-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    }
                },
            });
        }

    });
    // $(document).ready(function () {
    //     hotel_page_currencies();
    // });
</script>