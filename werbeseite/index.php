<? php /**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 **/
?>

<?php include 'db_connect.php';


$sortOrder = "ASC";
if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == "desc") {
  $sortOrder = "DESC";
}
$sql = "
SELECT 
    g.name,
    g.preisintern,
    g.preisextern,
    g.id,
    GROUP_CONCAT(gha.code SEPARATOR ', ') AS allergen 
FROM 
    (SELECT *
     FROM gericht
     ORDER BY id ASC
     LIMIT 5)
        AS g
LEFT JOIN 
        gericht_hat_allergen gha ON g.id = gha.gericht_id 
GROUP BY 
    g.id,
    g.name,
    g.preisintern,
    g.preisextern
ORDER BY 
    g.name $sortOrder";


$result = mysqli_query($link, $sql);
if (!$result) {
  echo "Fehler bei SQL-Abfragen!", mysqli_connect_error();
}

$sqlAllergene = "
SELECT DISTINCT a.code,a.name FROM (SELECT id FROM gericht ORDER BY id ASC LIMIT 5) AS g JOIN gericht_hat_allergen gha ON g.id = gha.gericht_id JOIN allergen a ON gha.code = a.code ORDER BY a.code";
$resultAllergene = mysqli_query($link, $sqlAllergene);
if(!$resultAllergene){
  echo "Fehler bei SQL-Abfragen!", mysqli_connect_error();
}




$zählerdatei = __DIR__ . 'besucher.txt'; //__dir__ : ordner in dem die aktuelle php datei ist
$newsletterdatei = 'newsletter.txt';


if (!file_exists($zählerdatei)) {
  file_put_contents($zählerdatei, '0');
}
$besucherAnzahl = (int)file_get_contents($zählerdatei); //liest die datei und wandelt string in int um
$besucherAnzahl++;
file_put_contents($zählerdatei, (string)$besucherAnzahl); //überschreiben der datei


if (file_exists($newsletterdatei)) {
  $zeilen = file($newsletterdatei);
  $anzahlNewsletter = count($zeilen);
} else {
  $anzahlNewsletter = 0;
}

$meldung = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $datenschutz = isset($_POST['datenschutz']);

  if ($name == '') {
    $meldung = 'Bitte geben Sie einen Namen ein.';
  } elseif (strpos($email, '@') == false) {
    $meldung = 'Bite geben Sie eine gültige E-Mail-Adresse ein.';
  } // substr nach dem @ zeiczen überprüfen ob trashmail oder email ist und nicht vor dem zeichen
  elseif (str_contains($email, 'wegwerfmail.de') || str_contains($email, 'trashmail')) {
    $meldung = 'Diese E-Mail-Adresse ist nicht erlaubt.';
  } elseif (!$datenschutz) {
    $meldung = 'Bitte stimmen Sie den Datenschutzbedingungen zu';
  } else {
    $zeile = $name . ';' . $email . PHP_EOL;
    $ergebnis = file_put_contents($newsletterdatei, $zeile, FILE_APPEND);

    if ($ergebnis == true) {
      $meldung = 'Danke für die Anmeldung';
    } else {
      $meldung = 'Fehler beim speichern';
    }
  }
}

?>

<!doctype html>
<!--
- Praktikum DBWT. Autoren:
- Kawa, Akbulut, 3589339
- Claire, Haarhaus, 3647080
-->

<html lang="de">
<head>
  <meta charset="UTF-8"/>
  <title>E-Mensa</title>
  <style>
      html {
          scroll-behavior: smooth;
      }

      fieldset {
          height: 1450px;
      }

      .header {
          display: flex;
          grid-template-columns: 1fr auto 1fr;
          align-items: center;
          gap: 40px;
      }

      .E-Mensa_Logo {
          border: solid 1px black;
          width: 150px;
      }

      .E-Mensa_Logo img {
          width: 150px;
          height: auto;
      }


      nav {
          display: flex;
          width: 800px;
          gap: 40px;
          margin-left: 0;
          border: solid 1px black;
          padding: 30px 20px;
      }

      .main {
          margin-left: 195px;
          width: 840px;
      }

      .placeholder_1 {
          border: solid 1px black;
          padding: 10px;
      }

      table {
          text-align: center;
      }

      .tabellen-cointainer{
          display: flex;
          gap: 40px;
          align-items: flex-start;
      }

      td,
      th {
          border: solid 1px black;
      }

      span {
          font-weight: bold;
          padding: 50px;
      }

      .input-reihe {
          display: flex;
          gap: 45px;
      }

      #language {
          width: 150px;
      }

      .label-reihe label:nth-child(1) {
          margin-left: 0;
      }

      .label-reihe label:nth-child(2) {
          margin-left: 130px;
      }

      .label-reihe label:nth-child(3) {
          margin-left: 110px;
      }

      #submit {
          margin-left: 20px;
      }

      footer {
          text-align: right;
      }

      footer ul {
          list-style: none;
          display: flex;
          justify-content: center;
          gap: 40px;
      }

      footer ul li {
          border-right: solid 1px grey;
          padding: 0 20px;
      }

      footer ul li:last-child {
          border: none;
      }

      .zentrierte_überschrift {
          text-align: center;
      }
  </style>
