<?php

include 'config.php';

//Include header

include 'layouts/header.php';

$type = $_GET['type'];

if($type == '1' || $type == '2'){



    $package_id = $_GET['package_id'];

    $package_type = $_GET['package_type'];

    $adult_count = $_GET['adult_count'];

    $child_wocount = $_GET['child_wocount'];

    $child_wicount = $_GET['child_wicount'];

    $extra_bed_count = $_GET['extra_bed_count'];

    $infant_count = $_GET['infant_count'];

    $travel_date = $_GET['travel_date'];

}

else{

    $item_id = $_GET['item_id'];

    $enq_data = json_decode($_GET['enq_data']);

}



if($type == '1') {

    $type_label = 'Holiday';

    $sq_tour = mysqli_fetch_assoc(mysqlQuery("select package_name,dest_id from custom_package_master where package_id='$package_id'"));

    $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_name from destination_master where dest_id='$sq_tour[dest_id]'"));

    $tour_name = $sq_tour['package_name'].' ('.$sq_dest['dest_name'].')';

    $travel_date1 = $travel_date;

    $readonly = '';

}

else if($type == '2') {

    $type_label = 'Group Tour';

    $query = mysqli_fetch_assoc(mysqlQuery("select tour_name,dest_id from tour_master where tour_id = '$package_id'"));

    $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_name from destination_master where dest_id='$query[dest_id]'"));

    $tour_name = $query['tour_name'].' ('.$sq_dest['dest_name'].')';

    $travel_date1 = explode('to',$travel_date);

    $travel_date = $travel_date1[0];

    $travel_to_date = $travel_date1[1];

    $readonly = 'readonly';

    $group_id = $_GET['group_id'];

}

else if($type == '3') {

    $type_label = 'Hotel';

    $query = mysqli_fetch_assoc(mysqlQuery("select city_id from hotel_master where hotel_id = '$item_id'"));

    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id = '$query[city_id]'"));

    $tour_name = $enq_data[0]->hotel_name.' ('.$sq_city['city_name'].')';

    $check_in = date('d-m-Y',strtotime($enq_data[0]->check_in));

    $check_out = date('d-m-Y',strtotime($enq_data[0]->check_out));

    $total_rooms = $enq_data[0]->total_rooms;

}

else if($type == '4') {

    $type_label = 'Activity';

    $query = mysqli_fetch_assoc(mysqlQuery("select city_id from excursion_master_tariff where entry_id = '$item_id'"));

    $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id = '$query[city_id]'"));

    $tour_name = $enq_data[0]->excursion_name.' ('.$sq_city['city_name'].')';

    $act_date = date('d-m-Y',strtotime($enq_data[0]->actDate));

}

else if($type == '5') {



    $type_label = 'Transfer';

    $tour_name = $enq_data[0]->vehicle_name.' ('.$enq_data[0]->vehicle_type.')';

    $trip_type = $enq_data[0]->trip_type;

    $pickup = $enq_data[0]->pickup;

    $pickup_date = date('d-m-Y H:i',strtotime($enq_data[0]->pickup_date));

    $drop = $enq_data[0]->drop;

    $return_date = ($trip_type == 'roundtrip') ? date('d-m-Y H:i',strtotime($enq_data[0]->return_date)) : 'NA';

    $readonly = ($trip_type == 'roundtrip') ? '' : 'readonly';

    $passengers = $enq_data[0]->passengers;

}

else if($type == '6') {



    $type_label = 'Visa';

    $tour_name = $enq_data[0].' ('.$enq_data[1].')';

}

else if($type == '7') {



    $type_label = 'Cruise';

    $tour_name = $enq_data[0]->ferry_name.' ('.$enq_data[0]->ferry_type.')';

    $travel_date = date('d-m-Y H:i',strtotime($enq_data[0]->travel_date));

    $adult_count = $enq_data[0]->adult_count;

    $child_count = $enq_data[0]->child_count;

    $infant_count = $enq_data[0]->infant_count;

}



?>



<!-- ********** Component :: Page Title ********** -->

<div class="c-pageTitleSect ts-pageTitleSect">

