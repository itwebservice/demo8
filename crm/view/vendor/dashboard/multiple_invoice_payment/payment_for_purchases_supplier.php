<?php
include "../../../../model/model.php";

$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];

if($vendor_type=="Hotel Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="hotel_id" id="hotel_id" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Hotel</option>	
			<?php
		}
		else{
			$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_hotel['hotel_id'] ?>"><?= $sq_hotel['hotel_name'] ?></option>
			<?php
		}

		$sq_hotel = mysqlQuery("select * from hotel_master where active_flag!='Inactive' order by hotel_name");
		while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
			?>
			<option value="<?= $row_hotel['hotel_id'] ?>"><?= $row_hotel['hotel_name'] ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
$('#hotel_id').select2();
</script>
<?php
}
if($vendor_type=="Transport Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="transport_agency_id" id="transport_agency_id" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Transport Agency</option>
			<?php
		}
		else{
			$sq_transport = mysqli_fetch_assoc(mysqlQuery("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));			
			?>
			<option value="<?= $sq_transport['transport_agency_id'] ?>"><?= $sq_transport['transport_agency_name'] ?></option>
			<?php
		}

		$sq_transport = mysqlQuery("select * from transport_agency_master where active_flag!='Inactive' order by transport_agency_name");
		while($row_transport = mysqli_fetch_assoc($sq_transport)){
			?>
			<option value="<?= $row_transport['transport_agency_id'] ?>"><?= $row_transport['transport_agency_name'] ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
$('#transport_agency_id').select2();
</script>
<?php
}
if($vendor_type=="Car Rental Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from car_rental_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="DMC Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="dmc_id" id="dmc_id" title="Select DMC" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select DMC</option>
			<?php
		}
		else{
			$sq_dmc = mysqli_fetch_assoc(mysqlQuery("select * from dmc_master where dmc_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_dmc['dmc_id'] ?>"><?= $sq_dmc['company_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_dmc = mysqlQuery("select * from dmc_master where active_flag!='Inactive' order by company_name");
			while($row_dmc = mysqli_fetch_assoc($sq_dmc)){
				?>
				<option value="<?= $row_dmc['dmc_id'] ?>"><?= $row_dmc['company_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#dmc_id').select2();
</script>
<?php
}

if($vendor_type=="Visa Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from visa_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from visa_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="Passport Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from passport_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from passport_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="Ticket Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Ticket Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Ticket Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from ticket_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="Train Ticket Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Ticket Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Ticket Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from train_ticket_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="Excursion Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Activity Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Activity supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from site_seeing_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="Insurance Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id" id="vendor_id" title="Select Insurance Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Insurance Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from insuarance_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}

if($vendor_type=="Other Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			 
	<select name="vendor_id" id="vendor_id" title="Select Other Supplier" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Other Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from other_vendors where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysqlQuery("select * from other_vendors where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysqli_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id').select2();
</script>
<?php
}
if($vendor_type=="Cruise Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="cruise_id" id="cruise_id" style="width:100%" onchange="payment_for_single_purch(this.id,'<?= $vendor_type ?>','div_payment_for');">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">*Select Cruise</option>	
			<?php
		}
		else{
			$sq_cruise = mysqli_fetch_assoc(mysqlQuery("select * from cruise_master where cruise_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_cruise['cruise_id'] ?>"><?= $sq_cruise['company_name'] ?></option>
			<?php
		}

		$sq_cruise = mysqlQuery("select * from cruise_master where active_flag!='Inactive' order by cruise_id");
		while($row_cruise = mysqli_fetch_assoc($sq_cruise)){
			?>
			<option value="<?= $row_cruise['cruise_id'] ?>"><?= $row_cruise['company_name'] ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
$('#cruise_id').select2();
</script>
<?php
}
?>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>