CryptoUtil samples
==================

So far it's just a float checker. In opposite to the built-in PHP `is_float()` function, this util also detects 
stringified floats:

```php
$someValue = '71.5';
if (Number::isFloat($someValue)) {
    $floatValue = floatval($someValue);
    // $floatValue = double(71.5)
} else {
    echo 'The given value can\'t be typed to float';
}
```
