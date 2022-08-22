  <!-- ********** Component :: Footer ********** -->
  <footer class="c-footer">
    <div class="footer-wrapper">
      <div class="container">
        <div class="row">
          <?php
          $query1 = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM `b2b_settings_second`"));
          $col1 = ($query1['col1']!='')?json_decode($query1['col1']):[];
          if($col1[0]->display_status != 'Hide'){
          ?>
          <div class="col-sm-6 col-md-3">
            <h2 class="c-heading">Best Selling Hotels</h2>
                <ul class="c-footerLink">
                <?php
                  $col1_hotel = ($col1[0]->hotels!='')?($col1[0]->hotels):[];
                  for($i=0;$i<sizeof($col1_hotel);$i++){

                    $city_id = $col1_hotel[$i]->city_id;
                    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                    $hotel_id=$col1_hotel[$i]->hotel_id;
                    $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$hotel_id'"));
                    ?>
                    <li><a onclick="get_select_hotel('<?= $city_id ?>','<?= $hotel_id ?>','<?= date('m/d/Y',strtotime($date1 . '+1 days')) ?>','<?=date('m/d/Y',strtotime($date1 . '+2 days'))?>');"><?= $sq_hotel['hotel_name'] ?></a></li>
                  <?php } ?>
                </ul>
          </div>
          <?php }
          $col2 = ($query1['col2']!='')?json_decode($query1['col2']):[];
          if($col2[0]->display_status != 'Hide'){
          ?>
          <div class="col-sm-6 col-md-3">
            <h2 class="c-heading">Best Selling Activities</h2>
                <ul class="c-footerLink">
                <?php
                $col2_act = ($col2[0]->activities!='')?($col2[0]->activities):[];
                for($i=0;$i<sizeof($col2_act);$i++){

                    $city_id=$col2_act[$i]->city_id;
                    $exc_id = $col2_act[$i]->exc_id;
                    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$city_id'"));
                    $sq_exc = mysqli_fetch_assoc(mysqlQuery("select entry_id from excursion_master_tariff where excursion_name='$exc_id'"));
                ?>
                  <li><a onclick="get_select_activity('<?=$city_id ?>','<?=$sq_exc['entry_id'] ?>','<?= date('m/d/Y',strtotime($date1 . '+1 days')) ?>');"><?= $exc_id ?></a></li>
                <?php } ?>
                </ul>
          </div>
          <?php }
          $col3 = ($query1['col3']!='')?json_decode($query1['col3']):[];
          if($col3[0]->display_status != 'Hide'){
          ?>
          <div class="col-sm-6 col-md-3">
            <h2 class="c-heading">Best Selling Tours</h2>
                <ul class="c-footerLink">
                <?php
                $col3_tours = ($col3[0]->tours!='')?($col3[0]->tours):[];
                for($i=0;$i<sizeof($col3_tours);$i++){

                    $dest_id=$col3_tours[$i]->dest_id;
                    $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_id,dest_name from destination_master where dest_id='$dest_id'"));
                    $package_id=$col3_tours[$i]->package_id;
                    $sq_package = mysqli_fetch_assoc(mysqlQuery("select package_id,package_name from custom_package_master where package_id='$package_id'"));
                  ?>
                  <li><a onclick="get_select_package('<?=$dest_id ?>','<?=$package_id ?>','<?= date('m/d/Y',strtotime($date1 . '+1 days')) ?>');"><?= $sq_package['package_name'] ?></a></li>
                  <?php } ?>
                </ul>
          </div>
          <?php } ?>
          <div class="col-sm-6 col-md-3">
            <h2 class="c-heading">Terms & Policies</h2>
                <ul class="c-footerLink">
                  <li><a target="_blank" href="<?php echo BASE_URL ?>Tours_B2B/terms-conditions.php">Terms & Conditions</a></li>
                  <li><a target="_blank" href="<?php echo BASE_URL ?>Tours_B2B/privacy-policy.php">Privacy Policy</a></li>
                  <li><a target="_blank" href="<?php echo BASE_URL ?>Tours_B2B/cancellation-policy.php">Cancellation Policy</a></li>
                  <li><a target="_blank" href="<?php echo BASE_URL ?>Tours_B2B/refund-policy.php">Refund Policy</a></li>
                  <li><a target="_blank" href="<?php echo BASE_URL ?>Tours_B2B/careers.php">Careers</a></li>
                </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="c-bottom">
      <div class="container">
        <!-- <div class="row">
          <div class="col-sm-6 col-12">
            <div class="c-footerLogos">
              <ul>
                <li><img src="<?php echo BASE_URL ?>Tours_B2B/images/svg/american-express.svg" /></li>
                <li><img src="<?php echo BASE_URL ?>Tours_B2B/images/svg/visa.svg" /></li>
                <li><img src="<?php echo BASE_URL ?>Tours_B2B/images/svg/mastercard.svg" /></li>
              </ul>
            </div>
          </div>

          <div class="col-sm-6 col-12">
            <div class="c-footerSocial clearfix">
              <ul class="social-icons">
                <li class="twitter">
                  <a title="twitter" href="javascript:void(0);"
                    ><i class="soap-icon-twitter"></i
                  ></a>
                </li>
                <li class="googleplus">
                  <a title="googleplus" href="javascript:void(0);"
                    ><i class="soap-icon-googleplus"></i
                  ></a>
                </li>
                <li class="facebook">
                  <a title="facebook" href="javascript:void(0);"
                    ><i class="soap-icon-facebook"></i
                  ></a>
                </li>
                <li class="twitter">
                  <a title="twitter" href="javascript:void(0);"
                    ><i class="soap-icon-twitter"></i
                  ></a>
                </li>
                <li class="googleplus">
                  <a title="googleplus" href="javascript:void(0);"
                    ><i class="soap-icon-googleplus"></i
                  ></a>
                </li>
                <li class="facebook">
                  <a title="facebook" href="javascript:void(0);"
                    ><i class="soap-icon-facebook"></i
                  ></a>
                </li>
              </ul>
            </div>
          </div>
        </div> -->

        <div class="row">
          <div class="col-12 c-footerText">
            <span><?= $query1['footer_strip'] ?></span>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- ********** Component :: Footer End ********** -->
