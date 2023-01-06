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

                    <span class="pageTitle mb-0">About Us</span>

                </div>

                <!-- *** Search Head End **** -->

            </div>



            <div class="col-md-5 col-12 c-breadcrumbs">

                <ul>

                    <li>

                        <a href="<?= BASE_URL_B2C ?>">Home</a>

                    </li>

                    <li class="st-active">

                        <a href="javascript:void(0)">About Us</a>

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

            <h1 class="ts-section-title">About Us</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->



<!-- Reason Section End -->

<section class="ts-reason-section ts-font-poppins">

    <div class="container">

        <div class="ts-section-subtitle-content">

            <h2 class="ts-section-subtitle">KNOW MORE</h2>

            <span class="ts-section-subtitle-icon"><img src="images/traveler.png" alt="traveler"
                    classimg-fluid=""></span>

        </div>

        <h2 class="ts-section-title">WHY CHOOSE US?</h2>



        <div class="row">

            <div class="col col-12 col-md-6 col-lg-6">

                <div class="ts-reason-card">

                    <div class="ts-reason-card-icon">

                        <div class="ts-reason-icon__inner">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4zM480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6V112.6zM288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112z"
                                    fill="#fff"></path>
                            </svg>

                        </div>

                    </div>

                    <div class="ts-reason-card-body">

                        <h3 class="ts-reason-card-title">Easy Tour Booking</h3>

                        <p class="ts-reason-card-description">We believe in providing hassle free and convenient tour
                            booking options to our guests. Tour enquiries / booking can be done through our websites.
                            And can send us e-mail directly to get a prompt reply.</p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-6">

                <div class="ts-reason-card">

                    <div class="ts-reason-card-icon">

                        <div class="ts-reason-icon__inner">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4zM480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6V112.6zM288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112z"
                                    fill="#fff"></path>
                            </svg>

                        </div>

                    </div>

                    <div class="ts-reason-card-body">

                        <h3 class="ts-reason-card-title">Customizable Tour Packages</h3>

                        <p class="ts-reason-card-description">We understand our guests needs to perfection and thus
                            provide them with flexible customized holiday packages according to their needs and
                            requirements.</p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-6">

                <div class="ts-reason-card">

                    <div class="ts-reason-card-icon">

                        <div class="ts-reason-icon__inner">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4zM480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6V112.6zM288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112z"
                                    fill="#fff"></path>
                            </svg>

                        </div>

                    </div>

                    <div class="ts-reason-card-body">

                        <h3 class="ts-reason-card-title">Experienced Travel Consultants</h3>

                        <p class="ts-reason-card-description">Our travel consultants carry years of experience in the
                            travel industry and consists of travel enthusiasts who themselves are travel buffs.</p>

                    </div>

                </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-6">

                <div class="ts-reason-card">

                    <div class="ts-reason-card-icon">

                        <div class="ts-reason-icon__inner">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M279.6 160.4C282.4 160.1 285.2 160 288 160C341 160 384 202.1 384 256C384 309 341 352 288 352C234.1 352 192 309 192 256C192 253.2 192.1 250.4 192.4 247.6C201.7 252.1 212.5 256 224 256C259.3 256 288 227.3 288 192C288 180.5 284.1 169.7 279.6 160.4zM480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6V112.6zM288 112C208.5 112 144 176.5 144 256C144 335.5 208.5 400 288 400C367.5 400 432 335.5 432 256C432 176.5 367.5 112 288 112z"
                                    fill="#fff"></path>
                            </svg>

                        </div>

                    </div>

                    <div class="ts-reason-card-body">

                        <h3 class="ts-reason-card-title">Quick Assistance for Guests</h3>

                        <p class="ts-reason-card-description">We are available for our guests any day of the week. With
                            our highly trained operations team, we keep a look out for even the most minute of issues.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Reason Section End -->



<!-- Special Section Start -->

<section class="ts-special-section ts-font-poppins">

    <div class="row no-gutters">

        <div class="col col-12 col-md-6 col-lg-6">

            <div class="ts-special-img">

                <img src="images/banner-2.jpg" alt="Special" class="img-fluid">

            </div>

        </div>

        <div class="col col-12 col-md-6 col-lg-6">

            <div class="ts-special-content">

                <div class="ts-special-content__inner">

                    <h2 class="ts-section-title">Make Memories All Over The World!</h2>

                    <p class="ts-section-description">Our distinctive team meets the needs of luxury traveler and
                        creates the opportunity to REDISCOVER EXPERIENCES. The USP of our company is our belief in
                        building and maintaining long term relation with our clients. This stems from our core company
                        values which places family culture at the top.</p>

                    <div class="abt-btn">
                        <a target="_blank" href="contact.php" class="btn btn-primary">Contact Us</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Special Section End -->

<script type="text/javascript" src="js/scripts.js"></script>

<?php include 'layouts/footer.php';?>