    <?php

include 'config.php';

$service = $_GET['service'];

global $app_contact_no,$currency;

$package_id=explode('.',explode('-',basename($_SERVER['PHP_SELF']))[1])[0];

$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$package_id'"));

$sq_curr = mysqli_fetch_assoc(mysqlQuery("select * from currency_name_master where id=$sq_package[currency_id]"));

$sq_destination= mysqli_fetch_assoc(mysqlQuery("select * from destination_master where dest_id=$sq_package[dest_id]"));

$sq_package_program = mysqlQuery("select * from custom_package_program where package_id = '$package_id'");

$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Quotation' and dest_id='$sq_package[dest_id]' and active_flag ='Active'"));

//Include header

include 'layouts/header.php';

$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));

$to_currency_rate = $sq_to['currency_rate'];



// Costing from tariff

$costing_array = array();

$offer_options_array = array();

$all_orgcosts_array= array();

$total_cost1 = 0;

$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$sq_package[currency_id]'"));

$from_currency_rate = $sq_from['currency_rate'];



$tomorrow = date("Y-m-d", strtotime("+10 day"));

$tom_date = date("d-m-Y", strtotime("+10 day"));

$sq_tariff = mysqlQuery("select * from custom_package_tariff where (`from_date` <= '$tomorrow' and `to_date` >= '$tomorrow') and (`min_pax` <= '1' and `max_pax` >= '1') and `package_id`='$package_id'");

$row_tariff = mysqli_fetch_assoc($sq_tariff);

    

    $total_cost1 = floatval($row_tariff['cadult']);

    $h_currency_id = $sq_package['currency_id'];

    $c_amount1 = ($to_currency_rate!=0) ? ($from_currency_rate / $to_currency_rate * $total_cost1) : 0;

?>

<!-- Landing Section Start -->
<!-- 
<section class="ts-inner-landing-section ts-best-place-landing-section ts-font-poppins" style="background-image: url(../images/title-background.jpg);">

    <div class="ts-inner-landing-content">

        <div class="container">

            <div class="row">

                <div class="col col-12 col-md-12 col-lg-8 col-xl-9">

                    <h1 class="ts-section-title"><?//= $sq_package['package_name'] ?></h1>

                </div>

                <div class="col col-12 col-md-12 col-lg-4 col-xl-3">

                    <div class="ts-best-place-price-content">

                        <div class="ts-best-place-price-header">

                            <label>Start Price *</label>

                        </div>

                        <div class="ts-best-place-price-body">

                                <span class="p_currency currency-icon"></span>

                                <span class="best-currency-price"><?//= $total_cost1 ?></span>

                                <span class="c-hide best-currency-id"><?//= $h_currency_id ?></span>(PP)

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect pb-0">

<div class="container">

  <div class="row align-items-center">

    <div class="col col-12 col-md-12 col-lg-8 col-xl-9">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle"><?= $sq_package['package_name'] ?></span>

      </div>

      <!-- *** Search Head End **** -->

    </div>

    <div class="col col-12 col-md-12 col-lg-4 col-xl-3">

        <div class="ts-best-place-price-content">

            <div class="ts-best-place-price-header">

                <label>Start Price *</label>

            </div>

            <div class="ts-best-place-price-body">

                    <span class="p_currency currency-icon"></span>

                    <span class="best-currency-price"><?= $total_cost1 ?></span>

                    <span class="c-hide best-currency-id"><?= $h_currency_id ?></span>(PP)

                </p>

            </div>

        </div>

        </div>

    <!-- <div class="col-md-5 col-12 c-breadcrumbs">

       <ul>

        <li>

          <a href="<?//= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)"><?//= $sq_package['title'] ?></a>

        </li>

      </ul> 

    </div>-->



  </div>

</div>

</div>

<!-- ********** Component :: Page Title End ********** -->


<!-- Reason Section End -->

