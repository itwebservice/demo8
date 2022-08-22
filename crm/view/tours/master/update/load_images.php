<?php
include '../../../../model/model.php';
$tour_id = $_POST['tour_id'];

$day_url1 = explode(',',$image_url);
$sq_package_program = mysqlQuery("select * from  group_tour_program where tour_id='$tour_id'");

?>
<h4>Uploaded Images</h4><hr>
<?php
$num_days = 1;
while($rows = mysqli_fetch_assoc($sq_package_program)){
    if($rows['daywise_images'] != ""){
        $daywise_image = $rows['daywise_images'];
        $pos = strstr($daywise_image,'uploads');
        if ($pos != false){
            $newUrl1 = preg_replace('/(\/+)/','/',$daywise_image); 
            $daywise_image = BASE_URL.str_replace('../', '', $newUrl1);
        }
    }
    else{
        $daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
    }
?>
<div class="col-md-2">
        <div class="gallary-single-image mg_bt_10" style="height:100px;max-height: 100px;overflow:hidden;">
            <img src="<?= $daywise_image ?>" id="<?= $num_days ?>" width="100%" height="100%">
            <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image('<?= $rows['entry_id'] ?>', '<?= $tour_id ?>')" title="Remove Image"><i class="fa fa-times" aria-hidden="true"></i></button></span>
        </div>
        <h5 class="text-center no-pad">Day-<?= $num_days ?></h5>
        </div>
<?php
$num_days++;
}
?>