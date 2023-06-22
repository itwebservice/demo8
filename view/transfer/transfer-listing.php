<?php
include '../../config.php';
include BASE_URL.'model/model.php';
include '../../layouts/header.php';

$_SESSION['page_type'] = 'Car Rental';

$currency = $_SESSION['session_currency_id'];
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];
$sq_app = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id='1'"));
$transfer_service_time = json_decode($sq_app['transfer_service_time']);

$b2b_agent_code = $_SESSION['b2b_agent_code'];
$pick_drop_array = json_decode($_SESSION['pick_drop_array']);

$pickup_time = date('H:i', strtotime($pick_drop_array[0]->pickup_date));
$pick1 = explode(' ',$transfer_service_time[0]->pick_from);
$pick2 = explode(' ',$transfer_service_time[0]->pick_to);

$passengers = $pick_drop_array[0]->passengers;
// Pickup
$pickup_id = $pick_drop_array[0]->pickup_from;
if($pickup_id!=''){
  if($pick_drop_array[0]->pickup_type == 'city'){
    $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$pickup_id'"));
    $pickup = $row['city_name'];
  }
  else if($pick_drop_array[0]->pickup_type == 'hotel'){
    $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$pickup_id'"));
    $pickup = $row['hotel_name'];
  }
  else{
    $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$pickup_id'"));
    $airport_nam = clean($row['airport_name']);
    $airport_code = clean($row['airport_code']);
    $pickup = $airport_nam." (".$airport_code.")";
  }
  $pick_html =  '<optgroup value="'.$pick_drop_array[0]->pickup_type.'" label="'.ucfirst($pick_drop_array[0]->pickup_type).' Name">';
  $pick_html .= '<option value="'.$pickup_id.'">'.$pickup.'</option></optgroup>';
}
else{
  $pickup = '';
  $pick_html = '';
}

//Drop-off
$drop_id = $pick_drop_array[0]->drop_to;
if($drop_id!=''){
  if($pick_drop_array[0]->drop_type == 'city'){
    $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$drop_id'"));
    $drop = $row['city_name'];
  }
  else if($pick_drop_array[0]->drop_type == 'hotel'){
    $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$drop_id'"));
    $drop = $row['hotel_name'];
  }
  else{
    $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$drop_id'"));
    $airport_nam = clean($row['airport_name']);
    $airport_code = clean($row['airport_code']);
    $drop = $airport_nam." (".$airport_code.")";
  }
  $drop_html =  '<optgroup value="'.$pick_drop_array[0]->drop_type.'" label="'.ucfirst($pick_drop_array[0]->drop_type).' Name">';
  $drop_html .= '<option value="'.$drop_id.'">'.$drop.'</option></optgroup>';
}
else{
  $drop_id = '';
  $drop_html = '';
}
$pickup_date1 = date('d M Y H:i', strtotime($pick_drop_array[0]->pickup_date));
$return_date1 = date('d M Y H:i', strtotime($pick_drop_array[0]->return_date));
if($pick_drop_array[0]->trip_type == 'oneway') {
  $round_class = '';
  $checked = 'checked';
}
else{
  $round_class = 'round';
  $rchecked = 'checked';
  $return_time = date('H:i', strtotime($pick_drop_array[0]->return_date));
  $return1 = explode(' ',$transfer_service_time[0]->return_from);
  $return2 = explode(' ',$transfer_service_time[0]->return_to);
}
// Query
$checkDate_array = array();
$pickup_date11 = date('Y-m-d', strtotime($pick_drop_array[0]->pickup_date));
$return_date11 = date('Y-m-d', strtotime($pick_drop_array[0]->return_date));
array_push($checkDate_array,$pickup_date11);
if($pick_drop_array[0]->trip_type == 'roundtrip') {
  array_push($checkDate_array,$return_date11);
}
$passenger = ($pick_drop_array[0]->passengers == 1) ? 'Passenger' : 'Passengers';

