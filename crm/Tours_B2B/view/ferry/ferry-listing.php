<?php
include '../../../model/model.php';
include '../../layouts/header.php';

$currency = $_SESSION['session_currency_id'];
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$b2b_agent_code = $_SESSION['b2b_agent_code'];
$ferry_array = json_decode($_SESSION['ferry_array']);
$checkDate = date('d M Y H:i', strtotime($ferry_array[0]->travel_date));
$date1 = date("Y-m-d", strtotime($ferry_array[0]->travel_date));

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
          <span class="pageTitle">Ferry</span>

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
              <span class="sortTitle">
                <i class="icon it itours-sort-1"></i>
                Sort Ferries by:
              </span>
              <div class="dropdown selectable">
                <button class="btn-dd dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Most Popular
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" onClick="get_price_filter_data('ferry_result_array','1','fromRange_cost','toRange_cost');"> Price - High to Low</a>
                  <a class="dropdown-item" onClick="get_price_filter_data('ferry_result_array','2','fromRange_cost','toRange_cost');"> Price - Low to High</a>
                </div>
              </div>
            </div>
            
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
            <a href="<?= $b2b_index_url ?>">Home</a>
          </li>
          <li class="st-active">
            <a href="#">Ferry Search Result</a>
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
                        <div class="col-md-3 col-sm-6 col-12">
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
                        <div class="col-md-3 col-sm-6 col-12">
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
                        <div class="col-md-3 col-sm-6 col-12">
                          <div class="form-group">
                            <label>*Select Travel Datetime</label>
                            <div class="datepicker-wrap">
                              <input type="text" name="ftravelDate" title="Travel Datetime" class="input-text full-width" placeholder="mm/dd/yy" id="ftravelDate" value="<?= $ferry_array[0]->travel_date ?>" required/>
                            </div>
                          </div>
                        </div>
                        <!-- *** Travel End *** -->
                        <!-- *** Adult *** -->
                        <div class="col-md-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>*Adults</label>
                            <input type="number" name="fadults" title="Adults" class="input-text full-width" id="fadults" placeholder="Adults" min="0" value="<?= $adult ?>" required/>
                        </div>
                        </div>
                        <!-- *** Adult End *** -->
                        <!-- *** Children *** -->
                        <div class="col-md-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Children</label>
                            <input type="number" name="fchildren" title="Children" class="input-text full-width" id="fchildren" placeholder="Children" value="<?= $children ?>" min="0" />
                        </div>
                        </div>
                        <!-- *** Children End *** -->
                        <!-- *** Infant *** -->
                        <div class="col-md-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Infants</label>
                            <input type="number" name="finfant" title="Infants" class="input-text full-width" id="finfant" placeholder="Infants" min="0" value="<?= $infant ?>" />
                        </div>
                        </div>
                        <!-- *** Infant End *** -->
                        <div class="col-md-3 col-sm-6 col-12">
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
        <!-- ***** Price Filter ***** -->
        <div class="accordion c-accordion" id="filterPrice">
        <div class="card">

          <div class="card-header">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsFilterPrice" aria-expanded="true" aria-controls="jsFilterPrice">
                Price Range :(<span class='currency-icon'></span>)
              </button>
          </div>
          <div id="jsFilterPrice" class="collapse show" aria-labelledby="jsFilterPrice" data-parent="#filterPrice">
              <div class="card-body">
                <div class="c-priceRange">
                  <input type="hidden" class="slider-input" data-step="1"/>
                </div>
              </div>
            </div>
        </div>
        </div>
        <!-- ***** Price Filter End ***** -->
        <!-- ***** Type Filter ***** -->
        <div class="accordion c-accordion" id="filterRating">
        <div class="card">

          <div class="card-header">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsFilterRating" aria-expanded="true" aria-controls="jsFilterRating">
              Ferry Class
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
              $total_cost1 = 0;
              $adult_markup = 0;
              $child_markup = 0;
              $infant_markup = 0;
              while(($row_tariff  = mysqli_fetch_assoc($sq_tariff))){

                
                // ////////Adult//////////
                if($row_tariff['markup_in'] == 'Flat'){
                  $adult_markup = $row_tariff['markup_cost'];
                }else{
                  $adult_markup = (floatval($row_tariff['adult_cost']) * $row_tariff['markup_cost'] / 100);
                }
                $adult_cost = floatval($row_tariff['adult_cost']) + $adult_markup;
                // ///////Child///////////
                if($row_tariff['markup_in'] == 'Flat'){
                  $child_markup = $row_tariff['markup_cost'];
                }else{
                  $child_markup = (floatval($row_tariff['child_cost']) * $row_tariff['markup_cost'] / 100);
                }
                $child_cost = floatval($row_tariff['child_cost']) + $child_markup;
                // ///////Infant///////////
                if($row_tariff['markup_in'] == 'Flat'){
                  $infant_markup = $row_tariff['markup_cost'];
                }else{
                  $infant_markup = (floatval($row_tariff['infant_cost']) * $row_tariff['markup_cost'] / 100);
                }
                $infant_cost = floatval($row_tariff['infant_cost']) + $infant_markup;
                
                $total_cost1 = ($adult * $adult_cost) + ($children * $child_cost) + ($infant * $infant_cost);

                $total_cost1 = ($total_cost1);
                $adult_cost1 = ($adult_cost);
                $child_cost1 = ($child_cost);
                $infant_cost1 = ($infant_cost);
                $c_amount1 = $from_currency_rate / $to_currency_rate * $total_cost1;

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
                  'dep_date' => get_datetime_user($row_tariff['dep_date']),
                  'arr_date' => get_datetime_user($row_tariff['arr_date']),
                  'adults' => intval($adult),
                  'children' => intval($children),
                  'infant' => intval($infant),
                  'adult_cost' => floatval($row_tariff['adult_cost']),
                  'child_cost' => floatval($row_tariff['child_cost']),
                  'infant_cost' => floatval($row_tariff['infant_cost']),
                  'currency_id' => $row_tariff['currency_id'],
                  'total_cost' => floatval($total_cost1),
                  'adult_cost' => floatval($adult_cost1),
                  'child_cost' => floatval($child_cost1),
                  'infant_cost' => floatval($infant_cost1),
                  "best_lowest_cost"=>array('id'=>intval($row_tariff['currency_id']),
                                            'cost'=>floatval($total_cost1)),
                  "travel_date"=>$date1,
                  'inclusions'=>$row_query['inclusions'],
                  'exclusions'=> $row_query['exclusions'],
                  'terms_condition'=>$row_query['terms'],

                ));
              }
            }
          }
          //For Best low and high cost
          for($i=0;$i<sizeof($ferry_result_array);$i++){
            $total_cost = $original_cost = ($ferry_result_array[$i]['total_cost']);
            $currency_id = $ferry_result_array[$i]['currency_id'];
            array_push($all_costs_array,array('amount' => $total_cost,'id'=>$currency_id));
  
            $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency_id'"));
            $from_currency_rate = $sq_from['currency_rate'];
            $c_amount = $from_currency_rate / $to_currency_rate * $total_cost;
            array_push($actual_ccosts_array,$c_amount);
  
            if (!in_array($ferry_result_array[$i]['ferry_category'], $ferry_type_array)){
              array_push($ferry_type_array,$ferry_result_array[$i]['ferry_category']);
            }
          }
        $all_costs_array = ($all_costs_array==NULL)?[]:$all_costs_array;
        $all_costs_array1 = $array_master->array_column($all_costs_array, 'amount');
        $min_array = (sizeof($all_costs_array))?$all_costs_array[array_search(min($all_costs_array), $all_costs_array)]:[];
        $max_array = (sizeof($all_costs_array))?$all_costs_array[array_search(max($all_costs_array), $all_costs_array)]:[];
        
        $actual_ccosts_array = ($actual_ccosts_array!='')?$actual_ccosts_array:[];
        $ferry_result_array = ($ferry_result_array!='')?$ferry_result_array:[];
        $min_value = (sizeof($actual_ccosts_array)!=0)?min($actual_ccosts_array):0;
        $max_value= (sizeof($actual_ccosts_array)!=0)?max($actual_ccosts_array):0;
        ?>
        <input type='hidden' value='<?= json_encode($ferry_result_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='ferry_result_array' name='ferry_result_array'/>
        <input type='hidden' class='best-cost-currency' id='bestlow_cost' value='<?= $min_value ?>'/>
        <input type='hidden' class='best-cost-currency' id='besthigh_cost' value='<?= $max_value ?>'/>
        <input type='hidden' class='best-cost-id' id='bestlow_cost' value='<?= ($min_array['id']!='')?$min_array['id']:'0' ?>'/>
        <input type='hidden' class='best-cost-id' id='besthigh_cost' value='<?= ($max_array['id']!='')?$max_array['id']:'0'  ?>'/>
        <input type="hidden" id='price_rangevalues'/>
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
// Get currency changed values in hotel result
function get_currency_change(currency_id,JSONItems,fromRange_cost,toRange_cost,get_price_filter_data_result){
  var base_url = $('#base_url').val();
  var final_arr = [];
  
  JSONItems.forEach(function (item){
    var currency_rates = get_currency_rates(item.best_lowest_cost.id,currency_id).split('-');
    var to_currency_rate =  currency_rates[0];
    var from_currency_rate = currency_rates[1];
    var amount = parseFloat(to_currency_rate / from_currency_rate * item.best_lowest_cost.cost).toFixed(2);
    if(compare(amount,fromRange_cost,toRange_cost)){
      final_arr.push(item);
    }
  });
  get_price_filter_data_result(final_arr);
}

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
    if(type==1){
      final_arr = (JSONItems).sort(function(a,b){
        //First Value
        var currency_rates = get_currency_rates(a.best_lowest_cost.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        var aamount = parseFloat(to_currency_rate / from_currency_rate * a.best_lowest_cost.cost).toFixed(2);
        //Second value      
        var currency_rates = get_currency_rates(b.best_lowest_cost.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        var bamount = parseFloat(to_currency_rate / from_currency_rate * b.best_lowest_cost.cost).toFixed(2);

        return bamount-aamount;
      });
      get_price_filter_data_result(final_arr);
    }
    else if(type==2){
      final_arr = (JSONItems).sort(function(a,b){
        //First Value
        var currency_rates = get_currency_rates(a.best_lowest_cost.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        var aamount = parseFloat(to_currency_rate / from_currency_rate * a.best_lowest_cost.cost).toFixed(2);
        //Second value      
        var currency_rates = get_currency_rates(b.best_lowest_cost.id,currency_id).split('-');
        var to_currency_rate =  currency_rates[0];
        var from_currency_rate = currency_rates[1];
        var bamount = parseFloat(to_currency_rate / from_currency_rate * b.best_lowest_cost.cost).toFixed(2);

        return aamount - bamount;
      });
      get_price_filter_data_result(final_arr);
    }
    else if(type==3){
      
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
      get_currency_change(currency_id,JSONItems,fromRange_cost,toRange_cost,get_price_filter_data_result);    
    }
    
  }, 1000);
}
//Display ferry results data 
function get_price_filter_data_result(final_arr){
  var base_url = $('#base_url').val();
  $.post(base_url+'Tours_B2B/view/ferry/ferry_results.php', { final_arr: final_arr }, function (data) {
    $('#ferry_result_block').html(data);
	});
}
get_price_filter_data('ferry_result_array','2','0','0');

