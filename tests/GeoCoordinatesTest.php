<?php

namespace Wkukielczak\PhpUtils\Tests;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use PHPUnit\Framework\TestCase;
use Wkukielczak\PhpUtils\Doctrine\Acos;
use Wkukielczak\PhpUtils\Doctrine\Cos;
use Wkukielczak\PhpUtils\Doctrine\Radians;
use Wkukielczak\PhpUtils\Doctrine\Sin;
use Wkukielczak\PhpUtils\GeoCoordinates;

class GeoCoordinatesTest extends TestCase
{
    private EntityManagerInterface $entityManager;

    /**
     * @return void
     * @throws Exception
     * @throws MissingMappingDriverImplementation
     */
    public function setUp(): void
    {
        $paths = ['/src/Entities'];
        $isDevMode = true;

        $dbParams = [
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'db',
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $config->addCustomNumericFunction('acos', Acos::class);
        $config->addCustomNumericFunction('cos', Cos::class);
        $config->addCustomNumericFunction('radians', Radians::class);
        $config->addCustomNumericFunction('sin', Sin::class);

        $connection = DriverManager::getConnection($dbParams, $config);
        $this->entityManager = new EntityManager($connection, $config);
    }

    public function testAddHaversineDQLShouldCorrectlyAddDQLPart(): void
    {
        $lat = 37.7576793;
        $lon = -122.50764;
        $queryBuilder = $this->entityManager->createQueryBuilder();
        GeoCoordinates::addHaversineDQL($queryBuilder, $lat, $lon);

        $expected = sprintf('SELECT (%d * Acos (Cos (Radians(%F)) * Cos(Radians(%s)) * Cos(Radians(%s) - Radians(%F)) + 
            Sin(Radians(%F)) * Sin(Radians(%s)))) AS distance ORDER BY distance ASC',
            GeoCoordinates::EARTH_RADIUS_KM, $lat, 'latitude', 'longitude', $lon, $lat, 'latitude');

        $this->assertEquals($expected, $queryBuilder->getDQL());
    }

    public function testAddHaversineDQLWithDistanceLimitShouldCorrectlyAddDQLPart(): void
    {
        $lat = 37.7576793;
        $lon = -122.50764;
        $maxDistance = 40;
        $queryBuilder = $this->entityManager->createQueryBuilder();
        GeoCoordinates::addHaversineDQL($queryBuilder, $lat, $lon, $maxDistance, 'DESC');

        $expected = sprintf('SELECT (%d * Acos (Cos (Radians(%F)) * Cos(Radians(%s)) * Cos(Radians(%s) - Radians(%F)) + 
            Sin(Radians(%F)) * Sin(Radians(%s)))) AS distance HAVING distance < %d ORDER BY distance DESC',
            GeoCoordinates::EARTH_RADIUS_KM, $lat, 'latitude', 'longitude', $lon, $lat, 'latitude', $maxDistance);

        $this->assertEquals($expected, $queryBuilder->getDQL());
    }

    public function testAddHaversineDQLInMilesShouldCorrectlyAddDQLPart(): void
    {
        $lat = 37.7576793;
        $lon = -122.50764;
        $queryBuilder = $this->entityManager->createQueryBuilder();
        GeoCoordinates::addHaversineDQL($queryBuilder, $lat, $lon, null, 'ASC', GeoCoordinates::EARTH_RADIUS_MI);

        $expected = sprintf('SELECT (%d * Acos (Cos (Radians(%F)) * Cos(Radians(%s)) * Cos(Radians(%s) - Radians(%F)) + 
            Sin(Radians(%F)) * Sin(Radians(%s)))) AS distance ORDER BY distance ASC',
            GeoCoordinates::EARTH_RADIUS_MI, $lat, 'latitude', 'longitude', $lon, $lat, 'latitude');

        $this->assertEquals($expected, $queryBuilder->getDQL());
    }

    public function testCalculateDistanceShouldCorrectlyCountTheDistance(): void
    {
        $latFrom = 37.7597704;
        $lonFrom = -122.4271145;
        $latTo = 37.7749295;
        $lonTo = -122.4194155;

        $expectedDistanceKm = 1.8163915776362647;
        $expectedDistanceMi = 1.1287230035884432;

        $distanceKm = GeoCoordinates::calculateHaversineDistance($latFrom, $lonFrom, $latTo, $lonTo);
        $distanceMi = GeoCoordinates::calculateHaversineDistance(
            $latFrom,
            $lonFrom,
            $latTo,
            $lonTo,
            GeoCoordinates::EARTH_RADIUS_MI
        );

        $this->assertEquals($expectedDistanceKm, $distanceKm);
        $this->assertEquals($expectedDistanceMi, $distanceMi);
    }
}