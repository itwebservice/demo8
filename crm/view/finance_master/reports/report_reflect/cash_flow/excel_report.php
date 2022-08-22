<?php
include "../../../../../model/model.php";
$from_date = $_POST['from_date'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];

$sq_fin = mysqli_fetch_assoc(mysqlQuery("select from_date,to_date from financial_year where financial_year_id='$financial_year_id'"));
if($from_date != ''){
	$to_date1 = get_date_db($from_date);
	$flag = ($to_date1 >= $sq_fin['from_date'] && $to_date1 <= $sq_fin['to_date']) ? 1 : 0;
}
else{
	
	$flag = 1;
}
if($flag == 1){
$url = BASE_URL."model/app_settings/print_html/finance_reports/cash_flow_report.php?from_date=$from_date&financial_year_id=$financial_year_id&branch_admin_id=$branch_admin_id";
?>
<script type="text/javascript">
  loadOtherPage('<?= $url ?>');
</script>
<?php }
else{
	echo '0';
} ?>