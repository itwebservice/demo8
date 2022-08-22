<?php
include_once('../../../model/model.php');
include_once('../../../model/b2c_settings/book_form.php');
include_once('../../../model/app_settings/transaction_master.php');
include_once('../../../model/app_settings/bank_cash_book_master.php');

$book_master = new book_master;
$book_master->sale_save();
?>