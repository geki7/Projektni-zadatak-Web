<?php
// Include base.php to access the updateDatabase function
include 'baza.class.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $baza=new Baza();
    $baza->spojiDB();

    // Get the parameters from the AJAX request
    $knjiga_id = $_POST["knjiga_id"];


    $updateKnjiga = "DELETE FROM knjiga WHERE Knjiga_ID = $knjiga_id";

    // Call the updateDatabase function with the parameters
    $rezultat = $baza->updateDB($updateKnjiga);

    }
?>
