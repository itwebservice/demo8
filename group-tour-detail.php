<?php

include 'config.php';

$service = $_GET['service'];

global $app_contact_no,$currency;



$tour_id=explode('.',explode('-',basename($_SERVER['PHP_SELF']))[1])[0];

$sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id = '$tour_id'"));

$sq_destination= mysqli_fetch_assoc(mysqlQuery("select * from destination_master where dest_id=$sq_tour[dest_id]"));

$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Group Quotation' and active_flag ='Active'"));

$sq_tour_program = mysqlQuery("select * from group_tour_program where tour_id = '$tour_id'");



//Include header

include 'layouts/header.php';

$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));

$to_currency_rate = $sq_to['currency_rate'];



// Costing from tariff

$costing_array = array();

$offer_options_array = array();

$all_orgcosts_array= array();

$total_cost1 = 0;

$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$sq_tour[currency_id]'"));

$from_currency_rate = $sq_from['currency_rate'];



$tom_date = date("d-m-Y", strtotime("+10 day"));



$total_cost1 = floatval($sq_tour['adult_cost']);

$h_currency_id = $currency;

$c_amount1 = ($to_currency_rate!=0) ? ($from_currency_rate / $to_currency_rate * $total_cost1) : 0;

?>

<!-- Landing Section Start 

style="background-image: url(../images/title-background.jpg); -->

<section class="ts-inner-landing-section ts-best-place-landing-section ts-font-poppins" style="background-color: #2d3e52">

    <div class="ts-inner-landing-content">

        <div class="container">

            <div class="row">

                <div class="col col-12 col-md-12 col-lg-8 col-xl-9">

                    <h1 class="ts-section-title"><?= $sq_tour['tour_name'] ?></h1>

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

            </div>

        </div>

    </div>

</section>



<!-- Reason Section End -->

