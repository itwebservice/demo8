<?php
include '../../model/model.php';
$cat = $_POST['cat'];
$sq_count = mysqli_num_rows(mysqlQuery("select distinct(image_url) from flyer_categories where category='$cat'"));

if($sq_count >0 ){
    ?>
    <?php
    $query = mysqlQuery("select distinct(image_url) from flyer_categories where category='$cat'");
    $count = 0;
    while($row_gallary = mysqli_fetch_assoc($query)){
        
        $count++;
        $url = $row_gallary['image_url'];
        $pos = strstr($url,'uploads');
        $entry_id =$row_gallary['entry_id'];
        $sq_gal =  mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id = '$entry_id'"));
        if ($pos != false)   {
            $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 
            $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
        }
        else{
            $newUrl =  $row_gallary['image_url']; 
        }
    ?>
        <div class="gallary-image">
            <div class="col-sm-3">
                <div class="gallary-single-image mg_bt_30 mg_bt_10_sm_xs" style="width: 100%;">
                    <img src="<?php echo $newUrl; ?>" id="image<?php echo $count; ?>" alt="title" class="img-responsive">
                    <ul>
                        <li><a class="btn btn-sm" onclick="download_image('<?php echo $newUrl; ?>');" title="Download Background Image"><i class="fa fa-download" type="button"></i></a></li>
                    </ul>
                    <!-- <a href="<?= $newUrl ?>" download>
                        <img src="<?php echo $newUrl; ?>" id="image<?php echo $count; ?>" alt="title" class="img-responsive">
                    </a> -->

                <!-- <img src="<?php echo $newUrl; ?>" id="image<?php echo $count; ?>" alt="title" class="img-responsive"> -->
                <!-- <div class="table-image-btns">

                    <ul>

                    
                    <li><a class="btn btn-info btn-sm" href="<?= $newUrl ?>" download data-toggle="tooltip" title="Download Invoice"><i class="fa fa-download"></i></a></li> -->
                    </ul>

                <!-- </div>  -->
            </div>

            </div>
        </div> 
    <?php
    }
}
?>