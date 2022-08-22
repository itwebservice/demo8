<?php
include "../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>">
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>">
<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">
<div class="modal fade" id="enquiry_save_modal" role="dialog" aria-labelledby="enquiry_save_modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Enquiry Details</h4>
      </div>
      <div class="modal-body">
        <form id="frm_emquiry_save">
                <div class="row mg_bt_20">
                    <div class="col-sm-4 col-sm-offset-4">
                        <select name="enquiry_type" id="enquiry_type" title="Enquiry For" title="Enquiry For" data-toggle="tooltip" onchange="enquiry_fields_reflect()" class="form-control">
                            <option value="Package Booking">Package Booking</option>
                            <option value="Group Booking">Group Booking</option>
                            <option value="Hotel">Hotel</option>
                            <option value="Flight Ticket">Flight Ticket</option>
                            <option value="Car Rental">Car Rental</option>
                            <option value="Visa">Visa</option>
                            <option value="Bus">Bus</option>
                            <option value="Train Ticket">Train Ticket</option>
                        </select>
                    </div>
                </div>
                <div class="row mg_tp_10">
                    <div class="col-md-3 col-sm-6 mg_bt_10">
                        <input type="text" class="form-control" id="txt_name" name="txt_name" onchange="fname_validate(this.id)" placeholder="*Customer Name" title="Customer Name">
                        <input type="hidden" id="cust_data" name="cust_data" value='<?= get_customer_hint() ?>'>
                    </div>
                    <div class="col-md-3 col-sm-6 mg_bt_10">
                        <input type="number" class="form-control" id="txt_mobile_no" onchange="mobile_validate(this.id);" name="txt_mobile_no" placeholder="*Mobile No" title="Mobile No"> 
                    </div>
                    <div class="col-md-3 col-sm-6 mg_bt_10">
                      <div class="row">
                        <div class="col-md-4" style="padding-right:0px;">
                          <select name="country_code" id="country_code" style="width:100px;">
                              <?= get_country_code(); ?>
                          </select>
                        </div>
                        <div class="col-md-8">
                          <input type="number" class="form-control" id="txt_landline_no" onchange="mobile_validate(this.id);" name="txt_landline_no" placeholder="WhatsApp No" title="WhatsApp No"> 
                        </div>
                      </div>      
                    </div>        
                    <div class="col-md-3 col-sm-6 mg_bt_10">
                        <input type="text" class="form-control" id="txt_email_id" name="txt_email_id" placeholder="Email ID" title="Email ID">
                    </div>   
                </div>
		            <input type="hidden" id="destinations" name="destinations" placeholder="destinations" value='<?= get_destinations() ?>'>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mg_bt_10">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location" title="Location">
                    </div>
                </div>
                <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
                  <legend>Service Information</legend>
                  <div id="div_enquiry_fields"></div>
                </div>
                <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
                 <legend>Office Information</legend>
                <div class="row"> 
                    <div class="col-sm-4 mg_bt_10">
                        <input type="text" class="form-control" id="txt_enquiry_date"  name="txt_enquiry_date" placeholder="*Enquiry Date" title="Enquiry Date" onchange="check_valid_date(this.id)" value="<?= date('d-m-Y') ?>">
                    </div>
                    <div class="col-sm-4 mg_bt_10">
                        <input type="text" class="form-control" id="txt_followup_date" name="txt_followup_date" placeholder="*Followup Date" title="Followup Date & Time" value="<?= date('d-m-Y H:i') ?>">
                    </div>
                    <div class="col-sm-4 mg_bt_10">
                        <select name="reference_id" id="reference_id" style="width:100%" title="Reference" onchange="customer_fields_reflect()">
                            <option value="">Reference</option>
                            <?php 
                            $sq_ref = mysqlQuery("select * from references_master where active_flag!='Inactive' order by reference_name asc");
                            while($row_ref = mysqli_fetch_assoc($sq_ref)){
                              ?>
                              <option value="<?= $row_ref['reference_id'] ?>"><?= $row_ref['reference_name'] ?></option>
                              <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6 mg_bt_10">
                      <select id="customer_dropdown" name="customer_dropdown" title="Customer" class="form-control hidden">
                          <option value="">Select Customer</option>
                      </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 mg_bt_10_xs">
                        <select name="assigned_emp_id" id="assigned_emp_id" title="Allocate To" style="width:100%">
                            <option value="">*Allocate To</option>
                            <?php
                            if($role=='Admin' || ($branch_status!='yes' && $role=='Branch Admin')){
                              $query = "select * from emp_master where active_flag='Active' order by first_name desc";
                            $sq_emp = mysqlQuery($query);
                            while($row_emp = mysqli_fetch_assoc($sq_emp)){
                                ?>
                                <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                                <?php
                              }
                            }
                            elseif($branch_status=='yes' && $role=='Branch Admin'){
                              $query = "select * from emp_master where active_flag='Active' and branch_id='$branch_admin_id' order by first_name asc";
                            $sq_emp = mysqlQuery($query);
                            while($row_emp = mysqli_fetch_assoc($sq_emp)){
                                ?>
                                <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                                <?php
                              }
                            }
                            else{ 
                            $query1 = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id' and active_flag='Active'")); ?>

                              <option value="<?= $query1['emp_id'] ?>"><?= $query1['first_name'].' '.$query1['last_name'] ?></option>

                            <?php
                            }
                            ?>
                              
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6 mg_bt_10_xs">
                      <select name="enquiry" id="enquiry" title="Enquiry Type" class="form-control">
                        <option value="">Enquiry Type</option>
                        <option value="<?= "Strong" ?>">Strong</option>
                        <option value="<?= "Hot" ?>">Hot</option>
                        <option value="<?= "Cold" ?>">Cold</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                        <textarea class="form-control" id="txt_enquiry_specification" onchange="validate_spaces(this.id);" name="txt_enquiry_specification" placeholder="Other Enquiry specification (If any)" title="Enquiry Specification"></textarea>
                    </div>
                </div>
              </div>

            <div class="row text-center mg_tp_20">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-success" id="btn_enq_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>
        </form>
        

        </div>
    
    </div>
  </div>
</div>

<script>
$('#enquiry_save_modal').modal('show');
$('#reference_id,#assigned_emp_id,#country_code').select2();
$("#txt_enquiry_date").datetimepicker({ timepicker:false, format:'d-m-Y' });
$("#txt_followup_date" ).datetimepicker({ format:'d-m-Y H:i' });

function enquiry_fields_reflect()
{
  var enquiry_type = $('#enquiry_type').val();
  $.post('enquiry_fields_reflect.php', { enquiry_type : enquiry_type }, function(data){
      $('#div_enquiry_fields').html(data);
  });
}
enquiry_fields_reflect();
function customer_fields_reflect(){
	var reference_id = $('#reference_id').val();
  if(reference_id == 3){
		$.post('customer_fields_reflect.php', {reference_id : reference_id}, function(data){
      $('#customer_dropdown').removeClass('hidden');
		  $('#customer_dropdown').html(data);
	  }); 
  }else{
		  $('#customer_dropdown').html('');
	    $('#customer_dropdown').addClass('hidden');
  }
}customer_fields_reflect();
///////////////////////***Enquiry Master save start*********//////////////
$(function(){
  $('#frm_emquiry_save').validate({
    rules:{
      txt_name : { required :true },
      assigned_emp_id : { required : true },
      txt_enquiry_date : { required :true },
      txt_followup_date : { required :true },
      enquiry : { required : true },
      txt_mobile_no : { required : true },
    },
    submitHandler:function(form,e){
      e.preventDefault();

      var base_url = $('#base_url').val();  
      var login_id = $("#login_id").val();

      var enquiry_type = $('#enquiry_type').val(); 
      if(enquiry_type == 'Flight Ticket') table_count();//for flight only
      var enquiry = $('#enquiry').val(); 
      var name = $("#txt_name").val(); 
      var mobile_no = $("#txt_mobile_no").val(); 
      var landline_no = $("#txt_landline_no").val();
      var country_code = $('#country_code').val();
      var email_id = $("#txt_email_id").val();
      var location = $("#location").val();
      var assigned_emp_id  = $('#assigned_emp_id').val();
      var enquiry_specification = $("#txt_enquiry_specification").val(); 
      var enquiry_date = $("#txt_enquiry_date").val(); 
      var followup_date = $("#txt_followup_date").val();
      var reference_id = $('#reference_id').val();
      var branch_admin_id = $('#branch_admin_id').val();
      var financial_year_id = $('#financial_year_id').val();
      var customer_name = $('#customer_dropdown').val();
      
      var enquiry_content = Array();
      if(enquiry_type == 'Flight Ticket'){
        var table = document.getElementById("tbl_enquiry_flight");
        var rowCount = table.rows.length;
        var selectedFlag = false;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
            selectedFlag = true;
            if(row.cells[2].childNodes[0].value == ''){
              error_msg_alert('Select travel date/time in row '+(i+1)); return false;
            }
            if(row.cells[3].childNodes[0].value == ''){
              error_msg_alert('Select sector from in row '+(i+1)); return false;
            }
            if(row.cells[4].childNodes[0].value == ''){
              error_msg_alert('Select sector to in row '+(i+1)); return false;
            }
            var obj = {
              travel_datetime : row.cells[2].childNodes[0].value,
              sector_from : row.cells[3].childNodes[0].value,
              sector_to : row.cells[4].childNodes[0].value,
              preffered_airline : row.cells[5].childNodes[0].value,
              class_type : row.cells[6].childNodes[0].value,
              total_adults_flight : row.cells[7].childNodes[0].value,
              total_child_flight : row.cells[8].childNodes[0].value,
              total_infant_flight : row.cells[9].childNodes[0].value,
              from_city_id_flight : row.cells[10].childNodes[0].value,
              to_city_id_flight : row.cells[11].childNodes[0].value,
              budget : $('#budget').val()
            }
            enquiry_content.push(obj); 
          }
        }
        if(!selectedFlag){
          error_msg_alert("Select Atleast one Flight Service Information");
          return false;
        }
      }
        else
          enquiry_content = $('#div_enquiry_fields').find('select, input, textarea').serializeArray();

        var err_msg = "";

        if(landline_no != '' && country_code == ''){
          error_msg_alert("Country Code is Required!");
          return false;
        }
        for(arr1 in enquiry_content){

          var row = enquiry_content[arr1];
          var field = row['name'];
          var field_val = $('#'+field).val();
          if(field_val==""){
          
              var placeholder = $('#'+field).attr('name');
              if(placeholder != 'Child Without Bed' && placeholder !='Child With Bed' && placeholder !='budget'){
              
                if (placeholder == "places_to_visit"){
                  placeholder = "route";
                } else if (placeholder == "vehicle_type") {
                  placeholder = "Vehicle Name";
                }else if (placeholder == "hotel_type") {
                  placeholder = "Hotel category";
                }
                if (placeholder == "hotel_requirements"){
                  placeholder = "Hotel Requirements";
                }
                if (placeholder == "total_adult"){
                  placeholder = "Total Adult(s)";
                }
                if (placeholder == "total_cwb"){
                  placeholder = "Total Child With Bed(s)";
                }
                if (placeholder == "total_cwob"){
                  placeholder = "Total Child Without Bed(s)";
                }
                if (placeholder == "total_infant"){
                  placeholder = "Total Infant(s)";
                }
                if (placeholder == "total_members"){
                  placeholder = "Total Members";
                }
                if (placeholder == "traveling_date"){
                  placeholder = "Travel From Date";
                }
                if (placeholder == "route"){
                  placeholder = "Route";
                }
                err_msg += placeholder+" is required!<br>"; 
              }
          }
        }
        if(err_msg!=""){
          error_msg_alert(err_msg);
          return false;
        }
        
        $('#btn_enq_save').button('loading');
        var obj = { login_id : login_id, enquiry_type : enquiry_type, name : name, mobile_no : mobile_no, email_id : email_id,location : location, assigned_emp_id : assigned_emp_id , enquiry_specification : enquiry_specification, enquiry_date : enquiry_date, followup_date : followup_date, reference_id : reference_id, enquiry_content : enquiry_content, landline_no : landline_no,enquiry : enquiry , branch_admin_id : branch_admin_id,financial_year_id : financial_year_id, country_code : country_code,customer_name:customer_name};
        $.post(
            base_url+"controller/attractions_offers_enquiry/enquiry_master_save_v.php",
            {  mobile_no : mobile_no, email_id : email_id },
            function(data) { 
              $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: enquiry_date }, function(data1){
              if(data1 !== 'valid'){
                $('#btn_enq_save').button('reset');
                error_msg_alert("The Enquiry date does not match between selected Financial year.");
                return false;
              } 
              else{ 
                prompt_error_enquiry(obj, data);
              }
            });
        });

    }
  });
});

