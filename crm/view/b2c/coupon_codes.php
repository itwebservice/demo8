<?php
include '../../model/model.php';
$query = mysqli_fetch_assoc(mysqlQuery("SELECT coupon_codes FROM `b2c_settings` where setting_id='1'"));
$coupon_codes = ($query['coupon_codes']!='' && $query['coupon_codes']!='null') ? json_decode($query['coupon_codes']): [];
?>
<form id="section_hotels">
    <legend>Define Coupon codes</legend>
    <div class="row"> 
        <div class="col-md-4"> <label class="alert-danger">For saving coupon keep checkbox selected!</label> </div>
        <div class="col-md-8 text-right">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_coupons')" title="Add Row"><i class="fa fa-plus"></i></button>
        <button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_coupons');" title="Delete Row"><i class="fa fa-trash"></i></button>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-12"><div class="table-responsive">
    <table id="tbl_coupons" name="tbl_coupons" class="table border_0 table-hover" style="width:1000px;">
        <?php
        if(sizeof($coupon_codes) == 0){?>
            <tr>
                <td><input id="chk_coupon1" type="checkbox" checked></td>
                <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><input type="text" id="title" name="title" class="form-control" placeholder="*Title" title="Title"/></td>
                <td><input type="text" id="coupon_code-1" name="coupon_code-1" placeholder="*Coupon Code" title="Coupon Code" class="form-control"/></td>
                <td><select name="amount_in-1" id="amount_in-1" title="Amount In" class="form-control" style="width:150px" class="form-control">
                    <option value="">*Amount In</option>
                    <option value="Percentage">Percentage</option>
                    <option value="Flat">Flat</option>
                </select></td>
                <td><input type="number" id="amount-1" name="amount-1" class="form-control" placeholder="*Amount" title="Amount"/></td>
                <td><input type="text" id="valid_date-1" name="valid_date-1" class="form-control" placeholder="*Valid date" title="Valid date"/></td>
            </tr>
            <script>
                $('#valid_date-1').datetimepicker({ timepicker:false, format:'d-m-Y',minDate: new Date() });
            </script>
        <?php
        }else{
            
            for($i=0;$i<sizeof($coupon_codes);$i++){
            ?>
            <tr>
                <td><input id="chk_coupon1<?=$i?>_u" type="checkbox" checked></td>
                <td><input maxlength="15" value="<?=($i+1)?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><input type="text" id="title" name="title" class="form-control" placeholder="*Title" title="Title" value="<?=$coupon_codes[$i]->title?>"/></td>
                <td><input type="text" id="coupon_code-1<?=$i?>_u" name="coupon_code-1" placeholder="*Coupon Code" class="form-control" value="<?=$coupon_codes[$i]->coupon_code?>" title="Coupon Code"/></td>
                <td><select name="amount_in-1" id="amount_in-1<?=$i?>_u" title="Amount In" class="form-control" style="width:150px" class="form-control">
                    <option value="<?=$coupon_codes[$i]->amount_in?>"><?=$coupon_codes[$i]->amount_in?></option>
                    <option value="">*Amount In</option>
                    <option value="Percentage">Percentage</option>
                    <option value="Flat">Flat</option>
                </select></td>
                <td><input type="number" id="amount-1<?=$i?>_u" name="amount-1" class="form-control" placeholder="*Amount" title="Amount" value="<?=$coupon_codes[$i]->amount?>"/></td>
                <td><input type="text" id="valid_date-1<?=$i?>_u" name="valid_date-1" class="form-control" placeholder="*Valid date" title="Valid date" value="<?=$coupon_codes[$i]->valid_date?>"/></td>
            </tr>
            <script>
                $('#valid_date-1<?=$i?>_u').datetimepicker({ timepicker:false,minDate: new Date(), format:'d-m-Y' });
            </script>
            <?php
            }
        } ?>
    </table>
    </div> </div></div>
    <div class="row mg_tp_20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
//Hotel list load
function hotel_names_load (id,offset) {
    var offset = id.split('-');
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.get(base_url + 'view/hotels/booking/inc/hotel_name_load.php', { city_id: city_id }, function (data) {
		$('#hotel_name-'+offset[1]).html(data);
	});
}
$(function(){
$('#section_hotels').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_coupons");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        var title = row.cells[2].childNodes[0].value;
        var coupon_code = row.cells[3].childNodes[0].value;
        var amount_in = row.cells[4].childNodes[0].value;
        var amount = row.cells[5].childNodes[0].value;
        var valid_date = row.cells[6].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){

            if(title==""){ error_msg_alert("Enter title at row "+(i+1)); return false; }
            if(coupon_code==""){ error_msg_alert("Enter coupon code at row "+(i+1)); return false; }
            if(amount_in==""){ error_msg_alert("Select amount-in at row "+(i+1)); return false;}
            if(amount==""){ error_msg_alert("Enter amount at row "+(i+1)); return false; }
            if(valid_date==""){ error_msg_alert("Select valid dare at row "+(i+1)); return false;}
            images_array.push({
                'title':title,
                'coupon_code':coupon_code,
                'amount_in':amount_in,
                'amount':amount,
                'valid_date':valid_date
            });
        }
    }
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '17', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('17');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>