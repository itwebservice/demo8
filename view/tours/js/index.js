//package list load
function package_dynamic_reflect(dest_name){
    var base_url = $('#base_url').val();
	var dest_id = $("#"+dest_name).val();

	$.ajax({
		type:'post',
		url: base_url+'view/tours/inc/tours_list_load.php', 
		data: { dest_id : dest_id}, 
		success: function(result){
			$('#tours_name_filter').html(result);
		},
		error:function(result){
			console.log(result.responseText);
		}
	});
}

//Tours Search From submit
$(function () {
	$('#frm_tours_search').validate({
		rules         : {},
		submitHandler : function (form) {
			var base_url = $('#base_url').val();
			var crm_base_url = $('#crm_base_url').val();
			var currency = $('#currency').val();
			var dest_id = $('#tours_dest_filter').val();
			var tour_id = $('#tours_name_filter').val();
            var tour_date = $('#travelDate').val();
            var adult = $('#tadult').val();
            var child_wobed = $('#child_wobed').val();
			var child_wibed = $('#child_wibed').val();
			var extra_bed = $('#extra_bed').val();
            var infant = $('#tinfant').val();
			if (dest_id == '' && tour_id == '') {
				error_msg_alert('Select atleast Destination!',base_url);
				return false;
            }
            if(parseInt(adult) === 0){
				error_msg_alert('Select No of. Adults!',base_url);
				return false;
            }
            
			var tours_array = [];
			tours_array.push({
				'dest_id':dest_id,
				'tour_id':tour_id,
				'tour_date':tour_date,
				'adult':parseInt(adult),
				'child_wobed':parseInt(child_wobed),
				'child_wibed':parseInt(child_wibed),
				'extra_bed':parseInt(extra_bed),
				'infant':parseInt(infant)
			})
			$.post(crm_base_url+'controller/custom_packages/search_session_save.php', { tours_array: tours_array,currency:currency }, function (data) {
				window.location.href = base_url + 'view/tours/tours-listing.php';
			});
		}
	});
});