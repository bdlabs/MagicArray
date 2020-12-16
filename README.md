# MagicArray

Class to simple modify array structure.
This class protected value types.

**Simple example:**

```php
$data = [
    'product' => [
        'data' => [
            'price' => 0,
            'qty' => 0,
        ],
        'name' => '',
    ],
    'setIndex' => false,
];
$ma = new MagicArray($data);
```

***First way:***

```php
$ma->set('product.data.price', 100)
    ->set('product.data.qty', 90)
    ->set('setIndex', true);
```

***Secound way:***

```php
$ma->product->data->price(100)->qty(90)
->r()->setIndex = true;
//OR
$ma->product->data->price(100)->qty(90)
->r()->setIndex(true);
//OR
$ma->product->data->price(100)->qty(90)
->r()->eval('setIndex', true);
```

**Eval:**
