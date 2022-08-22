<?php
include '../../model/model.php';
$cart_list_arr = ($_POST['cart_list_arr']!='')?$_POST['cart_list_arr']:[];
$coupon_list_arr = array();
$hotel_list_arr = array();
$transfer_list_arr = array();
$activity_list_arr = array();
$tours_list_arr = array();
$ferry_list_arr = array();
$unique_timestamp =  md5(uniqid());
for($i=0;$i<sizeof($cart_list_arr);$i++){
  if($cart_list_arr[$i]['service']['name'] == 'Hotel'){
    array_push($hotel_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]['service']['name'] == 'Transfer'){
    array_push($transfer_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]['service']['name'] == 'Activity'){
    array_push($activity_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]['service']['name'] == 'Combo Tours'){
    array_push($tours_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]['service']['name'] == 'Ferry'){
    array_push($ferry_list_arr,$cart_list_arr[$i]);
  }
}
//Get default currency rate
$currency = $_POST['currency'];
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];
?>
      <!-- ********** Component :: Listing  ********** -->
      <div class="c-containerDark">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-sm-12">
              <?php
              if(sizeof($hotel_list_arr)>0){ ?>
                <!-- ***** Hotel Listing ***** -->
                  <div class="c-cartContainer m20-btm">
                    <div class="cartHeading">

                    <div class="row align-items-center">
                      <div class="col-8">Hotel Details</div>
                      <div class="col-4 text-right">
                      <button id="avail_button" title="Check Availability" data-toggle="tooltip" class="c-button md colDark"  value="Payment" onclick="check_availability();">Check Availability</button>
                      </div>
                    </div>
                  </div>
                  <div class="cartBody">
                    <?php
                    $price_total = 0;
                    $tax_total = 0;
                    $hotel_total = 0;
                    for($i=0;$i<sizeof($hotel_list_arr);$i++){

                      $hotel_id = $hotel_list_arr[$i]['service']['id'];
                      //Applied Tax
                      $tax_arr = explode(',',$hotel_list_arr[$i]['service']['hotel_arr']['tax']);
                      ?>
                      <!-- **** Shopping Cart Item ****  -->
                      <div class="cartItem">
                        <div class="row">
                          <!-- **** Cart Image ****  -->
                          <div class="col-3">
                            <div class="cartImage">
                              <img src="<?= $hotel_list_arr[$i]['service']['hotel_arr']['newUrl'] ?>" loading="lazy" alt="<?php echo $hotel_list_arr[$i]['service']['hotel_arr']['hotel_name']; ?>"/>
                            </div>
                          </div>
                          <!-- **** Cart Image End ****  -->

                          <!-- **** Cart Data ****  -->
                          <div class="col-9 p0-left">
                            <div class="cartInfo">
                              <!-- **** Cart Header ****  -->
                              <div class="cartHeader">
                                <span class="itemTitle"><?= stripslashes($hotel_list_arr[$i]['service']['hotel_arr']['hotel_name']) ?></span>
                                <button class="deleteHotel" onclick="remove_item('<?= $hotel_list_arr[$i]['service']['uuid'] ?>')"></button>
                                <div class="infoSection">
                                  <span class="cardInfoLine cust">
                                    <i class="icon it itours-calendar"></i>
                                    Check In:
                                    <strong><?= $hotel_list_arr[$i]['service']['check_in'] ?></strong>
                                  </span>
                                  <span class="cardInfoLine cust">
                                    <i class="icon it itours-calendar"></i>
                                    Check Out:
                                    <strong><?= $hotel_list_arr[$i]['service']['check_out'] ?></strong>
                                  </span>
                                </div>
                              </div>
                              <!-- **** Cart Header End ****  -->
                              <?php
                              $tax_amount = 0;
                              for($j=0;$j<sizeof($hotel_list_arr[$i]['service']['item_arr']);$j++){
                                $room_types = explode('-',$hotel_list_arr[$i]['service']['item_arr'][$j]);
                                $room_no = $room_types[0];
                                $room_cat = $room_types[1];
                                $room_cost = $room_types[2];
                                $h_currency_id = $room_types[3];
                                
                                $tax_arr1 = explode('+',$tax_arr[0]);
                                for($t=0;$t<sizeof($tax_arr1);$t++){
                                  if($tax_arr1[$t]!=''){
                                    $tax_arr2 = explode(':',$tax_arr1[$t]);
                                    if($tax_arr2[2] == "Percentage"){
                                      $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                    }else{
                                      $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                                    }
                                  }
                                }
                                $total_amount = $room_cost + $tax_amount;
                                //Convert into default currency
                                $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                                $from_currency_rate = $sq_from['currency_rate'];
                                $room_cost1 = ($to_currency_rate!='')?($from_currency_rate / $to_currency_rate * $room_cost) : 0;
                                $tax_amount1 = ($to_currency_rate!='')?($from_currency_rate / $to_currency_rate * $tax_amount) : 0;
                                $total_amount1 = ($to_currency_rate!='')?($from_currency_rate / $to_currency_rate * $total_amount) : 0;

                                $price_total += $room_cost1;
                                $tax_total += $tax_amount1;
                                $hotel_total += $total_amount1;
                              ?>
                              <!-- **** Hotel Room Item ****  -->
                              <div class="roomType">
                                <div class="rHeading"><?= $room_no ?></div>
                                <div class="roomTitle clearfix">
                                  <span class="s1"><?= $room_cat ?></span>
                                  <span class="s2"><span class='currency-icon'></span>
                                  <span class='c-hide checkoutt-currency-id'><?= $h_currency_id ?></span>
                                  <span class='checkoutt-currency-price'><?= $total_amount ?></span></span>
                                </div>
                                <div class="rData">
                                  <div class="infoSection">
                                    <span class="cardInfoLine noicon">
                                      Amount:
                                      <span class='currency-icon'></span>
                                      <span class='c-hide checkoutp-currency-id'><?= $h_currency_id ?></span>
                                      <strong class='checkoutp-currency-price'><?= $room_cost ?></strong>
                                    </span>
                                    <span class="cardInfoLine noicon">
                                      Tax:
                                      <span class='currency-icon'></span>
                                      <span class='c-hide checkouttax-currency-id'><?= $h_currency_id ?></span>
                                      <strong class='checkouttax-currency-price'><?= $tax_amount ?></strong>
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <!-- **** Hotel Room Item End ****  -->
                              <?php
                                $tax_amount = 0;
                                $total_amount = 0; 
                              }
                              ?>
                            </div>
                          </div>
                          <!-- **** Cart Data End ****  -->
                          <!-- **** Shopping Cart Item End ****  -->
                        </div>
                      </div>
                      <!-- **** Shopping Cart Item End****  -->
                      <?php
                      $coupon_arr = ($hotel_list_arr[$i]['service']['hotel_arr']['coupon_info_arr'])?$hotel_list_arr[$i]['service']['hotel_arr']['coupon_info_arr']:[];
                      for($j=0;$j<sizeof($coupon_arr);$j++){
                          array_push($coupon_list_arr,$coupon_arr[$j]);
                      }
                    } ?>
                    </div>
                  </div>
                <!-- ***** Hotel Listing End ***** -->
              <?php } ?>
              <?php if(sizeof($transfer_list_arr)>0){ ?>
                <!-- **** Transfer Listing **** -->
                <div class="c-cartContainer m20-btm">
                    <div class="cartHeading">Transfer Details</div>
                    <div class="cartBody">
                      <?php
                      $trans_basic_tottal = 0;
                      $trans_tax_total = 0;
                      $trans_total = 0;
                      for($i=0;$i<sizeof($transfer_list_arr);$i++){
                        $tax_amount = 0;
                        //Transfer costing
                        $room_cost_arr = explode('-',$transfer_list_arr[$i]['service']['service_arr'][0]['transfer_cost']);
                        $taxation_arr = explode(',',$transfer_list_arr[$i]['service']['service_arr'][0]['taxation']);
                        $room_cost = $room_cost_arr[0];
                        $h_currency_id = $room_cost_arr[1];
                        
                        $tax_arr1 = explode('+',$taxation_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                          if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                              $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                              $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                          }
                        }

                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                        $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                        $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                        $trans_basic_tottal += $room_cost1;
                        $trans_tax_total += $tax_amount1;
                        $trans_total += $total_amount1;
                        //Pickup n drop location
                        $pickup_id = $transfer_list_arr[$i]['service']['service_arr'][0]['pickup_from'];
                        if($transfer_list_arr[$i]['service']['service_arr'][0]['pickup_type'] == 'city'){
                          $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$pickup_id'"));
                          $pickup = $row['city_name'];
                        }
                        else if($transfer_list_arr[$i]['service']['service_arr'][0]['pickup_type'] == 'hotel'){
                          $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$pickup_id'"));
                          $pickup = $row['hotel_name'];
                        }
                        else{
                          $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$pickup_id'"));
                          $airport_nam = clean($row['airport_name']);
                          $airport_code = clean($row['airport_code']);
                          $pickup = $airport_nam." (".$airport_code.")";
                        }
                        //Drop-off
                        $drop_id = $transfer_list_arr[$i]['service']['service_arr'][0]['drop_to'];
                        if($transfer_list_arr[$i]['service']['service_arr'][0]['drop_type'] == 'city'){
                          $row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$drop_id'"));
                          $drop = $row['city_name'];
                        }
                        else if($transfer_list_arr[$i]['service']['service_arr'][0]['drop_type'] == 'hotel'){
                          $row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$drop_id'"));
                          $drop = $row['hotel_name'];
                        }
                        else{
                          $row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$drop_id'"));
                          $airport_nam = clean($row['airport_name']);
                          $airport_code = clean($row['airport_code']);
                          $drop = $airport_nam." (".$airport_code.")";
                        }
                        $round_class = ($transfer_list_arr[$i]['service']['service_arr'][0]['trip_type'] == 'oneway') ? '' : 'round';
                      ?>
                      <!-- **** Shopping Cart Item **** -->
                      <div class="cartItem">
                        <div class="row">
                          <!-- **** Cart Image **** -->
                          <div class="col-3">
                            <div class="cartImage">
                            <img src="<?= $transfer_list_arr[$i]['service']['service_arr'][0]['image'] ?>" alt="iTours" />
                            </div>
                          </div>
                          <!-- **** Cart Image End **** -->
                        
                          <!-- **** Cart Data **** -->
                          <div class="col-9 p0-left">
                            <div class="cartInfo">
                              <!-- **** Cart Header **** -->
                              <div class="cartHeader">
                                <span class="itemTitle"><?= $transfer_list_arr[$i]['service']['service_arr'][0]['vehicle_name'] ?></span>
                                <button class="deleteHotel" onclick="remove_item('<?= $transfer_list_arr[$i]['service']['uuid'] ?>')"></button>
                              
                                <div class="infoSection">
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-person"></i>
                                Passengers: 
                                <strong><?= $transfer_list_arr[$i]['service']['service_arr'][0]['passengers'] ?></strong>
                                </span>
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-taxi"></i>
                                No.Of Vehicles:
                                <strong><?= $transfer_list_arr[$i]['service']['service_arr'][0]['no_of_vehicles'] ?></strong>
                                </span>
                                </div>
                                
                                <div class="infoSection">
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-pin-alt"></i>
                                Pickup Location:
                                <strong><?= $pickup ?></strong>
                                </span>
                                <div class="sortIcon <?= $round_class ?>"></div>
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-pin-alt"></i>
                                Dropoff Location:
                                <strong><?= $drop ?></strong>
                                </span>
                                </div>
                              
                                <div class="infoSection">
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-calendar"></i>
                                Pickup Date & Time:
                                <strong><?= $transfer_list_arr[$i]['service']['service_arr'][0]['pickup_date'] ?></strong>
                                </span>
                                <?php if($transfer_list_arr[$i]['service']['service_arr'][0]['trip_type'] == "roundtrip"){ ?>
                                  <span class="cardInfoLine cust">
                                  <i class="icon it itours-calendar"></i>
                                  Return Date & Time:
                                  <strong><?= $transfer_list_arr[$i]['service']['service_arr'][0]['return_date'] ?></strong>
                                  </span>
                                <?php } ?>
                                </div>
                              </div>
                              <!-- **** Cart Header End **** -->
                          
                              <!-- **** Transfer Room Item **** -->
                              <div class="roomType">
                                <div class="roomTitle clearfix">
                                  <div class="rHeading"><?= $transfer_list_arr[$i]['service']['service_arr'][0]['vehicle_type'] ?></div>
                                    <span class="s1">Total Cost</span>
                                    <span class="s2"><span class='currency-icon'></span>
                                    <span class='c-hide checkoutt-currency-id'><?= $h_currency_id ?></span>
                                    <span class='checkoutt-currency-price'><?= $total_amount ?></span></span>
                                </div>
                                <div class="rData">
                                  <div class="infoSection">
                                  <span class="cardInfoLine noicon">
                                    Amount:
                                    <span class='currency-icon'></span>
                                    <span class='c-hide checkoutp-currency-id'><?= $h_currency_id ?></span>
                                    <strong class='checkoutp-currency-price'><?= $room_cost ?></strong>
                                  </span>
                                  <span class="cardInfoLine noicon">
                                    Tax:
                                    <span class='currency-icon'></span>
                                    <span class='c-hide checkouttax-currency-id'><?= $h_currency_id ?></span>
                                    <strong class='checkouttax-currency-price'><?= $tax_amount ?></strong>
                                  </span>
                                  <span class="cardInfoLine noicon pull-right m0">
                                    <a href="#" onclick="get_transfer_cancellation('<?php echo $transfer_list_arr[$i]['service']['id']; ?>');">Cancellation Policy</a>
                                  </span>
                                  </div>
                                </div>
                              </div>
                              <!-- **** Transfer Item End **** -->
                            </div>
                          </div>
                          <!-- **** Cart Data End **** -->
                        </div>
                      </div>
                      <!-- **** Shopping Cart Item End **** -->
                      <?php } ?>
                      <div id="cancellation_modal"></div>
                    </div>
                </div>
                <!-- ***** Transfer Listing End ***** -->
              <?php } ?>
              <?php if(sizeof($activity_list_arr)>0){ ?>
                <!-- ***** Activity Listing ***** -->
                  <div class="c-cartContainer m20-btm">
                    <div class="cartHeading">Activity Details</div>
                    <div class="cartBody">
                      <?php
                      for($i=0;$i<sizeof($activity_list_arr);$i++){

                        $exc_id = $activity_list_arr[$i]['service']['service_arr'][0]['id'];
                        $sq_exc = mysqli_fetch_assoc(mysqlQuery("select timing_slots from excursion_master_tariff where entry_id='$exc_id'"));
                        $timing_slots = json_decode($sq_exc['timing_slots']);
                        ?>
                      <!-- **** Shopping Cart Item ****  -->
                      <div class="cartItem">
                        <div class="row">
                          <!-- **** Cart Image ****  -->
                          <div class="col-3">
                            <div class="cartImage">
                              <img src="<?= $activity_list_arr[$i]['service']['service_arr'][0]['image'] ?>" loading="lazy" alt="<?php echo $activity_list_arr[$i]['service']['service_arr'][0]['act_name']; ?>"/>
                            </div>
                          </div>
                          <!-- **** Cart Image End ****  -->

                          <!-- **** Cart Data ****  -->
                          <div class="col-9 p0-left">
                            <div class="cartInfo">
                              <!-- **** Cart Header ****  -->
                              <div class="cartHeader">
                                <span class="itemTitle"><?= $activity_list_arr[$i]['service']['service_arr'][0]['act_name'] ?></span>
                                <button class="deleteHotel" onclick="remove_item('<?= $activity_list_arr[$i]['service']['uuid'] ?>')"></button>
                                <div class="infoSection">
                                  <span class="cardInfoLine cust">
                                    <i class="icon it itours-calendar"></i>
                                    Check Date:
                                    <strong><?= get_date_user($activity_list_arr[$i]['service']['service_arr'][0]['checkDate']) ?></strong>
                                  </span>
                                  <span class="cardInfoLine cust">
                                    <i class="icon it itours-person"></i>
                                    Total Guest:
                                    <strong><?= $activity_list_arr[$i]['service']['service_arr'][0]['total_pax'] ?></strong>
                                  </span>
                                </div>
                                <div class="infoSection">
                                  <span class="cardInfoLine cust">
                                    <i class="icon it itours-clock"></i>
                                    Reporting Time:
                                    <strong><?= $activity_list_arr[$i]['service']['service_arr'][0]['rep_time'] ?></strong>
                                  </span>
                                  <span class="cardInfoLine cust">
                                    <i class="icon it itours-pin-alt"></i>
                                    Pickup Point:
                                    <strong><?= $activity_list_arr[$i]['service']['service_arr'][0]['pick_point'] ?></strong>
                                  </span>
                                </div>
                              </div>
                              <!-- **** Cart Header End ****  -->
                              <?php
                              $tax_amount = 0;
                              $taxation_arr = explode(',',$activity_list_arr[$i]['service']['service_arr'][0]['taxation']);
                              $transfer_type = explode('-',$activity_list_arr[$i]['service']['service_arr'][0]['transfer_type']);
                              $room_cost = $transfer_type[1];
                              $h_currency_id = $transfer_type[2];
                              
                              $tax_arr1 = explode('+',$taxation_arr[0]);
                              for($t=0;$t<sizeof($tax_arr1);$t++){
                                if($tax_arr1[$t]!=''){
                                  $tax_arr2 = explode(':',$tax_arr1[$t]);
                                  if($tax_arr2[2] === "Percentage"){
                                    $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                  }else{
                                    $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                                  }
                                }
                              }
                              
                              $total_amount = $room_cost + $tax_amount;
                              
                              //Convert into default currency
                              $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                              $from_currency_rate = $sq_from['currency_rate'];
                              $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                              $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                              $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);
                              
                              $actprice_total += $room_cost1;
                              $acttax_total += $tax_amount1;
                              $activity_total += $total_amount1;
                              ?>
                              <!-- **** Transfer Room Item **** -->
                              <div class="roomType">
                                <div class="roomTitle clearfix">
                                  <div class="rHeading"><?= $transfer_type[0] ?></div>
                                    <!-- <span class="s1">Total Cost</span> -->
                                    
                                  <div class="infoSection m0">
                                    <?php if((int)$timing_slots != 0 && sizeof($timing_slots) != 0){ ?>
                                    <span class="cardInfoLine noicon">
                                      <select id="timing_slot<?=$i?>" title="Select Timing Slot" class="pad0">
                                        <option value="">Select Timing Slot</option>
                                        <?php for($t=0;$t<sizeof($timing_slots);$t++){?>
                                          <option value="<?= $timing_slots[$t]->from_time.' To '.$timing_slots[$t]->to_time ?>"><?= $timing_slots[$t]->from_time.' To '.$timing_slots[$t]->to_time ?></option>
                                        <?php } ?>
                                      </select>
                                    </span>
                                    <?php } ?>
                                    <span class="s2"><span class='currency-icon'></span>
                                    <span class='c-hide checkoutt-currency-id'><?= $h_currency_id ?></span>
                                    <span class='checkoutt-currency-price'><?= $total_amount ?></span></span>
                                    </div>
                                </div>
                                <div class="rData">
                                  <div class="infoSection">
                                  <span class="cardInfoLine noicon">
                                    Amount:
                                    <span class='currency-icon'></span>
                                    <span class='c-hide checkoutp-currency-id'><?= $h_currency_id ?></span>
                                    <strong class='checkoutp-currency-price'><?= $room_cost ?></strong>
                                  </span>
                                  <span class="cardInfoLine noicon">
                                    Tax:
                                    <span class='currency-icon'></span>
                                    <span class='c-hide checkouttax-currency-id'><?= $h_currency_id ?></span>
                                    <strong class='checkouttax-currency-price'><?= $tax_amount ?></strong>
                                  </span>
                                  </div>
                                </div>
                              </div>
                              <!-- **** Transfer Item End **** -->
                            </div>
                          </div>
                          <!-- **** Cart Data End ****  -->
                          <!-- **** Shopping Cart Item End ****  -->
                        </div>
                      </div>
                      <!-- **** Shopping Cart Item End****  -->
                    <?php
                    $coupon = ($activity_list_arr[$i]['service']['service_arr'][0]['coupon']!='')?$activity_list_arr[$i]['service']['service_arr'][0]['coupon']:[];
                      for($j=0;$j<sizeof($coupon);$j++){
                          array_push($coupon_list_arr,$coupon['coupon_info_arr'][$j]);
                      }
                    } ?>
                    </div>
                  </div>
                <!-- ***** Hotel Listing End ***** -->
              <?php } ?>
              <?php if(sizeof($tours_list_arr)>0){ ?>
                <!-- **** Transfer Listing **** -->
                <div class="c-cartContainer m20-btm">
                    <div class="cartHeading">Holiday Details</div>
                    <div class="cartBody">
                      <?php
                      $tours_basic_tottal = 0;
                      $tours_tax_total = 0;
                      $tours_total = 0;
                      for($i=0;$i<sizeof($tours_list_arr);$i++){
                        $tax_amount = 0;
                        //Transfer costing
                        $room_cost_arr = explode('-',$tours_list_arr[$i]['service']['service_arr'][0]['transfer_cost']);
                        $taxation_arr = explode(',',$tours_list_arr[$i]['service']['service_arr'][0]['taxation']);
                        $package_item = explode('-',$tours_list_arr[$i]['service']['service_arr'][0]['package_type']);
                        $room_cost = $package_item[1];
                        $h_currency_id = $package_item[2];

                        $tax_arr1 = explode('+',$taxation_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                          if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                              $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                              $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                          }
                        }
                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $room_cost1 = ($to_currency_rate!='') ?($from_currency_rate / $to_currency_rate * $room_cost) : 0;
                        $tax_amount1 = ($to_currency_rate!='') ?($from_currency_rate / $to_currency_rate * $tax_amount) : 0;
                        $total_amount1 = ($to_currency_rate!='') ?($from_currency_rate / $to_currency_rate * $total_amount) : 0;

                        $tours_basic_tottal += $room_cost1;
                        $tours_tax_total += $tax_amount1;
                        $tours_total += $total_amount1;
                      ?>
                      <!-- **** Shopping Cart Item **** -->
                      <div class="cartItem">
                        <div class="row">
                          <!-- **** Cart Image **** -->
                          <div class="col-3">
                            <div class="cartImage">
                            <img src="<?= $tours_list_arr[$i]['service']['service_arr'][0]['image'] ?>" alt="iTours" />
                            </div>
                          </div>
                          <!-- **** Cart Image End **** -->
                        
                          <!-- **** Cart Data **** -->
                          <div class="col-9 p0-left">
                            <div class="cartInfo">
                              <!-- **** Cart Header **** -->
                              <div class="cartHeader">
                                <span class="itemTitle"><?= $tours_list_arr[$i]['service']['service_arr'][0]['package'].'('.$package_item[0].')' ?></span>
                                <button class="deleteHotel" onclick="remove_item('<?= $tours_list_arr[$i]['service']['uuid'] ?>')"></button>
                              
                                <div class="infoSection">
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-calendar"></i>
                                Travel Date: 
                                <strong><?= get_date_user($tours_list_arr[$i]['service']['service_arr'][0]['travel_date']) ?></strong>
                                </span>
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-person"></i>
                                Passengers: 
                                <strong><?= ($tours_list_arr[$i]['service']['service_arr'][0]['adult'] + $tours_list_arr[$i]['service']['service_arr'][0]['childwo'] + $tours_list_arr[$i]['service']['service_arr'][0]['childwi'] + $tours_list_arr[$i]['service']['service_arr'][0]['infant']) ?></strong>
                                </span>
                                <?php if($tours_list_arr[$i]['service']['service_arr'][0]['extra_bed'] != 0){ ?>
                                <span class="cardInfoLine cust">
                                <i class="icon it itours-bed"></i>
                                Extra Bed: 
                                <strong><?= $tours_list_arr[$i]['service']['service_arr'][0]['extra_bed'] ?></strong>
                                </span>
                                <?php } ?>
                                </div>
                                
                              </div>
                              <!-- **** Cart Header End **** -->
                          
                              <!-- **** Transfer Room Item **** -->
                              <div class="roomType">
                                <div class="roomTitle clearfix">
                                  <div class="rHeading"><?= $tours_list_arr[$i]['service']['service_arr'][0]['package_code'] ?></div>
                                    <span class="s1">Total Cost</span>
                                    <span class="s2"><span class='currency-icon'></span>
                                    <span class='c-hide checkoutt-currency-id'><?= $h_currency_id ?></span>
                                    <span class='checkoutt-currency-price'><?= $total_amount ?></span></span>
                                </div>
                                <div class="rData">
                                  <div class="infoSection">
                                  <span class="cardInfoLine noicon">
                                    Amount:
                                    <span class='currency-icon'></span>
                                    <span class='c-hide checkoutp-currency-id'><?= $h_currency_id ?></span>
                                    <strong class='checkoutp-currency-price'><?= $room_cost ?></strong>
                                  </span>
                                  <span class="cardInfoLine noicon">
                                    Tax:
                                    <span class='currency-icon'></span>
                                    <span class='c-hide checkouttax-currency-id'><?= $h_currency_id ?></span>
                                    <strong class='checkouttax-currency-price'><?= $tax_amount ?></strong>
                                  </span>
                                  </div>
                                </div>
                              </div>
                              <!-- **** Transfer Item End **** -->
                            </div>
                          </div>
                          <!-- **** Cart Data End **** -->
                        </div>
                      </div>
                      <!-- **** Shopping Cart Item End **** -->
                      <?php
                      $coupon = ($tours_list_arr[$i]['service']['service_arr'][0]['coupon']['coupon_info_arr']!='')?$tours_list_arr[$i]['service']['service_arr'][0]['coupon']['coupon_info_arr'] : [];
                      for($j=0;$j<sizeof($coupon);$j++){
                        array_push($coupon_list_arr,$coupon[$j]);
                      }
                      ?>
                      <?php } ?>
                      <div id="cancellation_modal"></div>
                    </div>
                </div>
                <!-- ***** Transfer Listing End ***** -->
              <?php } ?>
              <?php if(sizeof($ferry_list_arr)>0){ ?>
                <!-- **** ferry Listing **** -->
                <div class="c-cartContainer m20-btm">
                  <div class="cartHeading">Ferry Details</div>
                    <div class="cartBody">
                      <?php
                      $ferry_basic_total = 0;
                      $ferry_tax_total = 0;
                      $ferry_total = 0;
                      for($i=0;$i<sizeof($ferry_list_arr);$i++){
                        $tax_amount = 0;
                        //ferry costing
                        $room_cost_arr = explode('-',$ferry_list_arr[$i]['service']['service_arr'][0]['total_cost']);
                        $taxation_arr = explode(',',$ferry_list_arr[$i]['service']['service_arr'][0]['taxation']);
                        $room_cost = $room_cost_arr[0];
                        $h_currency_id = $room_cost_arr[1];
                        
                        $tax_arr1 = explode('+',$taxation_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                          if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                              $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                              $tax_amount = $tax_amount + ($room_cost + $tax_arr2[1]);
                            }
                          }
                        }

                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                        $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                        $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                        $ferry_basic_total += $room_cost1;
                        $ferry_tax_total += $tax_amount1;
                        $ferry_total += $total_amount1;
                        ?>
                        <!-- **** Shopping Cart Item **** -->
                        <div class="cartItem">
                          <div class="row">
                            <!-- **** Cart Image **** -->
                            <div class="col-3">
                              <div class="cartImage">
                              <img src="<?= $ferry_list_arr[$i]['service']['service_arr'][0]['image'] ?>" alt="iTours" />
                              </div>
                            </div>
                            <!-- **** Cart Image End **** -->
                          
                            <!-- **** Cart Data **** -->
                            <div class="col-9 p0-left">
                              <div class="cartInfo">
                                <!-- **** Cart Header **** -->
                                <div class="cartHeader">
                                  <span class="itemTitle"><?= $ferry_list_arr[$i]['service']['service_arr'][0]['ferry_name'] ?></span>
                                  <button class="deleteHotel" onclick="remove_item('<?= $ferry_list_arr[$i]['service']['uuid'] ?>')"></button>
                                  <div class="infoSection">
                                    <span class="cardInfoLine cust">
                                    <i class="icon it itours-calendar"></i>
                                    Travel Date: 
                                    <strong><?= get_date_user($ferry_list_arr[$i]['service']['service_arr'][0]['travel_date']) ?></strong>
                                    </span>
                                    <span class="cardInfoLine cust">
                                    <i class="icon it itours-pin-alt"></i>
                                    Location: 
                                    <strong><?= $ferry_list_arr[$i]['service']['service_arr'][0]['from_loc_city'].' To '.$ferry_list_arr[$i]['service']['service_arr'][0]['to_loc_city'] ?></strong>
                                    </span>
                                  </div>
                                
                                <!-- **** Cart Header End **** -->
                            
                                <!-- **** Transfer Room Item **** -->
                                <div class="roomType">
                                  <div class="roomTitle clearfix">
                                    <div class="rHeading"><?= $ferry_list_arr[$i]['service']['service_arr'][0]['ferry_type'] ?></div>
                                      <span class="s1">Total Cost</span>
                                      <span class="s2"><span class='currency-icon'></span>
                                      <span class='c-hide checkoutt-currency-id'><?= $h_currency_id ?></span>
                                      <span class='checkoutt-currency-price'><?= $total_amount ?></span></span>
                                  </div>
                                  <div class="rData">
                                    <div class="infoSection">
                                    <span class="cardInfoLine noicon">
                                      Amount:
                                      <span class='currency-icon'></span>
                                      <span class='c-hide checkoutp-currency-id'><?= $h_currency_id ?></span>
                                      <strong class='checkoutp-currency-price'><?= $room_cost ?></strong>
                                    </span>
                                    <span class="cardInfoLine noicon">
                                      Tax:
                                      <span class='currency-icon'></span>
                                      <span class='c-hide checkouttax-currency-id'><?= $h_currency_id ?></span>
                                      <strong class='checkouttax-currency-price'><?= $tax_amount ?></strong>
                                    </span>
                                    </div>
                                  </div>
                                </div>
                                <!-- **** ferry Item End **** -->
                              </div>
                            </div>
                            <!-- **** Cart Data End **** -->
                          </div>
                        </div>
                        </div>
                        <!-- **** Shopping Cart Item End **** -->
                      <?php } ?>
                    </div>
                </div>
                <!-- ***** ferry Listing End ***** -->
              <?php } ?>
              <input type='hidden' id='coupon_list_arr' value='<?php echo json_encode($coupon_list_arr,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>'/>
            </div>
            <!-- ***** Listing Filter ***** -->
            <div class="col-md-4 col-sm-12">
              <div class="c-cartContainer cartPricing">
                <div class="sTitle">
                  <div class="row align-items-center">
                    <div class="col-6">Final Pricing</div>
                    <div class="col-6 text-right">
                      <button id="quot_button" title="Generate Quotation PDF" data-toggle="tooltip" class="c-button colGrn sm" value="Payment" onclick="generate_pdf(<?= sizeof($activity_list_arr)?>);">Quotation PDF</button>
                      <div id="pdf_modal"></div>
                    </div>
                  </div>  
                </div>
                <?php if(sizeof($hotel_list_arr)>0){?>
                <!-- **** Pricing Block **** -->
                <div class="sBlock">
                  <span class="sBlock_title">Hotel</span>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Price: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkouttsubtotal-currency-price'><?= $price_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Tax: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkoutttaxtotal-currency-price'><?= $tax_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price cDivider">
                    <div class="col-4">
                      <span class="pLabel">Total: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost colWhite"><span class='currency-icon'></span>
                      <span class='checkouttotal-currency-price'><?= $hotel_total ?></span></span>
                    </div>
                  </div>
                </div>
                <!-- **** Pricing Block End **** -->
                <?php }
                if(sizeof($transfer_list_arr)>0){?>
                <!-- **** Pricing Block **** -->
                <div class="sBlock">
                  <span class="sBlock_title">Transfer</span>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Price: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkouttsubtotal-currency-price'><?= $trans_basic_tottal ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Tax: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkoutttaxtotal-currency-price'><?= $trans_tax_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price cDivider">
                    <div class="col-4">
                      <span class="pLabel">Total: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost colWhite"><span class='currency-icon'></span>
                      <span class='checkouttotal-currency-price'><?= $trans_total ?></span></span>
                    </div>
                  </div>
                </div>
                <!-- **** Pricing Block End **** -->
                <?php }
                if(sizeof($activity_list_arr)>0){?>
                <!-- **** Pricing Block **** -->
                <div class="sBlock">
                  <span class="sBlock_title">Activity</span>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Price: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkouttsubtotal-currency-price'><?= $actprice_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Tax: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkoutttaxtotal-currency-price'><?= $acttax_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price cDivider">
                    <div class="col-4">
                      <span class="pLabel">Total: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost colWhite"><span class='currency-icon'></span>
                      <span class='checkouttotal-currency-price'><?= $activity_total ?></span></span>
                    </div>
                  </div>
                </div>
                <!-- **** Pricing Block End **** -->
                <?php }
                if(sizeof($tours_list_arr)>0){?>
                <!-- **** Pricing Block **** -->
                <div class="sBlock">
                  <span class="sBlock_title">Holiday</span>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Price: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkouttsubtotal-currency-price'><?= $tours_basic_tottal ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Tax: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkoutttaxtotal-currency-price'><?= $tours_tax_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price cDivider">
                    <div class="col-4">
                      <span class="pLabel">Total: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost colWhite"><span class='currency-icon'></span>
                      <span class='checkouttotal-currency-price'><?= $tours_total ?></span></span>
                    </div>
                  </div>
                </div>
                <!-- **** Pricing Block End **** -->
                <?php }if(sizeof($ferry_list_arr)>0){?>
                <!-- **** Pricing Block **** -->
                <div class="sBlock">
                  <span class="sBlock_title">Ferry</span>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Price: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkouttsubtotal-currency-price'><?= $ferry_basic_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price">
                    <div class="col-4">
                      <span class="pLabel">Tax: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost"><span class='currency-icon'></span><span class='checkoutttaxtotal-currency-price'><?= $ferry_tax_total ?></span></span>
                    </div>
                  </div>
                  <div class="row sBlock_price cDivider">
                    <div class="col-4">
                      <span class="pLabel">Total: </span>
                    </div>
                    <div class="col-8">
                      <span class="pLabel cost colWhite"><span class='currency-icon'></span>
                      <span class='checkouttotal-currency-price'><?= $ferry_total ?></span></span>
                    </div>
                  </div>
                </div>
                <!-- **** Pricing Block End **** -->
                <?php }
                $grand_total += $hotel_total + $trans_total + $activity_total + $tours_total + $ferry_total;
                ?>
                <!-- **** Pricing Block **** -->
                <div class="sBlock gTotal">
                  <div class="row sBlock_price">
                    <div class="col-6">
                      <span class="pLabel">Grand Total: </span>
                    </div>
                    <div class="col-6">
                      <span class="pLabel cost colWhite"><span class='currency-icon'></span>
                      <span class='checkoutgrandtotal-currency-price' id='grand_total'><?= $grand_total ?></span></span>
                    </div>
                  </div>
                </div>
                <!-- **** Pricing Block End **** -->
                <!-- **** Promo code Notifications **** -->
                <div class="c-promoNotify st-success c-hide" id='success_div'>
                  <span id='coupon_text'></span>
                  <span class="p_code" id='promo_amount'></span>
                  <input type='button' class="removePromo" onclick='remove_coupon();' value='Remove' title='Remove Promo Code'/>
                </div>
                <!-- **** Promo code Notifications End **** -->

                <!-- **** Promo code Notifications **** -->
                <div class="c-promoNotify st-fail c-hide" id='error_div'>
                  <span id='invalid_coupon_text'></span>
                  <input type='button' class="removePromo" value='Close' onclick='close_section();' title='Close'/>
                </div>
                <!-- **** Promo code Notifications End **** -->

                <!-- **** Promo Code Block **** -->
                <div class="sPromocode" id='promocode_div'>
                  <span class="sLabel">Have promo code.?</span>
                  <div class="row">
                    <div class="col-12 col-md-8 sections">
                      <input
                        type="text"
                        class="promoTxt"
                        placeholder="Enter Promocode" id='coupon_code'
                      />
                    </div>
                    <div class="col-12 col-md-4 sections">
                      <input type='button' class="promoBtn" onclick='apply_coupon();' value='Apply' title='Apply Promo Code'/>
                    </div>
                  </div>
                </div>
                <!-- **** Promo Code Block End **** -->

                <button type='submit' onclick="proceed_to_checkout('<?= sizeof($activity_list_arr) ?>');" class="c-button colGrn lg">Proceed to Checkout</button>
              </div>
            </div>
            <!-- ***** Listing Filter End ***** -->
          </div>
        </div>
      </div>
      <input type="hidden" id="aunique_timestamp" name="aunique_timestamp" value="<?php echo $unique_timestamp; ?>">
<!-- ********** Component :: Listing End ********** -->
</form>
<script type="text/javascript" src="checkout.js"></script>