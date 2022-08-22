<?php
include_once('../model.php');
global $app_name, $app_contact_no, $app_email_id, $app_landline_no,$app_address,$app_website,$similar_text,$currency;

$package_id1 = $_GET['package_id'];
$enquiry_id1 = $_GET['enquiry_id'];
$package_id = base64_decode($package_id1);
$enquiry_id = base64_decode($enquiry_id1);
$count = 0;

$in = 'in';
$sq_tours_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id = '$package_id'"));
$sq_dest = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_tours_package[dest_id]'"));
$sq_dest1 = mysqli_fetch_assoc(mysqlQuery("select dest_name from destination_master where dest_id = '$sq_tours_package[dest_id]'"));
$sq_enq = mysqli_fetch_assoc(mysqlQuery("select email_id,assigned_emp_id,name,enquiry_date from enquiry_master where enquiry_id='$enquiry_id'"));
$date = $sq_enq['enquiry_date'];
$yr = explode("-", $date);
$year =$yr[0];
$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_enq[assigned_emp_id]'"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Package Tour</title>

    <meta property="og:title" content="Tour Operator Software - iTours" />
    <meta property="og:description" content="Welcome to tiTOurs leading tour operator software, CRM, Accounting, Billing, Invocing, B2B, B2C Online Software for all small scale & large scale companies" />
    <meta property="og:url" content="http://www.itouroperatorsoftware.com" />
    <meta property="og:site_name" content="iTour Operator Software" />
    <meta property="og:image" content="http://www.itouroperatorsoftware.com/images/iTours-Tour-Operator-Software-logo.png" />
    <meta property="og:image:width" content="215" />
    <meta property="og:image:height" content="83" />

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">



    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.theme.css" type="text/css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/modules/single_quotation.php">  

    </head>


    <body>

    <header>
    <!-- Header -->
    <nav class="navbar navbar-default">

        <!-- Header-Top -->
        <div class="Header_Top">
        <div class="container">
            <div class="row">
            <div class="col-xs-12">
                <ul class="company_contact">
                <li><a href="mailto:email@company_name.com"><i class="fa fa-envelope"></i> <?= $app_email_id; ?></a></li>
                <li><i class="fa fa-mobile"></i> <?= $app_contact_no; ?></li>
                <li><i class="fa fa-phone"></i>  <?= $app_landline_no; ?></li>
                </ul>
            </div>
            </div>
        </div>
        </div>
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header single_quotation_head">
        <a class="navbar-brand" href="http://<?= $app_website ?>"><img src="<?php echo BASE_URL ?>images/Admin-Area-Logo.png" class="img-responsive"></a>
        <div class="logo_right_part">
            <h1><i class="fa fa-pencil-square-o"></i> Package Tour</h1>
        </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="nav">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul id="menu-center" class="nav navbar-nav">
            <li class="active"><a href="#0">Package</a></li>
            <li><a href="#1">Costing</a></li>
            <li><a href="#2">Transport</a></li>
            <li><a href="#3">Tour Itinerary</a></li>
            <li><a href="#4">Accommodations</a></li>
            <li><a href="#7">Incl/Excl</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
        </div>
    </div><!-- /.container-fluid -->
    </nav>
    <!-- Header-End -->
    </header>


<!-- Package -->

    <section id="0" class="main_block link_page_section">

    <div class="container">

        <div class="sec_heding">

        <h2>Package Details</h2>

        </div>

        <div class="row">

            <div class="col-md-6 col-xs-12">

                <ul class="pack_info">
                    <li><span>DESTINATION </span>:  <?= $sq_dest1['dest_name']; ?> </li>
                    <li><span>PACKAGE NAME </span>:  <?= $sq_tours_package['package_name'].' ('.$sq_tours_package['package_code'].')'; ?> </li>
                </ul>

            </div>

            <div class="col-md-6 col-xs-12">

                <ul class="pack_info">
                    <li><span>TOUR TYPE </span>:  <?= $sq_tours_package['tour_type'] ?></li>
                    <li><span>DURATION </span>:  <?= $sq_tours_package['total_nights'].'N / '.$sq_tours_package['total_days'].'D' ?></li>
                </ul>

            </div>

        </div>

    </div>

    </div>

    </section>



