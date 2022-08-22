<?php
include_once('../../model/model.php');
include_once('../../model/ferry/ferry.php');

$ferry = new ferry;
$ferry->search_session_save();
?>