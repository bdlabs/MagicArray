<?php

include "../src/MagicArray.php";

use \BlueDiamond\MagicArray\MagicArray;

$data = [
    'product' => [
        'data' => [
            'price' => 0,
            'qty' => 0,
        ],
        'name' => '',
    ],
    'setIndex' => 1,
];

$ma = new MagicArray($data);
$ma->set('product.data.price', 21)->set('product.data.qty', 12);
$ma->product->data->qty(11)->r()->setIndex = 2;
$ma->setIndex(3);

$jsonResult = json_encode($ma->all(), JSON_PRETTY_PRINT);
echo $jsonResult . PHP_EOL;
echo $ma->r()->setIndex->value() . PHP_EOL;
