<?php
include '../../config.php';
include BASE_URL.'model/model.php';
include '../../layouts/header.php';
global $currency;

// $currency = $_SESSION['session_currency_id'];

$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));

$to_currency_rate = $sq_to['currency_rate'];



$b2b_agent_code = $_SESSION['b2b_agent_code'];

$tours_array = json_decode($_SESSION['tours_array']);

$pax = intval($tours_array[0]->adult) + intval($tours_array[0]->child_wobed) + intval($tours_array[0]->child_wibed) + intval($tours_array[0]->extra_bed) + intval($tours_array[0]->infant);

$costing_pax = intval($pax) - intval($tours_array[0]->infant);

$dest_id = $tours_array[0]->dest_id;

$tour_id = $tours_array[0]->tour_id;

$tour_group_id = $tours_array[0]->tour_group_id;

$seats_availability = $tours_array[0]->seats_availability;

//City Search

if($dest_id!=''){

  $row_dest = mysqli_fetch_assoc(mysqlQuery("select * from destination_master where dest_id = '$dest_id'"));

}

//Tour Name Search

if($tour_id!=''){

  $query = "select * from tour_master where tour_id = '$tour_id'";

  $row_tour = mysqli_fetch_assoc(mysqlQuery($query));

}

//Tour Name Search

if($tour_group_id!=''){

  $row_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id = '$tour_group_id'"));

}

$adults_count = $tours_array[0]->adult;

$child_wocount = $tours_array[0]->child_wobed;

$cwb_count = $tours_array[0]->child_wibed;

$extra_bed_count = $tours_array[0]->extra_bed;

$infant_count = $tours_array[0]->infant;
$total_pax = intval($adults_count) + intval($child_wocount) + intval($cwb_count) + intval($extra_bed_count)  +intval($infant_count);
?>

