<form id="frm_tab1">

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

		    <input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>">
		    <input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
		    <input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
			<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">

			<select name="enquiry_id" id="enquiry_id" title="Enquiry No" style="width:100%" onchange="get_flight_enquiry_details()">

				<option value="">*Enquiry No</option>
				<option value="0"><?= "New Enquiry" ?></option>

				<?php
				if($role=='Admin'){
					$sq_enq = mysqlQuery("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' order by enquiry_id desc");
				}else{
					if($branch_status=='yes'){
						if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
							$sq_enq = mysqlQuery("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
						}
						elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
							$q = "select * from enquiry_master where enquiry_type in('Flight Ticket') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
							$sq_enq = mysqlQuery($q);
						}
					}
					elseif($branch_status!='yes' && ($role=='Branch Admin' || $role_id=='7')){
						
						$sq_enq = mysqlQuery("select * from enquiry_master where enquiry_type in('Flight Ticket') and status!='Disabled' order by enquiry_id desc");
					}
					elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
						$q = "select * from enquiry_master where enquiry_type in('Flight Ticket') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
						$sq_enq = mysqlQuery($q);
					}
				}
				while($row_enq = mysqli_fetch_assoc($sq_enq)){

					$sq_enq2 = mysqli_fetch_assoc(mysqlQuery("SELECT followup_status FROM `enquiry_master_entries` WHERE `enquiry_id` = '$row_enq[enquiry_id]' ORDER BY `entry_id` DESC"));
					if($sq_enq2['followup_status'] != 'Dropped'){
						?>

						<option value="<?= $row_enq['enquiry_id'] ?>">Enq<?= $row_enq['enquiry_id'] ?> : <?= $row_enq['name'] ?></option>

					<?php
					}
				}

				?>

			</select>

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" class="form-control" name="customer_name" id="customer_name" onchange="fname_validate(this.id);" name="customer_name"  placeholder="*Customer Name" title="Customer Name"> 

	    </div>	        		                			        		        	        		


		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="mobile_no" name="mobile_no" placeholder="Whatsapp no with country code" onchange="mobile_validate(this.id);" title="Whatsapp no with country code">

		</div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	    	<input type="text" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y')?>" onchange="get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','true','service_charge', true);"> 

	    </div>

	</div>	

	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button id="handler" class="btn btn-info btn-sm ico_right" onclick="event_airport('tbl_flight_quotation_dynamic_plane');" >Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</form>



<script>
$('#travel_datetime').datetimepicker({format:'d-m-Y H:i' });
$('#quotation_date').datetimepicker({timepicker:false, format:'d-m-Y' });
// New Customization ----start
$(document).ready(function(){
	let searchParams = new URLSearchParams(window.location.search);
	if( searchParams.get('enquiry_id') ){
		$('#enquiry_id').val(searchParams.get('enquiry_id'));
		$('#enquiry_id').trigger('change');
	}
});
// New Customization ----end
$('#frm_tab1').validate({

	rules:{

			enquiry_id : { required : true },

	},

	submitHandler:function(form){
		var customer_name = $('#customer_name').val();
		if(customer_name == ''){
			error_msg_alert("Please Enter Customer Name");
			return false;
		}
		$('a[href="#tab2"]').tab('show');


	}

});



</script>

