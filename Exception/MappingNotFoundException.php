<?php

namespace Videni\Bundle\JsonApiBundle\Exception;

class MappingNotFoundException extends \RuntimeException
{
    public static function createNotFoundForClassAndField($mapping, $class, $field): self
    {
        return new self(
            sprintf('Mapping "%s" does not exist. The configuration for the class "%s" is probably incorrect as the mapping to use for the field "%s" could not be found.', $mapping, $class, $field)
        );
    }

    public static function createNotFoundForClass(string $mapping, string $class): self
    {
        if ('' === $mapping) {
            return new self(
                sprintf('Mapping not found. The configuration for the class "%s" is probably incorrect.', $class)
            );
        }

        return new self(
            sprintf('Mapping "%s" does not exist. The configuration for the class "%s" is probably incorrect.', $mapping, $class)
        );
    }
}