<section class="ts-reason-section ts-font-poppins ts-best-place-section">

    <div class="container">

        <div class="row">

            <div class="col col-12 col-md-12 col-lg-8 col-xl-9">

                <div class="ts-blog-info">

                    <p class="ts-blog-time">

                        <i class="fa fa-clock-o" aria-hidden="true"></i>

                        <a href="#"><?= $sq_package['total_nights'] ?> Nights, <?= $sq_package['total_days'] ?> Days</a>

                    </p>

                    <p class="ts-blog-time ml-auto">

                        <i class="fa fa-bookmark" aria-hidden="true"></i>

                        <a href="#"><?= $sq_destination['dest_name'] ?></a>

                    </p>

                </div>

                <div class="ts-best-place-slider owl-carousel owl-theme">

                    <?php

                    if($sq_package['dest_image']!= 0){

                        $row_gallary = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id='$sq_package[dest_image]'"));

                        $url = $row_gallary['image_url'];

                        $pos = strstr($url,'uploads');

                        if ($pos != false)   {

                            $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 

                            $newUrl = BASE_URL.str_replace('../', '', $newUrl1);

                        }

                        else{

                            $newUrl =  $row_gallary['image_url']; 

                        }

                        ?>

                        <div class="item">

                            <img src="<?= $newUrl ?>" alt="Package Image" class="img-fluid">

                        </div>

                    <?php

                    }

                    $img_count = 0;

                    $sq_gallary = mysqlQuery("select * from gallary_master where dest_id='$sq_package[dest_id]' order by entry_id desc");

                    while($row_gallary = mysqli_fetch_assoc($sq_gallary)){

                        if($img_count>9){

                            break;

                        }

                        $url = $row_gallary['image_url'];

                        $pos = strstr($url,'uploads');

                        if ($pos != false)   {

                            $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 

                            $newUrl = BASE_URL.str_replace('../', '', $newUrl1);

                        }

                        else{

                            $newUrl =  $row_gallary['image_url']; 

                        }

                        ?>

                        <div class="item">

                            <img src="<?= $newUrl ?>" alt="Package Image" class="img-fluid">

                        </div>

                        <?php

                        $img_count++;

                        } ?>

                </div>

                <ul class="nav nav-pills" id="pills-tab" role="tablist">

                    <li class="nav-item">

                        <a class="nav-link active" id="pills-overview-tab" data-toggle="pill" href="#pills-overview" role="tab" aria-controls="pills-overview" aria-selected="true">OVERVIEW</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" id="pills-travel-tab" data-toggle="pill" href="#pills-travel" role="tab" aria-controls="pills-travel" aria-selected="false">Travel & Stay</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" id="pills-inclusion-tab" data-toggle="pill" href="#pills-inclusion" role="tab" aria-controls="pills-inclusion" aria-selected="false">Inclusion</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" id="pills-exclusion-tab" data-toggle="pill" href="#pills-exclusion" role="tab" aria-controls="pills-exclusion" aria-selected="false">Exclusion</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" id="pills-terms-tab" data-toggle="pill" href="#pills-terms" role="tab" aria-controls="pills-terms" aria-selected="false">Terms & Conditions</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" id="pills-covid-tab" data-toggle="pill" href="#pills-covid" role="tab" aria-controls="pills-covid" aria-selected="false">Covid 19</a>

                    </li>

                </ul>

                <div class="tab-content ts-tab-content" id="pills-tabContent">

                    <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab">

                        <div class="ts-tab-content__inner">

                            <p><?= $sq_package['note'] ?></p>

                            <div id="OverviewAccordion">

                                <?php

                                $count=1;

                                while($row_program = mysqli_fetch_assoc($sq_package_program)){

                                    if($count == '1'){

                                        $show_class="show";

                                    }else{ $show_class=""; }

                                ?>

                                <div class="card">

                                    <div class="card-header" id="OverviewheadingOne<?=$count?>">

                                    <h5 class="mb-0">

                                        <button class="btn btn-link" data-toggle="collapse" data-target="#OverviewcollapseOne<?=$count?>" aria-expanded="true" aria-controls="OverviewcollapseOne<?=$count?>">

                                            <span class="ts-accordian-icon"></span><span> Day-<?=$count.'  '?><?= $row_program['attraction'] ?></span>

                                        </button>

                                    </h5>

                                </div>



                                <div id="OverviewcollapseOne<?=$count?>" class="collapse <?= $show_class ?>" aria-labelledby="OverviewheadingOne<?=$count?>" data-parent="#OverviewAccordion">

                                    <div class="card-body">

                                        <?= $row_program['day_wise_program'] ?>

                                        <ul  class="ts-tours-night-list">

                                            <li class="ts-tours-night-item">

                                                <span>Overnight Stay</span>

                                            </li>

                                            <li class="ts-tours-night-item ts-tours-night-name-item">

                                                <span><?= $row_program['stay'] ?></span>

                                            </li>

                                        </ul>

                                        <?php

                                        if($row_program['meal_plan']!=''){ ?>

                                        <ul  class="ts-tours-night-list">

                                            <li class="ts-tours-night-item">

                                                <span>Meals</span>

                                            </li>

                                            <li class="ts-tours-night-item ts-tours-night-name-item">

                                                <span><i class="fa fa-spoon" aria-hidden="true"></i> <?= $row_program['meal_plan'] ?></span>

                                            </li>

                                        </ul>

                                        <?php } ?>

                                    </div>

                                    </div>

                                </div>

                                <?php

                                $count++;} ?>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-travel" role="tabpanel" aria-labelledby="pills-travel-tab">

                        <div class="ts-tab-content__inner">

                            <?php

                            $sq_h_count = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id = '$package_id'"));

                            if($sq_h_count > 0){

                                ?>

                                <!-- Package Hotels -->

                                <legend>Hotel Information</legend>

                                <div class="table-responsive">

                                    <table class="table table_bordered">

                                        <thead>

                                            <th>City Name</th>

                                            <th>Hotel Name</th>

                                            <th>Hotel Category</th>

                                            <th>Total Nights</th>

                                        </thead>

                                        <tbody>

                                            <?php

                                            $sq_hotel = mysqlQuery("select * from custom_package_hotels where package_id = '$package_id'");

                                            while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                                                $sq_hcity = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id = '$row_hotel[city_name]'"));

                                                $sq_hhotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name,hotel_id from hotel_master where hotel_id = '$row_hotel[hotel_name]'"));

                                                ?>

                                                <tr>

                                                    <td><?= $sq_hcity['city_name'] ?></td>

                                                    <td><?= $sq_hhotel['hotel_name'] ?></td>

                                                    <td><?= $row_hotel['hotel_type'] ?></td>
de
                                                    <td><?= $row_hotel['total_days'] ?></td>

                                                </tr>

                                                <?php

                                            }

                                            ?>

                                        </tbody>

                                    </table>

                                </div>

                            <?php } ?>

                            <!-- Package Transport -->

                            <?php

                            $sq_tr_count = mysqli_num_rows(mysqlQuery("select * from custom_package_transport where package_id = '$package_id'"));

                            if($sq_tr_count > 0){

                                ?>

                                <legend>Transport Information</legend>

                                <div class="table-responsive">

                                    <table class="table table_bordered">

                                        <thead>

                                            <th>Vehicle Name</th>

                                            <th>Pickup Location</th>

                                            <th>Dropoff Location</th>

                                        </thead>

                                        <tbody>

                                            <?php

                                            $sq_hotel = mysqlQuery("select * from custom_package_transport where package_id = '$package_id'");

                                            while($row_trans = mysqli_fetch_assoc($sq_hotel)){



                                                $sq_vehicle = mysqli_fetch_assoc(mysqlQuery("select entry_id,vehicle_name from b2b_transfer_master where entry_id = '$row_trans[vehicle_name]'"));

                                                

                                                // Pickup

                                                if($row_trans['pickup_type'] == 'city'){

                                                    $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_trans[pickup]'"));

                                                    $pickup = $row['city_name'];

                                                }

                                                else if($row_trans['pickup_type'] == 'hotel'){

                                                    $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_trans[pickup]'"));

                                                    $pickup = $row['hotel_name'];

                                                }

                                                else{

                                                    $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_trans[pickup]'"));

                                                    $airport_nam = clean($row['airport_name']);

                                                    $airport_code = clean($row['airport_code']);

                                                    $pickup = $airport_nam." (".$airport_code.")";

                                                    $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';

                                                }

                                                // Drop

                                                if($row_trans['drop_type'] == 'city'){

                                                    $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_trans[drop]'"));

                                                    $drop = $row['city_name'];

                                                }

                                                else if($row_trans['drop_type'] == 'hotel'){

                                                    $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_trans[drop]'"));

                                                    $drop = $row['hotel_name'];

                                                }

                                                else{

                                                    $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_trans[drop]'"));

                                                    $airport_nam = clean($row['airport_name']);

                                                    $airport_code = clean($row['airport_code']);

                                                    $drop = $airport_nam." (".$airport_code.")";

                                                }

                                                ?>

                                                <tr>

                                                    <td><?= $sq_vehicle['vehicle_name'] ?></td>

                                                    <td><?= $pickup ?></td>

                                                    <td><?= $drop ?></td>

                                                </tr>

                                                <?php

                                            }

                                            ?>

                                        </tbody>

                                    </table>

                                </div>

                            <?php } ?>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-inclusion" role="tabpanel" aria-labelledby="pills-inclusion-tab">

                        <div class="ts-tab-content__inner">

                            <div class="custom_texteditor">

                                <p><?= $sq_package['inclusions'] ?></p>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-exclusion" role="tabpanel" aria-labelledby="pills-exclusion-tab">

                        <div class="ts-tab-content__inner">

                            <div class="custom_texteditor">

                                <p><?= $sq_package['exclusions'] ?></p>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-terms" role="tabpanel" aria-labelledby="pills-terms-tab">

                        <div class="ts-tab-content__inner">

                            <div class="custom_texteditor">

                                <p><?= $sq_terms_cond['terms_and_conditions'] ?></p>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-covid" role="tabpanel" aria-labelledby="pills-covid-tab">

                        <div class="ts-tab-content__inner">

                            <p>Static Content..</p>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-12 col-lg-4 col-xl-3">

                <div class="ts-best-place-enquiry-content">

                <div class="ts-contact-form">

                    <h3 class="ts-contact-form-title">Get In Touch</h3>

                    <form id="getInTouch_form" class="needs-validation" novalidate>

                        <input type="hidden" id="package_name" value="<?=$sq_package['package_name']?>"/>

                        <!-- <input type="hidden" id="travel_date" value="<?= $tom_date ?>"/> -->

                        <div class="form-row">

                            <div class="form-group col-md-12">

                                <input type="text" class="form-control" id="inputNamep" name="inputNamep" placeholder="*Name" onkeypress="return blockSpecialChar(event)" required>

                            </div>

                            <div class="form-group col-md-12">

                                <input type="email" class="form-control" id="inputEmailp" name="inputEmailp" placeholder="*Email" required>

                            </div>

                            <div class="form-group col-md-12">

                                <input type="number" class="form-control" id="inputPhonep" name="inputPhonep" placeholder="*Phone" required>

                            </div>

                        </div>

                        <div class="form-group">

                            <textarea id="inputMessagep" name="inputMessagep" rows="8" class="form-control" placeholder="*Your Enquiry" required></textarea>

                        </div>

                        <button type="submit" id="getInTouch_btn" class="btn btn-primary">Send Message</button>

                    </form>
                    <div class="ts-video-content mt-5">
                        <h2 class="ts-video-title">Destination video guide..</h2>
                        <?php
                        $sq_dest = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_package[dest_id]'"));
                        ?>
                        <iframe width="100%" src="<?=$sq_dest['link']?>" title="Destination video guide" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                </div>

            </div>

        </div>

        <div class="row text-center">

            <div class="col col-12 col-md-12 col-lg-4 col-xl-8">

                <div class="clearfix">

                    <button class="c-button md" id='<?=$tours_result_array[$i]['package_id']?>' onclick="redirect_to_action_page('<?= $package_id ?>','1','','','','','','','<?=$tom_date?>');"><i class="fa fa-phone-square" aria-hidden="true"></i>  Enquiry</button>

                    <button class="c-button g-button md" id='<?=$tours_result_array[$i]['package_id']?>' onclick="redirect_to_action_page('<?= $package_id ?>','1','','','','','','','<?=$tom_date?>');"><i class="fa fa-address-book" aria-hidden="true"></i>  Book</button>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Reason Section End -->



