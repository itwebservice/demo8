<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
?>
<input type="hidden" id="b_id" value="<?= $booking_id ?>">
<div class="row mg_tp_20">	
	<div class="col-md-10  col-md-offset-1 col-sm-12 col-xs-12">
		<div class="widget_parent-bg-img bg-img-red">
			<?php 
        $servie_total = 0;
        $ferry_total = 0;
        $sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
        $cart_checkout_data = json_decode($sq_b2b_info['cart_checkout_data']);
        $hotel_list_arr = array();
        $transfer_list_arr = array();
        $activity_list_arr = array();
        $tours_list_arr = array();
        $ferry_list_arr = array();

        for($i=0;$i<sizeof($cart_checkout_data);$i++){
            if($cart_checkout_data[$i]->service->name == 'Hotel'){
              array_push($hotel_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Transfer'){
              array_push($transfer_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Activity'){
              array_push($activity_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
              array_push($tours_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Ferry'){
              array_push($ferry_list_arr,$cart_checkout_data[$i]);
            }
        }

        global $currency;
        $sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
        $to_currency_rate = $sq_to['currency_rate'];
                
        if(sizeof($hotel_list_arr)>0){
        $tax_total = 0;
        $hotel_total = 0;
        for($i=0;$i<sizeof($hotel_list_arr);$i++){

          $tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
          for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
            $room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
            $room_no = $room_types[0];
            $room_cat = $room_types[1];
            $room_cost = $room_types[2];
            $h_currency_id = $room_types[3];
            $tax_amount = 0;
            
            $tax_arr1 = explode('+',$tax_arr[0]);
            for($t=0;$t<sizeof($tax_arr1);$t++){
              if($tax_arr1[$t]!=''){
                $tax_arr2 = explode(':',$tax_arr1[$t]);
                if($tax_arr2[2] == "Percentage"){
                  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                }else{
                  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                }
              }
            }
            $total_amount = $room_cost + $tax_amount;
            //Convert into default currency
            $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
            $from_currency_rate = $sq_from['currency_rate'];
            $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
            $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);

            $hotel_total += $room_cost1;
            $tax_total += $tax_amount1;
            }
          }
        }

        if(sizeof($transfer_list_arr)>0){
            $trtax_total = 0;
            $transfer_total = 0;
            for($i=0;$i<sizeof($transfer_list_arr);$i++){
              
              $tax_amount = 0;
              $services = ($transfer_list_arr[$i]->service!='') ? $transfer_list_arr[$i]->service : [];
              for($j=0;$j<count(array($services));$j++){
                $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                $transfer_cost = explode('-',$services->service_arr[$j]->transfer_cost);
                $room_cost = $transfer_cost[0];
                $h_currency_id = $transfer_cost[1];
              
                $tax_arr1 = explode('+',$tax_arr[0]);
                for($t=0;$t<sizeof($tax_arr1);$t++){
                  if($tax_arr1[$t]!=''){
                    $tax_arr2 = explode(':',$tax_arr1[$t]);
                    if($tax_arr2[2] == "Percentage"){
                      $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                    }else{
                      $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                    }
                  }
                }
                $total_amount = $room_cost + $tax_amount;
                //Convert into default currency
                $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                $from_currency_rate = $sq_from['currency_rate'];
                $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);

                $transfer_total += $room_cost1;
                $trtax_total += $tax_amount1;
              } 
            } 
        }

        if(sizeof($activity_list_arr)>0){
          $acttax_total = 0;
          $activity_total = 0;
          for($i=0;$i<sizeof($activity_list_arr);$i++){
            $tax_amount = 0;
            $tax_arr = explode(',',$activity_list_arr[$i]->service->service_arr[0]->taxation);
            $transfer_types = explode('-',$activity_list_arr[$i]->service->service_arr[0]->transfer_type);
            $transfer = $transfer_types[0];
            $room_cost = $transfer_types[1];
            $h_currency_id = $transfer_types[2];
            
            $tax_arr1 = explode('+',$tax_arr[0]);
            for($t=0;$t<sizeof($tax_arr1);$t++){
              if($tax_arr1[$t]!=''){
                $tax_arr2 = explode(':',$tax_arr1[$t]);
                if($tax_arr2[2] === "Percentage"){
                  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                }else{
                  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                }
              }
            }
            $total_amount = $room_cost + $tax_amount;
            //Convert into default currency
            $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
            $from_currency_rate = $sq_from['currency_rate'];
            $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
            $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
  
            $activity_total += $room_cost1;
            $acttax_total += $tax_amount1;
          }
        }

        if(sizeof($tours_list_arr)>0){
            $tourstax_total = 0;
            $tours_total = 0;
            for($i=0;$i<sizeof($tours_list_arr);$i++){

              $tax_amount = 0;
              $tax_arr = explode(',',$tours_list_arr[$i]->service->service_arr[0]->taxation);
              $package_item = explode('-',$tours_list_arr[$i]->service->service_arr[0]->package_type);
              $room_cost = $package_item[1];
              $h_currency_id = $package_item[2];
              
              $tax_arr1 = explode('+',$tax_arr[0]);
              for($t=0;$t<sizeof($tax_arr1);$t++){
                if($tax_arr1[$t]!=''){
                  $tax_arr2 = explode(':',$tax_arr1[$t]);
                  if($tax_arr2[2] == "Percentage"){
                  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                  }else{
                  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                  }
                }
              }
              $total_amount = $room_cost + $tax_amount;
              //Convert into default currency
              $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
              $from_currency_rate = $sq_from['currency_rate'];
              $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
              $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);

              $tours_total += $room_cost1;
              $tourstax_total += $tax_amount1;
            }
        }
        if(sizeof($ferry_list_arr)>0){
            $ferry_total = 0;
            $ferrytax_total = 0;
            for($i=0;$i<sizeof($ferry_list_arr);$i++){

              $tax_amount = 0;
              $tax_arr = explode(',',$ferry_list_arr[$i]->service->service_arr[0]->taxation);
              $package_item = explode('-',$ferry_list_arr[$i]->service->service_arr[0]->total_cost);
              $room_cost = $package_item[0];
              $h_currency_id = $package_item[1];
              
              $tax_arr1 = explode('+',$tax_arr[0]);
              for($t=0;$t<sizeof($tax_arr1);$t++){
                if($tax_arr1[$t]!=''){
                  $tax_arr2 = explode(':',$tax_arr1[$t]);
                  if($tax_arr2[2] == "Percentage"){
                  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                  }else{
                  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                  }
                }
              }
              $total_amount = $room_cost + $tax_amount;
              //Convert into default currency
              $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
              $from_currency_rate = $sq_from['currency_rate'];
              $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
              $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);

              $ferry_total += $room_cost1;
              $ferrytax_total += $tax_amount1;
            }
        }

        $servie_total = $servie_total + $hotel_total + $transfer_total + $activity_total + $tours_total + $ferry_total;
      
        $main_total += $servie_total;
        $main_tax_total += $tax_total + $trtax_total + $acttax_total + $tourstax_total + $ferrytax_total;
        $final_total = $main_total + $main_tax_total;

        $offer_amount = 0;
        if($sq_b2b_info['coupon_code'] != ''){
          $sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$sq_b2b_info[coupon_code]'"));
          $sq_exc_count = mysqli_num_rows(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$sq_b2b_info[coupon_code]'"));
          if($sq_hotel_count > 0){
            $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$sq_b2b_info[coupon_code]'"));
          }else if($sq_exc_count > 0){
            $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$sq_b2b_info[coupon_code]'"));
          }else{
            $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from custom_package_offers where coupon_code='$sq_b2b_info[coupon_code]'"));
            }
        
          if($sq_coupon['offer']=="Flat"){
            $offer_amount = $sq_coupon['offer_amount'];
            $text = 'Promocode('.$sq_b2b_info['coupon_code'].') is Applied '.$sq_coupon['offer_amount'].' Off';
          }else{
            $offer_amount = ($final_total*$sq_coupon['offer_amount']/100);
            $text = 'Promocode('.$sq_b2b_info['coupon_code'].') is Applied '.$sq_coupon['offer_amount'].'% Off';
          }
        }
        
        $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

        begin_widget();
            $title_arr = array("Booking Amount", "Tax","Coupon Amount(-)","Total Amount","Paid Amount");
            $content_arr = array( number_format($main_total,2), number_format($main_tax_total,2), number_format($offer_amount,2), number_format(floatval($final_total)-$offer_amount,2),number_format($sq_payment_info['sum'],2));
            $percent = ($final_total!='0') ? ($sq_payment_info['sum']/$final_total)*100 : 0;
            $percent = number_format($percent, 2);
            $label = "B2B Fee Paid In Percent";
            widget_element($title_arr, $content_arr, $percent, $label, $head_title);
        end_widget();
      ?>
      <input type="hidden" id="total_sale" name="total_sale" value="<?= $final_total ?>">
      <input type="hidden" id="total_paid" name="total_paid" value="<?= $sq_payment_info['sum']?>">
      <input type="hidden" id="total_tax" name="total_tax" value="<?= $main_tax_total ?>">
      <input type="hidden" id="total_booking" value="<?= $main_total ?>" >
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_0">
			<thead>
				<tr class="table-heading-row">
					<th>S_No.</th>
					<th>Type</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 0;
      $disabled_count= 0;
      $sq_b2b_entries = mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'");
      $tax_type = "";
			while($row = mysqli_fetch_assoc($sq_b2b_entries)){

				if($row['status']=="Cancel"){
					$bg = "danger";
					$checked = "checked disabled";
					++$disabled_count;
        }
        $cart_checkout_data = json_decode($row['cart_checkout_data']);

        for($i=0;$i<sizeof($cart_checkout_data);$i++){
          if($cart_checkout_data[$i]->service->name == 'Hotel'){
            $tax_type = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax)[0];
        ?>
            <tr class="<?= $bg ?>">
					    <td><?= ++$count ?></td>
              <td>Hotel Booking</td>
					    <td><?= $cart_checkout_data[$i]->service->hotel_arr->hotel_name ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Transfer'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					    <td><?= ++$count ?></td>
              <td>Transfer Booking</td>
					    <td><?= $cart_checkout_data[$i]->service->service_arr[0]->vehicle_name.'('.$cart_checkout_data[$i]->service->service_arr[0]->vehicle_type.')' ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Activity'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					      <td><?= ++$count ?></td>
                <td>Activity Booking</td>
					      <td><?= $cart_checkout_data[$i]->service->service_arr[0]->act_name ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					      <td><?= ++$count ?></td>
                <td>Holiday</td>
					      <td><?= $cart_checkout_data[$i]->service->service_arr[0]->package ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Ferry'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					      <td><?= ++$count ?></td>
                <td>Ferry</td>
					      <td><?= $cart_checkout_data[$i]->service->service_arr[0]->ferry_name.' '.$cart_checkout_data[$i]->service->service_arr[0]->ferry_type ?></td>
				    </tr>
        <?php
          }
        }
			}
			?>
			</tbody>
		</table>
    <?php
    if($sq_b2b_info['status']!='Cancel'){ ?>
    <div class="panel panel-default panel-body text-center">
				<button class="btn btn-danger btn-sm ico_left" onclick="cancel_booking()"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel Booking</button>
			</div>
		</div> </div>
    <?php } ?>
    <input type="hidden" name="tax_type" id="tax_type" value="<?= $tax_type ?>">
