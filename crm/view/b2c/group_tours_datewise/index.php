<?php
include '../../../model/model.php';
$query = mysqli_fetch_assoc(mysqlQuery("SELECT git_tours FROM `b2c_settings` where setting_id='1'"));
$git_tours = ($query['git_tours']!='' && $query['git_tours']!='null') ? json_decode($query['git_tours']): [];
?>
<form id="section_package">
    <legend>Active & Inactive Group Tours</legend>
    <div class="row"> 
        <div class="col-md-5"> <label class="alert-danger">For saving group tour keep checkbox selected!</label> </div>
        <div class="col-md-7 text-right">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_grp_packages_datewise')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_grp_packages_datewise');" title="Delete Row"><i class="fa fa-trash"></i></button>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-12">
    <table id="tbl_grp_packages_datewise" name="tbl_grp_packages_datewise" class="table border_0 table-hover">
        <?php
        if(sizeof($git_tours) == 0){ ?>
        <tr>
            <td><input id="chk_dest1" type="checkbox" checked></td>
            <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select style="width:100%;" class="form-control" id="cmb_tour_name-1" name="cmb_tour_name-1" onchange="tour_groups_reflect(this.id);" title="Tour Name"> 
                <option value="">Tour Name </option>
                <?php
                    $sq=mysqlQuery("select tour_id,tour_name from tour_master order by tour_name");
                    while($row=mysqli_fetch_assoc($sq)){
                        echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }
                ?>
            </select></td>
            <td><select class="form-control" id="cmb_tour_group-1" Title="Tour Date" name="cmb_tour_group"> 
                    <option value="">*Tour Date</option>        
                </select></td>
            <td><select class="form-contorl" class="form-control" name="validity" id="validity-1" title="Select Status" onchange="check_validity(this.id)">
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select></td>
            <script>
                $('#dest_name-1').select2();
                $('#from_date-1,#to_date-1').datetimepicker({ timepicker:false, format:'d-m-Y' });
            </script>
        </tr>
        <?php
        }
        else{
        for($i=0;$i<sizeof($git_tours);$i++){

            $tour_id=$git_tours[$i]->tour_id;
            $sq_dest = mysqli_fetch_assoc(mysqlQuery("select tour_id,tour_name from tour_master where tour_id='$tour_id'"));
            $package_id=$git_tours[$i]->package_id;
            $disabled = ($git_tours[$i]->validity != 'Period') ? 'readonly' : '';
        ?>
        <tr>
            <td><input id="chk_dest1<?=$i?>_u" type="checkbox" checked></td>
            <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select style="width:100%;" class="form-control" id="cmb_tour_name-1<?=$i?>_u" name="cmb_tour_name-1<?=$i?>_u" onchange="tour_groups_reflect(this.id);" title="Tour Name">
                <option value='<?= $sq_dest['tour_id']?>'><?= $sq_dest['tour_name'] ?></option>
                <option value="">Tour Name </option>
                <?php
                    $sq=mysqlQuery("select tour_id,tour_name from tour_master order by tour_name");
                    while($row=mysqli_fetch_assoc($sq)){
                        echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                    }
                ?>
            </select></td>
            <td><select class="form-control" id="cmb_tour_group-1<?=$i?>_u" Title="Tour Date" name="cmb_tour_group-1<?=$i?>_u">
                    <?php
                    $tour_id = $git_tours[$i]->tour_id;
                    $sq = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where tour_id='$tour_id'"));
                    $from_date = $sq['from_date'];
                    $to_date = $sq['to_date'];
                    $group_id = $sq['group_id'];

                    $from_date = date("d-m-Y", strtotime($from_date));
                    $to_date = date("d-m-Y", strtotime($to_date));
                    echo "<option value='$group_id'>".$from_date." to ".$to_date."</option>"; ?>
                    <option value="">*Tour Date</option>
                    <?php
                    $sq=mysqlQuery("select * from tour_groups where tour_id='$tour_id'");
                    while($row=mysqli_fetch_assoc($sq)){
                        $group_id=$row['group_id'];
                        $from_date=$row['from_date'];
                        $to_date=$row['to_date'];

                        $from_date = date("d-m-Y", strtotime($from_date));
                        $to_date = date("d-m-Y", strtotime($to_date));

                        echo "<option value='$group_id'>".$from_date." to ".$to_date."</option>";
                    }
                    ?>
                </select></td>
            <td><select class="form-contorl" name="validity" id="validity-1<?=$i?>_u" title="Select Status">
                    <option value="<?= $git_tours[$i]->validity ?>"><?= $git_tours[$i]->validity ?></option>
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select></td>
        </tr>
        <script>
        $('#dest_name-1<?=$i?>_u').select2();
        $('#from_date-1<?=$i?>_u,#to_date-1<?=$i?>_u').datetimepicker({ timepicker:false, format:'d-m-Y' });
        </script>
        <?php } } ?>
    </table>
    </div> </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>

function check_validity(id){
    var id1 = $('#'+id).val();
    var offset = id.split('-');
    if(id1 === "Permanent"){
        $('#from_date-'+offset[1]).attr({ 'disabled': 'disabled' });
        $('#to_date-'+offset[1]).attr({ 'disabled': 'disabled' });
        $('#from_date-'+offset[1]).val('');
        $('#to_date-'+offset[1]).val('');
    }
    else{
        $('#from_date-'+offset[1]).removeAttr('readonly');
        $('#to_date-'+offset[1]).removeAttr('readonly');
        $('#from_date-'+offset[1]).removeAttr('disabled');
        $('#to_date-'+offset[1]).removeAttr('disabled');
    }
}

function tour_groups_reflect(cmb_tour_name){

    var tour_id = $("#"+cmb_tour_name).val(); 
    var offset = cmb_tour_name.split('-');
    $.get( "group_tours_datewise/tour_groups_reflect.php" , { tour_id : tour_id } , function ( data ) {
        $ ("#cmb_tour_group-"+offset[1]).html(data);
    });
}
//Pacakges load
function package_dynamic_reflect(dest_name){
    var offset = dest_name.split('-');
	var dest_id = $("#"+dest_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: 'package_tours/get_packages.php', 
		data: { dest_id : dest_id}, 
		success: function(result){
			$('#package-'+offset[1]).html(result);
		}
	});
}
$(function(){
$('#section_package').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_grp_packages_datewise");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
        
        var row = table.rows[i];
        var destination = row.cells[2].childNodes[0].value;
        var tour_date = row.cells[3].childNodes[0].value;
        var validity = row.cells[4].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){

            if(destination==""){ error_msg_alert("Select destination at row "+(i+1)); return false; }
            if(tour_date==""){ error_msg_alert("Select tour date at row "+(i+1)); return false; }
            if(validity==""){ error_msg_alert("Select validity at row "+(i+1)); return false; }

            images_array.push({          
                'tour_id':destination,
                'tour_date':tour_date,
                'validity':validity
            });
        }
    }

    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '12', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('12');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>