</head>

<body>
<fieldset>
  <div class="header">
    <div class="E-Mensa_Logo">
      <img src="img/img.png" alt="E-Mensa_Logo"/>
    </div>
    <nav class="Reiter">
      <a href="#Ankündigung">Ankündigung</a> <a href="#Speisen">Speisen</a> <a href="#Zahlen">Zahlen</a> <a
          href="#Kontakt">Kontakt</a> <a href="#Wichtigfüruns">Wichtig für uns</a>
    </nav>
  </div>
  <hr/>
  <div class="main">
    <h1 id="Ankündigung">Bald gibt es Essen auch online ;)</h1>
    <br/>
    <div class="placeholder_1">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna
        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi
        consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
        Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
      </p>
    </div>
    <h1 id="Speisen">Köstlichkeiten, die Sie erwarten</h1>
    <a href="index.php?sortOrder=asc">ASC</a> <a href="index.php?sortOrder=desc">DESC</a>
    <div class = "tabellen-cointainer">
    <table class="gerichte">
      <tr>
        <th>Gerichte</th>
        <th>Preis intern</th>
        <th>Preis extern</th>
        <th>Allergene</th>
      </tr>
      <?php
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . number_format($row['preisintern'], 2) . "&euro;" . "</td>";
        echo "<td>" . number_format($row['preisextern'], 2) . "&euro;" . "</td>";
        echo "<td>" . $row['allergen'] . "</td>";
      }
      ?>
    </table>
    <br>
    <table class = "allergene">
      <tr>
        <th>Code</th>
        <th>Name</th>
      </tr>
    <?php
    while ($row = mysqli_fetch_assoc($resultAllergene)) {
      echo "<tr>";
      echo "<td>" . $row['code'] . "</td>";
      echo "<td>" . $row['name'] . "</td>";
    }
    ?>
    </table>
    </div>
    <h1 id="Zahlen">E-Mensa in Zahlen</h1>
    <span><?php echo $besucherAnzahl; ?> Besuche</span>
    <span><?php echo $anzahlNewsletter ?>Anmeldungen zum Newsletter</span>
    <span><?php echo $anzahlGerichte ?> Gerichte</span>
    <h1 id="Kontakt">Interesse geweckt? Wir informieren Sie!</h1>
    <?php if (!empty($meldung)) echo '<p>' . htmlspecialchars($meldung) . '</p>'; ?>
    <form method="POST">
      <div class="label-reihe">
        <label for="name_input">Ihr Name</label> <label for="email_input">Ihre E-Mail</label> <label for="language">Newsletter
                                                                                                                    bitte
                                                                                                                    in:</label>
      </div>
      <div class="input-reihe">
        <input type="text" id="name_input" name="name" placeholder="Vorname"/> <input type="email" id="email_input"
                                                                                      name="email"
                                                                                      placeholder="E-Mail"/> <select
            id="language" name="language">
          <option value="de">Deutsch</option>
        </select>
      </div>
      <br/> <input type="checkbox" id="Datenschutz" name="datenschutz"/> <label for="Datenschutz">Den
                                                                                                  Datenschutzbestimmungen
                                                                                                  stimme ich zu</label>
      <label for="submit" id="submit_label" name="newsletter_bestätigung"></label> <input
          type="submit"
          id="submit"
          name="newsletter_submit"
          value="Zum Newsletter anmelden"
      />
    </form>
    <h1 id="Wichtigfüruns">Das ist uns wichtig</h1>
    <ul>
      <li>Beste frische saisonale Zutaten</li>
      <li>Ausgewogene und abwechslungsreiche Gerichte</li>
      <li>Sauberkeit</li>
    </ul>
    <h1 class="zentrierte_überschrift">Wir freuen uns auf Ihren Besuch!</h1>
    <hr/>
    <footer>
      <ul>
        <li>(c) E-Mensa GmbH</li>
        <li>Kawa Akbulut</li>
        <li>
          <a href="#">Impressum</a>
        </li>
      </ul>
    </footer>
  </div>
</fieldset>
</body>
</html>
