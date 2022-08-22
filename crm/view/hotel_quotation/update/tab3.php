<?php
	$basic_cost1 = $costDetails['hotel_cost'];
	$service_charge = $costDetails['service_charge'];
	$markup = $costDetails['markup_cost'];

		$bsmValues = json_decode($sq_quotation['bsmValues']);
		$service_tax_amount = 0;
		if($costDetails['tax_amount'] !== 0.00 && ($costDetails['tax_amount']) !== ''){
			$service_tax_subtotal1 = explode(',',$costDetails['tax_amount']);
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount = $service_tax_amount + $service_tax[2];
			}
		}
		$markupservice_tax_amount = 0;
		if($costDetails['markup_tax'] !== 0.00 && $costDetails['markup_tax'] !== ""){
			$service_tax_markup1 = explode(',',$costDetails['markup_tax']);
			for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount = $markupservice_tax_amount+ $service_tax[2];
			}
		}
		foreach($bsmValues as $key => $value){
			switch($key){
				case 'basic' : $basic_cost = ($value != "") ? $basic_cost1 + $service_tax_amount : $basic_cost1;$inclusive_b = $value;break;
				case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;break;
				case 'markup' : $markup = ($value != "") ? $markup + $markupservice_tax_amount : $markup;$inclusive_m = $value;break;
			}
		}
    ?>
<form id="frm_tab3">
	<div class="app_panel"> 
<?php
?>
	<!--=======Header panel======-->
		<div class="app_panel_head mg_bt_20">
		<div class="container">
			<h2 class="pull-left"></h2>
			<div class="pull-right header_btn">
			</div>
		</div>
		</div> 
	<!--=======Header panel end======-->
        <div class="container" id="table_data">
                <div class="row mg_tp_10">
                <div class="col-xs-12">
                    <h3 class="editor_title">Costing</h3>
                    <div class="panel panel-default panel-body app_panel_style">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table id="hotel_quotation_costing_update">

                                        <td class="header_btn header_btn" style="padding:4px"><small id="basic_show-u_1" style="color:red"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small><input type="number" id="basic_cost-u_1" name="basic_cost-u_1" placeholder="Hotel Cost" title="Hotel Cost" value="<?= $basic_cost ?>"  onchange="validate_balance(this.id);get_auto_values('quotation_date1','basic_cost-u_1','payment_mode','service_charge-u_1','markup_cost-u_1','update','true','service_charge','discount1',true);"> </td>

                                        <td class="header_btn header_btn" style="padding:4px"><small id="service_show-u_1" style="color:red"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small><input type="number" id="service_charge-u_1" name="service_charge-u_1" placeholder="Service Charge" title="Service Charge" value="<?= $service_charge ?>"  onchange="validate_balance(this.id);get_auto_values('quotation_date1','basic_cost-u_1','payment_mode','service_charge-u_1','markup_cost-u_1','update','false','service_charge','discount1',true);"></td>

                                        <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="text" id="tax_amount-u_1" name="tax_amount-u_1" placeholder="Tax Amount" title="Tax Amount"  value="<?= $costDetails['tax_amount'] ?>" onchange="validate_balance(this.id)" readonly> </td>

                                        <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="number" id="markup_cost-u_1" name="markup_cost-u_1" placeholder="Markup Cost" title="Markup Cost" value="<?= $markup ?>"  onchange="validate_balance(this.id);get_auto_values('quotation_date1','basic_cost-u_1','payment_mode','service_charge-u_1','markup_cost-u_1','update','false','service_charge','discount1',true);" > </td>

                                        <td class="header_btn header_btn" style="padding:4px"><small id="markup_show-u_1" style="color:red"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small><input type="text" id="tax_markup-u_1" name="tax_markup-u_1" placeholder="Markup Tax" title="Markup Tax" value="<?= $costDetails['markup_tax'] ?>"  onchange="validate_balance(this.id)" readonly> </td>

										<td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="text" id="roundoff-u_1" name="roundoff-u_1" placeholder="Round Off" title="Round Off" value="<?= $costDetails['roundoff'] ?>"  onchange="validate_balance(this.id)" readonly> </td>

                                        <td class="header_btn header_btn" style="padding:4px"><small>&nbsp;</small><input type="number" id="total_amount-u_1" class="amount_feild_highlight text-right form-control" name="total_amount-u_1" placeholder="Total Amount" title="Total Amount" value="<?= $costDetails['total_amount'] ?>"  onchange="validate_balance(this.id)" readonly> </td>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<select name="currency_code1" id="currency_code1" title="Currency" style="width:100%" data-toggle="tooltip" required>
						<?php
						$sq_currencyd = mysqli_fetch_assoc(mysqlQuery("SELECT `id`,`currency_code` FROM `currency_name_master` WHERE id=" . $sq_quotation['currency_code']));
						?>
						<option value="<?= $sq_currencyd['id'] ?>"><?= $sq_currencyd['currency_code'] ?></option>
						<?php
						$sq_currency = mysqlQuery("select * from currency_name_master order by currency_code");
						while($row_currency = mysqli_fetch_assoc($sq_currency)){
						?>
						<option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
						<?php } ?>
					</select>
				</div>
            </div>
		</div>

		<div class="row text-center mg_tp_20">
			<div class="col-xs-12">
				<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
				&nbsp;&nbsp;
				<button id="btn_quotation_update" class="btn btn-info btn-sm ico_right">Update&nbsp;&nbsp;<i class="fa fa-floppy-o"></i></button>
			</div>
		</div>
	</div>
