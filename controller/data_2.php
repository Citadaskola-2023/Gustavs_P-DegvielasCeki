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
