<?php
// Include base.php to access the updateDatabase function
include 'baza.class.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $baza=new Baza();
    $baza->spojiDB();

    // Get the parameters from the AJAX request
    $knjiga_id = $_POST["knjiga_id"];
    $naziv = $_POST["naziv"];
    $opis = $_POST["opis"];
    $autor = $_POST["autor"];


    $updateKnjiga = "UPDATE knjiga SET Naziv_knjige = '$naziv', Opis = '$opis', Autor = '$autor' WHERE Knjiga_ID = $knjiga_id";

    // Call the updateDatabase function with the parameters
    $rezultat = $baza->updateDB($updateKnjiga);

    }
?>
