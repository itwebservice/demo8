<?php
include '../../../../model/model.php';
$hotel_ids = $_POST['hotel_id_arr'];
$hotel_ids = ($hotel_ids != '') ? $hotel_ids : [];
$flag = 0;
for($i = 0;$i < sizeof($hotel_ids); $i++){

    $sq = mysqlQuery("select state_id from hotel_master where hotel_id='$hotel_ids[$i]'");
    while($row = mysqli_fetch_assoc($sq)){
        if($row['state_id'] == '1'){
            $flag = 1;
            echo $flag;
            exit;
        }
    }
}
echo $flag;
?>