<?php


namespace App;


class BackstagePass extends ItemWrapper
{
    protected function getFreshItemQualityChange(): int
    {
        $change = 1;
        if ($this->sell_in < 10) {
            $change = 2;
        }
        if ($this->sell_in < 5) {
            $change = 3;
        }

        return $change;
    }

    protected function getExpiredItemQualityChange(): int
    {
        return -1 * $this->quality; // Leads to 0 = q + (-q)
    }

}