?>
<!-- ********** Component :: Page Title ********** -->
<div class="c-pageTitleSect">
  <div class="container">
    <div class="row">
      <div class="col-md-7 col-12">

        <!-- *** Search Head **** -->
        <div class="searchHeading">
          <span class="pageTitle">Transfer</span>

          <div class="clearfix for-transfer">

            <div class="sortSection">
              <span class="sortTitle st-search">
                <i class="icon it itours-pin-alt"></i>
                Pickup Location: <strong><?= ($pickup != '') ? $pickup : 'NA' ?></strong>
              </span>
            </div>
            <div class="sortIcon <?= $round_class ?>"></div>
            <div class="sortSection">
              <span class="sortTitle st-search">
                <i class="icon it itours-pin-alt"></i>
                Dropoff Location: <strong><?= ($drop != '') ? $drop : 'NA' ?></strong>
              </span>
            </div>

          </div>

          <div class="clearfix">

            <div class="sortSection">
              <span class="sortTitle st-search">
                <i class="icon it itours-timetable"></i>
                Pickup Date & Time: <strong><?= $pickup_date1 ?></strong>
              </span>
            </div>
            <?php if($pick_drop_array[0]->trip_type != 'oneway'){ ?>
            <div class="sortSection">
              <span class="sortTitle st-search">
                <i class="icon it itours-timetable"></i>
                Return Date & Time: <strong><?= $return_date1 ?></strong>
              </span>
            </div>
            <?php } ?>

            <div class="sortSection">
              <span class="sortTitle st-search">
                <i class="icon it itours-person"></i>
                <?= $pick_drop_array[0]->passengers.' '.$passenger ?> 
              </span>
            </div>

          </div>

          <div class="clearfix">

            <div class="sortSection">
              <span class="sortTitle st-search">
                <i class="icon it itours-search"></i>
                <span>Showing <span class="results_count"></span> </span>
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
            <a href="javascript:void(0)">Transfer Search Result</a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</div>
<!-- ********** Component :: Page Title End ********** -->


