<?php include "../../model/model.php"; ?>
<?php
  
        $term=$_GET['term'];
        $offset=$_GET['page']*100;
        $valueasText = $_GET['valueasText'];
        $q=mysqlQuery("select * from city_master where active_flag='Active' and city_name LIKE '$term%' LIMIT 100 OFFSET $offset");
        $q1=mysqlQuery("select * from airport_master where flag='Active' and airport_name LIKE '$term%' or airport_code LIKE '$term%' LIMIT 100 OFFSET $offset");
        $q2=mysqlQuery("select * from hotel_master where active_flag='Active' and hotel_name LIKE '$term%' LIMIT 100 OFFSET $offset");
        $children = array();$children_a = array();$children_h = array();
        while($row = mysqli_fetch_assoc($q)){
            if($valueasText == "true"){
                $children[] = array('id'=>"city-".$row['city_name'],'text'=>$row['city_name']);
            }
            else
                $children[] = array('id'=>"city-".$row['city_id'],'text'=>$row['city_name']);
        }
        while($row = mysqli_fetch_assoc($q1)){
            if($valueasText == "true"){
                $children_a[] = array('id'=>"airport-".$row['airport_name'],'text'=>$row['airport_name'].' ('.$row['airport_code'].')');
            }
            else
                $children_a[] = array('id'=>"airport-".$row['airport_id'],'text'=>$row['airport_name'].' ('.$row['airport_code'].')');
        }
        while($row = mysqli_fetch_assoc($q2)){
            if($valueasText == "true"){
                $children_h[] = array('id'=>"hptel-".$row['hotel_name'],'text'=>$row['hotel_name']);
            }
            else
                $children_h[] = array('id'=>"hotel-".$row['hotel_id'],'text'=>$row['hotel_name']);
        }
        
        $array['results'][]=array('text' => "City Name", "children" => $children);    
        $array['results'][]=array('text' => "Airport Name", "children" => $children_a);
        $array['results'][]=array('text' => "Hotel Name", "children" => $children_h);
        
        $rows = mysqli_num_rows($q);
        $rows1 = mysqli_num_rows($q1);
        $rows2 = mysqli_num_rows($q2);
        if($rows == 100 || $rows1 == 100 || $rows2 == 100){
            $array['pagination']=array("more"=>true);
        }
        else if($rows < 100 && $rows1 < 100 && $rows2 < 100){
            
            $array['pagination']=array("more"=>false);
        }  

    echo  json_encode($array);
?>