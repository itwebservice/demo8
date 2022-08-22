<?php include "../../../../../../model/model.php";

$month = $_POST['month'];
$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from employee_salary_master where 1 ";
if($month != ''){
	$query .= " and month='$month'";
}
if($branch_status=='yes'){
	if($role=='Admin'){ }
	else if($role=='Branch Admin' || $role=='HR' || $role=='Accountant'){
		$query .= " and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
	}
	else{
    	$query .= " and emp_id='$emp_id'";
    }
}
$sq_query = mysqlQuery($query);

$count = 1;
while($row_query = mysqli_fetch_assoc($sq_query))
{
	$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row_query[emp_id]'"));

	$temp_arr = array( "data" => array(
	(int)($count++),
	$row_query['year'],
	$row_query['emp_id'],
	$sq_emp['first_name'].' '.$sq_emp['last_name'] ,
	$row_query['employer_pf'] ,
	$row_query['employee_pf'],
	number_format($row_query['employee_pf'] + $row_query['employer_pf'],2) 

	), "bg" =>$bg);
	array_push($array_s,$temp_arr);	
	
}
echo json_encode($array_s);
?>	 	