<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect">

  <div class="container">

    <div class="row">

      <div class="col-md-7 col-12">



        <!-- *** Search Head **** -->

        <div class="searchHeading">

          <span class="pageTitle">Group Tour</span>



          <div class="clearfix for-transfer">

            <?php if($dest_id != ''){ ?>

            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-pin-alt"></i>

                Destination: <strong><?= $row_dest['dest_name'] ?></strong>

              </span>

            </div>

            <?php } ?>

            <?php if($tour_id != ''){ ?>

            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-pin-alt"></i>

                Tour Name: <strong><?= $row_tour['tour_name'] ?></strong>

              </span>

            </div>

            <?php } ?>



          </div>



          <div class="clearfix">



            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-timetable"></i>

                Tour Date: <strong><?= ($tour_group_id!= '') ? date('d-m-Y',strtotime($row_group['from_date'])).' to '.date('d-m-Y',strtotime($row_group['to_date'])) : 'NA' ?></strong>

              </span>

            </div>



            <div class="sortSection">

              <span class="sortTitle st-search">

                <i class="icon it itours-person"></i>

                <?php echo $tours_array[0]->adult; ?> Adult(s), <?php echo $tours_array[0]->child_wobed + $tours_array[0]->child_wibed ; ?> Child(ren), <?php echo $tours_array[0]->extra_bed; ?> Extra Bed(s), <?php echo $tours_array[0]->infant; ?> Infant(s)

                <input type="hidden" id="total_passengers" value="<?= $tours_array[0]->adult.'-'.$tours_array[0]->child_wobed.'-'.$tours_array[0]->child_wibed.'-'.$tours_array[0]->extra_bed.'-'.$tours_array[0]->infant ?>"/>

              </span>

            </div>



          </div>



          <div class="clearfix">



            <div class="sortSection">

              <span class="sortTitle">

                <i class="icon it itours-sort-1"></i>

                Sort Tours by:

              </span>

              <div class="dropdown selectable">

                <button class="btn-dd dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                  Most Popular

                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                  <a class="dropdown-item" onClick="get_price_filter_data('tours_result_array','1','fromRange_cost','toRange_cost');"> Price - High to Low</a>

                  <a class="dropdown-item" onClick="get_price_filter_data('tours_result_array','2','fromRange_cost','toRange_cost');"> Price - Low to High</a>

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

            <a href="<?=BASE_URL_B2C?>">Home</a>

          </li>

          <li class="st-active">

            <a href="#">Group Tour Search Result</a>

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

                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#jsModifySearch_filter" aria-expanded="true" aria-controls="jsModifySearch_filter">

                Modify Search >> <span class="results_count"></span><?php echo ' available for '.$pax.' Pax'; ?>

                </button>

                <input type="hidden" value="<?= $pax ?>" id="total_pax"/>

              </div>

              <div id="jsModifySearch_filter" class="collapse show" aria-labelledby="jsModifySearch_filter" data-parent="#modifySearch_filter">

                <div class="card-body">

                <form id="frm_group_tours_search">

                  <div class="row">

                        <input type='hidden' id='page_type' value='search_page' name='search_page'/>

                        <!-- *** Destination Name *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <label>Select Destination</label>

                            <div class="c-select2DD">

                              <select id='gtours_dest_filter' class="full-width js-roomCount" onchange="group_tours_reflect(this.id);">

                                <?php if($dest_id!=''){?>

                                  <option value="<?php echo $row_dest['dest_id'] ?>"><?php echo $row_dest['dest_name'] ?></option>

                                  <?php  } ?>

                                <option value="">Destination</option>

                                <?php 

                                $sq_query = mysqlQuery("select * from destination_master where status != 'Inactive'"); 

                                while($row_dest = mysqli_fetch_assoc($sq_query)){ ?>

                                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>

                                <?php } ?>

                              </select>

                            </div>

                          </div>

                        </div>

                        <!-- *** Destination Name End *** -->

                        <!-- *** Tour Name *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <label>*Select Tour</label>

                            <div class="selector">

                                <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" title="Tour Name" onchange="tour_group_reflect(this.id);"> 

                                  <?php

                                    if($tour_id!=''){

                                      echo "<option value='$tour_id'>".$row_tour['tour_name']."</option>";

                                    }

                                    ?>

                                    <option value="">*Tour Name</option>

                                    <?php

                                        $sq = mysqlQuery("select tour_id,tour_name from tour_master where active_flag = 'Active' and dest_id = '$dest_id' and tour_id!='$tour_id' order by tour_name asc");

                                        while($row=mysqli_fetch_assoc($sq)){



                                          echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";

                                        }

                                    ?>

                                </select>

                            </div>

                          </div>

                        </div>

                        <!-- *** Destination Name End *** -->

                        <!-- *** tours date *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <label>*Select Tour Date</label>

                            <div class="selector">

                              <select class="form-control" id="cmb_tour_group" Title="Tour Date" name="cmb_tour_group" onchange="seats_availability_reflect();">

                                <?php

                                if($tour_group_id!=''){

                                  $row = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id='$tour_group_id'"));

                                  $group_id=$row['group_id'];

                                  $from_date=$row['from_date'];

                                  $to_date=$row['to_date'];

                                  $from_date=date("d-m-Y", strtotime($from_date));  

                                  $to_date=date("d-m-Y", strtotime($to_date));

                                  echo "<option value='$group_id'>".$from_date." to ".$to_date."</option>";

                                }

                                echo "<option value=''>*Tour Date</option>";

                                $today_date = strtotime(date('Y-m-d'));

                                $sq = mysqlQuery("select * from tour_groups where tour_id='$tour_id' and status!='Cancel' ");

                                while($row=mysqli_fetch_assoc($sq))

                                {

                                    $group_id=$row['group_id'];

                                    $from_date=$row['from_date'];

                                    $to_date=$row['to_date'];

                              

                                    $from_date=date("d-m-Y", strtotime($from_date));  

                                    $to_date=date("d-m-Y", strtotime($to_date)); 

                                

                                    $date1_ts = strtotime($from_date);

                                    if($flag == "false"){

                                        $val = (int)date_diff(date_create(date("d-m-Y")),date_create($to_date))->format("%R%a");

                                        if($val <= 0)  continue; // skipping the ended group tours (only used group quotation)

                                    }

                              

                                    if($today_date < $date1_ts){

                                      echo "<option value='$group_id'>".$from_date." to ".$to_date."</option>";

                                    }

                                } ?>

                              </select>

                            </div>

                          </div>

                        </div>

                        <!-- *** tours Name End *** -->

                        

                        <!-- *** Adult *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>*Adults</label>

                            <div class="selector">

                            <select name="gtadult" id='gtadult' class="full-width" required>

                                <option value='<?= $tours_array[0]->adult ?>'><?= $tours_array[0]->adult ?></option>

                                <?php for($m=0;$m<=10;$m++){

                                  if($m != $tours_array[0]->adult){ ?>

                                    <option value="<?= $m ?>"><?= $m ?></option>

                                <?php } } ?>

                            </select>

                            </div>

                        </div>

                        </div>

                        <!-- *** Adult End *** -->

                        <!-- *** Child W/o Bed *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>Child Without Bed(2-5 Yrs)</label>

                            <div class="selector">

                            <select name="gchild_wobed" id='gchild_wobed' class="full-width">

                                <option value='<?= $tours_array[0]->child_wobed ?>'><?= $tours_array[0]->child_wobed ?></option>

                                <?php for($m=0;$m<=10;$m++){

                                  if($m != $tours_array[0]->child_wobed){ ?>

                                    <option value="<?= $m ?>"><?= $m ?></option>

                                <?php } } ?>

                            </select>

                            </div>

                        </div>

                        </div>

                        <!-- *** Child W/o Bed End *** -->

                        <!-- *** Child With Bed *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>Child With Bed(5-12 Yrs)</label>

                            <div class="selector">

                            <select name="gchild_wibed" id='gchild_wibed' class="full-width">

                                <option value='<?= $tours_array[0]->child_wibed ?>'><?= $tours_array[0]->child_wibed ?></option>

                                <?php for($m=0;$m<=10;$m++){

                                  if($m != $tours_array[0]->child_wibed){ ?>

                                    <option value="<?= $m ?>"><?= $m ?></option>

                                <?php } } ?>

                            </select>

                            </div>

                        </div>

                        </div>

                        <!-- *** Child With Bed End *** -->

                        <!-- *** Extra Bed *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>Extra Bed</label>

                            <div class="selector">

                            <select name="gextra_bed" id='gextra_bed' class="full-width">

                                <option value='<?= $tours_array[0]->extra_bed ?>'><?= $tours_array[0]->extra_bed ?></option>

                                <?php for($m=0;$m<=10;$m++){

                                    if($m != $tours_array[0]->extra_bed){ ?>

                                    <option value="<?= $m ?>"><?= $m ?></option>

                                <?php } } ?>

                            </select>

                            </div>

                        </div>

                        </div>

                        <!-- *** Extra Bed End *** -->

                        <!-- *** Infant *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                        <div class="form-group">

                            <label>Infants(0-2 Yrs)</label>

                            <div class="selector">

                            <select name="gtinfant" id='gtinfant' class="full-width">

                                <option value='<?= $tours_array[0]->infant ?>'><?= $tours_array[0]->infant ?></option>

                                <?php for($m=0;$m<=10;$m++){

                                    if($m != $tours_array[0]->infant){ ?>

                                    <option value="<?= $m ?>"><?= $m ?></option>

                                <?php } } ?>

                            </select>

                            </div>

                        </div>

                        </div>

                        <!-- *** Infant End *** -->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                            <button class="c-button lg colGrn m20-top">

                                <i class="icon itours-search"></i> SEARCH NOW

                            </button>

                        </div>

                        <div class="col-md-6 col-sm-6 col-12">

                          <div class="form-group">

                            <div id="seats_availability" class="m20-top"><?= $seats_availability ?></div>

                          </div>

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

      </div>

      <!-- ***** Tours Listing Filter End ***** -->



      <?php

        $tours_result_array = array();

        $final_arr = array();



        $actual_ccosts_array = array();

        $all_costs_array = array();

        if($query!=''){

          $sq_query = mysqlQuery($query);

          while(($row_query  = mysqli_fetch_assoc($sq_query))){

              $hotels_array = array();
              $train_array = array();
              $flight_array = array();
              $cruise_array = array();
              $program_array = array();

              $package_id = $row_query['package_id'];

              $currency_id = $currency;

              $taxation = json_decode($row_query['taxation']);

              $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_name from destination_master where dest_id = '$row_query[dest_id]' and status!='Inactive'"));
              $sq_terms = mysqli_fetch_assoc(mysqlQuery("select terms_and_conditions from terms_and_conditions where type = 'Group Quotation' and active_flag!='Inactive'"));

              $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency_id'"));
              $from_currency_rate = $sq_from['currency_rate'];

              //Single package Image
              if($row_query['dest_image'] != '0'){

                $row_gallary = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id = '$row_query[dest_image]'"));
                $url = $row_gallary['image_url'];
                $pos = strstr($url,'uploads');
                $entry_id =$row_gallary['entry_id'];

                if ($pos != false)   {
                  $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 
                  $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                }
                else{
                  $newUrl =  $row_gallary['image_url']; 
                }
              }else{

                $sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select * from default_package_images where dest_id='$row_query[dest_id]'"));

                if($sq_singleImage['image_url']!=''){

                    $image = $sq_singleImage['image_url'];

                    $pos = strstr($url,'uploads');

                    if ($pos != false){

                        $newUrl1 = preg_replace('/(\/+)/','/',$image); 

                        $newUrl = BASE_URL.str_replace('../', '', $newUrl1);

                    }

                    else{

                        $newUrl =  $image; 

                    }

                }else{

                    $newUrl = BASE_URL_B2C.'images/dummy-image.jpg';

                }

              }

              //Group Hotels

              $sq_hotel = mysqlQuery("select * from group_tour_hotel_entries where tour_id = '$row_query[tour_id]'");

              while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

                $sq_hcity = mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id = '$row_hotel[city_id]'"));

                $sq_hhotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name,hotel_id from hotel_master where hotel_id = '$row_hotel[hotel_id]'"));

                array_push($hotels_array,array(

                  'city' => $sq_hcity['city_name'],

                  'hotel' => $sq_hhotel['hotel_name'],

                  'hotel_type' => $row_hotel['hotel_type'],

                  'nights' => $row_hotel['total_nights'],

                ));

              }

              //Group Train

              $sq_trans = mysqlQuery("select * from group_train_entries where tour_id = '$row_query[tour_id]'");

              while($row_trans = mysqli_fetch_assoc($sq_trans)){

                array_push($train_array,array(

                  'from_location' => $row_trans['from_location'],

                  'to_location' => $row_trans['to_location'],

                  'class' => $row_trans['class'],

                ));

              }

              //Group flight

              $sq_trans = mysqlQuery("select * from group_tour_plane_entries where tour_id = '$row_query[tour_id]'");

              while($sq_tourgrp = mysqli_fetch_assoc($sq_trans)){

                $sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$sq_tourgrp[airline_name]'"));

                $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$sq_tourgrp[from_city]'"));

                $sq_city1 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$sq_tourgrp[to_city]'"));

                array_push($flight_array,array(

                  'from_location' => $sq_city['city_name'].' ('.$sq_tourgrp['from_location'].')',

                  'to_location' => $sq_city1['city_name'].' ('.$sq_tourgrp['to_location'].')',

                  'airline' => $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')',

                  'class' => $sq_tourgrp['class'],

                ));

              }

              //Group cruise

              $sq_trans = mysqlQuery("select * from group_cruise_entries where tour_id = '$row_query[tour_id]'");

              while($sq_tourgrp = mysqli_fetch_assoc($sq_trans)){



                array_push($cruise_array,array(

                  'route' => $sq_tourgrp['route'],

                  'cabin' => $sq_tourgrp['cabin'],

                ));

              }

              //Group Program

              $sq_prg = mysqlQuery("select * from group_tour_program where tour_id = '$row_query[tour_id]'");

              while($row_prg = mysqli_fetch_assoc($sq_prg)){

                array_push($program_array,array(

                  'attraction' => $row_prg['attraction'],

                  'day_wise_program' => $row_prg['day_wise_program'],

                  'stay' => $row_prg['stay'],

                  'meal_plan' => $row_prg['meal_plan'],

                ));

              }

              

              //Group Costing

              $adult_cost = $row_query['adult_cost'];
              $child_without_cost = $row_query['child_without_cost'];
              $child_with_cost = $row_query['child_with_cost'];
              $with_bed_cost = $row_query['with_bed_cost'];
              $infant_cost = $row_query['infant_cost'];
              $single_person_cost = $row_query['single_person_cost'];

              $adult_cost_total = 0;
              $child_without_cost_total = 0;
              $child_with_cost_total = 0;
              $with_bed_cost_total = 0;
              $infant_cost_total = 0;
              $sp_cost_total = 0;
              if($total_pax == 1){
                $sp_cost_total = $single_person_cost;
              }else{
                $adult_cost_total = intval($adults_count) * floatval($adult_cost);
                $child_without_cost_total = intval($child_wocount) * floatval($child_without_cost);
                $child_with_cost_total = intval($cwb_count) * floatval($child_with_cost);
                $with_bed_cost_total = intval($extra_bed_count) * floatval($with_bed_cost);
                $infant_cost_total = intval($infant_count) * floatval($infant_cost);
                $sp_cost_total = 0;
              }

              $total_cost1 = floatval($adult_cost_total) + floatval($child_without_cost_total) + floatval($child_with_cost_total) + floatval($with_bed_cost_total) + floatval($infant_cost_total) + floatval($sp_cost_total);
              $total_cost1 = ceil($total_cost1);
              array_push($all_costs_array,array('amount' => $total_cost1,'id'=>$currency_id));
              $c_amount1 = ($to_currency_rate!=0) ? $from_currency_rate / $to_currency_rate * $total_cost1 : 0;
              array_push($actual_ccosts_array,$c_amount1);

              //Final cost push into array
              array_push($tours_result_array,array(

                'image' => $newUrl,

                "tour_id"=>$row_query['tour_id'],

                'group_id'=>$tour_group_id,

                "tour_name"=>$row_tour['tour_name'],

                "dest_name"=>$sq_dest['dest_name'],

                'adult_count'=>intval($adults_count),

                'child_wocount'=>intval($child_wocount),

                'child_wicount'=>intval($cwb_count),

                'extra_bed_count'=>intval($extra_bed_count),

                'infant_count'=>intval($infant_count),

                'adult_cost'=>floatval($adult_cost_total),
                'sp_cost_total'=>floatval($sp_cost_total),

                'child_wo_cost'=>floatval($child_without_cost_total),

                'child_wi_cost'=>floatval($child_with_cost_total),

                'with_bed_cost'=>floatval($with_bed_cost_total),

                'infant_cost'=>floatval($infant_cost_total),

                "total_cost"=>$total_cost1,

                'taxation'=>$taxation,

                'travel_date' => date('d-m-Y',strtotime($row_group['from_date'])).' to '.date('d-m-Y',strtotime($row_group['to_date'])),

                'total_days' => $row_query['total_days'],

                'inclusions'=>$row_query['inclusions'],

                'exclusions'=> $row_query['exclusions'],

                'terms'=>$sq_terms['terms_and_conditions'],

                "currency_id" => $currency_id,

                "best_lowest_cost"=>array('id'=>$currency_id,

                                          'cost'=>$total_cost1),

                "hotels_array" =>$hotels_array,

                "train_array"=>$train_array,

                "flight_array"=>$flight_array,

                "cruise_array"=>$cruise_array,

                "program_array"=>$program_array

              ));



          }

        }

        $mint = (sizeof($actual_ccosts_array) > 0) ? min($actual_ccosts_array) : 0;

        $maxt = (sizeof($actual_ccosts_array) > 0) ? max($actual_ccosts_array) : 0;

        $all_costs_array1 = $array_master->array_column($all_costs_array, 'amount');

        $min_array = (sizeof($all_costs_array) > 0) ? $all_costs_array[array_search(min($all_costs_array), $all_costs_array)] : [];

        $max_array = (sizeof($all_costs_array) > 0) ? $all_costs_array[array_search(max($all_costs_array), $all_costs_array)] : [];
        ?>

        <input type='hidden' value='<?= json_encode($tours_result_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='tours_result_array' name='tours_result_array'/>

        <input type='hidden' class='best-cost-currency' id='bestlow_cost' value='<?= $mint ?>'/>

        <input type='hidden' class='best-cost-currency' id='besthigh_cost' value='<?= $maxt ?>'/>

        <input type='hidden' class='best-cost-id' id='bestlow_cost' value='<?= $min_array['id'] ?>'/>

        <input type='hidden' class='best-cost-id' id='besthigh_cost' value='<?= $max_array['id']  ?>'/>

        <input type="hidden" id='price_rangevalues'/>

      

        <div class="col-md-9 col-sm-12">

            <div id="tours_result_block">



            </div>

        </div>

      <!-- ***** Tours Listing End ***** -->

    </div>

  </div>

