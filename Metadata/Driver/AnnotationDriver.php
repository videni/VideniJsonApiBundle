<?php

namespace Videni\Bundle\JsonApiBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader as AnnotationReader;
use Metadata\Driver\AdvancedDriverInterface;
use Videni\Bundle\JsonApiBundle\Annotation\JsonApi;
use Videni\Bundle\JsonApiBundle\Annotation\Field;
use Videni\Bundle\JsonApiBundle\Metadata\ClassMetadata;

class AnnotationDriver implements AdvancedDriverInterface
{
    protected $reader;

    public function __construct(AnnotationReader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        if (!$this->hasJsonApi($class)) {
            return;
        }

        $classMetadata = new ClassMetadata($class->name);
        $classMetadata->fileResources[] = $class->getFileName();

        foreach ($class->getProperties() as $property) {
            $field = $this->reader->getPropertyAnnotation($property, Field::class);
            if (null === $field) {
                continue;
            }
            $fieldMetadata = [
                'absolute' => $field->isAbsolute(),
            ];

            $classMetadata->fields[$property->getName()] = $fieldMetadata;
        }

        return $classMetadata;
    }

    public function getAllClassNames()
    {
        return [];
    }

    protected function hasJsonApi(\ReflectionClass $class)
    {
        return null !== $this->reader->getClassAnnotation($class, JsonApi::class);
    }
}