<!-- Costing -->

    <section id="1" class="main_block link_page_section">

    <div class="container">

      <div class="sec_heding">

        <h2>Costing</h2>

      </div>

      <div class="row">

        <div class="col-md-12">

          <div class="adolence_info">

            <ul class="main_block">
            <?php
            $package_type_arr = array();
            $package_cost_arr = array();
            $cwb_cost_arr = array();
            $cwob_cost_arr = array();
            $extra_cost_arr = array();
            $infant_cost_arr = array();
            $package_type = 'On Request';
            $tomorrow = date("Y-m-d", strtotime("+1 day"));
            $sq_tariff = mysqlQuery("select * from custom_package_tariff where (`from_date` <= '$tomorrow' and `to_date` >= '$tomorrow') and (`min_pax` <= '1' and `max_pax` >= '1') and `package_id`='$package_id'");
            $to_currency_id = $currency;
            $h_currency_id = $sq_tours_package['currency_id'];
            while($row_tariff = mysqli_fetch_assoc($sq_tariff)){
              
              $total_cost = floatval($row_tariff['cadult']);
              $ccwb = floatval($row_tariff['ccwb']);
              $ccwob = floatval($row_tariff['ccwob']);
              $cinfant = floatval($row_tariff['cinfant']);
              $cextra = floatval($row_tariff['cextra']);
              $package_type = $row_tariff['hotel_type'];
              $adult_cost = currency_conversion($h_currency_id,$to_currency_id,$total_cost).' (PP)';
              $cwb_cost = currency_conversion($h_currency_id,$to_currency_id,$ccwb).' (PP)';
              $cwob_cost = currency_conversion($h_currency_id,$to_currency_id,$ccwob).' (PP)';
              $infant_cost = currency_conversion($h_currency_id,$to_currency_id,$cinfant).' (PP)';
              $extra_cost = currency_conversion($h_currency_id,$to_currency_id,$cextra).' (PP)';
              array_push($package_type_arr,$row_tariff['hotel_type']);
              array_push($package_cost_arr,$adult_cost);
              array_push($cwb_cost_arr,$cwb_cost);
              array_push($cwob_cost_arr,$cwob_cost);
              array_push($extra_cost_arr,$extra_cost);
              array_push($infant_cost_arr,$infant_cost);
            }
            if(sizeof($package_type_arr) == 0){ ?>
              <div class="row">
                <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Package Type : </span><?= 'On Request' ?></li>
                <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Quotation Cost : </span><?= 'On Request' ?></li>
              </div>
            <?php }
            for($i = 0;$i<sizeof($package_type_arr);$i++){
            ?>
            <div class="row">
              <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Package Type : </span><?=$package_type_arr[$i] ?></li>
              <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Adult Cost : </span><?=$package_cost_arr[$i] ?></li>
              <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>CWB Cost : </span><?=$cwb_cost_arr[$i] ?></li>
              <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>CWOB Cost : </span><?=$cwob_cost_arr[$i] ?></li>
              <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Extra Bed : </span><?=$extra_cost_arr[$i] ?></li>
              <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Infant Cost : </span><?=$infant_cost_arr[$i] ?></li>
            </div><hr/>
            <?php } ?>
            </ul>

          </div>

        </div>

      </div>

    </div>

  </section>



<!-- Transport -->

<?php 

