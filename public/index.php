<?php

require __DIR__ . '/../src/FuelReceiptDTO.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receipt = new \App\FuelReceiptDTO(
        licencePlate: $_POST['license_plate'],
        dateTime: $_POST['date_time'],
        odometer: $_POST['odometer'],
        petrolStation: $_POST['petrol_station'],
        fuelType: $_POST['fuel_type'],
        refueled: $_POST['refueled'],
        total: $_POST['total'],
        currency: $_POST['currency'],
    );

    try {
        $pdo = new PDO("mysql:host=mysql;dbname=fuel;charset=utf8mb4", 'root', 'root', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    $sql = <<<MySQL
        INSERT INTO fuel_receipts (license_plate, date_time, odometer, petrol_station, fuel_type, refueled, total, currency, fuel_price)
        VALUES (:licencePlate, :dateTime, :odometer, :petrolStation, :fuelType, :refueled, :total, :currency, :fuelPrice)
        MySQL;


    $stmt = $pdo->prepare($sql);
    $stmt->execute($receipt->toArray());

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Receipt Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h1 {
            color: #007bff;
            margin-top: 0;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        input[type="datetime-local"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Fuel Receipt Form</h1>
    <form action="process.php" method="post">
        <label for="license_plate">License Plate:</label>
        <input type="text" name="license_plate" id="license_plate">

        <label for="odometer">Odometer:</label>
        <input type="number" name="odometer" id="odometer">

        <label for="date_time">Date and Time:</label>
        <input type="datetime-local" name="date_time" id="date_time">

        <label for="petrol_station">Petrol Station:</label>
        <input type="text" name="petrol_station" id="petrol_station">

        <label for="fuel_type">Fuel Type:</label>
        <input type="text" name="fuel_type" id="fuel_type">

        <label for="refueled">Refueled (liters):</label>
        <input type="number" name="refueled" id="refueled">

        <label for="total">Total (currency):</label>
        <input type="number" name="total" id="total">

        <label for="currency">Currency:</label>
        <select name="currency" id="currency">
            <option value="EUR">Euro (EUR)</option>
            <option value="CZK">Czech Koruna (CZK)</option>
            <option value="USD">US Dollar (USD)</option>
            <option value="GBP">British Pound (GBP)</option>
            <option value="GEL">Georgian Lari (GEL)</option>
            <option value="JPY">Japanese Yen (JPY)</option>
            <option value="RUB">Russian Ruble (RUB)</option>
            <option value="SEK">Swedish Koruna (SEK)</option>
            <option value="AUD">Australian Dollar (AUD)</option>
            <option value="CAD">Canadian Dollar (CAD)</option>
            <option value="CHF">Swiss Franc (CHF)</option>
            <option value="DKK">Danish Krone (DKK)</option>
            <option value="HKD">Hong Kong Dollar (HKD)</option>
            <option value="INR">Indian Rupee (INR)</option>
            <option value="KRW">South Korean Won (KRW)</option>
            <option value="MXN">Mexican Peso (MXN)</option>
            <option value="NOK">Norwegian Krone (NOK)</option>
            <option value="NZD">New Zealand Dollar (NZD)</option>
            <option value="SGD">Singapore Dollar (SGD)</option>
            <option value="TRY">Turkish Lira (TRY)</option>
        </select>

        <label for="fuel_price">Fuel Price:</label>
        <input type="number" step="0.01" name="fuel_price" id="fuel_price">

        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
