<?php

namespace ArgsParser;

final class Parser {
    private $scheme;

    public function __construct(Scheme $scheme)
    {
        $this->scheme = $scheme;
    }

    public function parse(string $args): array
    {
        $args = array_filter(array_map(function($a) {
            return trim($a);
        }, explode('-', $args)));

        $result = [];
        foreach ($args as $a) {
            $name = substr($a, 0, 1);
            $value = trim(substr($a, 1));
            $type = $this->scheme->getArgType($name);
            $result[$name] = self::convertType($value, $type);
        }

        foreach ($this->scheme->getArgs() as $arg) {
            if (!isset($result[$arg->getName()])) {
                $result[$arg->getName()] = $arg->getDefaultValue();
            }
        }

        return $result;
    }

    public static function convertType(string $value, string $type)
    {
        assert(in_array($type, ['string', 'boolean', 'number']));

        if ($type === 'string') {
            return $value;
        }
        
        if ($type === 'boolean') {
            return true;
        }

        if ($type === 'number') {
            return (int)$value;
        }
    }
}