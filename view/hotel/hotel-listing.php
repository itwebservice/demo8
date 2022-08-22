<?php

include '../../config.php';

include BASE_URL.'model/model.php';

include '../../layouts/header.php';



$hotel_array = json_decode($_SESSION['hotel_array']);

$city_id = ($hotel_array[0]->city_id);

$hotel_id = ($hotel_array[0]->hotel_id);

$check_indate = $hotel_array[0]->check_indate;

$check_outdate = $hotel_array[0]->check_outdate;

$star_category_arr = $hotel_array[0]->star_category_arr;

$total_rooms = $hotel_array[0]->total_rooms;



$check_indate1 = date('d M Y', strtotime($check_indate));

$check_outdate1 = date('d M Y', strtotime($check_outdate));

$star_category_arr = ($star_category_arr!='')?$star_category_arr:[];

$star_category_arr = implode(',',$star_category_arr);

if($city_id=='' && $hotel_id==''){

  $query = "select * from hotel_master where 1 and active_flag='Active'";

}

//City Search

else if($city_id!=''){

  $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$city_id'"));

  $city_name = $sq_city['city_name'];

  $query = "select * from hotel_master where city_id='$city_id' and active_flag='Active'";

}

//Hotel Search

if($hotel_id!=''){

  $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$hotel_id' and active_flag='Active'"));

  $hotel_name = $sq_hotel['hotel_name'];

  $query = "select * from hotel_master where hotel_id='$hotel_id' and active_flag='Active'";

}

//Star Category filter

if($star_category_arr!=''){

  $query .= " and rating_star in($star_category_arr) ";

}

//Page Title

if($hotel_id!=''){

  $page_title = 'Results for '.$hotel_name;

}else if($city_id!=''){

  $page_title = 'Hotels in '.$city_name;

}else{

  $page_title = 'All Hotels..';

}

//Array of Check-in and Check-out date

$checkDate_array = array();

$check_in = strtotime($check_indate);

$check_out = strtotime($check_outdate);

for ($i_date=$check_in; $i_date<=$check_out; $i_date+=86400) {

    array_push($checkDate_array,date("Y-m-d", $i_date));  

}

?>

<input type='hidden' id='check_indate' value='<?=$check_indate?>'/>

