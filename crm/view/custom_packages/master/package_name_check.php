<?php
include "../../../model/model.php";
$package_name = $_POST['package_name'];
$tour_name_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where package_name='$package_name'"));
if($tour_name_count>0){
echo "This package name already exists.";
}
else{
echo '';
}