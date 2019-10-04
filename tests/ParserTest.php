<?php

use ArgsParser\ArgDefinition;
use ArgsParser\Parser;
use ArgsParser\Scheme;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    /** @var Parser */
    private $parser;

    public function setUp()
    {
        parent::setUp();

        $args = [
            new ArgDefinition("l", "boolean"),
            new ArgDefinition("p", "number"),
            new ArgDefinition("d", "string")
        ];
        $scheme = new Scheme($args);
        $this->parser = new Parser($scheme);
    }

    public function testShouldSeparateArgs()
    {
        // Arrange
        // done in setUp

        // Act
        $parsedArgs = $this->parser->parse("-l -p 514 -d /dev/null");

        // Assert
        $this->assertEquals(3, count($parsedArgs));        
    }

    public function testShouldConvertTypes()
    {
        // Arrange
        // done in setUp

        // Act
        $parsedArgs = $this->parser->parse("-l -p 514 -d /dev/null");

        // Assert
        $this->assertEquals(true, $parsedArgs['l']);
        $this->assertEquals(514, $parsedArgs['p']);
        $this->assertEquals("/dev/null", $parsedArgs['d']);
    }

    public function testShouldReturnDefaultValuesIfNoValueProvided()
    {
        // Arrange
        // done in setUp

        // Act
        $parsedArgs = $this->parser->parse("");

        // Assert
        $this->assertEquals(false, $parsedArgs['l']);
        $this->assertEquals(0, $parsedArgs['p']);
        $this->assertEquals("", $parsedArgs['d']);
    }

    public function testShouldReturnDefaultValueIfEmptyValueProvided()
    {
        // Act
        $parsedArgs = $this->parser->parse("-p");
        
        // Assert
        $this->assertEquals(0, $parsedArgs['p']);
    }

    public function testShouldIgnoreWhiteSpace()
    {
        // Act
        $parsedArgs = $this->parser->parse("   -p      514     -d \t /dev/null   ");

        // Assert
        $this->assertEquals(514, $parsedArgs['p']);
        $this->assertEquals("/dev/null", $parsedArgs['d']);
    }

    public function testShouldReturnErrorIfInvalidNumberProvided()
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("forty two is not a number");

        // Act
        $parsedArgs = $this->parser->parse("-p forty two");
    }
}