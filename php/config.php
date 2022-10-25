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