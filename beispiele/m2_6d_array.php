<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 */
$famouesMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => [2019]]
];

    function noWinner($arr1) : array {
        $arr2 = range(2000, 2025);
        $noWinner = array_diff($arr2,$arr1);
        return $noWinner;
    }
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>array</title>
</head>
<body>
<ol style="margin-bottom: 50px;">
    <?php foreach ($famouesMeals as $meal) {
        echo "<li>" . $meal['name'] . "</li>";
        $list = implode(", ", array_reverse($meal['winner']));
        printf($list);
    } ?>
</ol>

<?php
    $allWinners = [];
    foreach ($famouesMeals as $meal) {
        $allWinners = array_merge($allWinners, $meal['winner']);
    }
    $noWinner = noWinner($allWinners);
    $list = implode(", ", $noWinner);
    printf($list);
?>

</body>
</html>
