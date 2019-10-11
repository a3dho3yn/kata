<?php

use PHPUnit\Framework\TestCase;
use Yahtzee\Game;

class GameTest extends TestCase {
    public function testRollingDiceReturnsFiveRandomNumber()
    {
        // Arrange
        $game = new Game();

        // Act
        $dice = $game->roll();

        // Assert
        $this->assertCount(5, $dice);
    }

    public function testRollingDiceShouldAllowChoosingDicesToRoll()
    {
        // Arrange
        $game = new Game();

        // Act
        $game->roll();
        $dice = $game->roll([1,3,4]);

        // Assert
        $this->assertCount(3, $dice);
    }

    public function testReturnsAllDices()
    {
        // Arrange
        $game = new Game();

        // Act
        $game->roll();
        $dice = $game->getDices();

        // Assert
        $this->assertCount(5, $dice);
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

    /** @expectedException Error */
    public function testShouldReturnErrorWhenTryingToGetDicesBeforeFirstRoll()
    {
        // Arrange
        $game = new Game();

        // Act
        $game->getDices();
    }

    /** @expectedException Yahtzee\DiceNotInitializedException */
    public function testShouldNotAllowChoosingDicesToRollAtFirstRun()
    {
        // Arrange
        $game = new Game();

        // Act
        $game->roll([1,2]);
    }

    /** @expectedException Error */
    public function testShouldNotAllowRollingMoreThanThreeTimes()
    {
        // Arrange
        $game = new Game();
        $game->roll();
        $game->roll();
        $game->roll();
        
        // Act
        $game->roll();
    }

    /** @doesNotPerformAssertions */
    public function testShouldAllowRollingAfterSubmittingScore()
    {
        // Arrange
        $game = new Game();
        $game->roll();
        $game->roll();
        $game->roll();
        $game->submitScore('threes');

        // Act
        $game->roll();
    }

    /** @expectedException Error */
    public function testSubmitScoreRequiresOneOfPredefinedConfigurations()
    {
        // Arrange
        $game = new Game();
        $game->roll();

        // Act
        $game->submitScore('foo');
    }

    /**
     * @dataProvider submitScoreTestCaseProvider
     */
    public function testSubmitScoreShouldUpdateUsersScoreBasedOnConfigrationAndDices($category, $dice, $score)
    {
        // Arrange
        $game = new Game();
        $game->setDice($dice);

        // Act
        $game->submitScore($category);

        // Assert
        $this->assertEquals($score, $game->getScore());
    }

    public function submitScoreTestCaseProvider()
    {
        return [
            ['ones',  [1,1,1,1,2], 4],
            ['twos',  [2,3,4,2,2], 6],
            ['threes',[3,1,3,1,3], 9],
            ['fours', [2,3,4,5,6], 4],
            ['fives', [1,1,1,1,1], 0],
            ['sixes', [6,6,6,6,6], 30],
        ];
    }

    /** @expectedException Yahtzee\CategoryUnavailableException */
    public function testShouldPreventSumbittingTwiceForSingleCategory()
    {
        // Arrange
        $game = new Game();
        $game->roll();
        $game->submitScore('ones');
        $game->roll();

        // Act
        $game->submitScore('ones');
    }

    /** @expectedException Yahtzee\DiceNotInitializedException */
    public function testShouldResetDiceAfterSubmitScore()
    {
        // Arrange
        $game = new Game();
        $game->roll();
        $game->submitScore('ones');

        // Act
        $game->submitScore('ones');
    }

    public function testShouldCalculateTotalScoreWhenGameFinished()
    {
        // Arrange
        $game = new Game();
        $categories = ['ones', 'twos', 'threes', 'fours', 'fives', 'sixes'];
        foreach ($categories as $c) {
            $game->setDice([1,2,3,4,5]);
            $game->submitScore($c);
        }

        // Act
        $game->finish();

        // Assert
        $this->assertEquals(1+2+3+4+5+0, $game->getScore());
    }
}