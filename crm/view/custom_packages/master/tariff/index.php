<?php
include "../../../../model/model.php";
?>
<div class="row text-right">
    <div class="col-xs-12 mg_bt_20">
        <form action="tariff/save/index.php" method="POST">
            <button class="btn btn-info btn-sm ico_left" class="form-control" title="Add Tariff" data-toggle="tooltip" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tariff</button>
        </form>
    </div>
</div>
<div class="app_panel_content Filter-panel">
    <div class="col-md-3 col-sm-6">
        <select id="tdest_name"  name="tdest_name" title="Select Destination" class="form-control" onchange="tarrif_list_reflect(this.value)"  style="width:100%"> 
        <option value="">Destination</option>
        <?php
        $sq_query = mysqlQuery("select * from destination_master where status != 'Inactive'"); 
        while($row_dest = mysqli_fetch_assoc($sq_query)){
            ?>
            <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
            <?php
        } ?>
        </select>
    </div>
</div>

<div id="div_request_list" class="main_block loader_parent mg_tp_20">
<div class="col-md-12 no-pad"> <div class="table-responsive">
    <table id="b2b_tarrif_tab" class="table table-hover" style="margin: 20px 0 !important;width:100%;">         
    </table>
</div></div>
</div>

</div>
<div id="div_bid_modal"></div>
<div id='div_view_modal'></div>

<script>
$('#tdest_name').select2();
$('#from_date_filter,#to_date_filter').datetimepicker({ format:'d-m-Y H:i' });
var columns = [
    { title: "S_NO" },
    { title: "Package_Name(Code)" },
    { title: "Days/Nights" },
    { title: "Actions", className:"text-center" }
];
function tarrif_list_reflect(){
    $('#div_request_list').append('<div class="loader"></div>');
    var dest_id = $('#tdest_name').val();

	$.post('tariff/price_list_reflect.php', {dest_id : dest_id }, function(data){
        setTimeout(() => {
            pagination_load(data,columns,true, false, 20,'b2b_tarrif_tab') // third parameter is for bg color show yes or not
            $('.loader').remove();
        }, 1000);
	});
}
tarrif_list_reflect();
function view_modal(package_id){
    $.post('tariff/view/index.php', {package_id : package_id}, function(data){
        $('#div_view_modal').html(data);
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

