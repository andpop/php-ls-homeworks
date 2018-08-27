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

    echo str_repeat('=', 80).'<br>'.PHP_EOL;
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
    echo "Delivery notes: <i>{$deliveryNotes}</i><br>".PHP_EOL;
    echo str_repeat('=', 80).'<br>'.PHP_EOL;

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
        echo str_repeat('-', 120).'<br>'.PHP_EOL;
    }
    echo "Total: <strong>{$itemNumber} items</strong><br>".PHP_EOL;
    echo str_repeat('=', 80).'<br>'.PHP_EOL;
}

/**
 * 1. Создайте массив, в котором имеется как минимум 1 уровень вложенности. Преобразуйте его в JSON. Сохраните как output.json
 * 2. Откройте файл output.json. Случайным образом, используя функцию rand(), решите изменять данные или нет.
 * Сохраните как output2.json
 * 3. Откройте оба файла. Найдите разницу и выведите информацию об отличающихся элементах
 */
function task2()
{
    /**
     * Сохраняем JSON во внешний файл output.json
     */
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

    /**
     * С вероятностью 0.5 меняем значения одного ключа из output.json и записываем результат в output2.json
     */
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

    /**
     * Определяем разницу между файлами output.json и output2.json
     * Для этого:
     * 1. Переводим json-файлы в плоский формат (файлы temp1.csv и temp2.csv)
     * 2. Считываем данные из temp1.csv и temp2.csv в одномерные массивы linearArr1 и linearArr2
     * 3. Сравниваем элементы массивов linearArr1 и linearArr2
     */
    function checkDifferencies()
    {
        /**
         * Добавляет в файл temp1.txt содержимое текущего элемента output.json в линейном виде
         * @param $item
         * @param $key
         */
        function addJsonItemToTempFile1($item, $key)
        {
            $f = fopen("./data/temp1.csv", 'a+');
            $complexItem = $key.'=>'.$item.';';
            fwrite($f, $complexItem);
            fclose($f);
        };

        /**
         * Добавляет в файл temp2.txt содержимое текущего элемента output2.json в линейном виде
         * @param $item
         * @param $key
         */
        function addJsonItemToTempFile2($item, $key)
        {
            $f = fopen("./data/temp2.csv", 'a+');
            $complexItem = $key.'=>'.$item.';';
            fwrite($f, $complexItem);
            fclose($f);
        };

        function delTempFiles($fileName1, $fileName2)
        {
          if (file_exists($fileName1)) {
              unlink($fileName1);
          }
          if (file_exists($fileName2)) {
              unlink($fileName2);
          }
        };

        function getTempFileContent($fileName)
        {
            $content = file_get_contents($fileName);
            return explode(';', $content);
        };


        $pathJsonFile1 = "./data/output.json";
        $pathJsonFile2 = "./data/output2.json";
        $pathTempFile1 = "./data/temp1.csv";
        $pathTempFile2 = "./data/temp2.csv";

        $content1 = json_decode(file_get_contents($pathJsonFile1), true);
        $content2 = json_decode(file_get_contents($pathJsonFile2), true);

        delTempFiles($pathTempFile1, $pathTempFile2);

        array_walk_recursive($content1, 'addJsonItemToTempFile1');
        array_walk_recursive($content2, 'addJsonItemToTempFile2');

        $linearArr1 = getTempFileContent($pathTempFile1);
        $linearArr2 = getTempFileContent($pathTempFile2);

        $difference = array_diff($linearArr1, $linearArr2);
        if (count($difference) == 0) {
            echo "В JSON-файлах различий не обнаружено.<br>".PHP_EOL;
        } else {
            echo "В JSON-файлах обнаружены различия:<br>".PHP_EOL;
            foreach ($difference as $key=>$value) {
                echo 'output.json: <b>'.$linearArr1[$key].'</b>   output2.json: <b>'.$linearArr2[$key].'</b><br>';
            };
        };

//        Пробовал формировать линейный массив через рекурсивный итератор - не получилось, не входит внутрь вложенного массива
//        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($content1),
//            RecursiveIteratorIterator::CATCH_GET_CHILD) as $key => $value) {
//            echo 'My node ' . $key . ' with value ' . $value . '<br>'.PHP_EOL;
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

    echo "<em>Данные из {$url}:</em><br>".PHP_EOL;
    echo "<b>title = {$title}, pageid = {$pageId}</b><br>".PHP_EOL;
}
