<?php

global $currency, $app_name, $app_contact_no, $app_email_id_send;

include "get_cache_currencies.php";

include "array_column.php";

// LIVE Cache file reading

$cached_array = json_decode(file_get_contents('https://' . $_SERVER['SERVER_NAME'] . '/crm/view/b2c_cache.php'));

// LOCAL Cache file readingc

//$cached_array = json_decode(file_get_contents('http://localhost/demo8/crm/view/b2c_cache.php'));



$array_master = new array_master();

$to_currency_rate = $cached_array[0]->company_profile_data[0]->currency_rate;



$social_media = json_decode($cached_array[0]->cms_data[0]->social_media);

$google_analytics = $cached_array[0]->cms_data[0]->google_analytics;

$tidio_chat = $cached_array[0]->cms_data[0]->tidio_chat;



// ////////// Header Holiday domestic and internal destinations ////////////////////

// Getting domestic and international package dest-id's

$dom_dest_id_arr = array();

$int_dest_id_arr = array();

$package_tour_data = ($cached_array[0]->package_tour_data != '') ? ($cached_array[0]->package_tour_data) : [];

for ($i = 0; $i < sizeof($package_tour_data); $i++) {



  if ($package_tour_data[$i]->tour_type == 'Domestic') {

    array_push($dom_dest_id_arr, intval($package_tour_data[$i]->dest_id));
  } else if ($package_tour_data[$i]->tour_type == 'International') {

    array_push($int_dest_id_arr, intval($package_tour_data[$i]->dest_id));
  }
}

$dom_dest_id_arr = array_unique($dom_dest_id_arr);

$int_dest_id_arr = array_unique($int_dest_id_arr); // Unique dest-id's



//Preparing final destination array with id and name

$destination_array = ($cached_array[0]->destination != '') ? $cached_array[0]->destination : [];

$dom_array = array();

foreach ($dom_dest_id_arr as $dom_id) {

  foreach ($destination_array as $subarray) {

    if (isset($subarray->dest_id) && intval($subarray->dest_id) == intval($dom_id)) {

      array_push($dom_array, $subarray);

      break;
    }
  }
}

$intn_array = array();

foreach ($int_dest_id_arr as $int_id) {

  foreach ($destination_array as $subarray) {

    if (isset($subarray->dest_id) && intval($subarray->dest_id) == intval($int_id)) {

      array_push($intn_array, $subarray);

      break;
    }
  }
}

// ////////// Header Holiday domestic and internal destinations End //////////////////



// ////////// Header Group tour domestic and internal destinations ////////////////////

// Getting domestic and international tour dest-id's

$dom_dest_id_arr = array();

$int_dest_id_arr = array();

$group_tour_data = ($cached_array[0]->group_tour_data != '') ? ($cached_array[0]->group_tour_data) : [];



for ($i = 0; $i < sizeof($group_tour_data); $i++) {



  if ($group_tour_data[$i]->tour_type == 'Domestic') {

    array_push($dom_dest_id_arr, intval($group_tour_data[$i]->dest_id));
  } else if ($group_tour_data[$i]->tour_type == 'International') {

    array_push($int_dest_id_arr, intval($group_tour_data[$i]->dest_id));
  }
}

$dom_dest_id_arr = array_unique($dom_dest_id_arr);

$int_dest_id_arr = array_unique($int_dest_id_arr); // Unique dest-id's

//Preparing final destination array with id and name

$group_dom_array = array();

foreach ($dom_dest_id_arr as $dom_id) {

  foreach ($destination_array as $subarray) {

    if (isset($subarray->dest_id) && intval($subarray->dest_id) == intval($dom_id)) {

      array_push($group_dom_array, $subarray);

      break;
    }
  }
}

$group_intn_array = array();

foreach ($int_dest_id_arr as $int_id) {

  foreach ($destination_array as $subarray) {

    if (isset($subarray->dest_id) && intval($subarray->dest_id) == intval($int_id)) {

      array_push($group_intn_array, $subarray);

      break;
    }
  }
}

// ////////// Header Holiday domestic and internal destinations End //////////////////

?>

<!DOCTYPE html>

<html>

