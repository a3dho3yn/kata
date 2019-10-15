<?php

use FizzBuzz\FizzBuzz;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase {
    public function testShouldReturnNextNumber()
    {
        $fizzbuzz = new FizzBuzz();

        $next = $fizzbuzz->next();

        $this->assertEquals(1, $next);
        $this->assertEquals(2, $fizzbuzz->next());
    }

    public function testShouldGetInitialValue()
    {
        $fizzbuzz = new FizzBuzz(31);

        $next = $fizzbuzz->next();

        $this->assertEquals(32, $next);
    }

    public function testShouldReturnFizzWhenDivisableByThree()
    {
        $fizzbuzz = new FizzBuzz(2);

        $next = $fizzbuzz->next();

        $this->assertEquals('Fizz', $next);
    }

    public function testShouldReturnBuzzWhenDivisableByFive()
    {
        $fizzbuzz = new FizzBuzz(4);

        $next = $fizzbuzz->next();

        $this->assertEquals('Buzz', $next);
    }
}