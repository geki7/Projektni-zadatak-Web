<?php

include "../sesija.class.php";

if(isset($_SESSION)){
    Sesija::obrisiSesiju();
    session_write_close();


}

header("Location: index.php");

?>