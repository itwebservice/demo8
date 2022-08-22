<?php
class branch_mgt{

///////////// User roles save start/////////////////////////////////////////////////////////////////////////////////////////
function branch_mgt_save()
{
  //$role_id = $_POST['role_id'];
  $name = $_POST['name'];
  $link = $_POST['link'];
  $rank = $_POST['rank'];
  $priority = $_POST['priority'];
  $description = $_POST['description'];
  $icon = $_POST['icon'];

  $sq = mysqlQuery("delete from branch_assign where branch_status!='disabled'");
  if(!$sq)
  {
    echo "Sorry cannot update Branch Privileges.";
  }   

  for($i=0; $i<sizeof($name); $i++)
  {
    $sq1 = mysqlQuery("select max(id) as max from branch_assign");
    $value = mysqli_fetch_assoc($sq1);
    $max_id = $value['max'] + 1; 

    $sq1 = mysqlQuery("insert into branch_assign (id, name, link, rank, priority, description, icon, branch_status) values ('$max_id' ,'$name[$i]', '$link[$i]', '$rank[$i]', '$priority[$i]', '$description[$i]', '$icon[$i]', 'yes')");
  } 
  
    echo "Branchwise Privileges Assigned!";
  

}
///////////// User roles save end/////////////////////////////////////////////////////////////////////////////////////////

}
?>