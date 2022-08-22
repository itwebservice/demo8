<?php 
class bus_master_save{

///////////// Bus Master Save start/////////////////////////////////////////////////////////////////////////////////////////
function bus_master_save_c($bus_name, $bus_capacity)
{
  $bus_name = mysqlREString($bus_name);  
  $bus_capacity = mysqlREString($bus_capacity);  
  $bus_rows = mysqlREString($bus_rows);  
  $bus_cols = mysqlREString($bus_cols);  
  $bus_gap = mysqlREString($bus_gap);  
  $bus_blank_space = mysqlREString($bus_blank_space);  
  $bus_cabin_seat_status = mysqlREString($bus_cabin_seat_status);  
  $bus_combination_status = mysqlREString($bus_combination_status);  

  $sq_name_count = mysqli_num_rows(mysqlQuery("select * from bus_master where bus_name='$bus_name'"));
  if($sq_name_count>0)
  {
    echo "error--Sorry This bus already exists.";
    exit;
  }  

   $sq = mysqlQuery("select max(bus_id) as max from bus_master");
   $value = mysqli_fetch_assoc($sq);
   $max_id = $value['max'] + 1;

   $sq = mysqlQuery("insert into bus_master(bus_id, bus_name, capacity) values('$max_id', '$bus_name', '$bus_capacity')");

   if(!$sq)
   {
     echo "error--Error.";
   }
   else
   {
     echo "Bus Details saved successfully.";
   } 

}
///////////// Bus Master Save end/////////////////////////////////////////////////////////////////////////////////////////
	
}
?>