<?php
include '../../../../model/model.php';
$noOfChild = $_POST['noOfChild'];
$roomCount = $_POST['roomCount'];
for($i=0;$i<$noOfChild;$i++){
?>
    <div class="col">
        <div class="form-group">
        <label>Child-<?= ($i+1) ?> Age</label>
        <div class="selector">
            <select class="full-width" id='child-<?= $roomCount.$i?>'>
                <?php for($j=2;$j<12;$j++){ ?>
                    <option value='<?= $j ?>'><?= $j ?></option>
                <?php } ?>
            </select>
        </div>
        </div>
    </div>
<?php } ?>
<script> initilizeDropdown();</script>