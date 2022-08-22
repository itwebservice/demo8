<?php
include "../../../../model/model.php";
$dest_id = $_POST['dest_id'];
if($dest_id != '') { 
      $query = " select * from gallary_master where dest_id = '$dest_id'";
}
?>
<option value="">Select Image</option>
<?php
$count = 0;
$sq_gallary = mysqlQuery($query);
while($row_gallary = mysqli_fetch_assoc($sq_gallary)){
    $url = $row_gallary['image_url'];
    $pos = strstr($url,'uploads');
    $entry_id =$row_gallary['entry_id'];
    if ($pos != false)   {
        $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 
        $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
    }
    else{
        $newUrl =  $row_gallary['image_url']; 
    }
    $image_url = explode('/',$newUrl);
    $count = sizeof($image_url)-1;
?>
<option value="<?=$entry_id?>"><?=$image_url[$count]?></option>
<?php } ?>