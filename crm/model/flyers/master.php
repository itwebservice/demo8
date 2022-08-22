<?php
class flyer_master{
    
    function save(){

        $back_url = $_POST['back_url'];
        $flyer_name = addslashes($_POST['flyer_name']);
        $logo_upload_url = $_POST['logo_upload_url'];

        $title1 = $_POST['title'];
        $desc_data = $_POST['desc'];
        $content1 = $_POST['content1'];
        $content2 = $_POST['content2'];
        $content3 = $_POST['content3'];
        $date = date('Y-m-d');
        
        $logoloc =json_encode(array("css"=> array("top" => "100px", "left" =>"250px" , "position" => "absolute"),"data"=> $logo_upload_url));
        $title = json_encode(array("css"=> array("top" => "100px", "left" =>"250px" , "position" => "absolute")));
        $desc = json_encode(array("css"=> array("top" => "100px", "left" =>"250px" , "position" => "absolute")));
        $content1_css = json_encode(array("css"=> array("top" => "100px", "left" =>"250px" , "position" => "absolute")));
        $content2_css = json_encode(array("css"=> array("top" => "100px", "left" =>"250px" , "position" => "absolute")));
        $content3_css = json_encode(array("css"=> array("top" => "100px", "left" =>"250px" , "position" => "absolute")));
        $gencss = " width:100%; z-index: 1;";

        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(iid) as max from flyers"));
        $iid = $sq_max['max'] + 1;

        $sq_query = mysqlQuery("insert into flyers (`iid`,`flyer_name`, `background_url`, `logo`, `title`, `title_data`, `desc`,`desc_data`, `content1`, `content1_data`, `content2`, `content2_data`, `content3`, `content3_data`, `igencss`,`created_at`,`active_flag`) values('$iid','$flyer_name','$back_url','$logoloc','$title','$title1','$desc','$desc_data','$content1_css','$content1','$content2_css','$content2','$content3_css','$content3','$gencss','$date','Active')");
        if($sq_query){
            echo 'Flyer saved successfully';
            exit;
        }else{
            echo 'error--Flyer not saved successfully';
            exit;
        }
    }
    function update(){
        
        $flyer_id = $_POST['flyer_id'];
        $logo_array = $_POST['logo_array'];

        $title_array = $_POST['title_array'];
        $desc_array = $_POST['desc_array'];
        $content1_array = $_POST['content1_array'];
        $content2_array = $_POST['content2_array'];
        $content3_array = $_POST['content3_array'];
        
        $title_data = $_POST['title_data'];
        $description_data = $_POST['description_data'];
        $content1_data = $_POST['content1_data'];
        $content2_data = $_POST['content2_data'];
        $content3_data = $_POST['content3_data'];

        $logo_array1 =json_encode(array("css"=> array("top" => $logo_array[0]['css'][0]['top'], "left" =>$logo_array[0]['css'][0]['left'] , "position" => "absolute"),"data"=> $logo_array[0]['data']));
        $title_array1 =json_encode(array("css"=> array("top" => $title_array[0]['css'][0]['top'], "left" =>$title_array[0]['css'][0]['left'] , "position" => "absolute"),"data"=> $title_array[0]['data']));
        $desc_array1 =json_encode(array("css"=> array("top" => $desc_array[0]['css'][0]['top'], "left" =>$desc_array[0]['css'][0]['left'] , "position" => "absolute")));
        $content1_array1 =json_encode(array("css"=> array("top" => $content1_array[0]['css'][0]['top'], "left" =>$content1_array[0]['css'][0]['left'] , "position" => "absolute")));
        $content2_array1 =json_encode(array("css"=> array("top" => $content2_array[0]['css'][0]['top'], "left" =>$content2_array[0]['css'][0]['left'] , "position" => "absolute")));
        $content3_array1 =json_encode(array("css"=> array("top" => $content3_array[0]['css'][0]['top'], "left" =>$content3_array[0]['css'][0]['left'] , "position" => "absolute")));

        $q = "UPDATE `flyers` SET `logo`='$logo_array1',`title`='$title_array1',`title_data`='$title_data',`desc`='$desc_array1',`desc_data`='$description_data',`content1`='$content1_array1',`content1_data`='$content1_data',`content2`='$content2_array1',`content2_data`='$content2_data',`content3`='$content3_array1',`content3_data`='$content3_data' WHERE iid='$flyer_id'";
        $sq_query = mysqlQuery($q);

        if($sq_query){
            echo 'Flyer updated successfully';
            exit;
        }else{
            echo 'error--Flyer not updated successfully';
            exit;
        }
    }
    function delete(){
        
        $flyer_id = $_POST['flyer_id'];
        $q = "UPDATE `flyers` SET `active_flag`='Inactive' WHERE iid='$flyer_id'";
        $sq_query = mysqlQuery($q);

        if($sq_query){
            echo 'Flyer deleted successfully';
            exit;
        }else{
            echo 'error--Flyer not deleted successfully';
            exit;
        }
    }
}
?>