$sq_trans_count = mysqli_num_rows(mysqlQuery("select * from custom_package_transport where package_id = '$package_id'"));
if($sq_trans_count>0){

?>

  <section id="2" class="main_block link_page_section">

    <div class="container">

      <div class="sec_heding">

        <h2>Transport</h2>

      </div>

      <div class="row">

        <div class="col-md-12">

         <div class="table-responsive">

          <table class="table table-bordered no-marg" id="tbl_emp_list">

            <thead>
              <tr class="table-heading-row">
                <th>VEHICLE</th>
                <th>PICKUP LOCATION</th>
                <th>DROP LOCATION</th>
              </tr>
            </thead>
            <tbody>   

            <?php
            $count = 0;
            $sq_hotel = mysqlQuery("select * from custom_package_transport where package_id = '$package_id'");
            while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
              
              $transport_name = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id='$row_hotel[vehicle_name]'"));
              // Pickup
              if($row_hotel['pickup_type'] == 'city'){
                $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[pickup]'"));
                $pickup = $row['city_name'];
              }
              else if($row_hotel['pickup_type'] == 'hotel'){
                $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[pickup]'"));
                $pickup = $row['hotel_name'];
              }
              else{
                $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[pickup]'"));
                $airport_nam = clean($row['airport_name']);
                $airport_code = clean($row['airport_code']);
                $pickup = $airport_nam." (".$airport_code.")";
              }
              //Drop-off
              if($row_hotel['drop_type'] == 'city'){
                $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
                $drop = $row['city_name'];
              }
              else if($row_hotel['drop_type'] == 'hotel'){
                $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
                $drop = $row['hotel_name'];
              }
              else{
                $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
                $airport_nam = clean($row['airport_name']);
                $airport_code = clean($row['airport_code']);
                $drop = $airport_nam." (".$airport_code.")";
              }
              ?>
              <tr>
                <td><?= $transport_name['vehicle_name'].$similar_text ?></td>
                <td><?= $pickup ?></td>
                <td><?= $drop ?></td>
              </tr>
              <?php } ?>

            </tbody>

          </table>

         </div>

       </div>

      </div>

    </div>

  </section>

<?php } ?>



<!-- Tour Itinenary -->

  <section id="3" class="main_block link_page_section">

    <div class="container">
      <div class="sec_heding">
        <h2>Tour Itinerary</h2>
      </div>
      <div class="row mg_bt_30">
        <div class="col-md-12">
          <div class="adolence_info mg_tp_15">
            <ul class="main_block">
              <li class="col-md-12 col-sm-4 col-xs-12 mg_bt_10_xs"><img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive">
                &nbsp;Destination Guide Video :&nbsp;<a href="<?=$sq_dest['link']?>" class="no-marg itinerary-link" target="_blank"><?=$sq_dest['link']?> </a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 Itinenary_detail app_accordion">
            <div class="panel-group main_block" id="pkg_accordion" role="tablist" aria-multiselectable="true">
            <?php
            $count = 0;
            $sq_pckg_a = mysqlQuery("select * from custom_package_program where package_id = '$package_id'");
            while($row_itinarary = mysqli_fetch_assoc($sq_pckg_a)){

                $sq_day_image = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_images where quotation_id='$row_itinarary[quotation_id]' and package_id='$sq_quotation[package_id]'"));
                $daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
                $count++; ?>
                <div class="panel panel-default main_block">
                <div class="panel-heading main_block" role="tab" id="heading<?= $count; ?>">
                    <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#pkg_accordion" href="#collapse<?= $count; ?>" aria-expanded="false" aria-controls="collapse<?= $count; ?>">
                        <div class="col-md-1"><span><em>Day :</em> <?= $count; ?></span></div>
                        <div class="col-md-4" style="line-height: 26px; padding:7px 15px 7px 15px;"><span><em>Attraction :</em> <?= $row_itinarary['attraction']; ?></span></div>
                        <div class="col-md-4"><span><em>Overnight stay :</em> <?= $row_itinarary['stay']; ?></span></div>
                        <div class="col-md-3"><span><em>Meal Plan :</em> <?= $row_itinarary['meal_plan']; ?></span></div>
                    </div>
                </div>
                <div id="collapse<?= $count; ?>" class="panel-collapse <?= $in; ?> collapse main_block" role="tabpanel" aria-labelledby="heading<?= $count; ?>">

                    <div class="panel-body">
                        <pre class="real_text"><?= $row_itinarary['day_wise_program']; ?></pre>
                    </div>
                </div>
                </div>
            <?php  $in = ''; } ?>
            </div>
        </div>
    </div>

<!-- <div id="div_quotation_form1"></div> -->

  <!-- Accomodations -->

