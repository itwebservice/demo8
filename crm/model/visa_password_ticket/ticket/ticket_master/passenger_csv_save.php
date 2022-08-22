<?php 

class passenger_csv_save{

public function passenger_csv_save1()
{
    $cust_csv_dir = $_POST['cust_csv_dir'];
    $pass_info_arr = array();

    $cust_csv_dir = explode('uploads', $cust_csv_dir);
    $cust_csv_dir = CSV_READ_URL.'uploads'.$cust_csv_dir[1];

    begin_t();

    $count = 1;

    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {

        while(($data = fgetcsv($handle,0, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }
            if($count>0){                
            $arr = array(
                'm_first_name' => $data[0],
                'm_middle_name' => $data[1],
                'm_last_name' => $data[2],
                'm_adolescence' => $data[3],
                'ticket_no' => $data[4],
                'gds_pnr' => $data[5],
                'baggage_info' => $data[6], 
                'seat_no' => $data[7],
                'meal_plan' => $data[8],
                'main_ticket' => $data[9]
                );
            array_push($pass_info_arr, $arr);
            }
            $count++;
        }
        fclose($handle);
    }
echo json_encode($pass_info_arr);
}

}
?>