<?php
include "../../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="train_ticket_id" id="train_ticket_id" style="width:100%" onchange="content_reflect()" title="Select Booking">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_ticket = mysqlQuery("select * from train_ticket_master order by train_ticket_id desc");
		        while($row_ticket = mysqli_fetch_assoc($sq_ticket)){

		          $date = $row_ticket['created_at'];
		          $yr = explode("-", $date);
		          $year =$yr[0];
		          $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
				  if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
					  $cust_name = $sq_customer['company_name'];
				  }else{
					  $cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				  }
		          ?>
		          <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year).' : '.$cust_name ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
	</div>
</div>

<div id="div_cancel_ticket" class="main_block"></div>


<script>
$('#train_ticket_id').select2();
function content_reflect()
{
	var train_ticket_id = $('#train_ticket_id').val();
	if(train_ticket_id!=''){
		$.post('cancel/content_reflect.php', { train_ticket_id : train_ticket_id }, function(data){
			$('#div_cancel_ticket').html(data);
		});
	}else{
		$('#div_cancel_ticket').html('');
	}
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>