<?php

$sq_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where dest_id = '$sq_package[dest_id]' and package_id!='$sq_package[package_id]'"));

if($sq_count>0){

    ?>

    <!-- Destinations Section Start -->

    <section class="ts-destinations-section">

        <div class="container">

            <div class="ts-section-subtitle-content">

                <h2 class="ts-section-subtitle">PACK AND GO</h2>

                <span class="ts-section-subtitle-icon"><img src="<?=BASE_URL_B2C?>images/traveler.png" alt="traveler" classimg-fluid></span>

            </div>

            <h2 class="ts-section-title">Related Packages</h2>

    

            <div class="ts-blog-content">

                <div class="row">

                    <?php

                    $sq_dest = mysqlQuery("select * from custom_package_master where dest_id = '$sq_package[dest_id]' and package_id!='$sq_package[package_id]'");

                    while($row_package = mysqli_fetch_assoc($sq_dest)){

                        if ($i>5) {

                            break;

                        }

                        $package_id = $row_package['package_id'];

                        // Package file name

                        $package_fname = str_replace(' ', '_', $row_package['package_name']);

                        $file_name = BASE_URL_B2C.'package_tours/'.$package_fname.'-'.$package_id.'.php';

                        // Package Image

                        $sq_image = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id='$row_package[dest_image]'"));

                        $url = $sq_image['image_url'];

                        $pos = strstr($url,'uploads');

                        if ($pos != false)   {

                            $newUrl = preg_replace('/(\/+)/','/',$url); 

                            $newUrl1 = BASE_URL.str_replace('../', '', $newUrl);

                        }

                        else{

                            $newUrl1 =  $url; 

                        }

                        $package_name1 = substr($row_package['package_name'], 0, 22).'..';

                        ?>

                        <div class="col col-12 col-md-6 col-lg-4">

                            <div class="ts-blog-card">

                                <div class="ts-blog-card-img">

                                    <a href="#" class="ts-blog-card-img-link">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0003C515.9 484.7 515.9 459.3 500.3 443.7zM288 232H231.1V288c0 13.26-10.74 24-23.1 24C194.7 312 184 301.3 184 288V232H127.1C114.7 232 104 221.3 104 208s10.74-24 23.1-24H184V128c0-13.26 10.74-24 23.1-24S231.1 114.7 231.1 128v56h56C301.3 184 312 194.7 312 208S301.3 232 288 232z" fill="#ffffff"/></svg>

                                    </a>

                                    <img src="<?= $newUrl1 ?>" alt="Package Image" class="img-fluid">

                                </div>

                                <div class="ts-blog-card-body">

                                    <a href="<?= $file_name ?>" class="ts-blog-card-title"><?= $package_name1 ?></a>

                                    <p class="ts-blog-time">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z" fill="#f68c34"/></svg>

                                        <span><?= $row_package['total_nights'] ?> Nights, <?= $row_package['total_days'] ?> Days</span>

                                    </p>

                                    <p class="ts-blog-card-description"><?= $row_package['note'] ?> </p>

                                </div>

                                <div class="ts-blog-card-footer">

                                    <a href="<?= $file_name ?>" target="_blank" class="ts-blog-card-link"> READ MORE</a>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>

    </section>

    <!-- Destinations Section End -->

<?php } ?>

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

<?php include 'layouts/footer.php';?>

<script type="text/javascript" src="<?= BASE_URL_B2C ?>js/scripts.js"></script>

<script>

    $( document ).ready(function() {

    

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

        

        

        var amount_list1 = document.querySelectorAll(".best-currency-price");

        var amount_id1 = document.querySelectorAll(".best-currency-id");

        

        //Tours Best Cost

        var amount_arr1 = [];

        for(var i=0;i<amount_list1.length;i++){

            amount_arr1.push({

                'amount':amount_list1[i].innerHTML,

                'id':amount_id1[i].innerHTML});

        }

        sessionStorage.setItem('tours_best_amount_list',JSON.stringify(amount_arr1));

        

        setTimeout(() => {

            tours_page_currencies();

        },500);

        });

</script>