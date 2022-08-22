<?php
class package_clone{

public function package_clone_save(){
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$package_id = $_POST['package_id'];
	$cols=array();

	$result = mysqlQuery("SHOW COLUMNS FROM custom_package_master"); 
	while ($r=mysqli_fetch_assoc($result)) {
		$cols[]= $r["Field"];
	}

	$result = mysqlQuery("SELECT * FROM custom_package_master WHERE package_id='$package_id'");
	while($r=mysqli_fetch_array($result)) {

			$insertSQL = "INSERT INTO custom_package_master (".implode(", ",$cols).") VALUES (";
			$count=count($cols);

			foreach($cols as $counter=>$col) {

				if($col=='package_id'){
					$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(package_id) as max from custom_package_master"));
					$package_max = $sq_max['max']+1;
					$insertSQL .= "'".$package_max."'";	
				}
				else if($col=='inclusions' || $col=='exclusions' || $col=='note'){
					$incl_excl = addslashes($r[$col]);
					$insertSQL .= "'".$incl_excl."'";
				}
				else{
					$insertSQL .= "'".$r[$col]."'";
				}
				if ($counter<$count-1) {$insertSQL .= ", ";}
			}
			$insertSQL .= ")";
			mysqlQuery($insertSQL);
			$sq_update  = mysqlQuery("update custom_package_master set clone='yes',update_flag='0' where package_id='$package_max'");
	}

	$this->clone_program_entries($package_id, $package_max);
	$this->clone_hotel_entries($package_id, $package_max);
	$this->clone_transport_entries($package_id, $package_max);
	$this->clone_images_entries($package_id, $package_max);

	echo "Package Tour has been successfully copied.";
}

public function clone_program_entries($package_id, $package_max){
	$cols=array();
	$result = mysqlQuery("SHOW COLUMNS FROM custom_package_program"); 
	while ($r=mysqli_fetch_assoc($result)) {
		$cols[]= $r["Field"];
	}

	$result = mysqlQuery("SELECT * FROM custom_package_program WHERE package_id='$package_id'");
	while($r=mysqli_fetch_array($result)) {
		$insertSQL = "INSERT INTO custom_package_program (".implode(", ",$cols).") VALUES (";
		$count=count($cols);

		foreach($cols as $counter=>$col) {
			if($col=='entry_id'){
			$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from custom_package_program"));
					$id = $sq_max['max']+1;
					$insertSQL .= "'".$id."'";	
			}
			elseif($col=='package_id'){
				$insertSQL .= "'".$package_max."'";
			}
			else{
				$dyn_content = addslashes($r[$col]);
			$insertSQL .= "'".$dyn_content."'";	
			}
			if ($counter<$count-1) {$insertSQL .= ", ";}
			}

			$insertSQL .= ")";
			mysqlQuery($insertSQL);
	}
}

public function clone_hotel_entries($package_id, $package_max){
	$cols=array();
	$result = mysqlQuery("SHOW COLUMNS FROM custom_package_hotels"); 
	while ($r=mysqli_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}

	  $result = mysqlQuery("SELECT * FROM custom_package_hotels WHERE package_id='$package_id'");
	  while($r=mysqli_fetch_array($result)) {
		    $insertSQL = "INSERT INTO custom_package_hotels (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {
		      if($col=='entry_id'){
		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from custom_package_hotels"));
						$id = $sq_max['max']+1;
						$insertSQL .= "'".$id."'";	
  	      }
		      elseif($col=='package_id'){
	 			  	$insertSQL .= "'".$package_max."'";
 			  	}
		      else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
  			  if ($counter<$count-1) {$insertSQL .= ", ";}
			 }

			  $insertSQL .= ")";
			  mysqlQuery($insertSQL);
	  }
}
public function clone_transport_entries($package_id, $package_max){
	$cols=array();
	$result = mysqlQuery("SHOW COLUMNS FROM custom_package_transport"); 
	while ($r=mysqli_fetch_assoc($result)) {
	   $cols[]= '`'.$r["Field"].'`';
	}

	$result = mysqlQuery("SELECT * FROM custom_package_transport WHERE package_id='$package_id'");
	while($r = mysqli_fetch_array($result)) {

		$insertSQL = "INSERT INTO custom_package_transport (".implode(", ",$cols).") VALUES (";
		$count=count($cols);
		foreach($cols as $counter=>$col) {
			if($col=='`entry_id`'){
				$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from custom_package_transport"));
				$id = $sq_max['max']+1;
				$insertSQL .= "'".$id."'";	
			}
			elseif($col=='`package_id`'){
				$insertSQL .= "'".$package_max."'";
			}
			else{
				$col_name = str_replace('`','',$col);
				$insertSQL .= "'".$r[$col_name]."'";	
			}
			if ($counter<$count-1) {$insertSQL .= ", ";}
		}

		$insertSQL .= ")";
		
		mysqlQuery($insertSQL);
	}
}
public function clone_images_entries($package_id, $package_max){
	$cols=array();
	$result = mysqlQuery("SHOW COLUMNS FROM custom_package_images"); 
	while ($r=mysqli_fetch_assoc($result)) {
	   $cols[]= $r["Field"];
	}

	  $result = mysqlQuery("SELECT * FROM custom_package_images WHERE package_id='$package_id'");
	  while($r=mysqli_fetch_array($result)) {
		    $insertSQL = "INSERT INTO custom_package_images (".implode(", ",$cols).") VALUES (";
		    $count=count($cols);

		    foreach($cols as $counter=>$col) {
		      if($col=='image_entry_id'){
		      	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(image_entry_id) as max from custom_package_images"));
						$id = $sq_max['max']+1;
						$insertSQL .= "'".$id."'";	
  	      }
		      elseif($col=='package_id'){
	 			  	$insertSQL .= "'".$package_max."'";
 			  	}
		      else{
		      	$insertSQL .= "'".$r[$col]."'";	
		      }
  			  if ($counter<$count-1) {$insertSQL .= ", ";}
			 }

			  $insertSQL .= ")";
			  mysqlQuery($insertSQL);
	  }
}

}

?>