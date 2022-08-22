<?php
class b2c_operations{

    function search_session_save(){
        $_SESSION['visa_array'] = json_encode($_POST['visa_array']);
    }
}
?>