<input type='hidden' id='check_outdate' value='<?=$check_outdate?>'/>

      <!-- ********** Component :: Page Title ********** -->

      <div class="c-pageTitleSect">

        <div class="container">

          <div class="row">

            <div class="col-md-7 col-12">



              <!-- *** Search Head **** -->

              <div class="searchHeading">

                <span class="pageTitle"><?= $page_title ?></span>



                <div class="clearfix">



                  <div class="sortSection">

                    <span class="sortTitle st-search">

                      <i class="icon it itours-timetable"></i>

                      Check In: <strong><?= $check_indate1 ?></strong>

                    </span>

                  </div>



                  <div class="sortSection">

                    <span class="sortTitle st-search">

                      <i class="icon it itours-timetable"></i>

                      Check Out: <strong><?= $check_outdate1 ?></strong>

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

                  <a href="javascript:void(0)">Hotel Search Result</a>

                </li>

              </ul>

            </div>



          </div>

        </div>

      </div>

      <!-- ********** Component :: Page Title End ********** -->



      <!-- ********** Component :: Hotel Listing  ********** -->

      <div class="c-containerDark">

        <div class="container">

           <!-- ********** Component :: Modify Filter  ********** -->

            <div class="row c-modifyFilter">

                <div class="col">

                  <!-- Modified Search Filter -->

                  <div class="accordion c-accordion ts-hotel-listing-accordion" id="modifySearch_filter">

                  <div class="card">



                    <div class="card-header" id="headingThree">

                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsModifySearch_filter" aria-expanded="false" aria-controls="jsModifySearch_filter">

                      Modify Search >>

                      </button>

                    </div>

                    <div id="jsModifySearch_filter" class="collapse" aria-labelledby="jsModifySearch_filter" data-parent="#modifySearch_filter">

                      <div class="card-body">

                        <form id="frm_hotel_search">

                        <input type='hidden' id='page_type' value='hotel_listing_page' name='hotel_listing_page'/>

                          <div class="row">

                                <!-- *** City Name *** -->

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                  <div class="form-group">

                                    <label>Enter City</label>

                                    <div class="c-select2DD">

                                      <select id='hotel_city_filter' class="full-width js-roomCount" onchange="hotel_names_load(this.id);">

                                      <?php if($city_id!=''){

                                        $sq_city_name = mysqli_fetch_assoc(mysqlQuery("select city_id, city_name from city_master where city_id='$city_id'"));?>

                                        <option value="<?php echo $sq_city_name['city_id'] ?>"><?php echo $sq_city_name['city_name'] ?></option>

                                      <?php  } ?>

                                      </select>

                                    </div>

                                  </div>

                                </div>

                                <!-- *** City Name End *** -->

                                <!-- *** Hotel Name *** -->

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                  <div class="form-group">

                                    <label>Enter Hotel Name</label>

                                    <div class="c-select2DD">

                                      <select id='hotel_name_filter' class="full-width js-roomCount">

                                      <?php if($hotel_id !=''){

                                        $sq_filter = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$hotel_id'")); ?>

                                        <option value="<?php echo $sq_filter['hotel_id'] ?>"><?php echo $sq_filter['hotel_name'] ?></option>

                                        <option value="">Hotel Name</option>

                                        <?php }

                                        else{

                                          if($city_id!=''){

                                            $querys = "select hotel_id, hotel_name from hotel_master where city_id='$city_id' and active_flag='Active'"; }

                                          else{

                                            $querys = "select hotel_id, hotel_name from hotel_master where 1 and active_flag='Active'"; } ?>

                                          <option value="">Hotel Name</option>

                                          <?php

                                          $sq_hotels = mysqlQuery($querys);

                                          while($row_hotels = mysqli_fetch_assoc($sq_hotels)){ ?>

                                          <option value="<?php echo $row_hotels['hotel_id'] ?>"><?php echo $row_hotels['hotel_name'] ?></option>

                                          <?php }

                                        }  ?>

                                      </select>

                                    </div>

                                  </div>

                                </div>

                                <!-- *** Hotel Name End *** -->

                                

                                <!-- *** Check in Date *** -->

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                  <div class="form-group">

                                    <label>*Check In</label>

                                    <div class="datepicker-wrap">

                                      <input type="text" name="date_from" class="input-text full-width" value="<?= $check_indate ?>" placeholder="mm/dd/yy" id="checkInDate" onchange='get_to_date("checkInDate","checkOutDate")' required/>

                                    </div>

                                  </div>

                                </div>

                                <!-- *** Check in Date End *** -->

                                

                                <!-- *** Check Out Date *** -->

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                  <div class="form-group">

                                    <label>*Check Out

                                      <span class="nytCount" id='total_stay'></span>

                                    </label>

                                    <div class="datepicker-wrap">

                                      <input type="text" name="date_from" class="input-text full-width" value="<?= $check_outdate ?>" placeholder="mm/dd/yy" id="checkOutDate" onchange='total_nights_reflect();' required/>

                                    </div>

                                  </div>

                                </div>

                                <!-- *** Check Out Date End *** -->

                                <!-- *** Add Rooms *** -->

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                  <div class="form-group">

                                    <label>Total Rooms</label>

                                      <input type="number" name="total_rooms" class="input-text full-width" placeholder="Total Rooms" id="total_rooms" value="<?= $total_rooms ?>"/>

                                  </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                  <div class="form-group clearfix">

                                    <label>Hotel Star Catagory</label>

                                      <div class="form-check form-check-inline c-checkGroup">

                                        <?php $checked_status1 = (strpos($star_category_arr, "1 Star"))?'checked':'';?>

                                      <input class="form-check-input" type="checkbox" id="c1" value="1" name='star_category' <?= $checked_status1 ?>>

                                      <label class="form-check-label" role="button" for="c1">

                                        1 <i class="icon-star"></i>

                                      </label>

                                    </div>

                                      <div class="form-check form-check-inline c-checkGroup">

                                        <?php

                                        $checked_status2 =(strpos($star_category_arr, "2 Star"))?'checked':'';?>

                                      <input class="form-check-input" type="checkbox" id="c2" value="2" name='star_category' <?= $checked_status2 ?>>

                                      <label class="form-check-label" role="button" for="c2">

                                        2 <i class="icon-star"></i>

                                      </label>

                                    </div>

                                      <div class="form-check form-check-inline c-checkGroup">

                                        <?php

                                        $checked_status3 =(strpos($star_category_arr, "3 Star"))?'checked':'';?>

                                      <input class="form-check-input" type="checkbox" id="c3" value="3" name='star_category' <?= $checked_status3 ?>>

                                      <label class="form-check-label" role="button" for="c3">

                                        3<i class="icon-star"></i>

                                      </label>

                                    </div>

                                      <div class="form-check form-check-inline c-checkGroup">

                                        <?php

                                        $checked_status4 =(strpos($star_category_arr, "4 Star"))?'checked':'';?>

                                      <input class="form-check-input" type="checkbox" id="c4" value="4" name='star_category' <?= $checked_status4 ?>>

                                      <label class="form-check-label" role="button" for="c4">

                                        4 <i class="icon-star"></i>

                                      </label>

                                    </div>

                                      <div class="form-check form-check-inline c-checkGroup">

                                        <?php

                                        $checked_status5 = (strpos($star_category_arr, "5 Star"))?'checked':'';?>

                                      <input class="form-check-input" type="checkbox" id="c5" value="5" name='star_category' <?= $checked_status5 ?>>

                                      <label class="form-check-label" role="button" for="c5">

                                        5<i class="icon-star"></i>

                                      </label>

                                    </div>

                                  </div>

                                </div>



                            <!-- *** Search Rooms *** -->

                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <button class="c-button lg colGrn m26-top">

                                <i class="icon itours-search"></i> SEARCH NOW

                            </button>

                            </div>

                            <!-- *** Search Rooms End *** -->

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

            <!-- ***** Hotel Listing ***** -->

            <div class="col-md-12 col-sm-12">

            <?php

            $hotel_results_array = array();

            $array = array();

            $sq_query = mysqlQuery($query);

            while(($row_query  = mysqli_fetch_assoc($sq_query))){

              //Single Hotel Image

              $sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$row_query[hotel_id]'"));

              if($sq_singleImage['hotel_pic_url']!=''){

                $image = $sq_singleImage['hotel_pic_url'];

                $newUrl1 = preg_replace('/(\/+)/','/',$image);

                $newUrl1 = explode('uploads', $newUrl1);

                $newUrl = BASE_URL.'uploads'.$newUrl1[1];

              }else{

                $newUrl = BASE_URL.'images/dummy-image.jpg';

              }



              $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_query[city_id]'"));

              //Category

              $star_category = explode(' ', $row_query['rating_star']);

              $star_category = (sizeof($star_category) > 1) ? $star_category[0] : '';

              //Amenities

              $amenity = explode(',', $row_query['amenities']);



              $hotel_result_array = array(

                "hotel_id"=>$row_query['hotel_id'],

                "hotel_name"=>$row_query['hotel_name'],

                "city_name"=>$sq_city['city_name'],

                "hotel_image"=>$newUrl,

                "star_category"=>$star_category,

                "hotel_address"=>addslashes($row_query['hotel_address']),

                "hotel_type"=>$row_query['hotel_type'],

                "meal_plan"=>$row_query['meal_plan'],

                "amenity" =>$amenity,

                "checkDate_array"=>$checkDate_array,

                "description"=>addslashes($row_query['description']),

                "policies"=>addslashes($row_query['policies']),

                "check_in"=>$check_indate,

                "check_out"=>$check_outdate,

                "total_rooms"=>$total_rooms,

              );

                array_push($hotel_results_array,$hotel_result_array);

            }

            ?>

              <input type='hidden' value='<?= json_encode($hotel_results_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='hotel_results_array' name='hotel_results_array'/>

              <div id='hotel_result_block'></div>

            </div>

          </div>

        </div>

      </div>

      <!-- ********** Component :: Hotel Listing End ********** -->

<?php include '../../layouts/footer.php'; ?>

<script type="text/javascript" src="../../js/jquery.range.min.js"></script>

<script type="text/javascript" src="../../js/pagination.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>/view/hotel/js/index.js"></script>

<script type="text/javascript" src="js/amenities.js"></script>

<script>

$('#checkInDate, #checkOutDate').datetimepicker({ timepicker:false,format:'m/d/Y',minDate:new Date() });

total_nights_reflect();



// Get Hotel results data

function get_price_filter_data(hotel_results_array,type,fromRange_cost,toRange_cost){

  var base_url = $('#base_url').val();

  var selected_value = document.getElementById(hotel_results_array).value;

  var JSONItems = JSON.parse(selected_value);

  get_price_filter_data_result(JSONItems);

}

//Display Hotel results data 

function get_price_filter_data_result(final_arr){

  var base_url = $('#base_url').val();

  $.post(base_url+'view/hotel/hotel_results.php', { final_arr: final_arr }, function (data) {

    $('#hotel_result_block').html(data);

	});

}

get_price_filter_data('hotel_results_array','3','0','0');

</script>