PHP Utils
=========

This is a collection of my personal utils I use repeatedly
in projects I drive. Whenever I have a new util which 
I need to re-use it lands here. Feel free to use and 
modify the tools from this repository. It's free!

# Installation

Edit your `composer.json` file and add the following:

```json
{
  "require": {
    "wkukielczak/php-utils": "*"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/wkukielczak/php-utils"
    }
  ]
}
```

# Utils index

- `ArrayUtil` contains helpers to use on arrays ([how to use](docs/ARRAY_UTIL.md))
- `Crypto` is a safe number and string generator ([how to use](docs/CRYPTO.md))
- `GeoCoordinates` is intended to use whenever
  you need to count geographic distance between 
  two points or query the SQL database to find 
  the nearest spots ([how to use](docs/GEO_COORDINATES.md))
- `Number` to operate on numbers ([how to use](docs/NUMBER.md))
- `ToArrayTrait` a simple way to add "toArray()" method to your models ([how to use](docs/TO_ARRAY.md))

If you believe something is missing - you are right!
That's because I did not need it. But feel free to use
the repository as a base for your own utils base

# Using `GeoCoordinates` with Doctrine

There's a `GeoCoordinates::addHaversineDQL()` method
to find the nearest spots in your database. If you
want to use it, you need to set up your doctrine 
installation before. 

Please register the following custom DQL functions to 
your doctrine installation:

- `Wkukielczak\PhpUtils\Doctrine\Acos`
- `Wkukielczak\PhpUtils\Doctrine\Cos`
- `Wkukielczak\PhpUtils\Doctrine\Radians`
- `Wkukielczak\PhpUtils\Doctrine\Sin`

To register custom DQL function to a clear Doctrine installation see the
[DQL User Defined Functions](https://www.doctrine-project.org/projects/doctrine-orm/en/current/cookbook/dql-user-defined-functions.html#dql-user-defined-functions)

To register custom DQL functions in Symfony project, 
see the [How to Register custom DQL Functions](https://symfony.com/doc/current/doctrine/custom_dql_functions.html)

# Build and test cheatsheet

Build

```shell
docker build -t wkukielczak/php-utils:latest .
# Versioned variation
docker build -t wkukielczak/php-utils:$(git rev-parse --short HEAD) .
```

Install dependencies

```shell
docker run -it \
  -v $(pwd):/vol/app \
  wkukielczak/php-utils:latest composer install
```

Run PHPUnit tests

```bash
docker run -it \
  -v $(pwd):/vol/app \
  wkukielczak/php-utils:latest vendor/bin/phpunit \
  --coverage-html output \
  --coverage-filter src/ \
  --display-notices \
  --display-warnings \
  --display-errors \
  tests/
```
