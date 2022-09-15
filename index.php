<?php

include 'config.php';


$service = $_GET['service'];

global $app_contact_no;

//Include header

include 'layouts/header.php';

$date = date('m-d-Y');

$date1 = str_replace('-', '/', $date);

?>


<!-- Site Content Start -->
<main>
    <!-- //  -- booking section start --// -->
    <section>
        <div class="booking-banner">
            <div class="banner-text">
                <div class="container">
                    <div class="banner-title">
                        <h1>Where Do You Want To Go? </h1>
                        <p>Find The World's Largest Collection Of Tours & Travel Packages.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="searching-tabs">
                                <ul class="nav nav-pills " id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link banner-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tours</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link banner-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Hotels</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link banner-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Flights</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link banner-link" id="pills-car-tab" data-bs-toggle="pill" data-bs-target="#pills-car" type="button" role="tab" aria-controls="pills-car" aria-selected="false">Cars</button>
                                    </li>
                                </ul>
                                <div class="tab-content search-border" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="searchbar">
                                            <div class="search-form row no-gutters">
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <input type="text" class="form-control current-input " placeholder="Current Location">
                                                    <span><img src="images/gps.svg" class="gps" alt=""></span>
                                                </div>
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <select class="form-control js-example-templating current-input" name="" id="">
                                                        <option value="" selected>Destination Location
                                                        </option>
                                                        <option value="">India</option>
                                                        <option value="">USA</option>
                                                        <option value="">United Kingdom</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-lg-8 col-xl-8 mb-0 p-0 ">
                                                    <div class="row no-gutters">
                                                        <div class="form-group col-md-12 col-lg-3 col-xl-3 mb-0 p-0">
                                                            <input class="form-control current-input datepicker" placeholder="Travel Date">
                                                        </div>
                                                        <div class="form-group col-md-12 col-lg-3 col-xl-3 mb-0 p-0">
                                                            <input class="form-control current-input datepicker" placeholder="Return Date">
                                                        </div>
                                                        <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                            <select class="form-control current-input js-example-templating" name="" id="">
                                                                <option value="" selected>Persons</option>
                                                                <option value="">1</option>
                                                                <option value="">2</option>
                                                                <option value="">3</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                            <select class="form-control current-input js-example-templating" name="" id="">
                                                                <option value="" selected>Kids</option>
                                                                <option value="">1</option>
                                                                <option value="">2</option>
                                                                <option value="">3</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                            <a href="#" class="btn book-search">Search</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="searchbar">
                                            <div class="search-form row no-gutters">
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <input type="text" class="form-control current-input " placeholder="Current Location">
                                                    <span><img src="images/gps.svg" class="gps" alt=""></span>
                                                </div>
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <select class="form-control js-example-templating current-input" name="" id="">
                                                        <option value="" selected>Persons</option>
                                                        <option value="">1</option>
                                                        <option value="">2</option>
                                                        <option value="">3</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <select class="form-control js-example-templating current-input" name="" id="">
                                                        <option value="" selected>Kids</option>
                                                        <option value="">1</option>
                                                        <option value="">2</option>
                                                        <option value="">3</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-lg-6 col-xl-6 mb-0 p-0">
                                                    <div class="row no-gutters">
                                                        <div class="form-group col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <input class="form-control current-input datepicker" placeholder="Checkin">
                                                        </div>
                                                        <div class="form-group col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <input class="form-control current-input datepicker" placeholder="Checkout">
                                                        </div>
                                                        <div class="col-md-12 col-lg-4 col-xl-4 p-0 ">
                                                            <a href="#" class="btn book-search">Search</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <div class="searchbar">
                                            <div class="search-form row no-gutters">
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <input type="text" class="form-control current-input" placeholder="From">
                                                </div>
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <input type="text" class="form-control current-input" placeholder="To">
                                                </div>
                                                <div class="form-group col-md-12 col-lg-2 col-xl-2 mb-0 p-0">
                                                    <select class="form-control js-example-templating current-input" name="" id="">
                                                        <option value="" selected>Adults</option>
                                                        <option value="">1</option>
                                                        <option value="">2</option>
                                                        <option value="">3</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-lg-6 col-xl-6 mb-0 p-0">
                                                    <div class="row no-gutters">
                                                        <div class="form-group col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <select class="form-control js-example-templating current-input" name="" id="">
                                                                <option value="" selected>Kids</option>
                                                                <option value="">1</option>
                                                                <option value="">2</option>
                                                                <option value="">3</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <input class="form-control current-input datepicker" placeholder="Checkout">
                                                        </div>
                                                        <div class="col-md-12 col-lg-4 col-xl-4 p-0">
                                                            <a href="#" class="btn book-search">Search</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-car" role="tabpanel" aria-labelledby="pills-car-tab">
                                        <div class="searchbar">
                                            <div class="search-form row no-gutters">
                                                <div class="form-group col-lg-3 col-xl-3 mb-0 p-0">
                                                    <input class="form-control current-input datepicker" placeholder="Pickup Date">
                                                </div>
                                                <div class="form-group col-lg-3 col-xl-3 mb-0 p-0">
                                                    <input class="form-control current-input " type="time" placeholder="Checkout">
                                                </div>
                                                <div class="form-group col-md-12 col-lg-6 col-xl-6 mb-0 p-0">
                                                    <div class="row no-gutters">
                                                        <div class="form-group col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <input type="text" class="form-control current-input" placeholder="Pickup Location">
                                                        </div>
                                                        <div class="form-group col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <input type="text" class="form-control current-input" placeholder="Drop Location">
                                                        </div>
                                                        <div class="col-md-12 col-lg-4 col-xl-4 mb-0 p-0">
                                                            <a href="#" class="btn book-search">Search</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-xl-10 mx-auto">
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="tour-service">
                                    <a target="_blank" href="<?=BASE_URL_B2C?>/view/tours/tours-listing.php" style="text-decoration: none;">
                                        <img src="images/hotel.png" class="img-fluid hotel-book" alt="">
                                        <h6>Hotels</h6></a>
                                    </div>
                                </div>
                                <!-- <div class="col">
                                    <div class="tour-service">
                                        <img src="images/restaurant.png" class="img-fluid hotel-book" alt="">
                                        <h6>Restaurant</h6>
                                    </div>
                                </div> -->
                                <div class="col">
                                    <div class="tour-service">
                                    <a target="_blank" href="<?=BASE_URL_B2C?>/view/visa/visa-listing.php" style="text-decoration: none;">
                                        <img src="images/plane.png" class="img-fluid hotel-book" alt="">
                                        <h6>Visa</h6></a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="tour-service">
                                        <a target="_blank" href="<?=BASE_URL_B2C?>/view/transfer/transfer-listing.php" style="text-decoration: none;">
                                        <img src="images/vehicle.png" class="img-fluid hotel-book" alt="">
                                        <h6>Car</h6></a>
                                    </div>
                                </div>
                                <!-- <div class="col">
                                    <div class="tour-service">
                                        <img src="images/train.png" class="img-fluid hotel-book" alt="">
                                        <h6>Trains</h6>
                                    </div>
                                </div> -->
                                <div class="col">
                                    <div class="tour-service">
                                    <a target="_blank" href="<?=BASE_URL_B2C?>/view/ferry/ferry-listing.php" style="text-decoration: none;">
                                        <img src="images/boat.png" class="img-fluid hotel-book" alt="">
                                        <h6>Ships</h6></a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="tour-service">
                                    <a target="_blank" href="<?=BASE_URL_B2C?>/view/activities/activities-listing.php" style="text-decoration: none;">
                                        <img src="images/wine.png" class="img-fluid hotel-book" alt="">
                                        <h6>Activities</h6></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <!-- //  -- booking section end  --  // -->
    <!-- //  ---- tour package start  ----  // -->
    <section class="tour-pack">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Best</span>
                <h1>Popoular Packages</h1>
                <p>Get The Premium International Destinations, Personalized Tailor Made Tours With Us And Explore Yourself.</p>

            </div>
            <div class="package-card">
                <?php
                // var_dump($Apipackage->images);
                foreach ($Apipackage as $package) {

                    $package_name = $package->package_name;

                    $package_fname = str_replace(' ', '_', $package_name);

                    $file_name = 'package_tours/' . $package_fname . '-' . $package->package_id . '.php';
                ?>
                    <div class="card widget-card border-0">
                        <div class="widget-card-img">
                            <img src="<?= $package->main_img_url ?>" class="card-img-top" alt="...">
                            <!-- <div class="widget-card-price">
                                <h4>$40 <del>$50</del></h4>
                            </div> -->
                            <div class="widget-card-lighting">
                                <span>
                                    <i class="fa-solid fa-bolt-lightning"></i>
                                </span>
                            </div>
                            <div class="widget-card-price" style="top: 100px;">
                                <h4>$<?= !empty($package->tariff) ? $package->tariff->cadult : 0.00  ?></h4>
                            </div>
                            <div class="ribbon">
                                <span class="bg-primary">Collaction</span>
                            </div>
                            <div class="widget-hotel-card-item">
                                <!-- <a href="#" class="hotel-card-item"><i class="fa-solid fa-utensils"></i></a> -->
                                <a href="#" class="hotel-card-item1 australia-hart-icon">
                                    <i class="fa-solid fa-plane"></i>
                                </a>
                                <a href="#" class="hotel-card-item australia-hart-icon">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            </div>

                        </div>
                        <div class="card-body widget-card-body">
                            <div class="widget-card-reviw widget-card-hotel-title mb-0">
                                <a href="<?= $file_name ?>" class="text-decoration-none">
                                    <h5 class="card-title widget-card-title hotel-australia-title"><?= $package->package_name ?>
                                    </h5>
                                </a>
                                <span class="widget-card-trip-day">
                                    <strong><?= $package->total_nights ?> Nights,<?= $package->total_days ?> Days </strong>
                                    <?= $package->tour_type ?>
                                </span>
                                <p class="card-text widget-card-text"><?= $package->note ?>
                                </p>

                            </div>
                        </div>
                        <div class="card-footer widget-card-footer bg-white australia-card-footer">
                            <a href="#" class="text-decoration-none" onclick="get_tours_data('<?= $package->destination->dest_id ?>','1')">
                                <span class="widget-card-footer-text"><i class="bi bi-geo-alt fa-solid fa-location-dot"></i> <?= $package->destination->dest_name ?>
                                </span>
                            </a>
                            <!-- <div class="rating-star">
                                <span><i class="fas fa-star star"></i></span>
                                <span><i class="fas fa-star star"></i></span>
                                <span><i class="fas fa-star star"></i></span>
                                <span><i class="fas fa-star star"></i></span>
                                <span><i class="fas fa-star"></i></span> (85)
                            </div> -->
                        </div>
                    </div>
                <?php  } ?>


            </div>
        </div>
    </section>
    <!-- //  ---- tour package end  ----  // -->

    <!-- Tour type Section Start -->
    <section class="tour-type-section">
        <div class="container">
            <div class="tour-type-content">
                <div class="tour-type-list">

                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/hill.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Mountains</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/trip.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Flyings</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/palm-tree.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Seas</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/historical.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Historical</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/climb.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Climbing</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/mountain.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Snow Views</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/india.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">7 Wonders</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/pyramid.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Pyramids</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/camel.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Deserts</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/forest.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">Forests</h6>
                            </a>
                        </div>
                    </div>
                    <div class="tour-type-item">
                        <div class="tour-type-img text-decoration-none">
                            <a href="#" class="text-decoration-none">
                                <img src="images/world.png" alt="" class="img-fluid">
                                <h6 class="tour-type-title">World Tour</h6>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Tour type Section End -->
    <!-- //  ---- tour Location slider start  ----  // -->
    <section class="tour-location">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Top</span>
                <h1>Rated Locations</h1>
                <p>Explore popular Domestic & International Destinations</p>
                <?php
                //var_dump($Apidestination[0]);
                ?>

            </div>
            <div class="location-slider">
                <?php
                //var_dump($Apidestination[0]);
                foreach ($Apidestination as $destination) {  ?>
                    <div class="style-nine-card-item">
                       <a onclick="get_tours_data('<?= $destination->dest_id ?>','1')"> <div class="style-nine-img">
                            <img src="  <?= $destination->gallery_images[5]->image_url; ?>" alt="" class="img-fluid">

                            <div class="style-nine-card-details">
                                <div class="rating-star">
                                    <span><i class="fas fa-star star"></i></span>
                                    <span><i class="fas fa-star star"></i></span>
                                    <span><i class="fas fa-star star"></i></span>
                                    <span><i class="fas fa-star star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                </div>
                                <p class="style-nine-card-title  text-white">
                                    <?= $destination->dest_name; ?>
                                </p>
                                <!-- <p class="style-nine-location mb-0">
                                    <small><i class="bi bi-geo-alt fa-solid fa-location-dot"></i> 8
                                        Cities</small>
                                    <small><i class="bi bi-eye fa-solid fa-eye"></i> + Tour Places</small>
                                </p> -->
                            </div>
                        </div> </a> 
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <!-- //  tour location slider end  ----  // -->
    <!-- Destination Card Section Start -->
    <section class="c-destination-section">
        <div class="container">
            <div class="c-destination-content">
                <div class="best-title text-center">
                    <span class="heading-style">We're</span>
                    <h1>Partners Of</h1>
                    <p>Forming Partnerships And Growing Our Tour Business</p>
                </div>
                <div class="c-destination-slide-list">
                    <?php foreach ($Apiassoc as $logo) { ?>
                        <div class="c-destination-card-item">
                            <div class="c-destination-img">
                                <img src="<?= $logo ?>" alt="" class="img-fluid">
                                <!-- <div class="c-destination-card-details">
                                    <h2 class="c-destination-card-title">Paris Tour</h2>
                                    <p class="c-destination-card-text">We denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment
                                    </p>
                                    <a href="#" class="btn c-destination-card-btn">View Details</a>
                                </div> -->
                            </div>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
    </section>
    <!-- Destination Card Section End -->
    <!-- //  ---- package detail section start  ----  // -->
    <section class="package-detail" style="display:none;">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Top</span>
                <h1>Tour Packages</h1>
                <p>Explore & Check Out Our Best Deals On Tour Packages</p>
            </div>
            <div class="row">
                <div class="col col-md-12 col-lg-4 col-xl-4">
                    <div class="tour-package-card">
                        <div class="package-item-img">
                            <img src="images/canada-history.png" class="img-fluid" alt="">
                            <div class="pacakge-text">
                                <h4>Historical Tour </h4>

                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>Canada Historical Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$86 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light ">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>Canada Historical Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$85 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>Canada Historical Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$86 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 col-lg-4 col-xl-4">
                    <div class="tour-package-card">
                        <div class="package-item-img">
                            <img src="images/weekand.png" class="img-fluid" alt="">
                            <div class="pacakge-text">
                                <h4>Weekend Tour </h4>

                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>Spain Weekend Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$84 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>France Weekend Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$63 <small>/Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>London Weekend Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$75 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 col-lg-4 col-xl-4">
                    <div class="tour-package-card">
                        <div class="package-item-img">
                            <img src="images/holiday.png" class="img-fluid" alt="">
                            <div class="pacakge-text">
                                <h4>holiday Tour </h4>

                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>Usa Holiday Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$82 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>Europw Holiday Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$86 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                        <div class="card-body weekend-package">
                            <div class="state-history">
                                <div class="text-dark d-flex canada-tour">
                                    <h4>China Holiday Tour</h4>
                                    <div class="ml-auto">
                                        <p class="days">$86 <small>/ Day</small> </p>
                                    </div>
                                </div>
                                <p class="flight">Flight Tickets Not Included <span>*</span></p>
                                <small class="badge badge-space bg-light">
                                    <i class="far fa-clock"></i> 5 Days 4 Nights Trip
                                </small>
                                <small class="badge bg-light">
                                    <i class="fa-solid fa-location-dot"></i> 10 Places
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //  ----  package detail section end  ----  // -->
    <!-- Great Section Start -->
    <section class="great-section">
        <div class="container">
            <div class="great-content text-center">
                <h2 class="great-title">Get Best Tour Experience With Us!</h2>
                <p class="great-discription">Find Best Deals For Tour Packages, Hotels, Holidays, Bus Reservations For<br class="d-none d-lg-block"> India & International Travel, B2B Travel Services.</p>
                <a href="<?=BASE_URL_B2C?>/view/tours/tours-listing.php" class="btn great-btn" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-play"></i></a>
            </div>
        </div>
    </section>
    <!-- Great Section End -->
    <!-- //  ---- transpotation section start  ----  // -->
    <section class="transpotation">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Our</span>
                <h1>Tranportation Facilities</h1>
                <p>Private & Public Transportation Available For Smoother Your Ride</p>
            </div>
            <div class="widget-card border-0 transpot-vehical">
                <?php foreach ($Apitransport as $transport) {
                    if (!empty($transport->tariff)) {
                        foreach($transport->tariff as $tariff) {
                ?>
                        <div class="transpotation-cards">
                            <div class="widget-card-img">
                                <img src="crm/<?= substr($transport->image_url,9) ?>" class="card-img-top img-fluid" alt="...">
                                <div class="widget-hotel-card-item">
                                    <a href="#" class="hotel-card-item">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="transpotation-text">
                                <h6 class="mini"> <?= $transport->vehicle_name ?> </h6>
                                <p class="mini-text"><?= $transport->vehicle_type ?> </p>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="facilities-text">
                                            <i class="fas fa-check"></i>Pickup Location: <?= $tariff->tariff_entry->city_from->city_name ?> 
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="facilities-text">
                                            <i class="fas fa-check"></i>Drop Location: <?= $tariff->tariff_entry->city_to->city_name ?> 
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="facilities-text">
                                            <i class="fas fa-check"></i>From Date: <?= $tariff->tariff_entry->from_date ?> 
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="facilities-text">
                                            <i class="fas fa-check"></i>To Date: <?= $tariff->tariff_entry->to_date ?> 
                                        </div>
                                    </div>



                                </div>
                                <div class="card-footer widget-card-footer restaurant-footer">
                                    <div class="widget-star-rating widget-hotel-star">
                                        <small><?= json_decode($tariff->tariff_entry->tariff_data)[0]->total_cost  ?></small>
                                    
                                    </div>

                                </div>
                            </div>


                        </div>

                <?php }}
                } ?>
              
            </div>
        </div>
    </section>

    <!-- //  ---- transpotation section end ----  // -->
    <!-- //  ---- resturnts slider start  ----  // -->
    <section class="redturnt-slider">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Most Recommended</span>
                <h1>Popular Hotels </h1>
                <p>Explore World Wide Popular Hotels Across The World.</p>
                <?php //var_dump($Apihotel[0]); 
                ?>
            </div>
            <div class="package-card">
                <?php 
                                                            
                
                foreach ($Apihotel as $hotel) { ?>
                                 

                    <div class=" widget-card ">
                    <a href="#" onclick="get_tours_data('<?= $hotel->city_id ?>','3','<?= $hotel->hotel_id ?>')">  
                        <div class="widget-card-img">
                            <img src="<?= file_exists('crm/'. substr($hotel->hotel_image->hotel_pic_url, 11)) ? 'crm/'. substr($hotel->hotel_image->hotel_pic_url, 11) : 'images/hotel_image.png' ?>" class="card-img-top" alt="...">
                            <!-- <div class="widget-card-price">
                                    <h4>$40 <del>$50</del></h4>
                                </div> -->
                            <div class="widget-card-power">
                                <span>
                                    <i class="fa-solid fa-bolt-lightning"></i>
                                </span>
                            </div>
                            <div class="widget-hotel-card-item">
                                <a href="#" class="hotel-card-item1 australia-hart-icon">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                                <a href="#" class="hotel-card-item">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            </div>
                            <div class="restaurant-name">
                                <span class="tour-card-discription">Hotel</span>
                            </div>
                        </div>
                    </a>
                          
                    <div class="card-body widget-card-body">
                            <div class="widget-card-reviw widget-card-hotel-title mb-0">
                                <a href="#" onclick="get_tours_data('<?= $hotel->city_id ?>','3','<?= $hotel->hotel_id ?>')" class="text-decoration-none">
                                    <h5 class="card-title widget-card-title hotel-card-title">
                                        <?= $hotel->hotel_name ?>
                                    </h5>
                                    <p class="mini-text">

                                        <?= $hotel->amenities ?>
                                    </p>
                                </a>
                                <div class="widget-card-ruting widget-card-ruting-restaurant pb-0 mb-0">
                                    <a href="#" class="text-decoration-none mb-2">
                                        <span class="widget-card-ruting-location card-ruting-hotel border-0">
                                            <i class="fa-solid fa-location-dot"></i> <?= $hotel->city->city_name ?>,<?= $hotel->country ?>
                                        </span>
                                    </a>
                                    <a href="#" class="text-decoration-none mb-2 mt-2">
                                        <span class="widget-card-ruting-calendar card-ruting-hotel border-end-0 pe-0 me-0">
                                            <i class="fas fa-phone"></i><?php
                                            $mobile_no = $encrypt_decrypt->fnDecrypt($hotel->mobile_no, $secret_key);
                                                echo $mobile_no;
                                            ?>
                                        </span>
                                    </a>
                                    <!-- <span class="widget-card-ruting-time border-0 mt-2">
                                        <i class="fa-regular fa-clock"></i> 10am - 9pm
                                        <a href="#" class="btn historical-text restaurant-btn-open">Open Now</a>
                                    </span> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer widget-card-footer restaurant-footer">
                            <div class="widget-star-rating widget-hotel-star">
                                <small><?= $hotel->rating_star ?></small>
                                <!-- <input type="checkbox" id="5-restaurant4" name="restaurant4" value="5">
                                <label for="5-restaurant4" class="widget-card-star">&#9733;</label>
                                <input type="checkbox" id="4-restaurant4" name="restaurant4" value="4" checked>
                                <label for="4-restauran4t" class="widget-card-star">&#9733;</label>
                                <input type="checkbox" id="3-restaurant4" name="restaurant4" value="3">
                                <label for="3-restaurant4" class="widget-card-star">&#9733;</label>
                                <input type="checkbox" id="2-restaurant4" name="restaurant4" value="2">
                                <label for="2-restaurant4" class="widget-card-star">&#9733;</label>
                                <input type="checkbox" id="1-restaurant4" name="restaurant4" value="1">
                                <label for="1-restauran4t" class="widget-card-star">&#9733;</label> -->
                            </div>
                            <!-- <div class="restaurant-comment tour-card-discription">
                                <i class="fa-regular fa-comment"></i> 45
                            </div> -->
                        </div>
                    
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <!-- //  ---- restaurant slider end  ----  // -->


    <!-- //  ----- most holiday slider  start  -----  // -->
    <section class="-most-holiday-slider">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Best Rated</span>
                <h1>Popular Activities </h1>
                <p>Most Beautiful Places In The World</p>
            </div>
            <div class=" transpot-vehical holiday-slider">
                <?php foreach ($Apiactivity as $activity) { ?>
                    <div class=" widget-card border-0 ">
                        <a  onclick="get_tours_data('<?= $activity->city_id ?>','4','<?= $activity->entry_id ?>')">
                        <div class="widget-card-img">
                            <img src="<?= file_exists('crm/'.substr($activity->images[0]->image_url, 6)) ? 'crm/'.substr($activity->images[0]->image_url, 6) : 'images/hotel_image.png' ?>" class="card-img-top" alt="...">

                            <div class="widget-china-location">
                                <span>
                                    <i class="bi bi-geo-alt"></i> <?= $activity->departure_point ?>
                                </span>
                                <!-- <span>
                                <i class="bi bi-eye"></i> 40+ Tour Places
                            </span> -->
                            </div>
                            <!-- <div class="widget-card-price">
                                <h4>$40 <del>$50</del></h4>
                            </div> -->
                        </div>
                        </a>
                        <div class="card-body widget-card-body">
                            <div class="widget-card-reviw widget-card-china">
                                <a href="#" class="text-decoration-none china-wall" onclick="get_tours_data('<?= $activity->city_id ?>','4','<?= $activity->entry_id ?>')">
                                    <h5 class="card-title widget-card-title mb-0"><?= $activity->excursion_name ?></h5>
                                    <small class="text-muted">Duration: <?= $activity->duration ?></small>
                                </a>
                                
                            </div>
                            <div class="widget-china-day">
                                <span class="tour-card-discription">
                                    <?= substr($activity->description, 0, 100) ?> ...
                                </span>
                            </div>
                        </div>
                        <div class="card-footer widget-card-footer">
                            <small><?= $activity->basics->adult_cost ?></small>
                            <!-- <div class="china-profile">
                                <h5 class="widget-china-profile tour-card-discription mb-0">
                                    <img src="images/wendy (1).jpg" alt="" class="img-fluid">Wendy Peake
                                    <i class="fa-regular fa-circle-check"></i>
                                </h5>

                            </div>
                            <a href="#" class="holiday-heart">
                                <i class="fa-solid fa-heart"></i>
                            </a> -->
                        </div>
                    </div>

                <?php } ?>



            </div>
        </div>
    </section>
    <!-- //  ----- most holiday slider  end  -----  // -->


    <!-- Counter Section Start -->
    <section class="it-counter-v2-section">
        <div class="container">
            <div class="it-counter-v2-content">
                <div class="row g-0">
                    <div class="col col-12 col-md-6 col-lg-3">
                        <div class="it-counter-v2-card">
                            <div class="it-counter-v2-icon it-bg-primary">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <label class="it-counter-v2-label">Famous Places</label>
                            <h3 class="it-counter-v2-number" data-count="17846">0</h3>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6 col-lg-3">
                        <div class="it-counter-v2-card">
                            <div class="it-counter-v2-icon it-bg-danger">
                                <i class="fa-solid fa-signs-post"></i>
                            </div>
                            <label class="it-counter-v2-label">Famous Places</label>
                            <h3 class="it-counter-v2-number" data-count="5463">0</h3>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6 col-lg-3">
                        <div class="it-counter-v2-card">
                            <div class="it-counter-v2-icon it-bg-success">
                                <i class="fa-solid fa-user-group"></i>
                            </div>
                            <label class="it-counter-v2-label"> Our Clients</label>
                            <h3 class="it-counter-v2-number" data-count="7569">0</h3>
                        </div>
                    </div>
                    <div class="col col-12 col-md-6 col-lg-3">
                        <div class="it-counter-v2-card">
                            <div class="it-counter-v2-icon it-bg-info">
                                <i class="fa-solid fa-face-smile"></i>
                            </div>
                            <label class="it-counter-v2-label">Total Locations</label>
                            <h3 class="it-counter-v2-number" data-count="7253">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- //  ---- favaourite destination tab start  ---- // -->
    <section class="favaourite-destination" style="display:none;">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Find Your</span>
                <h1>Favourite Destination </h1>
                <p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>
            </div>
            <div class="tours-destination">
                <ul class="nav nav-pills " id="pills-tab" role="tablist">
                    <li class="nav-item item-blog-menu" role="presentation">
                        <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
                    </li>
                    <li class="nav-item item-blog-menu" role="presentation">
                        <button class="nav-link" id="pills-historical-tab" data-bs-toggle="pill" data-bs-target="#pills-historical" type="button" role="tab" aria-controls="pills-historical" aria-selected="false">Historical</button>
                    </li>
                    <li class="nav-item item-blog-menu" role="presentation">
                        <button class="nav-link" id="pills-weekend-tab" data-bs-toggle="pill" data-bs-target="#pills-weekend" type="button" role="tab" aria-controls="pills-weekend" aria-selected="false">Weekend</button>
                    </li>
                    <li class="nav-item item-blog-menu" role="presentation">
                        <button class="nav-link" id="pills-tour-tab" data-bs-toggle="pill" data-bs-target="#pills-tour" type="button" role="tab" aria-controls="pills-tour" aria-selected="false">Spacial Tour</button>
                    </li>
                    <li class="nav-item item-blog-menu" role="presentation">
                        <button class="nav-link" id="pills-holiday-tab" data-bs-toggle="pill" data-bs-target="#pills-holiday" type="button" role="tab" aria-controls="pills-holiday" aria-selected="false">Holiday Trip</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                        <div class="row">
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination  border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-1.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Historical</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">60 Reviews</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Historical Places Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Canada
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-2.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Spacial Tour</span>
                                        </div>
                                        <div class="widget-historical-offer bg-secondary">
                                            <div>
                                                <b>35%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">55 Reviews</span>
                                                <input type="checkbox" id="5-historical1" name="historical1" value="5">
                                                <label for="5-historical1" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical1" name="historical1" value="4" checked>
                                                <label for="4-historical1" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical1" name="historical1" value="3">
                                                <label for="3-historical1" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical1" name="historical1" value="2">
                                                <label for="2-historical1" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical1" name="historical1" value="1">
                                                <label for="1-historical1" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    America Special Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                720 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> America
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/2.jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-hearts">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-3.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Holiday Trip</span>
                                        </div>
                                        <div class="widget-historical-offer bg-success">
                                            <div>
                                                <b>50%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">65 Reviews</span>
                                                <input type="checkbox" id="5-historical2" name="historical2" value="5">
                                                <label for="5-historical2" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical2" name="historical2" value="4" checked>
                                                <label for="4-historical2" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical2" name="historical2" value="3">
                                                <label for="3-historical2" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical2" name="historical2" value="2">
                                                <label for="2-historical2" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical2" name="historical2" value="1">
                                                <label for="1-historical2" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    France Holiday Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                875 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> France
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Jodie Melthon
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-historical" role="tabpanel" aria-labelledby="pills-historical-tab">
                        <div class="row">
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-1.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Historical</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Historical Places Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Canada
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-4.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Historical</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    America Historical Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> America
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-5.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Historical</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    India Historical Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> India
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-weekend" role="tabpanel" aria-labelledby="pills-weekend-tab">
                        <div class="row">
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-6.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Weekend</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Canada Weekend Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Canada
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-7.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Weekend</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Spain Weekend Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Spain
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-8.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Weekend</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Americal Weekend Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> America
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-tour" role="tabpanel" aria-labelledby="pills-tour-tab">
                        <div class="row">
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-2.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Spacial Tour</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Canada Spacial Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Canada
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-9.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Spacial Tour</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Spain Spacial Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Spain
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-10.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Spacial Tour</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    London Spacial Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> London
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/1.jpg" alt="" class="img-fluid">Jodie melthon
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-holiday" role="tabpanel" aria-labelledby="pills-holiday-tab">
                        <div class="row">
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-11.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Holiday Trip</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Itly Holiday Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Itly
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Elizabeth
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-3.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Holiday Trip</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    France Holiday Tour
                                                </h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> France
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/wendy (1).jpg" alt="" class="img-fluid">Victoria
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                                <div class=" widget-card widget-destination border-0">
                                    <div class="widget-card-img">
                                        <img src="images/tour-f-12.png" class="card-img-top" alt="...">
                                        <div class="widget-china-tour widget-historical-tour">
                                            <span>Canada Holiday Trip</span>
                                        </div>
                                        <div class="widget-historical-offer">
                                            <div>
                                                <b>23%</b>
                                                <span>OFF</span>
                                            </div>
                                        </div>
                                        <!-- <div class="widget-china-location">
                                                    <span><i class="bi bi-geo-alt"></i> 30 Cities</span>
                                                    <span><i class="bi bi-eye"></i>  40+ Tour Places </span>
                                                </div> -->
                                        <!-- <div class="widget-card-price">
                                                    <h4>$40 <del>$50</del></h4>
                                                </div> -->
                                    </div>
                                    <div class="card-body widget-card-body">
                                        <div class="widget-card-reviw widget-card-china d-inline">
                                            <div class="widget-star-rating widget-historical-rating">
                                                <span class="tour-card-discription">(45 Reviews)</span>
                                                <input type="checkbox" id="5-historical" name="historical" value="5">
                                                <label for="5-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="4-historical" name="historical" value="4" checked>
                                                <label for="4-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="3-historical" name="historical" value="3">
                                                <label for="3-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="2-historical" name="historical" value="2">
                                                <label for="2-historical" class="widget-card-star">&#9733;</label>
                                                <input type="checkbox" id="1-historical" name="historical" value="1">
                                                <label for="1-historical" class="widget-card-star">&#9733;</label>
                                            </div>
                                            <a href="#" class="text-decoration-none">
                                                <h5 class="card-title widget-card-title historical-card-title">
                                                    Canada Holiday Tour</h5>
                                            </a>
                                        </div>
                                        <div class="widget-historical-location">
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-eye"></i>
                                                615 Visiting
                                                Places
                                            </span>
                                            <span class="tour-card-discription">
                                                <i class="fa-solid fa-location-dot"></i> Canada
                                            </span>
                                        </div>
                                        <p class="card-text widget-card-text historical-text">
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </p>
                                    </div>
                                    <div class="card-footer widget-card-footer">
                                        <div class="china-profile historical-profile">
                                            <h5 class="widget-china-profile tour-card-discription mb-0">
                                                <img src="images/jodie.jpg" alt="" class="img-fluid">Jodie Melton
                                                <i class="fa-regular fa-circle-check"></i>
                                            </h5>

                                        </div>
                                        <a href="#" class="holiday-heart">
                                            <i class="fa-solid fa-heart text-pink"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //  ---- favaourite destination tab end  ---- // -->

    <!-- Testimonail Section Start -->
    <section class="it-testimonail-v2-section">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Our</span>
                <h1>Customer Says </h1>
                <p>We're Professionally Managed Travel Service Providing Company. Committed To Total Customer Satisfaction & Enhancing Value Of Money.</p>
            </div>
            <div class="it-testimonail-v2-slider">
                <?php foreach ($Apitestimonial as $testimonial) { ?>
                    <div class="it-testimonail-v2-slide">
                        <div class="it-testimonail-v2-card">
                            <div class="it-testimonail-v2-img">
                                <img src="crm/<?= substr($testimonial->image, 9) ?>" class="img-fluid" alt="images">
                            </div>
                            <div class="it-testimonail-v2-card-body">
                                <h4 class="it-testimonail-v2-title"><?= $testimonial->name  ?> (<?= $testimonial->designation  ?>)</h4>
                                <ul class="it-testimonail-v2-review-list">
                                    <li class="it-testimonail-v2-review-item it-review-selected">
                                        <i class="fa fa-star"> </i>
                                    </li>
                                    <li class="it-testimonail-v2-review-item it-review-selected">
                                        <i class="fa fa-star"> </i>
                                    </li>
                                    <li class="it-testimonail-v2-review-item it-review-selected">
                                        <i class="fa fa-star"> </i>
                                    </li>
                                    <li class="it-testimonail-v2-review-item it-review-selected">
                                        <i class="fa fa-star"> </i>
                                    </li>
                                    <li class="it-testimonail-v2-review-item">
                                        <i class="fa fa-star"> </i>
                                    </li>
                                </ul>
                                <p class="it-testimonail-v2-description"> <?= substr($testimonial->testm, 0, 150)  ?> </p>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </section>
    <!-- Testimonail Section End -->
    <!-- Travel Bird Section Start -->
    <section class="t-bird-section">
        <div class="container">
            <div class="t-bird-content text-center">
                <h2 class="t-bird-style">Where Would Like To Go</h2>
                <h2 class="t-bird-title">Travel Like A Free Bird & Enjoy Your Life</h2>
                <div class="input-group t-bird-input">
                    <input type="text" class="form-control" placeholder="      " aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <a href="" class="input-group-text btn t-bird-btn" id="basic-addon2">Signup</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Travel Bird Section End -->

    <!-- Features Section Start -->
    <section class="feature-section">
        <div class="container">
            <div class="feature-content">
                <div class="feature-title-content text-center">
                    <h2 class="feature-subtitle">Why</h2>
                    <h2 class="feature-title">Choose Us</h2>
                    <p class="feature-discription mb-0">View Our Most Valuable USP's Which Keep Us Always Motivated.</p>
                </div>
                <div class="row">
                    <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="feature-item text-center">
                            <div class="feature-img">
                                <i class="fa-regular fa-thumbs-up"></i>
                            </div>
                            <div class="feature-points">
                                <h4 class="feature-points-title">Best Quality Services</h4>
                                <small class="feature-points-discription">With our highly trained operations team,
                                    we keep a look out for even the most minute of issues.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="feature-item text-center">
                            <div class="feature-img feature-travellers-img">
                                <i class="fa-solid fa-shield"></i>
                            </div>
                            <div class="feature-points">
                                <h4 class="feature-points-title">Easy Tour Booking</h4>
                                <small class="feature-points-discription">We believe in providing hassle free and convenient
                                    tour booking options to our guests.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-md-12 col-lg-4 col-xl-4">
                        <div class="feature-item text-center">
                            <div class="feature-img feature-support-img">
                                <i class="fa-solid fa-headphones"></i>
                            </div>
                            <div class="feature-points">
                                <h4 class="feature-points-title">Quick Assistance For Guests</h4>
                                <small class="feature-points-discription">With our highly trained operations team,
                                    we keep a look out for even the most minute of issues.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features Section End -->
    <!-- //  ---- blog news section start  ----  // -->
    <section class="blog-section">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">New</span>
                <h1>Gallery </h1>
                <p>View Our Recent Client Experiences Of Various Destinations Through Images.</p>
            </div>
            <div class="row">

                <?php foreach ($Apigallery as $image) { ?>
                    <div class="col col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="blog-news">
                            <div class="blog-news-img">
                                <img src="crm/<?= substr($image->image_url, 9) ?>" class="img-fluid" alt="">
                            </div>
                            <!-- <div class="bolg-text">
                                <h4 class="blog-trip">New Trip With Gowell</h4>
                                <small class="blog-tip text-warning"><i class="fa-solid fa-tag"></i>Blog</small>
                                <small class="blog-date ms-4"><i class="fa-solid fa-calendar-days"></i>27 Jul
                                    2020</small>
                                <small class="blog-name ms-4"><i class="fas fa-user"></i>John Smith</small>
                            </div> -->
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>
    </section>
    <!-- //  ---- blog news section end  ----  // -->
    <!-- // ---- app download section start  ---- // -->
    <section class="app">
        <div class="container">
            <div class="best-title text-center">
                <span class="heading-style">Quick</span>
                <h1>Contact</h1>
                <p>We're Always Curious To Provide a Promt Services To You. Let's Connect!</p>
            </div>
            <div class="btn-list">
                <!--  <a href="#" class="btn apple-btn">
                    <i class="fab fa-apple"></i> App Store</a> -->
                <a href="" class="btn google-btn">
                    <i class="fa-solid fa-phone"></i>Arrange Call back</a>
                <!--  <a href="#" class="btn window-btn">
                    <i class="fa-brands fa-windows"></i>Windows</a> -->
            </div>
        </div>
    </section>
    <!-- // ---- app download section end  ---- // -->
    <!-- Great Adventure Modal Start -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content great-modal-content">
                <button type="button" class="btn-close great-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="modal-body great-modal-body p-0">
                    <video src="images/great.mp4" controls class="w-100 h-100"></video>
                </div>
            </div>
        </div>
    </div>
    <!-- Great Adventure Modal End -->

</main>
<!-- Site Content End -->



<a href="#" class="scrollup">Scroll</a>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields

    (function() {

        'use strict';

        window.addEventListener('load', function() {

            // Fetch all the forms we want to apply custom Bootstrap validation styles to

            var forms = document.getElementsByClassName('needs-validation');

            // Loop over them and prevent submission

            var validation = Array.prototype.filter.call(forms, function(form) {

                form.addEventListener('submit', function(event) {

                    if (form.checkValidity() === false) {

                        event.preventDefault();

                        event.stopPropagation();

                    }

                    form.classList.add('was-validated');

                }, false);

            });

        }, false);

    })();
</script>

<?php

include 'layouts/footer.php';

?>

<script type="text/javascript" src="view/hotel/js/index.js"></script>

<script type="text/javascript" src="view/transfer/js/index.js"></script>

<script type="text/javascript" src="view/activities/js/index.js"></script>

<script type="text/javascript" src="view/tours/js/index.js"></script>

<script type="text/javascript" src="view/group_tours/js/index.js"></script>

<script type="text/javascript" src="js/scripts.js"></script>

<script>
    $(document).ready(function() {

        /////// Next 10th day onwards date display

        var tomorrow = new Date();

        tomorrow.setDate(tomorrow.getDate() + 10);

        var day = tomorrow.getDate();

        var month = tomorrow.getMonth() + 1

        var year = tomorrow.getFullYear();

        $('#travelDate').datetimepicker({
            timepicker: false,
            format: 'm/d/Y',
            minDate: tomorrow
        });



        $('#checkInDate, #checkOutDate, #checkDate').datetimepicker({
            timepicker: false,
            format: 'm/d/Y',
            minDate: new Date()
        });

        $('#pickup_date').datetimepicker({
            format: 'm/d/Y H:i',
            minDate: new Date()
        });

        document.getElementById('return_date').readOnly = true;



        var service = '<?php echo $service; ?>';

        if (service && (service !== '' || service !== undefined)) {

            var checkLink = $('.c-searchContainer .c-search-tabs li');

            var checkTab = $('.c-searchContainer .search-tab-content .tab-pane');

            checkLink.each(function() {

                var child = $(this).children('.nav-link');

                if (child.data('service') === service) {

                    $(this).siblings().children('.nav-link').removeClass('active');

                    child.addClass('active');

                }

            });

            checkTab.each(function() {

                if ($(this).data('service') === service) {

                    $(this).addClass('active show').siblings().removeClass('active show');

                }

            })

        }

    });
</script>
<script type="text/javascript">
    $(function() {
        //prepare Your data array with img urls
        var dataArray = [
            <?php
            foreach ($Apibanner as $banner) {
                echo '"crm/' . substr($banner->image_url, 9) . '",';
            }
            ?>
        ];


        //start with id=0 after 5 seconds
        var thisId = 0;

        window.setInterval(function() {
            $('.booking-banner').attr('style', "background-image:url('" + dataArray[thisId] + "');");
            thisId++; //increment data array id
            if (thisId == dataArray.length) thisId = 0; //repeat from start
        }, 5000);
    });
</script>