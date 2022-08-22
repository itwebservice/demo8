<?php
$hotel_traveller_arr = array();
$package_traveller_arr = array();
$ferry_traveller_arr = array();
for($i=0;$i<sizeof($traveller_details);$i++){
    if($traveller_details[$i]->service->name == 'Hotel'){
        array_push($hotel_traveller_arr,$traveller_details[$i]);
    }
    else if($traveller_details[$i]->service->name == 'Combo Tours'){
        array_push($package_traveller_arr,$traveller_details[$i]);
    }
    else if($traveller_details[$i]->service->name == 'Ferry'){
        array_push($ferry_traveller_arr,$traveller_details[$i]);
    }
}
?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
	    <div class="profile_box main_block b2b_block">
	    <legend>Contact Person Details</legend>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block"> 
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <?php
                        $yr = explode("-", get_datetime_db($query['created_at']));
                        echo $query['fname'].' '.$query['lname'].'&nbsp'.'('.get_b2b_booking_id($query['booking_id'],$yr[0]).')'; ?>
                    </span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <?php echo $query['email_id']; ?>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <?php echo $query['contact_no']; ?> 
                    </span>
                    <?php
                    $sq_country = mysqli_fetch_assoc(mysqlQuery("select country_code,country_name from country_list_master where country_id='$query[country_id]'"));
                    ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="main_block">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        <?php echo $sq_country['country_name'].'('.$sq_country['country_code'].')' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if($query['sp_request']!=''){ ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
        <div class="profile_box main_block">
        <span class="main_block">
            Special Request : <?php echo $query['sp_request'] ?>
        </span>
        </div>
    </div>
</div>
<?php } ?>