</div>
<input type="hidden" id="credit_amount_temp" value="<?= $credit_amount ?>" name="credit_amount_temp"/>
<div id="site_alert"></div>
<div id='hotel-result'></div>

<div class="modal fade shoppingCartModal" id="shopping_list_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
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
</div>
<!-- Javascript -->
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/jquery-ui.1.10.4.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/bootstrap-4.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/theme-scripts.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/vi.alert.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/scripts.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/jquery-confirm.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script>

</body>
</html>
<script>
$(document).ready(function () {
  if (typeof Storage !== 'undefined') {
    var currency_id = $('#currency').val();
    if (localStorage) {
      var global_currency = localStorage.getItem('global_currency');
      
    } else {
      var global_currency = window.sessionStorage.getItem('global_currency');
    }
  }
  //Get selected Currency Dropdown
  var base_url = $('#base_url').val();
  $.post(base_url+'Tours_B2B/view/get_currency_dropdown.php', { currency_id : global_currency }, function (data){
      $('#currency_dropdown').html(data);
  });
  $('#currency').select2();

  //Cart Items and Count
  var register_id = $('#register_id').val();
  $.post(base_url+'Tours_B2B/view/get_cart_data.php', { register_id : register_id }, function (data){
    if (typeof Storage !== 'undefined') {
      if (localStorage){
        var cart_list_arr = JSON.parse(localStorage.getItem('cart_list_arr'));
        var cLength = (cart_list_arr) ? cart_list_arr.length : 0;
      }
      else{
        var cart_list_arr = window.sessionStorage.getItem('cart_list_arr');
        var cLength = (cart_list_arr) ? cart_list_arr.length : 0;
      }
    }
    $('#cart_item_count').html(cLength);
  });
});

