<?php
/**
 * Praktikum DBWT. Autoren:
 * Kawa, Akbulut, 3589339
 * Claire, Haarhaus, 3647080
 */

include ('m2_6a_standardparameter.php');
function multiplizieren($a, $b = 0) : int {
    return $a * $b;
}

$result = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $operator = $_POST["operator"];

    if ($operator == "add") {
        $result = addieren($num1, $num2);
    } else if ($operator == "multiply") {
        $result = multiplizieren($num1, $num2);
    }
}
?>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>addform</title>
</head>
<body>
    <form method="post">
        <label for="num1">Number 1:</label>
        <input type="number" id="num1" name="num1" required><br>

        <label>Operation:</label>
        <input type="radio" name="operator" value="add">"+"
        <input type="radio" name="operator" value="multiply">"*"<br>

        <label for="num2">Number 2:</label>
        <input type="number" id="num2" name="num2" required><br>

        <input type="submit" value="calculate">
    </form>

    <h4>Result: <?php echo $result; ?></h4>

</body>
</html>
