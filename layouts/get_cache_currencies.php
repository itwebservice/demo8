<?php
if (file_exists(BASE_URL.'view/cache.txt')) {
    $modified_time = filemtime('cache.txt');
}else{
    $modified_time = time()-1*10801;
}
$data = array();
if ($modified_time < time()-1*10800) {
    include_once BASE_URL.'model/model.php';
    
    //Currency Rates
    $result = mysqlQuery("SELECT * FROM roe_master");
    while($row = mysqli_fetch_array($result)) {
        $temp_array = array(
            'entry_id' => $row['entry_id'],
            'currency_id' => $row['currency_id'],
            'currency_rate' => $row['currency_rate']
        );
        array_push($data,$temp_array);
    }
    //Currency Icon
    $sq_currency= mysqlQuery("select default_currency,id from currency_name_master");
    while($row_currency = mysqli_fetch_array($sq_currency)) {
        $temp_array = array(
            'icon' => $row_currency['default_currency'],
            'id' => $row_currency['id']
        );
        array_push($data,$temp_array);
    }

    $result = mysqlQuery("SELECT * FROM tax_master");
    while($row = mysqli_fetch_array($result)) {
        $temp_array = array(
            'entry_id' => $row['entry_id'],
            'name1' => $row['name1'],
            'amount1' => $row['amount1'],
            'ledger1' => $row['ledger1'],
            'name2' => $row['name2'],
            'amount2' => $row['amount2'],
            'ledger2' => $row['ledger2'],
            'status' => $row['status']
        );
        array_push($data,$temp_array);
    }
    //Tax Rules
    $result = mysqlQuery("SELECT * FROM tax_master_rules");
    while($row = mysqli_fetch_array($result)) {
        $temp_array = array(
            'rule_id' => $row['rule_id'],
            'entry_id' => $row['entry_id'],
            'name' => $row['name'],
            'validity' => $row['validity'],
            'from_date' => $row['from_date'],
            'to_date' => $row['to_date'],
            'ledger_id' => $row['ledger_id'],
            'travel_type' => $row['travel_type'],
            'calculation_mode' => json_encode($row['calculation_mode']),
            'target_amount' => $row['target_amount'],
            'applicableOn' => $row['applicableOn'],
            'conditions' => $row['conditions'],
            'status' => $row['status']
        );
        array_push($data,$temp_array);
    }

    // store query result in cache.txt
    file_put_contents(BASE_URL.'view/cache.txt', serialize(json_encode($data)));
    $data = json_encode($data);
}
else {
    $data = unserialize(file_get_contents('cache.txt'));
    //echo $data;
}
?>