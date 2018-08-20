<?php
require('src/functions.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Домашнее задание #2</title>
</head>
<style>
    table {
        font-size: 14px;
        border-collapse: collapse;
        text-align: center;
    }
    th, td:first-child {
        background: #AFCDE7;
        color: white;
        padding: 10px 20px;
    }
    th, td {
        border-style: solid;
        border-width: 0 1px 1px 0;
        border-color: white;
    }
    td {
        background: #D8E6F3;
    }
</style>

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
<h2>Задача 3</h2>
<?php
task3(7, 7);
echo "<br>";
?>
<hr>
<h2>Задача 4</h2>
<?php
task4();
?>
<hr>

</body>
</html>



