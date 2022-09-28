<?php

/*$seperator = strstr(strtoupper(substr(PHP_OS, 0, 3)), "WIN") ? "\\" : "/";
session_save_path('..'.$seperator.'xml'.$seperator.'session_dir');
ini_set('session.gc_maxlifetime', 6); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', FALSE);
ini_set('session.use_only_cookies', TRUE);*/
ini_set("session.gc_maxlifetime", 3*60*60);
ini_set('session.gc_maxlifetime', 3*60*60);
session_start();

require_once 'api.php';
date_default_timezone_set('Asia/Kolkata');

set_error_handler("myErrorHandler");
function myErrorHandler($errno, $errstr, $errfile, $errline){
   // echo  "<br><br>".$errno."<br>".$errstr."<br>".$errfile."<br>".$errline;
}
$localIP = getHostByName(getHostName());

// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "itours_demo_8";
global $connection;
$connection = new mysqli($servername, $username, $password, $db_name);

define('BASE_URL', 'http://localhost/itours_git/demo8/crm/');

define('BASE_URL_B2C', 'http://localhost/itours_git/demo8/');
mysqli_query($connection,"SET SESSION sql_mode = ''");
// mysqli_set_charset($connection,'utf8');
//**********Global Variables start**************//
global $admin_logo_url, $circle_logo_url, $report_logo_small_url, $app_email_id_send, $app_smtp_host, $app_smtp_port, $app_smtp_password,$app_smtp_method,$app_smtp_status,$app_name,$app_contact_no,$currency_logo,$currency_code;

$admin_logo_url = BASE_URL.'images/Admin-Area-Logo.png';
$circle_logo_url = BASE_URL.'images/logo-circle.png';
$report_logo_small_url = BASE_URL.'images/Receips-Logo-Small.jpg';

global $secret_key,$encrypt_decrypt,$currency,$text_primary_color,$text_secondary_color,$button_color;
$secret_key = "secret_key_for_iTours";

$sq_app_setting = mysqli_fetch_assoc(mysqli_query($connection,"select * from app_settings"));
$app_name = $sq_app_setting['app_name'];
$app_contact_no = $sq_app_setting['app_contact_no'];
$app_smtp_status = $sq_app_setting['app_smtp_status'];
$app_email_id_send = $sq_app_setting['app_email_id'];
$app_smtp_host = $sq_app_setting['app_smtp_host'];
$app_smtp_port = $sq_app_setting['app_smtp_port'];
$app_smtp_password = $sq_app_setting['app_smtp_password'];
$app_smtp_password = $sq_app_setting['app_smtp_password'];
$app_smtp_method = $sq_app_setting['app_smtp_method'];
$currency = $sq_app_setting['currency'];

$sq_color_scheme = mysqli_fetch_assoc(mysqli_query($connection,"select * from b2c_color_scheme where 1 "));
$text_primary_color = $sq_color_scheme['text_primary_color'];
$text_secondary_color = $sq_color_scheme['text_secondary_color'];
$button_color = $sq_color_scheme['button_color'];
$currency_logo_d = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `default_currency`,`currency_code` FROM `currency_name_master` WHERE id=" . $currency));
$currency_code = $currency_logo_d['currency_code'];
$currency_logo = ($currency_logo_d['default_currency']);

include 'crm/model/app_settings/dropdown_master.php';

$encrypt_decrypt = new encrypt_decrypt;
class encrypt_decrypt
{
    function fnEncrypt($plaintext, $key)
    {
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
        
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($plaintext, $ciphering,
                    $key, $options, $encryption_iv);
        return $encryption;
    }
    function fnDecrypt($encryption, $key)
    {
        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';
        $options = 0;

        // Use openssl_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($encryption, $ciphering, 
        $key, $options, $decryption_iv);
        return $decryption;
    }
}

// Userdefined function for php-8 mysqli-query
function mysqlQuery($query){

global $connection;
return mysqli_query($connection,$query);
}
// Userdefined function for php-8 mysqli_real_escape_string
function mysqlREString($string){

global $connection;
return mysqli_real_escape_string($connection,$string);
}
function clean($string) {

   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
//**********App Settings Global Variables start**************//

function get_cities_dropdown_sugg()
{ 
    $final_array = array();
    $sq_city = mysqlQuery("select city_name from city_master where active_flag!='Inactive' order by REPLACE(city_name, ' ', '') asc");
    while($row_city = mysqli_fetch_assoc($sq_city)){
        array_push($final_array, $row_city['city_name']);
    }
    echo json_encode($final_array);
}

?>
