<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from package_refund_traveler_cancelation where booking_id in (select booking_id from package_tour_booking_master where customer_id='$customer_id')";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}

?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered table-hover mg_bt_0 cust_table" id="package_table3" style="margin:20px 0 !important">
    <thead>   
    <tr class="table-heading-row">
        <th>S_No.</th>
        <th>Booking_ID</th>
        <th>Passenger_name</th>
        <th>Tour_Type</th>
        <th>Refund_Date</th>  
        <th>Bank_Name</th>  
        <th>Refund_Mode</th>
        <th class="text-right success">Amount</th>  
    </tr>
    </thead>
    <tbody>
    <?php 
    $total_tour_refund = 0;
    $total_travel_refund = 0;
    $total_refund = 0;
    $count = 0;
    $date;

    $sq_pending_amount=0;
    $sq_cancel_amount=0;
    $sq_paid_amount=0.00;
    $Total_payment=0;

    $sq_refund = mysqlQuery($query);
    while($row_refund = mysqli_fetch_assoc($sq_refund))
    {       
        $count++;
        $sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$row_refund[booking_id]'"));
        $date = $sq_booking['booking_date'];
        $yr = explode("-", $date);
        $year =$yr[0];
        $sq_pending_amount = 0;
        $sq_can_amount = 0;

        if($row_refund['clearance_status']=="Pending"){ $bg='warning';
            $sq_pending_amount = $row_refund['total_refund'];
        }
        if($row_refund['clearance_status']=="Cleared"){ $bg='success';
            $sq_paid_amount = $sq_paid_amount + $row_refund['total_refund'];
        }
        if($row_refund['clearance_status']=="Cancelled"){ $bg='danger';
            $sq_can_amount = $row_refund['total_refund'];
        }
        if($row_refund['clearance_status']==""){ $bg='';
            $sq_paid_amount = $sq_paid_amount + $row_refund['total_refund'];
        }  

        $total_refund_amt += $row_refund['total_refund']; 
        $sq_refund_entry = mysqlQuery("select traveler_id from package_refund_traveler_cancalation_entries where refund_id='$row_refund[refund_id]'");
        while($row_refund_entry = mysqli_fetch_assoc($sq_refund_entry) )
        {
            $sq_traveler = mysqli_fetch_assoc( mysqlQuery( "select m_honorific, first_name, last_name from package_travelers_details where traveler_id='$row_refund_entry[traveler_id]'" ) );
        } 
        $total_refund = currency_conversion($currency,$sq_booking['currency_code'],$row_refund['total_refund']);
        $sq_paid_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$row_refund['total_refund']);
        $sq_paid_amount_string = explode(' ',$sq_paid_amount1);
        $footer_paid_total += str_replace(',', '', $sq_paid_amount_string[1]);
        $sq_pending_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_pending_amount);
        $sq_pending_amount_string = explode(' ',$sq_pending_amount1);
        $footer_pending_total += str_replace(',', '', $sq_pending_amount_string[1]);
        $sq_can_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_can_amount);
        $sq_canc_amount_string = explode(' ',$sq_can_amount1);
        $footer_canc_total += str_replace(',', '', $sq_canc_amount_string[1]);
    ?>
    <tr class="<?= $bg?> text-left">
        <td><?php echo $count; ?></td>
        <td><?php echo get_package_booking_id($row_refund['booking_id'],$year); ?></td> 
        <td><?php echo $sq_traveler['m_honorific'].' '.$sq_traveler['first_name'].' '.$sq_traveler['last_name']."<br>"; ?></td>
        <td><?= $sq_booking['tour_type'] ?></td>
        <td><?php echo date('d-m-Y', strtotime($row_refund['refund_date'])); ?></td>
        <td><?= $row_refund['bank_name'] ?></td>
        <td><?php echo $row_refund['refund_mode'] ?></td>
        <td class="text-right success"><?php echo $total_refund; ?></td>
    </tr>
    <?php    
    }    
    ?>
    </tbody>
    <tfoot>
        <tr class="active">
            <th colspan="2" class="text-right info">Refund: <?= number_format($footer_paid_total,2) ?></th>
            <th colspan="2" class="text-right warning">Pending : <?= number_format($footer_pending_total,2);?></th>
            <th colspan="2" class="text-right danger">Cancelled: <?= number_format($footer_canc_total,2) ?></th>
            <th colspan="2" class="text-right success">Total Refund : <?= number_format(($footer_paid_total - $footer_pending_total - $footer_canc_total),2);?></th>
        </tr>
    </tfoot>
</table>
</div> </div> </div>
<script type="text/javascript">
    
$('#package_table3').dataTable({
    "pagingType": "full_numbers"
});
</script>