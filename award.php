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

        <span class="pageTitle mb-0">Awards</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Awards</a>

        </li>

      </ul>

    </div>



  </div>

</div>

</div>

<!-- ********** Component :: Page Title End ********** -->

<!-- Landing Section Start -->
<!-- 
<section class="ts-inner-landing-section ts-font-poppins">

    <img src="images/banner-2.jpg" alt="" class="img-fluid">

    <div class="ts-inner-landing-content">

        <div class="container">

            <h1 class="ts-section-title">Awards</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->



<section class="ts-destinations-section">

    <div class="container">

        <div id="lightGalleryImage" class="light-gallery-list">

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

            <a href="images/banner-2.jpg" class="light-gallery-item">

                <img alt="" src="images/banner-2.jpg" class="img-fluid" />

            </a>

        </div>

    </div>

</section>

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



<script type="text/javascript" src="js/scripts.js"></script>

<script>

    $( document ).ready(function() {    

    

    lightGallery(document.getElementById('lightGalleryImage'), {

            plugins: [lgZoom, lgThumbnail],

            speed: 500,

            download: true,

        });

    var width = $(".light-gallery-item img").width();

    $(".light-gallery-item img").height(width);

    

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