    <?php
class taxes_master{
    function save(){
        $code_array = $_POST['code_array'];
        $name_array = $_POST['name_array'];
        $rate_in_array = $_POST['rate_in_array'];
        $rate_array = $_POST['rate_array'];
        
        begin_t();
        for($i=0;$i<sizeof($code_array);$i++){
            $sq_tax_count = mysqli_num_rows(mysqlQuery("select * from tax_master where code='$code_array[$i]'"));
            if($sq_tax_count>0){
                rollback_t();
                echo "error--Tax Code already exists!";
                exit;
            }
            else{
                $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from tax_master"));
                $entry_id = $sq_max['max'] + 1;
                $sq = mysqlQuery("insert into tax_master (entry_id, code,name, rate_in, rate, status)values('$entry_id','$code_array[$i]','$name_array[$i]','$rate_in_array[$i]','$rate_array[$i]','Active')");
            }
        }
        if($sq){
            commit_t();
            echo "Taxes saved successfully!";
            exit;
        }else{
            rollback_t();
            echo "error--Taxes not saved!";
            exit;
        }
    }
    function update(){
        $entry_id = $_POST['entry_id'];
        $code = $_POST['code'];
        $name = $_POST['name'];
        $rate_in = $_POST['rate_in'];
        $rate = $_POST['rate'];
        $status = $_POST['status'];

        begin_t();
        $sq_tax_count = mysqli_num_rows(mysqlQuery("select * from tax_master where code='$code' and entry_id!='$entry_id'"));
        if($sq_tax_count>0){
            rollback_t();
            echo "error--Tax Code already exists!";
            exit;
        }
        else{
            $sq = mysqlQuery("update tax_master set code='$code',name='$name', rate_in='$rate_in', rate='$rate',status='$status' where entry_id='$entry_id'");
            if($sq){
                commit_t();
                echo "Tax updated successfully!";
                exit;
            }else{
                rollback_t();
                echo "error--Tax not updated!";
                exit;
            }
        }
    }
}