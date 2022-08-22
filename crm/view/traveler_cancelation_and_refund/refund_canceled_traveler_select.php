<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$emp_id = $_SESSION['emp_id'];
?>
<div class="app_panel_content Filter-panel">
    <div class="row text_center_xs">
        <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-3 col-xs-12 mg_bt_10_xs">
            <select id="cmb_tourwise_traveler_id" name="cmb_tourwise_traveler_id" style="width:100%" title="Select Booking ID" class="form-control" onchange="cancel_booking_reflect(this.value);">
                <option value=""><?php echo 'Select Booking'; ?></option>
                <?php
                //get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id)
                $query = "select * from tourwise_traveler_details where financial_year_id='$financial_year_id' and 1 ";
                include "../model/app_settings/branchwise_filteration.php";
                $query .= " and tour_group_status != 'Cancel'";
                $query .= " order by id desc";
                $sq_booking = mysqlQuery($query);
                while($row_booking = mysqli_fetch_assoc($sq_booking)){
            
                    $pass_count = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_booking[id]'"));
                    $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));
                    if($pass_count==$cancelpass_count){

                        $date = $row_booking['form_date'];
                        $yr = explode("-", $date);
                        $year =$yr[0];
                    
                        $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
                        if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
                            ?>
                            <option value="<?php echo $row_booking['id'] ?>"><?php echo get_group_booking_id($row_booking['id'],$year)."-"." ".$sq_customer['company_name']; ?></option>
                            <?php }
                            else{ ?> 
                
                            <option value="<?= $row_booking['id'] ?>"><?= get_group_booking_id($row_booking['id'],$year) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                            <?php
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>      
<div id="div_booking_refund_reflect"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
$("#cmb_tourwise_traveler_id").select2(); 
function cancel_booking_reflect(booking_id){
    if(booking_id!=''){
        $.post('refund_traveler_booking.php', { cmb_tourwise_traveler_id : booking_id }, function(data){
            $('#div_booking_refund_reflect').html(data);
        });
    }else{
        $('#div_booking_refund_reflect').html('');
    }
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>       