<head>

    <!-- Page Title -->

    <title><?= $app_name ?></title>



    <!-- Meta Tags -->

    <meta charset="utf-8" />

    <meta name="keywords" content="HTML5 Template" />

    <meta name="description" content="iTours - Travel, Tour Booking HTML5 Template" />

    <meta name="author" content="SoapTheme" />



    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" href="<?php echo BASE_URL_B2C; ?>images/favicon.png" type="image/x-icon" />



    <!-- Theme Styles -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/bootstrap-4.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/owl.carousel.min.css" />

    <link id="main-style" rel="stylesheet" href="<?php echo BASE_URL; ?>css/vi.alert.css" />

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/pagination.css" />

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/jquery-confirm.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/jquery.datetimepicker.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/lightgallery.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/lightgallery-bundle.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/all.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/aos.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/select2.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/slick.css">

    <link rel="stylesheet" href="<?php echo BASE_URL_B2C; ?>css/custom-style.css">



    <!-- COMMON CSS -->

    <link id="main-style" rel="stylesheet/less" type="text/css"
        href="<?php echo BASE_URL_B2C; ?>css/LESS/itours-styles.less" />

    <script src="<?php echo BASE_URL_B2C; ?>js/less.js"></script>





    <script>
    <?= $google_analytics ?>
    </script>

    <script src="<?= $tidio_chat ?>" async></script>

    <!-- Javascript Page Loader -->

</head>

