<?php

require_once('config.php');
session_start();


if(!isset($_SESSION['id']))
    header('location: ../login.php');

if ($_POST['action'] === "getExams") {
    $sql = "SELECT * FROM exams WHERE user_id = ".$_SESSION['id']." ORDER BY exam_date DESC";

    if($result = $connection->query($sql)){
        $exams = [];
        while($row = $result->fetch_assoc()){
            $exams[] = $row;
        }
        echo json_encode($exams);
    } else {
        echo json_encode(['error' => 'Errore nel caricamento degli esami']);
    }
} else if($_POST['action'] === "setExams") {
    $sql = "INSERT INTO exams (user_id, subject, cfu, mark, professor, exam_date) 
            VALUES (".$_SESSION['id'].", '".$_POST['subject']."', '".$_POST['cfu']."', '".$_POST['mark']."', '".$_POST['professor']."','".$_POST['exam_date']."')";
    if($result = $connection->query($sql)){
        echo json_encode(['success' => 'Esame aggiunto con successo']);
    } else {
        echo json_encode(['error' => 'Errore nell\'aggiunta dell\'esame']);
    }
}
