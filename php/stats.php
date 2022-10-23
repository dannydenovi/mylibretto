<?php

require_once('config.php');
session_start();

if ($_POST["action"] === "cfu") {
    $sql = "SELECT SUM(cfu) AS cfu FROM exams WHERE user_id = " . $_SESSION['id'];

    if ($result = $connection->query($sql)) {
        $row = $result->fetch_assoc();
        $cfu["cfu"] = $row["cfu"];
        $sql = "SELECT total_credits FROM infos WHERE user_id = " . $_SESSION['id'];
        if ($result = $connection->query($sql)) {
            $row = $result->fetch_assoc();
            $cfu["total_credits"] = $row["total_credits"];

            echo json_encode($cfu);
        } else {
            echo json_encode(['error' => 'Errore nel caricamento dei CFU']);
        }
    } else {
        echo json_encode(['error' => 'Errore nel caricamento dei CFU']);
    }
} else if ($_POST["action"] === "averages") {
    $sql = "SELECT cfu, mark, exam_date FROM exams WHERE user_id = " . $_SESSION['id'] ." ORDER BY exam_date ASC";

    if ($result = $connection->query($sql)) {
        $exams = [];
        while ($row = $result->fetch_assoc()) {
            $exams["exams"][] = $row;
        }

       echo json_encode($exams);
    } else {
        echo json_encode(['error' => 'Errore nel caricamento delle medie']);
    }
}
