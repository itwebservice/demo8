<?php 
class app_color_scheme{


public function app_color_scheme_save()
{
	$theme_color = $_POST['theme_color'];
	$theme_color_dark = $_POST['theme_color_dark'];
	$theme_color_2 = $_POST['theme_color_2'];
	$sidebar_color = $_POST['sidebar_color'];
	$topbar_color = $_POST['topbar_color'];

	$sq_count = mysqli_num_rows( mysqlQuery("select * from app_color_scheme") );

	if($sq_count==0){

		$sq = mysqlQuery("insert into app_color_scheme ( id, theme_color, theme_color_dark, theme_color_2, sidebar_color, topbar_color ) values ( '1', '$theme_color', '$theme_color_dark', '$theme_color_2', '$sidebar_color', '$topbar_color' )");
		if(!$sq){
			echo "error--Color Scheme not saved.";
			exit;
		}
		else{
			echo "Color Scheme saved successfully.";
			exit;
		}

	}
	else{
		$sq = mysqlQuery("update app_color_scheme set theme_color='$theme_color', theme_color_dark='$theme_color_dark', theme_color_2='$theme_color_2', sidebar_color='$sidebar_color', topbar_color='$topbar_color' where id='1'");

		if(!$sq){
			echo "error--Color Scheme not saved.";
			exit;
		}
		else{
			echo "Color Scheme saved successfully.";
			exit;
		}
	}

}

public function app_color_scheme_reset()
{
	$sq = mysqlQuery("delete from app_color_scheme");

	if(!$sq){
		echo "error--Color Scheme reset not successfully.";
		exit;
	}
	else{
		echo "Color Scheme reset successfully.";
		exit;
	}
}


}
?>