<div class="container">

  <div class="row">

    <div class="col-md-7 col-12">



      <!-- *** Search Head **** -->

      <div class="searchHeading">

            <span class="pageTitle">Enquiry for <?= $type_label ?> </span>



            <div class="clearfix for-transfer">

                <div class="sortSection">

                <span class="sortTitle st-search">

                    <i class="icon it itours-pin-alt"></i>

                    <?= $tour_name ?></strong>

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

          <a href="javascript:void(0)">Enquiry</a>

        </li>

      </ul>

    </div>



  </div>

</div>

</div>

<!-- ********** Component :: Page Title End ********** -->


<!-- Contact Section Start -->

<section class="ts-contact-section" style="padding:30px 0;">

    <div class="container">

        <div class="row">

            <div class="col col-12 col-md-12 col-lg-12">

                <div class="ts-contact-form ts-enquiry-form">

                    <form id="action_form" class="needs-validation" novalidate>

                            <input type="hidden" id="type" name="type" value="<?= $type ?>"/>

                        <?php

                        // Holiday and Group Tour

                        if($type == '1'||$type == '2'){

                            ?>

                            <input type="hidden" id="package_id" name="package_id" value="<?= $package_id ?>"/>

                            <input type="hidden" id="package_type" name="package_type" value="<?= $package_type ?>"/>

                            <input type="hidden" id="group_id" name="group_id" value="<?= $group_id ?>"/>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="name">Name*</label>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onkeypress="return blockSpecialChar(event)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="email_id  ">Email ID*</label>

                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="city_name">City or Place*</label>

                                    <input type="text" class="form-control" id="city_place" name="city_place" placeholder="City or Place" required>

                                    <input type="hidden" id="city_data" name="city_data" value='<?= get_cities_dropdown_sugg() ?>'>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_code">Country Code *</label>

                                    <select  class="form-control" id="country_code" name="country_code" name="country_code" style="width:100%" required>

                                    <?= get_country_code() ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="phone">Phone *</label>

                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="package_name">Package name*</label>

                                    <input name="package_name" id="package_name" name="package_name" class="form-control" value="<?= $tour_name ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="travel_from">Travel From Date*</label>

                                    <input type="text" class="form-control" id="travel_from" name="travel_from" placeholder="Travel From Date" onchange="get_to_date1(this.id,'travel_to')" value="<?= $travel_date ?>" <?= $readonly ?> required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="travel_to">Travel To Date*</label>

                                    <input type="text" class="form-control" id="travel_to" name="travel_to" placeholder="Travel To Date" onchange="validate_validDate1('travel_from','travel_to');" value="<?=$travel_to_date?>" <?= $readonly ?>  required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Adult(s)*</label>

                                    <input type="number" class="form-control" id="adults" name="adults" placeholder="Adult(s)" value="<?= $adult_count ?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="chwob">Child Without Bed(s)(2-5 yrs)</label>

                                    <input type="number" class="form-control" id="chwob" placeholder="Child Without Bed(s)" value="<?= $child_wocount ?>">

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="chwb">Child With Bed(s)(6-11 yrs)</label>

                                    <input type="number" class="form-control" id="chwb" placeholder="Child With Bed(s)" value="<?= $child_wicount ?>">

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="chwb">Extra Bed(s)</label>

                                    <input type="number" class="form-control" id="extra_bed" placeholder="Extra Bed(s)" value="<?= $extra_bed_count ?>">

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="infant">Infant(s)(Below 2 yrs)</label>

                                    <input type="number" class="form-control" id="infant" placeholder="Infant(s)" value="<?= $infant_count ?>">

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="package_typef">Package Type</label>

                                    <select id="package_typef" class="form-control">

                                        <?php

                                        if($type=='2'){ ?>

                                            <option value="NA"><?= 'NA' ?></option>

                                            <?php

                                        }

                                        else if($package_type!=''){

                                            $package_type_arr = explode(',',$package_type);

                                            for($i=0;$i<sizeof($package_type_arr);$i++){

                                            ?>

                                            <option value="<?= $package_type_arr[$i] ?>"><?= $package_type_arr[$i] ?></option>

                                            <?php }

                                        }else{

                                            get_package_type_dropdown();

                                        }

                                        ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-12 col-lg-4">

                                    <label for="specification">Other Specification(If any)</label>

                                    <textarea class="form-control" id="specification" placeholder="Other Specification"></textarea>

                                </div>

                            </div>

                        <?php }

                        // Hotel

                        else if($type == '3') {

                            ?>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="name">Name*</label>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onkeypress="return blockSpecialChar(event)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="email_id  ">Email ID*</label>

                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="city_name">City or Place*</label>

                                    <input type="text" class="form-control" id="city_place" name="city_place" placeholder="City or Place" required>

                                    <input type="hidden" id="city_data" name="city_data" value='<?= get_cities_dropdown_sugg() ?>'>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_code">Country Code *</label>

                                    <select  class="form-control" id="country_code" name="country_code" name="country_code" style="width:100%" required>

                                    <?= get_country_code() ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="phone">Phone *</label>

                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="hotel_name">Hotel name*</label>

                                    <input name="hotel_name" id="hotel_name" name="hotel_name" class="form-control" value="<?= $tour_name ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="check_in">CheckIn Date*</label>

                                    <input type="text" class="form-control" id="check_in" name="check_in" placeholder="CheckIn Date" onchange="get_to_date1(this.id,'check_out')" value="<?= $check_in ?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="check_out">CheckOut Date*</label>

                                    <input type="text" class="form-control" id="check_out" name="check_out" placeholder="CheckOut Date" onchange="validate_validDate1('check_in','check_out');" value="<?=$check_out?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Total Room(s)*</label>

                                    <input type="number" class="form-control" id="total_rooms" name="total_rooms" placeholder="Total Room(s)" value="<?=$total_rooms?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="room_cat">Room Category*</label>

                                    <select id="room_cat" class="form-control" style="width:100%;" required>

                                        <?php get_room_category_dropdown(); ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Adult(s)*</label>

                                    <input type="number" class="form-control" id="adults" name="adults" placeholder="Adult(s)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="chwob">Child Without Bed(s)(2-5 yrs)</label>

                                    <input type="number" class="form-control" id="chwob" placeholder="Child Without Bed(s)" >

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="chwb">Child With Bed(s)(6-11 yrs)</label>

                                    <input type="number" class="form-control" id="chwb" placeholder="Child With Bed(s)">

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="chwb">Extra Bed(s)</label>

                                    <input type="number" class="form-control" id="extra_bed" placeholder="Extra Bed(s)" >

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="infant">Infant(s)(Below 2 yrs)</label>

                                    <input type="number" class="form-control" id="infant" placeholder="Infant(s)" >

                                </div>

                                <div class="form-group col-md-12 col-lg-4">

                                    <label for="specification">Other Specification(If any)</label>

                                    <textarea class="form-control" id="specification" placeholder="Other Specification"></textarea>

                                </div>

                            </div>

                        <?php }

                        // Activity

                        else if($type == '4') {

                            ?>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="name">Name*</label>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onkeypress="return blockSpecialChar(event)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="email_id  ">Email ID*</label>

                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="city_name">City or Place*</label>

                                    <input type="text" class="form-control" id="city_place" name="city_place" placeholder="City or Place" required>

                                    <input type="hidden" id="city_data" name="city_data" value='<?= get_cities_dropdown_sugg() ?>'>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_code">Country Code *</label>

                                    <select  class="form-control" id="country_code" name="country_code" name="country_code" style="width:100%" required>

                                    <?= get_country_code() ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="phone">Phone *</label>

                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="act_name">Activity name*</label>

                                    <input name="act_name" id="act_name" class="form-control" value="<?= $tour_name ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="act_date">Activity Date*</label>

                                    <input type="text" class="form-control" id="act_date" name="act_date" placeholder="CheckIn Date" value="<?= $act_date ?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="transfer_option">Transfer Option*</label>

                                        <select name="transfer_option" id="transfer_option" data-toggle="tooltip" class="form-control" title="Transfer Option" style="width:100%" required>

                                            <option value="">*Transfer Option</option>

                                            <option value="Without Transfer">Without Transfer</option>

                                            <option value="Sharing Transfer">Sharing Transfer</option>

                                            <option value="Private Transfer">Private Transfer</option>

                                            <option value="SIC">SIC</option>

                                        </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Adult(s)*</label>

                                    <input type="number" class="form-control" id="adults" name="adults" placeholder="Adult(s)" value="<?=$enq_data[0]->adult_count ?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="child">Child(ren)(2-5 yrs)</label>

                                    <input type="number" class="form-control" id="child" placeholder="Child(ren)" value="<?=$enq_data[0]->child_count ?>" >

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="infant">Infant(s)(Below 2 yrs)</label>

                                    <input type="number" class="form-control" id="infant" placeholder="Infant(s)" value="<?=$enq_data[0]->infant_count ?>" >

                                </div>

                                <div class="form-group col-12 col-md-12 col-lg-4">

                                    <label for="specification">Other Specification(If any)</label>

                                    <textarea class="form-control" id="specification" placeholder="Other Specification"></textarea>

                                </div>

                            </div>

                        <?php }

                        // Transfer

                        else if($type == '5') {

                            ?>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="name">Name*</label>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onkeypress="return blockSpecialChar(event)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="email_id  ">Email ID*</label>

                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="city_name">City or Place*</label>

                                    <input type="text" class="form-control" id="city_place" name="city_place" placeholder="City or Place" required>

                                    <input type="hidden" id="city_data" name="city_data" value='<?= get_cities_dropdown_sugg() ?>'>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_code">Country Code *</label>

                                    <select  class="form-control" id="country_code" name="country_code" name="country_code" style="width:100%" required>

                                    <?= get_country_code() ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="phone">Phone *</label>

                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="trans_name">Transfer name*</label>

                                    <input name="trans_name" id="trans_name" class="form-control" value="<?= $tour_name ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="trip_type">Trip Type*</label>

                                    <input name="trip_type" id="trip_type" class="form-control" value="<?= ucfirst($trip_type) ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="pickup">Pickup Location*</label>

                                    <input name="pickup" id="pickup" class="form-control" value="<?= $pickup ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="pickup_date">Pickup Date&Time*</label>

                                    <input type="text" class="form-control" id="pickup_date" name="pickup_date" placeholder="Pickup Date&Time" onchange="get_to_datetime1(this.id,'return_date','<?=$trip_type?>')" value="<?= $pickup_date ?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="drop">Dropoff Location*</label>

                                    <input name="drop" id="drop" class="form-control" value="<?= $drop ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="return_date">Return Date&Time*</label>

                                    <input type="text" class="form-control" id="return_date" name="return_date" placeholder="Return Date&Time" onchange="validate_validDatetime1('pickup_date','return_date')" value="<?= $return_date ?>" <?= $readonly ?> required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Total Passengers*</label>

                                    <input type="number" class="form-control" id="pass" name="pass" placeholder="Total Passengers" value="<?=$passengers ?>" required>

                                </div>

                                <div class="form-group col-md-12 col-lg-4">

                                    <label for="specification">Other Specification(If any)</label>

                                    <textarea class="form-control" id="specification" placeholder="Other Specification"></textarea>

                                </div>

                            </div>

                        <?php }

                        // Visa

                        else if($type == '6') {

                            ?>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="name">Name*</label>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onkeypress="return blockSpecialChar(event)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="email_id  ">Email ID*</label>

                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="city_name">City or Place*</label>

                                    <input type="text" class="form-control" id="city_place" name="city_place" placeholder="City or Place" required>

                                    <input type="hidden" id="city_data" name="city_data" value='<?= get_cities_dropdown_sugg() ?>'>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_code">Country Code *</label>

                                    <select  class="form-control" id="country_code" name="country_code" name="country_code" style="width:100%" required>

                                    <?= get_country_code() ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="phone">Phone *</label>

                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_name">Country name*</label>

                                    <input name="country_name" id="country_name" class="form-control" value="<?= $tour_name ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="act_date">Travel Date*</label>

                                    <input type="text" class="form-control" id="travel_date" name="travel_date" placeholder="Travel Date" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Adult(s)*</label>

                                    <input type="number" class="form-control" id="adults" name="adults" placeholder="Adult(s)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="child">Child(ren)(2-5 yrs)</label>

                                    <input type="number" class="form-control" id="child" placeholder="Child(ren)" >

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="infant">Infant(s)(Below 2 yrs)</label>

                                    <input type="number" class="form-control" id="infant" placeholder="Infant(s)">

                                </div>

                                <div class="form-group col-md-8">

                                    <label for="specification">Other Specification(If any)</label>

                                    <textarea class="form-control" id="specification" placeholder="Other Specification"></textarea>

                                </div>

                            </div>

                        <?php } 

                        // Cruise

                        else if($type == '7') {

                            ?>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="name">Name*</label>

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" onkeypress="return blockSpecialChar(event)" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="email_id  ">Email ID*</label>

                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email ID" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="city_name">City or Place*</label>

                                    <input type="text" class="form-control" id="city_place" name="city_place" placeholder="City or Place" required>

                                    <input type="hidden" id="city_data" name="city_data" value='<?= get_cities_dropdown_sugg() ?>'>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="country_code">Country Code *</label>

                                    <select  class="form-control" id="country_code" name="country_code" name="country_code" style="width:100%" required>

                                    <?= get_country_code() ?>

                                    </select>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="phone">Phone *</label>

                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="cruise_name">Cruise name*</label>

                                    <input name="cruise_name" id="cruise_name" class="form-control" value="<?= $tour_name ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="from_location">From Location*</label>

                                    <input name="from_location" id="from_location" class="form-control" value="<?= $enq_data[0]->from_location ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="to_location">To Location*</label>

                                    <input name="to_location" id="to_location" class="form-control" value="<?= $enq_data[0]->to_location ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="act_date">Travel Date*</label>

                                    <input type="text" class="form-control" id="travel_date" name="travel_date" placeholder="Travel Date" value="<?= $travel_date ?>" readonly required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="adults">Adult(s)*</label>

                                    <input type="number" class="form-control" id="adults" name="adults" placeholder="Adult(s)" value="<?= $adult_count ?>" required>

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="child">Child(ren)(2-5 yrs)</label>

                                    <input type="number" class="form-control" id="child" placeholder="Child(ren)" value="<?= $child_count ?>" >

                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4">

                                    <label for="infant">Infant(s)(Below 2 yrs)</label>

                                    <input type="number" class="form-control" id="infant" placeholder="Infant(s)" value="<?= $infant_count ?>">

                                </div>

                                <div class="form-group col-md-8">

                                    <label for="specification">Other Specification(If any)</label>

                                    <textarea class="form-control" id="specification" placeholder="Other Specification"></textarea>

                                </div>

                            </div>

                        <?php } ?>

                        <button type="submit" name="sb" value="btn_enq" id="btn_enq" class="btn btn-primary w-33" title="Generate Enquiry"><i class="fa fa-phone-square" aria-hidden="true"></i>  Enquiry</button>

                        <?php

                        if($type == '1' || $type =='2'){ ?>

                            <button type="submit" name="sb" value="btn_quot" id="btn_quot" class="btn btn-info w-33" title="Download Quotation"><i class="fa fa-file-text-o" aria-hidden="true"></i>  Download Quotation</button>

                            <button type="submit" name="sb" value="btn_book" id="btn_book" class="btn btn-success w-33" title="Book"><i class="fa fa-address-book" aria-hidden="true"></i>  Book</button>

                        <?php } ?>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<div id="div_data_modal"></div>

