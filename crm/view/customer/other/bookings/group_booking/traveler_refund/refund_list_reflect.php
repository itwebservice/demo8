<?php
include "../../../../../../model/model.php";
global $currency;
$tourwise_traveler_id = $_POST['tourwise_traveler_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from refund_traveler_cancelation where tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id')";

if($tourwise_traveler_id!=""){
	$query .=" and tourwise_traveler_id='$tourwise_traveler_id'";	
}

?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered table-hover mg_bt_0 bg_white" id="group_table3" style="margin: 20px 0;">
    <thead> 
    <tr>
        <th>S_No.</th>
        <th>Booking_ID</th>
        <th>Traveller_name</th>
        <th>Refund_Date</th>
        <th>Bank_Name</th>
        <th>Refund_Mode</th>
        <th>Cheque_No/ID</th>
        <th class="text-right success">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $count = 0;
    $bg;
    $sq_pending_amount=0;
    $sq_cancel_amount=0;
    $sq_paid_amount=0;
    $Total_payment=0;
    $date;
    $sq_refund = mysqlQuery($query);
    while($row_refund = mysqli_fetch_assoc($sq_refund))
    {
        $count++;
        $sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where id='$row_refund[tourwise_traveler_id]'"));
        $date = $sq_booking['form_date'];
        $yr = explode("-", $date);
        $year =$yr[0];
        if($row_refund['clearance_status']=="Pending"){ $bg='warning';
            $sq_pending_amount = $row_refund['total_refund'];
        }
        else if($row['clearance_status']=="Cleared"){ $bg='success';
            $bg = '';
            $sq_paid_amount = $sq_paid_amount + $row['refund_amount'];
        }
        else if($row_refund['clearance_status']=="Cancelled"){ 
            $bg = "danger"; 
            $sq_can_amount = $sq_can_amount + $row_refund['total_refund'];
        }
        else{
            $bg = '';
            $sq_paid_amount = $sq_paid_amount + $row_refund['total_refund'];
        }

        $paid_amt = $paid_amt + $row_refund['total_refund'];
        $total_refund = currency_conversion($currency,$sq_booking['currency_code'],$row_refund['total_refund']);

        $sq_paid_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$row_refund['total_refund']);
        $sq_paid_amount_string = explode(' ',$sq_paid_amount1);
        $footer_paid_total += str_replace(',', '', $sq_paid_amount_string[1]);
        $sq_pending_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_pending_amount);
        $sq_paid_amount_string = explode(' ',$sq_pending_amount1);
        $footer_pending_total += str_replace(',', '', $sq_paid_amount_string[1]);
        $sq_can_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_can_amount);
        $sq_canc_amount_string = explode(' ',$sq_can_amount1);
        $footer_canc_total += str_replace(',', '', $sq_canc_amount_string[1]);
    ?>
    <tr class="<?= $bg?>">
        <td><?php echo $count; ?></td>
        <td><?= get_group_booking_id($row_refund['tourwise_traveler_id'],$year) ?></td>
        <td>
        <?php 
        $sq_refund_entry = mysqlQuery("select traveler_id from refund_traveler_cancalation_entries where refund_id='$row_refund[refund_id]'");
        while($row_refund_entry = mysqli_fetch_assoc($sq_refund_entry) )
        {
            $sq_traveler = mysqli_fetch_assoc( mysqlQuery( "select m_honorific, first_name, last_name from travelers_details where traveler_id='$row_refund_entry[traveler_id]'" ) );
            echo $sq_traveler['m_honorific'].' '.$sq_traveler['first_name'].' '.$sq_traveler_query['last_name']."<br>";
        }    
        ?>
        </td>
        <td><?php echo date("d-m-Y", strtotime($row_refund['refund_date'])) ?></td>
        <td><?php echo $row_refund['bank_name'] ?></td>
        <td><?php echo $row_refund['refund_mode'] ?></td>
        <td><?= $row_refund['transaction_id'] ?></td>
        <td class="text-right success"><?php echo $total_refund; ?></td> 
    </tr>
    <?php    
    }    
    ?>
    </tbody>
    <tfoot>
        <tr class="active">
            <th colspan="2" class="text-right info">Refund : <?= number_format($footer_paid_total,2); ?></th>
            <th colspan="2" class="text-right warning">Pending : <?= number_format($footer_pending_total,2);?></th>
            <th colspan="2" class="text-right danger">Cencelled : <?= number_format($footer_canc_total,2); ?></th>
            <th colspan="2" class="text-right success">Total Refund : <?= number_format(($footer_paid_total-$footer_pending_total- $footer_canc_total),2);?></th>
        </tr>
    </tfoot>

</table>
</div> </div> </div>
<script type="text/javascript">
    
$('#group_table3').dataTable({
    "pagingType": "full_numbers"
});
</script>