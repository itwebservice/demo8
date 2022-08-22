<?php
include "../../../model/model.php";
include_once('../../layouts/fullwidth_app_header.php');
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='hotel_quotation/index.php'"));
$branch_status = $sq['branch_status'];
?>

<!-- Tab panes -->
<div id="site_alert"></div>
<div id="vi_confirm_box"></div>
<div id="markup_confirm"></div>
<div class="bk_tab_head bg_light">
    <ul> 
        <li>
            <a href="javascript:void(0)" id="tab1_head" class="active">
                <span class="num" title="Enquiry">1<i class="fa fa-check"></i></span><br>
                <span class="text">Enquiry</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab2_head">
                <span class="num" title="Hotels">2<i class="fa fa-check"></i></span><br>
                <span class="text">Hotels</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" id="tab3_head">
                <span class="num" title="Costing">3<i class="fa fa-check"></i></span><br>
                <span class="text">Costing</span>
            </a>
        </li>
    </ul>
</div>

<div class="bk_tabs">
    <div id="tab1" class="bk_tab active">
        <?php include_once("tab1.php"); ?>
    </div>
    <div id="tab2" class="bk_tab">
        <?php include_once("tab2.php"); ?>
    </div>
    <div id="tab3" class="bk_tab">
        <?php include_once("tab3.php"); ?>
    </div>
</div>  
<script>
$('#enquiry_id, #currency_code').select2();

$('#from_date, #to_date, #quotation_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_arrval1,#txt_dapart1,#train_arrival_date,#train_departure_date').datetimepicker({ format:'d-m-Y H:i' });

/**Hotel Name load start**/
function hotel_name_list_load(id)
{
  var city_id = $("#"+id).val();
  var count = id.substring(9);
  $.get( "../hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name-"+count).html( data ) ;                            
  } ) ;   
}

</script>
<script src="<?php echo BASE_URL ?>view/hotel_quotation/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?php echo BASE_URL ?>view/hotel_quotation/js/business_rule.js"></script>
<?php
    include_once('../layouts/fullwidth_app_footer.php');
?>