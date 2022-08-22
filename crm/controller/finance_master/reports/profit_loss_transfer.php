<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/reports/profit_loss_transfer.php');

$total_purchase1 = $_POST['total_purchase1'];
$profit_loss = $_POST['profit_loss'];
$today_date = $_POST['today_date'];
$branch_admin_id = $_POST['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$sq_fy = mysqli_fetch_assoc(mysqlQuery("select from_date from financial_year where financial_year_id='$financial_year_id'"));
$year = explode('-',$sq_fy['from_date']);

$sq_branch = mysqli_fetch_assoc(mysqlQuery("select branch_name from branches where branch_id='$branch_admin_id'"));
$sq_branch['branch_name'];
$branch_name = $sq_branch['branch_name'];
$save_master = new transaction_master;
$save_master->transaction_save('Profit & Loss A/c','1','',$total_purchase1,$today_date,'Being Profit Loss transferred to Capital for the branch '.$branch_name.'('.$year[0].')','165',$profit_loss,'','',$branch_admin_id,'');
?>