</div>

<!-- ********** Component :: Tours Listing End ********** -->

<?php include '../../layouts/footer.php'; ?>

<script type="text/javascript" src="js/index.js"></script>

<script type="text/javascript" src="../../js/scripts.js"></script>

<script type="text/javascript" src="../../js/jquery.range.min.js"></script>

<script type="text/javascript" src="../../js/pagination.min.js"></script>

<script>

if('<?= $tour_id ?>' == ''){

  group_tours_reflect('tours_dest_filter');

}

if('<?= $tour_group_id ?>' != ''){  seats_availability_reflect(); }



/////// Next 10th day onwards date display

var tomorrow = new Date();

tomorrow.setDate(tomorrow.getDate()+10);

var day = tomorrow.getDate();

var month = tomorrow.getMonth() + 1

var year = tomorrow.getFullYear();

$('#travelDate').datetimepicker({ timepicker:false,format:'m/d/Y',minDate:tomorrow });



  // $('#travelDate').datetimepicker({ timepicker:false,format:'m/d/Y',minDate:new Date() });

  $(document).ready(function () {

    $('body').delegate('.lblfilterChk','click', function(){

      get_price_filter_data('tours_result_array','3','0','0');

    })

  });

// Get currency changed values in hotel result

function get_currency_change(currency_id,JSONItems,fromRange_cost,toRange_cost,get_price_filter_data_result){

  

  var final_arr = [];

  console.log(JSONItems)

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



// Get tours results data

function get_price_filter_data(tours_result_array,type,fromRange_cost,toRange_cost){



  setTimeout(() => {

    var selected_value = document.getElementById(tours_result_array).value;

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

        if(a.best_lowest_cost.id == null){

          a.best_lowest_cost.id = '0';

          a.best_lowest_cost.cost = 0;

        }

        if(b.best_lowest_cost.id == null){

          b.best_lowest_cost.id = '0';

          b.best_lowest_cost.cost = 0;

        }

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

        if(a.best_lowest_cost.id == null){

          a.best_lowest_cost.id = '0';

          a.best_lowest_cost.cost = 0;

        }

        if(b.best_lowest_cost.id == null){

          b.best_lowest_cost.id = '0';

          b.best_lowest_cost.cost = 0;

        }

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

//Display tours results data 

function get_price_filter_data_result(final_arr){

  var base_url = $('#base_url').val();

  $.post('tours_results.php', { final_arr: final_arr }, function (data) {

    $('#tours_result_block').html(data);

	});

}

get_price_filter_data('tours_result_array','2','0','0');



///////////Debounce function for range slider////////////

function getSliderValue(){

  var ranges = $('.slider-input').val().split(',');

  

  $('.slider-input').attr({

    min: parseFloat(ranges[0]).toFixed(2),

    max: parseFloat(ranges[1]).toFixed(2)

  });

  if(ranges[0]!='' && ranges[1]!='' && ranges[0]!=='NaN' && ranges[1]!=='NaN'){

    get_price_filter_data('tours_result_array','4',ranges[0],ranges[1]);

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

  sessionStorage.setItem('tours_best_price',JSON.stringify(bestAmount_arr));

},100);

</script>

