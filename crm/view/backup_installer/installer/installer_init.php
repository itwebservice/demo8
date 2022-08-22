<?php
include_once('../../../model/model.php');
//===============================Creating Backup directory start=======================================//
$timestamp = date('d-m-y').'('.date('U').')';

function check_dir($current_dir, $type)
{	 	
	if(!is_dir($current_dir."/".$type))
	{
		mkdir($current_dir."/".$type);		
	}	
	$current_dir = $current_dir."/".$type;
		return $current_dir;	
}

$current_dir = '../backups';
$current_dir = check_dir($current_dir , $timestamp);
//$project_dir = check_dir($current_dir , 'project');
$db_dir = check_dir($current_dir , 'db');
//===============================Creating Backup directory end=======================================//


//===============================Copying project to backup directory start=======================================//
$src = "../../";
$dst = $project_dir;
function copy_directory($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
            	if($file!="installers" && $file!="backup_installer"){
            		copy_directory($src . '/' . $file,$dst . '/' . $file); 	
            	}                
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
}
//copy_directory( $src, $dst );
//===============================Copying project to backup directory end=======================================//


//===============================Taking database backup start=======================================//
function backup_itours_db($db_dir, $tables = '*')
{
    
    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqlQuery('SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    $return = '';
    //cycle through
    foreach($tables as $table)
    {
        $fields_array = array();
        $result = mysqlQuery('SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $cols = mysqlQuery('SHOW COLUMNS FROM '.$table);
        while ($row_cols = mysqli_fetch_assoc($cols)) {
            // for($j=0; $j < $num_fields; $j++) {
            array_push($fields_array,$row_cols['Field']);
        }
        $fields = implode(',',$fields_array);
        $row2 = mysqli_fetch_row(mysqlQuery('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        
        for ($i = 0; $i < $num_fields; $i++) 
        {
            while($row = mysqli_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' ('.$fields.') VALUES(';
                for($j=0; $j < $num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    // $row[$j] = preg_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j < ($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    $sql_file = $db_dir.'/db-backup.txt';
    //save file
    $handle = fopen($sql_file,'w+');
    fwrite($handle,$return);
    fclose($handle);
    $sql_file = explode('..', $sql_file)[1];
    $newUrl = preg_replace('/(\/+)/','/',$sql_file); 
    echo BASE_URL.'view/backup_installer'.$newUrl;
    
}

backup_itours_db($db_dir);
//===============================Taking database backup end=======================================//


//echo "Backup is successfully taken!";
exit;
?>