///////////Debounce function for range slider////////////
function getSliderValue(){
  var ranges = $('.slider-input').val().split(',');
  $('.slider-input').attr({
    min: parseFloat(ranges[0]).toFixed(2),
    max: parseFloat(ranges[1]).toFixed(2)
  });
  if(ranges[0]!='' && ranges[1]!='' && ranges[0]!=='NaN' && ranges[1]!=='NaN'){
    get_price_filter_data('ferry_result_array','4',ranges[0],ranges[1]);
  }
}
const setSliderValue = function (fun) {
	let timer;
	return function () {
		let context = this;
		args = arguments;
		clearTimeout(timer);
		timer = setTimeout(() => {
			fun.apply(context, args);
		}, 800);
	};
};
const passSliderValue = setSliderValue(getSliderValue);
//Make session for best hotel costs
clearTimeout(a);
var a = setTimeout(function() {

  var best_price_list = document.querySelectorAll(".best-cost-currency");
  var best_price_id = document.querySelectorAll(".best-cost-id");
  var bestAmount_arr = [];
  for(var i=0;i<best_price_list.length;i++){
    bestAmount_arr.push({
      'amount':best_price_list[i].value,
      'id':best_price_id[i].value});
  }
  sessionStorage.setItem('ferry_best_price',JSON.stringify(bestAmount_arr));
},100);
</script>
