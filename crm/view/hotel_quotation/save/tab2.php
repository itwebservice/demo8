<form id="frm_tab2">
	<div class="app_panel"> 
	<!--=======Header panel======-->
		<div class="app_panel_head mg_bt_20">
			<div class="container">
				<h2 class="pull-left"></h2>
				<div class="pull-right header_btn">
					<button>
						<a>
							<i class="fa fa-arrow-right"></i>
						</a>
					</button>
				</div>
			</div>
		</div> 
	<!--=======Header panel end======-->
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_20" id="package_div">
						<input type="number" name="nofquotation" id="nofquotation" placeholder="Enter No of Quotation(s)" title="Number of Quotation(s)" onchange="options_dynamic_reflect(this.id)">
					</div>
				</div>
				<div class="row">
					<div class="col-md-9 col-sm-4 col-xs-12 mg_bt_20">
						<small class="note">Note - Use this field to generate multiple hotel quotations for eg. If you enter 3 here you can create 3 quotation options.</small>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-8 col-xs-12 no-pad" id="options_div"></div>
				</div>
			</div>

		

		<div class="row text-center mg_tp_30 mg_bt_30">
			<div class="col-xs-12">
				<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>
				&nbsp;&nbsp;
				<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
		</div>
	</div>
</form>


<script>
$('#dest_name').select2();
function switch_to_tab1(){ 
	$('#tab2_head').addClass('done');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
 }

$('#frm_tab2').validate({

	submitHandler:function(form,e)
	{
		e.preventDefault();
		var nofquotation = $('#nofquotation').val();
		if(nofquotation == ''){
			error_msg_alert('Please Enter Number of Quotations');
			$('#nofquotation').val('');
			$('#nofquotation').css('border','1px solid red');
			return false
		}
		var hotelcostArr = new Array();
		var hcount = 0;
		for(var quot = 1; quot <= Number(nofquotation); quot++){
			var table = document.getElementById("dynamic_table_list_h_"+quot);
			var rowCount = table.rows.length;

			var hcostTotal = 0;
			for(var i=0; i<rowCount; i++){

				var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked){

					hcount++;
					var city_name = row.cells[2].childNodes[0].value;
					var hotel_id = row.cells[3].childNodes[0].value;  
					var hotel_cat = row.cells[4].childNodes[0].value;
					var check_in = row.cells[6].childNodes[0].value;  
					var checkout = row.cells[7].childNodes[0].value;        
					var hotel_stay_days1 = row.cells[9].childNodes[0].value;
					var total_rooms = row.cells[10].childNodes[0].value;
					var hotel_cost = row.cells[12].childNodes[0].value;  	      
					hcostTotal += Number(hotel_cost);

					if(city_name==""){
						error_msg_alert('Select Hotel city in Row '+(i+1)+ ' in Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}

					if(hotel_id==""){
						error_msg_alert('Enter Hotel in Row '+(i+1)+ ' in Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}
					if(hotel_cat==""){
						error_msg_alert('Enter Room Category in Row '+(i+1)+ ' in Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}
					if(check_in==""){
						error_msg_alert('Select Check-In date in Row '+(i+1)+ ' in Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}

					if(checkout==""){
						error_msg_alert('Select Check-Out date in Row '+(i+1)+ ' in Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}
					if(total_rooms==""){
						error_msg_alert('Enter total rooms in Row '+(i+1)+ ' in Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}
					if(hotel_stay_days1==""){
						error_msg_alert('Enter Hotel total days in Row '+(i+1)+ ' of Option ' + quot);
						$('.accordion_content').removeClass("indicator");
						$('#tbl_package_tour_quotation_dynamic_hotel').parent('div').closest('.accordion_content').addClass("indicator");
						return false;
					}
				}
				get_hotel_cost("dynamic_table_list_h_"+quot);
			}
			hotelcostArr.push(hcostTotal);
		}
		if(parseInt(hcount) === 0){
			error_msg_alert("Atleast one hotel is required to proceed!");
			return false;
		}
		$.get("../get_options_costing.php", { nofquotation : nofquotation, hotelcostArr : hotelcostArr}, function(table){
			$('#table_data').html(table);
		});
			
		$('#tab2_head').addClass('done');
		$('#tab3_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab3').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});
</script>