<!-- ********** Component :: Transfer Listing  ********** -->
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
                Modify Search >> <span class="results_count"></span><?php echo ' Transfer available for '.($passengers).' Pax'; ?>
                </button>
              </div>
              <div id="jsModifySearch_filter" class="collapse" aria-labelledby="jsModifySearch_filter" data-parent="#modifySearch_filter">
                <div class="card-body">
                <form id="frm_transfer_search">
                  <div class="row">
                    <div class="col-12">
                      <div class="radioCheck">
                        <div class="sect s1">
                          <input type="radio" value="oneway" id="oneway" name="transfer_type" class="radio_txt transfer_type" onclick="fields_enable_disable()" <?= $checked ?> />
                          <label for="oneway" role="button" class="radio_lbl">One Way</label>
                        </div>
                        <div class="sect s2">
                          <input type="radio"value="roundtrip" id="roundtrip" name="transfer_type" class="radio_txt transfer_type" onclick="fields_enable_disable()"  <?= $rchecked ?> />
                          <label for="roundtrip" role="button" class="radio_lbl">Round Trip</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                      <div class="form-group">
                          <label>Pickup Location*</label>
                          <div class="c-select2DD">
                          <select id='pickup_location' class="full-width js-roomCount">
                              <?php if($pick_html != ''){
                                echo $pick_html;
                                }
                              ?>
                              <option value="">Select Pickup Location</option>
                              <optgroup value='city' label="City Name">
                              <?php get_cities_dropdown('1'); ?>
                              </optgroup>
                              <optgroup value='airport' label="Airport Name">
                              <?php get_airport_dropdown(); ?>
                              </optgroup>
                              <optgroup value='hotel' label="Hotel Name">
                              <?php get_hotel_dropdown(); ?>
                              </optgroup>
                          </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                      <div class="form-group">
                          <label>Pickup Date&Time*</label>
                          <div class="datepicker-wrap">
                              <input type="text" name="pickup_date" class="input-text full-width" placeholder="mm/dd/yy H:i" id="pickup_date" value="<?= $pick_drop_array[0]->pickup_date ?>"/>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                      <div class="form-group">
                        <label>Total Passengers*</label>
                        <input type="number" name="passengers" class="input-text full-width" placeholder="Total Passengers" id="passengers" value="<?= $pick_drop_array[0]->passengers ?>"/>
                      </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                      <div class="form-group">
                        <label>Drop-Off Location*</label>
                          <div class="c-select2DD">
                          <select id='dropoff_location' class="full-width js-roomCount">
                              <?php if($drop_html != ''){
                                  echo $drop_html;
                              } ?>
                              <option value="">Select Drop-Off Location</option>
                              <optgroup value='city' label="City Name">
                              <?php get_cities_dropdown('1'); ?>
                              </optgroup>
                              <optgroup value='airport' label="Airport Name">
                              <?php get_airport_dropdown(); ?>
                              </optgroup>
                              <optgroup value='hotel' label="Hotel Name">
                              <?php get_hotel_dropdown(); ?>
                              </optgroup>
                          </select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                      <div class="form-group">
                          <label>Return Date&Time</label>
                          <div class="datepicker-wrap">
                              <input type="text" name="return_date" class="input-text full-width" placeholder="mm/dd/yy H:i" id="return_date" value="<?= $pick_drop_array[0]->return_date ?>" onchange="check_valid_date_trs()"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-12">
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
      <!-- ***** Transfer Listing Filter ***** -->
      <div class="col-md-3 col-sm-12">
        <!-- ***** Type Filter ***** -->
        <div class="accordion c-accordion" id="filterRating">
        <div class="card">

          <div class="card-header">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsFilterRating" aria-expanded="true" aria-controls="jsFilterRating">
              Vehicle Type
            </button>
          </div>

          <div id="jsFilterRating" class="collapse show" aria-labelledby="jsFilterRating" data-parent="#filterRating">
            <div class="card-body filters-container">
              <ul class="c-checkSquare" id="vehicle_types"></ul>
            </div>
          </div>
        </div>
        </div>
        <!-- ***** Type Filter End ***** -->
      </div>
      <!-- ***** Transfer Listing Filter End ***** -->

      <!-- ***** Transfer Listing ***** -->
      <?php
      $transfer_result_array = array();
      $final_arr = array();
      if(($pickup_time >= $pick1[0]) && ($pickup_time <= $pick2[0])){
        
        $actual_ccosts_array = array();
        $all_costs_array = array();
        $vehicle_type_array = array();

        $query = "select * from b2b_transfer_master where status!='Inactive' ";
        $sq_query = mysqlQuery($query);
        while(($row_query  = mysqli_fetch_assoc($sq_query))){

          $vehicle_data = json_decode($row_query['vehicle_data']);
          if($row_query['image_url'] != ''){
            $image = $row_query['image_url'];
            $newUrl1 = preg_replace('/(\/+)/','/',$image);
            $newUrl1 = explode('uploads', $newUrl1);
            $newUrl = BASE_URL.'uploads'.$newUrl1[1];
          }else{
            $newUrl = BASE_URL.'images/taxi.png';
          }
          $max_pax = $row_query['seating_capacity'];
          $vehicle_count = ceil($passengers / $max_pax);
          //Tariff Master
          $sq_tariff_master = mysqlQuery("select * from b2b_transfer_tariff where vehicle_id='$row_query[entry_id]'");
          while($row_tariff_master = mysqli_fetch_assoc($sq_tariff_master)){
            
            $currency_id = $row_tariff_master['currency_id'];
            $total_cost = 0;
            for($i_date=0; $i_date<sizeof($checkDate_array); $i_date++){

                if($i_date === 0){
                  $sq_tariff = mysqlQuery("select * from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_location = '$pickup_id' and drop_location = '$drop_id' and (from_date <='$checkDate_array[$i_date]' and to_date>='$checkDate_array[$i_date]')");
                }else{
                  $sq_tariff = mysqlQuery("select * from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_location = '$drop_id' and drop_location = '$pickup_id' and (from_date <='$checkDate_array[$i_date]' and to_date>='$checkDate_array[$i_date]')");
                }

                while($row_tariff = mysqli_fetch_assoc($sq_tariff)){

                  $tariff_data = json_decode($row_tariff['tariff_data']);
                  array_push($transfer_result_array,array(
                    "trip_date"=>$checkDate_array[$i_date],
                    "vehicle_id"=>(int)($row_query['entry_id']),
                    "vehicle_name"=>$row_query['vehicle_name'],
                    "transfer_image"=>$newUrl,
                    "vehicle_type"=>$row_query['vehicle_type'],
                    "cancellation_policy"=>$row_query['cancellation_policy'],
                    "currency_id"=>(int)($currency_id),
                    "total_cost" =>$total_cost,
                    'luggage'=> $tariff_data[0]->seating_capacity,
                    'seating_capacity'=>(int)($max_pax),
                    'service_duration'=> $row_tariff['service_duration'],
                    'vehicle_count'=>(int)($vehicle_count),
                    'trip_type'=>$pick_drop_array[0]->trip_type,
                    'pickup'=>$pickup,
                    'pickup_date'=>$pickup_date1,
                    'drop'=>$drop,
                    'return_date'=>$return_date1,
                    'passengers'=>$pick_drop_array[0]->passengers
                  ));
                }
            }  
          }
        }
        
        if($pick_drop_array[0]->trip_type == 'roundtrip') {
          $final_result_array = array();
          $total_cost = 0;
          for($i=0;$i<sizeof($transfer_result_array);$i++){

            $key = array_search($transfer_result_array[$i]['vehicle_id'], $array_master->array_column($final_result_array, 'vehicle_id'));
            if(gettype($key) === "integer"){
              $uni_array[] = $key;
            }

            array_push($final_result_array,array(
              "trip_date"=>$transfer_result_array[$i]['trip_date'],
              "vehicle_id"=>($transfer_result_array[$i]['vehicle_id']),
              "vehicle_name"=>$transfer_result_array[$i]['vehicle_name'],
              "transfer_image"=>$transfer_result_array[$i]['transfer_image'],
              "vehicle_type"=>$transfer_result_array[$i]['vehicle_type'],
              "cancellation_policy"=>$transfer_result_array[$i]['cancellation_policy'],
              "currency_id"=>($transfer_result_array[$i]['currency_id']),
              'luggage'=> $transfer_result_array[$i]['luggage'],
              'seating_capacity'=>($transfer_result_array[$i]['seating_capacity']),
              'service_duration'=> $transfer_result_array[$i]['service_duration'],
              'vehicle_count'=>($transfer_result_array[$i]['vehicle_count']),
              'trip_type'=>$pick_drop_array[0]->trip_type,
              'pickup'=>$pickup,
              'pickup_date'=>$pickup_date1,
              'drop'=>$drop,
              'return_date'=>$return_date1,
              'passengers'=>$pick_drop_array[0]->passengers
            ));
          }
          $uni_array = ($uni_array != '') ? $uni_array : [];
          if(!empty($final_result_array)){
            for($i=0;$i<sizeof($uni_array);$i++){
              $key = $uni_array[$i];
              $new_array[] = $final_result_array[$key];
            }
          }else{
            $new_array[] = [];
          }
        }
        if($pick_drop_array[0]->trip_type == 'roundtrip') {
          if(($return_time >= $return1[0]) && ($return_time <= $return2[0])){
            $final_arr = $new_array;
          }
        }
        else{
          $final_arr = $transfer_result_array;
        }
        if(empty($final_arr)){
          $final_arr = [];
        }
        
        for($i=0;$i<sizeof($final_arr);$i++){

          if (!in_array($final_arr[$i]['vehicle_type'], $vehicle_type_array)){
            array_push($vehicle_type_array,$final_arr[$i]['vehicle_type']);
          }
        }
      }
        ?>
      <input type='hidden' value='<?= json_encode($final_arr,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='transfer_result_array' name='transfer_result_array'/>
      <input type="hidden" value='<?= json_encode($vehicle_type_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id="vehicle_type_array"/>
      <input type="hidden" id="selected_vehicle_type_array"/>
      
      <div class="col-md-9 col-sm-12">
          <div id="transfer_result_block"> </div>
      </div>
      <!-- ***** Transfer Listing End ***** -->
    </div>
  </div>
