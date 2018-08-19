<?php

/*1. Функция должна принимать массив строк и выводить каждую строку в отдельном
параграфе (тег <p>)
2. Если в функцию передан второй параметр true, то возвращать (через return)
результат в виде одной объединенной строки.*/
function task1($strings, $isUnionString = false)
{
    if (!is_array($strings)) {
        echo "Ошибка! Первый параметр функции task1 должен быть массивом.".PHP_EOL;
        return;
    };
    foreach ($strings as $string) {
        echo "<p>{$string}</p>";
    };
    if ($isUnionString) {
        return implode("", $strings);
    };
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