<!-- Contact Section End -->

<script>

// Example starter JavaScript for disabling form submissions if there are invalid fields

(function() {

    'use strict';

    window.addEventListener('load', function() {

        // Fetch all the forms we want to apply custom Bootstrap validation styles to

        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission

        var validation = Array.prototype.filter.call(forms, function(form) {

        form.addEventListener('submit', function(event) {

            if (form.checkValidity() === false) {

            event.preventDefault();

            event.stopPropagation();

            }

            form.classList.add('was-validated');

        }, false);

        });

    }, false);

})();

</script>



<?php include 'layouts/footer.php';?>

<script type="text/javascript" src="js/scripts.js"></script>

<script>

$('#country_code,#room_cat').select2();

/////// Next 10th day onwards date display

var tomorrow = new Date();

tomorrow.setDate(tomorrow.getDate()+10);

var day = tomorrow.getDate();

var month = tomorrow.getMonth() + 1

var year = tomorrow.getFullYear();

if(<?= $type ?> == '1'){

    $('#travel_from, #travel_to').datetimepicker({ timepicker:false,format:'d-m-Y',minDate:tomorrow });

}

if(<?= $type ?> == '3'){

    $('#check_in, #check_out').datetimepicker({ timepicker:false,format:'d-m-Y',minDate:new Date() });

}

