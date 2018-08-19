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
