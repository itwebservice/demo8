<?php
include "../../model/model.php";
$nofquotation = $_REQUEST['nofquotation'];
?>
<div class="col-md-12 app_accordion">
    <div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
        <?php 
        for($i = 1; $i <= $nofquotation; $i++){
        ?>
        <div class="accordion_content package_content mg_bt_10">
            <div class="panel panel-default main_block">
                <div class="panel-heading main_block" role="tab" id="heading_<?= $i ?>">
                    <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?= $i; ?>" aria-expanded="false" aria-controls="collapse_<?= $i; ?>" id="collapsed_<?= $i ?>">                
                        <div class="col-md-12"><span><em style="margin-left: 15px;">Option - <?php echo $i ?></em></span></div>
                    </div>
                </div>
                <div id="collapse_<?= $i?>" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading_<?= $i ?>">
                    <div class="panel-body">
                        <div class="col-md-12 no-pad" id="div_list1">
                            <div class="row mg_bt_10">
                                <div class="col-xs-12 text-right text_center_xs">
                                    <button type="button" class="btn btn-excel btn-sm" onClick="addRow('dynamic_table_list_h_<?= $i ?>','<?= $i ?>');city_lzloading('.city_master_dropdown')"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('dynamic_table_list_h_<?= $i ?>')"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table style="width: 100%" id="dynamic_table_list_h_<?= $i ?>" name="dynamic_table_list_h_<?= $i ?>" class="table table-bordered table-hover table-striped no-marg pd_bt_51 mg_bt_0">
                                    <tr>
                                        <td style="width: 50px;"><input class="css-checkbox mg_bt_10" id="chk_program-<?= $i ?>-1" type="checkbox" checked><label class="css-label" for="chk_program-<?= $i ?>-1"> <label>
                                        </td>

                                        <td style="width: 50px;"><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control mg_bt_10" disabled />
                                        </td>

                                        <td><select id="city_name-<?= $i ?>-1" name="city_name-<?= $i ?>-1" class="city_master_dropdown" style="width:160px" onchange="hotel_name_list_load(this.id);" title="Select City Name">
                                        </select>
                                        </td>

                                        <td><select id="hotel_name-<?= $i ?>-1" name="hotel_name-<?= $i ?>-1" onchange="hotel_type_load(this.id);get_hotel_cost('dynamic_table_list_h_<?= $i ?>');" style="width:160px" title="Select Hotel Name">
                                        <option value="">Hotel Name</option>
                                        </select>
                                        </td>

                                        <td><select name="room_cat-<?= $i ?>-1" id="room_cat-<?= $i ?>-1" style="width:145px;" title="Room Category" class="form-control app_select2" onchange="get_hotel_cost('dynamic_table_list_h_<?= $i ?>');"><?php get_room_category_dropdown(); ?></select>
                                        </td>

                                        <td><select name="meal_plan-<?= $i ?>-1" id="meal_plan-<?= $i ?>-1" style="width:145px;" title="Meal Plan" class="form-control app_select2"><?php get_mealplan_dropdown(); ?></select>
                                        </td>

                                        <td><input type="text" style="width:150px;" class="app_datepicker" id="check_in-<?= $i ?>-1" name="check_in-<?= $i ?>-1" placeholder="Check-In Date" title="Check-In Date"  onchange="get_auto_to_date(this.id);get_hotel_cost('dynamic_table_list_h_<?= $i ?>');"></td>

                                        <td><input type="text" style="width:150px;" class="app_datepicker" id="check_out-<?= $i ?>-1" name="check_out-<?= $i ?>-1" placeholder="Check-Out Date" title="Check-Out Date" onchange="calculate_total_nights(this.id);validate_validDates(this.id);get_hotel_cost('dynamic_table_list_h_<?= $i ?>');"></td>

                                        <td><input type="text" id="hotel_type-<?= $i ?>-1" name="hotel_type-1" placeholder="Hotel Category" title="Hotel Category" style="width:150px" readonly></td>

                                        <td><input type="text" id="hotel_stay_days-<?= $i ?>-1" title="Total Nights" name="hotel_stay_days-<?= $i ?>-1" placeholder="Total Nights" onchange="validate_balance(this.id);" style="width:150px;" readonly></td>

                                        <td><input type="text" id="no_of_rooms-<?= $i ?>-1" title="Total Rooms" name="no_of_rooms-<?= $i ?>-1" placeholder="*Total Rooms" onchange="validate_balance(this.id);get_hotel_cost('dynamic_table_list_h_<?= $i ?>');" style="width:110px"></td>

                                        <td><input type="text" id="extra_bed-<?= $i ?>-1" name="extra_bed-<?= $i ?>-1" title="Extra Bed" placeholder="Extra Bed" onchange="validate_balance(this.id);get_hotel_cost('dynamic_table_list_h_<?= $i ?>');" style="width:100px"></td>

                                        <td class="hidden"><input type="hidden" id="hotel_cost-<?= $i ?>-1" name="hotel_cost-<?= $i ?>-1" placeholder="Hotel Cost" title="Hotel Cost" onchange="validate_balance(this.id)" style="width:100px;"></td> 
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
    </div>
</div>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
    city_lzloading('.city_master_dropdown');
    $('.app_datepicker').datetimepicker({ format:'d-m-Y',timepicker:false });
</script>