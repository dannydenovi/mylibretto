<?php

// File di configurazione per la connessione al db
$username = "mylibrettoprogetto";
$password = "";
$addr = "localhost";
$database = "my_mylibrettoprogetto";

$connection = new mysqli($addr, $username, $password, $database);

if (!$connection)
    die("Errore di connessione: ".$connection->connect_error);

session_start();

/*
$del = "SELECT deleted FROM users WHERE id = " . $_SESSION['id'];
if($result = $connection->query($del))
    if($row = $result->fetch_array())
        if($row['deleted'])
            header('location: ../logout.php');*/