</div>
<!-- ********** Component :: Transfer Listing End ********** -->
<?php include '../../layouts/footer.php'; ?>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="../../js/jquery.range.min.js"></script>
<script type="text/javascript" src="../../js/pagination.min.js"></script>
<script>
  $('#pickup_date').datetimepicker({ format:'m/d/Y H:i',minDate:new Date() });
  fields_enable_disable();
  $(document).ready(function () {
    $('body').delegate('.lblfilterChk','click', function(){
      get_price_filter_data('transfer_result_array','3','0','0');
    })
  });
// Get results data
function get_price_filter_data(transfer_result_array,type,fromRange_cost,toRange_cost){
  var base_url = $('#base_url').val();
  setTimeout(() => {
    var selected_value = document.getElementById(transfer_result_array).value;
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
      
			var vehicle_type_array = [];
			var checkboxes = document.getElementsByName('vehicle_type');
			for (var checkbox of checkboxes) {
				if (checkbox.checked)
				vehicle_type_array.push(checkbox.value);
      }
      if(vehicle_type_array.length != 0){
          final_arr = (JSONItems).filter(function(a){
            return vehicle_type_array.includes(a.vehicle_type);
          });
      }else{
        final_arr = JSONItems;
      }
      $('#selected_vehicle_type_array').val(vehicle_type_array);
      get_price_filter_data_result(final_arr);
    }
    else{
      var currency_id = $('#currency').val();
      get_price_filter_data_result(JSONItems);
    }
    
  }, 1000);
}
//Display Hotel results data 
function get_price_filter_data_result(final_arr){
  var base_url = $('#base_url').val();
  $.post(base_url+'view/transfer/transfer-results.php', { final_arr: final_arr }, function (data) {
    $('#transfer_result_block').html(data);
	});
}
get_price_filter_data('transfer_result_array','4','0','0');

</script>
