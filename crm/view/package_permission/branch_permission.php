<?php
include '../../model/model.php';
$sq_branch_count = mysqli_num_rows(mysqlQuery("select * from branches"));
echo $sq_branch_count;
?>