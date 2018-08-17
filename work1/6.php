<?php
/**
Задание #6
1. Используя цикл for, выведите таблицу умножения размером 10x10. Таблица
должна быть выведена с помощью HTML тега <table>
2. Если значение индекса строки и столбца чётный, то результат вывести в
круглых скобках.
3. Если значение индекса строки и столбца Нечётный, то результат вывести в
квадратных скобках.
4. Во всех остальных случаях результат выводить просто числом.
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задание #6</title>
</head>
<body>
    <table>
        <tr>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "<td>$i</td>";
        };
        ?>
        </tr>
        <?php
        for ($verticalCell = 2; $verticalCell <=10; $verticalCell++) {
            echo "<tr>";
            for ($horizontalCell = 1; $horizontalCell <= 10; $horizontalCell++) {
                $result = $verticalCell * $horizontalCell;
                echo "<td>$result</td>";
            }
            echo "</tr>";
        };
        ?>
    </table>
</body>
</html>
