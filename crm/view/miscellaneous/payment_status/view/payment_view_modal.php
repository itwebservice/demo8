<?php 
include "../../../../model/model.php";
$misc_id = $_POST['misc_id'];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Receipt Information</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row mg_bt_20">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		            <div class="table-responsive">
                    <table  class="table table-bordered no-marg">
	                   <thead>
                         <tr class="table-heading-row">
                            <th>S_No.</th>
                            <th>Receipt_Date</th>
                            <th>Mode</th>
                            <th>Amount</th>
                         </tr>
                     </thead>
                     <tbody>
                       <?php 
                       $count = 0;
                       $sq_query = mysqlQuery("SELECT * FROM miscellaneous_payment_master WHERE misc_id = '$misc_id' and payment_amount!='0'");
                       while($row_entry = mysqli_fetch_assoc($sq_query))
                       {
                          if($row_entry['clearance_status']=="Pending")
                            $bg='warning';
                          else if($row_entry['clearance_status']=="Cancelled")
                            $bg='danger';		
                          else
                            $bg='success';
                          $count++;
                          ?>
                          <tr class="<?=$bg?>">
                              <td><?php echo $count; ?></td>
                              <td><?php echo get_date_user($row_entry['payment_date']); ?></td>
                              <td><?php echo $row_entry['payment_mode']; ?></td>
                              <td><?php echo number_format($row_entry['payment_amount'],2); ?></td>
                           
                          </tr>  
                          <?php
                        }
                       ?>
                     </tbody>
		                </table>
		            </div>
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