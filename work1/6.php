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
    <table>
        <tr>
        <?php
        for ($rowNumber = 1; $rowNumber <= 10; $rowNumber++) {
            echo "<th>$rowNumber</th>";
        };
        ?>
        </tr>
        <?php
        for ($columnNumber = 2; $columnNumber <=10; $columnNumber++) {
            echo "<tr>";
            for ($rowNumber = 1; $rowNumber <= 10; $rowNumber++) {
                $product = $columnNumber * $rowNumber;
                if (($columnNumber % 2 == 0) and ($rowNumber % 2 == 0)) {
                    $result = "({$product})";
                } elseif (($columnNumber % 2 == 1) and ($rowNumber % 2 == 1)) {
                    $result = "[{$product}]";
                } else {
                    $result = $product;
                };

                echo "<td>$result</td>";
            }
            echo "</tr>";
        };
        ?>
    </table>
</body>
</html>
