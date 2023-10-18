<?php
    include "../baza.class.php";
    include "../sesija.class.php";

    $baza = new Baza();
    $baza->spojiDB();
    $ses = Sesija::dajKorisnika();
    $korisnik = reset($ses);
    $res = $baza->selectDB("SELECT * FROM knjiga");
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
    
    <div id="edit-knjiga-modal" class="popup-form">
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
            <span class="close" onclick="closeEditKnjiga()">&times;</span>
            <h2>Uredi knjigu</h2>
            <form id="edit-knjiga-form" action="" method="post">
            <label for="naziv">Naziv knjige</label>
                <input type="text" id="naziv" name="naziv">
                <label for="opis">Opis knjige:</label>
                <input type="text" id="opis" name="opis">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" readonly="readonly" value="<?php echo $korisnik; ?>">
                <button type="submit" class="login-button" name="login-button">Uredi</button>
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
            <h2>Dodaj knjigu</h2>
            <form id="poduzece-form" action="" method="post">
                <label for="naziv">Naziv knjige</label>
                <input type="text" id="naziv" name="naziv">
                <label for="opis">Opis knjige:</label>
                <input type="text" id="opis" name="opis">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" readonly="readonly" value="<?php echo $korisnik; ?>">
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
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $knjiga_id = $row["Knjiga_ID"];
                            if($row["Autor"] === $korisnik) {
                                echo "<tr>";
                                echo "<td>" . $row["Knjiga_ID"] . "</td>";
                                echo "<td>" . $row["Naziv_knjige"] . "</td>";
                                echo "<td>" . $row["Opis"] . "</td>";
                                echo "<td>" . $row["Autor"] . "</td>";
                                echo "<td><button onclick='editKnjiga($knjiga_id)'>Uredi knjigu</button></td>";
                                echo "<td><button onclick='obrisiKnjigu($knjiga_id)'>Obriši knjigu</button></td>";
                                echo "</tr>";
                            }
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


    <script src="../igadzic.js"></script>
</body>
</html>

