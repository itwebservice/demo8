<?php
global $app_name;
$register_id = $_SESSION['register_id'];
$customer_id = $_SESSION['customer_id'];
$credit_amount = $_SESSION['credit_amount'];
include "get_cache_currencies.php";
?>
<!DOCTYPE html>
<html>
    <head>
      <!-- Page Title -->
      <title><?= $app_name ?></title>

      <!-- Meta Tags -->
      <meta charset="utf-8" />
      <meta name="keywords" content="HTML5 Template" />
      <meta
        name="description"
        content="iTours - Travel, Tour Booking HTML5 Template"
      />
      <meta name="author" content="SoapTheme" />

      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="shortcut icon" href="<?php echo BASE_URL ?>Tours_B2B/images/favicon.png" type="image/x-icon" />

      <!-- Theme Styles -->
      <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
      <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/bootstrap-4.min.css" />
      <link rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/owl.carousel.min.css" />
      <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
      <link id="main-style" rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/itours-styles.css" />
      <link id="main-style" rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/itours-components.css" />
      <!-- Javascript Page Loader -->
    </head>
    <body>
        <input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">
        <input type="hidden" id="register_id" value="<?= $register_id ?>"/>
        <input type="hidden" id="customer_id" value="<?= $customer_id ?>"/>
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

                  <div class="col-sm-4 col-12">
                    <span class="staticText">Helpline : <?= $app_contact_no ?></span>
                  </div>

                  <div class="col-sm-4 col-12">
                    
                  </div>

                  <div class="col-sm-4 col-12">
                    <div class="topListing">
                      <ul>
                        <li>
                          <div class="c-select2DD st-clear">
                          <div id='currency_dropdown'></div>
                          </div>
                        </li>
                        <li>
                          <div class="c-select2DD st-clear">
                            <select name="state">
                              <option value="English">English</option>
                            </select>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Menubar for Mobile -->
              <div class="menuBar forMobile">
                <ul>
                  <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Hotels">Hotels</a></li>
                  <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Activities">Activities</a></li>
                  <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Transfer">Transfer</a></li>
                  <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=ComboTours">Combo Tours</a></li>
                  <li><a class="menuLink" href="<?php echo BASE_URL ?>Tours_B2B/login.php">Logout</a></li>
                </ul>
              </div>
              <!-- Menubar for Mobile End -->

            </div>
          </div>
          <!-- **** Top Header End ***** -->

          <!-- **** Bottom Header ***** -->
          <div class="c-pageHeader">
            <div class="pageHeader_btm">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-sm-4 col-7 p0-right">

                    <!-- Menubar Hamb btn for Mobile -->
                    <button class="mobile_hamb"></button>
                    <!-- Menubar Hamb btn for Mobile End -->

                    <a href="<?= $b2b_index_url ?>" class="btm_logo">
                      <img src='<?php echo BASE_URL ?>images/Admin-Area-Logo.png' alt="iTours" />
                    </a>
                  </div>
                  <div class="col-sm-8 col-5 text-right p0-left">
                    <div class="menuBar">
                      <ul>
                        <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Hotels">Hotels</a></li>
                        <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Activities">Activities</a></li>
                        <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Transfer">Transfer</a></li>
                        <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=ComboTours">Holiday</a></li>
                        <li><a class="menuLink" href="<?= $b2b_index_url ?>?service=Ferry">Ferry</a></li>
                      </ul>
                    </div>

                    <button class="btnUtil" type="button" data-toggle="modal" data-target="#shopping_list_modal" aria-haspopup="true" aria-expanded="false" onclick='display_cart("cart_item_count");'>
                      <img src="<?php echo BASE_URL ?>Tours_B2B/images/svg/supermarket.svg" alt="iTours" />
                      <span class="notify" id='cart_item_count'></span>
                    </button>


                    <!-- ***** User Profile DD ***** -->
                    <div class="c-userProf dropdown">
                      <button class="btnUtil" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo BASE_URL ?>Tours_B2B/images/svg/user.svg" alt="iTours" />
                      </button>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class="userHeading">
                          <div class="profIcon">
                            <img src="<?php echo BASE_URL ?>Tours_B2B/images/svg/user.svg" alt="iTours" />
                          </div>
                          <h4 class="userName"><?=$sq_query['company_name'] ?></h4>
                          <span class="userCode"><?= $sq_query['mobile_no'] ?></span>
                        </div>
                        <div class="userNav">
                          <a href="<?php echo BASE_URL ?>Tours_B2B/view/user-profile/profile.php" class="userNavLink">
                            <i class="icon user itours-user"></i>
                            <span>Profile</span>
                          </a>
                          <a href="<?php echo BASE_URL ?>Tours_B2B/view/user-profile/profile.php" class="userNavLink">
                            <i class="icon user itours-shopping-cart"></i>
                            <span>Quotation Summary</span>
                          </a>
                          <a href="<?php echo BASE_URL ?>Tours_B2B/view/user-profile/profile.php" class="userNavLink">
                            <i class="icon user itours-shopping-cart"></i>
                            <span>Booking Summary</span>
                          </a>
                          <a href="<?php echo BASE_URL ?>Tours_B2B/view/user-profile/profile.php" class="userNavLink">
                            <i class="icon user itours-ledger"></i>
                            <span>Account Ledger</span>
                          </a>
                          <a href="<?php echo BASE_URL ?>Tours_B2B/login.php" class="userNavLink">
                            <i class="icon user itours-logout"></i>
                            <span>Logout</span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <!-- ***** User Profile DD End ***** -->

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- **** Bottom Header End ***** -->
      </div>
      <!-- ********** Component :: Header End ********** -->
      <input type="hidden" id='cache_currencies' value='<?= $data ?>'/>