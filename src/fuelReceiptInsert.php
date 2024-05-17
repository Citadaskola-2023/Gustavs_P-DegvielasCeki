<?php


namespace App;

use DateTime, DateTimeZone;

require __DIR__ . '/../src/database.php';

class fuelReceiptInsert
{
    public function getFormInput(): array
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
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
            if (! is_string($data['licence_plate'])) {
                die('Lincence plate does not match input type!');
            }
            if (! is_string($data['petrol_station'])) {
                die('Petrol station does not match input type!');
            }
            if (! preg_match("/^[0-9]+$/",$data['odometer'])) {
                die('Odometer does not match input type!');
            }

            $DateTime_local = new DateTime($data['date_time'], new DateTimeZone(date_default_timezone_get()));
            $DateTime_local->setTimezone(new DateTimeZone('UTC'));
            $DateTime_universal = $DateTime_local->format('Y-m-d\TH:i');
            $data['date_time'] = $DateTime_universal;;

            return $data;
        }
        die("<h3> Could not get form input data </h3>");
    }

    public function uploadFuelReceipt(array $data): void
    {
        $DB = new database();
        $conn = $DB->connectDB();
        $stmt = $conn->prepare(
            "INSERT INTO Form(licence_plate, date_time,
         petrol_station, fuel_type, refueled, currency, fuel_price, odometer, total)
         VALUES(:licence_plate, :date_time, :petrol_station, :fuel_type, :refueled, :currency, :fuel_price, :odometer, :total)"
        );
        $stmt->execute($data);
    }
}