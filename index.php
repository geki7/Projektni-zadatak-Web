<?php

include "baza.class.php";
include "sesija.class.php";

$baza=new Baza();
$baza->spojiDB();

//prijava
if(isset($_GET['login-button'])){

    $greska_polje="";
    $poruka_prijava = "";
    $korime=$_GET['username'];
    $lozinka=$_GET['password'];
    
    $upit="SELECT * FROM `korisnik` WHERE Korisnicko_ime='{$korime}'";
    $rezultat=$baza->selectDB($upit);

    if(mysqli_num_rows($rezultat)>0) {
        $sol="sha256kript";
        $kriptirano=$lozinka.$sol;
        $nova_lozinka=sha1($kriptirano);

        while($red=mysqli_fetch_assoc($rezultat)){
            $korisnicko_ime=$red['Korisnicko_ime'];
            $sifra=$red['Lozinka_Sha256'];
            $uloga=$red['Korisnicka_uloga'];
            $id = $red['Korisnik_ID'];
            $blokiran = $red['Blokiran'];
        }

        if($nova_lozinka != $sifra) {
            $poruka_prijava ="Lozinka za username '" . $korime . "' nije ispravna.";
        }

        if($blokiran == 1) {
            $poruka_prijava = "Korisnik '" . $korime . "' je trenutno blokiran. Javite se administratoru";
        }
    } else {
        $greska_polje="Ne postoji korisnik sa username '" . $korime . "'.";
    } 

    if(empty($greska_polje) && empty($poruka_prijava)){
        Sesija::kreirajSesiju();
        Sesija::kreirajKorisnika($id, $korisnicko_ime, $natjecaj_id, $uloga);
        if($uloga == 0) {
            header('Location: Pages/admin.php');
        } elseif ($uloga == 1) {
            header('Location: Pages/moderator.php');
        } 
    }
}
//registracija 
if (isset($_POST['submit_btn'])) {

    $greska_polje="";
    $poruka = "";
    $email_greska = "";
    $lozinka_greska = "";
    $potvrda_lozinka_greska="";
    $email_postoji_greska="";

    $ime = $_POST['firstName'];
    $prezime = $_POST['lastName'];
    $email = $_POST['email'];
    $korime = $_POST['newUsername'];
    $lozinka = $_POST['newPassword'];
    $potvrda_lozinka = $_POST['repPassword'];

    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            $poruka .= "Nije upisano " . $key . "<br>";
            $greska_polje.="Nije prazno";
        } elseif ($key == "email") {

            $upit="SELECT * FROM `korisnik` WHERE Email='{$email}'";

            $rezultat=$baza->selectDB($upit);

            if(mysqli_num_rows($rezultat)>0){
                $email_postoji_greska="Email već postoji";
                $greska_polje.="Nije prazno";
            }
            $regex = "/^[A-Za-z0-9._]{1,64}@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*\.(info|hr|com)$/";

            if (!preg_match($regex, $email)) {
                $email_greska = "Neispravan format emaila";
                $greska_polje.="Nije prazno";
            }
        } elseif ($key == "lozinka") {

            function pregled_lozinke($lozinka)
            {
                $mala_slova = false;
                $velika_slova = false;
                $brojevi = false;
                $razmak=true;
                $duljina_lozinke=false;
               
                if(strlen($lozinka)>=15 && strlen($lozinka)<=25){
                    $duljina_lozinke=true;
                }
                for ($i = 0; $i < strlen($lozinka); $i++) {
                    $znak = $lozinka[$i];
                    if (ctype_lower($znak)) {
                        $mala_slova = true;
                    } elseif (ctype_upper($znak)) {
                        $velika_slova = true;
                    } elseif (ctype_digit($znak)) {
                        $brojevi = true;
                    }
                    elseif(strpos($lozinka,' ')==true){
                        $razmak=false;
                    }   
                }
                return $mala_slova && $velika_slova && $brojevi && $razmak && $duljina_lozinke;
            }
            if (!pregled_lozinke($lozinka)) {
                $lozinka_greska = "Lozinka nije u dobrom formatu";
                $greska_polje.="Nije prazno";
            }
        }
        elseif($key=="potvrda_lozinke"){
            if($lozinka!=$potvrda_lozinka){
                $potvrda_lozinka_greska="Lozinke nisu iste";
                $greska_polje.="Nije prazno";
            }
        }
    }

    if(empty($greska_polje)){
        $sol="sha256kript";
        $kriptirano=$lozinka.$sol;
        $nova_lozinka=sha1($kriptirano);

        $upit="INSERT INTO `korisnik`(`Ime`, `Prezime`, `Email`, `Korisnicko_ime`, 
        `Lozinka`, `Lozinka_Sha256`, `Korisnicka_uloga`) VALUES ('{$ime}','{$prezime}','{$email}',
        '{$korime}','{$lozinka}','{$nova_lozinka}', '2')";
        $rezultat=$baza->updateDB($upit);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/igadzic.css">
    <title>Digitalna knjižnica</title>
</head>
<body style="background-image: url('Materijali/pozadina.png'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">

    <div class="container">
    <?php
        if (isset($poruka_prijava)) {
            echo "$poruka_prijava";
            echo "<br>";
        }

        if (isset($greska_polje)) {
            echo "$greska_polje";
            echo "<br>";
        }
    ?>
        <div class="buttons">
            <button class="login-button" onclick="openLoginForm()">Prijavi se</button>
            <button class="register-button" onclick="openRegistrationForm()">Registriraj se</button>
        </div>
    </div>

    <div id="loginForm" class="popup-form">
    
        <div class="form-container">
            <span class="close" onclick="closeLoginForm()">&times;</span>
            <h2>Prijava</h2>
            <form action="" method="get">
                <label for="username">Korisničko ime:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Šifra:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" class="login-button" name="login-button">Prijavi se</button>
            </form>
        </div>
    </div>

    <div id="registrationForm" class="popup-form">
        <?php
            if (isset($poruka)) {
                echo "$poruka";
                echo "<br>";
            }
            if (isset($email_greska)) {
                echo "$email_greska";
                echo "<br>";
            }
            if (isset($lozinka_greska)) {
                echo "$lozinka_greska";
            }
            echo "<br>";
            if (isset($potvrda_lozinka_greska)) {
                echo "$potvrda_lozinka_greska";
            }
            echo "<br>";
            if (isset($email_postoji_greska)) {
                echo "$email_postoji_greska";
            }
            echo "<br>";
        ?>
        <div class="form-container">
            <span class="close" onclick="closeRegistrationForm()">&times;</span>
            <h2>Registracija</h2>
            <form action="" method="post">
                <label for="firstName">Ime:</label>
                <input type="text" id="firstName" name="firstName">
                <label for="lastName">Prezime:</label>
                <input type="text" id="lastName" name="lastName" >
                <label for="dateOfBirth">Datum rođenja:</label>
                <input type="date" id="dateOfBirth" name="dateOfBirth" >
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" >
                <label for="newUsername">Korisničko ime:</label>
                <input type="text" id="newUsername" name="newUsername" >
                <label for="newPassword">Šifra:</label>
                <input type="password" id="newPassword" name="newPassword" >
                <label for="repPassword">Ponovi šifru:</label>
                <input type="password" id="repPassword" name="repPassword" >
                <button type="submit" id="registriraj" name="submit_btn" value="registriraj" class="register-button">Registracija</button>
            </form>
        </div>
    </div>

    <script src="igadzic.js"></script>
</body>
</html>