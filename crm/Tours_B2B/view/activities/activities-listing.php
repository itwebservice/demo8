<?php
include '../../../model/model.php';
include '../../layouts/header.php';
global $currency;
$b2b_currency = $_SESSION['session_currency_id'];
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$b2b_currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$b2b_agent_code = $_SESSION['b2b_agent_code'];
$activity_array = json_decode($_SESSION['activity_array']);
$checkDate = date('d M Y', strtotime($activity_array[0]->checkDate));
$date1 = date("Y-m-d", strtotime($activity_array[0]->checkDate));
$pax = $activity_array[0]->adult+$activity_array[0]->child+$activity_array[0]->infant;
$city_id = $activity_array[0]->activity_city_id;
$activities_id = $activity_array[0]->activities_id;
$day = date("l", strtotime($date1));
//City Search
if($city_id!=''){
    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id='$city_id'"));
    $query = "select * from excursion_master_tariff where city_id='$city_id' and active_flag='Active'";
}
//Hotel Search
if($activities_id!=''){
    $sq_exc = mysqli_fetch_assoc(mysqlQuery("select entry_id,excursion_name from excursion_master_tariff where entry_id='$activities_id'"));
    $query = "select * from excursion_master_tariff where entry_id='$activities_id' and active_flag='Active'";
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

          <div class="clearfix for-transfer">
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
              <span class="sortTitle st-search">
                <i class="icon it itours-pin-alt"></i>
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
                <?php $adult_label = ($activity_array[0]->adult <= 1) ? 'Adult':'Adults';
                      $child_label = ($activity_array[0]->child <= 1) ? 'Child':'Children';
                      $infant_label = ($activity_array[0]->infant <= 1) ? 'Infant':'Infants';
                echo $activity_array[0]->adult.' '.$adult_label; ?> , <?php echo $activity_array[0]->child.' '.$child_label; ?>, <?php echo $activity_array[0]->infant.' '.$infant_label; ?> 
              </span>
            </div>

          </div>

          <div class="clearfix">

            <div class="sortSection">
              <span class="sortTitle">
                <i class="icon it itours-sort-1"></i>
                Sort Activities by:
              </span>
              <div class="dropdown selectable">
                <button class="btn-dd dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Most Popular
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" onClick="get_price_filter_data('activity_result_array','1','fromRange_cost','toRange_cost');"> Price - High to Low</a>
                  <a class="dropdown-item" onClick="get_price_filter_data('activity_result_array','2','fromRange_cost','toRange_cost');"> Price - Low to High</a>
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
                            <div class="col-md-3 col-sm-6 col-12">
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
                            <div class="col-md-3 col-sm-6 col-12">
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
                                        $querys = "select entry_id,excursion_name from excursion_master_tariff where entry_id='$activities_id' and active_flag='Active'"; }
                                        else{
                                        $querys = "select entry_id, excursion_name from excursion_master_tariff where 1 and active_flag='Active'";
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
                            <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>*Select Date</label>
                                <div class="datepicker-wrap">
                                <input type="text" name="checkDate" class="input-text full-width" placeholder="mm/dd/yy" id="checkDate" value="<?= $activity_array[0]->checkDate ?>" required/>
                                </div>
                            </div>
                            </div>
                            <!-- *** Date End *** -->
                            
                            <!-- *** Adult *** -->
                            <div class="col-md-3 col-sm-6 col-12">
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
                            <div class="col-md-3 col-sm-6 col-12">
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
                            <div class="col-md-3 col-sm-6 col-12">
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
      <!-- ***** Activity Listing Filter ***** -->
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
      </div>
      <!-- ***** Activity Listing Filter End ***** -->

      <!-- ***** Activity Listing ***** -->
        <?php
        $adult_count = $activity_array[0]->adult;
        $child_count = $activity_array[0]->child;
        $infant_count = $activity_array[0]->infant;
        $activity_result_array = array();
        $final_arr = array();
        
        $actual_ccosts_array = array();
        $actual_orgcosts_array = array();
        $sq_query = mysqlQuery($query);
        while(($row_query  = mysqli_fetch_assoc($sq_query))){
          $all_costs_array = array();
          $all_orgcosts_array = array();
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
            $from_currency_rate1 = $sq_from['currency_rate'];

            //Single Hotel Image
            $sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_images where exc_id='$exc_id'"));
            if($sq_singleImage['image_url']!=''){
                $image = $sq_singleImage['image_url'];
                $newUrl1 = preg_replace('/(\/+)/','/',$image);
                $newUrl1 = explode('uploads', $newUrl1);
                $newUrl = BASE_URL.'uploads'.$newUrl1[1];
            }else{
                $newUrl = BASE_URL.'images/dummy-image.jpg';
            }

            //Tariff Master 
            $sq_count = mysqli_num_rows(mysqlQuery("select * from excursion_master_tariff_basics where exc_id='$exc_id' and (from_date <='$date1' and to_date>='$date1')"));
            if($sq_count >0){
                $sq_tariff_master = mysqlQuery("select * from excursion_master_tariff_basics where exc_id='$exc_id' and (from_date <='$date1' and to_date>='$date1')");
                while(($row_tariff_master  = mysqli_fetch_assoc($sq_tariff_master))){

                  $total_cost1 = ($adult_count*$row_tariff_master['adult_cost'] + $child_count*$row_tariff_master['child_cost'] + $infant_count*$row_tariff_master['infant_cost']);

                  if($row_tariff_master['markup_in'] == 'Flat'){
                      $total_cost1 += $row_tariff_master['markup_cost'];
                  }else{
                      $total_cost1 = $total_cost1 + ($total_cost1 * $row_tariff_master['markup_cost'] / 100);
                  }
                  $total_cost = ($total_cost1);
                  array_push($all_orgcosts_array,array('orgamount' => floatval($total_cost1),'id'=>$currency_id));
                  $c_amount1 = ($to_currency_rate!='') ? $from_currency_rate / $to_currency_rate * $total_cost1 : 0;
                  array_push($actual_orgcosts_array,$c_amount1);

                  //Checking discount applied or not
                  $sq_offers_count = mysqli_num_rows(mysqlQuery("select * from excursion_master_offers where (from_date <='$date1' and to_date>='$date1') and exc_id='$exc_id'"));
                  if($sq_offers_count>0){
                  $row_offers = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_offers where (from_date <='$date1' and to_date>='$date1') and exc_id='$exc_id'"));
                    $offer_type = $row_offers['type'];
                    $offer_in = $row_offers['offer_in'];
                    $offer_amount = $row_offers['offer_amount'];
                    $coupon_code = $row_offers['coupon_code'];
                    $agent_type = $row_offers['agent_type'];
                  }else{
                    $offer_type = '';
                    $offer_in = '';
                    $offer_amount = 0;
                    $coupon_code = '';
                    $agent_type = '';
                  }
                  //Offers
                  if($offer_type != ''){
                    if($offer_type == 'Offer'){
                      if($offer_in == 'Percentage'){
                          $offer_applied = $total_cost1 * ($offer_amount/100); 
                      }
                      else{
                        
                          if($currency != $b2b_currency){
                          
                              $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
                              $from_currency_rate = $sq_from['currency_rate'];
                              $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$b2b_currency'"));
                              $to_currency_rate = $sq_to['currency_rate'];
                              $offer_applied = ($to_currency_rate != '') ? $from_currency_rate / $to_currency_rate * $offer_amount : 0;
                          }else{
                              $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
                              $from_currency_rate = $sq_from['currency_rate'];
                              $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency_id'"));
                              $to_currency_rate = $sq_to['currency_rate'];
                              $offer_applied = ($to_currency_rate != '') ? $from_currency_rate / $to_currency_rate * $offer_amount : 0;
                          }
                      }
                      $total_cost1 = $total_cost1 - $offer_applied;
                    }
                  }
                  //Final cost push into array
                  array_push($transfer_options_array,array(
                    "transfer_option"=>$row_tariff_master['transfer_option'],
                    "total_cost"=>$total_cost1,
                    "org_cost"=>$total_cost,
                    'offer_type'=>$offer_type,
                    'offer_in'=>$offer_in,
                    'offer_amount'=>$offer_amount,
                    'coupon_code'=>$coupon_code,
                    'agent_type'=>$agent_type,
                    'offer_applied'=>$offer_applied
                  ));
                  array_push($all_costs_array,array('amount' => floatval($total_cost1),'id'=>$currency_id));
                  $c_amount = ($to_currency_rate!='') ? $from_currency_rate1 / $to_currency_rate * $total_cost1 : 0;
                  array_push($actual_ccosts_array,floatval($total_cost1));
                }
                $prices = $array_master->array_column($all_costs_array,'amount');
                $min_array = $all_costs_array[array_search(min($prices), $prices)];
                $prices1 = $array_master->array_column($all_orgcosts_array,'orgamount');
                $orgmin_array = $all_orgcosts_array[array_search(min($prices1), $prices1)];

                array_push($activity_result_array,array(
                    "exc_id"=>(int)($exc_id),
                    "excursion_name"=>$row_query['excursion_name'],
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
                    'transfer_options'=>$transfer_options_array,
                    "taxation"=>json_decode($row_query['taxation']),
                    "best_lowest_cost"=>array('id'=>$min_array['id'],
                                              'cost'=>$min_array['amount']),
                    "best_org_cost"=>array("id"=>$orgmin_array['id'],
                              "org_cost"=>$orgmin_array['orgamount'])
                ));
            }
          }
        }
        $all_costs_array = ($all_costs_array==NULL)?[]:$all_costs_array;
        $all_costs_array1 = $array_master->array_column($all_costs_array,'amount');
        $min_array = (sizeof($all_costs_array))?$all_costs_array[array_search(min($all_costs_array), $all_costs_array)]:[];
        $max_array = (sizeof($all_costs_array))?$all_costs_array[array_search(max($all_costs_array), $all_costs_array)]:[];

        $actual_ccosts_array = ($actual_ccosts_array!='')?$actual_ccosts_array:[];
        $activity_result_array = ($activity_result_array!='')?$activity_result_array:[];
        $min_value = (sizeof($actual_ccosts_array)!=0)?min($actual_ccosts_array):0;
        $max_value= (sizeof($actual_ccosts_array)!=0)?max($actual_ccosts_array):0;
        ?>
        <input type='hidden' value='<?= json_encode($activity_result_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='activity_result_array' name='activity_result_array'/>
        <input type='hidden' class='best-cost-currency' id='bestlow_cost' value='<?= ($min_value!='')?$min_value:'0'  ?>'/>
        <input type='hidden' class='best-cost-currency' id='besthigh_cost' value='<?= ($max_value!='')?$max_value:'0' ?>'/>
        <input type='hidden' class='best-cost-id' id='bestlow_cost' value='<?= ($min_array['id']!='')?$min_array['id']:'0' ?>'/>
        <input type='hidden' class='best-cost-id' id='besthigh_cost' value='<?= ($max_array['id']!='')?$max_array['id']:'0'  ?>'/>
        <input type="hidden" id='price_rangevalues'/>
      
        <div class="col-md-9 col-sm-12">
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
  $(document).ready(function () {
    $('body').delegate('.lblfilterChk','click', function(){
      get_price_filter_data('activity_result_array','3','0','0');
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
        console.log(item.best_lowest_cost);
    if(compare(amount,fromRange_cost,toRange_cost)){
      final_arr.push(item);
    }
  });
  get_price_filter_data_result(final_arr);
}

// Get Hotel results data
function get_price_filter_data(activity_result_array,type,fromRange_cost,toRange_cost){
  var base_url = $('#base_url').val();

  setTimeout(() => {
    var selected_value = document.getElementById(activity_result_array).value;
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
      
			var vehicle_type_array = [];
			var checkboxes = document.getElementsByName('vehicle_type');
			for (var checkbox of checkboxes) {
				if (checkbox.checked)
				vehicle_type_array.push(checkbox.value);
      }
      final_arr = (JSONItems).filter(function(a){
        return vehicle_type_array.includes(a.vehicle_type);
      });
      $('#selected_vehicle_type_array').val(vehicle_type_array);
      get_price_filter_data_result(final_arr);
    }
    else{
      var currency_id = $('#currency').val();
      get_currency_change(currency_id,JSONItems,fromRange_cost,toRange_cost,get_price_filter_data_result);    
    }
    
  }, 1000);
}
//Display Hotel results data 
function get_price_filter_data_result(final_arr){
  var base_url = $('#base_url').val();
  $.post(base_url+'Tours_B2B/view/activities/activity_results.php', { final_arr: final_arr }, function (data) {
    $('#activity_result_block').html(data);
	});
}
get_price_filter_data('activity_result_array','2','0','0');

///////////Debounce function for range slider////////////
function getSliderValue(){
  var ranges = $('.slider-input').val().split(',');
  
  $('.slider-input').attr({
    min: parseFloat(ranges[0]).toFixed(2),
    max: parseFloat(ranges[1]).toFixed(2)
  });
  if(ranges[0]!='' && ranges[1]!='' && ranges[0]!=='NaN' && ranges[1]!=='NaN'){
    get_price_filter_data('activity_result_array','4',ranges[0],ranges[1]);
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
  sessionStorage.setItem('activity_best_price',JSON.stringify(bestAmount_arr));
},100);
</script>