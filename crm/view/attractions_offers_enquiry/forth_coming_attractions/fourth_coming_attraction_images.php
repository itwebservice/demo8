<?php
include "../../../model/model.php";
$fourth_id = $_POST['fourth_id'];
?>
		<div class="row mg_bt_10">
        <?php
        $sq_img = mysqlQuery("select * from fourth_coming_att_images where fourth_id='$fourth_id'");
        while($row_img = mysqli_fetch_assoc($sq_img))
        {
            $newUrl = $row_img['upload'];
            if($newUrl!=""){
                $newUrl = preg_replace('/(\/+)/','/',$row_img['upload']); 
                $newUrl_arr = explode('uploads/', $newUrl);
                $newUrl = BASE_URL.'uploads/'.$newUrl_arr[1];   
            } 
            if($newUrl != ''){
                ?>
                <div class="col-md-2">
                    <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
                        <img src="<?php echo $newUrl; ?>" id="<?php echo $row_img['attr_id']; ?>" width="100%" height="100%">
                        <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image(<?php echo $row_img['attr_id']; ?>,<?php echo $fourth_id; ?>)" title="Remove"><i class="fa fa-times" aria-hidden="true"></i></button></span>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    