<?php
include_once('../../../model/model.php');
$entry_id = $_POST['entry_id'];
if($entry_id != ""){

    $query = "select image_url from ferry_master where entry_id='$entry_id'";
    $row_image = mysqli_fetch_assoc(mysqlQuery($query));
    $image_url = explode(',',$row_image['image_url']);
    for($i = 0;$i < sizeof($image_url);$i++){

        $newUrl = preg_replace('/(\/+)/','/',$image_url[$i]);
        if($newUrl != ''){
        $download_url = BASE_URL.str_replace('../', '', $newUrl);
        ?>
        <div class="col-md-2">
            <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
                <img src="<?php echo $download_url; ?>" id="<?php echo $row_image['entry_id']; ?>" width="100%" height="100%">
                <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image(<?php echo $i; ?>,<?= $entry_id ?>)" title="Remove"><i class="fa fa-times" aria-hidden="true"></i></button></span>
            </div>
        </div>
        <?php
        }
    }
}
?>