<?php

namespace Yahtzee;

use Error;

final class Game {
    private $dice;
    private $timesRolled = 0;
    private $score = 0;
    private $categories = [];

    public function roll(array $which = [0,1,2,3,4]): array
    {
        if ($this->timesRolled >= 3) {
            throw new Error("could not roll more than three times in a row");
        }

        if (empty($this->dice) && count($which) < 5) {
            throw new DiceNotInitializedException("should roll all dices at the beginning");
        }

        $rolled = [];
        foreach ($which as $diceIndex) {
            $dice = random_int(1,6);
            $rolled[] = $dice;
            $this->dice[$diceIndex] = $dice;
        }

        $this->timesRolled++;
        return $rolled;
    }

    public function getDices(): array
    {
        if (empty($this->dice)) {
            throw new Error("not rolled yet");
        }

        return $this->dice;
    }

    public function setDice(array $dice): void
    {
        $dice = array_filter($dice, function($d) {
            return $d < 7 && $d > 0;
        });

        if (count($dice) !== 5) {
            throw new Error("should pass 5 dice");
        }

        $this->dice = $dice;
    }

    public function getScore(): int
    {
        return array_sum($this->categories);
    }

    public function submitScore(string $category)
    {
        if (!in_array($category, ['ones', 'twos', 'threes', 'fours', 'fives', 'sixes'])) {
            throw new Error("invalid configuration");
        }

        if (empty($this->dice)) {
            throw new DiceNotInitializedException();
        }

        if (isset($this->categories[$category])) {
            throw new CategoryUnavailableException();
        }

        switch ($category) {
            case 'ones':
                $this->categories[$category] = array_sum(array_filter($this->dice, function($d) { return $d === 1; }));
                break;
            case 'twos':
                $this->categories[$category] = array_sum(array_filter($this->dice, function($d) { return $d === 2; }));
                break;
            case 'threes':
                $this->categories[$category] = array_sum(array_filter($this->dice, function($d) { return $d === 3; }));
                break;
            case 'fours':
                $this->categories[$category] = array_sum(array_filter($this->dice, function($d) { return $d === 4; }));
                break;
            case 'fives':
                $this->categories[$category] = array_sum(array_filter($this->dice, function($d) { return $d === 5; }));
                break;
            case 'sixes':
                $this->categories[$category] = array_sum(array_filter($this->dice, function($d) { return $d === 6; }));
                break;
            
            default:
                $this->score = 0;
        }

        $this->dice = null;
        $this->timesRolled = 0;
    }
}