<?php
include_once('../../../../model/model.php');
include_once('../../layouts/admin_header.php');
$today = date('Y-m-d');
?>
<!--////////////****************************Actual Form content start*********************************/////////-->
<div class="app_panel_head main_block mg_bt_10" style="border-bottom: 1px solid #dddddd8f;">
    <h2 class="pull-left">Sightseeing Attractions</h2>
</div>
<div class="tour-info-wrap-new main_block">
    <div class="profile_box main_block">
        <?php 
        $sq_det = mysqlQuery("select * from fourth_coming_attraction_master where status!='Disabled' and valid_date>='$today'");
        while($row_det = mysqli_fetch_assoc($sq_det))
        {
        ?>
            <div class="col-xs-12">
                <div class="main_block bg_light">
                    <div class="col-md-8 col-xs-12"><h5 class="no-pad"><?php echo $row_det['title'] ?>
                    <button onclick="view_modal(<?= $row_det['id'] ?>)" title="View Images"><i class="fa fa-eye"></i></button></h5></div>
                    <div class="col-md-2 col-xs-12"><h5><i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> Dated :  <?php echo date("d-m-Y", strtotime($row_det['created_at'])); ?></h5></div>
                    <div class="col-md-2 col-xs-12"><h5><i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> Valid till :  <?php echo date("d-m-Y", strtotime($row_det['valid_date'])); ?></h5></div>
                </div>
                <div class="panel panel-default panel-body app_panel_style main_block">
                    <p><?php echo $row_det['description'] ?></p>
                </div>
            </div>
        <?php   
        }    
        ?>
    </div>
<div id="div_view_modal"></div>
</div>
<script>
function view_modal(att_id){

    $.post('display_images.php', { att_id: att_id }, function(data){
        $('#div_view_modal').html(data);
    });
}
</script>
<?= end_panel() ?>
<!--/////////*****************************Actual Form content end********************************/////////////-->
<?php 
include_once('../../layouts/admin_footer.php');
?>