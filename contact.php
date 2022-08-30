<?php

include 'config.php';

//Include header

include 'layouts/header.php';

$service = $_GET['service'];

global $app_contact_no;

?>

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle mb-0">Contact Us</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Contact Us</a>

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

            <h1 class="ts-section-title">Contact Us</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->



<!-- Contact Section Start -->

<section class="ts-contact-section">

    <div class="container">

        <div class="ts-section-subtitle-content">

            <h2 class="ts-section-subtitle">CONTACT US </h2>

            <span class="ts-section-subtitle-icon"><img src="images/traveler.png" alt="traveler" classimg-fluid></span>

        </div>

        <h2 class="ts-section-title">GET IN TOUCH</h2>

        <div class="row">

            <div class="col col-12 col-md-6 col-lg-5">

                <ul class="ts-contact-info-list">

                    <li class="ts-contact-info-item">

                        <span class="ts-contact-info-icon">

                            <i class="fa fa-map-marker"></i>

                        </span>

                        <a class="ts-contact-info-link"><?= $cached_array[0]->company_profile_data[0]->address ?></a>

                    </li>

                    <li class="ts-contact-info-item">

                        <span class="ts-contact-info-icon">

                            <i class="fa fa-phone"></i>

                        </span>

                        <a <?= $cached_array[0]->company_profile_data[0]->contact_no ?>" class="ts-contact-info-link"><?= $cached_array[0]->company_profile_data[0]->contact_no ?></a>

                    </li>

                    <li class="ts-contact-info-item">

                        <span class="ts-contact-info-icon">

                            <i class="fa fa-envelope-o"></i>

                        </span>

                        <a href="mailto:<?= $cached_array[0]->company_profile_data[0]->email_id ?>" class="ts-contact-info-link"><?= $cached_array[0]->company_profile_data[0]->email_id ?></a>

                    </li>

                    <li class="ts-contact-info-item">

                        <span class="ts-contact-info-icon">

                            <i class="fa fa-clock-o"></i>

                        </span>

                        <a class="ts-contact-info-link"><?= $cached_array[0]->cms_data[0]->header_strip_note ?></a>

                    </li>

                </ul>

                <ul class="ts-social-media-list">

                    <?php

                    if($social_media[0]->fb != ''){ ?>

                    <li class="ts-social-media-item">

                        <a target="_blank" href="<?= $social_media[0]->fb ?>" class="ts-social-media-link">

                            <span class="ts-contact-info-icon">

                                <i class="fa fa-facebook"></i>

                            </span>

                        </a>

                    </li>

                    <?php }

                    if($social_media[0]->inst != ''){ ?>

                    <li class="ts-social-media-item">

                        <a target="_blank" href="<?= $social_media[0]->inst ?>" class="ts-social-media-link">

                            <span class="ts-contact-info-icon">

                                <i class="fa fa-instagram"></i>

                            </span>

                        </a>

                    </li>

                    <?php }

                    if($social_media[0]->wa != ''){ ?>

                    <li class="ts-social-media-item">

                        <a target="_blank" href="<?= $social_media[0]->wa ?>" class="ts-social-media-link">

                            <span class="ts-contact-info-icon">

                                <i class="fa fa-whatsapp"></i>

                            </span>

                        </a>

                    </li>

                    <?php } ?>

                </ul>

            </div>

            <div class="col col-12 col-md-6 col-lg-7">

                <div class="ts-contact-form">

                    <form id="contact_us_form" class="needs-validation" novalidate>

                        <div class="form-row">

                            <div class="form-group col-md-6">

                                <label for="inputName">Name *</label>

                                <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name" onkeypress="return blockSpecialChar(event)" required>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="inputEmail">Email *</label>

                                <input type="email" class="form-control" id="inputEmail1" name="inputEmail1" placeholder="Email" required>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="inputPhone">Phone *</label>

                                <input type="number" class="form-control" id="inputPhone" name="inputPhone" placeholder="Phone" required>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="inputState">Interested In *</label>

                                <select id="inputState" name="inputState" class="form-control" required>

                                    <option value="">Select</option>

                                    <option value="Group Tour Package">Group Tour Package</option>

                                    <option value="Holiday Tour Package">Holiday Tour Package</option>

                                    <option value="Hotel Booking">Hotel Booking</option>

                                    <option value="Activities">Activities</option>

                                    <option value="Visa">Visa</option>

                                    <option value="Transfer">Transfer</option>

                                    <option value="Cruise">Cruise</option>

                                    <option value="Other">Other</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label for="InputMessage">Message*</label>

                            <textarea id="inputMessage" name="inputMessage" rows="8" class="form-control" placeholder="Message" required ></textarea>

                        </div>

                        <button type="submit" id="contact_form_send" class="btn btn-primary">Send Message</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Contact Section End -->



<!-- Contact Map Section Start -->

<?php

if($cached_array[0]->cms_data[0]->google_map_script!=''){?>

    <section class="ts-map-section">

        <iframe src="<?= $cached_array[0]->cms_data[0]->google_map_script ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

    </section>

<?php } ?>

<!-- Contact Map Section End -->

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