//Set selected currency in local/session storage
function get_selected_currency(){
    var base_url = $('#base_url').val();
    var currency_id = $('#currency').val();

    //Set selected currency in php session also
    $.post(base_url + 'Tours_B2B/view/set_currency_session.php', { currency_id: currency_id}, function (data) {
    });

    if (typeof Storage !== 'undefined') {
      if (localStorage) {
        localStorage.setItem(
          'global_currency', currency_id
        );
      } else {
        window.sessionStorage.setItem(
          'global_currency', currency_id
        );
      }
    }
    // Call respective currency converter according active page url
    var current_page_url = document.URL;
    var index_pageurl = base_url + 'Tours_B2B/view/index.php';
    var hotel_pageurl = base_url + 'Tours_B2B/view/hotel/hotel-listing.php';
    var transfer_pageurl = base_url + 'Tours_B2B/view/transfer/transfer-listing.php';
    var activities_pageurl = base_url + 'Tours_B2B/view/transfer/activities-listing.php';
    var tours_pageurl = base_url + 'Tours_B2B/view/transfer/tours-listing.php';
    var ferry_pageurl = base_url + 'Tours_B2B/view/ferry/ferry-listing.php';
    var checkout_pageurl = base_url + 'Tours_B2B/checkout_pages/cartPage.php';
    if(current_page_url==checkout_pageurl){
      checkout_currency_converter();
    }
    else if(current_page_url==index_pageurl){
      index_page_currencies();
    }
    else if(current_page_url==ferry_pageurl){
      ferry_page_currencies();
    }
    else if(current_page_url==transfer_pageurl){
      transfer_page_currencies();
    }
    else if(current_page_url==activities_pageurl){
      activties_page_currencies();
    }
    else if(current_page_url==tours_pageurl){
      tours_page_currencies();
    }
    else if(current_page_url==hotel_pageurl){
      currency_converter();
    }
    else{
      currency_converter();
    }
    location.reload();
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

function ferry_page_currencies(){
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
    // setTimeout(() => {
      //Load Currency Icon
      var currency_icon_lisr = document.querySelectorAll(".currency-icon");
      var cache_currencies = JSON.parse($('#cache_currencies').val());
      var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';
      currency_icon_lisr.forEach(function(item){
          item.innerHTML = to_currency_rate.icon;
      });
      //Credit amount conversion
      var currency_rates = get_currency_rates(default_currency,currency_id).split('-');
      var to_currency_rate =  currency_rates[0];
      var from_currency_rate = currency_rates[1];
      var result = parseFloat(to_currency_rate / from_currency_rate * credit_amount).toFixed(2);
      if(!isNaN(result))
      $('#credit_amount').html(result);
      else
      $('#credit_amount').html((0).toFixed(2));

      //ferry prices
      var price_list = JSON.parse(sessionStorage.getItem('ferry_amount_list'));
      var amount_Classlist = document.querySelectorAll(".ferry-currency-price");
      if(price_list !== null && amount_Classlist[0] !== undefined){
        price_list.map((tour,i)=>{
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];
          amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        });
      }
      
      //ferry adult prices
      var price_list = JSON.parse(sessionStorage.getItem('ferry_adult_amount_list'));
      var amount_Classlist = document.querySelectorAll(".ferry-currency-adult_price");
      if(price_list !== null && amount_Classlist[0] !== undefined){
        price_list.map((tour,i)=>{
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];
          amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        });
      }
      //ferry child prices
      var price_list = JSON.parse(sessionStorage.getItem('ferry_child_amount_list'));
      var amount_Classlist = document.querySelectorAll(".ferry-currency-child_price");
      if(price_list !== null && amount_Classlist[0] !== undefined){
        price_list.map((tour,i)=>{
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];
          amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        });
      }
      //ferry infant prices
      var price_list = JSON.parse(sessionStorage.getItem('ferry_infant_amount_list'));
      var amount_Classlist = document.querySelectorAll(".ferry-currency-infant_price");
      if(price_list !== null && amount_Classlist[0] !== undefined){
        price_list.map((tour,i)=>{
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];
          amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        });
      }
      //Best High-Low cost array(Price Range filter) 
      var best_price_list = JSON.parse(sessionStorage.getItem('ferry_best_price'));
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
    // },800);
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
    // setTimeout(() => {
      //Load Currency Icon
      var currency_icon_lisr = document.querySelectorAll(".currency-icon");
      var cache_currencies = JSON.parse($('#cache_currencies').val());
      var to_currency_rate = (cache_currencies.find(el => el.id === currency_id) !== undefined )?cache_currencies.find(el => el.id === currency_id) : '0';
      currency_icon_lisr.forEach(function(item){
          item.innerHTML = to_currency_rate.icon;
      });
      //Credit amount conversion
      var currency_rates = get_currency_rates(default_currency,currency_id).split('-');
      var to_currency_rate =  currency_rates[0];
      var from_currency_rate = currency_rates[1];
      var result = parseFloat(to_currency_rate / from_currency_rate * credit_amount).toFixed(2);
      if(!isNaN(result))
      $('#credit_amount').html(result);
      else
      $('#credit_amount').html((0).toFixed(2));

      //Transfer prices
      var price_list = JSON.parse(sessionStorage.getItem('transfer_amount_list'));
      var amount_Classlist = document.querySelectorAll(".transfer-currency-price");
      if(price_list !== null && amount_Classlist[0] !== undefined){
        price_list.map((tour,i)=>{
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];
          amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        });
      }

      //Best High-Low cost array(Price Range filter) 
      var best_price_list = JSON.parse(sessionStorage.getItem('transfer_best_price'));
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
    // },800);
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
    //Credit amount conversion
    var currency_rates = get_currency_rates(default_currency,currency_id).split('-');
    var to_currency_rate =  currency_rates[0];
    var from_currency_rate = currency_rates[1];
    var result = parseFloat(to_currency_rate / from_currency_rate * credit_amount).toFixed(2);
    if(!isNaN(result))
    $('#credit_amount').html(result);
    else
    $('#credit_amount').html((0).toFixed(2));

    //Activity best original prices
    var price_list = JSON.parse(sessionStorage.getItem('bestorg_price_list'));
    var amount_Classlist = document.querySelectorAll(".best-activity-orgamount");
    if(price_list !== null && amount_Classlist[0] !== undefined){
      price_list.map((tour,i)=>{
        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
      });
    }
    //Activity best offer prices
    var price_list = JSON.parse(sessionStorage.getItem('trans_price_list'));
    var amount_Classlist = document.querySelectorAll(".best-activity-amount");
    if(price_list !== null && amount_Classlist[0] !== undefined){
      price_list.map((tour,i)=>{
        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
      });
    }
    //Activity best offer prices
    var price_list = JSON.parse(sessionStorage.getItem('trans_price_list'));
    var amount_Classlist = document.querySelectorAll(".best-activity-amount");
    if(price_list !== null && amount_Classlist[0] !== undefined){
      price_list.map((tour,i)=>{
        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
      });
    }
    //Activities prices
    var price_list = JSON.parse(sessionStorage.getItem('transfer_amount_list'));
    var amount_Classlist = document.querySelectorAll(".activity-currency-price");
    if(price_list !== null && amount_Classlist[0] !== undefined){
      price_list.map((tour,i)=>{
        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
      });
    }
    //Activities Original prices
    var price_list = JSON.parse(sessionStorage.getItem('orgtransfer_amount_list'));
    var amount_Classlist = document.querySelectorAll(".activity-orgcurrency-price");
    if(price_list !== null && amount_Classlist[0] !== undefined){
      price_list.map((tour,i)=>{
        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
      });
    }
    //Activities Offer prices
    var price_list = JSON.parse(sessionStorage.getItem('transferoffer_price_list'));
    var amount_Classlist = document.querySelectorAll(".offer-currency-price");
    if(price_list !== null && amount_Classlist[0] !== undefined){
      price_list.map((tour,i)=>{
        if(tour.flag == ''){
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];
        amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        }
      });
    }
    //Best High-Low cost array(Price Range filter) 
    var best_price_list = JSON.parse(sessionStorage.getItem('activity_best_price'));
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
          ans_arr3.push((parseFloat(to_currency_rate / from_currency_rate * tour.amount)));
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
function tours_page_currencies(){

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
    //Credit amount conversion
    var currency_rates = get_currency_rates(default_currency,currency_id).split('-');
    var to_currency_rate =  currency_rates[0];
    var from_currency_rate = currency_rates[1];
    var result = parseFloat(to_currency_rate / from_currency_rate * credit_amount).toFixed(2);
    if(!isNaN(result))
      $('#credit_amount').html(result);
    else
      $('#credit_amount').html((0).toFixed(2));

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
    
    var offeramt_Classlist = document.querySelectorAll(".offer-currency-price");
    var offer_price_list = JSON.parse(sessionStorage.getItem('tours_offer_price_list'));
    //Hotel Offer Cost
    if(offer_price_list !== null && offeramt_Classlist[0] !== undefined){
      offer_price_list.map((tour,i)=>{
        if(tour.flag == ''){
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];

          offeramt_Classlist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        }
      });
    }

    // //Adult prices
    // var price_list = JSON.parse(sessionStorage.getItem('adult_price_list'));
    // var amount_Classlist = document.querySelectorAll(".adult_cost-currency-price");
    // if(price_list !== null && amount_Classlist[0] !== undefined){
    //   price_list.map((tour,i)=>{
    //     var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
    //     var to_currency_rate =  currency_rates[0];
    //     var from_currency_rate = currency_rates[1];
    //     amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
    //   });
    // }
    // //Child WO prices
    // var price_list = JSON.parse(sessionStorage.getItem('childwo_price_list'));
    // var amount_Classlist = document.querySelectorAll(".childwo_cost-currency-price");
    // if(price_list !== null && amount_Classlist[0] !== undefined){
    //   price_list.map((tour,i)=>{
    //     var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
    //     var to_currency_rate =  currency_rates[0];
    //     var from_currency_rate = currency_rates[1];
    //     amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
    //   });
    // }
    // //Child WI prices
    // var price_list = JSON.parse(sessionStorage.getItem('childwi_price_list'));
    // var amount_Classlist = document.querySelectorAll(".childwi_cost-currency-price");
    // if(price_list !== null && amount_Classlist[0] !== undefined){
    //   price_list.map((tour,i)=>{
    //     var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
    //     var to_currency_rate =  currency_rates[0];
    //     var from_currency_rate = currency_rates[1];
    //     amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
    //   });
    // }
    // //Extra Bed prices
    // var price_list = JSON.parse(sessionStorage.getItem('extrabed_price_list'));
    // var amount_Classlist = document.querySelectorAll(".extrabed-currency-price");
    // if(price_list !== null && amount_Classlist[0] !== undefined){
    //   price_list.map((tour,i)=>{
    //     var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
    //     var to_currency_rate =  currency_rates[0];
    //     var from_currency_rate = currency_rates[1];
    //     amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
    //   });
    // }
    // //Infant prices
    // var price_list = JSON.parse(sessionStorage.getItem('infant_price_list'));
    // var amount_Classlist = document.querySelectorAll(".infant_cost-currency-price");
    // if(price_list !== null && amount_Classlist[0] !== undefined){
    //   price_list.map((tour,i)=>{
    //     var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
    //     var to_currency_rate =  currency_rates[0];
    //     var from_currency_rate = currency_rates[1];
    //     amount_Classlist[i].innerHTML = parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
    //   });
    // }
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
          ans_arr3.push((parseFloat(to_currency_rate / from_currency_rate * tour.amount)));
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
    
    var cartamt_Classlist = document.querySelectorAll(".cart-currency-price");
    var cart_item_list = JSON.parse(localStorage.getItem('cart_item_list'));
    //Cart Items cost array
    if(cart_item_list !== null && cartamt_Classlist[0] !== undefined){
      cart_item_list.map((tour,i)=>{
       
        var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];

        cartamt_Classlist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
      });
    }
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
        if(tour.flag == ''){
          var currency_rates = get_currency_rates(tour.id,currency_id).split('-');
          var to_currency_rate =  currency_rates[0];
          var from_currency_rate = currency_rates[1];

          offeramt_Classlist[i].innerHTML =  parseFloat(to_currency_rate / from_currency_rate * tour.amount).toFixed(2);
        }
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
        if(tour.id!=currency_id){
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

function clearRange() {
    var ans_arr= ($('#price_rangevalues').val());
    ans_arr = ans_arr.split(',');
    if(ans_arr[0]==ans_arr[1]){
      var bestlow_cost = 0;
      var besthigh_cost = ans_arr[0];
    }
    else if(parseFloat(ans_arr[1]) > parseFloat(ans_arr[0])){
      var bestlow_cost = ans_arr[0];
      var besthigh_cost = ans_arr[1];
    }
    else{
      var bestlow_cost = ans_arr[1];
      var besthigh_cost = ans_arr[0];
    }
  jQuery('.c-priceRange').next('div').remove();
  reinit(bestlow_cost,besthigh_cost);
}
</script>