if(<?= $type ?> == '4'){

    $('#act_date').datetimepicker({ timepicker:false,format:'d-m-Y',minDate:new Date() });

}

if(<?= $type ?> == '5'){

    $('#pickup_date').datetimepicker({ format:'d-m-Y H:i',minDate:new Date() });

    if('<?= $trip_type ?>' == 'roundtrip'){

        $('#return_date').datetimepicker({ format:'d-m-Y H:i',minDate:new Date() });

    }

}

if(<?= $type ?> == '6'){

    $('#travel_date').datetimepicker({ timepicker:false,format:'d-m-Y',minDate:tomorrow });

}



$( document ).ready(function() {



    var service = '<?php echo $service; ?>';

    if(service && (service !== '' || service !== undefined)){

    var checkLink = $('.c-searchContainer .c-search-tabs li');

    var checkTab = $('.c-searchContainer .search-tab-content .tab-pane');

    checkLink.each(function(){

        var child = $(this).children('.nav-link');

        if(child.data('service') === service){

        $(this).siblings().children('.nav-link').removeClass('active');

        child.addClass('active');

        }

    });

    checkTab.each(function(){

        if($(this).data('service') === service){

        $(this).addClass('active show').siblings().removeClass('active show');

        }

    })

    }

});

// $("#city_name").autocomplete({



