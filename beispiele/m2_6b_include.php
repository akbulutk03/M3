<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 */

include ('m2_6a_standardparameter.php');

$a = 3;
$b = 4;
$c = 7;

$sum = addieren($a, $b);
echo $sum . "<br>";
$sum = addieren($a, $c);
echo $sum . "<br>";
$sum = addieren($c);
echo $sum . "<br>";
?>