<?php

namespace App;

require __DIR__ . '/../src/database.php';

class fuelReceiptRequest
{
    public string $idInputMin;
    public string $idInputMax;
    public string $licencePlateInput;
    public string $dateTimeInputMin;
    public string $dateTimeInputMax;
    public string $petrolStationInput;
    public string $fuelTypeInput;
    public string $refueledInputMin;
    public string $refueledInputMax;
    public string $totalInputMin;
    public string $totalInputMax;
    public string $currencyInput;
    public string $fuelPriceInputMin;
    public string $fuelPriceInputMax;
    public string $odometerInputMin;
    public string $odometerInputMax;

    public function getSearchInputs(): void
    {
        $this->idInputMin = $_POST['idInputMin'];
        $this->idInputMax = $_POST['idInputMax'];
        $this->licencePlateInput = $_POST['licencePlateInput'];
        $this->dateTimeInputMin = $_POST['dateTimeInputMin'];
        $this->dateTimeInputMax = $_POST['dateTimeInputMax'];
        $this->petrolStationInput = $_POST['petrolStationInput'];
        $this->fuelTypeInput = $_POST['fuelTypeInput'];
        $this->refueledInputMin = $_POST['refueledInputMin'];
        $this->refueledInputMax = $_POST['refueledInputMax'];
        $this->totalInputMin = $_POST['totalInputMin'];
        $this->totalInputMax = $_POST['totalInputMax'];
        $this->currencyInput = $_POST['currencyInput'];
        $this->fuelPriceInputMin = $_POST['fuelPriceInputMin'];
        $this->fuelPriceInputMax = $_POST['fuelPriceInputMax'];
        $this->odometerInputMin = $_POST['odometerInputMin'];
        $this->odometerInputMax = $_POST['odometerInputMax'];
    }

    public function requestData(): void
    {
        //check
        $query = parse_url($_SERVER['REQUEST_URI'])['query'];
        $query = urldecode($query);
        if (empty($query)) {
            $query = 'SELECT * FROM Form';
        }

        //ASC or DESC
        $dom = new \DOMDocument();
        $dom->loadHTMLFile('../html/receiptData.html');
        $anchors = $dom->getElementsByTagName('a');

        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            $modifiedHref = '';
            if (stripos($href, 'ASC')) {
                $modifiedHref = str_replace("ASC", "DESC", $href);
            } else {
                if (stripos($href, 'DESC')) {
                    $modifiedHref = str_replace("DESC", "ASC", $href);
                }
            }
            $anchor->setAttribute('href', $modifiedHref);
        }

        file_put_contents('../html/receiptData.html', $dom->saveHTML());

        $bannedWords = ['DROP', 'INSERT'];

        foreach ($bannedWords as $bw) {
            if (stristr($query, $bw)) {
                echo "<script>window.location.replace('/')</script>";
                exit;
            }
        }

        //connection
        $db = new database();
        $conn = $db->connectDB();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();

        //data table
        if (!empty($results)) {
            echo '<table>';
            foreach ($results as $row) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>' . htmlspecialchars($value) . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No results found.';
        }
    }
}

