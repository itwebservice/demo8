<?php
class vehicle_master{

    function vehicle_save(){
        $vehicle_type = $_POST['vehicle_type'];
        $vehicle_name = addslashes($_POST['vehicle_name']);
        $seating_c = $_POST['seating_c'];

        $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from b2b_transfer_master where vehicle_name='$vehicle_name' and vehicle_type='$vehicle_type'"));
        if($sq_count > 0){
            echo 'error--Vehicle name already added';
            exit;
        }
        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from b2b_transfer_master"));
        $entry_id = $sq_max['max'] + 1;
        $sq_query = mysqlQuery("INSERT INTO `b2b_transfer_master`(`entry_id`,`vehicle_type`,`vehicle_name`, `seating_capacity`,`image_url`, `cancellation_policy`, `status`) VALUES ('$entry_id','$vehicle_type','$vehicle_name','$seating_capacity','','','Active')");
        if($sq_query){
            echo "<option value=".$entry_id.">$vehicle_name</option>";
            exit;
        }else{
            echo 'error--Vehicle Details not added succesfully';
            exit;
        }

    }
}
?>