<?php 
include "../../../../../../model/model.php";

$tourwise_traveler_id = $_POST['tourwise_traveler_id'];
$customer_id = $_SESSION['customer_id'];
$status = true;

$query = "select * from tourwise_traveler_details where customer_id='$customer_id' ";
if($tourwise_traveler_id!=""){
	$query .=" and id = '$tourwise_traveler_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	<table class="table table-bordered bg_white cust_table" id="group_table" style="margin: 20px 0 !important;">

		<thead>
			<tr class="table-heading-row1">
			    <th>S_No.</th>
			    <th>Booking_ID</th>
			    <th>Tour_Name</th>
			    <th>Tour_Date</th>
			    <th>View</th>
			    <th class="text-right info">total_Amount</th>
			    <th class="text-right success">Paid_Amount </th>  
			    <th class="text-right danger">Cncl_Amount</th>
			    <th class="text-right warning">Balance</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count = 0;
		$pen_ref=0;
		$pen_paid=0;
		$sq1 =mysqlQuery($query);
		while($row1 = mysqli_fetch_assoc($sq1))
		{
			$date = $row1['form_date'];
			$yr = explode("-", $date);
			$year = $yr[0];
			$tourwise_id = $row1['id']; 
			$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row1[id]'"));
			$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row1[id]' and status='Cancel'"));
			$bg="";
			if($row1['tour_group_status']=="Cancel"){
				$bg="danger";
			}
			else{
				if($pass_count==$cancelpass_count){
					$bg="danger";
				}
			}

			$sq_travler_personal_info = mysqli_fetch_assoc(mysqlQuery("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));

			$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row1[customer_id]'"));
			
			$sq_tour_name = mysqlQuery("select tour_name from tour_master where tour_id='$row1[tour_id]'");
			$row1_tour_name = mysqli_fetch_assoc($sq_tour_name);
			$tour_name = $row1_tour_name['tour_name'];

			$sq_tour_group_name = mysqlQuery("select from_date,to_date from tour_groups where group_id='$row1[tour_group_id]'");
			$row1_tour_group_name = mysqli_fetch_assoc($sq_tour_group_name);
			$tour_group_from = date("d-m-Y", strtotime($row1_tour_group_name['from_date']));
			$tour_group_to = date("d-m-Y", strtotime($row1_tour_group_name['to_date']));

			$sale_total_amount=$row1['net_total'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			//Paid
			$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum,sum(`credit_charges`) as sumc from payment_master where tourwise_traveler_id='$row1[id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$credit_card_charges = $query['sumc'];
			$paid_amount = $query['sum']+$credit_card_charges;

			if($row1['tour_group_status'] == 'Cancel'){
				//Group Tour cancel
				$cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row1[id]'"));
				if($cancel_tour_count2 >= '1'){
					$cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row1[id]'"));
					$cancel_amount = $cancel_tour['cancel_amount'];
				}
				else{ 
					$cancel_amount = 0;
				}
			}
			else{
				// Group booking cancel
				$cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row1[id]'"));
				if($cancel_esti_count1 >= '1'){
					$cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row1[id]'"));
					$cancel_amount = $cancel_esti1['cancel_amount'];
				}
				else{ $cancel_amount = 0; }
			}

			if($row1['tour_group_status'] == 'Cancel'){
				if($cancel_amount > $paid_amount){
					$balance_amount = $cancel_amount - $paid_amount;
				}
				else{
					$balance_amount = 0;
				}
			}else{
				if($cancel_esti_count1 >= '1'){
					if($cancel_amount > $paid_amount){
						$balance_amount = $cancel_amount - $paid_amount;
					}
					else{
						$balance_amount = 0;
					}
				}
				else{
					$balance_amount = $sale_total_amount + $credit_card_charges - $paid_amount;
				}
			}

			$net_total1 = currency_conversion($currency,$row1['currency_code'],$row1['net_total']+$credit_card_charges);
			$paid_amount1 = currency_conversion($currency,$row1['currency_code'],$paid_amount);
			$cancel_amount1 = currency_conversion($currency,$row1['currency_code'],$cancel_amount);
			$balance_amount1 = currency_conversion($currency,$row1['currency_code'],$balance_amount);

			$net_total1_string = explode(' ',$net_total1);
			$footer_net_total = str_replace(',', '', $net_total1_string[1]);
			$paid_amount1_string = explode(' ',$paid_amount1);
			$footer_paid_amount = str_replace(',', '', $paid_amount1_string[1]);
			$cancel_amount1_string = explode(' ',$cancel_amount1);
			$footer_cancel_amount = str_replace(',', '', $cancel_amount1_string[1]);
			$balance_amount1_string = explode(' ',$balance_amount1);
			$footer_balance_amount = str_replace(',', '', $balance_amount1_string[1]);
			
			//Total
			$total_amount += $footer_net_total;
			$total_paid1 += $footer_paid_amount;
			$total_cancel += $footer_cancel_amount;
			$total_balance += $footer_balance_amount;

			$count++;
			?>
			<tr class="<?= $bg ?>">
				<td><?php echo $count ?></td>
				<td><?= get_group_booking_id($tourwise_id,$year) ?></td>
				<td><?php echo $tour_name ?></td>
				<td><?php echo $tour_group_from." to ".$tour_group_to ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?php echo $row1['id']; ?>)" title="View Details"><i class="fa fa-eye"></i></button>
				</td>
				<td class="text-right info"><?= $net_total1 ?></td>
				<td class="text-right success"><?= $paid_amount1?></td>
				<td class="text-right danger"><?= $cancel_amount1 ?></td>
				<td class="text-right warning"><?= $balance_amount1 ?></td>
			</tr>
			<?php			
		}
		?>
		</tbody>
		<tfoot>
			<tr class="active">
				<th class="text-right" colspan="5"><?= 'TOTAL' ?></th>
				<th class="text-right info"><?= number_format($total_amount,2);?></th>
				<th class="text-right success"><?= number_format($total_paid1,2);?></th>
				<th class="text-right danger"><?=  number_format($total_cancel,2);?></th>
				<th class="text-right warning"><?= number_format($total_balance,2);?></th>
			</tr>
		</tfoot>
	</table>
</div></div></div>
<div id="view_modal"></div>
<script>
$('#group_table').dataTable({
	"pagingType": "full_numbers"
});
function display_modal(id)
{
    $.post('bookings/group_booking/booking/view/index.php', { id : id }, function(data){
    	$('#view_modal').html(data);
    });
}
</script>