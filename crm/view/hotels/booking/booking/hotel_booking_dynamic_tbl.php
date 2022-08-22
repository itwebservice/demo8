<tr>
    <td ><input id="chk_hotel<?= $prefix ?>_1" type="checkbox" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save')" checked ></td>
    <td><input maxlength="15" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
    <td><select id="city_id<?= $prefix ?>1" style="width:105px" name="city_id<?= $prefix ?>1" title="City" onchange="hotel_name_list_load(this.id);" data-toggle="tooltip" class="city_id" style="width:100%">
    </select>
    </td>    
    <td><select id="hotel_id1" name="hotel_id1" title="Hotel" style="width:130px" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');" data-toggle="tooltip">
            <option value="">*Select Hotel</option>
        </select>
    </td>
    <td><input type="text" data-toggle="tooltip" style="width:150px;" class="app_datetimepicker" id="check_in<?= $prefix ?>1" name="check_in<?= $prefix ?>1" placeholder="Check-In Date Time" title="Check-In Date Time" value="<?= date('d-m-Y H:i')?>" onchange="get_to_datetime(this.id,'check_out<?= $prefix ?>1');calculate_total_nights('check_in<?= $prefix ?>1', 'check_out<?= $prefix ?>1','no_of_nights<?= $prefix ?>1')"></td>
    <td><input type="text" data-toggle="tooltip" style="width:150px;" class="app_datetimepicker" id="check_out<?= $prefix ?>1" name="check_out<?= $prefix ?>1" placeholder="Check-Out Date Time" title="Check-Out Date Time" onchange="calculate_total_nights('check_in<?= $prefix ?>1', 'check_out<?= $prefix ?>1','no_of_nights<?= $prefix ?>1')" value="<?= date('d-m-Y H:i')?>"></td>
    <td><input type="text" data-toggle="tooltip" style="width:100px;" id="no_of_nights<?= $prefix ?>1" name="no_of_nights<?= $prefix ?>1" placeholder="*No Of Nights" title="No Of Nights" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');validate_balance(this.id)"></td>
    <td><input type="text" id="rooms<?= $prefix ?>1" style="width:100px;" name="rooms<?= $prefix ?>1" placeholder="*No Of Rooms" title="No Of Rooms" data-toggle="tooltip" onchange="get_auto_values('booking_date','sub_total','payment_mode','service_charge','markup','save','true','service_charge','discount');validate_balance(this.id)"></td>
    <td><select data-toggle="tooltip" style="width:120px" name="room_type<?= $prefix ?>1" id="room_type<?= $prefix ?>1" title="Room Type">
        <option value="">Room Type</option>
        <option value="AC">AC</option>
        <option value="Non AC">Non AC</option>
    </select></td>
    <td><select data-toggle="tooltip" style="width:140px" name="category<?= $prefix ?>1" id="category<?= $prefix ?>1" title="Category">
        <?php echo get_room_category_dropdown(); ?>   
    </select></td>
    <td><select data-toggle="tooltip" style="width:185px" name="accomodation_type<?= $prefix ?>1" id="accomodation_type<?= $prefix ?>1" title="Accommodation Type">
            <option value="">Accommodation Type</option>
            <option value="Single Adult">Single Adult</option>
            <option value="Twin Sharing">Twin Sharing</option>  
            <option value="Triple Sharing">Triple Sharing</option>
            <option value="Quadruple Sharing">Quadruple Sharing</option>
    </select></td>
    <td><input type="text" style="width:90px" data-toggle="tooltip" id="extra_beds<?= $prefix ?>1" name="extra_beds<?= $prefix ?>1" placeholder="*Extra Beds" title="Extra Beds" onchange="validate_balance(this.id)"></td>
    <td><select data-toggle="tooltip" style="width:120px" title="Meal Plan" id="meal_plan<?= $prefix ?>1" name="meal_plan<?= $prefix ?>1" title="Meal Plan" Placeholder="Meal Plan">
            <?php get_mealplan_dropdown(); ?>
    </select></td>
    <td><input type="text" style="width:110px" data-toggle="tooltip" id="conf_no<?= $prefix ?>1" name="conf_no<?= $prefix ?>1" placeholder="Confirmation No." title="Confirmation No."></td>
</tr>