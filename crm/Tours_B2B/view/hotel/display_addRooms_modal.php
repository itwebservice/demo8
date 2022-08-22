<?php
include '../../../model/model.php';
$final_arr = json_decode($_POST['final_arr'],true);
?>
<!-- ***** Add Room Modal ***** -->
<div class="modal fade c-modal" id="addRoom" role="dialog" aria-labelledby="addRoomLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addRoomLabel">ADD ROOMS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- ***** Room 1 Section ***** -->
            <div class="clearfix">
                <div class="row">

                <div class="col-12">
                    <!-- ***** Room Listing ***** -->
                    <div class="c-roomListing" id='roomListing'>

                    <div class="clearfix text-right m10-btm">
                        <a href="javascript:void(0);" class="c-customeBtn xs" id='addRooms' onClick='generate_rooms();'><i class="icon it itours-android-add-circle"></i>Add Room</a>
                    </div>
                    <!-- ***** Room 1 Section ***** -->
                    <?php
                    for($i=0;$i<sizeof($final_arr);$i++){
                        $roomNo = $final_arr[$i]['rooms']['room']; 
                    ?>
                    <div class="c-lineDiv" id='room-<?= $roomNo ?>'>
                    <span class="c-midHeading">Room <span id='roomcount-<?= $roomNo ?>'><?= $roomNo ?></span></span>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Adults</label>
                            <div class="selector">
                            <select class="full-width" id='room-<?= $roomNo ?>Adult'>
                                <option value='<?= $final_arr[$i]['rooms']['adults'] ?>'><?= $final_arr[$i]['rooms']['adults'] ?></option>
                                <?php
                                for($m=1;$m<=4;$m++){
                                    if($m != $final_arr[$i]['rooms']['adults']){
                                ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                                <?php } } ?>
                            </select>
                            </div>
                        </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Children</label>
                            <div class="selector">
                            <select class="full-width" id='room-<?= $roomNo ?>Child' onchange='generate_child_ages(this.id,"<?= $roomNo ?>");'>
                                <option value='<?php echo $final_arr[$i]['rooms']['child']; ?>'><?php echo $final_arr[$i]['rooms']['child']; ?></option>
                                <?php
                                for($m=0;$m<=2;$m++){
                                    if($m != $final_arr[$i]['rooms']['child']){
                                ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                                <?php } } ?>
                            </select>
                            </div>
                        </div>
                        </div>

                        <!-- *** Room 1 - Child Section *** -->
                        <div class="col-12 c-childSection">
                            <div class="row" id='childAge-<?= $roomNo ?>'>
                                <?php
                                for($k=0;$k<$final_arr[$i]['rooms']['child'];$k++){
                                    $child_age = $final_arr[$i]['rooms']['childAge'][$k];
                                    $child_id = $k + 1;
                                ?>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Child-<?= $child_id ?> Age</label>
                                        <div class="selector">
                                            <select class="full-width" id='child-<?= $roomNo.$k?>'>
                                                <option value='<?php echo $child_age; ?>'><?php echo $child_age; ?></option>
                                                <?php for($j=2;$j<12;$j++){
                                                    if($j != $child_age){ ?>
                                                    <option value='<?= $j ?>'><?= $j ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- *** Room 1 - Child Section End *** -->

                    </div>
                    </div>
                    <?php } ?>
                    <script>
                        $('#dynamic_room_count').val(<?= sizeof($final_arr) ?>);
                    </script>
                    <!-- ***** Room 1 Section End ***** -->

                    </div>
                    <!-- ***** Room Listing End ***** -->

                    <div id='roomListing1'>
                        <!-- Added Rooms -->
                    </div>
                    <div class="clearfix text-right">
                        <a href="javascript:void(0);" class="c-customeBtn xs" onClick='delete_rooms();' id='deleteRoom'><i class="icon it itours-android-remove-circle"></i>Remove Room</a>
                    </div>
                </div>
                </div>
            </div>
            <!-- ***** Room 1 Section End ***** -->
        </div>
        <div class="modal-footer">
            <button type="button" class='c-button colGrn' onclick='get_persons_count();'>Save</button>
        </div>
    </div>
</div>
</div>
<!-- ***** Add Room Modal End ***** -->
<script>
$('#addRoom').modal('show');
initilizeDropdown();
//appending modal background inside the blue div
$('.modal-backdrop').appendTo('.blue');   
    
//remove the padding right and modal-open class from the body tag which bootstrap adds when a modal is shown
$('body').removeClass("modal-open")
$('body').css("padding-right","");

var roomCount1 = $('#dynamic_room_count').val();
if(roomCount1==1)document.getElementById('deleteRoom').style.display = 'none';


//Calculate Total Pax 
function get_persons_count(){

    var dynamic_room_count = $('#dynamic_room_count').val();
    var total_pax = 0;
    var adult_count = 0;
    var child_count = 0;

    var final_arr = [];
    for (var i = 1; i <= dynamic_room_count; i++) {
        var room_count = $('#' + 'roomcount-' + i).html();
        var adult_count1 = $('#' + 'room-' + i + 'Adult').val();
        var child_count1 = $('#' + 'room-' + i + 'Child').val();

        var child_age_arr = [];
        for (var j = 0; j < child_count1; j++) {
            var child_age = $('#' + 'child-' + i + j).val();
            if (typeof child_age != 'undefined') {
                child_age_arr.push(parseInt(child_age));
            }
        }
        final_arr.push({
            rooms : {
                room     : parseInt(room_count),
                adults   : parseInt(adult_count1),
                child    : parseInt(child_count1),
                childAge : child_age_arr
            }
        });
        
        total_pax = parseFloat(total_pax) + parseFloat(adult_count1) + parseFloat(child_count1);
        adult_count = parseFloat(adult_count) + parseFloat(adult_count1);
        child_count = parseFloat(child_count) + parseFloat(child_count1);
    }
    // Store
    if(window.sessionStorage){
        try{
            sessionStorage.setItem("final_arr", JSON.stringify(final_arr));
        }
        catch(e){
            console.log(e);
        }
        
    }
    dynamic_room_count = (dynamic_room_count == 1)?dynamic_room_count+' Room':dynamic_room_count+' Rooms';
    $('#total_pax').html(total_pax);
    $('#room_count').html(dynamic_room_count);
    $('#adult_count').val(adult_count);
    $('#child_count').val(child_count);
    $('#addRoom').modal('hide');
}
</script>