<?php 
class tour_cities_master{

///////////////////////***Tour Cities save start*********//////////////

function tour_cities_save($tour_id, $city_id)
{

  for($i=0; $i<sizeof($city_id); $i++)
  {
    $city_count = mysqli_num_rows(mysqlQuery("select city_id from tour_city_names where tour_id='$tour_id' and city_id='$city_id[$i]'"));
    if($city_count>0)
    {
      echo "error--".$city_id[$i]." already exit in this tour!";
      exit;
    }  
  }  

  for($i=0; $i<sizeof($city_id); $i++)
  {
    $max_id1 = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from tour_city_names"));
    $max_id = $max_id1['max']+1;

    $sq = mysqlQuery("insert into tour_city_names (id, tour_id, city_id) values ('$max_id', '$tour_id', '$city_id[$i]') ");
    if(!$sq)
    {
      echo "error--".$city_id[$i]." not saved!";
      exit;
    }  
  }  
  echo "City names saved successfully.";
}


///////////////////////***Tour Cities save end*********//////////////

///////////////////////***Tour Cities Update start*********//////////////

function tour_cities_update($tour_city_id, $city_id, $tour_id)
{
  $city_count = mysqli_num_rows(mysqlQuery("select city_id from tour_city_names where tour_id='$tour_id' and city_id='$city_id'"));
  if($city_count>0)
  {
    echo "error--".$city_id." already exit in this tour!";
    exit;
  } 

  $sq = mysqlQuery("update tour_city_names set city_id='$city_id' where id='$tour_city_id' ");
  if(!$sq)
  {
    echo "error--City name not updated!";
    exit;
  }  
  else
  {
    echo "City name updated successfully.";
    return true;
  }  
}

///////////////////////***Tour Cities Update end*********//////////////	

}
?>