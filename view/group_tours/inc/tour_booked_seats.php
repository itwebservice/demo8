<?php

class total_booked_seats1
{
    function booked_seats($tour_id, $tour_group_id)
    {
        $traveler_group=array();

        $sq_1 = mysqlQuery("select traveler_group_id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id = '$tour_group_id'");
        while($row_1 = mysqli_fetch_assoc($sq_1))
        {
            array_push($traveler_group,$row_1['traveler_group_id']);
        }
        $query = "select * from travelers_details where 1 ";
        for($i=0; $i<sizeof($traveler_group); $i++)
        {   
            if($i>0)
            {
                $query = $query." or traveler_group_id= '$traveler_group[$i]'";
            }
            else
            {    
                $query = $query." ( traveler_group_id= '$traveler_group[$i]'";
            }
        }
        if(sizeof($traveler_group) > 1){
            $query = $query." ) ";
        }
        $query .= " and status='Active'";
        $booked_seats = (sizeof($traveler_group) > 0) ? mysqli_num_rows(mysqlQuery($query)) : 0;  
        
        return $booked_seats;
    }

    function b2c_booked_seats($tour_id, $tour_group_id)
    {	
        $booked_seats = 0;
        $sq_group = mysqli_fetch_assoc(mysqlQuery("select from_date,to_date from tour_groups where group_id='$tour_group_id'"));
        $from_date = $sq_group['from_date'];
        $to_date = $sq_group['to_date'];

        $sq_1 = mysqlQuery("select * from b2c_sale where service = 'Group Tour' and status!='Cancel'");
        while($row_1 = mysqli_fetch_assoc($sq_1)){

            $enq_data = json_decode($row_1['enq_data']);
            
            $efrom_date = date('Y-m-d', strtotime($enq_data[0]->travel_from));
            $eto_date = date('Y-m-d', strtotime($enq_data[0]->travel_to));

            if($tour_id == $enq_data[0]->package_id && $efrom_date == $from_date && $eto_date == $to_date){
                $total_pax = intval($enq_data[0]->adults)+intval($enq_data[0]->chwob)+intval($enq_data[0]->chwb)+intval($enq_data[0]->infant)+intval($enq_data[0]->extra_bed);
                $booked_seats += $total_pax;
            }
        }
        return $booked_seats;
    }
}
?>