//     source: JSON.parse($('#city_data').val()),

//     select: function (event, ui) {

// 		$("#city_name").val(ui.item.label);

//     },

//     open: function(event, ui) {

// 		$(this).autocomplete("widget").css({

//             "width": document.getElementById("city_name").offsetWidth

//         });

//     }

// }).data("ui-autocomplete")._renderItem = function(ul, item) {

// return $("<li disabled>")

// .append("<a>" + item.label +"</a>")

// .appendTo(ul);

// };



//Get DateTime

function get_to_datetime1 (from_date, to_date,trip_type) {

    

    if(trip_type == 'roundtrip'){

        var from_date1 = $('#' + from_date).val();

        if (from_date1 != '') {

            var edate = from_date1.split(' ');

            var edate1 = edate[0].split('-');

            var edatetime = edate[1].split(':');

            var e_date_temp = new Date(

                edate1[2],

                edate1[1] - 1,

                edate1[0],

                edatetime[0],

                edatetime[1]

            ).getTime();



            var currentDate = new Date(new Date(e_date_temp).getTime() + 24 * 60 * 60 * 1000);

            var day = currentDate.getDate();

            var month = currentDate.getMonth() + 1;

            var year = currentDate.getFullYear();

            var hours = currentDate.getHours();

            var minute = currentDate.getMinutes();

            if (day < 10) {

                day = '0' + day;

            }

            if (month < 10) {

                month = '0' + month;

            }

            if (hours < 10) {

                hours = '0' + hours;

            }

            if (minute < 10) {

                minute = '0' + minute;

            }

            $('#' + to_date).val(day + '-' + month + '-'+ year + ' ' + hours + ':' + minute);

        }

        else {

            $('#' + to_date).val('');

        }

    }

}