<?php
  $sq_hotel_count = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id = '$package_id'"));
  if($sq_hotel_count>0){ ?>

  <section id="4" class="main_block link_page_section">

    <div class="container">

      <div class="sec_heding">

        <h2>accommodations</h2>

      </div>

      <div class="row">

        <div class="col-md-10 col-md-offset-1 col-sm-12">

        <?php 
            $sq_hotel = mysqlQuery("select * from custom_package_hotels where package_id = '$package_id'");
            while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

            $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
            $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_name]'"));
            $sq_hotel_count = mysqli_num_rows(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id = '$row_hotel[hotel_name]'"));
            if($sq_hotel_count == '0'){
                $newUrl = BASE_URL.'images/dummy-image.jpg';
            }
            else{
              $sq_hotel_image1 = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id = '$row_hotel[hotel_name]'"));
              $image = $sq_hotel_image1['hotel_pic_url']; 
              $newUrl = preg_replace('/(\/+)/','/',$image);
              $newUrl = explode('uploads', $newUrl);
              $newUrl = BASE_URL.'uploads'.$newUrl[1];
            }
        ?>

          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_20">

            <div class="single_accomodation_hotel mg_bt_10_xs">

              <div class="acco_hotel_image" style="display: block;cursor: pointer;" onclick="display_gallery('<?php echo $row_hotel['hotel_name']; ?>')">

                <img src="<?php echo $newUrl; ?>" style="width: 100%;height: 135px;" class="img-responsive">

              </div>

              <div class="acco_hotel_detail">

                <ul class="text-center">

                  <li class="acco-_hotel_name"><?= $hotel_name['hotel_name'].$similar_text; ?></li>

                  <li class="acco-_hotel_star"><?= $row_hotel['hotel_type']; ?></li>

                  <li class="acco-_hotel_city"><span>City : </span><?= $city_name['city_name']; ?></li>
                  <li class="acco-_hotel_city"><span>Total Nights : </span><?= $row_hotel['total_days']; ?></li>


                </ul>

              </div>

              <div class="acco_hotel_btn text-center mg_tp_20">

                <button type="button" data-toggle="modal" onclick="display_gallery('<?php echo $row_hotel['hotel_name']; ?>')" title="View Gallery">Hotel Gallery</button>

              </div>

            </div>

          </div>

          <?php } ?>

        </div>

      </div>

    </div>

  </section>

  <?php }

?>

<div id="div_quotation_form"></div>

  <!-- Inclusion --><!-- Exclusion -->

  <section id="7" class="main_block link_page_section">

    <div class="container">

      <div class="row">

        <div class="col-md-12 in_ex_tab">

          <!-- Nav tabs -->
            <ul class="nav nav-tabs responsive" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Inclusion</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Exclusion</a></li>
              <li role="presentation"><a href="#terms" aria-controls="terms" role="tab" data-toggle="tab">Terms & conditions</a></li>
              <li role="presentation"><a href="#note" aria-controls="note" role="tab" data-toggle="tab">Note</a></li>
            </ul>

            <!-- Tab panes -->

            <div class="tab-content responsive">

              <div role="tabpanel" class="tab-pane active" id="home">
                <pre><?php echo $sq_tours_package['inclusions']; ?></pre>
              </div>

              <div role="tabpanel" class="tab-pane" id="profile">
                <pre><?php echo $sq_tours_package['exclusions']; ?></pre>
              </div>
              
              <div role="tabpanel" class="tab-pane" id="terms">
                <pre><?php
                  $sq_query = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Package Quotation' and dest_id='$sq_tours_package[dest_id]' and active_flag ='Active'")); 
                  echo $sq_query['terms_and_conditions'] ?></pre>
              </div>
              <div role="tabpanel" class="tab-pane" id="profile">
                <pre><?php echo $sq_quotation['exclusions']; ?></pre>
              </div>
              <div role="tabpanel" class="tab-pane" id="note">
                <pre><?php echo $sq_tours_package['note']; ?></pre>
              </div>

            </div>



      </div>

      </div>

    </div>

  </section>



<!-- Feedback -->
 <?php
 $quotation_id = base64_encode($quotation_id);
 ?>
  <!-- <section id="8" class="main_block link_page_section"> -->

    <!-- <div class="container">

      <div class="feedback_action text-center">

        <div class="row">

            <div class="col-sm-4 col-xs-12">

              <div class="feedback_btn succes mg_bt_20">

                <button value="Interested in Booking"><a href="template_mail/quotation_email_interested.php?quotation_id=<?php echo $quotation_id; ?>" style="color:#ffffff;text-decoration:none">I'm Interested</a>

              </div>

            </div>

            <div class="col-sm-4 col-xs-12">

              <div class="feedback_btn danger mg_bt_20">

               <button value="Interested in Booking"><a href = "template_mail/quotation_email_not_interested.php?quotation_id=<?php echo $quotation_id; ?>" style="color:#ffffff;text-decoration:none">Not Interested</a>

              </div>

            </div>

            <div class="col-sm-4 col-xs-12">

              <div class="feedback_btn info mg_bt_20">

                <button type="button" data-toggle="modal" data-target="#feedback_suggestion" title="Write Suggestion">Give Suggestion</button>

              </div>

            </div>

        </div>

      </div>

    </div> -->

  <!-- </section> -->



