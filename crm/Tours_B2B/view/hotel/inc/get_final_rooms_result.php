<?php
class result_master{
    function get_result_array($cost_arr,$date_array_size){
        //Sort complete result array by room-count-wise and dates-wise
        usort($cost_arr, function($a, $b){
            if ($a["rooms"] == $b["rooms"])
                return (0);
            return (($a["rooms"] < $b["rooms"]) ? -1 : 1);
        });

        //Get Sepearte Room-count-wise hotel category costing
        $final_result_array = array();
        for($i=0;$i<sizeof($cost_arr);$i++){
            $total_cost = 0;
            $child_cost = 0;
            for($j=$i+1;$j<=$i+1;$j++){
                if($cost_arr[$i]['rooms']['category'] == $cost_arr[$j]['rooms']['category'] && $cost_arr[$i]['rooms']['room_count'] == $cost_arr[$j]['rooms']['room_count']){

                    $total_cost = $cost_arr[$i]['rooms']['room_cost'];
                    
                    $extrabed_cost = $cost_arr[$i]['rooms']['extra_bed_cost'];
                    for($k=0;$k<sizeof($cost_arr[$i]['rooms']);$k++){
                        $child_cost += $cost_arr[$i]['rooms']['child_cost'][$k];
                    }
                    $cost_arr1 = array(
                    'rooms' => array(
                                "room_count"=>      $cost_arr[$i]['rooms']['room_count'], 
                                "check_date"=>      $cost_arr[$i]['rooms']['check_date'],
                                "category"=>        $cost_arr[$i]['rooms']['category'], 
                                "room_cost"=>       floatval($total_cost),
                                "child_cost"=>      $child_cost,
                                "extra_bed_cost"=>  floatval($extrabed_cost),
                                "max_occupancy"=>   $cost_arr[$i]['rooms']['max_occupancy'],
                                "markup_type"=>     $cost_arr[$i]['rooms']['markup_type'],
                                "markup_amount"=>   $cost_arr[$i]['rooms']['markup_amount'],
                                "offer_type"=>      $cost_arr[$i]['rooms']['offer_type'],
                                "offer_amount"=>    $cost_arr[$i]['rooms']['offer_amount'],
                                "offer_in"=>        $cost_arr[$i]['rooms']['offer_in'],
                                "coupon_code"=>     $cost_arr[$i]['rooms']['coupon_code'],
                                "agent_type"=>      $cost_arr[$i]['rooms']['agent_type'],
                                "currency_id"=>     $cost_arr[$i]['rooms']['currency_id']
                    ));
                    array_push($final_result_array,$cost_arr1);
                }
                else{
                    $total_cost = $cost_arr[$i]['rooms']['room_cost'];
                    for($k=0;$k<sizeof($cost_arr[$i]['rooms']);$k++){
                        $child_cost += $cost_arr[$i]['rooms']['child_cost'][$k];
                    }
                    $cost_arr2 = array( 
                    'rooms' => array(
                                "room_count"=>      $cost_arr[$i]['rooms']['room_count'], 
                                "check_date"=>      $cost_arr[$i]['rooms']['check_date'],
                                "category"=>        $cost_arr[$i]['rooms']['category'], 
                                "room_cost"=>       floatval($total_cost),
                                "child_cost"=>      floatval($child_cost),
                                "extra_bed_cost"=>  floatval($cost_arr[$i]['rooms']['extra_bed_cost']),
                                "max_occupancy"=>   $cost_arr[$i]['rooms']['max_occupancy'],
                                "markup_type"=>     $cost_arr[$i]['rooms']['markup_type'],
                                "markup_amount"=>   floatval($cost_arr[$i]['rooms']['markup_amount']),
                                "offer_type"=>     $cost_arr[$i]['rooms']['offer_type'],
                                "offer_amount"=>   floatval($cost_arr[$i]['rooms']['offer_amount']),
                                "offer_in"=>       $cost_arr[$i]['rooms']['offer_in'],
                                "coupon_code"=>    $cost_arr[$i]['rooms']['coupon_code'],
                                "agent_type"=>     $cost_arr[$i]['rooms']['agent_type'],
                                "currency_id"=>    $cost_arr[$i]['rooms']['currency_id']
                    )
                    );
                    array_push($final_result_array,$cost_arr2);
                }
            } //j For Loop
        } //i For Loop
        //Category Array and Room-count array for next-step array creation
        $result_category_array = array();
        $room_array = array();
        for($i=0;$i<sizeof($final_result_array);$i++){
            array_push($result_category_array,$final_result_array[$i]['rooms']['category']);
            array_push($room_array,$final_result_array[$i]['rooms']['room_count']);
        }
        //Array for same room-count and same category but different dates
        $room_array = array_unique($room_array);
        $category_array = array();
        for($k=0;$k<sizeof($final_result_array);$k++){
            $final_result_array1 = array(); 
            for($i=0;$i<sizeof($final_result_array);$i++){
                if($final_result_array[$i]['rooms']['room_count'] == $room_array[$k]){
                    array_push($final_result_array1,$final_result_array[$i]['rooms']);
                }
            }
            if(!empty($final_result_array1))
            array_push($category_array,$final_result_array1);
        }
        //Array for same room-count and same category but different dates
        $category_array1 = array();
        $result_category_array = array_unique($result_category_array);
        for($c=0;$c<sizeof($result_category_array);$c++){
            
            for($k=0;$k<sizeof($category_array);$k++){

                $final_result_array1 = array();
                for($i=0;$i<sizeof($category_array[$k]);$i++){

                    if($category_array[$k][$i]['category'] == $result_category_array[$c]){
                        array_push($final_result_array1,$category_array[$k][$i]);
                    }
                }
                if(!empty($final_result_array1))
                array_push($category_array1,$final_result_array1);
            }
        }

        //Final categorywise costing array prpareation
        $final_category_array = array();
        for($i=0;$i<sizeof($category_array1);$i++){

            $room_cost_array = array();
            $child_cost_array = array();
            $extra_bed_cost_array = array();
            $markup_type_array = array();
            $markup_amount_array = array();
            for($j=0;$j<sizeof($category_array1[$i]);$j++){

                array_push($room_cost_array,floatval($category_array1[$i][$j]['room_cost']));
                array_push($child_cost_array,floatval($category_array1[$i][$j]['child_cost']));
                array_push($extra_bed_cost_array,floatval($category_array1[$i][$j]['extra_bed_cost']));
                array_push($markup_type_array,$category_array1[$i][$j]['markup_type']);
                array_push($markup_amount_array,floatval($category_array1[$i][$j]['markup_amount']));

                $categorywise_array = array(
                'room_count'=>      $category_array1[$i][$j]['room_count'],
                'category'=>        $category_array1[$i][$j]['category'],
                'check_date'=>      $category_array1[$i][$j]['check_date'],
                'room_cost' =>      ($room_cost_array),
                'child_cost'=>      ($child_cost_array),
                'daywise_exbcost'=> ($extra_bed_cost_array),
                "max_occupancy"=>   $category_array1[$i][$j]['max_occupancy'],
                "markup_type"=>     ($markup_type_array),
                "markup_amount"=>   ($markup_amount_array),
                "offer_type"=>      $category_array1[$i][$j]['offer_type'],
                "offer_amount"=>    $category_array1[$i][$j]['offer_amount'],
                "offer_in"=>        $category_array1[$i][$j]['offer_in'],
                "coupon_code"=>     $category_array1[$i][$j]['coupon_code'],
                "agent_type"=>      $category_array1[$i][$j]['agent_type'],
                "currency_id"=>     $category_array1[$i][$j]['currency_id']
                );
            }
            array_push($final_category_array,$categorywise_array);
        }
        //Find Dupicate array's key's and uset them
        $final_room_type_array = array();
        $duplicate_keys = array();
        $tmp = array();       
        $keep_key_assoc = false;
        foreach ($final_category_array as $key => $val){
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;
            if (!in_array($val, $tmp)){
                $tmp[] = $val;
            }
            else
                $duplicate_keys[] = $key;                
        }
        foreach ($duplicate_keys as $key)
            unset($final_category_array[$key]);
        ////////////////////////////////////////////////

        $final_room_type_array = $keep_key_assoc ? $final_category_array : array_values($final_category_array);
        return $final_room_type_array;
    }
}
?>