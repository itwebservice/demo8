  <!-- ********** Component :: Footer ********** -->

  <footer class="it-footer">
   
    <div class="it-footer-top" style="display: none;">
        <div class="container">
            <div class="it-footer-top-content">
                <ul class="it-payment-list">
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-brands fa-cc-amex"></i>
                        </a>
                    </li>
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-brands fa-cc-visa"></i>
                        </a>
                    </li>
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-solid fa-credit-card"></i>
                        </a>
                    </li>
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-brands fa-cc-mastercard"></i>
                        </a>
                    </li>
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-brands fa-cc-paypal"></i>
                        </a>
                    </li>
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-brands fa-cc-discover"></i>
                        </a>
                    </li>
                    <li class="it-payment-item">
                        <a href="#" class="it-payment-link">
                            <i class="fa-brands fa-google-wallet"></i>
                        </a>
                    </li>
                </ul>
                <div class="it-select-content">
                    <div class="it-select-item">
                        <select class="form-control it-footer-lang form-select">
                            
                            <option value="">English</option>
                            <option value="">Arabic</option>
                            <option value="">German</option>
                            <option value="">Greek</option>
                            
                        </select>

                    </div>
                    <div class="it-select-item">
                        <select class="form-control it-footer-cur form-select">
                            <option value="">USD</option>
                            <option value="">EUR</option>
                            <option value="">INR</option>
                            <option value="">GBP</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="it-footer-main">
        <div class="container">
            <div class="row">
               <!-- <div class="col col-12 col-md-12 col-lg-6 col-xl-3">
                    <div class="it-footer-logo">
                        <img src="images/logo.png" alt="logo" class="imng-fluid">
                    </div>
                    <p class="it-footer-description">At vero eos et accusamus et iusto odio dignissimos ducimus voluptatum
                    </p>
                    <h6 class="it-footer-title">Social Icons</h6> 
                </div> -->
                <div class="col col-12 col-md-12 col-lg-6 col-xl-3">
                    <h6 class="it-footer-title">Popular Tour Places</h6>
                    <ul class="it-footer-menu-list">
                    <?php foreach($Apifooter as $footer){  ?>   
                    <li class="it-footer-menu-item">
                            <a href="#" onclick="get_tours_data('<?= $footer->destination->dest_id ?>','1')"  class="it-footer-menu-link"><i class="fa fa-angle-double-right"></i>
                                <?= $footer->package_name  ?></a>
                        </li>
                        <?php } ?>
                        
                    </ul>
                </div>
                <div class="col col-12 col-md-12 col-lg-6 col-xl-2">
                    <h6 class="it-footer-title">Important Links</h6>
                    <ul class="it-footer-menu-list">
                        <li class="it-footer-menu-item">
                            <a target="_blank" href="<?=BASE_URL_B2C?>about.php" class="it-footer-menu-link"><i class="fa fa-angle-double-right"></i>
                                About
                                Us</a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a target="_blank" href="<?=BASE_URL_B2C?>award.php" class="it-footer-menu-link"><i class="fa fa-angle-double-right"></i>
                                Awards</a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a target="_blank" href="<?=BASE_URL_B2C?>blog.php" class="it-footer-menu-link"><i class="fa fa-angle-double-right"></i>
                                Travel
                                Blog</a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a target="_blank" href="<?=BASE_URL_B2C?>refund-policy.php" class="it-footer-menu-link"><i class="fa fa-angle-double-right"></i>
                                Refund
                                Policy</a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a target="_blank" href="<?=BASE_URL_B2C?>terms-conditions.php" class="it-footer-menu-link"><i class="fa fa-angle-double-right"></i>
                                Terms
                                of Use</a>
                        </li>
                    </ul>
                </div>
                <div class="col col-12 col-md-12 col-lg-6 col-xl-4">
                    <h6 class="it-footer-title">Get In Touch</h6>
                    <ul class="it-footer-menu-list">
                        <li class="it-footer-menu-item" style="color: rgba(255, 255, 255, 0.6);">
                            <a class="it-footer-menu-link"><i class="fa fa-home"></i> 
                            <?= $Apigeneral->app_address ?>
                        </a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a href="mailto:<?= $cached_array[0]->company_profile_data[0]->app_email_id ?>" class="it-footer-menu-link"><i class="fa fa-envelope"></i>
                            <?= $Apigeneral->app_email_id ?>
                        </a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a class="it-footer-menu-link" style="color: rgba(255, 255, 255, 0.6);"><i class="fa fa-phone"></i>
                            <?= $Apigeneral->app_contact_no ?></a>
                        </li>
                        <li class="it-footer-menu-item">
                            <a href="#" class="it-footer-menu-link"><i class="fa fa-print"></i> 
                            <?= $Apigeneral->app_website ?>
                        </a>
                        </li>
                    </ul>
                    <!--social media plaform-->
                    <ul class="it-social-list">
                        <li class="it-social-item">
                            <a class="it-social-link" href="<?= $Apisocial->fb ?>">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="it-social-item">
                            <a class="it-social-link" href="<?= $Apisocial->tw ?>">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <!-- <li class="it-social-item">
                            <a class="it-social-link" href="#">
                                <i class="fa-solid fa-rss"></i>
                            </a>
                        </li> -->
                        <li class="it-social-item">
                            <a class="it-social-link" href="<?= $Apisocial->yu ?>">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                        <li class="it-social-item">
                            <a class="it-social-link" href="<?= $Apisocial->li ?>">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </li>
                             <li class="it-social-item">
                            <a class="it-social-link" href="<?= $Apisocial->inst ?>">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li> 
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="it-footer-bottom">
        <div class="container">
            <div class="it-footer-bottom-content">
                <p class="it-site-copyright"> Copyright © 2022 <?= $app_name ?> All rights reserved. </p>
            </div>
        </div>
    </div>
