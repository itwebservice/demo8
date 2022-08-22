<?php
include "../../../../model/model.php";
$booking_id = $_POST['booking_id'];
$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_booking where booking_id='$booking_id'"));
$date = $sq_booking['created_at'];
$yr = explode("-", $date);
$year = $yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_car_rental_booking_id($booking_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">

        <div class="row">
        <div class="col-md-12">

          <div class="profile_box main_block">

            <div class="row">

              <div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd">

                <span class="main_block"> 
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Vehicle Name <em>:</em></label> " .$sq_booking['vehicle_name']; ?>
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Travel Type <em>:</em></label> " .$sq_booking['travel_type']; ?> 
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Capacity <em>:</em></label> " .$sq_booking['capacity']; ?> 
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Travel Date <em>:</em></label> " .get_date_user($sq_booking['from_date']).' To '.get_date_user($sq_booking['to_date']); ?> 
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Rate <em>:</em></label> " .$sq_booking['rate']; ?> 
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Extra Km Rate <em>:</em></label> " .$sq_booking['extra_km']; ?> 
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Extra Hr Rate <em>:</em></label> " .$sq_booking['extra_hr_cost']; ?> 
                </span>
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Total Max Km <em>:</em></label> " .$sq_booking['total_max_km']; ?> 
                </span>
                <?php
                if($sq_booking['local_places_to_visit'] != ''){ ?>
                  <span class="main_block">
                    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                    <?php echo "<label>Route <em>:</em></label> ".$sq_booking['local_places_to_visit'];?> 
                  </span> 
                <?php } ?>
                <?php
                if($sq_booking['total_km'] != 0){ ?>
                  <span class="main_block">
                    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                    <?php echo "<label>Total Km <em>:</em></label> ".$sq_booking['total_km'];?> 
                  </span> 
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#visa_display_modal').modal('show');
</script>