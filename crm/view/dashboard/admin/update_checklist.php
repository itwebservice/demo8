<?php 
include "../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
$aemp_id = $_POST['aemp_id'];

$booking_id = $_POST['booking_id'];
$tour_type = $_POST['tour_type'];
$new_array = array();
$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
if($tour_type=="Package Tour" || $tour_type=="B2C-Holiday"){
    if($tour_type=="Package Tour"){
        $sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$booking_id'"));
        $package_id = $sq_booking['package_id'];
        if($sq_booking['dest_id']=='0'){
            $sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id='$package_id'"));
            $dest_id = $sq_package['dest_id'];
        }else{
            $dest_id = $sq_booking['dest_id'];
        }
    }else{
        $sq_booking1 = mysqli_fetch_assoc(mysqlQuery("select enq_data from b2c_sale where booking_id='$booking_id'"));
        $enq_data = json_decode($sq_booking1['enq_data']);
        $package_id = $enq_data[0]->package_id;
        $sq_package = mysqli_fetch_assoc(mysqlQuery("select * from custom_package_master where package_id='$package_id'"));
        $dest_id = $sq_package['dest_id'];
    }
}
if($tour_type=="Group Tour" || $tour_type=="B2C-Group Tour"){
    $sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from  tourwise_traveler_details where id='$booking_id'"));
    $tour_id = $sq_booking['tour_id'];
    $sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from  tour_master where tour_id='$tour_id'"));
    $dest_id = $sq_tour['dest_id'];
}

if($tour_type=="Package Tour" || $tour_type=="Group Tour"||$tour_type=='B2C-Holiday'||$tour_type=='B2C-Group Tour'){
    
    if($tour_type=='B2C-Holiday'){
        $tour_type1 = 'Package Tour';
    }
    elseif($tour_type=='B2C-Group Tour'){
        $tour_type1 = 'Group Tour';
    }else{
        $tour_type1 = $tour_type;
    }

    $sq_entitiesc = mysqli_num_rows(mysqlQuery("select * from checklist_entities where entity_for='$tour_type1' and destination_name = '$dest_id'"));
}else{
    $sq_entitiesc = mysqli_num_rows(mysqlQuery("select * from checklist_entities where entity_for='$tour_type'"));
}
?>

<div class="modal fade profile_box_modal" id="view_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?= $tour_type.' Checklist' ?></h4>
        </div>
        <div class="modal-body profile_box_padding">
        <?php if($sq_entitiesc != 0){ ?>
        <form id="frm_emquiry_save">
        <input type="hidden" id="booking_id" name="booking_id" value="<?= $booking_id ?>">
        <input type="hidden" id="tour_type" name="tour_type" value="<?= $tour_type ?>">
            <div class="row mg_tp_10"><div class="table-responsive">
                <table class="table table-bordered" style="margin: 44px;width: 800px;">
                <thead>
                    <tr class="active table-heading-row">
                        <th></th>
                        <th>S_No.</th>
                        <th>To_Do</th>
                        <th>Assigned_To</th>
                    </tr>
                </thead>
                <tbody> 
                <?php
                    if($tour_type=="Package Tour" || $tour_type=="Group Tour" || $tour_type=='B2C-Holiday' || $tour_type=='B2C-Group Tour'){
                        
                        if($tour_type=='B2C-Holiday'){
                            $tour_type1 = 'Package Tour';
                        }
                        elseif($tour_type=='B2C-Group Tour'){
                            $tour_type1 = 'Group Tour';
                        }else{
                            $tour_type1 = $tour_type;
                        }
                        $sq_entities = mysqlQuery("select * from checklist_entities where entity_for='$tour_type1' and destination_name = '$dest_id'");
                    }else{
                        $sq_entities = mysqlQuery("select * from checklist_entities where entity_for='$tour_type'");
                    }
                    while($row_entity = mysqli_fetch_assoc($sq_entities))
                    { 
                        $sql=mysqlQuery("select * from to_do_entries where entity_id='$row_entity[entity_id]'");
                        $count = 0;
                            while($sq_todo_list=mysqli_fetch_assoc($sql))
                            {
                                $count++;

                                $sql_entry = mysqli_fetch_assoc(mysqlQuery("select * from checklist_package_tour where booking_id='$booking_id' and tour_type='$tour_type' and entity_id='$sq_todo_list[id]'"));
                            
                                $sq_chk_count = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$booking_id' and entity_id='$sq_todo_list[id]' "));
                                
                                $chk_status = ($sq_chk_count==1) ? "checked" : "";
                                
                                $sq_chk_count1 = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where booking_id='$booking_id' and entity_id='$sq_todo_list[id]' and status='Completed'"));
                                $bg = ($sq_chk_count1==1) ? "success" : "";
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td>
                                        <input type="checkbox" id="chk_package_tour_checklist_<?= $count ?>" name="chk_package_tour_checklist" <?= $chk_status ?> data-entity-id="<?= $sq_todo_list['id'] ?>" >
                                    </td>
                                    <td><?= $count ?></td>
                                    <td><?= $sq_todo_list['entity_name'] ?></td>
                                    <td><select name="assigned_emp_id<?= $sq_todo_list['id'] ?>" id="assigned_emp_id<?= $sq_todo_list['id'] ?>" title="Allocate To" style="width:100%">
                                        <?php
                                            $sql_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$aemp_id'"));     
                                        ?>
                                        <option value="<?= $aemp_id ?>"><?= ($sql_emp['first_name']=='') ? 'Admin
                                        ' : $sql_emp['first_name'].' '.$sql_emp['last_name'] ?></option>
                                        </select></td>
                                        <td class="hidden"><select name="status<?= $sq_todo_list['id'] ?>" id="status<?= $sq_todo_list['id'] ?>" title="Status" style="width:100%">
                                        <?php if($sql_entry['status']!=''){ ?>
                                        <option value="<?= $sql_entry['status'] ?>"><?= $sql_entry['status'] ?></option>
                                        <option value="Not Updated">Not Updated</option>
                                        <option value="Completed">Completed</option>
                                    <?php }else{ ?>
                                        <option value="Not Updated">Not Updated</option>
                                        <option value="Completed">Completed</option>
                                    <?php } ?>
                                    </select></td>
                                        <td class="hidden"><input type="hidden" id="entry_id<?= $sq_todo_list['id'] ?>" name="entry_id<?= $sq_todo_list['id'] ?>" value="<?= $sql_entry['id'] ?>"></td>
                                </tr>
                                <?php 
                            }
                        }
                        ?> 
                </tbody>		
            </table>
            </div></div>
            <div class="row text-center mg_tp_20">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-success" ><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
                </div>
            </div>
        </form>
        <?php }else{
            echo '<h4>No checklist added!</h4>';
        } ?>
        <div>
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#view_modal').modal('show');

