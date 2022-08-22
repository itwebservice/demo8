<?php 
include '../../../../../model/model.php';
$emp_id = $_POST['emp_id'];
$year = $_POST['year'];
$month = $_POST['month'];

//Validation employee salary for perticular month gets saved only once 
$sq_count  = mysqli_num_rows(mysqlQuery("select * from employee_salary_master where emp_id='$emp_id' and year='$year' and month='$month'"));
echo $sq_count;
?>