<?php
include "../../model/model.php";
include '../constants.php';
global $currency;

$global_currency = $_POST['global_currency'];
$cart_list_arr = $_POST['cart_list_arr1'];
$payment_amount = $_POST['payment_amount'];
$timing_slots = $_POST['timing_slots'];
$register_id = $_SESSION['register_id'];
$customer_id = $_SESSION['customer_id'];

$_SESSION['payment_amount'] = $payment_amount;
$_SESSION['global_currency'] = $global_currency;
$hotel_list_arr = array();
$tours_list_arr = array();
$ferry_list_arr = array();
$cart_list_arr = ($cart_list_arr != '') ? $cart_list_arr : array();
for($i=0;$i<sizeof($cart_list_arr);$i++){
    if($cart_list_arr[$i]['service']['name'] == 'Hotel'){
        array_push($hotel_list_arr,$cart_list_arr[$i]);
    }
    if($cart_list_arr[$i]['service']['name'] == 'Combo Tours'){
        array_push($tours_list_arr,$cart_list_arr[$i]);
    }
    if($cart_list_arr[$i]['service']['name'] == 'Ferry'){
        array_push($ferry_list_arr,$cart_list_arr[$i]);
    }
}
?>
<input type='hidden' value='<?= json_encode($cart_list_arr,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='cart_checkout_data' name='cart_checkout_data'/>
<input type='hidden' value='<?= $timing_slots ?>' id='timing_slots' name='timing_slots'/>
<input type='hidden' value='<?= $register_id ?>' id='register_id' name='register_id'/>
<input type='hidden' value='<?= $customer_id ?>' id='customer_id' name='customer_id'/>
<input type='hidden' value='<?= $payment_amount ?>' id='payment_amount' name='payment_amount'/>
<input type='hidden' value='<?= $currency ?>' id='global_currency' name='global_currency'/>