<div class="row mg_tp_10">
	<div class="col-md-12">
		<div class="profile_box main_block">
			<?php if(sizeof($hotel_traveller_arr)>0){ ?>
                <legend>Guest Details</legend>
                <div class="col-md-12 profile_box">
                    <?php for($i=0;$i<sizeof($hotel_traveller_arr);$i++){
                        $hotel_id = $hotel_traveller_arr[$i]->service->id;
                        $sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name from hotel_master where hotel_id='$hotel_id'"));
                    ?>
                    <h5 class="serviceTitle"><?= $sq_hotel['hotel_name'] ?></h5>
                    <div class="row">
                    <!-- Roomwise Traveller -->
                    <?php for($j=0;$j<sizeof($hotel_traveller_arr[$i]->service->room_arr);$j++){ ?>
                        <div class='col-md-6'>
                            <div class='col-md-12'><u><?= 'Room '.($j+1) ?></u></div>
                            <div class='col-md-12'>
                                <ul>
                                <!-- Adults -->
                                <?php
                                for($k=0;$k<sizeof($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr);$k++){
                                    $pass_name =  ($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->honorofic.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->fname).' '.($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->lname);
                                ?>
                                <li><?php echo $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->adult_count.' : '.rawurldecode($pass_name) ?></li>
                                <?php } ?>
                                <!-- Children -->
                                <?php
                                $child_arr = ($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr) ? $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr : [];
                                for($k=0;$k<sizeof($child_arr);$k++){
                                    $pass_name = ($child_arr[$k]->chonorofic.' '.$child_arr[$k]->cfname).' '.($child_arr[$k]->clname);
                                ?>
                                <li><?php echo $child_arr[$k]->child_count.' : '.rawurldecode($pass_name) ?></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            <?php } ?>
			<?php if(sizeof($package_traveller_arr)>0){ ?>
			    <legend class="mg_tp_10">Guest Details</legend>
                <?php
                for($i=0;$i<sizeof($package_traveller_arr);$i++){
                    $package_id = $package_traveller_arr[$i]->service->id;
                    $sq_package = mysqli_fetch_assoc(mysqlQuery("select package_name,package_code from custom_package_master where package_id='$package_id'"));
                    ?>
                    <h5 class="serviceTitle"><?= $sq_package['package_name'].' ('.$sq_package['package_code'].')' ?></h5>
                    <div class="row">
                        <div class="col-md-12 profile_box">
                        <table class="table table-bordered no-marg">
                            <thead>
                                <tr class="table-heading-row">
                                    <th>S_No.</th>
                                    <th>ADOLESCENCE</th>
                                    <th>Name</th>
                                    <th>Birthdate</th>
                                    <th>Meal_Preference</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                for($k=0;$k<sizeof($package_traveller_arr[$i]->service->adults);$k++){
                                    $pass_name =  ($package_traveller_arr[$i]->service->adults[$k]->honorofic.' '.$package_traveller_arr[$i]->service->adults[$k]->fname).' '.($package_traveller_arr[$i]->service->adults[$k]->lname);
                                    $birthdate = $package_traveller_arr[$i]->service->adults[$k]->birthdate;
                                    $meal = $package_traveller_arr[$i]->service->adults[$k]->meal;
                                    ?>
                                <tr>
                                    <td><?= ++$count ?></td>
                                    <td><?= 'Adult' ?></td>
                                    <td><?= $pass_name ?></td>
                                    <td><?= $birthdate ?></td>
                                    <td><?= $meal ?></td>
                                </tr>
                                <?php } ?>
                                <?php
                                $package_traveller_arr[$i]->service->cwb = ($package_traveller_arr[$i]->service->cwb != '' || $package_traveller_arr[$i]->service->cwb != null) ? $package_traveller_arr[$i]->service->cwb : [];
                                for($k=0;$k<sizeof($package_traveller_arr[$i]->service->cwb);$k++){
                                    $pass_name =  rawurldecode($package_traveller_arr[$i]->service->cwb[$k]->honorofic.' '.$package_traveller_arr[$i]->service->cwb[$k]->fname).' '.($package_traveller_arr[$i]->service->cwb[$k]->lname);
                                    $birthdate = $package_traveller_arr[$i]->service->cwb[$k]->birthdate;
                                    $meal = $package_traveller_arr[$i]->service->cwb[$k]->meal;
                                    ?>
                                <tr>
                                    <td><?= ++$count ?></td>
                                    <td><?= 'ChildWithBed' ?></td>
                                    <td><?= $pass_name ?></td>
                                    <td><?= $birthdate ?></td>
                                    <td><?= $meal ?></td>
                                </tr>
                                <?php } ?>
                                <?php
                                $package_traveller_arr[$i]->service->cwob = ($package_traveller_arr[$i]->service->cwob != '' || $package_traveller_arr[$i]->service->cwob != null) ? $package_traveller_arr[$i]->service->cwob : [];
                                for($k=0;$k<sizeof($package_traveller_arr[$i]->service->cwob);$k++){
                                    $pass_name =  rawurldecode($package_traveller_arr[$i]->service->cwob[$k]->honorofic.' '.$package_traveller_arr[$i]->service->cwob[$k]->fname).' '.($package_traveller_arr[$i]->service->cwob[$k]->lname);
                                    $birthdate = $package_traveller_arr[$i]->service->cwob[$k]->birthdate;
                                    $meal = $package_traveller_arr[$i]->service->cwob[$k]->meal;
                                    ?>
                                <tr>
                                    <td><?= ++$count ?></td>
                                    <td><?= 'ChildWithoutBed' ?></td>
                                    <td><?= $pass_name ?></td>
                                    <td><?= $birthdate ?></td>
                                    <td><?= $meal ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                <?php
                }
            } ?>
			<?php if(sizeof($ferry_traveller_arr)>0){ ?>
			    <legend>Guest Details</legend>
                <?php
                for($i=0;$i<sizeof($ferry_traveller_arr);$i++){
                    ?>
                    <h5 class="serviceTitle"><?= $ferry_list_arr[$i]->service->service_arr[0]->ferry_name.' ('.$ferry_list_arr[$i]->service->service_arr[0]->ferry_type.')' ?></h5>
                    <div class="row">
                        <div class="col-md-12 profile_box">
                        <table class="table table-bordered no-marg">
                            <thead>
                                <tr class="table-heading-row">
                                    <th>S_No.</th>
                                    <th>ADOLESCENCE</th>
                                    <th>Name</th>
                                    <th>Birthdate</th>
                                    <th>Meal_Preference</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                for($k=0;$k<sizeof($ferry_traveller_arr[$i]->service->adults);$k++){
                                    $pass_name =  rawurldecode($ferry_traveller_arr[$i]->service->adults[$k]->honorofic.' '.$ferry_traveller_arr[$i]->service->adults[$k]->fname).' '.($ferry_traveller_arr[$i]->service->adults[$k]->lname);
                                    $birthdate = $ferry_traveller_arr[$i]->service->adults[$k]->birthdate;
                                    $meal = $ferry_traveller_arr[$i]->service->adults[$k]->meal;
                                    ?>
                                <tr>
                                    <td><?= ++$count ?></td>
                                    <td><?= 'Adult' ?></td>
                                    <td><?= $pass_name ?></td>
                                    <td><?= $birthdate ?></td>
                                    <td><?= $meal ?></td>
                                </tr>
                                <?php } ?>
                                <?php
                                $ferry_traveller_arr[$i]->service->children = ($ferry_traveller_arr[$i]->service->children != '' || $ferry_traveller_arr[$i]->service->children != null) ? $ferry_traveller_arr[$i]->service->children : [];
                                for($k=0;$k<sizeof($ferry_traveller_arr[$i]->service->children);$k++){
                                    $pass_name =  rawurldecode($ferry_traveller_arr[$i]->service->children[$k]->honorofic.' '.$ferry_traveller_arr[$i]->service->children[$k]->fname).' '.($ferry_traveller_arr[$i]->service->children[$k]->lname);
                                    $birthdate = $ferry_traveller_arr[$i]->service->children[$k]->birthdate;
                                    $meal = $ferry_traveller_arr[$i]->service->children[$k]->meal;
                                    ?>
                                <tr>
                                    <td><?= ++$count ?></td>
                                    <td><?= 'Child' ?></td>
                                    <td><?= $pass_name ?></td>
                                    <td><?= $birthdate ?></td>
                                    <td><?= $meal ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                <?php
                }
            } ?>
            </div>
        </div>
    </div>
</div>
    