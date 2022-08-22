<?php
class checklist{

    public function checklist_save()
    {
        $booking_id = $_POST['booking_id'];
        $entity_id_arr = $_POST['entity_id_arr'];
        $ass_emp_id_arr = $_POST['ass_emp_id_arr'];
        $branch_admin_id = $_POST['branch_admin_id'];
        $tour_type = $_POST['tour_type'];
        $status_arr = $_POST['status_arr'];
        $entry_id_arr = $_POST['entry_id_arr'];
        $check_id_arr = $_POST['check_id_arr'];
        
        $count = sizeof($entry_id_arr);
        for($i=0; $i<$count; $i++){
            if($entry_id_arr[$i]=='' && $check_id_arr[$i] == '1'){

                $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from checklist_package_tour"));
                $id = $sq_max['max'] + 1;

                $sq_checklist = mysqlQuery("insert into checklist_package_tour( id, branch_admin_id, booking_id, tour_type,entity_id,assigned_emp_id,status ) values ( '$id', '$branch_admin_id', '$booking_id','$tour_type' ,'$entity_id_arr[$i]','$ass_emp_id_arr[$i]','$status_arr[$i]')");
                if(!$sq_checklist){
                    echo "error--Sorry, Some status are not marked!";
                    exit;
                }
            }
            else{
                if($check_id_arr[$i] == '1'){
                    
                    $sq_count =  mysqli_num_rows(mysqlQuery("select id from checklist_package_tour where id = '$entry_id_arr[$i]'"));
                    if($sq_count == 0){
                        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from checklist_package_tour"));
                        $id = $sq_max['max'] + 1;

                        $sq_update1 = mysqlQuery("insert into checklist_package_tour( id, branch_admin_id, booking_id, tour_type,entity_id,assigned_emp_id,status ) values ( '$id', '$branch_admin_id', '$booking_id','$tour_type' ,'$entity_id_arr[$i]','$ass_emp_id_arr[$i]','$status_arr[$i]')");
                    }
                    else{
                        $sq_update1 =  mysqlQuery("update checklist_package_tour set assigned_emp_id='$ass_emp_id_arr[$i]', status='$status_arr[$i]' where id = '$entry_id_arr[$i]'");
                    }
                }
                else{
                    $sq_update1 =  mysqlQuery("delete from checklist_package_tour where id = '$entry_id_arr[$i]'");
                }
                if(!$sq_update1){
                    echo "error--Sorry, Some status are not Updated!";
                    exit;
                }
            }
        }
        echo "Checklist updated successfully!";
        exit;
    }
}
?>