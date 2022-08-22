<?php
include '../../model/model.php';
$type = $_POST['type'];
?>
<select class="form-control" title="Select Category" id="category" name="category" onchange="get_images(this.id)">
    <option value="">*Select Category</option>
    <?php
    $sq_count = mysqli_num_rows(mysqlQuery("select distinct(category) from flyer_categories where type='$type'"));
    if($sq_count >0 ){
        $query = mysqlQuery("select distinct(category) from flyer_categories where type='$type'");
        while($row = mysqli_fetch_assoc($query)){
        ?>
            <option value="<?= $row['category'] ?>"><?= $row['category'] ?></option>
        <?php
        }
    }
    ?>
</select>
<script>
$('#category').select2();
</script>