<div class="row text-right mg_bt_10">
    <div class="col-xs-12">
        <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_member_dynamic_row')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
    </div>
</div>
<input type="hidden" id="tour_type_r" name="tour_type_r">
<?php
    $sq_bus_booking = mysqli_fetch_assoc(mysqlQuery("select seats_booked from bus_tour_booking where tour_id='$tour_id' and tour_group_id='$tour_group_id' "));
?>    
<input type="hidden" value="<?= $traveler_group_id ?>" id="traveler_group_id" name="traveler_group_id"/>
<div class="row"> <div class="col-xs-12"> <div class="table-responsive">
<table id="tbl_member_dynamic_row" class="table table-bordered table-hover table-striped" style="width:1504px">
<?php 
$count_m = 0;
$bg;
$disabled;
$sq_traveler_grop_details = mysqlQuery("select * from travelers_details where traveler_group_id='$traveler_group_id'");
while($row_traveler_grop_details = mysqli_fetch_assoc($sq_traveler_grop_details))
{    
    $count_m++;
    $sq_entry = mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where traveler_group_id='$traveler_group_id'"));
    
    $bg = ($row_traveler_grop_details['status']=='Cancel' || $sq_entry['tour_group_status']=='Cancel' )?'danger':"";
    $disabled = ($row_traveler_grop_details['status']=='Cancel' || $sq_entry['tour_group_status']=='Cancel')?'disabled':"";
    
?>    
<tr class="<?= $bg ?>">
    <td ><input id="<?php echo "check-btn-member-".$count_m.'m' ?>" type="checkbox" onchange="payment_details_reflected_data('tbl_member_dynamic_row')" checked disabled ></td>

    <td><input maxlength="15" type="text" name="username"  value="<?php echo $count_m ?>" placeholder="ID" disabled/></td>

    <td><select id="<?= 'cmb_m_honorific'.$count_m.'m' ?>" data-toggle="tooltip" onchange="changeGender(this.id)" title="Honorific" name="<?= 'cmb_m_honorific'.$count_m.'m' ?>" <?= $disabled;?>>
            <option value="<?php echo $row_traveler_grop_details['m_honorific'] ?>"><?php echo $row_traveler_grop_details['m_honorific'] ?></option>
            <option value="Mr"> Mr </option>
            <option value="Mrs"> Mrs </option>
            <option value="Mas"> Mas </option>
            <option value="Miss"> Miss </option>
            <option value="Smt"> Smt </option>
            <option value="Infant"> Infant </option>
        </select>
    </td>
    
    <td><input style="width: 129px;" type="text" id="<?php echo 'txt_m_first_name'.$count_m.'m' ?>" name="<?php echo 'txt_m_first_name'.$count_m.'m' ?>" <?= $disabled;?> onchange="fname_validate(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" title="First Name" placeholder="First Name" value="<?php echo $row_traveler_grop_details['first_name'] ?>"  required /></td>
    <td><input style="width: 129px;" type="text" id="<?php echo 'txt_m_middle_name'.$count_m.'m' ?>" name="<?php echo 'txt_m_middle_name'.$count_m.'m' ?>" <?= $disabled;?>  onchange="fname_validate(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" title="Middle Name" placeholder="Middle Name" value="<?php echo $row_traveler_grop_details['middle_name'] ?>" /></td>
    <td><input style="width: 129px;" type="text" id="<?php echo 'txt_m_last_name'.$count_m.'m' ?>" name="<?php echo 'txt_m_last_name'.$count_m.'m' ?>" <?= $disabled;?>  onchange="fname_validate(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" placeholder="Last Name" title="Last Name" value="<?php echo $row_traveler_grop_details['last_name'] ?>" /></td>

    <td><select id="<?php echo 'cmb_m_gender'.$count_m.'m' ?>" title="Gender" name="<?php echo 'cmb_m_gender'.$count_m.'m' ?>" <?= $disabled;?> style="width:60px;"> 
            <?php 
                if($row_traveler_grop_details['gender']=='Male'){ $gender='M'; }    
                else { $gender='F'; }
            ?>    
            <option value="<?php echo $row_traveler_grop_details['gender'] ?>"><?php echo $gender ?></option>
            <option value="Male"> M </option>
            <option value="Female"> F </option>
        </select>
    </td>
    <td><input maxlength="20" type="text" id="<?php echo 'm_birthdate'.$count_m.'m' ?>" name="<?php echo 'm_birthdate'.$count_m.'m' ?>" value="<?php if($row_traveler_grop_details['birth_date']!="") { echo date("d-m-Y", strtotime($row_traveler_grop_details['birth_date'])); } ?>" <?= $disabled;?> title="Birth Date" style="width: 100px;" onchange="calculate_age_member(this.id); payment_details_reflected_data('tbl_member_dynamic_row');" placeholder="Birth Date" required /></td>
    <td><input style="width: 100px;" type="text" id="<?php echo 'txt_m_age'.$count_m.'m' ?>" name="<?php echo 'txt_m_age'.$count_m.'m' ?>" <?= $disabled;?>  value="<?php echo $row_traveler_grop_details['age'] ?>" title="Age(Y:M:D)" placeholder="Age" onchange="payment_details_reflected_data('tbl_member_dynamic_row')"  onkeyup="adolescence_reflect(this.id)" /></td>
    <td><select id="<?php echo 'txt_m_adolescence'.$count_m.'m' ?>" title="Adolescence" name="<?php echo 'txt_m_adolescence'.$count_m.'m' ?>" disabled>
            <?php 
            if($row_traveler_grop_details['adolescence']=="Adult"){ $adlc = "A"; }
            if($row_traveler_grop_details['adolescence']=="Child With Bed"){ $adlc = "CB"; }
            if($row_traveler_grop_details['adolescence']=="Child Without Bed"){ $adlc = "CWB"; }
            if($row_traveler_grop_details['adolescence']=="Infant"){ $adlc = "I"; }
            ?>
            <option value="<?php echo $row_traveler_grop_details['adolescence'] ?>"><?php echo $adlc; ?></option>            
            <option value="Adult">A</option>
            <option value="Child With Bed">CB</option>
            <option value="Child Without Bed">CWB</option>
            <option value="Infant">I</option>
        </select>
    </td>
    <td><input type="text" id="txt_m_passport_no<?= $count_m ?>m" name="txt_m_passport_no" placeholder="Passport No" title="Passport No" onchange="validate_specialChar(this.id);payment_details_reflected_data('tbl_member_dynamic_row')"  <?= $disabled;?> value="<?= $row_traveler_grop_details['passport_no'] ?>" style="text-transform: uppercase;width: 139px;"></td>
    <td><input type="text" id="txt_m_passport_issue_date<?= $count_m ?>m" name="txt_m_passport_issue_date" placeholder="Issue Date" title="Passport Issue Date" onchange=" payment_details_reflected_data('tbl_member_dynamic_row');checkPassportDate(this.id)" <?= $disabled;?> value="<?php echo get_date_user($row_traveler_grop_details['passport_issue_date']); ?>" style="width: 130px;"></td>
    <td><input type="text" id="txt_m_passport_expiry_date<?= $count_m ?>m" name="txt_m_passport_expiry_date" value="<?php echo get_date_user($row_traveler_grop_details['passport_expiry_date']); ?>" title="Passport Expire Date" placeholder="Expire Date" onchange="payment_details_reflected_data('tbl_member_dynamic_row');checkExpiryDate(this.id)" style="width: 132px;" <?= $disabled ?>></td>
    <td><input type="hidden" value="<?php echo $row_traveler_grop_details['traveler_id'] ?>"></td>    
</tr>
<?php
}
?>

