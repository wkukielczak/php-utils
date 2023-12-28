ToArrayTrait samples
====================

This little trait uses Symfony's PropertyInfo and PropertyAccess components to add `toArray()` method to models:

```php
class Person {
    use \Wkukielczak\PhpUtils\ToArrayTrait;
    
    private string $name;
    private string $lastName;
    
    // Getters and Setters (...)
}

$person = new Person();
$person->setName('Wojtek')->setLastName('Kukielczak');

print_r($person->toArray());
// Expected:
// Array
// (
//   [name] => Wojtek
//   [lastName] => Kukielczak
// )
```