<?php
    include "../baza.class.php";
    include "../sesija.class.php";

    $baza = new Baza();
    $baza->spojiDB();
    $res = $baza->selectDB("SELECT * FROM knjiga");
    $resModeratori = $baza->selectDB("SELECT * FROM korisnik");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/igadzic.css">
    <title>Moj posao</title>
</head>
<body style="background-image: url('../Materijali/pozadina.png'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">

    <nav class="navbar">
        <ul class="nav-links">
            <li>
                <form id="logoutForm" action="../odjava.php" method="post">
                    <button type="submit">Odjavi me</button>
                </form>
            </li>
        </ul>
    </nav>

    <div id="edit-korisnik-modal" class="popup-form">
        <div class="form-container">
            <span class="close" onclick="closeEditKorisnik()">&times;</span>
            <h2>Uredi korisnika</h2>
            <form id="edit-korisnik-form" action="" method="post">
                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime">
                <label for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" >
                <label for="email">Email</label>
                <input type="email" id="email" name="email" >
                <label for="username">Korisnicko ime:</label>
                <input type="text" id="username" name="username" >
                <label for="uloga">Uloga:</label>
                <select name="uloga">
                    <option value="0">Admin</option>
                    <option value="1">Moderator</option>
                </select>
                <label for="blokiran">Blokiran:</label>
                <select name="blokiran">
                    <option value="1">Da</option>
                    <option value="0">Ne</option>
                </select>
                <button type="submit" id="registriraj" name="submit_btn" value="registriraj" class="register-button">Uredi</button>
            </form>
        </div>
    </div>


    <div id="poduzece-modal" class="popup-form">
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
        <div class="form-container">
            <span class="close" onclick="closeDodajPoduzece()">&times;</span>
            <h2>Dodaj poduzece</h2>
            <form id="poduzece-form" action="" method="post">
                <label for="naziv">Naziv knjige</label>
                <input type="text" id="naziv" name="naziv">
                <label for="opis">Opis knjige:</label>
                <input type="text" id="opis" name="opis">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor">
                <button type="submit" class="login-button" name="login-button">Dodaj knjigu</button>
            </form>
        </div>
    </div>

        <div class="container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Šifra knjige</th>
                        <th>Naziv knjige</th>
                        <th>Opis knjige</th>
                        <th>Autor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $knjiga_id = $row["Knjiga_ID"];
                            echo "<tr>";
                            echo "<td>" . $row["Knjiga_ID"] . "</td>";
                            echo "<td>" . $row["Naziv_knjige"] . "</td>";
                            echo "<td>" . $row["Opis"] . "</td>";
                            echo "<td>" . $row["Autor"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>Nema aktivnih poduzeća!</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        <div class="buttons">
            <button class="edit-button" onclick="dodajKnjigu()">Kreriraj knjigu</button>
        </div>

        <h2 style="color: white;">Korisnici</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Opis</th>
                    <th>Email</th>
                    <th>Korisnicko ime</th>
                    <th>Korisnicka uloga</th>
                    <th>Blokiran</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($res->num_rows > 0) {
                    while ($row = $resModeratori->fetch_assoc()) {
                        $modId = $row["Korisnik_ID"];
                        echo "<tr>";
                        echo "<td>" . $row["Korisnik_ID"] . "</td>";
                        echo "<td>" . $row["Ime"] . "</td>";
                        echo "<td>" . $row["Prezime"] . "</td>";
                        echo "<td>" . $row["Email"] . "</td>";
                        echo "<td>" . $row["Korisnicko_ime"] . "</td>";
                        echo "<td>" . $row["Korisnicka_uloga"] . "</td>";
                        echo "<td>" . $row["Blokiran"] . "</td>";
                        echo "<td><button onclick='editKorisnik($modId)'>Uredi</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Nema aktivnih poduzeća!</td></tr>";
                }
                ?>
            </tbody>
        </table>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../igadzic.js"></script>
</body>
</html>

