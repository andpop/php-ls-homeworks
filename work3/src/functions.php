<?php
/*Purchase order N {}
Date: {}
Shipping address: {}
Billing address: {}

Delivery notes: {}

1. PartNumber: {}
    ProductName: {}
    ...
-------------------
2. PartNumber: {}
    ProductName: {}
    ...
-------------------*/
function task1()
{
    $file = file_get_contents("data.xml");
    $xml = new SimpleXMLElement($file);
//    $orderNumber = $xml->attributes()->PurchaseOrderNumber;
//    $orderDate = $xml->attributes()->OrderDate;
    $orderNumber = $xml['PurchaseOrderNumber'];
    $orderDate = $xml['OrderDate'];

//    echo "<pre>";
//    var_dump($xml);
//    var_dump($xml->attributes()->PurchaseOrderNumber);
    echo "Purchase order N {$orderNumber}<br>".PHP_EOL;
    echo "Date: {$orderDate}<br>".PHP_EOL;

}