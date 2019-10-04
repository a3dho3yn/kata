<?php

namespace ArgsParser;

final class Scheme {
    
    /** @var array */
    private $args;

    public function __construct(array $args) {
        /** @var ArgDefinition[] $args */
        foreach ($args as $a) {
            $this->args[$a->getName()] = $a;
        }
    }

    public function getArgType(string $name)
    {
        return $this->args[$name]->getType();
    }

    public function getArgs()
    {
        return array_values($this->args);
    }

}