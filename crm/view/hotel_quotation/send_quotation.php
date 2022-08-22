<?php 
include "../../model/model.php";
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_status = $_GET['branch_status'];
$email_id = $_GET['email_id'];

$query = "SELECT * from `hotel_quotation_master` where 1 ";
if($role != 'Admin' && $role!='Branch Admin'){
	$query .= " and emp_id='$emp_id'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}
if($branch_admin_id != '' && $role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}
$query .= ' ORDER BY `quotation_id` DESC';
$sq_query = mysqlQuery($query);
?>
<div class="modal fade" id="quotation_send_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Quotation</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-xs-12">
				<input type="checkbox" id="check_all" name="check_all" onClick="select_all_check(this.id,'custom_package')">&nbsp;&nbsp;&nbsp;<span style="text-transform: initial;">Check All</span>
			</div>
		</div>
	  <div class="row">
	  <div class="col-xs-12">
      	<div class="table-responsive">
		  <table class="table table-hover table-bordered no-marg" id="tbl_tour_list">
		    <tr class="table-heading-row">
				<th></th>
				<th>SR No.</th>
				<th>Quotation ID</th>
				<th>Customer Name</th>
				<th>Quotation Cost</th>
		    </tr> 
		    <?php 
		    $quotation_cost = 0;  $count  = 1;
		    while($row_tours = mysqli_fetch_assoc($sq_query)){
		    	$costDetails = json_decode($row_tours['costing_details']);
                $enqDetails = json_decode($row_tours['enquiry_details']);
				$quotation_date = $row_tours['quotation_date'];
				$yr = explode("-", $quotation_date);
				$year =$yr[0];
				
				if($email_id == $enqDetails->email_id){
				?>
			    <tr>
					<td><input type="checkbox" value="<?php echo $row_tours['quotation_id']; ?>" id="<?php echo $row_tours['quotation_id']; ?>" name="custom_package" class="custom_package"/></td> 
					<td><?php echo $count; ?></td>
					<td><?php echo get_quotation_id($row_tours['quotation_id'],$year); ?></td>
					<td><?php echo $enqDetails->customer_name ?></td>
					<td><?= number_format($costDetails->total_amount,2) ?></td>
			    </tr>
				<?php $count++;
				}
			}
		    ?>
		  </table>
		</div>
		</div>
		</div>
		<div class="row text-center">
			<div class="col-md-12 mg_tp_20">
				<button class="btn btn-sm btn-success" id="btn_quotation_send" onclick="multiple_quotation_mail();"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;<?php echo "Send on Email" ?></button>
			</div>
		</div>
      </div>  
    </div>
  </div>
</div>
<script>
$('#quotation_send_modal').modal('show');
function select_all_check(id,custom_package){
	var checked = $('#'+id).is(':checked');
	// Select all
	if(checked){
		$('.custom_package1').each(function() {
			$(this).prop("checked",true);
		});
	}
	else{
		// Deselect All
		$('.custom_package1').each(function() {
			$(this).prop("checked",false);
		});
	}
}

function multiple_quotation_mail()
{
	 var quotation_id_arr = new Array();
	 var base_url = $('#base_url').val();
		$('input[name="custom_package"]:checked').each(function(){
			quotation_id_arr.push($(this).val());
		});
		if(quotation_id_arr.length==0){
			error_msg_alert('Please select at least one quotation!');
			return false;
		}
	$('#btn_quotation_send').button('loading'); 
	$.ajax({
			type:'post',
			url: base_url+'controller/hotel/quotation/quotation_email.php',
			data:{ quotation_id_arr : quotation_id_arr},
			success: function(message){
					msg_alert(message);
					$('#btn_quotation_send').button('reset'); 
					$('#quotation_send_modal').modal('hide');             	
                }  
		});	
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>