<?php
include "../../../model/model.php"; ?>
<option value="">Select Branch Name</option>
<?php 
$location_id=$_GET['location_id'];

$query = "select distinct(branch_id) from emp_master where 1 ";

if($location_id != ''){
 $query .= " and location_id = '$location_id'";
}
$sq = mysqlQuery($query);
while($row=mysqli_fetch_assoc($sq))
{
     $sq_branch = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id = '$row[branch_id]'")); 	

     echo "<option value='$sq_branch[branch_id]'>".$sq_branch['branch_name']."</option>";
}