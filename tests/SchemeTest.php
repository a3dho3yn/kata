<?php

use ArgsParser\Scheme;
use ArgsParser\ArgDefinition;
use PHPUnit\Framework\TestCase;

final class SchemeTest extends TestCase
{
    /**
     * @expectedException ArgumentCountError::class
     */
    public function testItRequiresListOfArgs() {
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
}