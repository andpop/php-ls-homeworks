<?php
require('src/functions.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Домашнее задание #2</title>
</head>
<body>
<h2>Задача 1</h2>
<?php
echo task1(["1 элемент", "2 элемент", "3 элемент"], true);
echo "<br>";
echo task1("123");
?>
<hr>
<h2>Задача 2</h2>
<?php
$result = task2("*", 2, 3, 4);
if (is_numeric($result)) {
    echo  $result.'<br>';
} else {
    echo  'Ошибка! '.$result.'<br>';
};
echo "<br>";
?>
<hr>
</body>
</html>