</div>
<hr>
	<?php 
	$sq_cancel_count = mysqli_num_rows(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id' and status='Cancel'"));
	if($sq_cancel_count>0){
		$sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
	?>
	<form id="frm_refund" class="mg_bt_150">

		<div class="row text-center">
			<div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" name="cancel_amount" id="cancel_amount" class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_b2b_info['cancel_amount'] ?>">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_b2b_info['total_refund_amount'] ?>">
			</div>
		</div>
		<?php if($sq_b2b_info['estimate_flag'] == "0"){ ?>
		<div class="row mg_tp_20">
		  <div class="col-md-4 col-md-offset-4 text-center">
		      <button id="btn_refund_save" id="cancel_booking" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
		  </div>
		</div>
		<?php } ?>

	</form>
	<?php 
	}
	?>
<script>
function cancel_booking(){
	//Validaion to select complete tour cancellation 
  var booking_id = $('#b_id').val();
	$('#vi_confirm_box').vi_confirm_box({
	    message: 'Are you sure?',
	    callback: function(data1){
        if(data1=="yes"){
          var base_url = $('#base_url').val();
          $('#cancel_booking').button('loading');
          $.post(base_url+'controller/b2b_customer/cancel/cancel_booking.php', {booking_id : booking_id}, function(data){
            msg_alert(data);
            $('#cancel_booking').button('reset');
            content_reflect();
          });
        }
	    }
	});
}

function calculate_total_refund()
{
	var total_refund_amount = 0;
	var cancel_amount = $('#cancel_amount').val();
	var total_sale = $('#total_sale').val();
	var total_paid = $('#total_paid').val();

	if(cancel_amount==""){ cancel_amount = 0; }
	if(total_paid==""){ total_paid = 0; }

	if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); }
	var total_refund_amount = parseFloat(total_paid) - parseFloat(cancel_amount);
	
	if(parseFloat(total_refund_amount) < 0){ 
		total_refund_amount = 0;
	}
	$('#total_refund_amount').val(total_refund_amount.toFixed(2));
}

$(function(){
  $('#frm_refund').validate({
      rules:{
        refund_amount : { required : true, number : true },
        total_refund_amount : { required : true, number : true },
      },
      submitHandler:function(form){

        var booking_id = $('#b_id').val();
        var cancel_amount = $('#cancel_amount').val();
        var total_refund_amount = $('#total_refund_amount').val();
			  var total_sale = $('#total_sale').val();
			  var total_paid = $('#total_paid').val();         
        var total_tax = $('#total_tax').val();    
        var tax_type = $('#tax_type').val();
        var total_booking = $('#total_booking').val();

			  if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); return false; }
			  
              var base_url = $('#base_url').val();

              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');

                        $.ajax({
                          type:'post',
                          url: base_url+'controller/b2b_customer/cancel/refund_estimate.php',
                          data:{ booking_id : booking_id, cancel_amount : cancel_amount, total_refund_amount : total_refund_amount, final_total : total_sale, main_tax_total : total_tax, taxation_type : tax_type, total_booking : total_booking },
                          success:function(result){
                            msg_alert(result);
                            content_reflect();
                            $('#btn_refund_save').button('reset');
                          },
                          error:function(result){
                            console.log(result.responseText);
                          }
                        });

                }
              }
            });

      }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>