<!-- Footer -->
    <footer class="main_block">

        <div class="footer_part">

        <div class="container">

            <div class="row">

            <div class="col-md-8 col-sm-6 col-xs-12 mg_bt_10_sm_xs">

                <div class="footer_company_cont">

                <p><i class="fa fa-map-marker"></i> <?php echo $app_address; ?></p>

                </div>

            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">

                <div class="footer_company_cont text-center text_left_sm_xs">

                <p><i class="fa fa-phone"></i> <?php echo $app_contact_no; ?></p>

                </div>

            </div>

            </div>

        </div>

        </div>

    </footer>


<div class="modal fade" id="feedback_suggestion" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">

            <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title" id="myModalLabel">Suggestion</h4>

            </div>

            <div class="modal-body">

            <textarea class="form-control" placeholder="*Write Suggestion" id="suggestion" rows="5"></textarea>

            <div class="row mg_tp_20 text-center">

                <button class="btn btn-success" id="btn_quotation_send" onclick="multiple_suggestion_mail('<?php echo $quotation_id; ?>');"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</a></button>

            </div>

            </div>

        </div>

        </div>

    </div>





<!-- Footer-End-->



    <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>

    <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/responsive-tabs.js"></script>

    <script type="text/javascript">
        (function($) {
            fakewaffle.responsiveTabs(['xs', 'sm']);
        })(jQuery);
    </script>



    <script type="text/javascript">



    function multiple_suggestion_mail(quotation_id){

        var base_url = $('#base_url').val();

        var suggestion = $('#suggestion').val();

        if(suggestion == ''){
        alert('Enter suggestion'); return false;
        }

        $('#btn_quotation_send').button('loading'); 

        $.ajax({

            type:'post',

            url: 'template_mail/suggestion_email_send.php',

            data:{ quotation_id : quotation_id , suggestion : suggestion},

            success: function(message){

                alert(message); 

                $('#feedback_suggestion').modal('hide');  

                $('#btn_quotation_send').button('reset');             

        }  

        }); 

    }

    </script>

    <!-- sticky-header -->

    <script type="text/javascript">

        $(document).ready(function(){
        $(window).bind('scroll', function() {
            var navHeight = 159; // custom nav height
            ($(window).scrollTop() > navHeight) ? $('div.nav').addClass('goToTop') : $('div.nav').removeClass('goToTop');
        });
        });
        // Smooth-scroll -->
        $(document).on('click', '#menu-center a', function(event){

            event.preventDefault();



            $('html, body').animate({

                scrollTop: $( $.attr(this, 'href') ).offset().top

            }, 500);

        });



    //Active-menu -->
    $("#menu-center a").click(function(){

        $(this).parent().siblings().removeClass('active');

        $(this).parent().addClass('active');

    });

    //Accordion -->

    $('#myCollapsible').collapse({

        toggle: false

    })



    function display_gallery(hotel_name)
    {

        $.post('../package_tour/quotation/display_hotel_gallery.php', { hotel_name : hotel_name}, function(data){
        $('#div_quotation_form').html(data);
        });

    }
    </script>



    </body>
</html>
<?php
$date = date('d-m-Y H:i');
$content ='

    <tr>
      <td>
        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
        <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_enq['name'].'</td></tr>
        <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry Id</td>   <td style="text-align:left;border: 1px solid #888888;" >'. get_enquiry_id($enquiry_id,$year).'</td></tr>
        <tr><td style="text-align:left;border: 1px solid #888888;">On Date&Time</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $date.'</td></tr>
        </table>
      </td>
    </tr>';

$subject = 'Customer viewed package! (Package Name : '.$sq_tours_package['package_name'].' ('.$sq_tours_package['total_nights'].'N / '.$sq_tours_package['total_days'].'D)';
$email_id = ($sq_emp_info['email_id'] == '') ? $app_email_id : $sq_emp_info['email_id'];

$model->app_email_send('121','Admin',$email_id, $content, $subject);
?>