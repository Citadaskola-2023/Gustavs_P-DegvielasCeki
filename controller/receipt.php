<?php

require __DIR__ . '/../src/FuelReceiptInsert.php';


require '../html/header.html';



require '../html/receiptForm.html';
$insert = new \App\FuelReceiptInsert();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $insert->uploadFuelReceipt($insert->getFormInput());
}