function prompt_error_enquiry(obj, msg){

  if(msg=="This enquiry does not exists."){
    actual_enq_save(obj);
  }
  else{
  
    $('#vi_confirm_box').vi_confirm_box({
      message: msg+"<br>Are you sure to save?",
      callback: function(data1){
          if(data1=="yes"){
            actual_enq_save(obj);
          }
          else{
            $('#btn_enq_save').button('reset');
            return false;
          }
      }
    });
  }
}

function actual_enq_save(obj){

  var base_url = $('#base_url').val(); 
  $.post( 
    base_url+"controller/attractions_offers_enquiry/enquiry_master_save_c.php",
    obj,
    function(data) {  
        var msg = data.split('--');
        if(msg[0]=="error"){
          msg_alert(data);
          $('#btn_enq_save').button('reset');
        }
        else{
          $('#enquiry_save_modal').modal('hide');
          msg_alert(data);                               
          $('#btn_enq_save').button('reset');  
          enquiry_proceed_reflect();
          return false;
        }
    });
}

$("#txt_name").autocomplete({
    source: JSON.parse($('#cust_data').val()),
    select: function (event, ui) {
	  $("#txt_name").val(ui.item.label);
    $('#txt_mobile_no').val(ui.item.contact_no);
    $('#txt_landline_no').val(ui.item.contact_no);
    $('#txt_email_id').val(ui.item.email_id);
    var country_code = ui.item.country_code;
    $('#country_code').prepend($('<option value='+ui.item.country_id+'>'+country_code+'</option>')); 
		document.getElementById('country_code').selectedIndex = "0";
    $('#country_code').trigger('change');
    },
    open: function(event, ui) {
		$(this).autocomplete("widget").css({
            "width": document.getElementById("txt_name").offsetWidth
        });
    }
}).data("ui-autocomplete")._renderItem = function(ul, item) {
      return $("<li disabled>")
        .append("<a>" + item.label +"</a>")
        .appendTo(ul);
	
};

///////////////////////***Enquiry Master save end*********//////////////
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>