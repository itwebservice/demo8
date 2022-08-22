<?php
global $transaction_master;
$transaction_master = new transaction_master;
class transaction_master{

	public function transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status,$row_spec, $branch_admin_id,$ledger_particular)
	{
		$financial_year_id = $_SESSION['financial_year_id'];
		$role = $_SESSION['role'];
		$sq_date = mysqli_fetch_assoc(mysqlQuery("select * from financial_year where financial_year_id='$financial_year_id'"));
		$created_at = $sq_date['to_date'];
		if($branch_admin_id!=0 && $role!='Admin'){
			$q = "select * from finance_transaction_master where module_name='Profit & Loss A/c' and module_entry_id='1' and gl_id='165' and financial_year_id='$financial_year_id' and branch_admin_id ='$branch_admin_id'";
			$sq_fin_count = mysqli_num_rows(mysqlQuery($q));

			if($sq_fin_count == '0')
			{
				$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(finance_transaction_id) as max from finance_transaction_master"));
				$finance_transaction_id = $sq_max['max'] + 1;

				$sq_transaction = mysqlQuery("insert into finance_transaction_master (finance_transaction_id, financial_year_id, branch_admin_id, module_name, module_entry_id, transaction_id, payment_amount, payment_date, payment_particular, gl_id, payment_side, clearance_status, created_at,row_specification,ledger_particular) values ('$finance_transaction_id', '$financial_year_id', '$branch_admin_id', '$module_name', '$module_entry_id', '$transaction_id', '$payment_amount', '$payment_date', '$payment_particular', '$gl_id', '$payment_side', '$clearance_status', '$created_at','$row_spec','$ledger_particular')");

				if(!$sq_transaction){
					$GLOBALS['flag'] = false;
					echo "error--Transaction entry not added!";
				}

			}
			else
			{
				$sq_transaction = mysqlQuery("update finance_transaction_master set financial_year_id='$financial_year_id', transaction_id='$transaction_id', payment_amount='$payment_amount', payment_date='$payment_date', payment_particular='$payment_particular', gl_id='$gl_id', clearance_status='$clearance_status', payment_side='$payment_side',row_specification = '$row_spec', ledger_particular = '$ledger_particular' where module_name='Profit & Loss A/c' and module_entry_id='1' and gl_id='165' and financial_year_id='$financial_year_id' and branch_admin_id='$branch_admin_id'");
				if(!$sq_transaction){
					$GLOBALS['flag'] = false;
					echo "error--Transaction not updated!";
				}
			}
		}

	}

}
?>