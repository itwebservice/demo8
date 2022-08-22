<?php
include_once '../../model/model.php';
$sq_query = mysqlQuery("select dest_name,dest_id from destination_master");

echo '<select id="dest_id" name="dest_id" class="form-control">';
echo '<option value="">*Select Destination</option>';
while($row_query = mysqli_fetch_assoc($sq_query)){
    echo '<option value='.$row_query['dest_id'].'>'.$row_query['dest_name'].'</option>';
}
echo '</select>';
?>
<script>
    $('#dest_id').select2();
</script>