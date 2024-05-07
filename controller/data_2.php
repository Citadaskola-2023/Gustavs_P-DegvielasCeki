<?php

use App\database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filters = array_filter($_POST);

    $params = [];
    $sql[] = <<<MySQL
        SELECT * FROM Form
        WHERE 1 = 1
    MySQL;

    if (isset($filters['idInputMin'])) {
        $sql[] = <<<MySQL
            AND id >= :id_min
    MySQL;
        $params['id_min'] = $filters['idInputMin'];
    }
    if (isset($filters['idInputMax'])) {
        $sql[] = <<<MySQL
            AND id <= :id_max
    MySQL;
        $params['id_max'] = $filters['idInputMax'];
    }
    if (isset($filters['licencePlateInput'])) {
        $sql[] = <<<MySQL
            AND licence_plate = :licence_plate
    MySQL;
        $params['licence_plate'] = $filters['licencePlateInput'];
    }
    if (isset($filters['dateTimeInputMin'])) {
        $sql[] = <<<MySQL
            AND date_time >= :dateTime_min
    MySQL;
        $params['dateTime_min'] = $filters['dateTimeInputMin'];
    }
    if (isset($filters['dateTimeInputMax'])) {
        $sql[] = <<<MySQL
            AND date_time <= :dateTime_max
    MySQL;
        $params['dateTime_max'] = $filters['dateTimeInputMax'];
    }
    if (isset($filters['petrolStationInput'])) {
    $sql[] = <<<MySQL
            AND petrol_station = :petrol_station
    MySQL;
    $params['petrol_station'] = $filters['petrolStationInput'];
    }
    if (isset($filters['fuelTypeInput'])) {
        $sql[] = <<<MySQL
            AND fuel_type = :fuel_type
    MySQL;
        $params['fuel_type'] = $filters['fuelTypeInput'];
    }
    if (isset($filters['refueledInputMin'])) {
        $sql[] = <<<MySQL
            AND refueled >= :refueled_min
    MySQL;
        $params['refueled_min'] = $filters['refueledInputMin'];
    }
    if (isset($filters['refueledInputMax'])) {
        $sql[] = <<<MySQL
            AND refueled <= :refueled_max
    MySQL;
        $params['refueled_max'] = $filters['refueledInputMax'];
    }
    if (isset($filters['currencyInput'])) {
        $sql[] = <<<MySQL
            AND currency = :currency
    MySQL;
        $params['currency'] = $filters['currencyInput'];
    }
    if (isset($filters['fuelPriceInputMin'])) {
        $sql[] = <<<MySQL
            AND fuel_price >= :fuel_price_min
    MySQL;
        $params['fuel_price_min'] = $filters['fuelPriceInputMin'];
    }
    if (isset($filters['fuelPriceInputMax'])) {
        $sql[] = <<<MySQL
            AND fuel_price <= :fuel_price_max
    MySQL;
        $params['fuel_price_max'] = $filters['fuelPriceInputMax'];
    }
    if (isset($filters['odometerInputMin'])) {
    $sql[] = <<<MySQL
            AND odometer >= :odometer_min
    MySQL;
    $params['odometer_min'] = $filters['odometerInputMin'];
    }
    if (isset($filters['odometerInputMax'])) {
    $sql[] = <<<MySQL
            AND odometer <= :odometer_max
    MySQL;
    $params['odometer_max'] = $filters['odometerInputMax'];
    }


    $query = implode("\n", $sql);

    $db = new database();
    $conn = $db->connectDB();
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll();

    echo "<style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 2px solid darkslategray;
            }
            th {
                background-color: seagreen;
                color: white;
            }
            tr:nth-child(even) {
                background-color: palegreen;
            }
            tr:hover {
                background-color: palegoldenrod;
            }
            .total-column {
                color: darkorange;
                font-weight: bold;
            }
          </style>";

    echo "<table>";
    echo "<tr>
        <th>ID</th>
        <th>Licence Plate</th>
        <th>Date and Time</th>
        <th>Petrol Station</th>
        <th>Fuel Type</th>
        <th>Refueled (Litres)</th>
        <th>Currency</th>
        <th>Fuel Price</th>
        <th>Odometer</th>
        <th class='total-column'>Total</th>
</tr>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['licence_plate'] . "</td>";
        echo "<td>" . $row['date_time'] . "</td>";
        echo "<td>" . $row['petrol_station'] . "</td>";
        echo "<td>" . $row['fuel_type'] . "</td>";
        echo "<td>" . $row['refueled'] . "</td>";
        echo "<td>" . $row['currency'] . "</td>";
        echo "<td>" . $row['fuel_price'] . "</td>";
        echo "<td>" . $row['odometer'] . "</td>";
        echo "<td class='total-column'>" . $row['total'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    die();
    //
}
