<?php 

class facebook_leads_token{
    public function save_token(){
        $access_token = $_POST['access_token'];
        $sq_check = mysqli_num_rows(mysqlQuery("select * from facebook_access_token where access_token = '$access_token'"));
        if($sq_check > 0){
            echo "Token already present";
        }
        else{
            $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(token_id) as max from facebook_access_token"));
            $token_id = $sq_max['max'] + 1;
            $sq_token = mysqlQuery("insert into facebook_access_token (token_id, access_token) values ('$token_id', '$access_token' ) ");
            if(sq_token){
                echo "Token is successfully added";
            }
            else{
                echo "Token is not added";
            }
        }
    }
    public function check_token(){
        $tokenQuery = mysqlQuery("SELECT `access_token` FROM `facebook_access_token` order by `token_id` DESC");

        //Checking if token returns a 400 http code
        while($tokens = mysqli_fetch_assoc($tokenQuery)){
            $url = "https://graph.facebook.com/oauth/access_token_info?access_token=".$tokens['access_token'];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            if($httpcode == "200"){
                echo "ValidTokenPresent";
                break;
            }
        }
    }
}

?>