<?php

namespace Yahtzee;

use Error;

final class Game {
    private $dices;
    private $timesRolled = 0;

    public function roll(array $which = [0,1,2,3,4]): array
    {
        if ($this->timesRolled >= 3) {
            throw new Error("could not roll more than three times in a row");
        }

        if (empty($this->dices) && count($which) < 5) {
            throw new Error("should roll all dices at the beginning");
        }

        $rolled = [];
        foreach ($which as $diceIndex) {
            $dice = random_int(1,6);
            $rolled[] = $dice;
            $this->dices[$diceIndex] = $dice;
        }

        $this->timesRolled++;
        return $rolled;
    }

    public function getDices(): array
    {
        if (empty($this->dices)) {
            throw new Error("not rolled yet");
        }

        return $this->dices;
    }

    public function submitScore(string $configuration)
    {
        if (!in_array($configuration, ['ones', 'twos', 'threes', 'fours', 'fives', 'sixes'])) {
            throw new Error("invalid configuration");
        }

        $this->timesRolled = 0;
    }
}