<?php

include 'config.php';

//Include header

include 'layouts/header.php';

?>


 <!-- ********** Component :: Page Title ********** -->

 <div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle mb-0">Services</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Services</a>

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

            <h1 class="ts-section-title">Services</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->





<!-- Testimonial Section Start -->

<section class="ts-customer-testimonial-section ts-destinations-section">

    <div class="container">

        <div class="ts-section-subtitle-content">

            <h2 class="ts-section-subtitle">OUR SERVICES</h2>

            <span class="ts-section-subtitle-icon"><img src="images/traveler.png" alt="traveler" classimg-fluid=""></span>

        </div>

        <h2 class="ts-section-title">Our top travel services</h2>

        <div class="row">

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-service-card">

                    <div class="ts-service-icon">

                        <div class="ts-service-icon__inner">

                            <i class="fa fa-address-card-o"></i>

                        </div>

                    </div>

                    <div class="ts-service-card-body">

                        <h4 class="ts-service-title">Visa</h4>

                        <p class="ts-service-description">Visa is a part of our complete suite of travel solutions apart from air ticketing and Forex services. </p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-service-card">

                    <div class="ts-service-icon">

                        <div class="ts-service-icon__inner">

                            <i class="fa fa-flag-o"></i>

                        </div>

                    </div>

                    <div class="ts-service-card-body">

                        <h4 class="ts-service-title">Passport</h4>

                        <p class="ts-service-description">Our team of extremely efficient and experienced of professionals to handle all the requisite visa services.</p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-service-card">

                    <div class="ts-service-icon">

                        <div class="ts-service-icon__inner">

                            <i class="fa fa-money"></i>

                        </div>

                    </div>

                    <div class="ts-service-card-body">

                        <h4 class="ts-service-title">MICE</h4>

                        <p class="ts-service-description">We value the concept of MICE tours i.e. Meetings,Incentive tours,Conferences & Exibitions to motivate employees. </p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-service-card">

                    <div class="ts-service-icon">

                        <div class="ts-service-icon__inner">

                            <i class="fa fa-glide-g"></i>

                        </div>

                    </div>

                    <div class="ts-service-card-body">

                        <h4 class="ts-service-title">Insurance</h4>

                        <p class="ts-service-description">Whether you travel for business or pleasure, travel involves risk. We provide the travel insurance services. </p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-service-card">

                    <div class="ts-service-icon">

                        <div class="ts-service-icon__inner">

                            <i class="fa fa-repeat"></i>

                        </div>

                    </div>

                    <div class="ts-service-card-body">

                        <h4 class="ts-service-title">SIM Card</h4>

                        <p class="ts-service-description">Local SIM card is most important whilte traveling abroad for communicate from overseas. </p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-4">

                <div class="ts-service-card">

                    <div class="ts-service-icon">

                        <div class="ts-service-icon__inner">

                            <i class="fa fa-camera-retro"></i>

                        </div>

                    </div>

                    <div class="ts-service-card-body">

                        <h4 class="ts-service-title">Forex Assistance</h4>

                        <p class="ts-service-description">Local country wise currencies are required to handle expenses paid joy. And we guide you.</p>

                    </div>

                </div>

            </div>

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