<?php
class tcs{
    
    function save(){

        $tax_amount_arr = $_POST['tax_amount_arr'];
        $calc_arr = $_POST['calc_arr'];
        $apply_arr = $_POST['apply_arr'];
        
        begin_t();
        $sq_valid = mysqli_num_rows(mysqlQuery("select * from tcs_master where 1"));
        if($sq_valid==0){

            for($i=0;$i<3;$i++){

                $entry_id = intval($i)+1;
                $sq = mysqlQuery("INSERT INTO `tcs_master`(`entry_id`, `tax_amount`, `calc`, `apply`) VALUES ('$entry_id','$tax_amount_arr[$i]','$calc_arr[$i]','$apply_arr[$i]')");
                if(!$sq){
                    rollback_t();
                    echo "TCS information not saved!";
                }
            }
        }else{
            for($i=0;$i<3;$i++){

                $entry_id = intval($i)+1;
                $sq = mysqlQuery("UPDATE `tcs_master` SET `tax_amount`='$tax_amount_arr[$i]',`calc`='$calc_arr[$i]',`apply`='$apply_arr[$i]' WHERE entry_id='$entry_id'");
                if(!$sq){
                    rollback_t();
                    echo "TCS information not updated!";
                    exit;
                }
            }
        }
        
        if($sq){
            commit_t();
            echo "TCS information saved successfully!";
            exit;
        }
    }
}