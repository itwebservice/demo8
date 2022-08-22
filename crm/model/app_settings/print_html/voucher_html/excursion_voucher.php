<?php
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";

$booking_id = $_GET['booking_id'];
$booking_type = $_GET['booking_type'];
$emp_id = $_SESSION['emp_id'];

$sq_service_voucher = mysqli_fetch_assoc(mysqlQuery("select * from excursion_service_voucher where booking_id='$booking_id' and booking_type='excursion'"));
$sq_excname = mysqlQuery("select * from excursion_master_entries where exc_id='$booking_id'");
$total_adl=0;
$total_child=0;
while($row=mysqli_fetch_assoc($sq_excname))
{
  $total_adl=$total_adl+$row['total_adult'];
  $total_child=$total_child+$row['total_child'];
}

$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master where exc_id='$booking_id'"));
$sq_traveler = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
if($sq_traveler['type'] == 'Corporate'||$sq_traveler['type']=='B2B'){
  $name = $sq_traveler['company_name'];
}else{
  $name = $sq_traveler['first_name'].' '.$sq_traveler['last_name'];
}


$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0'){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }
?>
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> ACTIVITY SERVICE VOUCHER</span>
        <div class="print_header_logo">
          <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo $app_address; ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $app_contact_no; ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>
        </div>
      </div>
    </section>

    <!-- BOOKING -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>BOOKING DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CUSTOMER NAME :</span> <?= $name ?></li>
          </ul>
        </div>
        <div class="col-md-5 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>TOTAL GUEST(s) :</span> <?= $total_adl+$total_child ;?></li>
          </ul>
        </div>
      </div>
    </section>

    <!-- EXC Detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>DATE_TIME</th>
                <th>CITY NAME</th>
                <th>Activity NAME</th>
                <th>TRANSFER OPTION</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sq_exc_acc = mysqlQuery("select * from excursion_master_entries where exc_id='$booking_id'");
              while($row_exc_acc=mysqli_fetch_assoc($sq_exc_acc)){
                $sq_city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_exc_acc[city_id]'"));
                $sq_exc_name = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff where entry_id='$row_exc_acc[exc_name]'"));
              ?>
                <tr>
                  <td><?= get_datetime_user($row_exc_acc['exc_date']) ?></td>
                  <td><?= $sq_city_name['city_name'] ?></td>
                  <td><?= $sq_exc_name['excursion_name'] ?></td>
                  <td><?= $row_exc_acc['transfer_option'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <section class="print_sec main_block">
      <?php if($sq_service_voucher['note'] != ''){ ?>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>Note : </span><?= $sq_service_voucher['note'] ?></li>
            </ul>
          </div>
        </div>
      </div>
      <?php } ?>
    </section>

     <!-- Terms and Conditions -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Terms and Conditions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?php 
            $sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Activity Service Voucher' and active_flag ='Active'"));
            echo $sq_terms_cond['terms_and_conditions'];?>
          </div>
        </div>
      </div>
    </section>

    <!-- Payment Detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-5">
          <div class="print_quotation_creator text-center">
            <span>Generated BY </span><br><?= $emp_name ?>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>