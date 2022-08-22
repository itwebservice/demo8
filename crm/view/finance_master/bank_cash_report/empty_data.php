<?php 
include "../../../model/model.php";
$sq = mysqlQuery("delete from finance_transaction_master");
$sq = mysqlQuery("delete from bank_cash_book_master");

echo "Entries removed!";
?>