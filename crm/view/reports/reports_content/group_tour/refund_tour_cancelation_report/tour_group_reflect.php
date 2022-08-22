<?php
include "../../../../../model/model.php";
$tour_id=$_GET['tour_id'];
?>
<option value=""> *Select Tour Date </option>

<?php
$sq=mysqlQuery("select * from tour_groups where tour_id='$tour_id' and status='Active'");
while($row=mysqli_fetch_assoc($sq))
{
     $group_id=$row['group_id'];
     $from_date=$row['from_date'];
     $to_date=$row['to_date'];

     $from_date = date("d-m-Y", strtotime($from_date));
     $to_date = date("d-m-Y", strtotime($to_date));

     echo "<option value='$group_id'>".$from_date." to ".$to_date."</option>";
}
?>
