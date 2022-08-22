<?php
include '../../model/model.php';
$query = mysqlQuery("SELECT * FROM `b2c_testimonials` where 1");
$sq_count = mysqli_num_rows(mysqlQuery("SELECT * FROM `b2c_testimonials` where 1"));
?>
<form id="section_ctm">
    <legend>Define Customer Testimonials</legend>
    <div class="row"> 
        <div class="col-md-4"> <label class="alert-danger">For saving testimonial keep checkbox selected!</label> </div>
        <div class="col-md-8 text-right">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_customer_tm')" title="Add Row"><i class="fa fa-plus"></i></button>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-12">
    <table id="tbl_customer_tm" name="tbl_customer_tm" class="table border_0 table-hover no-marg">
        <?php
        if($sq_count == 0){ ?>
            <tr>
                <td><input id="chk_ctm" type="checkbox" checked></td>
                <td><input maxlength="10" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" style="width:50px" disabled /></td>
                <td><input type="text" name="name" title="Customer Name" placeholder="*Customer Name" class="form-control"/></td>
                <td><input type="text" name="designation" placeholder="Designation" title="Designation" class="form-control" /></td>
                <td><textarea name="testm" placeholder="*Testimonial(Upto 1000 chars)" title="Testimonial" class="form-control" id="testm" onchange="validate_char_size('testm',1000);" ></textarea></td>
                <td><input type="hidden" name="entry_id" id="entry_id" value="" /></td>
            </tr>
        <?php
        }else{
            $i = 1;
            while($row = mysqli_fetch_assoc($query)){
                ?>
                <tr>
                    <td><input id="chk_city<?= ($i) ?>" type="checkbox" checked></td>
                    <td><input maxlength="15" value="<?= ($i) ?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                    <td><input type="text" name="name<?= ($i) ?>" title="Customer Name" placeholder="*Customer Name" class="form-control" id="name<?= ($i) ?>" value="<?=$row['name'] ?>"/></td>
                    <td><input type="text" name="designation<?= ($i) ?>" placeholder="Designation" title="Designation" class="form-control" id="designation<?= ($i) ?>" value="<?=$row['designation'] ?>" /></td>
                    <td><textarea name="testm" placeholder="*Testimonial(Upto 1000 chars)" title="Testimonial" id="testm<?= ($i) ?>" class="form-control" onchange="validate_char_size(this.id,1000);" ><?=$row['testm'] ?></textarea></td>
                    <td><input type="hidden" name="entry_id<?= ($i) ?>" id="entry_id<?= ($i) ?>" value="<?=$row['entry_id'] ?>" /></td>
                </tr>
            <?php 
                $i++; }
        }?>
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

$(function(){
$('#section_ctm').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = [];
    var table = document.getElementById("tbl_customer_tm");
    var rowCount = table.rows.length;
    var count = 0;
    for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        if(row.cells[0].childNodes[0].checked) count++;
    }
    if(parseInt(count)>10){
        error_msg_alert("Can not enter more than 10 customers!"); return false;
    }
    for(var i=0; i<rowCount; i++){

        var row = table.rows[i];
        var entry_id = '';
        var name = row.cells[2].childNodes[0].value;
        var designation = row.cells[3].childNodes[0].value;
        var testm = row.cells[4].childNodes[0].value;
        if(row.cells[5]){
            entry_id = row.cells[5].childNodes[0].value;
        }
        var status = row.cells[0].childNodes[0].checked;
        if(row.cells[0].childNodes[0].checked){
            if(name==""){ error_msg_alert("Enter customer name at row "+(i+1)); return false; }
            if(testm==""){ error_msg_alert("Enter testimonial "+(i+1)); return false;}
            
            var flag1 = validate_char_size(row.cells[4].childNodes[0].id,1000);
            if(!flag1){
                return false;
            }
        }
        images_array.push({
            'name':name,
            'designation':designation,
            'testm':testm,
            'entry_id':entry_id,
            'status':status
        });
    }
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '8', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('8');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>