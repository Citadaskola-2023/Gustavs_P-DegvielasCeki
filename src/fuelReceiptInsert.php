<?php


namespace App;

require __DIR__ . '/../src/database.php';

class fuelReceiptInsert
{
    public function getFormInput(): array
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return [
                'licence_plate' => $_POST['license_plate'],
                'date_time' => $_POST['date_time'],
                'petrol_station' => $_POST['petrol_station'],
                'fuel_type' => $_POST['fuel_type'],
                'refueled' => $_POST['refueled'],
                'currency' => $_POST['currency'],
                'fuel_price' => $_POST['fuel_price'],
                'odometer' => $_POST['odometer'],
                'total' => $_POST['fuel_price'] * $_POST['refueled'],
            ];
        }
        die("<h3> Could not get form input data </h3>");
    }

    public function uploadFuelReceipt(array $data): void
    {
        $DB = new DB();
        $conn = $DB->connectDB();
        $stmt = $conn->prepare(
            "INSERT INTO Form(licence_plate, date_time,
         petrol_station, fuel_type, refueled, currency, fuel_price, odometer, total)
         VALUES(:licence_plate, :date_time, :petrol_station, :fuel_type, :refueled, :currency, :fuel_price, :odometer, :total)"
        );
        $stmt->execute($data);
    }
}