<?php

use ArgsParser\Scheme;
use ArgsParser\ArgDefinition;
use PHPUnit\Framework\TestCase;

final class SchemeTest extends TestCase
{
    public function testItRequiresListOfArgs() {
        // Assert
        $this->expectException(ArgumentCountError::class);
        
        // Act
        $scheme = new Scheme();
    }

    public function test_newSchemeWithArgs_shouldCreated() {
        // Arrange
        $args = [new ArgDefinition("l", "string")];
        
        // Act
        $scheme = new Scheme($args);

        // Assert
        $this->assertNotNull($scheme);
    }

    public function testShouldReturnArgTypeByName()
    {
        // Arrange
        $args = [new ArgDefinition("l", "string")];
        $scheme = new Scheme($args);

        // Act
        $type = $scheme->getArgType('l');

        // Assert
        $this->assertEquals('string', $type);
    }

    public function testShouldReturnArgsList()
    {
        // Arrange
        $scheme = new Scheme([
            new ArgDefinition("l", "string"),
            new ArgDefinition("p", "number")
        ]);

        // Act
        $args = $scheme->getArgs();

        // Assert
        $this->assertCount(2, $args);
    }
}