<?php

use PHPUnit\Framework\TestCase;
use Yahtzee\Game;

class GameTest extends TestCase {
    public function testRollingDiceReturnsFiveRandomNumber()
    {
        // Arrange
        $game = new Game();

        // Act
        $dices = $game->roll();

        // Assert
        $this->assertCount(5, $dices);
    }

    public function testRollingDiceShouldAllowChoosingDicesToRoll()
    {
        // Arrange
        $game = new Game();

        // Act
        $game->roll();
        $dices = $game->roll([1,3,4]);

        // Assert
        $this->assertCount(3, $dices);
    }

    public function testReturnsAllDices()
    {
        // Arrange
        $game = new Game();

        // Act
        $game->roll();
        $dices = $game->getDices();

        // Assert
        $this->assertCount(5, $dices);
    }

    public function testShouldKeepStateOfNotRolledDices()
    {
        // Arrange
        $game = new Game();

        // Act
        $firstRun = $game->roll();
        $game->roll([1,3]);

        // Assert
        $this->assertCount(5, $game->getDices());
        $this->assertEquals($firstRun[4], $game->getDices()[4]);
    }

    public function testShouldReturnErrorWhenTryingToGetDicesBeforeFirstRoll()
    {
        // Assert
        $this->expectException(Error::class);

        // Arrange
        $game = new Game();

        // Act
        $game->getDices();
    }

    public function testShouldNotAllowChoosingDicesToRollAtFirstRun()
    {
        // Assert
        $this->expectException(Error::class);

        // Arrange
        $game = new Game();

        // Act
        $game->roll([1,2]);
    }
}