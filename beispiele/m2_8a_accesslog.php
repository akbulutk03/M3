<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 */

$log = fopen("accesslog.txt", "a");
$entry = date("d.m.Y-H:i:s") . ", " . $_SERVER["HTTP_USER_AGENT"] . ", " . $_SERVER["REMOTE_ADDR"] . "\n";
fwrite($log, $entry);
fclose($log);
?>