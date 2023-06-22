/////// Show Tours Start///////////////////////////////////////////////
function group_tours_reflect(id)
{
	var base_url = $('#base_url').val();
	var dest_id = document.getElementById(id).value;
	$.get(base_url+"view/group_tours/inc/tours_list_load.php", { dest_id : dest_id }, function(data){
		$('#cmb_tour_name').html('');
		$('#cmb_tour_name').html(data);
	});
}
/////// Show Tours End///////////////////////////////////////////////
/////// Show Tour Groups Start///////////////////////////////////////////////
function tour_group_reflect(id,flag=false)
{
	var base_url = $('#base_url').val();
	var tour_id = document.getElementById(id).value;  

	$.get(base_url+"view/group_tours/inc/tour_group_reflect.php", { tour_id : tour_id, flag : flag }, function(data){
		$('#cmb_tour_group').html('');
		$('#cmb_tour_group').html(data);
		if($('select#cmb_tour_group option').length == 1)
			$('#cmb_tour_group').append('<option disabled>No Active Group Tours Found!!');
	});
}
/////// Show Tour Groups End/////////////////////////////////////////////////
/////// Reflect capacity and how many seats are available ////////////////////////////////
function seats_availability_reflect()
{
	var base_url = $('#base_url').val();
	var tour_id = $("#cmb_tour_name").val();
	var tour_group_id = $("#cmb_tour_group").val();
	if( tour_id == '' || tour_group_id == '')
	{
		document.getElementById("seats_availability").innerHTML = "";
		return false;
	}
	$.get(base_url+'view/group_tours/inc/seats_availability_reflect.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){
		$('#seats_availability').html(data);
	});
}
//Tours Search From submit
$(function () {
	$('#frm_group_tours_search').validate({
		rules         : {},
		submitHandler : function (form) {

			var base_url = $('#base_url').val();
			var crm_base_url = $('#crm_base_url').val();
			var currency = $('#currency').val();
			var dest_id = $('#gtours_dest_filter').val();
			var tour_name = $('#cmb_tour_name').val();
			var tour_group = $('#cmb_tour_group').val();
            var adult = $('#gtadult').val();
            var child_wobed = $('#gchild_wobed').val();
			var child_wibed = $('#gchild_wibed').val();
			var extra_bed = $('#gextra_bed').val();
            var infant = $('#gtinfant').val();
			var seats_availability = $('#seats_availability').html();
			if (dest_id == '') {
				error_msg_alert('Select Destination!',base_url);
				return false;
            }
			if (tour_name == '') {
				error_msg_alert('Select Tour Name!',base_url);
				return false;
            }
			if (tour_group == '') {
				error_msg_alert('Select Tour Date!',base_url);
				return false;
            }
            if(parseInt(adult) === 0){
				error_msg_alert('Select No of. Adults!',base_url);
				return false;
            }
            
			var tours_array = [];
			tours_array.push({
				'dest_id':dest_id,
				'tour_id':tour_name,
				'tour_group_id':tour_group,
				'adult':parseInt(adult),
				'child_wobed':parseInt(child_wobed),
				'child_wibed':parseInt(child_wibed),
				'extra_bed':parseInt(extra_bed),
				'infant':parseInt(infant),
				'seats_availability':seats_availability
			})
			$.post(crm_base_url+'controller/custom_packages/search_session_save.php', { tours_array: tours_array,currency:currency }, function (data) {
				window.location.href = base_url + 'view/group_tours/tours-listing.php';
			});
		}
	});
});