<?php

$link = mysqli_connect("localhost", "root", "toor", "emensawerbeseite");
if (!$link) {
    echo "Fehler beim Verbinden des MySQL-Datenbanks!", mysqli_connect_error();
    exit;
}
