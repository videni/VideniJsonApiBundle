<?php

namespace Videni\Bundle\JsonApiBundle\Metadata;

use Metadata\AdvancedMetadataFactoryInterface;
use Videni\Bundle\JsonApiBundle\Exception\MappingNotFoundException;

/**
 * MetadataReader.
 */
class MetadataReader
{
    /**
     * @var AdvancedMetadataFactoryInterface
     */
    protected $reader;

    /**
     * Constructs a new instance of the MetadataReader.
     *
     * @param AdvancedMetadataFactoryInterface $reader The "low-level" metadata reader
     */
    public function __construct(AdvancedMetadataFactoryInterface $reader)
    {
        $this->reader = $reader;
    }

    public function hasApi(string $class): bool
    {
        $metadata = $this->reader->getMetadataForClass($class);

        return !!$metadata;
    }

    /**
     * Search for all classes that have files.
     *
     * @return array|null A list of classes that have files
     *
     * @throws \RuntimeException
     */
    public function getApiClasses(): ?array
    {
        return $this->reader->getAllClassNames();
    }
}
