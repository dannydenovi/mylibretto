<?php

require_once("config.php");
session_start();

if($_POST["action"] === "getClasses"){
    $sql = "SELECT * FROM classes WHERE user_id = ".$_SESSION["id"];
    $result = $connection->query($sql);
    $classes = array();
    while($row = $result->fetch_assoc()){
        $classes[] = $row;
    }
    echo json_encode($classes);
}

else if($_POST["action"] === "setClass"){

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
else if($_POST["action"] === "deleteClass"){
    $id = $connection->real_escape_string($_POST["id"]);
    $sql = "DELETE FROM classes WHERE class_id = $id";
    $result = $connection->query($sql);
    if($result){
        echo json_encode(["success" => "Classe eliminata con successo"]);
    } else {
        echo json_encode("Errore: ".$connection->error);
    }
}
else if($_POST["action"] === "getClass"){
    $sql = "SELECT * FROM classes WHERE class_id = ".$_POST["id"];
    $result = $connection->query($sql);
    $class = $result->fetch_assoc();
    echo json_encode($class);
}
else if($_POST["action"] === "editClass"){
    $id = $connection->real_escape_string($_POST["id"]);
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
        $sql = "UPDATE classes SET name = '$name', professor = '$professor', day = '$day', timeStart = '$timeStart', timeEnd = '$timeEnd', place = '$place' WHERE class_id = $id";
        $result = $connection->query($sql);
        if($result){
            echo json_encode(["success" => "Classe modificata con successo"]);
        } else {
            echo json_encode("Errore: ".$connection->error);
        }
    }
}