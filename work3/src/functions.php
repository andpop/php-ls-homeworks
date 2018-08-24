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