<?php
include '../../model/model.php';
$sq_emp_count = mysqli_num_rows(mysqlQuery("select * from emp_master"));
echo $sq_emp_count;
?>