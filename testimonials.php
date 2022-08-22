<?php

include 'config.php';

//Include header

include 'layouts/header.php';

$b2c_testm = $cached_array[0]->cms_data[4];

?>

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle mb-0">Testimonials</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Testimonials</a>

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

            <h1 class="ts-section-title">Testimonials</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->





<!-- Testimonial Section Start -->

<section class="ts-customer-testimonial-section">

    <div class="container">

        <div class="ts-section-subtitle-content">

            <h2 class="ts-section-subtitle">RELAX AND ENJOY</h2>

            <span class="ts-section-subtitle-icon"><img src="images/traveler.png" alt="traveler" classimg-fluid=""></span>

        </div>

        <h2 class="ts-section-title">HAPPY CUSTOMERS</h2>

            <?php

            if(sizeof($b2c_testm->customer_testimonials) != 0){

                ?>

            <div class="row">

            <?php

    

                $testm = $b2c_testm->customer_testimonials;

                for($testm_count=0;$testm_count<=sizeof($testm)-1;$testm_count++){

                        

                    //Image

                    $url = $testm[$testm_count]->image;

                    $pos = strstr($url,'uploads');

                    if ($pos != false)   {

                        $newUrl = preg_replace('/(\/+)/','/',$url); 

                        $newUrl1 = BASE_URL.str_replace('../', '', $newUrl);

                    }

                    else{

                        $newUrl1 =  $url; 

                    }

                    $name = ($testm[$testm_count]->designation!='') ? $testm[$testm_count]->name. '('.$testm[$testm_count]->designation.')' : $testm[$testm_count]->name;

                    if($name!=''){

                        ?>

                        <div class="col col-12 col-md-6 col-lg-12">

                            <div class="ts-customer-testimonial-card">

                                <div class="ts-customer-testimonial-img">

                                    <img src="<?= $newUrl1 ?>" alt="Customer Image" class="img-fluid">

                                    <h3 class="ts-customer-testimonial-name"><?= $name ?></h3>

                                </div>

                                <p class="ts-customer-testimonial-description"><?=$testm[$testm_count]->testm ?></p>

                                <ul class="ts-rating-list">

                                    <li class="ts-rating-item">

                                        <i class="fa fa-star"></i>

                                    </li>

                                    <li class="ts-rating-item">

                                        <i class="fa fa-star"></i>

                                    </li>

                                    <li class="ts-rating-item">

                                        <i class="fa fa-star"></i>

                                    </li>

                                    <li class="ts-rating-item">

                                        <i class="fa fa-star"></i>

                                    </li>

                                    <li class="ts-rating-item">

                                    <i class="fa fa-star-half-o"></i>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <?php

                    }

                } 

            ?>

            </div>

        <?php } ?>

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