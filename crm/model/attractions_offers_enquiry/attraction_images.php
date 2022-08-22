<?php 
class attraction_images
{

	public function update()
	{
		$attr_url = $_POST['upload_url'];
		$fourth_id = $_POST['fourth_id'];
		$max_img_entry_id = mysqli_fetch_assoc(mysqlQuery("select max(attr_id) as max from fourth_coming_att_images"));
		$max_entry_id = $max_img_entry_id['max']+1;

		$sq_count=mysqli_num_rows(mysqlQuery("select * from fourth_coming_att_images where fourth_id='$fourth_id' and upload!=''"));
		if($sq_count<3)
		{
			$sq_img = mysqlQuery("INSERT INTO `fourth_coming_att_images`(`attr_id`, `fourth_id`, `upload`) VALUES ('$max_entry_id','$fourth_id','$attr_url')");
			if(!$sq_img)
			{
				echo "error--Image Not Saved";
			}else
			{
				echo "Image Saved";
			}
		}
		else{
			echo "error--Sorry,You can Upload upto 3 images.";
		}
	} 
	
}
?>
