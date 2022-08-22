function ticket_id_dropdown_load(customer_id_filter, ticket_id_filter)
{
	var customer_id = $('#'+customer_id_filter).val();
	var branch_status = $('#branch_status').val();
	$.post('ticket_id_dropdown_load.php', { customer_id : customer_id  , branch_status : branch_status}, function(data){
		$('#'+ticket_id_filter).html(data);
		$('#'+ticket_id_filter).val('');
        $('#'+ticket_id_filter).trigger('change');
	});
}

function generate_ticket_payment_receipt(payment_id)
{
	url = 'payment/payment_receipt.php?payment_id='+payment_id;
	window.open(url, '_blank');
}

function cash_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();

	$('input[name="chk_ticket_payment"]:checked').each(function(){

		payment_id_arr.push($(this).val());

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/ticket_payment/cash_bank_receipt.php?payment_id_arr="+payment_id_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function cheque_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();
	var branch_name_arr = new Array();

	$('input[name="chk_ticket_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(19);
		var branch_name = $('#branch_name_'+offset).val();

		payment_id_arr.push($(this).val());
		branch_name_arr.push(branch_name);		

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	$('input[name="chk_ticket_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(19);
		var branch_name = $('#branch_name_'+offset).val();

		if(branch_name==""){
			error_msg_alert("Please enter branch name for selected payments!");				
			exit(0);
		}
	});

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/ticket_payment/cheque_bank_receipt.php?payment_id_arr="+payment_id_arr+'&branch_name_arr='+branch_name_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function get_arrival_dateid(departure_date){
	var offset = departure_date.split('-');
	get_to_datetime(departure_date,'arrival_datetime-'+offset[1]);
}
function whatsapp_send(emp_id, customer_id, booking_date, base_url,contact_no,email_id){
	
	$.post(base_url+'controller/visa_passport_ticket/ticket/whatsapp_send.php',{emp_id:emp_id,booking_date:booking_date ,customer_id:customer_id,booking_date:booking_date,contact_no:contact_no,email_id:email_id}, function(data){
		console.log(data);
		window.open(data);
	});
}
function validate_validDatetimeFlight(id){

	var offset = id.split('-')[1];
	var from_date = $('#departure_datetime-' + offset).val();
	var to_date = $('#' + id).val();

	from_date = from_date.split(' ')[0];
	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	to_date = to_date.split(' ')[0];
	var edate1 = to_date.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('From date should not be greater than valid To date');
		$('#departure_datetime-' + offset).css({ border: '1px solid red' });
		document.getElementById('departure_datetime-' + offset).value = '';
		g_validate_status = false;
		return false;
	}
	else {
		$('#departure_datetime-' + offset).css({ border: '1px solid #ddd' });
		return true;
	}
}