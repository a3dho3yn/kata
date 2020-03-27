<?php


namespace App;


class AgedBrie extends ItemWrapper
{
    protected function getFreshItemQualityChange(): int
    {
        return -1 * parent::getFreshItemQualityChange();
    }
}