GeoCoordinates samples
======================

## Using the util to calculate distance between given coordinates:

```php
$latFrom = 37.7597704;
$lonFrom = -122.4271145;
$latTo = 37.7749295;
$lonTo = -122.4194155;

$distanceKm = GeoCoordinates::calculateHaversineDistance($latFrom, $lonFrom, $latTo, $lonTo);
// $distanceKm = 1.8163915776362647 km

$distanceMi = GeoCoordinates::calculateHaversineDistance($latFrom, $lonFrom, $latTo, $lonTo, GeoCoordinates::EARTH_RADIUS_MI);
// $distanceMi = 1.1287230035884432 mil
```

## Using the util with Symfony/Doctrine to query DB for places and sort them by a distance: 

The database table, that you are about to query should have `latitude` and `longitude` columns:
```mysql
CREATE TABLE places (
    id int,
    name VARCHAR(64),
    latitude DOUBLE(10,16),
    longitude DOUBLE(10,16)
);
```

First, configure the doctrine to use additional math functions:

`config/packages/doctrine.yaml`
```yaml
doctrine:
    orm:
        # ...
        dql:
            numeric_functions:
                acos: Wkukielczak\PhpUtils\Doctrine\Acos
                cos: Wkukielczak\PhpUtils\Doctrine\Cos
                radians: Wkukielczak\PhpUtils\Doctrine\Radians
                sin: Wkukielczak\PhpUtils\Doctrine\Sin
```

Now you can use the util to query DB:

```php
class PlaceRepository extends ServiceEntityRepository
{
    /**
     * @return Place[]
     */
    public function findByDistance(float $userLat, float $userLon, ?int $maxDistance = null): ?array
    {
        $qb = $this->createQueryBuilder('p');
        GeoCoordinates::addHaversineDQL($qb, $userLat, $userLon, $maxDistance);
        
        return $qb->getQuery()->getResult();
    }
}
```

The `findByDistance()` method will return `Place`s sorted by distance from given `$userLat` and `$userLon` ascending.