</footer>

  <!-- ********** Component :: Footer End ********** -->

        
</div>

<div id="site_alert"></div>

<div id='hotel-result'></div>

<!-- <div id='WhatsAppPanel'></div> -->



<!-- <div class="modal fade shoppingCartModal" id="shopping_list_modal" role="dialog" aria-labelledby="myModalLabel">

<div class="modal-dialog modal-sm" role="document">

  <div class="modal-content">

    <div class="modal-header">

      <h4 class="modal-title" id="myModalLabel">Shopping Cart</h4>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    </div>

    <div class="modal-body">

      <div id='cart_div'></div>

    </div>

  </div>

</div>

</div> -->

<!-- Javascript -->

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/jquery-3.4.1.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/jquery-ui.1.10.4.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/popper.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/bootstrap-4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/owl.carousel.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/select2.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/theme-scripts.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL ?>js/vi.alert.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/jquery-confirm.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/pagination.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/lightgallery.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/lg-thumbnail.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/lg-zoom.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/scripts.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/aos.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/slick.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/smooth-scrollbar.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/custom.js"></script>

        </div>
    </div>
</body>

</html>

<script>

$(document).ready(function () {

    

    var base_url = $('#base_url').val();

    if (typeof Storage !== 'undefined') {

        

        var currency_id = $('#global_currency').val();

        if (localStorage) {

          var global_currency = localStorage.getItem('global_currency');

          

        } else {

          var global_currency = window.sessionStorage.getItem('global_currency');

        }

    }

    //Get selected Currency Dropdown

    $.post(base_url+'view/get_currency_dropdown.php', { currency_id : global_currency }, function (data){

          $('#currency_dropdown').html(data);

          $('#currency').select2();

          

          var currency_id1 = $('#currency').val();

          //Set selected currency in php session also

          $.post(base_url + 'view/set_currency_session.php', { currency_id: currency_id1}, function (data) {

          });

          if (typeof Storage !== 'undefined') {

              if (localStorage) {

                  localStorage.setItem(

                  'global_currency', currency_id1

                  );

              } else {

                  window.sessionStorage.setItem(

                  'global_currency', currency_id1

                  );

              }

          }

          // get_selected_currency();

    });

});



