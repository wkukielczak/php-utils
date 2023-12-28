CryptoUtil samples
==================

Example of use:

```php
$randomToken = Crypto::getToken();
// Expected value is a randomly generated string of length of 32 characters.
// This string is safe to use in URLs

$randomToken = Crypto::getToken(6);
// As in previous example, but this time the string has just 6 characters

$randomNumber = Crypto::randSecure(71, 951);
// Expected value is a random number between 71 and 951 inclusively
```

Additional lecture: [why to use cryptographic-secure random generators?](https://cryptobook.nakov.com/secure-random-generators)
