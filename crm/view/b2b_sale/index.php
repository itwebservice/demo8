<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('B2B Bookings','') ?>
<?php
if($setup_package == '4'){ ?>

<div class="row">
    <div class="col-md-12 text-right text_left_sm_xs">
      <button class="btn btn-excel btn-sm mg_bt_20" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
    </div>
</div>

<div class="app_panel_content Filter-panel mg_bt_20">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="cust_filter" id="cust_filter" onchange="booking_reflect();list_reflect();" style="width:100%" data-toggle="tooltip" title="Select Agent">
            <?php
            $sq_rc = mysqlQuery("select * from customer_master where type='B2B' and active_flag='Active'"); ?>
            <option value="">Select Agent</option>
            <?php
            while($row_rc = mysqli_fetch_assoc($sq_rc)){
              ?>
              <option value="<?= $row_rc['customer_id'] ?>"><?=  $row_rc['company_name'] ?></option>
              <?php } ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="b2b_booking_master" id="b2b_booking_master" style="width:100%" onchange="list_reflect();" title="Select Booking ID" data-toggle="tooltip">
              <option value="">Select Booking</option></select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="from_date_filter" name="from_date_filter" onchange="get_to_date(this.id,'to_date_filter');list_reflect();" placeholder="From Date"  data-toggle="tooltip" title="From Date">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
          <input type="text" id="to_date_filter" name="to_date_filter" onchange="validate_validDate('from_date_filter','to_date_filter');list_reflect();" placeholder="To Date" data-toggle="tooltip" title="To Date">
        </div>
    </div>
</div>

<div id="list_reflect" class="main_block loader_parent mg_tp_20">
<div class="table-responsive mg_tp_10">
        <table id="b2bsale_book" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_view_modal"></div>
<div id="div_voucher_view_modal"></div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>

<script>
$('#cust_filter,#b2b_booking_master').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ format:'d-m-Y', timepicker:false});
var columns = [
	{ title : "S_No"},
	{ title : "Booking_ID"},
	{ title : "Agent_name"},
	{ title : "Booking_date"},
	{ title : "total_amount", className : "warning"},
	{ title : "cancel_amount", className : "danger"},
	{ title : "net_amount", className : "info"},
	{ title : "paid_amount", className : "success"},
	{ title : "Balance_amount", className : "info"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
];
function list_reflect()
{
  $('#list_reflect').append('<div class="loader"></div>');
	var customer_id = $('#cust_filter').val();
	var b2b_booking_master = $('#b2b_booking_master').val();
	var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();

	$.post('list_reflect.php',{ b2b_booking_master : b2b_booking_master, customer_id : customer_id, from_date : from_date, to_date : to_date}, function(data){
    pagination_load(data,columns,true,true,10,'b2bsale_book');
		$('.loader').remove();
	});
}
list_reflect();
function customer_display_modal(booking_id){
  
  $('#view-'+booking_id).button('loading');
	$.post('view/index.php', { booking_id : booking_id }, function(data){
    $('#view-'+booking_id).button('reset');
		$('#div_view_modal').html(data);
	});
}
function booking_reflect()
{  
	var customer_id = $('#cust_filter').val();
  $.post('booking_reflect.php', { customer_id : customer_id}, function(data){
    $('#b2b_booking_master').html(data);
  });
}
booking_reflect();
function excel_report(){
	var customer_id = $('#cust_filter').val();
	var b2b_booking_master = $('#b2b_booking_master').val();
	var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();
    
  window.location = 'excel_report.php?b2b_booking_master='+b2b_booking_master+'&customer_id='+customer_id+'&from_date='+from_date+'&to_date='+to_date;
}
function voucher_modal(booking_id,hotel_flag,activity_flag){
  $.post('voucher_modal.php', {booking_id : booking_id, hotel_flag:hotel_flag, activity_flag:activity_flag}, function(data){
    $('#div_voucher_view_modal').html(data);
  });
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 

} else{ ?>
  <div class="alert alert-danger" role="alert">
    Please upgrade the subscription to use this feature.
  </div>
 <?php }?>