$(function(){
$('#frm_emquiry_save').validate({
    rules:{
        draft : { draft : true },
    },
    submitHandler:function(form){

    var booking_id = $('#booking_id').val();
    var branch_admin_id = $('#branch_admin_id1').val();
    var tour_type = $('#tour_type').val();
    var entity_id_arr = new Array();
    var assigned_emp_arr = new Array();
    var ass_emp_id_arr = new Array();
    var entry_id_arr = new Array();
    var status_arr = new Array();
    var check_id_arr = new Array();
    var count=1;
    $('input[name="chk_package_tour_checklist"]:checked').each(function(){
        var entity_id = $(this).attr('data-entity-id');
        var emp_id = $('#assigned_emp_id'+entity_id).val();
        var status = $('#status'+entity_id).val();
        var entry_id = $('#entry_id'+entity_id).val();
        ass_emp_id_arr.push(emp_id);
        status_arr.push(status);
        entry_id_arr.push(entry_id);
        entity_id_arr.push(entity_id);
        check_id_arr.push('1');
    });
    if(entity_id_arr.length == 0){ error_msg_alert('Atleast select one entity'); return false; }
    $('input[name="chk_package_tour_checklist"]:not(:checked)').each(function(){
        var entity_id = $(this).attr('data-entity-id');
        var emp_id = $('#assigned_emp_id'+entity_id).val();
        var status = $('#status'+entity_id).val();
        var entry_id = $('#entry_id'+entity_id).val();
        ass_emp_id_arr.push(emp_id);
        status_arr.push(status);
        entry_id_arr.push(entry_id);
        entity_id_arr.push(entity_id);
        check_id_arr.push('0');
    });
    var base_url = $('#base_url').val();

    $.ajax({
        type:'post',
        url: base_url+'controller/checklist/tour_checklist_save.php', 
        data:{ booking_id:booking_id,branch_admin_id:branch_admin_id,entity_id_arr:entity_id_arr,tour_type:tour_type,ass_emp_id_arr:ass_emp_id_arr,entry_id_arr:entry_id_arr,status_arr:status_arr,check_id_arr:check_id_arr },
        success:function(result){
            msg_alert(result);
            $('#btn_form_send').button('reset'); 
            $('#view_modal').modal('hide'); 
            followup_reflect(); 
        }
    });
    }
});
});
</script>