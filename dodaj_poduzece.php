<?php
// Include base.php to access the updateDatabase function
include 'baza.class.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $baza=new Baza();
    $baza->spojiDB();

    // Get the parameters from the AJAX request
    $naziv = $_POST["naziv"];
    $opis = $_POST["opis"];
    $autor = $_POST["autor"];

    $updatePoduzeca = "INSERT INTO `knjiga` (`Naziv_knjige`, `Opis`, `Autor`) VALUES ('{$naziv}','{$opis}','{$autor}')";

    $rezultat = $baza->updateDB($updatePoduzeca);

    }
?>
