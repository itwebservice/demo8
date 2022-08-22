<?php 
include "../../../../model/model.php";

$query = "select * from site_seeing_master where 1 ";
$sq_site = mysqlQuery($query);
while($row_site = mysqli_fetch_assoc($sq_site)){

    $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_site[city_id]'"));
    ?>
    <li data-city-id="<?= $row_site['city_id'] ?>" class="list-group-item"><?= $row_site['site_seeing'] ?></li>
    <?php
}
?>
<script>
$('#ul_site_seeing_list li').each(function(){
    $(this).draggable({
        helper: "clone",
        cursor: 'move'
    });
});
</script>