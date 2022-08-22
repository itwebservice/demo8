<?php 
$sq_hotel_details_count = mysqli_num_rows(mysqlQuery("select * from group_tour_hotel_entries where tour_id='$tour_id'"));
if($sq_hotel_details_count==0)
{
	include_once('../booking_save/tab_2/hotel_info.php');
}else{
?>
<div class="row mg_tp_20"> <div class="col-xs-12"> <div class="table-responsive">       
<table id="tbl_package_hotel_master" name="tbl_package_hotel_master" class="table table-bordered table-hover no-marg pd_bt_51">

<?php
$count_p = 0;
$sq_hotel_details = mysqlQuery("select * from group_tour_hotel_entries where tour_id='$tour_id'");
while($row_hotel_details = mysqli_fetch_assoc($sq_hotel_details)){
    $city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id = ".$row_hotel_details['city_id']));
    $hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name from hotel_master where hotel_id = ".$row_hotel_details['hotel_id']));
$count_p++;
?>
    <tr>
		<td><input class="css-checkbox" id="chk_dest1<?= $count_p ?>" type="checkbox" disabled checked><label      class="css-label" for="chk_dest1" checked> <label></td>
		<td><input maxlength="15" value="<?= $count_p ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled />
		</td>
		<td><input id="city_name<?= $count_p ?>" name="city_name1" class="form-control" style="width:100%" title="City Name" value="<?= $city['city_name']?>" readonly> 
		</td>
		<td><input id="hotel_name<?= $count_p ?>" name="hotel_name1" style="width:100%" title="Hotel Name" class="form-control" value="<?= $hotel['hotel_name']?>" readonly>
		</td>
	    <td><input type="text" id="hotel_type<?= $count_p ?>" name="hotel_type1" placeholder="*Hotel Type" class="form-control" title="Hotel Type" value="<?= $row_hotel_details['hotel_type']?>" readonly></td>
		<td><input type="text" id="hotel_tota_days1<?= $count_p ?>"  name="hotel_tota_days1" placeholder="*Total Night(s)" class="form-control" title="Total Night(s)" value="<?= $row_hotel_details['total_nights']?>" readonly></td></td>
    </tr> 
<?php
} }
?>
</table>
</div> </div> </div>