<div class="container">
<div class="row">
    <div class="col-md-12 col-sm-12">
        <!-- ***********START********************** -->
        <form id="frm_traveller_details" name="frm_traveller_details">
        <!-- ***** Traveller Info Section ***** -->
        <div class="c-cartContainer">
        <div class="cartHeading">Travellers Details</div>
            <div class="cartBody">
                <div class="c-travellerDtls">
                    
                    <!-- ***** Room Row ***** -->
                    <div class="section">
                        <div class="title">Contact Person Details</div>

                        <!-- ***** Info Row ***** -->
                        <div class="row c-infoRow">
                        <div class="col-md-3 col-sm-6">
                            <div class="formField">
                                <input type="text" class="infoRow_txtbox" placeholder="*First Name" id="cfname" name="cfname" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="formField">
                                <input type="text" class="infoRow_txtbox" placeholder="*Last Name" id="clname" name="clname" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="formField">
                                <input type="email" class="infoRow_txtbox" placeholder="*Email ID" id="email_id" name="email_id" title="Enter Email ID" data-toggle="tooltip" required/>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="c-select2DD">
                            <select class="form-control full-width" id="country_id" name="country_id" onchange="get_country_code(this.id,'country_code');" title="Select Country Name" data-toggle="tooltip" required>
                                <option value="">Select Country</option>
                                    <?php
                                    $sq_country = mysqlQuery("select * from country_list_master where 1");
                                    while($row_country = mysqli_fetch_assoc($sq_country)){ ?>
                                    <option value="<?= $row_country['country_id'] ?>"><?= $row_country['country_name'].'('.$row_country['country_code'].')' ?></option>
                                    <?php } ?>
                            </select>
                            </div>
                        </div>
                        </div>
                        <div class="row c-infoRow">
                            <div class="col-md-3 col-sm-6">
                                <div class="formField">
                                    <input type="text" class="infoRow_txtbox" id="country_code" title='Country Code' data-toggle="tooltip" placeholder="Country Code" readonly/>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="formField">
                                    <input type="number" minlength='4' maxlength='12' class="infoRow_txtbox" placeholder="*Contact Number" id="contact_no" name="contact_no" title="Enter Contant Number" data-toggle="tooltip" required />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="formField">
                                    <textarea class="infoRow_txtbox" placeholder="Special Request" id="sp_request" title="Special Request" data-toggle="tooltip" ></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- ***** Info Row End ***** -->

                    </div>
                    <!-- ***** Room Row End ***** -->

                    <!-- ***** Room Row ***** -->
                    <?php
                    for($i=0;$i<sizeof($hotel_list_arr);$i++){ ?>

                        <div class="title"><?= stripslashes($hotel_list_arr[$i]['service']['hotel_arr']['hotel_name']) ?></div>
                        <?php
                        for($i_room=0;$i_room<sizeof($hotel_list_arr[$i]['service']['final_arr']);$i_room++){
                            $dummy_id = 'Room'.$hotel_list_arr[$i]['service']['final_arr'][$i_room]['rooms']['room'];
                            ?>
                            <div class="section">
                            <div class="title">Room <?=$hotel_list_arr[$i]['service']['final_arr'][$i_room]['rooms']['room']?></div>

                            <!-- ***** Info Row ***** -->
                            <!-- For Adult -->
                            <?php for($j=1;$j<=$hotel_list_arr[$i]['service']['final_arr'][$i_room]['rooms']['adults'];$j++){ ?>
                            <div class="row c-infoRow">
                                <div class="col-md-2 col-sm-6">
                                    <label>Adult <?=$j?>: </label>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="formField">
                                        <div class="selector">
                                        <select class="full-width" id="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'adult'.$j.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="formField">
                                        <input type="text" class="infoRow_txtbox" placeholder="*First Name" name ="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'adult'.$j.'fname'?>" id="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'adult'.$j.'fname'?>" title="Enter First Name" data-toggle="tooltip"  onkeypress="return blockSpecialChar(event);" required/>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="formField">
                                        <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'adult'.$j.'lname'?>" id="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'adult'.$j.'lname'?>" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- For Child -->
                            <?php for($k=1;$k<=$hotel_list_arr[$i]['service']['final_arr'][$i_room]['rooms']['child'];$k++){ ?>
                            <div class="row c-infoRow">
                            <div class="col-md-2 col-sm-6">
                                <label>Child <?=$k?>: </label>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                    <div class="formField">
                                    <div class="selector">
                                    <select class="full-width" id="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'child'.$k.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="formField">
                                    <input type="text" class="infoRow_txtbox" placeholder="*First Name" name="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'child'.$k.'fname'?>" id="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'child'.$k.'fname'?>" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="formField">
                                <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'child'.$k.'lname'?>" id="<?='p'.$hotel_list_arr[$i]['service']['id'].$dummy_id.'child'.$k.'lname'?>" title="Enter last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                </div>
                            </div>
                            </div>
                            <?php } ?>
                            <!-- ***** Info Row End ***** -->

                        </div>
                        <?php }
                    } ?>
                    <!-- ***** Room Row End ***** -->

                    <!-- ***** Room Row ***** -->
                    <?php
                    for($i=0;$i<sizeof($tours_list_arr);$i++){

                        $adult = $tours_list_arr[$i]['service']['service_arr'][0]['adult'];
                        $childwo = $tours_list_arr[$i]['service']['service_arr'][0]['childwo'];
                        $childwi = $tours_list_arr[$i]['service']['service_arr'][0]['childwi'];
                        $infant = $tours_list_arr[$i]['service']['service_arr'][0]['infant'];
                        $extra_bed = $tours_list_arr[$i]['service']['service_arr'][0]['extra_bed'];
                        $package_item = explode('-',$tours_list_arr[$i]['service']['service_arr'][0]['package_type']);
                        ?>

                        <div class="title"><?= stripslashes($tours_list_arr[$i]['service']['service_arr'][0]['package']).'('.$package_item[0].')' ?></div>
                            <!-- Adult -->
                            <?php
                            for($i_room=0;$i_room<intval($adult);$i_room++){
                            
                                ?>
                                <div class="section">
                                <div class="title">Adult <?= ($i_room+1) ?></div>

                                <!-- For Adult -->
                                <div class="row c-infoRow">
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Dr.">Dr.</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*First Name" name ="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'fname'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'fname'?>" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'lname'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'lname'?>" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Birthdate" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'bdate'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'bdate'?>" title="Enter Birthdate" data-toggle="tooltip" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width"  id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'meal'?>" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'adult'.'meal'?>" title="Meal Preference" data-toggle="tooltip">
                                                <option value="">Meal Preference</option>
                                                <option value="Jain Special">Jain Special</option>
                                                <option value="Veg">Veg</option>
                                                <option value="Non Veg">Non Veg</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <script>
                                $('#'+'p'+<?=$tours_list_arr[$i]['service']['id']?>+<?=$i_room?>+'adult'+'bdate').datetimepicker({ format:'d/m/Y', timepicker:false});
                                </script>
                                <?php
                            } ?>
                            <!-- Adult End -->
                            <!-- Child Without -->
                            <?php
                            for($i_room=0;$i_room<intval($childwo);$i_room++){
                            
                                ?>
                                <div class="section">
                                <div class="title">Child Without Bed <?= ($i_room+1) ?></div>

                                <!-- For Childwo -->
                                <div class="row c-infoRow">
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Dr.">Dr.</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*First Name" name ="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'fname'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'fname'?>" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'lname'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'lname'?>" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Birthdate" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'bdate'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'bdate'?>" title="Enter Birthdate" data-toggle="tooltip" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width"  id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'meal'?>" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwo'.'meal'?>" title="Meal Preference" data-toggle="tooltip">
                                                <option value="">Meal Preference</option>
                                                <option value="Jain Special">Jain Special</option>
                                                <option value="Veg">Veg</option>
                                                <option value="Non Veg">Non Veg</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <script>
                                    $('#'+'p'+<?=$tours_list_arr[$i]['service']['id']?>+<?=$i_room?>+'childwo'+'bdate').datetimepicker({ format:'d/m/Y', timepicker:false});
                                </script>
                                <?php
                            } ?>
                            <!-- Child Without End-->
                            <!-- Child With -->
                            <?php
                            for($i_room=0;$i_room<intval($childwi);$i_room++){
                                ?>
                                <div class="section">
                                <div class="title">Child With Bed <?= ($i_room+1) ?></div>

                                <!-- For Childwi -->
                                <div class="row c-infoRow">
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Dr.">Dr.</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*First Name" name ="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'fname'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'fname'?>" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'lname'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'lname'?>" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Birthdate" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'bdate'?>" id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'bdate'?>" title="Enter Birthdate" data-toggle="tooltip" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width"  id="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'meal'?>" name="<?='p'.$tours_list_arr[$i]['service']['id'].$i_room.'childwi'.'meal'?>" title="Meal Preference" data-toggle="tooltip">
                                                <option value="">Meal Preference</option>
                                                <option value="Jain Special">Jain Special</option>
                                                <option value="Veg">Veg</option>
                                                <option value="Non Veg">Non Veg</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <script>
                                    $('#'+'p'+<?=$tours_list_arr[$i]['service']['id']?>+<?=$i_room?>+'childwi'+'bdate').datetimepicker({ format:'d/m/Y', timepicker:false});
                                </script>
                                <?php
                            } ?>
                            <!-- Child Without End-->
                        <?php
                    } ?>
                    <!-- ***** Room Row End ***** -->
                    <!-- ***** Room Row ***** -->
                    <?php
                    for($i=0;$i<sizeof($ferry_list_arr);$i++){

                        $adult = $ferry_list_arr[$i]['service']['service_arr'][0]['adults'];
                        $childwo = $ferry_list_arr[$i]['service']['service_arr'][0]['children'];
                        ?>

                        <div class="title"><?= stripslashes($ferry_list_arr[$i]['service']['service_arr'][0]['ferry_name']).' '.$ferry_list_arr[$i]['service']['service_arr'][0]['ferry_type'] ?></div>
                            <!-- Adult -->
                            <?php
                            for($i_room=0;$i_room<intval($adult);$i_room++){
                            
                                ?>
                                <div class="section">
                                <div class="title">Adult <?= ($i_room+1) ?></div>

                                <!-- For Adult -->
                                <div class="row c-infoRow">
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Dr.">Dr.</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*First Name" name ="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'fname'?>" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'fname'?>" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'lname'?>" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'lname'?>" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Birthdate" name="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'bdate'?>" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'bdate'?>" title="Enter Birthdate" data-toggle="tooltip" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width"  id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'meal'?>" name="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'adult'.'meal'?>" title="Meal Preference" data-toggle="tooltip">
                                                <option value="">Meal Preference</option>
                                                <option value="Jain Special">Jain Special</option>
                                                <option value="Veg">Veg</option>
                                                <option value="Non Veg">Non Veg</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <script>
                                $('#'+'f'+<?=$ferry_list_arr[$i]['service']['id']?>+<?=$i_room?>+'adult'+'bdate').datetimepicker({ format:'d/m/Y', timepicker:false});
                                </script>
                                <?php
                            } ?>
                            <!-- Adult End -->
                            <!-- Child Without -->
                            <?php
                            for($i_room=0;$i_room<intval($childwo);$i_room++){
                            
                                ?>
                                <div class="section">
                                <div class="title">Child <?= ($i_room+1) ?></div>

                                <!-- For Childwo -->
                                <div class="row c-infoRow">
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'honorofic'?>" title="Select Honorific" data-toggle="tooltip">
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Dr.">Dr.</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*First Name" name ="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'fname'?>" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'fname'?>" title="Enter First Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Last Name" name="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'lname'?>" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'lname'?>" title="Enter Last Name" data-toggle="tooltip" onkeypress="return blockSpecialChar(event);" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="formField">
                                            <input type="text" class="infoRow_txtbox" placeholder="*Birthdate" name="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'bdate'?>" id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'bdate'?>" title="Enter Birthdate" data-toggle="tooltip" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="formField">
                                            <div class="selector">
                                            <select class="full-width"  id="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'meal'?>" name="<?='f'.$ferry_list_arr[$i]['service']['id'].$i_room.'childwo'.'meal'?>" title="Meal Preference" data-toggle="tooltip">
                                                <option value="">Meal Preference</option>
                                                <option value="Jain Special">Jain Special</option>
                                                <option value="Veg">Veg</option>
                                                <option value="Non Veg">Non Veg</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <script>
                                    $('#'+'f'+<?=$ferry_list_arr[$i]['service']['id']?>+<?=$i_room?>+'childwo'+'bdate').datetimepicker({ format:'d/m/Y', timepicker:false});
                                </script>
                                <?php
                            } ?>
                            <!-- Child Without End-->
                        <?php
                    } ?>
                    <!-- ***** Room Row End ***** -->
                </div>
                </div>
            </div>
            <div class='text-center loadMoreContainer' id="payment_div">
                <button id="credit_button" title="Proceed With Credit Limit Amount" data-toggle="tooltip" class="loadBtn m10-btm" value="Credit">Proceed with Credit</button>
                <button id="payment_button" title="Proceed to Payment" data-toggle="tooltip" class="loadBtn m10-btm" value="Payment" >Proceed to payment</button>
            </div>
        </form>
    </div>
    <!-- ***** Traveller Info Section End ***** -->
    <!-- ***************END******************** -->
    </div>
</div>
</div>
<script>
$(document).ready(function() {

    if($("[data-toggle='tooltip']").length > 0){
        $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
    }
    initilizeDropdown();
    $("#frm_traveller_details").validate({
        rules: {
            cfname: "required",
            clname: "required",
            email_id: {required:true,email:true},
            contact_no : {required:true, minlength:'4',maxlength:'12'},
            country_id : "required"
        },
        messages: {
            cfname: "Please Enter First Name",
            clname: "Please Enter Last Name",
            email_id: "Please Enter Valid Email",
            country_id: "Please Select Country",
            contact_no: "Enter Contact Number(4 to 12 digits)"
        }
    });
});

$('#credit_button').click(function(e) {

    $("#frm_traveller_details").valid();
    var base_url = $('#base_url').val();
    var register_id = $('#register_id').val();
    var customer_id = $('#customer_id').val();
    var currency_id = $('#global_currency').val();
    
    var cart_total_list = JSON.parse(localStorage.getItem('cart_total_list'));
    if (typeof Storage !== 'undefined'){
        if (sessionStorage) {
            var timing_slots = window.sessionStorage.getItem('timing_slots');
        }
        else {
            var timing_slots = localStorage.getItem('timing_slots');
        }
    }
    var currency_rates = get_currency_rates(cart_total_list[0].id,currency_id).split('-');
    var to_currency_rate =  currency_rates[0];
    var from_currency_rate = currency_rates[1];
    var payment_amount = $('#payment_amount').val();

   // var payment_amount =  parseFloat(to_currency_rate / from_currency_rate * cart_total_list[0].amount).toFixed(2);

    //Credit Limit Balance validations
    $.post(base_url + 'controller/b2b_customer/sale/credit_validation.php', { register_id:register_id,customer_id:customer_id,booking_amount:payment_amount }, function (data) {
        if(data=="success"){
            //Contact Information
            var cpfname = $('#cfname').val();
            var cplname = $('#clname').val();
            var email_id = $('#email_id').val();
            var country_id = $('#country_id').val();
            var country_code = $('#country_code').val();
            var contact_no = $('#contact_no').val();
            var sp_request = $('#sp_request').val();

            var email_id_error = $('#email_id-error').html();
            var contact_no_error = $('#contact_no-error').html();
            if(cpfname == ''){ return false; }
            if(cplname == ''){ return false; }
            if(email_id == ''){ return false; }
            if(country_id == ''){ return false; }
            if(contact_no == ''){ return false; }
            if($('#email_id-error').length){
                if(email_id_error != ''){
                    error_msg_alert('Enter valid email-id');
                    return false;
                }
            }
            if($('#contact_no-error').length){
                if(contact_no_error != ''){
                    error_msg_alert('Enter valid contact no');
                    return false;
                }
            }
            //Hotelwise Room-passengers Details
            var cart_checkout_data = JSON.parse($('#cart_checkout_data').val());
            var hotel_arr = [];
            var coupon_code = '';
            for(var i=0;i<cart_checkout_data.length;i++){
                if(cart_checkout_data[i]['service']['name'] == 'Hotel'){
                    var room_arr = [];
                    for(var i_room=0;i_room<cart_checkout_data[i]['service']['final_arr'].length;i_room++){
                        var dummy_id = 'Room'+cart_checkout_data[i]['service']['final_arr'][i_room]['rooms']['room'];
                        var adult_arr = [];
                        for(var j=1;j<=cart_checkout_data[i]['service']['final_arr'][i_room]['rooms']['adults'];j++){
                            var adult_count = 'Adult'+j; // Adult No
                            var honorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'adult'+j+'honorofic').val();
                            var fname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'adult'+j+'fname').val();
                            var lname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'adult'+j+'lname').val();

                            if(fname == ''){ return false; }
                            if(lname == ''){ return false; }
                            
                            var adult_arr1 = {
                                adult_count:adult_count,
                                honorofic:honorofic,
                                fname:fname,
                                lname:lname
                            };
                            adult_arr.push(adult_arr1);
                        }
                        var child_arr = [];
                        for(var k=1;k<=cart_checkout_data[i]['service']['final_arr'][i_room]['rooms']['child'];k++){
                            var child_count = 'Child'+k; // Adult No
                            var chonorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'child'+k+'honorofic').val();
                            var cfname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'child'+k+'fname').val();
                            cfname = escape(cfname);
                            var clname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'child'+k+'lname').val();
                            clname = escape(clname);
                            
                            if(cfname == ''){ return false;}
                            if(clname == ''){ return false;}
                            var child_arr1 = {
                                child_count:child_count,
                                chonorofic:chonorofic,
                                cfname:cfname,
                                clname:clname
                            };
                            child_arr.push(child_arr1);
                        }
                        room_arr.push({
                            dummy_id : {
                                adult_arr:adult_arr,
                                child_arr:child_arr
                            }
                        });
                    }
                    hotel_arr.push({
                        service :{
                            name:'Hotel',
                            id:cart_checkout_data[i]['service']['id'],
                            room_arr:room_arr               
                        }
                    });
                }
                
                if(cart_checkout_data[i]['service']['name'] == 'Combo Tours'){
                    
                    var adult = cart_checkout_data[i]['service']['service_arr'][0]['adult'];
                    var childwi = cart_checkout_data[i]['service']['service_arr'][0]['childwi'];
                    var childwo = cart_checkout_data[i]['service']['service_arr'][0]['childwo'];
                    var infant = cart_checkout_data[i]['service']['service_arr'][0]['infant'];
                    var extra_bed = cart_checkout_data[i]['service']['service_arr'][0]['extra_bed'];
                    // Adult
                    var package_adult_arr = [];
                    for(var i_room=0;i_room<parseInt(adult);i_room++){

                        var honorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'honorofic').val();
                        var fname = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'fname').val();
                        var lname = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'lname').val();
                        var birthdate = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'bdate').val();
                        var meal = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'meal').val();

                        if(fname == ''){ return false; }
                        if(lname == ''){ return false; }
                        if(birthdate == ''){ return false; }
                        
                        var adult_arr1 = {
                            count:i_room,
                            honorofic:honorofic,
                            fname:fname,
                            lname:lname,
                            birthdate:birthdate,
                            meal:meal
                        };
                        package_adult_arr.push(adult_arr1);
                    }
                    // Child with bed
                    var package_cwb_arr = [];
                    for(var i_room=0;i_room<parseInt(childwi);i_room++){

                        var honorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwi'+'honorofic').val();
                        var fname = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwi'+'fname').val();
                        var lname = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwi'+'lname').val();
                        var birthdate = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwi'+'bdate').val();
                        var meal = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwi'+'meal').val();

                        if(fname == ''){ return false; }
                        if(lname == ''){ return false; }
                        if(birthdate == ''){ return false; }
                        
                        var cwb_arr1 = {
                            count:i_room,
                            honorofic:honorofic,
                            fname:fname,
                            lname:lname,
                            birthdate:birthdate,
                            meal:meal
                        };
                        package_cwb_arr.push(cwb_arr1);
                    }
                    // Child without bed
                    var package_cwob_arr = [];
                    for(var i_room=0;i_room<parseInt(childwo);i_room++){

                        var honorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'honorofic').val();
                        var fname = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'fname').val();
                        var lname = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'lname').val();
                        var birthdate = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'bdate').val();
                        var meal = $("#"+'p'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'meal').val();

                        if(fname == ''){ return false; }
                        if(lname == ''){ return false; }
                        if(birthdate == ''){ return false; }
                        
                        var cwb_arr1 = {
                            count:i_room,
                            honorofic:honorofic,
                            fname:fname,
                            lname:lname,
                            birthdate:birthdate,
                            meal:meal
                        };
                        package_cwob_arr.push(cwb_arr1);
                    }
                    hotel_arr.push({
                        service :{
                            name:'Combo Tours',
                            id:cart_checkout_data[i]['service']['id'],
                            adults : package_adult_arr,
                            cwb : package_cwb_arr,
                            cwob : package_cwob_arr
                        }
                    });
                }
                
                if(cart_checkout_data[i]['service']['name'] == 'Ferry'){
                    
                    var adult = cart_checkout_data[i]['service']['service_arr'][0]['adults'];
                    var child = cart_checkout_data[i]['service']['service_arr'][0]['children'];
                    // Adult
                    var ferry_adult_arr = [];
                    for(var i_room=0;i_room<parseInt(adult);i_room++){

                        var honorofic = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'honorofic').val();
                        var fname = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'fname').val();
                        var lname = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'lname').val();
                        var birthdate = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'bdate').val();
                        var meal = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'adult'+'meal').val();

                        if(fname == ''){ return false; }
                        if(lname == ''){ return false; }
                        if(birthdate == ''){ return false; }
                        
                        var adult_arr1 = {
                            count:i_room,
                            honorofic:honorofic,
                            fname:fname,
                            lname:lname,
                            birthdate:birthdate,
                            meal:meal
                        };
                        ferry_adult_arr.push(adult_arr1);
                    }
                    var ferry_child_arr = [];
                    for(var i_room=0;i_room<parseInt(child);i_room++){

                        var honorofic = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'honorofic').val();
                        var fname = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'fname').val();
                        var lname = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'lname').val();
                        var birthdate = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'bdate').val();
                        var meal = $("#"+'f'+cart_checkout_data[i]['service']['id']+i_room+'childwo'+'meal').val();

                        if(fname == ''){ return false; }
                        if(lname == ''){ return false; }
                        if(birthdate == ''){ return false; }
                        
                        var cwb_arr1 = {
                            count:i_room,
                            honorofic:honorofic,
                            fname:fname,
                            lname:lname,
                            birthdate:birthdate,
                            meal:meal
                        };
                        ferry_child_arr.push(cwb_arr1);
                    }
                    hotel_arr.push({
                        service :{
                            name:'Ferry',
                            id:cart_checkout_data[i]['service']['id'],
                            adults : ferry_adult_arr,
                            children : ferry_child_arr
                        }
                    });
                }
            }

            //If coupon apllied
            if (typeof Storage !== 'undefined'){
                if (localStorage) {
                    var coupon_apply_status = JSON.parse(localStorage.getItem('coupon_apply_status'));
                } else {
                    var coupon_apply_status = JSON.parse(window.sessionStorage.getItem('coupon_apply_status'));
                }
            }
            if(coupon_apply_status !== null){
                if(coupon_apply_status.applied != 'false'){
                    coupon_code = coupon_apply_status.promo_code;
                }else{
                    coupon_code = '';
                }
            }else{
                coupon_code = '';
            }
            //Currency
            if (typeof Storage !== 'undefined') {
                if (localStorage) {
                    var global_currency = localStorage.getItem('global_currency');
                }
                else {
                    var global_currency = window.sessionStorage.getItem('global_currency');
                }
            }
            if (typeof Storage !== 'undefined'){
                if (localStorage) {
                    localStorage.removeItem("cart_list_arr");
                    localStorage.removeItem("cart_item_list");
                    localStorage.removeItem("cart_total_list");
                    localStorage.removeItem("cart_subtotal_list");
                    localStorage.removeItem("cart_totaltax_list");
                    localStorage.removeItem("cart_grandtotal_list");
                    localStorage.removeItem("cart_amount_list");
                    localStorage.removeItem("cart_tax_list");
                    localStorage.removeItem("cart_maintotal_list");
                }
            }

            $.ajax({
            url: base_url + 'controller/b2b_customer/sale/b2b_sale_save.php',
            type: "POST",
            data: {
                payment_amount:payment_amount,customer_id: customer_id,fname:cpfname,lname:cplname,email_id:email_id,country_id:country_id,country_code:country_code,contact_no:contact_no,sp_request:sp_request,cart_checkout_data:cart_checkout_data,traveller_details:hotel_arr,coupon_code:coupon_code,global_currency:global_currency,timing_slots:timing_slots
            },
            cache: false,
            success: function(data1){
                console.log(data1);
            }
            });
            $.alert({
                title: 'Notification!',
                content: 'Booking saved successfully.Thank you so much!',
            });
            setTimeout(() => {
                window.location.href= '../view/index.php';
            }, 2000);
        }
        else{
            $.alert({
                title: 'Notification!',
                content: data,
            });
            return true;
        }
    });
    e.preventDefault();
});

