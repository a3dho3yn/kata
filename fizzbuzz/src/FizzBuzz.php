<?php

namespace FizzBuzz;

final class FizzBuzz {
    private $number;

    public function __construct(int $initialNumber = 0)
    {
        $this->number = $initialNumber;
    }

    public function next()
    {
        $next = ++$this->number;
        return ($next % 3 === 0) ? 'Fizz' : (($next % 5 === 0) ? 'Buzz' : $next);
    }
}