<body onload="myLoader()">
    <div id="loading"></div>
    <div class="site-content">
        <div class="site-content__inner">

            <input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL_B2C ?>">

            <input type="hidden" id="crm_base_url" name="crm_base_url" value="<?= BASE_URL ?>">

            <input type="hidden" id="global_currency" value="<?= $currency ?>" />

            <div class="c-pageWrapper">

                <!-- ********** Component :: Header ********** -->

                <div class="clearfix">

                    <!-- **** Top Header ***** -->

                    <div class="c-pageHeaderTop">

                        <div class="pageHeader_top mobileSidebar">



                            <!-- Menubar close btn for Mobile -->

                            <button class="closeSidebar forMobile"></button>

                            <!-- Menubar close btn for Mobile End -->



                            <div class="container">
                                <div class="row">



                                    <div class="col-md-6 col-12 section-1">

                                        <span class="staticText d-inline"><span style="text-transform: lowercase;">
                                                Helpline :</span>
                                            <?= $cached_array[0]->company_profile_data[0]->contact_no ?></span>

                                        <a href="mailto:<?= $cached_array[0]->company_profile_data[0]->email_id ?>"
                                            class="header-mail-link d-inline ml-2"><?= $cached_array[0]->company_profile_data[0]->email_id ?></a>
                                    </div>



                                    <div class="col-md-1 col-12 section-2 text-center">

                                        <!-- <a href="mailto:gauri@goldfinchholidays.com" class="header-mail-link"><?//= $cached_array[0]->company_profile_data[0]->email_id ?></a> -->

                                    </div>



                                    <div class="col-md-5 col-12 section-3">

                                        <div class="topListing">

                                            <ul>

                                                <li>

                                                    <a class="login_button" target="_blank"
                                                        href="<?= BASE_URL . 'view/customer/index.php' ?>">Login</a>

                                                </li>

                                                <li>

                                                    <div class="c-select2DD st-clear">

                                                        <div id='currency_dropdown'></div>

                                                    </div>

                                                </li>

                                                <!--<li>

                      <div class="c-select2DD st-clear">

                        <select name="state">

                          <option value="English">English</option>

                        </select>

                      </div>

                    </li> -->

                                            </ul>

                                        </div>

                                    </div>



                                </div>
                            </div>



                            <!-- Menubar for Mobile -->

                            <!-- <div class="menuBar forMobile">

                <ul>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>">Home</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>">Group Tour</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>?service=ComboTours">Holiday</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>?service=Hotels">Hotels</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>?service=Activities">Activities</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>">Visa</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>?service=Transfer">Transfer</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>">Cruise</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C ?>">Services</a></li>

                    <li><a class="menuLink" href="<?= BASE_URL_B2C . 'contact.php' ?>">Contact Us</a></li>

                </ul>

              </div> -->

                            <!-- Menubar for Mobile End -->



                        </div>

                    </div>

                    <!-- **** Top Header End ***** -->

                    <!-- New Header -->

                    <div class="container">
                        <div class="top-header">
                            <div class="row">

                                <div class="col-sm-3 col-7">

                                    <div id="logo_home" class="header-logo">

                                        <a href="<?= BASE_URL_B2C ?>" title="B2C Home Page">

                                            <img src="<?php echo $admin_logo_url; ?>" alt="<?php echo $app_name; ?>" />

                                        </a>

                                    </div>

                                </div>

                                <nav class="col-sm-9 col-5 text-right pad-top">

                                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close"
                                        href="javascript:void(0);"><span>Menu mobile</span></a>

                                    <div class="main-menu">

                                        <div id="header_menu">

                                            <img src="<?php echo $admin_logo_url; ?>" width="160" height="34"
                                                alt="<?php echo $app_name; ?>" />

                                        </div>

                                        <a href="#" class="open_close close_in" id="close_in">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>

                                        <ul>

                                            <li>

                                                <a href="<?= BASE_URL_B2C ?>">Home</a>

                                            </li>

                                            <li class="submenu">

                                                <a class="show-submenu">Group Tour<i
                                                        class="icon itours-b2b-angle-down"></i></a>

                                                <ul>

                                                    <li class="third-level">

                                                        <a>Domestic</a>

                                                        <ul>

                                                            <?php

                          for ($i = 0; $i < sizeof($group_dom_array); $i++) { ?>

                                                            <li><a
                                                                    onclick="get_tours_data('<?= $group_dom_array[$i]->dest_id ?>','2')"><?= $group_dom_array[$i]->dest_name ?></a>
                                                            </li>

                                                            <?php } ?>

                                                        </ul>

                                                    <li class="third-level">

                                                        <a>International</a>

                                                        <ul>

                                                            <?php

                          for ($i = 0; $i < sizeof($group_intn_array); $i++) { ?>

                                                            <li><a
                                                                    onclick="get_tours_data('<?= $group_intn_array[$i]->dest_id ?>','2')"><?= $group_intn_array[$i]->dest_name ?></a>
                                                            </li>

                                                            <?php } ?>

                                                        </ul>

                                                    </li>

                                                </ul>

                                            </li>

                                            <li class="submenu">

                                                <a class="show-submenu">Holiday <i
                                                        class="icon itours-b2b-angle-down"></i></a>

                                                <ul>

                                                    <li class="third-level">

                                                        <a>Domestic</a>

                                                        <ul>

                                                            <?php

                          for ($i = 0; $i < sizeof($dom_array); $i++) { ?>

                                                            <li><a
                                                                    onclick="get_tours_data('<?= $dom_array[$i]->dest_id ?>','1')"><?= $dom_array[$i]->dest_name ?></a>
                                                            </li>

                                                            <?php } ?>

                                                        </ul>

                                                    <li class="third-level">

                                                        <a>International</a>

                                                        <ul>

                                                            <?php

                          for ($i = 0; $i < sizeof($intn_array); $i++) { ?>

                                                            <li><a
                                                                    onclick="get_tours_data('<?= $intn_array[$i]->dest_id ?>','1')"><?= $intn_array[$i]->dest_name ?></a>
                                                            </li>

                                                            <?php } ?>

                                                        </ul>

                                                    </li>

                                                </ul>

                                            </li>

                                            <li>

                                                <a onclick="get_tours_data('','3')">Hotels</a>

                                            </li>

                                            <li>

                                                <a onclick="get_tours_data('','4')">Activities</a>

                                            </li>

                                            <li>

                                                <a onclick="get_tours_data('','6')">Visa</a>

                                            </li>

                                            <li>

                                                <a onclick="get_tours_data('','5')">Transfer</a>

                                            </li>

                                            <li>

                                                <a onclick="get_tours_data('','7')">Cruise</a>

                                            </li>

                                            <li>

                                                <a href="<?= BASE_URL_B2C . 'services.php' ?>">Services</a>

                                            </li>

                                            <li>

                                                <a href="<?= BASE_URL_B2C . 'contact.php' ?>">Contact Us</a>

                                            </li>
                                            <li class="header-btn">
                                                <a class="btn header-offer-btn"
                                                    href="<?= BASE_URL_B2C . 'offers.php' ?>">Offers</a>
                                            </li>
                                        </ul>

                                    </div>

                                    <!-- End main-menu -->



                            </div>
                        </div>
                        <!-- End dropdown-cart-->

                        </li>

                        </ul>

                        </nav>

                    </div>

                </div>

                <!-- container -->

                <!-- New Header End -->

            </div>

            <!-- ********** Component :: Header End ********** -->

            <!--preloader script-->
            <script>
            var preloader = document.getElementById('loading');

            function myLoader() {
                preloader.style.display = 'none';
            }
            </script>

            <?php

  // include "get_cache_tax_rules.php";

  ?>

            <input type="hidden" id='cache_currencies' value='<?= $data ?>' />