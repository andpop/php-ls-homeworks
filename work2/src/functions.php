<?php

/**
 * 1. Функция должна принимать массив строк и выводить каждую строку в отдельном параграфе (тег <p>)
 * 2. Если в функцию передан второй параметр true, то возвращать (через return) результат в виде одной объединенной строки.
 * @param $strings - массив строк для вывода
 * @param bool $isUnionString - флаг (если равен true, то возвращается результат объединения строк из массива в одну строку
 * @return string - возвращает либо пустую строку, либо строку с результатом объединения строк из массива
 */
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

/**
 * 1. Функция должна принимать переменное число аргументов.
 * 2. Первым аргументом обязательно должна быть строка, обозначающая
 * арифметическое действие, которое необходимо выполнить со всеми передаваемыми аргументами.
 * 3. Остальные аргументы это целые и/или вещественные числа.
 * @return mixed|string - результат вычисления
 */
function task2()
{
    if (func_num_args() < 3) {
        return "В функцию task2 должно быть передано не меньше трех аргументов";
    };

    $operations = ['+', '-', '*', '/'];
    $operation = func_get_arg(0);
    if (!in_array($operation, $operations)) {
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

/**
 * 1. Функция должна принимать два параметра – целые числа.
 * 2. Если в функцию передали 2 целых числа, то функция должна отобразить таблицу умножения размером со значения
 * параметров, переданных в функцию. (Например если передано 8 и 8, то нарисовать от 1х1 до 8х8).
 * Таблица должна быть выполнена с использованием тега <table>
 * 3. В остальных случаях выдавать корректную ошибку.
 * @param $maxRowNumber - количество строк в таблице умножения
 * @param $maxColumnNumber - количество столбцов в таблице умножения
 */
function task3($maxRowNumber, $maxColumnNumber)
{
    if (!(is_int($maxRowNumber) && $maxRowNumber > 0)) {
        echo "Ошибка! Параметры функции должны быть целыми положительными числами.<br>";
        return;
    };
    if (!(is_int($maxColumnNumber) && $maxColumnNumber > 0)) {
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

/**
 * 1. Выведите информацию о текущей дате в формате 31.12.2016 23:59
 * 2. Выведите unixtime время соответствующее 24.02.2016 00:00:00.
 */
function task4()
{
    $dateFormat = 'd.m.Y H:i';
    echo 'Текущая дата: ';
    echo date($dateFormat).PHP_EOL.'<br>';

    echo 'Unix-время для даты 24.02.2016: ';
    echo mktime(0, 0, 0, 2, 24, 2016).PHP_EOL.'<br>';
}

/**
 * 1. Дана строка: “Карл у Клары украл Кораллы”. удалить из этой строки все заглавные буквы “К”.
 * 2. Дана строка “Две бутылки лимонада”. Заменить “Две”, на “Три”. По желанию дополнить задание.
 */
function task5()
{
    $sourceString1 = 'Карл у Клары украл Кораллы';
    $sourceString2 = 'Две бутылки лимонада';

    $resultString1 = str_replace('К', '', $sourceString1);
    $resultString2 = str_replace('Две', 'Три', $sourceString2);
    echo "{$sourceString1} => {$resultString1}<br>".PHP_EOL;
    echo "{$sourceString2} => {$resultString2}<br>".PHP_EOL;
}

/**
 * 1. Создайте файл test.txt средствами PHP. Поместите в него текст - “Hello again!”
 * 2. Напишите функцию, которая будет принимать имя файла, открывать файл и выводить содержимое на экран.
 * @param $fileName - имя файла для чтения
 */
function task6($fileName)
{
    file_put_contents("test.txt", "Hello again!");

    if (!file_exists($fileName)) {
        echo "Файл $fileName не найден.<br>".PHP_EOL;
        return;
    };

    $content = file_get_contents($fileName);
    echo "Содержимое файла {$fileName}:<br>".PHP_EOL;
    echo $content.'<br>'.PHP_EOL;
}