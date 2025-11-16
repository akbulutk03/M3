<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 **/
$beispiel1 = "Hallo Welt";
$neu1 = str_replace("Welt", "Kawa", $beispiel1);
echo $neu1;
echo "<br>";
echo str_repeat("Hallo", 4);
echo "<br>";
echo substr($beispiel1,0,5);
echo "<br>";
$trimbeispiel1 = "        Hallo Welt     ";
echo "[" . trim($trimbeispiel1) . "]";      // Punkt gilt als String Konkatenationsoperator --> aneinanderhängen von zeichenketten
echo "<br>";
echo "[" . ltrim($trimbeispiel1) . "]";
echo "<br>";
echo "[" . rtrim($trimbeispiel1) . "]";