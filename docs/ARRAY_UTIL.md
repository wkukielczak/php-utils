ArrayUtil samples
=================

Example of use:

```php
$fruits = [
    'apple' => ['price' => 5.50, 'unit' => 'kg'],
    'banana' => ['price' => 10.99, 'unit' => 'kg'],
    'mango' => ['price' => 7.89, 'unit' => 'pcs']
];

$applePrice = ArrayUtil::safeGet('price', ArrayUtil::safeGet('apple', $fruits, []));
// Expected value of $applePrice: 5.50

$pineapple = ArrayUtil::safeGet('pineapple', $fruits, 'Not found');
// Expected value of $pineapple: 'Not found'

$pineapple = ArrayUtil::safeGet('pineapple', $fruits);
// Expected value of $pineapple: null

$pineapplePrice = ArrayUtil::safeGet('price', ArrayUtil::safeGet('pineapple', $fruits));
// Expected value of $pineapplePrice: null
```