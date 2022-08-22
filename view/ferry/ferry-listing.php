<?php

include '../../config.php';

include BASE_URL.'model/model.php';

include '../../layouts/header.php';



$currency = $_SESSION['session_currency_id'];

$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));

$to_currency_rate = $sq_to['currency_rate'];



$ferry_array = json_decode($_SESSION['ferry_array']);

$checkDate = date('d M Y H:i', strtotime($ferry_array[0]->travel_date));

$date1 = date("Y-m-d", strtotime($ferry_array[0]->travel_date));

$travel_date = date("Y-m-d H:i", strtotime($ferry_array[0]->travel_date));



$adult = ($ferry_array[0]->adult!='') ? $ferry_array[0]->adult : 0;

$children = ($ferry_array[0]->children != '') ? $ferry_array[0]->children : 0;

$infant = ($ferry_array[0]->infant != '') ? $ferry_array[0]->infant : 0;



$pax = intval($adult) + intval($children) + intval($infant);

$costing_pax = intval($pax) - intval($ferry_array[0]->infant);

$from_city_id = $ferry_array[0]->from_city;

$to_city_id = $ferry_array[0]->to_city;



if($from_city_id!=''){

    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id = '$from_city_id'"));

}

if($to_city_id!=''){

    $sq_tocity = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id = '$to_city_id'"));

} 

