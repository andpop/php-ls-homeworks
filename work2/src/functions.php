<?php

/*1. Функция должна принимать массив строк и выводить каждую строку в отдельном
параграфе (тег <p>)
2. Если в функцию передан второй параметр true, то возвращать (через return)
результат в виде одной объединенной строки.*/
function task1($strings, $isUnionString = false)
{
    if (!is_array($strings)) {
        echo "Ошибка! Первый параметр функции task1 должен быть массивом.".PHP_EOL;
        return '';
    };
    foreach ($strings as $string) {
        echo "<p>{$string}</p>";
    };
    if ($isUnionString) {
        return implode("", $strings);
    } else {
        return '';
    }
}

/*1. Функция должна принимать переменное число аргументов.
2. Первым аргументом обязательно должна быть строка, обозначающая
арифметическое действие, которое необходимо выполнить со всеми
передаваемыми аргументами.
3. Остальные аргументы это целые и/или вещественные числа.*/
function task2()
{
    if (func_num_args() < 3) {
        return "В функцию task2 должно быть передано не меньше трех аргументов";
    };

    $operationArray = ['+', '-', '*', '/'];
    $operation = func_get_arg(0);
    if (!in_array($operation, $operationArray)) {
        return 'Первый параметр должен быть символом арифметической операции (+, -, *, /).';
    }

    if (!is_numeric(func_get_arg(1))) {
        return 'Все параметры, начиная со второго, должны быть числами.';
    }
    $resultString = func_get_arg(1);
    for ($i = 2; $i < func_num_args(); $i++) {
        if (!is_numeric(func_get_arg($i))) {
            return 'Все параметры, начиная со второго, должны быть числами.';
        }
        $resultString .= $operation.func_get_arg($i);
    }
    return eval('return '.$resultString.';');
}

/*1. Функция должна принимать два параметра – целые числа.
2. Если в функцию передали 2 целых числа, то функция должна отобразить таблицу
умножения размером со значения параметров, переданных в функцию. (Например
если передано 8 и 8, то нарисовать от 1х1 до 8х8). Таблица должна быть
выполнена с использованием тега <table>
3. В остальных случаях выдавать корректную ошибку.*/
function task3($maxRowNumber, $maxColumnNumber)
{
    if (!(is_int($maxRowNumber) && $maxRowNumber >0)) {
        echo "Ошибка! Параметры функции должны быть целыми положительными числами.<br>";
        return;
    };
    if (!(is_int($maxColumnNumber) && $maxColumnNumber >0)) {
        echo "Ошибка! Параметры функции должны быть целыми положительными числами.<br>";
        return;
    };
    echo "<table>".PHP_EOL;
    echo "<tr>".PHP_EOL;
    for ($rowNumber = 1; $rowNumber <= $maxRowNumber; $rowNumber++) {
        echo "<th>$rowNumber</th>";
    };
    echo "</tr>".PHP_EOL;
    for ($columnNumber = 2; $columnNumber <=$maxColumnNumber; $columnNumber++) {
        echo "<tr>".PHP_EOL;
        for ($rowNumber = 1; $rowNumber <= $maxRowNumber; $rowNumber++) {
            $product = $columnNumber * $rowNumber;
            echo "<td>$product</td>";
        }
        echo "</tr>".PHP_EOL;
    };
    echo "</table>".PHP_EOL;
}
