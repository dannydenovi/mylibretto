<?php

require_once('config.php');
session_start();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method){
    case "GET":
        getTaxes();
        break;

    case "POST":
        addTax();
        break;

    case "PUT":
        updateTax();
        break;

    case "DELETE":
        deleteTax();
        break;

    default:
        echo json_encode(['error' => 'Metodo non valido']);
        break;
}


function getTaxes(){
    global $connection;
    $sql = "SELECT * FROM taxes WHERE user_id = ".$_SESSION['id'];
    if ($_GET["id"])
        $sql .=  " AND tax_id = " . $_GET["id"];
    
    $sql .= " ORDER BY date DESC";

    if($result = $connection->query($sql)){
        $taxes = [];
        while($row = $result->fetch_assoc()){
            $taxes["taxes"][] = $row;
        }
        echo json_encode($taxes);
    } else {
        echo json_encode(['error' => 'Errore nel caricamento delle imposte']);
    }
}

function addTax(){
    global $connection;
    $taxName = $connection->real_escape_string($_POST['tax_name']);
    $date = $connection->real_escape_string($_POST["tax_date"]);
    $amount = $connection->real_escape_string($_POST["tax_amount"]);
    $paid = $connection->real_escape_string($_POST["tax_paid"]);


    $error = [];
    
    if(!$taxName)
        $error["tax_name"] = "Inserisci il nome dell'imposta";
    if(!$date)
        $error["tax_date"] = "Inserisci la data dell'imposta";
    if(!$amount || !is_numeric($amount) || $amount < 0)
        $error["tax_amount"] = "Inserisci l'importo dell'imposta";
    if($paid != "0" && $paid != "1")
        $error["tax_paid"] = "Inserisci l'importo pagato";
    
    if(count($error) > 0){
        echo json_encode($error);
    } else {
        $sql = "INSERT INTO taxes (user_id, name, date, amount, paid) VALUES (".$_SESSION['id'].", '$taxName', '$date', '$amount', '$paid')";
        if($connection->query($sql)){
            echo json_encode(['success' => 'Imposta aggiunta con successo']);
        } else {
            echo json_encode(['error' => 'Errore nell\'aggiunta dell\'imposta']);
        }
    }
}

function updateTax() {
    global $connection;
    parse_str(file_get_contents('php://input'), $_PUT);
    $id = $connection->real_escape_string($_PUT["id"]);
    $taxName = $connection->real_escape_string($_PUT['tax_name']);
    $date = $connection->real_escape_string($_PUT["tax_date"]);
    $amount = $connection->real_escape_string($_PUT["tax_amount"]);
    $paid = $connection->real_escape_string($_PUT["tax_paid"]);

    $error = [];

    if(!$taxName)
        $error["tax_name"] = "Inserisci il nome dell'imposta";
    if(!$date)
        $error["tax_date"] = "Inserisci la data dell'imposta";
    if(!$amount || !is_numeric($amount) || $amount < 0)
        $error["tax_amount"] = "Inserisci l'importo dell'imposta";
    if($paid != "0" && $paid != "1")
        $error["tax_paid"] = "Inserisci l'importo pagato";

    if(count($error) > 0){
        echo json_encode($error);
    } else {
        $sql = "UPDATE taxes SET name = '$taxName', date = '$date', amount = '$amount', paid = '$paid' WHERE tax_id = $id";
        if($connection->query($sql)){
            echo json_encode(['success' => 'Imposta modificata con successo']);
        } else {
            echo json_encode(['error' => 'Errore nella modifica dell\'imposta']);
        }
    }
}

function deleteTax(){
    global $connection;
    parse_str(file_get_contents('php://input'), $_DELETE);
    $id = $connection->real_escape_string($_DELETE["id"]);
    $sql = "DELETE FROM taxes WHERE tax_id = $id";
    if($connection->query($sql)){
        echo json_encode(['success' => 'Imposta eliminata con successo']);
    } else {
        echo json_encode(['error' => 'Errore nell\'eliminazione dell\'imposta']);
    }
}

$connection->close();