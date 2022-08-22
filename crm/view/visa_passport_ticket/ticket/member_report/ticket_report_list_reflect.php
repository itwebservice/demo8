<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$ticket_id = $_POST['ticket_id'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];

$query = "select * from ticket_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($ticket_id!=""){
	$query .=" and ticket_id='$ticket_id'";
}
if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}	
if($role == "B2b"){
	$query .= " and emp_id='$emp_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by ticket_id desc ";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_ticket_report" style="margin: 20px 0 !important;">
	<thead>
	    <tr class="table-heading-row">
	    	<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name</th>
			<th>Passenger_Name</th>
			<th>Adolescence</th>
			<th>Ticket_No</th>
			<th>Main_Ticket_No</th>
			<th>Baggage</th>
			<th>Seat_No</th>
			<th>Meal_plan</th>
	    </tr>
	</thead>
	<tbody>
		<?php
		$count = 0;
		$sq_ticket = mysqlQuery($query);
		while($row_ticket =mysqli_fetch_assoc($sq_ticket)){

			$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			if($sq_customer_info['type'] == 'Corporate'||$sq_customer_info['type'] == 'B2B'){
				$cust_name = $sq_customer_info['company_name'];
			}else{
				$cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
			}
			$date = $row_ticket['created_at'];
            $yr = explode("-", $date);
        	$year = $yr[0];

            $from_city_arr = array();
            $to_city_arr = array();
            $sq_trip = mysqlQuery("SELECT * FROM ticket_trip_entries WHERE ticket_id='$row_ticket[ticket_id]'");
            while($row_trip = mysqli_fetch_assoc($sq_trip)){

				$dep_city = explode('(',$row_trip['departure_city']);
				$arr_city = explode('(',$row_trip['arrival_city']);

				$dep_city1 = explode(')',$dep_city[1]);
				$arr_city1 = explode(')',$arr_city[1]);
				array_push($from_city_arr,$dep_city1[0]);
				array_push($to_city_arr,$arr_city1[0]);
            }

			$sq_entry = mysqlQuery("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
			while($row_entry = mysqli_fetch_assoc($sq_entry)){

				$seat_no_string = '';
				$meal_plan_string = '';
				$seat_nos = explode('/',$row_entry['seat_no']);
				for($i = 0; $i < sizeof($seat_nos); $i++){
					$seat_no_string .= $seat_nos[$i].' ('.$from_city_arr[$i].'-'.$to_city_arr[$i].')';
					if($i != (sizeof($seat_nos)-1)){
						$seat_no_string .= ', ';
					}
				}
				$meal_plans = explode('/',$row_entry['meal_plan']);
				for($i = 0; $i < sizeof($meal_plans); $i++){
					$meal_plan_string .= $meal_plans[$i].' ('.$from_city_arr[$i].'-'.$to_city_arr[$i].')';
					if($i != (sizeof($meal_plans)-1)){
						$meal_plan_string .= ', ';
					}
				}

				$bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_ticket_booking_id($row_ticket['ticket_id'],$year) ?></td>
					<td><?= $cust_name ?></td>
					<td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
					<td><?= $row_entry['adolescence'] ?></td>
					<td><?php echo ($row_entry['ticket_no']!='') ? $row_entry['ticket_no'] : 'NA' ?></td>
                    <td><?php echo ($row_entry['main_ticket']!='') ? $row_entry['main_ticket'] : 'NA'; ?></td>
                    <td><?php echo ($row_entry['baggage_info']!='') ? $row_entry['baggage_info'] : 'NA'; ?></td>
                    <td><?php echo ($row_entry['seat_no'] != '' ) ? $seat_no_string : 'NA'; ?></td>
                    <td><?php echo ($row_entry['meal_plan'] != '' ) ? $meal_plan_string : 'NA'; ?></td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
	$('#tbl_ticket_report').dataTable({
		"pagingType": "full_numbers"
	});
</script>