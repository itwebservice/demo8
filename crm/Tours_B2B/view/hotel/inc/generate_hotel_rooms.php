<?php
include '../../../../model/model.php';
$roomCount = $_POST['roomCount'];
$roomCount = $roomCount + 1;
?>
    <!-- ***** Room N Section ***** -->
    <div class="c-lineDiv" id='room-<?= $roomCount ?>'>
    <span class="c-midHeading">Room <span id='roomcount-<?= $roomCount ?>'><?= $roomCount ?></span></span>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Adults</label>
            <div class="selector">
            <select class="full-width" id='room-<?= $roomCount ?>Adult'>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            </div>
        </div>
        </div>

        <div class="col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label>Children</label>
            <div class="selector">
            <select class="full-width" id='room-<?= $roomCount ?>Child' onchange='generate_child_ages(this.id,"<?= $roomCount ?>");'>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            </div>
        </div>
        </div>

        <!-- *** Room N - Child Section *** -->
        <div class="col-12 c-childSection">
            <div class="row" id='childAge-<?= $roomCount ?>'>
                
            </div>
        </div>
        <!-- *** Room N - Child Section End *** -->

    </div>
    </div>
    <!-- ***** Room N Section End ***** -->
<script> initilizeDropdown();</script>