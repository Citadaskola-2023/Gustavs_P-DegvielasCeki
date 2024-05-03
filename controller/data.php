<?php

//load header
require '../html/header.html';

require __DIR__ . '/../src/FuelReceiptRequest.php';

//get search
require '../html/receiptData.html';
$request = new \App\fuelReceiptRequest();
$request->requestData();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $request->getSearchInputs();
}