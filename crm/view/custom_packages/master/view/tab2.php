<?php
if($sq_pckg['dest_image']!='0'){
    $row_gallary = mysqli_fetch_assoc(mysqlQuery("select * from gallary_master where entry_id = '$sq_pckg[dest_image]'"));
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
    if($newUrl!=''){
    ?>
    <div class="item">
        <img src="<?= $newUrl ?>" class="img-resposive">
    </div>
    <?php }
    else{
        echo '<h3>Not Selected</h3>';
    } ?>
<?php
}
else{
    echo '<h3>Not Selected</h3>';
} ?>