<section class="ts-reason-section ts-font-poppins ts-best-place-section">

    <div class="container">

        <div class="row">

            <div class="col col-12 col-md-12 col-lg-8 col-xl-9">

                <div class="ts-blog-info">

                    <p class="ts-blog-time ml-auto">

                        <i class="fa fa-bookmark" aria-hidden="true"></i>

                        <a href="#"><?= $sq_destination['dest_name'] ?></a>

                    </p>

                </div>

                <div class="ts-best-place-slider owl-carousel owl-theme">

                    <?php

                    if($sq_tour['dest_image']!= 0){

                        $row_gallary = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id='$sq_tour[dest_image]'"));

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

                    $sq_gallary = mysqlQuery("select * from gallary_master where dest_id='$sq_tour[dest_id]' order by entry_id desc");

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

                            <img src="<?= $newUrl ?>" alt="Group Tour Image" class="img-fluid">

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

                            <p><?= $sq_tour['note'] ?></p>

                            <div id="OverviewAccordion">

                                <?php

                                $count=1;

                                while($row_program = mysqli_fetch_assoc($sq_tour_program)){

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

                            // Hotel

                            $sq_h_count = mysqli_num_rows(mysqlQuery("select * from group_tour_hotel_entries where tour_id = '$tour_id'"));

                            if($sq_h_count > 0){

                                ?>

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

                                            $sq_hotel = mysqlQuery("select * from group_tour_hotel_entries where tour_id = '$tour_id'");

                                            while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                                                $sq_hcity = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id = '$row_hotel[city_id]'"));

                                                $sq_hhotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name,hotel_id from hotel_master where hotel_id = '$row_hotel[hotel_id]'"));

                                                ?>

                                                <tr>

                                                    <td><?= $sq_hcity['city_name'] ?></td>

                                                    <td><?= $sq_hhotel['hotel_name'] ?></td>

                                                    <td><?= $row_hotel['hotel_type'] ?></td>

                                                    <td><?= $row_hotel['total_nights'] ?></td>

                                                </tr>

                                                <?php

                                            }

                                            ?>

                                        </tbody>

                                    </table>

                                </div>

                            <?php } ?>

                            <?php

                            // Train

                            $sq_h_count = mysqli_num_rows(mysqlQuery("select * from group_train_entries where tour_id = '$tour_id'"));

                            if($sq_h_count > 0){

                                ?>

                                <legend>Train Information</legend>

                                <div class="table-responsive">

                                    <table class="table table_bordered">

                                        <thead>

                                            <th>From_Location</th>

                                            <th>To_Location</th>

                                            <th>Class</th>

                                        </thead>

                                        <tbody>

                                            <?php

                                            $sq_hotel = mysqlQuery("select * from group_train_entries where tour_id = '$tour_id'");

                                            while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                                                ?>

                                                <tr>

                                                    <td><?= $row_hotel['from_location'].$similar_text ?></td>

                                                    <td><?= $row_hotel['to_location'] ?></td>

                                                    <td><?= $row_hotel['class'] ?></td>

                                                </tr>

                                                <?php

                                            }

                                            ?>

                                        </tbody>

                                    </table>

                                </div>

                            <?php } ?>

                            <?php

                            // Flight

                            $sq_h_count = mysqli_num_rows(mysqlQuery("select * from group_tour_plane_entries where tour_id = '$tour_id'"));

                            if($sq_h_count > 0){

                                ?>

                                <legend>Flight Information</legend>

                                <div class="table-responsive">

                                    <table class="table table_bordered">

                                        <thead>

                                            <th>From_Location</th>

                                            <th>To_Location</th>

                                            <th>Airline</th>

                                            <th>Class</th>

                                        </thead>

                                        <tbody>

                                            <?php

                                                $count = 0;

                                                $sq_hotel = mysqlQuery("select * from group_tour_plane_entries where tour_id='$tour_id'");

                                                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                                                    $sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_hotel[airline_name]'"));

                                                    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_hotel[from_city]'"));

                                                    $sq_city1 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_hotel[to_city]'"));

                                                ?>

                                                <tr>

                                                    <td><?= $sq_city['city_name'].' ('.$row_hotel['from_location'].')' ?></td>

                                                    <td><?= $sq_city1['city_name'].' ('.$row_hotel['to_location'].')' ?></td>

                                                    <td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>

                                                    <td><?= $row_hotel['class'] ?></td>

                                                </tr>

                                                <?php

                                            }

                                            ?>

                                        </tbody>

                                    </table>

                                </div>

                            <?php } ?>

                            <?php

                            // Cruise

                            $sq_h_count = mysqli_num_rows(mysqlQuery("select * from group_cruise_entries where tour_id = '$tour_id'"));

                            if($sq_h_count > 0){

                                ?>

                                <legend>Cruise Information</legend>

                                <div class="table-responsive">

                                    <table class="table table_bordered">

                                        <thead>

                                            <th>Route</th>

                                            <th>Cabin</th>

                                        </thead>

                                        <tbody>

                                            <?php

                                                $count = 0;

                                                $sq_hotel = mysqlQuery("select * from group_cruise_entries where tour_id='$tour_id'");

                                                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                                                ?>

                                                <tr>

                                                    <td><?= $row_hotel['route'] ?></td>

                                                    <td><?= $row_hotel['cabin'] ?></td>

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

                                <p><?= $sq_tour['inclusions'] ?></p>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-exclusion" role="tabpanel" aria-labelledby="pills-exclusion-tab">

                        <div class="ts-tab-content__inner">

                            <div class="custom_texteditor">

                                <p><?= $sq_tour['exclusions'] ?></p>

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

                        <input type="hidden" id="package_name" value="<?=$sq_tour['tour_name']?>"/>

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
                        $sq_dest = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_tour[dest_id]'"));
                        ?>
                        <iframe width="100%" src="<?=$sq_dest['link']?>" title="Destination video guide" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>

                </div>

                </div>

            </div>

        </div>

        

        <div class="row">

            <div class="col col-12 col-md-12 col-lg-4 col-xl-8">

                <?php

                // Tour Dates

                $sq_h_count = mysqli_num_rows(mysqlQuery("Select * from tour_groups where tour_id = '$tour_id'"));

                if($sq_h_count > 0){

                    ?>

                    <legend>Tour Dates</legend>

                    <div class="table-responsive">

                        <table class="table table_bordered">

                            <thead>

                                <th>S_No.</th>

                                <th>From Date</th>

                                <th>To Date</th>

                                <th>Select</th>

                            </thead>

                            <tbody>

                                <?php

                                $count = 1;

                                $today_date = strtotime(date('Y-m-d'));

                                $sq_hotel = mysqlQuery("Select * from tour_groups where tour_id = '$tour_id'");

                                while($sq_tourgrp = mysqli_fetch_assoc($sq_hotel)){

                                    $date1_ts = strtotime($sq_tourgrp['from_date']);

                                    if($today_date < $date1_ts){

                                        

                                        if($count == 1){

                                            $travel_date = date('d-m-Y',strtotime($sq_tourgrp['from_date'])).' to '.date('d-m-Y',strtotime($sq_tourgrp['to_date']));

                                            $group_id = $sq_tourgrp['group_id'];

                                        }

                                    ?>

                                    <tr>

                                        <td><?= $count++ ?></td>

                                        <td><?= date('d-m-Y', strtotime($sq_tourgrp['from_date'])) ?></td>

                                        <td><?= date('d-m-Y', strtotime($sq_tourgrp['to_date'])) ?></td>

                                        <td><input type="radio" id="chk_tour-<?= $sq_tourgrp['group_id'] ?>" name="chk_date" value="<?= date('d-m-Y',strtotime($sq_tourgrp['from_date'])).' to '.date('d-m-Y',strtotime($sq_tourgrp['to_date'])) ?>"></td>

                                    </tr>

                                    <?php

                                    }

                                }

                                ?>

                            </tbody>

                        </table>

                    </div>

                <?php } ?>

            </div>

        </div>

        <div class="row text-center">

            <div class="col col-12 col-md-12 col-lg-4 col-xl-8">

                <div class="clearfix">



                    <button class="c-button md" id='<?=$tours_result_array[$i]['tour_id']?>' onclick="redirect_to_action_page('<?= $tour_id ?>','2','','1','','','','','','0');"><i class="fa fa-phone-square" aria-hidden="true"></i>  Enquiry</button>

                    <button class="c-button g-button md" id='<?=$tours_result_array[$i]['tour_id']?>' onclick="redirect_to_action_page('<?= $tour_id ?>','2','','1','','','','','','0');"><i class="fa fa-address-book" aria-hidden="true"></i>  Book</button>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Reason Section End -->



<?php

$sq_count = mysqli_num_rows(mysqlQuery("select * from tour_master where dest_id = '$sq_tour[dest_id]' and tour_id!='$sq_tour[tour_id]'"));

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

                    $sq_dest = mysqlQuery("select * from tour_master where dest_id = '$sq_tour[dest_id]' and tour_id!='$sq_tour[tour_id]'");

                    while($row_tour = mysqli_fetch_assoc($sq_dest)){

                        if ($i>5) {

                            break;

                        }

                        $tour_id = $row_tour['tour_id'];

                        // Package file name

                        $package_fname = str_replace(' ', '_', $row_tour['tour_name']);

                        $file_name = BASE_URL_B2C.'group_tours/'.$package_fname.'-'.$tour_id.'.php';

                        // Package Image

                        $sq_image = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id='$row_tour[dest_image]'"));

                        $url = $sq_image['image_url'];

                        $pos = strstr($url,'uploads');

                        if ($pos != false)   {

                            $newUrl = preg_replace('/(\/+)/','/',$url); 

                            $newUrl1 = BASE_URL.str_replace('../', '', $newUrl);

                        }

                        else{

                            $newUrl1 =  $url; 

                        }

                        $package_name1 = substr($row_tour['tour_name'], 0, 22).'..';

                        

                        $today_date = strtotime(date('Y-m-d'));

                        $valid_dates_array = array();

                        $valid_count = 0;

                        $sq_hotel = mysqlQuery("Select * from tour_groups where tour_id = '$tour_id'");

                        while($sq_tourgrp = mysqli_fetch_assoc($sq_hotel)){

                            $date1_ts = strtotime($sq_tourgrp['from_date']);

                            if($today_date < $date1_ts){

                                

                                if($valid_count == 0){

                                    $date1_ts = strtotime($sq_tourgrp['from_date']);

                                    $date2_ts = strtotime($sq_tourgrp['to_date']);

                                    $diff = $date2_ts - $date1_ts;

                                    $days = round($diff / 86400);

                                }



                                if($valid_count < 3){

                                    array_push($valid_dates_array,array('from_date'=>date('d-m-Y',strtotime($sq_tourgrp['from_date'])),'to_date'=>date('d-m-Y',strtotime($sq_tourgrp['to_date']))));

                                    $valid_count++;

                                }else break;

                            }

                        }



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

                                        <span><?= $days ?> Nights, <?= $days+1 ?> Days</span>

                                        <p class="ts-blog-card-description">

                                        <?php

                                            for($v=0;$v < sizeof($valid_dates_array); $v++){

                                                echo '<i class="fa fa-calendar" aria-hidden="true"></i>  '.$valid_dates_array[$v]['from_date'].' To '.$valid_dates_array[$v]['to_date'].'<br/>';

                                            }

                                        ?>

                                        </p>

                                    </p>

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

            group_tours_page_currencies();

        },500);

        });

</script>