//function for valid date tariff

function validate_validDatetime1(from, to) {



    var base_url = $('#base_url').val();

    var from_date = $('#' + from).val();

    var to_date = $('#' + to).val();



    var edates = from_date.split(' ');

    var edate = edates[0].split('-');

    e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();

    var edatet = to_date.split(' ');

    var edate1 = edatet[0].split('-');

    e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();



    var from_date_ms = new Date(e_date).getTime();

    var to_date_ms = new Date(e_date1).getTime();



    if (from_date_ms > to_date_ms) {

        error_msg_alert('Date should not be greater than valid to date',base_url);

        $('#' + from).css({ border: '1px solid red' });

        document.getElementById(from).value = '';

        $('#' + from).focus();

        g_validate_status = false;

        return false;

    } else {

        $('#' + from).css({ border: '1px solid #ddd' });

        return true;

    }

    return true;

}



$(function () {

	$('#action_form').validate({

		rules         : {

        },

		submitHandler : function (form) {



            var btn_id = window.event.submitter.id;

            var base_url = $('#base_url').val();

            var crm_base_url = $('#crm_base_url').val();

            

            var type = $('#type').val();

            var name = $('#name').val();

            var email_id = $('#email_id').val();

            var city_place = $('#city_place').val();

            var country_code = $('#country_code').val();

            var phone = $('#phone').val();



            var package_id = $('#package_id').val();

            var group_id = $('#group_id').val();

            var package_type = $('#package_type').val();

            var package_name = $('#package_name').val();

            var travel_from = $('#travel_from').val();

            var travel_to = $('#travel_to').val();

            var adults = $('#adults').val();

            var chwb = $('#chwb').val();

            var chwob = $('#chwob').val();

            var extra_bed = $('#extra_bed').val();

            var infant = $('#infant').val();

            var package_typef = $('#package_typef').val();

            var specification = $('#specification').val();

            

            var enq_data_arr = [];

            if(type == '3'){

                

                var hotel_name = $('#hotel_name').val();

                var check_in = $('#check_in').val();

                var check_out = $('#check_out').val();

                var total_rooms = $('#total_rooms').val();

                var room_cat = $('#room_cat').val();



                enq_data_arr.push({

                    'hotel_name':hotel_name,

                    'check_in':check_in,

                    'check_out':check_out,

                    'total_rooms':total_rooms,

                    'room_cat':room_cat,

                    'adults':adults,

                    'chwob':chwob,

                    'chwb':chwb,

                    'extra_bed':extra_bed,

                    'infant':infant,

                    'specification':specification

                });

            }

            if(type == '4'){

                

                var act_name = $('#act_name').val();

                var act_date = $('#act_date').val();

                var child = $('#child').val();

                var transfer_option = $('#transfer_option').val();



                enq_data_arr.push({

                    'act_name':act_name,

                    'act_date':act_date,

                    'adults':adults,

                    'child':child,

                    'infant':infant,

                    'transfer_option' : transfer_option,

                    'specification':specification

                });

            }

            if(type == '5'){



                var trans_name = $('#trans_name').val();

                var trip_type = $('#trip_type').val();

                var pickup = $('#pickup').val();

                var pickup_date = $('#pickup_date').val();

                var drop = $('#drop').val();

                var return_date = $('#return_date').val();

                var pass = $('#pass').val();



                enq_data_arr.push({

                    'trans_name':trans_name,

                    'trip_type':trip_type,

                    'pickup':pickup,

                    'pickup_date':pickup_date,

                    'drop':drop,

                    'return_date' : return_date,

                    'pass' : pass,

                    'specification':specification

                });

            }

            if(type == '6'){



                var country_name = $('#country_name').val();

                var travel_date = $('#travel_date').val();

                var child = $('#child').val();

                

                adults = (adults == '') ? 0 : adults;

                child = (child == '') ? 0 : child;

                infant = (infant == '') ? 0 : infant;

                var pass = parseInt(adults) + parseInt(child) + parseInt(infant);



                enq_data_arr.push({

                    'country_name':country_name,

                    'travel_date':travel_date,

                    'adults':adults,

                    'child':child,

                    'infant':infant,

                    'pass' : pass,

                    'specification':specification

                });

            }

            if(type == '7'){



                var cruise_name = $('#cruise_name').val();

                var from_location = $('#from_location').val();

                var to_location = $('#to_location').val();

                var travel_date = $('#travel_date').val();

                var child = $('#child').val();

                

                adults = (adults == '') ? 0 : adults;

                child = (child == '') ? 0 : child;

                infant = (infant == '') ? 0 : infant;

                var pass = parseInt(adults) + parseInt(child) + parseInt(infant);



                enq_data_arr.push({

                    'cruise_name':cruise_name,

                    'travel_date':travel_date,

                    'from_location':from_location,

                    'to_location':to_location,

                    'adults':adults,

                    'child':child,

                    'infant':infant,

                    'pass' : pass,

                    'specification':specification

                });

            }

			$('#'+btn_id).prop('disabled',true);

            $('#'+btn_id).button('loading');

            if(btn_id == 'btn_enq'){

                var action_url = crm_base_url + 'controller/b2c_settings/b2c/enquiry_form.php';

            }

            else if(btn_id == 'btn_quot'){

                var action_url = crm_base_url + 'controller/b2c_settings/b2c/quot_form.php';

            }

            else if(btn_id == 'btn_book'){

                var action_url = crm_base_url + 'controller/b2c_settings/b2c/book_form.php';

            }

			$.ajax({

				type  : 'post',

				url   : action_url,

				data  : {

					type : type,

					package_id : package_id,

                    group_id : group_id,

					package_type : package_type,

                    name : name,

                    email_id : email_id,

                    city_place : city_place,

                    country_code : country_code,

                    phone : phone,

                    package_name : package_name,

                    travel_from : travel_from,

                    travel_to : travel_to,

                    adults : adults,

                    chwb : chwb,

                    chwob : chwob,

                    infant : infant,

                    extra_bed:extra_bed,

                    package_typef:package_typef,

                    specification:specification,

                    enq_data_arr:JSON.stringify(enq_data_arr)

				},

				success : function (result) {

                    $('#'+btn_id).prop('disabled',false);

                    $('#'+btn_id).button('reset');

                    if(btn_id == 'btn_enq'){

                        var msg = 'Thank you for enquiry with us. Our experts will contact you shortly.';

                        $.alert({

                            title: 'Notification!',

                            content: msg,

                        });

                        setTimeout(() => {

                            window.location.href= base_url;

                        }, 2000);

                    }

                    else if(btn_id == 'btn_quot'){

                        var otp = [];

                        otp.push({

                            otp : result, email_id : email_id, phone : phone, used : 'false'

                        });

                        if (typeof Storage !== 'undefined') {

                            if (localStorage) {

                                localStorage.setItem('otp_info', JSON.stringify(otp));

                            } else {

                                window.sessionStorage.setItem('otp_info', JSON.stringify(otp));

                            }

                        }

                        $.post('action_pages/quotation_modal.php', {

					        type : type,

                            package_id:package_id,

                            name : name,

                            email_id : email_id,

                            city_place : city_place,

                            country_code : country_code,

                            phone : phone,

                            travel_from : travel_from,

                            travel_to : travel_to,

                            adults : adults,

                            chwb : chwb,

                            chwob : chwob,

                            infant : infant,

                            extra_bed:extra_bed,

                            package_typef:package_typef,

                            specification:specification,

                            otp : JSON.stringify(otp), email_id : email_id, phone : phone }, function(data){

			                $('#'+btn_id).prop('disabled',false);

                            $('#div_data_modal').html(data);

                        });

                    }

                    else if(btn_id == 'btn_book'){

                        var msg = result.split('--');

                        if(msg[0]=='error'){

                            error_msg_alert(msg[1],base_url);

                            $('#'+btn_id).prop('disabled',false);

                            return false;

                        }else{

                            $.post('action_pages/book_modal.php', {

                                type:type,

                                package_id:package_id,

                                package_name:package_name,

                                name : name,

                                email_id : email_id,

                                city_place : city_place,

                                country_code : country_code,

                                phone : phone,

                                travel_from : travel_from,

                                travel_to : travel_to,

                                adults : adults,

                                chwb : chwb,

                                chwob : chwob,

                                extra_bed:extra_bed,

                                infant : infant,

                                package_typef:package_typef,

                                specification:specification,

                                result : result, email_id : email_id, phone : phone }, function(data){

                                $('#'+btn_id).prop('disabled',false);

                                $('#div_data_modal').html(data);

                            });

                        }

                    }

                }

            });

            

        }

    });

});

</script>