<?php
/**
 * 1. Дан XML файл. Сохраните его под именем data.xml
 * 2. Написать скрипт, который выведет всю информацию из этого файла в удобно
 * читаемом виде. Представьте, что результат вашего скрипта будет распечатан и выдан
 * курьеру для доставки, разберется ли курьер в этой информации?
 */
function task1()
{
    $file = file_get_contents("./data/data.xml");
    $xml = new SimpleXMLElement($file);
//    Можно выделять атрибуты так:
//    $orderNumber = $xml->attributes()->PurchaseOrderNumber;
//    $orderDate = $xml->attributes()->OrderDate;
    $orderNumber = $xml['PurchaseOrderNumber'];
    $orderDate = $xml['OrderDate'];
    $shippingAddress = $xml->xpath("//Address[@Type='Shipping']")[0];
    $billingAddress = $xml->xpath("//Address[@Type='Billing']")[0];
    $deliveryNotes = $xml->DeliveryNotes;
    $items = $xml->Items->Item;
//    var_dump($items);

    echo "<hr>".PHP_EOL;
    echo "Purchase order: <strong>{$orderNumber}</strong>  Date: <strong>{$orderDate}</strong><br><br>".PHP_EOL;
    echo "<strong>Shipping address:</strong><br>".PHP_EOL;
    echo "{$shippingAddress->Name}<br>".PHP_EOL;
    echo "{$shippingAddress->Street}<br>".PHP_EOL;
    echo "{$shippingAddress->City}, {$shippingAddress->State}, {$shippingAddress->Zip}<br>".PHP_EOL;
    echo "{$shippingAddress->Country}<br>".PHP_EOL;
    echo "<br>";
    echo "<strong>Billing address:</strong><br>".PHP_EOL;
    echo "{$billingAddress->Name}<br>".PHP_EOL;
    echo "{$billingAddress->Street}<br>".PHP_EOL;
    echo "{$billingAddress->City}, {$billingAddress->State}, {$billingAddress->Zip}<br>".PHP_EOL;
    echo "{$billingAddress->Country}<br>".PHP_EOL;
    echo "<br>";
    echo "Delivery notes: <i>{$deliveryNotes}</i><br><hr>".PHP_EOL;

    $itemNumber = 0;
    foreach ($items as $item) {
        $itemNumber++;
        echo "<strong>#{$itemNumber}</strong><br>".PHP_EOL;
        echo "Part. number: {$item['PartNumber']}<br>".PHP_EOL;
        echo "Product name: {$item->ProductName}<br>".PHP_EOL;
        echo "Quantity: {$item->Quantity}<br>".PHP_EOL;
        echo "Price: \${$item->USPrice}<br>".PHP_EOL;
        echo "Ship date: {$item->ShipDate}<br>".PHP_EOL;
        echo "Comment: {$item->Comment}<br>".PHP_EOL;
//        var_dump($item);
        echo "<hr>";
    }
    echo "Total: <strong>{$itemNumber} items</strong><br>".PHP_EOL;
}

/**
 * 1. Создайте массив, в котором имеется как минимум 1 уровень вложенности. Преобразуйте его в JSON. Сохраните как output.json
 * 2. Откройте файл output.json. Случайным образом, используя функцию rand(), решите изменять данные или нет.
 * Сохраните как output2.json
 * 3. Откройте оба файла. Найдите разницу и выведите информацию об отличающихся элементах
 */
