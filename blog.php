<?php

include 'config.php';

include BASE_URL.'model/model.php';

//Include header

include 'layouts/header.php';

$blog_id = $_GET['blog_id'];

$b2c_blogs = array();

$b2c_blogs = $cached_array[0]->cms_data[3]->b2c_blogs;

?>


<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

        <span class="pageTitle mb-0">Blogs</span>

      </div>

      <!-- *** Search Head End **** -->

    </div>



    <div class="col-md-5 col-12 c-breadcrumbs">

      <ul>

        <li>

          <a href="<?= BASE_URL_B2C ?>">Home</a>

        </li>

        <li class="st-active">

          <a href="javascript:void(0)">Blogs</a>

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

            <h1 class="ts-section-title">BLOGS</h1>

        </div>

    </div>

</section> -->

<!-- Landing Section End -->

<input type='hidden' value='<?php echo json_encode($b2c_blogs,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='b2c_blogs' name='b2c_blogs'/>



<div id='noData-container'></div>

<div id='data-container'>

</div>

<div id='pagination-container'></div>



<?php include 'layouts/footer.php';?>

<script type="text/javascript" src="js/scripts.js"></script>

<script>

$(document).ready(function () {

    

    var hotel_results = $('#b2c_blogs').val();

    hotel_results = JSON.parse(hotel_results);

    $('#pagination-container').pagination({

        dataSource:(hotel_results) ,

        pageSize: 3,

        isForced:true,

        callback: function(data, pagination) {

                

            $.post('blog_data_fetch.php', { data: data }, function (html) {

                $('#data-container').html(html);

            });

        }

    });

});

</script>