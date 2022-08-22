//**Hotel Name load start**//
function hotel_name_list_load(id) {

  var count = id.substring(7);
  var city_id = $("#" + id).val();
  $.get("inc/hotel_name_load.php", { city_id: city_id }, function (data) {
    $("#hotel_id" + count).html(data);
  });
}
function calculate_total_nights(from_date1, to_date1, night_id) {

  var from_date = $('#' + from_date1).val();
  from_date = from_date.split(' ')[0];
  var to_date = $('#' + to_date1).val();
  to_date = to_date.split(' ')[0];
  if (from_date != '' && to_date != '') {
    var edate = from_date.split('-');
    e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
    var edate1 = to_date.split('-');
    e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

    var one_day = 1000 * 60 * 60 * 24;

    var from_date_ms = new Date(e_date).getTime();
    var to_date_ms = new Date(e_date1).getTime();

    var difference_ms = to_date_ms - from_date_ms;
    var total_days = Math.round(Math.abs(difference_ms) / one_day);

    total_days = parseFloat(total_days);
    $('#' + night_id).val(total_days);
  }
  else {
    $('#' + night_id).val(0);
  }
}
function get_quotation_details(element){
  
  var base_url = $('#base_url').val();
  var quotation_id = $(element).val();
  
  $.get(base_url + 'view/hotels/booking/inc/get_currency_dropdown.php', {quotation_id:quotation_id}, function (data) {
    $('#currency_div').html(data);
  });

  if(quotation_id == ''){
    var table = document.getElementById('tbl_hotel_booking');
    for (var k = 1; k < table.rows.length; k++) {
      document.getElementById("tbl_hotel_booking").deleteRow(k);
    }
    $('#pass_name').val('');
    $('#adults').val('');
    $('#childrens').val('');
    $('#infants').val('');
    $('#sub_total').val(0);
    $('#sub_total').trigger('change');
  }
  else{

    $.getJSON(base_url + 'view/hotels/booking/booking/get_quotation_details.php', { quotation_id: quotation_id }, function (data) {
    
        var table = document.getElementById('tbl_hotel_booking');
        for (var i = 1; i < table.rows.length; i++) {
          document.getElementById("tbl_hotel_booking").deleteRow(i);
        }
        for (var i = 1; i < table.rows.length; i++) {
          document.getElementById("tbl_hotel_booking").deleteRow(i);
        }
        for (var i = 1; i < table.rows.length; i++) {
          document.getElementById("tbl_hotel_booking").deleteRow(i);
        }
        data.hotel_details = (data.hotel_details) ? data.hotel_details : [];
        if (table.rows.length != data.hotel_details.length) {
          for (var i = 1; i < data.hotel_details.length; i++) {
            addRow('tbl_hotel_booking');
          }
        }
        $.each(data.hotel_details, function (i, field) {
          var row = table.rows[i];
          $(row.cells[2].childNodes[0]).select2('destroy');
          $(row.cells[2].childNodes[0]).append('<option value="' + field.city_id + '" selected>' + field.city_name + '</option>');
          city_lzloading('#' + row.cells[2].childNodes[0].id);
          $(row.cells[3].childNodes[0]).append('<option value="' + field.hotel_id + '" selected>' + field.hotel_name + '</option>');
          row.cells[4].childNodes[0].value = field.checkin + ' 00:00';
          row.cells[5].childNodes[0].value = field.checkout + ' 00:00';
          row.cells[6].childNodes[0].value = field.hotel_stay_days;
          row.cells[7].childNodes[0].value = field.total_rooms;
          row.cells[9].childNodes[0].value = field.hotel_cat;
          row.cells[11].childNodes[0].value = field.extra_bed;
          row.cells[12].childNodes[0].value = field.meal_plan;
          $('#pass_name').val(data.enquiry_details.customer_name);
          $('#adults').val(data.enquiry_details.total_adult);
          $('#childrens').val(Number(data.enquiry_details.children_without_bed) + Number(data.enquiry_details.children_with_bed));
          $('#infants').val(data.enquiry_details.total_infant);
    
          $('#service_charge').val(data.costing_details.service_charge);
          $('#markup').val(data.costing_details.markup_cost);
          $('#sub_total').val(data.costing_details.hotel_cost);
          $('#sub_total').trigger('change');
        });
    });
  }
}
//**Hotel Name load end**//