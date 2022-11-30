<?php

require_once("config.php");
session_start();

$method = $_SERVER['REQUEST_METHOD'];


switch ($method){
    case "GET":
        getClass();
        break;

    case "POST":
        addClass();
        break;

    case "PUT":
        updateClass();
        break;

    case "DELETE":
        deleteClass();
        break;

    default:
        echo json_encode(['error' => 'Metodo non valido']);
        break;
}



function getClass(){
    global $connection;
    $sql = "SELECT * FROM classes WHERE user_id = ".$_SESSION["id"];

    if($_GET["id"])
        $sql .= " AND class_id = ".$_GET["id"];
    
    $result = $connection->query($sql);
    $classes = array();
    while($row = $result->fetch_assoc()){
        $classes[] = $row;
    }
    echo json_encode($classes);
}


function addClass(){
    global $connection;
    $name = $connection->real_escape_string($_POST["name"]);
    $professor = $connection->real_escape_string($_POST["professor"]);
    $day = $connection->real_escape_string($_POST["day"]);
    $timeStart = $connection->real_escape_string($_POST["timeStart"]);
    $timeEnd = $connection->real_escape_string($_POST["timeEnd"]);
    $place = $connection->real_escape_string($_POST["place"]);

    $error = [];

    if(!$name){
        $error["subject"] = "Nome non valido";
    }
    if(!$professor){
        $error["professor"] = "Professore non valido";
    }
    if(!$day || $day != "Monday" && $day != "Tuesday" && $day != "Wednesday" && $day != "Thursday" && $day != "Friday" && $day != "Saturday"){
        $error["weekday"] = "Giorno non valido";
    }
    if(!$timeStart || $timeStart > $timeEnd){
        $error["timeStart"] = "Ora di inizio non valida";
    }
    if(!$timeEnd || $timeEnd < $timeStart){
        $error["timeEnd"] = "Ora di fine non valida";
    }
    if(!$place){
        $error["place"] = "Aula non valida";
    }

    if($error) {
        echo json_encode($error);
    } else {
        $sql = "INSERT INTO classes (name, professor, day, timeStart, timeEnd, place, user_id) VALUES ('$name', '$professor', '$day', '$timeStart', '$timeEnd', '$place', ".$_SESSION["id"].")";
        $result = $connection->query($sql);
        if($result){
            echo json_encode(["success" => "Classe aggiunta con successo"]);
        } else {
            echo json_encode("Errore: ".$connection->error);
        }
    }
}

function updateClass(){
    global $connection;
    parse_str(file_get_contents('php://input'), $_PUT);
    $id = $connection->real_escape_string($_PUT["id"]);
    $name = $connection->real_escape_string($_PUT["name"]);
    $professor = $connection->real_escape_string($_PUT["professor"]);
    $day = $connection->real_escape_string($_PUT["day"]);
    $timeStart = $connection->real_escape_string($_PUT["timeStart"]);
    $timeEnd = $connection->real_escape_string($_PUT["timeEnd"]);
    $place = $connection->real_escape_string($_PUT["place"]);

    $error = [];

    if(!$name){
        $error["subject"] = "Nome non valido";
    }
    if(!$professor){
        $error["professor"] = "Professore non valido";
    }
    if(!$day || $day != "Monday" && $day != "Tuesday" && $day != "Wednesday" && $day != "Thursday" && $day != "Friday" && $day != "Saturday"){
        $error["weekday"] = "Giorno non valido";
    }
    if(!$timeStart || $timeStart > $timeEnd){
        $error["timeStart"] = "Ora di inizio non valida";
    }
    if(!$timeEnd || $timeEnd < $timeStart){
        $error["timeEnd"] = "Ora di fine non valida";
    }
    if(!$place){
        $error["place"] = "Aula non valida";
    }

    if($error) {
        echo json_encode($error);
    } else {
        $sql = "UPDATE classes SET name = '$name', professor = '$professor', day = '$day', timeStart = '$timeStart', timeEnd = '$timeEnd', place = '$place' WHERE class_id = $id";
        $result = $connection->query($sql);
        if($result){
            echo json_encode(["success" => "Classe modificata con successo"]);
        } else {
            echo json_encode("Errore: ".$connection->error);
        }
    }
}

function deleteClass(){
    global $connection;
    parse_str(file_get_contents('php://input'), $_DELETE);
    $id = $connection->real_escape_string($_DELETE["id"]);
    $sql = "DELETE FROM classes WHERE class_id = $id";
    $result = $connection->query($sql);

    if($result){
        echo json_encode(["success" => "Classe eliminata con successo"]);
    } else {
        echo json_encode("Errore: ".$connection->error);
    }
}

$connection->close();