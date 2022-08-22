<?php

include 'config.php';

//Include header

include 'layouts/header.php';

$coupon_codes = $cached_array[0]->cms_data[0]->coupon_codes;

$coupon_codes = ($coupon_codes != ''&&$coupon_codes != 'null') ? json_decode($coupon_codes) : [];

?>

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle mb-0">Offers</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Offers</a>

        </li>

      </ul>

    </div>



  </div>

</div>

</div>

<!-- ********** Component :: Page Title End ********** -->

<!-- Landing Section Start -->

<!-- <section class="ts-inner-landing-section ts-font-poppins">

    <img src="images/banner-2.jpg" alt="" class="img-fluid">

    <div class="ts-inner-landing-content">

        <div class="container">

            <h1 class="ts-section-title">Offers</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->





<!-- Testimonial Section Start -->

<section class="ts-customer-testimonial-section ts-destinations-section">

    <div class="container">

        <div class="row">

            <?php

            for($i = 0; $i < sizeof($coupon_codes); $i++){

                

                $date = time()-(60*60*24);

                $valid_date = date('d-m-Y',strtotime($coupon_codes[$i]->valid_date));

                if($date < strtotime($valid_date)){

                    $offer = '';

                    if($coupon_codes[$i]->amount_in == 'Percentage'){

                        $offer = $coupon_codes[$i]->amount.'% off,';

                    }else{

                        $offer = 'Flat '.$coupon_codes[$i]->amount.' off,';

                    }

                    $offer .= ' valid upto '.$coupon_codes[$i]->valid_date;

                    ?>

                    <div class="col col-12 col-md-6 col-lg-4">

                        <div class="ts-service-card">

                            <div class="ts-service-icon">

                                <div class="ts-service-icon__inner">

                                    <i class="fa fa-gift" aria-hidden="true"></i>

                                </div>

                            </div>

                            <div class="ts-service-card-body">

                                <h4 class="ts-service-title"><?= $coupon_codes[$i]->title ?></h4>

                                <p class="ts-service-description"><?= $offer ?></p>

                            </div>

                        </div>

                    </div>

            <?php }

            } ?>

        </div>

    </div>

</section>

<!-- Testimonial Section End -->

<a href="#" class="scrollup">Scroll</a>



<?php include 'layouts/footer.php';?>

<script type="text/javascript" src="js/scripts.js"></script>

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

    

});

</script>