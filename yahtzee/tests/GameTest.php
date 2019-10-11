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
}