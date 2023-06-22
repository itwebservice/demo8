<?php

include '../../config.php';

include BASE_URL.'model/model.php';

include '../../layouts/header.php';


$_SESSION['page_type'] = 'activities';
$currency = $_SESSION['session_currency_id'];

$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));

$to_currency_rate = $sq_to['currency_rate'];



$b2b_agent_code = $_SESSION['b2b_agent_code'];

$activity_array = json_decode($_SESSION['activity_array']);

$checkDate = date('d M Y', strtotime($activity_array[0]->checkDate));

$date1 = date("Y-m-d", strtotime($activity_array[0]->checkDate));

$pax = $activity_array[0]->adult+$activity_array[0]->child+$activity_array[0]->infant;

$city_id = $activity_array[0]->activity_city_id;

$activities_id = $activity_array[0]->activities_id;

$day = date("l", strtotime($date1));

if($city_id=='' && $hotel_id==''){

  $query = "select * from excursion_master_tariff where 1 and active_flag='Active'";

}

//City Search

else if($city_id!=''){

    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id='$city_id'"));

    $query = "select * from excursion_master_tariff where city_id='$city_id'";

}

//Hotel Search

if($activities_id!=''){

    $sq_exc = mysqli_fetch_assoc(mysqlQuery("select entry_id,excursion_name from excursion_master_tariff where entry_id='$activities_id'"));

    $query = "select * from excursion_master_tariff where entry_id='$activities_id'";

}

?>

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect">

  <div class="container">

    <div class="row">

      <div class="col-md-7 col-12">



        <!-- *** Search Head **** -->

        <div class="searchHeading">

          <span class="pageTitle">Activity</span>



          <div class="clearfix">

            <?php if($city_id != ''){ ?>

            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-pin-alt"></i>

                City: <strong><?= $sq_city['city_name'] ?></strong>

              </span>

            </div>

            <?php } ?>

            <?php if($activities_id != ''){ ?>

            <div class="sortSection">

              <span class="sortTitle st-search" style="padding-left:0px!important;">

                <!-- <i class="icon it itours-pin-alt"></i> -->

                Activity: <strong><?= $sq_exc['excursion_name'] ?></strong>

              </span>

            </div>

            <?php } ?>



          </div>



          <div class="clearfix">



            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-timetable"></i>

                Date: <strong><?= $checkDate ?></strong>

              </span>

            </div>



            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-person"></i>

                <?php

                $adult_label = 'Adult(s)';

                $child_label = 'Child(ren)';

                $infant_label = 'Infant(s)';

                echo $activity_array[0]->adult.' '.$adult_label; ?> , <?php echo $activity_array[0]->child.' '.$child_label; ?>, <?php echo $activity_array[0]->infant.' '.$infant_label; ?> 

              </span>

            </div>



          </div>



          <div class="clearfix">

            

            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-search"></i>

                <span>Showing <span class="results_count"></span></span>

              </span>

            </div>



          </div>

        </div>

        <!-- *** Search Head End **** -->



      </div>



      <div class="col-md-5 col-12 c-breadcrumbs">

        <ul>

          <li>

            <a href="<?= BASE_URL_B2C ?>">Home</a>

          </li>

          <li class="st-active">

            <a href="#">Activity Search Result</a>

          </li>

        </ul>

      </div>



    </div>

  </div>

</div>

<!-- ********** Component :: Page Title End ********** -->





<!-- ********** Component :: Activity Listing  ********** -->