document.getElementById("payment_button").addEventListener("click", function(event){
        
    var base_url = $('#base_url').val();
    var currency = $('#global_currency').val();
    //Currency
    if (typeof Storage !== 'undefined') {
        if (localStorage) {
            var global_currency = localStorage.getItem('global_currency');
        }
        else {
            var global_currency = window.sessionStorage.getItem('global_currency');
        }
    }
    // if(currency == global_currency){
        var register_id = $('#register_id').val();
        var customer_id = $('#customer_id').val();
        var payment_amount = $('#payment_amount').val();
        
        if (typeof Storage !== 'undefined'){
            if (sessionStorage) {
                var timing_slots = window.sessionStorage.getItem('timing_slots');
            }
            else {
                var timing_slots = localStorage.getItem('timing_slots');
            }
        }
        //Contact Information
        var cpfname = $('#cfname').val();
        var cplname = $('#clname').val();
        var email_id = $('#email_id').val();
        var country_id = $('#country_id').val();
        var country_code = $('#country_code').val();
        var contact_no = $('#contact_no').val();
        var sp_request = $('#sp_request').val();

        if(cpfname == ''){ return false; }
        if(cplname == ''){ return false; }
        if(email_id == ''){ return false; }
        if(country_id == ''){ return false; }
        if(contact_no == ''){ return false; }
        
        //Hotelwise Room-passengers Details
        var cart_checkout_data = JSON.parse($('#cart_checkout_data').val());
        var hotel_arr = [];
        for(var i=0;i<cart_checkout_data.length;i++){
            if(cart_checkout_data[i]['service']['name'] == 'Hotel'){
                var room_arr = [];
                for(var i_room=0;i_room<cart_checkout_data[i]['service']['final_arr'].length;i_room++){
                    var dummy_id = 'Room'+cart_checkout_data[i]['service']['final_arr'][i_room]['rooms']['room'];
                    var adult_arr = [];
                    for(var j=1;j<=cart_checkout_data[i]['service']['final_arr'][i_room]['rooms']['adults'];j++){
                        var adult_count = 'Adult'+j; // Adult No
                        var honorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'adult'+j+'honorofic').val();
                        var fname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'adult'+j+'fname').val();
                        var lname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'adult'+j+'lname').val();

                        if(fname == ''){ return false; }
                        if(lname == ''){ return false; }
                        
                        var adult_arr1 = {
                            adult_count:adult_count,
                            honorofic:honorofic,
                            fname:fname,
                            lname:lname
                        };
                        adult_arr.push(adult_arr1);
                    }
                    var child_arr = [];
                    for(var k=1;k<=cart_checkout_data[i]['service']['final_arr'][i_room]['rooms']['child'];k++){
                        var child_count = 'Child'+k; // Adult No
                        var chonorofic = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'child'+k+'honorofic').val();
                        var cfname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'child'+k+'fname').val();
                        var clname = $("#"+'p'+cart_checkout_data[i]['service']['id']+dummy_id+'child'+k+'lname').val();
                        
                        if(cfname == ''){ return false;}
                        if(clname == ''){ return false;}
                        var child_arr1 = {
                            child_count:child_count,
                            chonorofic:chonorofic,
                            cfname:cfname,
                            clname:clname
                        };
                        child_arr.push(child_arr1);
                    }
                    room_arr.push({
                        dummy_id : {
                            adult_arr:adult_arr,
                            child_arr:child_arr
                        }
                    });
                }
                hotel_arr.push({
                    service :{
                        name:'Hotel',
                        id:cart_checkout_data[i]['service']['id'],
                        room_arr:room_arr               
                    }
                });
            }
        }

        //If coupon apllied
        if (typeof Storage !== 'undefined'){
            if (localStorage) {
                var coupon_apply_status = JSON.parse(localStorage.getItem('coupon_apply_status'));
            } else {
                var coupon_apply_status = JSON.parse(window.sessionStorage.getItem('coupon_apply_status'));
            }
        }
        if(coupon_apply_status !== null){
            if(coupon_apply_status.applied != 'false'){
                var coupon_code = coupon_apply_status.promo_code;
            }else{
                coupon_code = '';
            }
        }else{
            coupon_code = '';
        }

        var btn = document.getElementById('payment_button');
        btn.disabled = true;
        btn.innerText = 'Loading...'
        $.post(base_url + 'controller/b2b_customer/sale/sale_save.php', { payment_amount:payment_amount,customer_id: customer_id,fname:cpfname,lname:cplname,email_id:email_id,country_id:country_id,country_code:country_code,contact_no:contact_no,sp_request:sp_request,cart_checkout_data:cart_checkout_data,traveller_details:hotel_arr,coupon_code:coupon_code,global_currency:global_currency,timing_slots:timing_slots }, function (data) {
            btn.disabled = true;
            btn.innerText = 'Proceed to payment';
            //RAZORPay
            if(data == ''){
                error_msg_alert('Payment Gateway not selected.You can not proceed!');
                return false;
            }
            else{
                if (typeof Storage !== 'undefined') {
                    if (localStorage) {
                        localStorage.removeItem("cart_list_arr");
                        localStorage.removeItem("cart_item_list");
                        localStorage.removeItem("cart_total_list");
                        localStorage.removeItem("cart_subtotal_list");
                        localStorage.removeItem("cart_totaltax_list");
                        localStorage.removeItem("cart_grandtotal_list");
                        localStorage.removeItem("cart_amount_list");
                        localStorage.removeItem("cart_tax_list");
                        localStorage.removeItem("cart_maintotal_list");
                    }
                    if (sessionStorage) {
                        window.sessionStorage.removeItem("timing_slots");
                    }
                }
                if(data == "RazorPay"){
                    window.location.href = base_url + 'Tours_B2B/payments/razor-pay/index.php';
                }
                else if(data=="CCAvenue"){
                    window.location.href = base_url + 'Tours_B2B/payments/ccavenue/dataFrom.php';
                }
            }
        });
        return true;
    // }
    // else{
    //     var msgs = "Please change the selected currency as it's not supported to checkout!";
    //     $.alert({
    //         title: 'Notification',
    //         content: msgs,
    //         icon:'icon itours-exclamation-circle',
    //     });
    //     // setTimeout(() => {
    //         event.preventDefault()
    //     // },1000);
    // }
    return true;
});

</script>