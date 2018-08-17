<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задание #5</title>
</head>
<body>
    <?php
/**
Задание #5
1. Создайте массив ​ $bmw​ с ячейками:
a. model
b. speed
c. doors
d. year
2. Заполните ячейки значениями соответсвенно: “X5”, 120, 5, “2015”
3. Создайте массивы $toyota и $opel аналогичные массиву $bmw
(заполните данными)
4. Объедините три массива в один многомерный массив
5. Выведите значения всех трех массивов в виде:
CAR name
name ​ model ​ speed ​ doors ​ year
Например:
CAR bmw
X5 ​ 120 ​ 5 ​ 2015
 */

    $bmw = array(
        "model" => "X5",
        "speed" => 120,
        "doors" => 5,
        "year" => "2015"
    );
    $toyota = array(
        "model" => "Corolla",
        "speed" => 140,
        "doors" => 5,
        "year" => "2016"
    );
    $opel = array(
        "model" => "Zafira",
        "speed" => 130,
        "doors" => 5,
        "year" => "2015"
    );
    $cars = [
        "bmw" => $bmw,
        "toyota" => $toyota,
        "opel" => $opel
    ];

    foreach ($cars as $carName => $carProperties) {
        echo "CAR {$carName}<br>".PHP_EOL;
        $s = "";
        foreach ($carProperties as $carProperty) {
            $s .= $carProperty." ";
        }
        echo $s."<br>".PHP_EOL;
        echo "<hr>".PHP_EOL;
    }
    ?>
</body>
</html>

