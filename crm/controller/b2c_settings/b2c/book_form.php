<?php
include_once('../../../model/model.php');
include_once('../../../model/b2c_settings/book_form.php');

$book_master = new book_master;
$book_master->calculate_cost();
?>