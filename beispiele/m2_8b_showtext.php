<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 */

$suchwort = '';
if(!empty($_GET['suchwort'])) {
    $suchwort = $_GET['suchwort'];
}

$en_txt = fopen("en.txt", "r");
$en_php = [];

while($line = fgets($en_txt)) {
    $parts = explode(";", $line);
    $de = $parts[0];
    $en = $parts[1];
    $en_php[$de] = $en;
}

fclose($en_txt);

$found = false;
if ($suchwort !== '') {
    foreach ($en_php as $de => $en) {
        if(stripos($de, $suchwort) !== false) {
            echo "Übersetzung von " . $de . ": " . $en;
            $found = true;
        } elseif (stripos($en, $suchwort) !== false) {
            echo "Übersetzung von " . $en . ": " . $de;
            $found = true;
        }
    }
    if (!$found) {
        echo "Das gesuchte Wort " . $suchwort . " ist nicht enthalten.";
    }
}
?>
<form method="get">
    <label for="suchwort">Suche:</label>
    <input id="suchwort" type="text" name="suchwort" value="<?php echo $suchwort?>">
    <input type="submit" value="Suchen">
</form>
