<?php /** @noinspection PhpUnused */

namespace Wkukielczak\PhpUtils;

use Doctrine\ORM\QueryBuilder;

/**
 * A helper class to operate on geographical coordinates
 */
class GeoCoordinates
{
    /**
     * Earth radius in kilometers. Use it if you want to count distance in kilometers
     */
    const EARTH_RADIUS_KM = 6371;

    /**
     * Earth radius in miles. Use it if you want to count distance in miles
     */
    const EARTH_RADIUS_MI = 3959;

    private static function getAliasedFieldName(QueryBuilder $queryBuilder, string $fieldName): string
    {
        $rootAliases = $queryBuilder->getRootAliases();
        if (!empty($rootAliases)) {
            $fieldName = sprintf('%s.%s', $rootAliases[0], $fieldName);
        }

        return $fieldName;
    }

    /**
     * Add Haversine Formulae to a query
     *
     * More info about SQL: https://enlear.academy/working-with-geo-coordinates-in-mysql-5451e54cddec
     *
     * For this query to work you have to implement following custom DQL functions
     * - ACOS()
     * - COS()
     * - RADIANS()
     * - SIN()
     * Check Doctrine's docs to see how to do it: https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/cookbook/dql-user-defined-functions.html#dql-user-defined-functions
     * Registering custom DQL in Symfony: https://symfony.com/doc/current/doctrine/custom_dql_functions.html
     *
     * @param QueryBuilder $queryBuilder
     * @param float $latitude
     * @param float $longitude
     * @param ?int $maxDistance
     * @param string $orderDir
     * @param int $earthRadius
     */
    public static function addHaversineDQL(
        QueryBuilder $queryBuilder,
        float $latitude,
        float $longitude,
        ?int $maxDistance = null,
        string $orderDir = 'ASC',
        int $earthRadius = self::EARTH_RADIUS_KM
    ): void
    {
        $latitudeField = self::getAliasedFieldName($queryBuilder, 'latitude');
        $longitudeField = self::getAliasedFieldName($queryBuilder, 'longitude');

        $dql = sprintf('(%d * Acos (Cos (Radians(%F)) * Cos(Radians(%s)) * Cos(Radians(%s) - Radians(%F)) + 
            Sin(Radians(%F)) * Sin(Radians(%s)))) AS distance', $earthRadius, $latitude, $latitudeField,
            $longitudeField, $longitude, $latitude, $latitudeField);

        $queryBuilder->addSelect($dql);
        if ($maxDistance) {
            $queryBuilder->having("distance < $maxDistance");
        }
        $queryBuilder->orderBy("distance", $orderDir);
    }

    /**
     * Count the distance between two points using haversine formulae. This util is dedicated
     * for single-counting operations.
     *
     * @param float $latitudeFrom
     * @param float $longitudeFrom
     * @param float $latitudeTo
     * @param float $longitudeTo
     * @param int $earthRadius
     * @return float
     */
    public static function calculateHaversineDistance(
        float $latitudeFrom,
        float $longitudeFrom,
        float $latitudeTo,
        float $longitudeTo,
        int $earthRadius = self::EARTH_RADIUS_KM
    ): float
    {
        $distanceLatitude = ($latitudeTo - $latitudeFrom) * M_PI / 180.0;
        $distanceLongitude = ($longitudeTo - $longitudeFrom) * M_PI / 180.0;

        $radLatFrom = $latitudeFrom * M_PI / 180.0;
        $radLatTo = $latitudeTo * M_PI / 180.0;

        $formula =  pow(sin($distanceLatitude / 2), 2) +
            pow(sin($distanceLongitude / 2), 2) *
            cos($radLatFrom) * cos($radLatTo);

        return $earthRadius * (2 * asin(sqrt($formula)));
    }
}
