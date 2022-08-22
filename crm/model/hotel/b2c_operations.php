<?php
class b2c_operations{

    function search_session_save(){
        $_SESSION['hotel_array'] = json_encode($_POST['hotel_array']);
    }
}
?>