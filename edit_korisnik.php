<?php
// Include base.php to access the updateDatabase function
include 'baza.class.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $baza=new Baza();
    $baza->spojiDB();

    // Get the parameters from the AJAX request
    $id = $_POST["id"];
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $uloga = $_POST["uloga"];
    $blokiran = $_POST["blokiran"];

    $updateKorisnika = "UPDATE korisnik SET Ime = '$ime', Prezime = '$prezime', Email = '$email', Korisnicko_ime = '$username', Korisnicka_uloga = '$uloga', Blokiran = '$blokiran' WHERE Korisnik_ID = $id";

    // Call the updateDatabase function with the parameters
    $rezultat = $baza->updateDB($updateKorisnika);

    }
?>