<div class="c-containerDark">

  <div class="container">

      <!-- ********** Component :: Modify Filter  ********** -->

      <div class="row c-modifyFilter">

          <div class="col">

            <!-- Modified Search Filter -->

            <div class="accordion c-accordion" id="modifySearch_filter">

            <div class="card">



              <div class="card-header" id="headingThree">

                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsModifySearch_filter" aria-expanded="false" aria-controls="jsModifySearch_filter">

                Modify Search >> <span class="results_count"></span><?php echo ' available for '.$pax.' Pax'; ?>

                </button>

                <input type="hidden" value="<?= $pax ?>" id="total_pax"/>

              </div>

              <div id="jsModifySearch_filter" class="collapse" aria-labelledby="jsModifySearch_filter" data-parent="#modifySearch_filter">

                <div class="card-body">

                    <form id="frm_activities_search">

                        <div class="row">

                            <input type='hidden' id='page_type' value='search_page' name='search_page'/>

                            <!-- *** City Name *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Enter City</label>

                                <div class="c-select2DD">

                                <select id='activities_city_filter' class="full-width js-roomCount" onchange="activities_names_load(this.id);">

                                    <?php if($city_id!=''){?>

                                    <option value="<?php echo $sq_city['city_id'] ?>" selected="selected"><?php echo $sq_city['city_name'] ?></option>

                                    <?php  } ?>

                                </select>

                                </div>

                            </div>

                            </div>

                            <!-- *** City Name End *** -->

                            <!-- *** Activities Name *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Enter Activity</label>

                                <div class="c-select2DD">

                                <select id='activities_name_filter' class="full-width js-roomCount">

                                    <?php if($activities_id != ''){ ?>

                                    <option value="<?php echo $sq_exc['entry_id'] ?>"><?php echo $sq_exc['excursion_name'] ?></option>

                                    <option value=''>Activity Name</option>

                                    <?php }

                                    else{

                                        if($city_id!=''){

                                        $querys = "select entry_id,excursion_name from excursion_master_tariff where entry_id='$activities_id'"; }

                                        else{

                                        $querys = "select entry_id, excursion_name from excursion_master_tariff where 1";

                                        } ?>

                                        <option value=''>Activity Name</option>

                                        <?php

                                        $sq_act = mysqlQuery($query);

                                        while($row_act = mysqli_fetch_assoc($sq_act)){

                                        ?>

                                        <option value="<?php echo $row_act['entry_id'] ?>"><?php echo $row_act['excursion_name'] ?></option>

                                        <?php }

                                    } ?>

                                </select>

                                </div>

                            </div>

                            </div>

                            <!-- *** Activities Name End *** -->

                            

                            <!-- *** Date *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <div class="form-group">

                                <label>*Select Date</label>

                                <div class="datepicker-wrap">

                                <input type="text" name="checkDate" class="input-text full-width" placeholder="mm/dd/yy" id="checkDate" value="<?= $activity_array[0]->checkDate ?>" required/>

                                </div>

                            </div>

                            </div>

                            <!-- *** Date End *** -->

                            

                            <!-- *** Adult *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <div class="form-group">

                                <label>*Adults</label>

                                <div class="selector">

                                <select name="adult" id='adult' class="full-width" required>

                                    <option value='<?= $activity_array[0]->adult ?>'><?= $activity_array[0]->adult ?></option>

                                    <?php

                                    for($m=0;$m<=20;$m++){

                                        if($m != $activity_array[0]->adult){

                                    ?>

                                        <option value="<?= $m ?>"><?= $m ?></option>

                                    <?php } } ?>

                                </select>

                                </div>

                            </div>

                            </div>

                            <!-- *** Adult End *** -->

                            <!-- *** Child *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Children(2-12 Yrs)</label>

                                <div class="selector">

                                <select name="child" id='child' class="full-width">

                                    <option value='<?= $activity_array[0]->child ?>'><?= $activity_array[0]->child ?></option>

                                    <?php

                                    for($m=0;$m<=20;$m++){

                                        if($m != $activity_array[0]->child){

                                    ?>

                                        <option value="<?= $m ?>"><?= $m ?></option>

                                    <?php } } ?>

                                </select>

                                </div>

                            </div>

                            </div>

                            <!-- *** Child End *** -->

                            <!-- *** Infant *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Infants(0-2 Yrs)</label>

                                <div class="selector">

                                <select name="infant" id='infant' class="full-width">

                                    <option value='<?= $activity_array[0]->infant ?>'><?= $activity_array[0]->infant ?></option>

                                    <?php

                                    for($m=0;$m<=20;$m++){

                                        if($m != $activity_array[0]->infant){

                                    ?>

                                        <option value="<?= $m ?>"><?= $m ?></option>

                                    <?php } } ?>

                                </select>

                                </div>

                            </div>

                            </div>

                            <!-- *** Infant End *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                <button class="c-button lg colGrn m26-top">

                                    <i class="icon itours-search"></i> SEARCH NOW

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

              </div>

            </div>

            </div>

            <!-- Modified Search Filter End -->

    </div>

    </div>



    <div class="row">



      <!-- ***** Activity Listing ***** -->

        <?php

        $adult_count = $activity_array[0]->adult;

        $child_count = $activity_array[0]->child;

        $infant_count = $activity_array[0]->infant;

        $activity_result_array = array();

        

        $sq_query = mysqlQuery($query);

        while(($row_query  = mysqli_fetch_assoc($sq_query))){

          

          $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_query[city_id]'"));



          if($row_query['off_days'] != ''){

            $off_days = $row_query['off_days'];

            $off_day = (strpos($off_days, $day) === false) ? true : false;

          }else{

            $off_day = true;

          }

          if($off_day){

            $transfer_options_array = array();

            $exc_id = $row_query['entry_id'];

            $currency_id = $row_query['currency_code'];

            $timing_slots = json_decode($row_query['timing_slots']);



            $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency_id'"));

            $from_currency_rate = $sq_from['currency_rate'];



            //Single Hotel Image

            $sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_images where exc_id='$exc_id'"));

            if($sq_singleImage['image_url']!=''){

                $image = $sq_singleImage['image_url'];

                $newUrl1 = preg_replace('/(\/+)/','/',$image);

                $newUrl1 = explode('uploads', $newUrl1);

                $newUrl = BASE_URL.'uploads'.$newUrl1[1];

            }else{

                $newUrl = BASE_URL_B2C.'images/activity_default.png';

            }



              array_push($activity_result_array,array(

                  "exc_id"=>(int)($exc_id),

                  "excursion_name"=>$row_query['excursion_name'],

                  "city_name"=>$sq_city['city_name'],

                  "image"=>$newUrl,

                  "currency_id"=>(int)($currency_id),

                  "duration"=>$row_query['duration'],

                  "departure_point"=>$row_query['departure_point'],

                  "rep_time" =>$row_query['rep_time'],

                  "description"=>$row_query['description'],

                  'note'=> $row_query['note'],

                  'inclusions'=>$row_query['inclusions'],

                  'exclusions'=> $row_query['exclusions'],

                  'terms_condition'=>$row_query['terms_condition'],

                  'useful_info'=>$row_query['useful_info'],

                  'booking_policy'=>$row_query['booking_policy'],

                  'canc_policy'=>$row_query['canc_policy'],

                  'adult_count'=>$adult_count,

                  'child_count'=>$child_count,

                  'infant_count'=>$infant_count,

                  'actDate'=>$date1,

                  'timing_slots'=>$row_query['timing_slots']

              ));

          }

        }

        ?>

        <input type='hidden' value='<?= json_encode($activity_result_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='activity_result_array' name='activity_result_array'/>

      

        <div class="col-md-12 col-sm-12">

            <div id="activity_result_block">



            </div>

        </div>

      <!-- ***** Activity Listing End ***** -->

    </div>

  </div>

</div>

<!-- ********** Component :: Activity Listing End ********** -->

<?php include '../../layouts/footer.php'; ?>

<script type="text/javascript" src="js/index.js"></script>

<script type="text/javascript" src="../../js/jquery.range.min.js"></script>

<script type="text/javascript" src="../../js/pagination.min.js"></script>

<script>

  $('#checkDate').datetimepicker({ timepicker:false,format:'m/d/Y',minDate:new Date() });

  

// Get Hotel results data

function get_price_filter_data(activity_result_array,type,fromRange_cost,toRange_cost){

  var base_url = $('#base_url').val();

  var selected_value = document.getElementById(activity_result_array).value;

  var JSONItems = JSON.parse(selected_value);

  get_price_filter_data_result(JSONItems);

}

//Display Hotel results data 

function get_price_filter_data_result(final_arr){

  var base_url = $('#base_url').val();

  $.post(base_url+'view/activities/activity_results.php', { final_arr: final_arr }, function (data) {

    $('#activity_result_block').html(data);

	});

}

get_price_filter_data('activity_result_array','3','0','0');

</script>

