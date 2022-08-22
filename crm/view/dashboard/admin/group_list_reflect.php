<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
$financial_year_id = $_SESSION['financial_year_id'];

$query = mysqli_fetch_assoc(mysqlQuery("select max(id) as booking_id from tourwise_traveler_details where financial_year_id='$financial_year_id'"));

$sq_traveler = "select * from traveler_personal_info where  where financial_year_id='$financial_year_id' ";

$query_package = "select * from package_tour_booking_master where  where financial_year_id='$financial_year_id'";

if($booking_id != ''){
  $sq_entry = mysqlQuery("select * from tourwise_traveler_details where id='$booking_id'");
}
else{
   $sq_entry = mysqlQuery("select * from tourwise_traveler_details where id='$query[booking_id]'");
}
$row_entry = mysqli_fetch_assoc($sq_entry);
 $sq_tour_name = mysqli_fetch_assoc(mysqlQuery("select  * from tour_master where tour_id = '$row_entry[tour_id]'"));
 $sq_traveler_personal_info = mysqli_fetch_assoc(mysqlQuery("select * from traveler_personal_info where tourwise_traveler_id='$query[booking_id]'"));
?>
<div class="col-md-7 col-sm-8 col-md-pull-3">
  <span class="tour_concern" style="margin-right: 30px;"><label>TOUR NAME  </label><em>:</em><?php echo $sq_tour_name['tour_name']; ?></span>
  <span class="tour_concern"><label>Mobile No </label><em>:</em><?php echo $sq_traveler_personal_info['mobile_no']; ?></span>
</div>
<div class="col-md-12 mg_tp_10">
      <div class="dashboard_table_body main_block">
        <div class="col-sm-9 no-pad table_verflow table_verflow_two"> 
          <div class="table-responsive no-marg-sm">
            <table class="table table-hover" style="margin: 0 !important;border: 0;padding: 0 !important;">
              <thead>
                <tr class="table-heading-row">
                  <th>S_No.</th>
                  <th>Passenger_Name</th>
                  <th>BIRTH_DATE</th>
                  <th>AGE</th>
                  <th>ID_Proof</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              $traveler_group_id = $row_entry['traveler_group_id'];
              $sq_entry = mysqlQuery("select * from travelers_details where traveler_group_id='$traveler_group_id'");
              while($row_entry1 = mysqli_fetch_assoc($sq_entry)){

                if($row_entry1['status']=="Cancel" || $row_entry['tour_group_status']=="Cancel"){
                  $bg="danger";
                }
                else {
                  $bg="#fff";
                }
                //paid
                $query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum,sum(credit_charges) as sumc from payment_master where tourwise_traveler_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
                $paid_amount = $query['sum']+$query['sumc'];
                $paid_amt = ($paid_amount == '')?'0':$paid_amount;

                $actual_tour_expense = $row_entry['net_total']+$query['sumc'] ;
                if($row_entry['tour_group_status'] == 'Cancel'){
                //Group Tour cancel
                $cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$booking_id'"));
                if($cancel_tour_count2 >= '1'){
                  $cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$booking_id'"));
                  $cancel_amount2 = $cancel_tour['cancel_amount'];
                }
                else{ $cancel_amount2 = 0; }

                if($cancel_esti_count1 >= '1'){
                  $cancel_amount = $cancel_amount1;
                }else{
                  $cancel_amount = $cancel_amount2;
                }	
              }
              else{
                // Group booking cancel
                $cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$booking_id'"));
                if($cancel_esti_count1 >= '1'){
                  $cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$booking_id'"));
                  $cancel_amount = $cancel_esti1['cancel_amount'];
                }
                else{ $cancel_amount = 0; }
              }
              $cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;
              if($row_entry['tour_group_status'] == 'Cancel'){
                if($cancel_amount > $paid_amt){
                  $balance_amt = $cancel_amount - $paid_amt;
                }
                else{
                  $balance_amt = 0;
                }
              }else{
                if($cancel_esti_count1 >= '1'){
                  if($cancel_amount > $paid_amt){
                    $balance_amt = $cancel_amount - $paid_amt;
                  }
                  else{
                    $balance_amt = 0;
                  }
                }
                else{
                  $balance_amt = $actual_tour_expense - $paid_amt;
                }
              }
              $count++;
              $age = $row_entry1['age'];
              $exp = explode(":" , $age); //explode marks data
              $mark1 = $exp[0];  
              ?>
                <tr class="<?= $bg ?>">
                    <td><?php echo $count ?></td>
                    <td><?php echo $row_entry1['m_honorific'].' '.$row_entry1['first_name']." ".$row_entry1['last_name']; ?></td>
                    <td><?php echo get_date_user($row_entry1['birth_date']); ?></td>
                    <td><?php echo $mark1; ?></td>
                    <td>
                      <button class="btn btn-info btn-sm" title="ID Proof" id="id-proof-<?= $count ?>" onclick="display_group_id_proof('<?php echo $row_entry1['id_proof_url']; ?>',<?= $count ?>)"><i class="fa fa-id-card-o"></i></button>
                    </td>
                </tr>
                  <?php } ?>
              </tbody>
            </table>

          </div> 
        </div>
        <div class="col-sm-3 no-pad">
          <div class="table_side_widget_panel main_block">
            <div class="table_side_widget_content main_block">
              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount"><?php echo number_format($actual_tour_expense,2); ?></div>
                  <div class="table_side_widget_text widget_blue_text">Total Amount</div>
                </div>
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount"><?php echo number_format($paid_amt,2); ?></div>
                  <div class="table_side_widget_text widget_green_text">Total Paid</div>
                </div>
              </div>
              <div class="col-xs-12">
                <div class="table_side_widget">
                  <div class="table_side_widget_amount"><?php echo number_format($balance_amt,2); ?></div>
                  <div class="table_side_widget_text widget_red_text">Total Balance</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<div id="id_proof"></div>

<script type="text/javascript">
  function display_group_id_proof(id_proof_url,count)
  { 
      $('id-proof'+count).button('loading');
      $('id-proof'+count).button('disabled','true');
      $.post('admin/id_proof/group_booking_id.php', { id_proof_url : id_proof_url }, function(data){
        $('#id_proof').html(data);
        $('id-proof'+count).button('reset');
        $('id-proof'+count).button('disabled','false');
      });
  }
</script>