?>

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect">

  <div class="container">

    <div class="row">

      <div class="col-md-7 col-12">



        <!-- *** Search Head **** -->

        <div class="searchHeading">

          <span class="pageTitle">Cruise</span>



          <div class="clearfix for-transfer">

            <?php if($from_city_id != ''){ ?>

            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-pin-alt"></i>

                From Location: <strong id="from_loc_city"><?= $sq_city['city_name'] ?></strong>

              </span>

            </div>

            <?php } ?>

            <?php if($to_city_id != ''){ ?>

            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-pin-alt"></i>

                To Location: <strong id="to_loc_city"><?= $sq_tocity['city_name'] ?></strong>

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

                <?php echo $ferry_array[0]->adult; ?> Adult(s), <?php echo $children ; ?> Child(ren), <?php echo $infant; ?> Infant(s)

                <input type="hidden" id="total_passengers" value="<?= $ferry_array[0]->adult.'-'.$children.'-'.$infant ?>"/>

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

            <a href="javascript:void(0)">Cruise Search Result</a>

          </li>

        </ul>

      </div>



    </div>

  </div>

</div>

<!-- ********** Component :: Page Title End ********** -->





<!-- ********** Component :: Tours Listing  ********** -->

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

                <form id="frm_ferry_search">

                  <div class="row">

                        <input type='hidden' id='page_type' value='search_page' name='search_page'/>

                        <!-- *** From Location Name *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <label>*Select From Location</label>

                            <div class="c-select2DD">

                              <select id='ffrom_city_filter' title="From Location" class="full-width js-roomCount">

                                <option value="<?= $sq_city['city_id'] ?>"><?= $sq_city['city_name'] ?></option>

                              </select>

                            </div>

                          </div>

                        </div>

                        <!-- *** From Location Name End *** -->

                        <!-- *** To Location Name *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <label>*Select To Location</label>

                            <div class="c-select2DD">

                              <select id='fto_city_filter' title="To Location" class="full-width js-roomCount">

                                <option value="<?= $sq_tocity['city_id'] ?>"><?= $sq_tocity['city_name'] ?></option>

                              </select>

                            </div>

                          </div>

                        </div>

                        <!-- *** To Location Name End *** -->

                        <!-- *** Travel Date *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <label>*Select Travel Datetime</label>

                            <div class="datepicker-wrap">

                              <input type="text" name="ftravelDate" title="Travel Datetime" class="input-text full-width" placeholder="mm/dd/yy" id="ftravelDate" value="<?= $ferry_array[0]->travel_date ?>" required/>

                            </div>

                          </div>

                        </div>

                        <!-- *** Travel End *** -->

                        <!-- *** Adult *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>*Adults</label>

                            <input type="number" name="fadults" title="Adults" class="input-text full-width" id="fadults" placeholder="Adults" min="0" value="<?= $adult ?>" required/>

                        </div>

                        </div>

                        <!-- *** Adult End *** -->

                        <!-- *** Children *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>Children</label>

                            <input type="number" name="fchildren" title="Children" class="input-text full-width" id="fchildren" placeholder="Children" value="<?= $children ?>" min="0" />

                        </div>

                        </div>

                        <!-- *** Children End *** -->

                        <!-- *** Infant *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>Infants</label>

                            <input type="number" name="finfant" title="Infants" class="input-text full-width" id="finfant" placeholder="Infants" min="0" value="<?= $infant ?>" />

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

      <!-- ***** Tours Listing Filter ***** -->

      <div class="col-md-3 col-sm-12">

        <!-- ***** Type Filter ***** -->

        <div class="accordion c-accordion" id="filterRating">

        <div class="card">



          <div class="card-header">

            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsFilterRating" aria-expanded="true" aria-controls="jsFilterRating">

              Cruise Class

            </button>

          </div>



          <div id="jsFilterRating" class="collapse show" aria-labelledby="jsFilterRating" data-parent="#filterRating">

            <div class="card-body filters-container">

              <ul class="c-checkSquare" id="ferry_types"></ul>

            </div>

          </div>

        </div>

        </div>

        <!-- ***** Type Filter End ***** -->

      </div>

      <!-- ***** Tours Listing Filter End ***** -->



      <!-- ***** Tours Listing ***** -->

        <?php

        $ferry_result_array = array();

        $ferry_type_array = array();

        $final_arr = array();

        

        $image_uploaded = '';

        $actual_ccosts_array = array();

        $all_costs_array = array();

        $query = mysqlQuery("select * from ferry_master where active_flag='Active'");

        while(($row_query  = mysqli_fetch_assoc($query))){

            $q = "select * from ferry_tariff where valid_from_date <= '$date1' and valid_to_date >= '$date1' and from_location='$from_city_id' and to_location='$to_city_id' and DATE(dep_date)='$date1' and entry_id='$row_query[entry_id]'";

            $sq_tariff_count = mysqli_num_rows(mysqlQuery($q));

            if($sq_tariff_count > 0){



              $newUrl = $row_query['image_url'];



              $sq_tariff = mysqlQuery("select * from ferry_tariff where valid_from_date <= '$date1' and valid_to_date >= '$date1' and from_location='$from_city_id' and to_location='$to_city_id' and DATE(dep_date)='$date1' and entry_id='$row_query[entry_id]'");

              while(($row_tariff  = mysqli_fetch_assoc($sq_tariff))){





                $dep_dates = date('d-m-Y H:i', strtotime($row_tariff['dep_date']));

                $arr_dates = date('d-m-Y H:i', strtotime($row_tariff['arr_date']));



                array_push($ferry_result_array,array(

                  "ferry_id"=>$row_query['entry_id'],

                  "tariff_id"=>$row_tariff['tariff_id'],

                  "ferry_type"=>$row_query['ferry_type'],

                  "ferry_name"=>$row_query['ferry_name'],

                  "seating_capacity"=>intval($row_query['seating_capacity']),

                  'image' => $newUrl,

                  'child_from' => intval($row_query['child_from']),

                  'child_to' => intval($row_query['child_to']),

                  'infant_from' => intval($row_query['infant_from']),

                  'infant_to' => intval($row_query['infant_to']),

                  'ferry_category' => $row_tariff['category'],

                  'dep_date' => $dep_dates,

                  'arr_date' => $arr_date,

                  'adults' => intval($adult),

                  'children' => intval($children),

                  'infant' => intval($infant),

                  'currency_id' => $row_tariff['currency_id'],

                  "travel_date"=>$travel_date,

                  'inclusions'=>$row_query['inclusions'],

                  'exclusions'=> $row_query['exclusions'],

                  'terms_condition'=>$row_query['terms'],

                  'from_location'=>$sq_city['city_name'],

                  'to_location'=>$sq_tocity['city_name']

                ));

              }

            }

          }

          //For Best low and high cost

          for($i=0;$i<sizeof($ferry_result_array);$i++){

  

            if (!in_array($ferry_result_array[$i]['ferry_category'], $ferry_type_array)){

              array_push($ferry_type_array,$ferry_result_array[$i]['ferry_category']);

            }

          }

        ?>

        <input type='hidden' value='<?= json_encode($ferry_result_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='ferry_result_array' name='ferry_result_array'/>

        <input type="hidden" value='<?= json_encode($ferry_type_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id="ferry_type_array"/>

        <input type="hidden" id="selected_ferry_type_array"/>

      

        <div class="col-md-9 col-sm-12">

            <div id="ferry_result_block">



            </div>

        </div>

      <!-- ***** Tours Listing End ***** -->

    </div>

  </div>

</div>

<!-- ********** Component :: Tours Listing End ********** -->

<?php

include '../../layouts/footer.php';

?>

<script type="text/javascript" src="../../js/scripts.js"></script>

<script type="text/javascript" src="js/index.js"></script>

<script type="text/javascript" src="../../js/jquery.range.min.js"></script>

<script type="text/javascript" src="../../js/pagination.min.js"></script>

<script>

  $('#travelDate').datetimepicker({ timepicker:false,format:'m/d/Y',minDate:new Date() });

  $('#ftravelDate').datetimepicker({ timepicker:true,format:'m/d/Y H:i',minDate:new Date() });

  

  $(document).ready(function () {

    $('body').delegate('.lblfilterChk','click', function(){

      get_price_filter_data('ferry_result_array','3','0','0');

    })

  });



// Get ferry results data

function get_price_filter_data(ferry_result_array,type,fromRange_cost,toRange_cost){



  var base_url = $('#base_url').val();

  

  setTimeout(() => {

    var selected_value = document.getElementById(ferry_result_array).value;

    var JSONItems = JSON.parse(selected_value);

    var final_arr = [];

    if (typeof Storage !== 'undefined') {

      if (localStorage) {

        var currency_id = localStorage.getItem('global_currency');

      } else {

        var currency_id = window.sessionStorage.getItem('global_currency');

      }

    }

    if(type==3){

      

			var ferry_type_array = [];

			var checkboxes = document.getElementsByName('ferry_type');

			for (var checkbox of checkboxes) {

				if (checkbox.checked)

				ferry_type_array.push(checkbox.value);

      }

      if(parseInt(ferry_type_array.length) > 0){

        final_arr = (JSONItems).filter(function(a){

          return ferry_type_array.includes(a.ferry_category);

        });

      }else{

        final_arr = (JSONItems);

      }

      $('#selected_ferry_type_array').val(ferry_type_array);

      get_price_filter_data_result(final_arr);

    }

    else{

      var currency_id = $('#currency').val();

      get_price_filter_data_result(JSONItems);

    }

    

  }, 1000);

}

//Display ferry results data 

function get_price_filter_data_result(final_arr){

  var base_url = $('#base_url').val();

  $.post(base_url+'view/ferry/ferry_results.php', { final_arr: final_arr }, function (data) {

    $('#ferry_result_block').html(data);

	});

}

get_price_filter_data('ferry_result_array','4','0','0');

</script>

