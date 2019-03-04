<?php

namespace Videni\Bundle\JsonApiBundle\Metadata;

use Metadata\ClassMetadata as BaseClassMetadata;

class ClassMetadata extends BaseClassMetadata
{
    public $type;
    public $id;
    public $attributes = [];
    public $relationships = [];

    public function serialize(): string
    {
        return serialize([
            $this->type,
            $this->id,
            $this->attributes,
            $this->relationships,
            parent::serialize(),
        ]);
    }

    public function unserialize($str): void
    {
        [   $this->type,
            $this->id,
            $this->attributes,
            $this->relationships,
            $parentStr
        ] = unserialize($str);

        parent::unserialize($parentStr);
    }
}
