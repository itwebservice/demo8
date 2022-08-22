<?php include "../../../../../model/model.php";
$today_date = date('Y-m-d');
$depr_interval = $_POST['depr_interval'];

$sq_finacial_year = mysqli_fetch_assoc(mysqlQuery("select * from financial_year where financial_year_id='$depr_interval'"));
if($today_date < $sq_finacial_year['to_date']){
	echo '0'; //false
}else{
	echo '1'; //true
}

?>