</table>


</div> </div> </div>

<input type = "hidden" id="txt_member_date_generate" value="<?php echo $count_m ?>">

<script>
function checkExpiryDate (id) {
	var idate = document.getElementById(id).value;
    var today = new Date().getTime(),
        idate = idate.split("-");

    idate = new Date(idate[2], idate[1] - 1, idate[0]).getTime();
    if( (today - idate) < 0){
    }
    else{
        error_msg_alert(" Expiry date should not be past date");
		$('#'+id).css({'border':'1px solid red'});  
			document.getElementById(id).value="";
			$('#'+id).focus();
			g_validate_status = false;
		return false;    }
}
function checkPassportDate (id) {
	var date1 = document.getElementById(id).value;
    var dates = date1.split("-");
    dates = new Date(dates[2], dates[1] - 1, dates[0]).getTime();
	if (dates == '') {
		error_msg_alert('Please enter the Date..!!');
		return false;
	}
	else if (!date1.match(/^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/)) {
		error_msg_alert('Date format is wrong');
		return false;
	}

    var today = new Date().getTime()
	date = Date.parse(date);
	if (today < dates) {
        error_msg_alert("Date cannot be future date");
        $('#'+id).css({'border':'1px solid red'});  
        document.getElementById(id).value="";
        $('#'+id).focus();
        g_validate_status = false;
        return false;		
	}
}
    function generating_member_date()
    {
        var count = $("#txt_member_date_generate").val();
        for(var i=0; i<=count; i++)
        {
            var date = new Date();
            var yest = date.setDate(date.getDate()-1);
            $( "#m_birthdate"+i+'m').datetimepicker({ timepicker: false, maxDate:yest, format: "d-m-Y"  });
            $( "#txt_m_passport_issue_date"+i+'m').datetimepicker({ timepicker: false, format: "d-m-Y"  });
            $( "#txt_m_passport_expiry_date"+i+'m').datetimepicker({ timepicker: false, format: "d-m-Y"  });
        }             
    }
    generating_member_date();
</script>
<script src="../js/tab_1_member_info_sec.js"></script>