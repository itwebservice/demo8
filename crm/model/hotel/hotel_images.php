<?php 
class hotel_images
{
	public function save()
	{
		$hotel_url = $_POST['hotel_upload_url'];
		$hotel_names = $_POST['hotel_names'];
		
		$max_img_entry_id = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from hotel_vendor_images_entries"));
		$max_entry_id = $max_img_entry_id['max']+1;
		$sq_count=mysqli_num_rows(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$hotel_names'"));
		if($sq_count<10)
		{
			$sq_count++;
			$sq_img = mysqlQuery("INSERT INTO `hotel_vendor_images_entries`(`id`, `hotel_id`, `hotel_pic_url`) VALUES ('$max_entry_id','$hotel_names','$hotel_url')");
			if(!$sq_img)
			{
			echo "error--Image Not Saved";
			}else
			{
			echo $sq_count." Images Saved";
			}
		}else
		{
		echo "error--Sorry, you can upload upto 10 images.";
		}

	}

	public function update()
	{
		$hotel_url = $_POST['hotel_upload_url'];
		$hotel_id = $_POST['hotel_id'];
	 	$max_img_entry_id = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from hotel_vendor_images_entries"));
	  	$max_entry_id = $max_img_entry_id['max']+1;

	  	$sq_count=mysqli_num_rows(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id='$hotel_id'"));
		  if($sq_count<10)
		  {
		  	$sq_img = mysqlQuery("INSERT INTO `hotel_vendor_images_entries`(`id`, `hotel_id`, `hotel_pic_url`) VALUES ('$max_entry_id','$hotel_id','$hotel_url')");
		  	if(!$sq_img)
		  	{
		  		echo "error--Image Not Saved";
		  	}else
		  	{
		  		echo "Image Saved";
		  	}
		  }else
		  {
		  	echo "error--Sorry, you can upload upto 10 images.";
		  }
	} 
}
?>