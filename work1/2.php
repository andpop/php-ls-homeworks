<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задание #2</title>
</head>
<body>
<?php
/*
Задание #2
1. Дана задача: На школьной выставке 80 рисунков. 23 из них выполнены
фломастерами, 40 карандашами, а остальные — красками. Сколько рисунков,
выполненные красками, на школьной выставке?
 2. Описать и вывести условия, решение этой задачи на PHP. Все
предоставленные числа из пункта 1 должны быть указаны в константах.
*/

    const TOTAL_FIGS = 80;
    const FELT_FIGS = 23;
    const PENCIL_FIGS = 40;
    $paintFigs = TOTAL_FIGS - FELT_FIGS - PENCIL_FIGS;
    echo "Написано красками: $paintFigs".PHP_EOL;
?>
</body>
</html>
