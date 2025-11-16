<?php


$link = mysqli_connect("localhost", "root", "toor", "emensawerbeseite");
if (!$link) {
    echo "Fehler beim Verbinden des MySQL-Datenbanks!", mysqli_connect_error();
    exit;
}
else{
    echo "Verbindung erfolgreich";
}


$sql = "SELECT * FROM gericht;";
$result = mysqli_query($link, $sql);
    if(!$result) {
        echo "Fehler bei der SQL-Abfrage";
    }

echo "<table border='1px solid black'>";
echo "<th>ID</th>";     // man hätte auch einen header definieren können und dann eine foreach --> <th> $h . </th>
echo "<th>Name</th>";
echo "<th>Beschreibung</th>";
echo "<th>erfasst_am</th>";
echo "<th>vegetarisch</th>";
echo "<th>vegan</th>";
echo "<th>preis_intern</th>";
echo "<th>preis_extern</th>";
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>"
    . "<td>" . $row['name'] . "</td>"
        . "<td>" . $row['beschreibung'] . "</td>"
        . "<td>" . $row['erfasst_am'] . "</td>"
        . "<td>" . $row['vegetarisch'] . "</td>"
        . "<td>" . $row['vegan'] . "</td>"
        . "<td>" . number_format($row['preisintern'], 2) . "&euro;" . "</td>"
        . "<td>" . number_format($row['preisextern'], 2) . "&euro;" . "</td>";
    echo "</tr>";
}
echo "</table>";