</form>

<script>
$('#currency_code1').select2();
function switch_to_tab2(){ 
	$('#tab3_head').addClass('done');
	$('#tab2_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab2').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$('#frm_tab3').validate({

	submitHandler:function(form,e)
	{
        e.preventDefault();
		var quotation_id = $('#quotation_id').val();
		var quotation_date = $('#quotation_date1').val();
		var currency_code = $('#currency_code1').val();
		var base_url = $('#base_url').val();

		var enquiryDetails = {
			enquiry_id : $('#enquiry_id1').val(),
			customer_name : $('#customer_name1').val(),
			email_id : $('#email_id1').val(),
			country_code : $('#country_code1').val(),
			whatsapp_no : $('#whatsapp_no1').val(),
			total_adult : $('#total_adult1').val(),
			children_without_bed : $('#children_without_bed1').val(),
			children_with_bed : $('#children_with_bed1').val(),
			total_infant : $('#total_infant1').val(),
			total_members : $('#total_members1').val(),
			hotel_requirements : $('#hotel_requirements1').val()
		};

			var table = document.getElementById("hotel_quotation_update");
			var rowCount = table.rows.length;
			var hotelDetails = [];
			for(var i=0; i<rowCount; i++){

				var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked){

					hotelDetails.push({
						city_id	:	row.cells[2].childNodes[0].value,
						hotel_id	:	row.cells[3].childNodes[0].value,
						hotel_cat	:	row.cells[4].childNodes[0].value,
						meal_plan : row.cells[5].childNodes[0].value,
						checkin	:	row.cells[6].childNodes[0].value,
						checkout	:	row.cells[7].childNodes[0].value,
						hotel_type : row.cells[8].childNodes[0].value,
						hotel_stay_days	:	row.cells[9].childNodes[0].value,
						total_rooms	:	row.cells[10].childNodes[0].value,
						extra_bed	:	row.cells[11].childNodes[0].value,
						hotel_cost	:	row.cells[12].childNodes[0].value
					});
				}
			}
			
            
            var table = document.getElementById("hotel_quotation_costing_update");
			var rowCount = table.rows.length;
			
            var row = table.rows[0];

			var costingDetails = {
				hotel_cost	:	row.cells[0].childNodes[1].value,
				service_charge	:	row.cells[1].childNodes[1].value,
				tax_amount	:	row.cells[2].childNodes[1].value,
				markup_cost	:	row.cells[3].childNodes[1].value,
				markup_tax	:	row.cells[4].childNodes[1].value,
				roundoff	:	row.cells[5].childNodes[1].value,
				total_amount	:	row.cells[6].childNodes[1].value
			};
            
			var bsmValues ={
				"basic" : $(row.cells[0].childNodes[0]).find('span').text(),
				"service" : $(row.cells[1].childNodes[0]).find('span').text(),
				"markup" : $(row.cells[4].childNodes[0]).find('span').text()
			}
		$.post(base_url + '/controller/hotel/quotation/quotation_update.php',	{ hotelDetails : hotelDetails, costingDetails : costingDetails , enquiryDetails : enquiryDetails, quotation_id : quotation_id, bsmValues : bsmValues,quotation_date:quotation_date,currency_code:currency_code},	function(message){
			
			$('#btn_quotation_update').button('reset');
			var msg = message.split('--');

			if(msg[0]=="error"){
				error_msg_alert(msg[1]);
			}
			else{
					$('#vi_confirm_box').vi_confirm_box({
						false_btn: false,
						message: message,
						true_btn_text:'Ok',
						callback: function(data1){
							if(data1=="yes"){
								$('#btn_quotation_update').button('reset');
								window.location.href = base_url+'view/hotel_quotation/index.php';
								quotation_list_reflect();
							}
						}
					});
				}
		});
	}
});
</script>