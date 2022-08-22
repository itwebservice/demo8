<?php
include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq1 = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='reports/staff_mgmt/index.php'"));
$branch_status_salary = $sq1['branch_status'];
?>
<div class="row text-right mg_tp_10 mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
        <button type="button" class="btn btn-info btn-sm ico_left" id="btn_save_modal" title="Add New Salary" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Salary</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
			<select name="year_filter1" style="width: 100%" id="year_filter1" title="Year" required>
				<option value="">*Year</option>
				<?php 
				for($year_count=2020; $year_count<2099; $year_count++){
					?>
					<option value="<?= $year_count ?>"><?= $year_count ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
			<select name="month_filter1" style="width: 100%" id="month_filter1" title="Month" required>
				<option value="">*Month</option>
				<option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
				<option value="04">April</option>
				<option value="05">May</option>
				<option value="06">June</option>
				<option value="07">July</option>
				<option value="08">August</option>
				<option value="09">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
		</div>
		<div class="col-md-3 mg_bt_10_xs">
			<select id="emp_id_filter1" name="emp_id_filter1" title="User Name" style="width: 100%">
				<option value="">Select User</option>
				<?php 
				$query ="select * from emp_master where 1 and active_flag!='Inactive'";  
				if($branch_status_salary=='yes' && $role!='Admin'){
				    $query .=" and branch_id='$branch_admin_id'";
				} 
				$sq_users = mysqlQuery($query);
				while($row_users = mysqli_fetch_assoc($sq_users)){
					?>
					<option value="<?= $row_users['emp_id'] ?>"><?= $row_users['first_name'].' '.$row_users['last_name'] ?></option>
					<?php
				} ?>
			</select>
		</div>
		<input type="hidden" id="branch_status_salary" value="<?= $branch_status_salary ?>"/>	
		<div class="col-md-3">
			<button type="submit" class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>
<hr>

<div id="div_salary_list_reflect" class="main_block loader_parent">
<div class="table-responsive mg_bt_150 mg_tp_10">
        <table id="emp_salary_table" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>


<div id="div_report" class="main_block"></div>
<div id="div_modal"></div>
<div id="div_update_modal"></div>
<script type="text/javascript">
$('#emp_id_filter1,#year_filter1, #month_filter1').select2();
function save_modal()
{
	var branch_status = $('#branch_status_salary').val();
	var base_url = $('#base_url').val();
	$('#btn_save').button('loading');
	$.post(base_url+'view/reports/staff_mgmt/report_reflect/emp_salary/save_modal.php', { branch_status : branch_status}, function(data){
		$('#btn_save').button('reset');
		$('#div_modal').html(data);
	});
}
var column = [
{ title : "S_No."},
{ title:"User_ID"},
{ title : "User_Name"},
{ title : "Days_Worked"},
{ title : "Gross_Salary"},
{ title : "salary_advance"},
{ title : "Incentive"},
{ title:"Employer_PF"},
{ title : "Employee_PF"},
{ title : "ESIC_Deduction"},
{ title : "PT_Deduction"},
{ title : "LWF_Deduction"},
{ title:"TDS_deduction"},
{ title : "Surcharge_deduction"},
{ title : "Cess_deduction"},
{ title : "leave_deduction"},
{ title : "Total_Deduction"},
{ title:"Net_Salary"},
{ title : "Actions"}	
];
function report_reflect()
{
	$('#div_salary_list_reflect').append('<div class="loader"></div>');
	var base_url = $('#base_url').val();
	var year = $('#year_filter1').val();
	var month = $('#month_filter1').val();
	var emp_id = $('#emp_id_filter1').val();
	var branch_status = $('#branch_status_salary').val();
	if(year == ''){
		error_msg_alert("Select Year!");
		return false;
	}
	if(month == ''){
		error_msg_alert("Select Month!");
		return false;
	}
	$.post(base_url+'view/reports/staff_mgmt/report_reflect/emp_salary/report_reflect.php', { year : year, month : month, emp_id : emp_id,branch_status:branch_status }, function(data){
		pagination_load(data, column, true, false, 20, 'emp_salary_table');
		$('.loader').remove();
	});
}

function salary_reflect(offset="")
{
	var emp_id = $('#emp_id_filter').val();
	var base_url = $('#base_url').val();

	$.post('report_reflect/emp_salary/salary_reflect.php', { emp_id : emp_id}, function(data){
		var result = JSON.parse(data);
		$('#txt_basic_pay1').val(result.basic_pay);
		$('#txt_dear_allow1').val(result.dear_allow);
		$('#hra1').val(result.hra);
		$('#txt_incentives1').val(result.incentive);
		$('#txt_travel_allow1').val(result.travel_allow);
		$('#txt_medi_all1').val(result.medi_allow);
		$('#special_allowance1').val(result.special_allow);
		$('#meal_allowance1').val(result.meal_allowance);
		$('#gross_salary1').val(result.gross_salary);
		$('#employer_pf1').val(result.employer_pf);
		$('#txt_pt1').val(result.pt);
		$('#txt_tds1').val(result.tds);
		$('#txt_labour1').val(result.labour_all);
		$('#employee_pf1').val(result.employee_pf);
		$('#txt_esic1').val(result.esic);
		$('#uniform_allowance1').val(result.uniform_allowance);
		$('#txt_deduction1').val(result.deduction);
		$('#net_salary1').val(result.net_salary);

    });
}
function update_modal(salary_id,month)
{
  var month1 = ('0' + month).slice(-2);

    $.post('report_reflect/emp_salary/update_modal.php', { salary_id : salary_id, month1 : month1 }, function(data){
        $('#div_update_modal').html(data);
    });
}
function calculate_total_payable(offset='')
{
	var basic_pay = $('#txt_basic_pay'+offset).val();
	var dear_allow = $('#txt_dear_allow'+offset).val();
	var hra = $('#hra'+offset).val();
	var travel_allow = $('#txt_travel_allow'+offset).val();
	var medi_allow = $('#txt_medi_all'+offset).val();
	var special_allow = $('#special_allowance'+offset).val();
	var uniform_allowance = $('#uniform_allowance'+offset).val();
	var incentive = $('#txt_incentives'+offset).val();
	var meal_allowance = $('#meal_allowance'+offset).val();
	var phone_allowance = $('#phone_allowance'+offset).val();
	var misc_earning = $('#misc_earning'+offset).val();

	var salary_advance = $('#salary_advance'+offset).val();
	var loan_ded = $('#loan_ded'+offset).val();
	var surcharge_deduction = $('#surcharge_deduction'+offset).val();
	var cess_deduction = $('#cess_deduction'+offset).val();
	var employee_pf = $('#employee_pf'+offset).val();
	var esic = $('#txt_esic'+offset).val();
	var pt = $('#txt_pt'+offset).val();
	var tds = $('#txt_tds'+offset).val();
	var labour_all = $('#txt_labour'+offset).val();
	var employer_pf = $('#employer_pf'+offset).val();
	var leave_deduction = $('#leave_deduction'+offset).val();
	
	if(basic_pay==""){ basic_pay=0; }
	if(dear_allow==""){ dear_allow=0; }
	if(hra==""){ hra=0; }
	if(travel_allow==""){ travel_allow=0; }
	if(medi_allow==""){ medi_allow=0; }
	if(special_allow==""){ special_allow=0; }
	if(uniform_allowance==""){ uniform_allowance=0; }
	if(incentive==""){ incentive=0;}
	if(meal_allowance==""){ meal_allowance=0; }
	if(phone_allowance==""){ phone_allowance=0; }
	if(misc_earning==""){ misc_earning=0; }

	if(salary_advance==""){ salary_advance=0; }
	if(loan_ded==""){ loan_ded=0;}
	if(surcharge_deduction==""){ surcharge_deduction=0; }
	if(cess_deduction==""){ cess_deduction=0; }
	if(employee_pf==""){ employee_pf=0; }
	if(esic==""){ esic=0; }
	if(pt==""){ pt=0; }
	if(labour_all==""){ labour_all=0; }
	if(tds==""){ tds=0; }
	if(leave_deduction==""){ leave_deduction=0; }
	if(employer_pf == '') { employer_pf = 0; }

	var total_addition= parseFloat(basic_pay) + parseFloat(dear_allow) + parseFloat(hra) + parseFloat(travel_allow) + parseFloat(medi_allow) + parseFloat(special_allow) + parseFloat(uniform_allowance) + parseFloat(incentive) + parseFloat(meal_allowance) + parseFloat(phone_allowance) + parseFloat(misc_earning);
	total_addition = round_off_value(total_addition);
	$('#gross_salary'+offset).val(total_addition);

	var total_deduction = parseFloat(employee_pf) + parseFloat(esic) + parseFloat(pt) + parseFloat(labour_all) + parseFloat(employer_pf) + parseFloat(tds) + parseFloat(salary_advance) + parseFloat(loan_ded) + parseFloat(surcharge_deduction) + parseFloat(cess_deduction) + parseFloat(leave_deduction);
	total_deduction = round_off_value(total_deduction);
	$('#txt_deduction'+offset).val(total_deduction);
	
	var total_add_value =  parseFloat(total_addition) - parseFloat(total_deduction) + parseFloat(employer_pf) + parseFloat(employer_pf);
	total_add_value = round_off_value(total_add_value);
	$('#net_salary'+offset).val(total_add_value);

}
function excel_report()
{
	var year = $('#year_filter1').val();
	var month = $('#month_filter1').val();
	var emp_id = $('#emp_id_filter1').val();
	if(year == ''){
		error_msg_alert("Select Year!");
		return false;
	}
	if(month == ''){
		error_msg_alert("Select Month!");
		return false;
	}
    window.location = 'report_reflect/emp_salary/excel_report.php?year='+year+'&month='+month+'&emp_id='+emp_id;
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>