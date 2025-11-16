<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 **/
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESCRIPTION = 'show_description';

/**
 * List of all allergens.
 */
$allergens = [
        11 => 'Gluten',
        12 => 'Krebstiere',
        13 => 'Eier',
        14 => 'Fisch',
    17 => 'Milch'
];

$meal = [
        'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
        'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
        'price_intern' => 2.90,
        'price_extern' => 3.90,
        'allergens' => [11, 13],
                'amount' => 42             // Number of available meals
        ];

$ratings = [
        [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
                'author' => 'Ute U.',
                'stars' => 2 ],
        [   'text' => 'Sehr gut. Immer wieder gerne',
                'author' => 'Gustav G.',
                'stars' => 4 ],
        [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
                'author' => 'Renate R.',
                'stars' => 4 ],
        [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
                'author' => 'Marta M.',
                'stars' => 3 ]
];

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (stripos($rating['text'], $searchTerm) !== false) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] <= $minStars){
            $showRatings[] = $rating;
        }
    }
} else {
    $showRatings = $ratings;
}

function calcMeanStars(array $ratings) : float {
    $sum = 0;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'] / count($ratings);
    }
    return $sum;
}

$showDescription = true;
if (isset($_GET[GET_PARAM_SHOW_DESCRIPTION]) && $_GET[GET_PARAM_SHOW_DESCRIPTION] == 0) {
    $showDescription = false;
}

$searchText = "";
if (isset($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchText = $_GET[GET_PARAM_SEARCH_TEXT];
}

$language = "en";
if (isset($_GET['lang']) && in_array($_GET['lang'], ['de', 'en'])) {
    $language = $_GET['lang'];
}

$translation = [
        'de' => [
            'gericht' => 'Gericht',
            'beschreibung_anzeigen' => 'Beschreibung anzeigen',
            'ja' => 'Ja',   'nein' => 'Nein',
            'beschreibung_anzeigen_button' => 'anzeigen/ausblenden',
            'allergene' => 'Allergene',
            'bewertungen' => 'Bewertungen',
            'insgesamt' => 'Insgesamt',
            'filter' => 'Filter',
            'suchen' => 'Suchen',
            'text' => 'Text',
            'sterne' => 'Sterne',
            'author' => 'Author'
        ],
        'en' => [
                'gericht' => 'Meal',
                'beschreibung_anzeigen' => 'show description',
                'ja' => 'yes',
                'nein' => 'no',
                'beschreibung_anzeigen_button' => 'show/hide',
                'allergene' => 'allergens',
                'bewertungen' => 'ratings',
                'insgesamt' => 'total',
                'filter' => 'filter',
                'suchen' => 'search',
                'text' => 'text',
                'sterne' => 'stars',
                'author' => 'author'
        ]
];

$topFlop = "";
if (isset($_GET['topFlop']) && in_array($_GET['topFlop'], ['TOP', 'FLOP'])) {
    $topFlop = $_GET['topFlop'];
}

$minStars = min(array_column($showRatings, 'stars'));
$maxStars = max(array_column($showRatings, 'stars'));

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $translation[$language]['gericht']; ?>: <?php echo $meal['name']; ?></title>
    <style>
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>
<h1><?php echo $translation[$language]['gericht']; ?>: <?php echo $meal['name']; ?></h1>

<form method="get">
    <label for="<?php echo GET_PARAM_SHOW_DESCRIPTION; ?>"><?php echo $translation[$language]['beschreibung_anzeigen']; ?>: </label>
    <input type="radio" id="<?php echo GET_PARAM_SHOW_DESCRIPTION; ?>" type="radio" name="<?php echo GET_PARAM_SHOW_DESCRIPTION; ?>" value="1"><?php echo $translation[$language]['ja']; ?>
    <input type="radio" id="<?php echo GET_PARAM_SHOW_DESCRIPTION; ?>" type="radio" name="<?php echo GET_PARAM_SHOW_DESCRIPTION; ?>" value="0"><?php echo $translation[$language]['nein']; ?><br>
    <p><?php if ($showDescription != false) {
            echo $meal['description'];} ?></p>
    <input type="submit" value="<?php echo $translation[$language]['beschreibung_anzeigen_button']; ?>">
</form>


<p><?php echo $translation[$language]['allergene']; ?>: </p>
<?php
    echo"<ul>";
    foreach ($meal['allergens'] as $allergen) {
        echo "<li> $allergen </li>";
} ?>


<h1><?php echo $translation[$language]['bewertungen']; ?> (<?php echo $translation[$language]['insgesamt']; ?>: <?php echo calcMeanStars($ratings); ?>)</h1>
<form method="get">
    <label for="search_text"><?php echo $translation[$language]['filter']; ?>:</label>
    <input id="search_text" type="text" name="<?php echo GET_PARAM_SEARCH_TEXT; ?>" value="<?php echo $searchText; ?>">
    <input type="submit" value="<?php echo $translation[$language]['suchen']; ?>">
</form>
<table class="rating">
    <thead>
    <tr>
        <td><?php echo $translation[$language]['text']; ?></td>
        <td><?php echo $translation[$language]['sterne']; ?></td>
        <td><?php echo $translation[$language]['author']; ?></td>
    </tr>
    </thead>
    <tbody>
    <p>
        <a href="?topFlop=TOP">TOP Bewertungen</a> |
        <a href="?topFlop=FLOP">FLOP Bewertungen</a> |
        <a href="?topFlop=">FLOP Filter entfernen</a>
    </p>

    <?php
    if ($topFlop == '') {
        foreach ($showRatings as $rating) {
            echo "<tr><td class='rating_text'>{$rating['text']}</td>
                 <td class='rating_stars'>{$rating['stars']}</td>
                 <td class='rating_author'>{$rating['author']}</td>
                  </tr>";
        }
    } elseif ($topFlop == 'TOP') {
        foreach ($showRatings as $rating) {
            if ($rating['stars'] == $minStars) {
                echo "<tr><td class='rating_text'>{$rating['text']}</td>
                 <td class='rating_stars'>{$rating['stars']}</td>
                 <td class='rating_author'>{$rating['author']}</td>
                 </tr>";
            }
        }
    } elseif ($topFlop == 'FLOP') {
        foreach ($showRatings as $rating) {
            if ($rating['stars'] == $maxStars) {
                echo "<tr><td class='rating_text'>{$rating['text']}</td>
                 <td class='rating_stars'>{$rating['stars']}</td>
                 <td class='rating_author'>{$rating['author']}</td>
                 </tr>";
            }
        }
    }
    ?>
    </tbody>
</table>

<p>
    <a href="?sprache=de">Deutsch</a> |
    <a href="?sprache=en">English</a>
</p>

<p>Preis intern: <?php echo number_format($meal['price_intern'], 2, ',', '.');?>€</p>
<p>Preis extern: <?php echo number_format($meal['price_extern'], 2, ',', '.');?>€</p>

</body>
</html>