<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задание #4</title>
</head>
<body>
    <?php
    /*
    Задание #4
    1. Создайте переменную $day и присвойте ей произвольное числовое значение
    2. С помощью конструкции switch выведите фразу “Это рабочий день”,
    если значение переменной $day попадает в диапазон чисел от 1 до 5
    (включительно)3. Выведите фразу “Это выходной день”, если значение переменной
    $day равно числам 6 или 7
    4. Выведите фразу “Неизвестный день”, если значение*/

    $day = rand(0, 10);
    echo $day."<br>".PHP_EOL;
    $workday = "Это рабочий день";
    $weekend = "Это выходной день";
    $unknownDay = "Неизвестный день";

    switch ($day) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
            echo $workday."<br>".PHP_EOL;
            break;
        case 6:
        case 7:
            echo $weekend."<br>".PHP_EOL;
            break;
        default:
            echo $unknownDay."<br>".PHP_EOL;
    }
    ?>
</body>
</html>

