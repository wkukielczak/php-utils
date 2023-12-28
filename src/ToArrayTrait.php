<?php

namespace Wkukielczak\PhpUtils;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

trait ToArrayTrait
{
    public function toArray(): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $listExtractors = [new ReflectionExtractor()];
        $propertyInfo = new PropertyInfoExtractor($listExtractors);

        $properties = $propertyInfo->getProperties(self::class);
        $data = [];
        foreach ($properties as $property) {
            $value = $propertyAccessor->getValue($this, $property);
            if (null !== $value) {
                $data[$property] = $value;
            }
        }

        return $data;
    }
}