function task2()
{
    function saveJSON()
    {
        $orders =
            [
                "orderID" => 12345,
                "name" => "Ваня Иванов",
                "email" => "ivanov@example.com",
                "content" =>
                    [
                        [
                            "productID" => 34,
                            "productName" => "Супер товар",
                            "quantity" => 1
                        ],
                        [
                            "productID" => 56,
                            "productName" => "Чудо товар",
                            "quantity" => 3
                        ]
                    ],
                "orderCompleted" => true
            ];
        $ordersJSON = json_encode($orders, JSON_UNESCAPED_UNICODE);
        $pathJsonFile = "./data/output.json";
        file_put_contents($pathJsonFile, $ordersJSON);
    };

    function changeJSON()
    {
        $pathJsonFile = "./data/output.json";
        $contentJSON = json_decode(file_get_contents($pathJsonFile), true);
        $isNeedChange = (rand(0, 1) == 1);
//        echo $isNeedChange;
        if ($isNeedChange) {
          $contentJSON['content'][0]['productName'] = 'Мега-хит';
        };
        $ordersJSON = json_encode($contentJSON, JSON_UNESCAPED_UNICODE);
        $pathJsonFile = "./data/output2.json";
        file_put_contents($pathJsonFile, $ordersJSON);

    };

    function checkDifferencies()
    {
        function makeLinearArray1($item, $key, &$str1)
        {
//            global $str1;
            echo $str1.'<br>';
            $complexItem = $key.'=>'.$item;
            $str1 = $complexItem;

//            array_push($linearArray1, $complexItem);
//            echo $complexItem;
//            $linearArray1[0] = "$key=>$item";
        };

        $pathJsonFile1 = "./data/output.json";
        $pathJsonFile2 = "./data/output2.json";
        $content1 = json_decode(file_get_contents($pathJsonFile1), true);
        $content2 = json_decode(file_get_contents($pathJsonFile2), true);

        $linearArray1 = [];
        $linearArray1[0] = 1;
        $str1 = '123';

        array_walk_recursive($content1, 'makeLinearArray1', $str1);
        echo 's=', $str1;
//        print_r($linearArray1);

//        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($content1),
//            RecursiveIteratorIterator::CATCH_GET_CHILD) as $key => $value) {
//            echo 'My node ' . $key . ' with value ' . $value . '<br>'.PHP_EOL;
//        }
//        echo "<hr>";
//        array_walk_recursive($content2, 'test_print');

//        echo serialize($content1).'<br>';
//        echo serialize($content2).'<br>';
//        echo "<pre>";
//        var_dump($content1);
//        echo "</pre>";

//        $difference = array_diff($content1, $content2);
//        print_r($difference);
//        foreach ($content1 as $key=>$value) {
//            if (!is_array($value)) {
//                echo $value.'<br>';
//            } else {
//                print_r($value).'<br>';
//            }
//        }

    }

    saveJSON();
    changeJSON();
    checkDifferencies();
}

/**
 * 1. Программно создайте массив, в котором перечислено не менее 50 случайных чисел от 1 до 100
 * 2. Сохраните данные в файл csv
 * 3. Откройте файл csv и посчитайте сумму четных чисел
 */
function task3($minArrLength, $maxArrLength)
{
    // Создаем массив
    $arr = [];
    $arrLength = rand($minArrLength, $maxArrLength);
    for ($i = 1; $i <= $arrLength; $i++) {
        $arr[] = rand(1, 100);
    }

    // Записываем массив в csv-файл
    $file = fopen('./data/data.csv', 'w');
    fputcsv($file, $arr, ';');
    fclose($file);

    // Читаем массив из csv-файла
    $file = fopen('./data/data.csv', 'r');
    $arr2 = fgetcsv($file, 0, ';');
    fclose($file);
    // Считаем сумму четных чисел в массиве
    $sum = 0;
    foreach ($arr2 as $item) {
        $sum += ($item % 2 == 0 ? $item : 0 );
    }
    echo "Сумма четных чисел в файле равна {$sum}.<br>".PHP_EOL;
}

/**
 * 1. С помощью PHP запросить данные по адресу:
 * https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json
 * 2. Вывести title и page_id
 */
function task4()
{
    $url = 'https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json';
    $content = file_get_contents($url);
    $pages = json_decode($content, true)['query']['pages'];
    // В $page присваиваем первый элемент массива $pages
    $page = reset($pages);

    $title = $page['title'];
    $pageId = $page['pageid'];

    echo "Данные из {$url}:<br>".PHP_EOL;
    echo "title = {$title}, pageid = {$pageId}<br>".PHP_EOL;
}
