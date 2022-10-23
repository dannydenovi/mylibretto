<?php

use function PHPSTORM_META\sql_injection_subst;

require_once('config.php');
session_start();


if(!isset($_SESSION['id']))
    header('location: ../login.php');

if ($_POST['action'] === "getExams") {
    $sql = "SELECT * FROM exams WHERE user_id = ".$_SESSION['id']." ORDER BY exam_date DESC";

    if($result = $connection->query($sql)){
        $exams = [];
        while($row = $result->fetch_assoc()){
            $exams["exams"][] = $row;
        }
        $sql = "SELECT laude_value, total_credits FROM infos WHERE user_id = ".$_SESSION['id'];
        if($result = $connection->query($sql)){
            $row = $result->fetch_assoc();
            $exams["info"]["laude_value"] = $row["laude_value"];
            $exams["info"]["total_credits"] = $row["total_credits"];

            echo json_encode($exams);
        }

    } else {
        echo json_encode(['error' => 'Errore nel caricamento degli esami']);
    }
} else if($_POST['action'] === "setExams") {


    $sql = "SELECT laude_value FROM infos WHERE user_id = ".$_SESSION['id'];
    if($result = $connection->query($sql)){
        $row = $result->fetch_assoc();
        $laude_value = $row['laude_value'];

        $subject = $connection->real_escape_string($_POST['subject']);
        $cfu = $connection->real_escape_string($_POST['cfu']);
        $mark = $connection->real_escape_string($_POST['mark']);
        $professor = $connection->real_escape_string($_POST['professor']);
        $exam_date = $connection->real_escape_string($_POST['exam_date']);


        $error = [];

        if (!$subject)
            $error["subject"] = "Inserisci il nome dell'esame";
        if (!$cfu || !is_numeric($cfu))
            $error["cfu"] = "Inserisci il numero di CFU";
        if (!$mark || !is_numeric($mark) || $mark < 18 || $mark > $laude_value)
            $error["mark"] = "Inserisci la tua votazione";
        if (!$professor)
            $error["professor"] = "Inserisci il nome del professore";
        if (!$exam_date)
            $error["exam_date"] = "Inserisci la data dell'esame";

        if (count($error) > 0) {
            echo json_encode($error);
        } else {
            $sql = "INSERT INTO exams (user_id, subject, cfu, mark, professor, exam_date) VALUES (".$_SESSION['id'].", '$subject', '$cfu', '$mark', '$professor', '$exam_date')";

            if($connection->query($sql) === TRUE){
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Errore nell\'aggiunta dell\'esame']);
            }
        }


    }

    
} else if($_POST["action"] === "deleteExam"){
    $sql = "DELETE FROM exams WHERE id = ".$_POST['id'];
    if($connection->query($sql) === TRUE){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Errore nella cancellazione dell\'esame']);
    }
} else if ($_POST["action"] === "getSingleExam") {

    $sql = "SELECT * FROM exams WHERE id = ".$_POST['id'];
    if($result = $connection->query($sql)){
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Errore nel caricamento dell\'esame']);
    }
} else if($_POST["action"] === "editExam"){

    $sql = "SELECT laude_value FROM infos WHERE user_id = ".$_SESSION['id'];

    if($result = $connection->query($sql)){
        $row = $result->fetch_assoc();
        $laude_value = $row['laude_value'];

        $subject = $connection->real_escape_string($_POST['subject']);
        $cfu = $connection->real_escape_string($_POST['cfu']);
        $mark = $connection->real_escape_string($_POST['mark']);
        $professor = $connection->real_escape_string($_POST['professor']);
        $exam_date = $connection->real_escape_string($_POST['exam_date']);


        $error = [];

        if (!$subject)
            $error["subject"] = "Inserisci il nome dell'esame";
        if (!$cfu || !is_numeric($cfu))
            $error["cfu"] = "Inserisci il numero di CFU";
        if (!$mark || !is_numeric($mark) || $mark < 18 || $mark > $laude_value)
            $error["mark"] = "Inserisci la tua votazione";
        if (!$professor)
            $error["professor"] = "Inserisci il nome del professore";
        if (!$exam_date)
            $error["exam_date"] = "Inserisci la data dell'esame";

        if (count($error) > 0) {
            echo json_encode($error);
        } else {
            $sql = "UPDATE exams SET subject = '$subject', cfu = '$cfu', mark = '$mark', professor = '$professor', exam_date = '$exam_date' WHERE id = ".$_POST['id'];

            if($connection->query($sql) === TRUE){
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Errore nell\'aggiunta dell\'esame']);
            }
        }


    }

}
