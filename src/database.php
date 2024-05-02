<?php

namespace App;
use PDO;
use PDOException;
class DB
{
    public function connectDB() : PDO{
        try{ //mēģina ielogoties iekšā
            $pdo = new PDO('mysql:host=mysql;dbname=myapp;',
                'root',
                'root',
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            $this->tableCheck($pdo); // pārbauda vai eksistē data table
            return $pdo;
        }
        catch (PDOException $e){
            echo $e->getCode() . " " . $e->getMessage() . '<br>';
            die("Something went wrong...");
        }
    }
    public function login(string $username, string $password) : void{
        if($username === 'gusha' && $password === 'dusha'){
            header("Location: /ceks?"); //lai aizietu uz receipt
            exit;
        }
        else{
            echo "<h3> YOU HAVE ENTERED THE WRONG USERNAME OR PASSWORD, PLEASE TRY AGAIN!"; //ja nav ievadīti pareizi dati
        }
    }

    private function tableCheck(PDO $pdo) : void{ //Izveido DB
        $tableSQL = 'SHOW TABLES LIKE "Form"';
        $tableResult = $pdo->query($tableSQL);

        if($tableResult->rowCount() == 0){
            $pdo->exec("CREATE TABLE Form (
            id INT AUTO_INCREMENT PRIMARY KEY,
            licence_plate VARCHAR(20) NOT NULL,
            date_time DATETIME NOT NULL,
            petrol_station VARCHAR(100) NOT NULL,
            fuel_type VARCHAR(32) NOT NULL,
            refueled DECIMAL(10,2) NOT NULL,
            currency CHAR(3) NOT NULL,
            fuel_price DECIMAL(10,4) NOT NULL,
            odometer INT NOT NULL,
            total DECIMAL(10,2) NOT NULL
        )");
        }
    }
}
