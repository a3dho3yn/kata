<?php

namespace ArgsParser;

final class ArgDefinition {
    /** @var string */
    private $name;

    /** @var string */
    private $type;

    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDefaultValue()
    {
        assert(in_array($this->type, ['string', 'boolean', 'number']));

        if ($this->type === 'string') {
            return '';
        }

        if ($this->type === 'boolean') {
            return false;
        }

        if ($this->type === 'number') {
            return 0;
        }
    }
}