// $('#WhatsAppPanel').load('../whatsContent.html');



function tours_page_currencies(current_page_url){

    

    var base_url = $('#base_url').val();

    var default_currency = $('#global_currency').val();    

    if (typeof Storage !== 'undefined') {

        if (localStorage) {

            var currency_id = localStorage.getItem('global_currency');

        } else {

            var currency_id = window.sessionStorage.getItem('global_currency');

        }

    }

    // Listing page //Load Currency Icon

    var currency_icon_lisr = document.querySelectorAll(".currency-icon");

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )? cache_currencies.find(el => el.id === currency_id) : '0';

    currency_icon_lisr.forEach(function(item){

        item.innerHTML = to_currency_rate.icon;

    });

    if(current_page_url != base_url + 'view/tours/tours-listing.php'){

        

        // Indivisual Package Php page

        var price_list = JSON.parse(sessionStorage.getItem('tours_best_amount_list'));

        var amount_Classlist = document.querySelectorAll(".best-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

                

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

                var cost = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

                if(parseFloat(cost) != '0.00'){

                    amount_Classlist[i].innerHTML = cost;

                }else{

                    amount_Classlist[i].innerHTML = 'On Request';

                }

            });

        }

    }

    else{

    

        //Tour Prices

        var price_list = JSON.parse(sessionStorage.getItem('tours_amount_list'));

        var amount_Classlist = document.querySelectorAll(".tours-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //Tour Org Prices

        var price_list = JSON.parse(sessionStorage.getItem('tours_orgamount_list'));

        var amount_Classlist = document.querySelectorAll(".tours-orgcurrency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //Tour best Prices

        var price_list = JSON.parse(sessionStorage.getItem('tours_best_amount_list'));

        var amount_Classlist = document.querySelectorAll(".best-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //Tour best Org Prices

        var price_list = JSON.parse(sessionStorage.getItem('tours_best_orgamount_list'));

        var amount_Classlist = document.querySelectorAll(".best-tours-orgamount");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //Best High-Low cost array(Price Range filter)

        var best_price_list = JSON.parse(sessionStorage.getItem('tours_best_price'));

        if(best_price_list !== null){

            var ans_arr3 = [];

            best_price_list.map((tour,i)=>{

            if(i===0)

                tour.amount = Math.floor(tour.amount);

            else

                tour.amount = Math.ceil(tour.amount);

                if(tour.id!=currency_id){

                    var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                    var to_currency_rate =  currency_rates[0];

                    var from_currency_rate = currency_rates[1];

                    var final_amount = (parseFloat(to_currency_rate / from_currency_rate * tour.amount));

                    

                    ans_arr3.push(final_amount);

                }

                else{

                    ans_arr3.push(parseFloat(tour.amount).toFixed(2));

                }

                $('#price_rangevalues').val((ans_arr3));

            });

            const element = document.querySelector(".c-priceRange");

            if(element!==null){

                clearRange();

            }

        }

        

    }

}

function group_tours_page_currencies(current_page_url){

    

    var base_url = $('#base_url').val();

    var default_currency = $('#global_currency').val();    

    if (typeof Storage !== 'undefined') {

        if (localStorage) {

            var currency_id = localStorage.getItem('global_currency');

        } else {

            var currency_id = window.sessionStorage.getItem('global_currency');

        }

    }

    // Listing page //Load Currency Icon

    var currency_icon_lisr = document.querySelectorAll(".currency-icon");

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )? cache_currencies.find(el => el.id === currency_id) : '0';

    currency_icon_lisr.forEach(function(item){

        item.innerHTML = to_currency_rate.icon;

    });

    if(current_page_url != base_url + 'view/group_tours/tours-listing.php'){

        

        // Indivisual Package Php page

        var price_list = JSON.parse(sessionStorage.getItem('tours_best_amount_list'));

        var amount_Classlist = document.querySelectorAll(".best-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

                

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

                var cost = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

                if(parseFloat(cost) != '0.00'){

                    amount_Classlist[i].innerHTML = cost;

                }else{

                    amount_Classlist[i].innerHTML = 'On Request';

                }

            });

        }

    }

    else{

    

        //Tour Prices

        var price_list = JSON.parse(sessionStorage.getItem('tours_amount_list'));

        var amount_Classlist = document.querySelectorAll(".tours-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //adult Prices

        var price_list = JSON.parse(sessionStorage.getItem('adult_price_list'));

        var amount_Classlist = document.querySelectorAll(".adult_cost-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //child without best Prices

        var price_list = JSON.parse(sessionStorage.getItem('childwo_price_list'));

        var amount_Classlist = document.querySelectorAll(".childwio_cost-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //child with Prices

        var price_list = JSON.parse(sessionStorage.getItem('childwi_price_list'));

        var amount_Classlist = document.querySelectorAll(".childwi_cost-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //extra bed Org Prices

        var price_list = JSON.parse(sessionStorage.getItem('extrabed_price_list'));

        var amount_Classlist = document.querySelectorAll(".extrabed-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //infant Org Prices

        var price_list = JSON.parse(sessionStorage.getItem('infant_price_list'));

        var amount_Classlist = document.querySelectorAll(".infant_cost-currency-price");

        if(price_list !== null && amount_Classlist[0] !== undefined){

            price_list.map((tour,i)=>{

            var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

            var to_currency_rate =  currency_rates[0];

            var from_currency_rate = currency_rates[1];

            amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

            });

        }

        //Best High-Low cost array(Price Range filter)

        var best_price_list = JSON.parse(sessionStorage.getItem('tours_best_price'));

        if(best_price_list !== null){

            var ans_arr3 = [];

            best_price_list.map((tour,i)=>{

            if(i===0)

                tour.amount = Math.floor(tour.amount);

            else

                tour.amount = Math.ceil(tour.amount);

                if(tour.id!=currency_id){

                    var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                    var to_currency_rate =  currency_rates[0];

                    var from_currency_rate = currency_rates[1];

                    var final_amount = (parseFloat(to_currency_rate / from_currency_rate * tour.amount));

                    

                    ans_arr3.push(final_amount);

                }

                else{

                    ans_arr3.push(parseFloat(tour.amount).toFixed(2));

                }

                $('#price_rangevalues').val((ans_arr3));

            });

            const element = document.querySelector(".c-priceRange");

            if(element!==null){

                clearRange();

            }

        }

        

    }

}

function index_page_currencies(){

    var base_url = $('#base_url').val();

    var credit_amount = $("#credit_amount_temp").val();

    var default_currency = $('#global_currency').val();

    if (typeof Storage !== 'undefined') {

      if (localStorage) {

        var currency_id = localStorage.getItem('global_currency');

      } else {

        var currency_id = window.sessionStorage.getItem('global_currency');

      }

    }

      

    final_arr = JSON.parse(sessionStorage.getItem('final_arr'));

    var adult_count = 0;

    var child_count = 0;

    if(final_arr === null){

      $('#total_pax').html(2);

      $('#room_count').html(1+' Room');

      $('#adult_count').val(2);

      $('#child_count').val(0);

      $('#dynamic_room_count').val(1);

    }else{

      for (var n = 0; n < final_arr.length; n++) {

        adult_count = parseFloat(adult_count) + parseFloat(final_arr[n]['rooms']['adults']);

        child_count = parseFloat(child_count) + parseFloat(final_arr[n]['rooms']['child']);

      }

      $('#total_pax').html(adult_count+child_count);

      $('#room_count').html(final_arr.length+ ' Rooms');

      $('#adult_count').val(adult_count);

      $('#child_count').val(child_count);

      $('#dynamic_room_count').val(final_arr.length);

    }



    setTimeout(() => {

      //Hotels for honeymoon costing

      var amountClasslist = document.querySelectorAll(".currency-hotel-price");

      var amount_list = JSON.parse(sessionStorage.getItem('hotel_price'));

      if(amount_list !== null && amountClasslist[0] !== undefined){

        amount_list.map((tour,i)=>{

          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

          var to_currency_rate =  currency_rates[0];

          var from_currency_rate = currency_rates[1];

          amountClasslist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

        });

      }

      //Credit amount conversion

      var currency_rates = get_currency_rates(default_currency,currency_id).split('-');

      var to_currency_rate =  currency_rates[0];

      var from_currency_rate = currency_rates[1];

      var result = parseFloat(to_currency_rate / from_currency_rate * credit_amount).toFixed(2);

      if(!isNaN(result))

      $('#credit_amount').html(result);

      else

      $('#credit_amount').html((0).toFixed(2));



      //Load Currency Icon

      var currency_icon_lisr = document.querySelectorAll(".currency-icon");

      var cache_currencies = $('#cache_currencies').val();

      cache_currencies = JSON.parse(cache_currencies);

      var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';

      currency_icon_lisr.forEach(function(item){

          item.innerHTML = to_currency_rate.icon;

      });

    },1200);

}

function transfer_page_currencies(){

    var base_url = $('#base_url').val();

    var credit_amount = $("#credit_amount_temp").val();

    var default_currency = $('#global_currency').val();    

    if (typeof Storage !== 'undefined') {

      if (localStorage) {

        var currency_id = localStorage.getItem('global_currency');

      } else {

        var currency_id = window.sessionStorage.getItem('global_currency');

      }

    }

    //Load Currency Icon

    var currency_icon_lisr = document.querySelectorAll(".currency-icon");

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';

    currency_icon_lisr.forEach(function(item){

        item.innerHTML = to_currency_rate.icon;

    });

}

function activties_page_currencies(){

    var base_url = $('#base_url').val();

    var credit_amount = $("#credit_amount_temp").val();

    var default_currency = $('#global_currency').val();    

    if (typeof Storage !== 'undefined') {

      if (localStorage) {

        var currency_id = localStorage.getItem('global_currency');

      } else {

        var currency_id = window.sessionStorage.getItem('global_currency');

      }

    }

    //Load Currency Icon

    var currency_icon_lisr = document.querySelectorAll(".currency-icon");

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';

    currency_icon_lisr.forEach(function(item){

        item.innerHTML = to_currency_rate.icon;

    });

}

function hotel_page_currencies(){

    var base_url = $('#base_url').val();

    var credit_amount = $("#credit_amount_temp").val();

    var default_currency = $('#global_currency').val();    

    if (typeof Storage !== 'undefined') {

      if (localStorage) {

        var currency_id = localStorage.getItem('global_currency');

      } else {

        var currency_id = window.sessionStorage.getItem('global_currency');

      }

    }

    //Load Currency Icon

    var currency_icon_lisr = document.querySelectorAll(".currency-icon");

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';

    currency_icon_lisr.forEach(function(item){

        item.innerHTML = to_currency_rate.icon;

    });

}

function currency_converter(){

            var base_url = $('#base_url').val();

            var default_currency = $('#global_currency').val();

        

            if (typeof Storage !== 'undefined') {

              if (localStorage) {

                var currency_id = localStorage.getItem('global_currency', credit_amount);

              } else {

                var currency_id = window.sessionStorage.getItem('global_currency', credit_amount);

              }

            }

            //Load Currency Icon

            var currency_icon_lisr = document.querySelectorAll(".currency-icon");

            var cache_currencies = JSON.parse($('#cache_currencies').val());

            var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';

            currency_icon_lisr.forEach(function(item){

                item.innerHTML = to_currency_rate.icon;

            });

            //Get all amounts

            var amount_Classlist = document.querySelectorAll(".currency-price");

            var amount_list = JSON.parse(sessionStorage.getItem('amount_list'));

        

            var pamount_Classlist = document.querySelectorAll(".room-currency-price");

            var room_price_list = JSON.parse(sessionStorage.getItem('room_price_list'));

            

            var orgamt_Classlist = document.querySelectorAll(".original-currency-price");

            var original_amt_list = JSON.parse(sessionStorage.getItem('original_amt_list'));

        

            var offeramt_Classlist = document.querySelectorAll(".offer-currency-price");

            var offer_price_list = JSON.parse(sessionStorage.getItem('offer_price_list'));

        

            var cartamt_Classlist = document.querySelectorAll(".cart-currency-price");

            var cart_item_list = JSON.parse(localStorage.getItem('cart_item_list'));

        

            var bestamt_Classlist = document.querySelectorAll(".best-cost-currency");

            var best_price_list = JSON.parse(sessionStorage.getItem('best_price_list'));

            

            //Cart Items cost array

            if(cart_item_list !== null && cartamt_Classlist[0] !== undefined){

              cart_item_list.map((tour,i)=>{

               

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

        

                cartamt_Classlist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

              });

            }

            //Hotel Best lowest cost array

            if(amount_list !== null && amount_Classlist[0] !== undefined){

              amount_list.map((tour,i)=>{

        

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

                amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

              });

            }

            //Hotel Original Cost

            if(original_amt_list !== null && orgamt_Classlist[0] !== undefined){

              original_amt_list.map((tour,i)=>{

        

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

        

                orgamt_Classlist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

              });

            }

            //Hotel Offer Cost

            if(offer_price_list !== null && offeramt_Classlist[0] !== undefined){

              offer_price_list.map((tour,i)=>{

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

        

                offeramt_Classlist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

              });

            }

            //Best High-Low cost array(Price Range filter) 

            if(best_price_list !== null){

              var ans_arr3 = [];

              best_price_list.map((tour,i)=>{

                if(i===0)

                  tour.amount = Math.floor(tour.amount);

                else

                  tour.amount = Math.ceil(tour.amount);

                if(tour.id==currency_id){

                  var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                  var to_currency_rate =  currency_rates[0];

                  var from_currency_rate = currency_rates[1];

                  ans_arr3.push(parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2));

                }

                else{

                  ans_arr3.push(parseFloat(tour.amount).toFixed(2));

                }

                  

                $('#price_rangevalues').val((ans_arr3));

              });

              const element = document.querySelector(".c-priceRange");

              if(element!==null){

                clearRange();

              }

            }

        

            //Room Category prices

            if(room_price_list !== null && pamount_Classlist[0] !== undefined){

              room_price_list.map((tour,i)=>{

        

                var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

                var to_currency_rate =  currency_rates[0];

                var from_currency_rate = currency_rates[1];

                pamount_Classlist[i].innerHTML =   parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

              });

        }

    

}



function checkout_currency_converter(){

	var base_url = $('#base_url').val();

  var default_currency = $('#global_currency').val();

  if (typeof Storage !== 'undefined') {

    if (localStorage) {

      var currency_id = localStorage.getItem('global_currency');

    } else {

      var currency_id = window.sessionStorage.getItem('global_currency');

    }

  }

  setTimeout(() => {

    //Load Currency Icon

    var currency_icon_lisr = document.querySelectorAll(".currency-icon");

    var cache_currencies = JSON.parse($('#cache_currencies').val());

    var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';

    currency_icon_lisr.forEach(function(item){

        item.innerHTML = to_currency_rate.icon;

    });

    //Checkout Page amounts

    var cartp_list = document.querySelectorAll(".checkoutp-currency-price");

    var cart_amount_list = JSON.parse(localStorage.getItem('cart_amount_list'));

    

    var carttax_list = document.querySelectorAll(".checkouttax-currency-price");

    var cart_tax_list = JSON.parse(localStorage.getItem('cart_tax_list'));

    

    var cartt_list = document.querySelectorAll(".checkoutt-currency-price");

    var cart_total_list = JSON.parse(localStorage.getItem('cart_total_list'));

    

    //Checkout Page Final Pricing amounts

    var cartsubtotal_list = document.querySelectorAll(".checkouttsubtotal-currency-price");

    var cart_subtotal_list = JSON.parse(localStorage.getItem('cart_subtotal_list'));

    

    var carttotaltax_list = document.querySelectorAll(".checkoutttaxtotal-currency-price");

    var cart_totaltax_list = JSON.parse(localStorage.getItem('cart_totaltax_list'));

    

    var carttotal_list = document.querySelectorAll(".checkouttotal-currency-price");

    var cart_maintotal_list = JSON.parse(localStorage.getItem('cart_maintotal_list'));

    

    var cartgrandt_list = document.querySelectorAll(".checkoutgrandtotal-currency-price");

    var cart_grandtotal_list = localStorage.getItem('cart_grandtotal_list');

    

    //Checkout Final Pricing Amount cost array

    if(cart_subtotal_list !== null && cartsubtotal_list[0] !== undefined){

      cart_subtotal_list.map((tour,i)=>{

      var currency_rates = get_currency_rates(currency_id,currency_id).split('-');

      var to_currency_rate =  currency_rates[0];

      var from_currency_rate = currency_rates[1];

      cartsubtotal_list[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour).toFixed(2);

      })

    }

    //Checkout Tax cost array

    if(cart_totaltax_list !== null && carttotaltax_list[0] !== undefined){

      cart_totaltax_list.map((tour,i)=>{

      var currency_rates = get_currency_rates(currency_id,currency_id).split('-');

      var to_currency_rate =  currency_rates[0];

      var from_currency_rate = currency_rates[1];

      carttotaltax_list[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour).toFixed(2);

      })

    }

    //Checkout total cost array

    if(cart_maintotal_list !== null && carttotal_list[0] !== undefined){

      cart_maintotal_list.map((tour,i)=>{

      var currency_rates = get_currency_rates(currency_id,currency_id).split('-');

      var to_currency_rate =  currency_rates[0];

      var from_currency_rate = currency_rates[1];

      carttotal_list[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour).toFixed(2);

      })

    }

    //Checkout grand total cost array

    if(cartgrandt_list !== null){

      var currency_rates = get_currency_rates(currency_id,currency_id).split('-');

      var to_currency_rate =  currency_rates[0];

      var from_currency_rate = currency_rates[1];

      cartgrandt_list[0].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * cart_grandtotal_list).toFixed(2);

    }

    //Checkout Amount cost array

    if(cart_amount_list !== null && cartp_list[0] !== undefined){

      cart_amount_list.map((tour,i)=>{

        

        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

        var to_currency_rate =  currency_rates[0];

        var from_currency_rate = currency_rates[1];

        cartp_list[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

      });

    }

    //Checkout Tax cost array

    if(cart_tax_list !== null && carttax_list[0] !== undefined){

      cart_tax_list.map((tour,i)=>{

        

        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

        var to_currency_rate =  currency_rates[0];

        var from_currency_rate = currency_rates[1];

        carttax_list[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

      });

    }

    //Checkout total cost array

    if(cart_total_list !== null && cartt_list[0] !== undefined){

      cart_total_list.map((tour,i)=>{



        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');

        var to_currency_rate =  currency_rates[0];

        var from_currency_rate = currency_rates[1];

        cartt_list[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);

      });

    }

    //Credit amount conversion

    var credit_amount = $("#credit_amount_temp").val();

    var currency_rates = get_currency_rates(default_currency,currency_id).split('-');

    var to_currency_rate =  currency_rates[0];

    var from_currency_rate = currency_rates[1];

    var result = parseFloat(to_currency_rate / from_currency_rate * credit_amount).toFixed(2);

    if(!isNaN(result))

    $('#credit_amount').html(result);

    else

    $('#credit_amount').html((0).toFixed(2));

  }, 800);

}



</script>

<!-- <script type="text/javascript" src="<?php echo BASE_URL_B2C ?>js/scripts.js"></script> -->