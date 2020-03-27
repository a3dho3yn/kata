<?php


namespace App;


class ConjuredItem extends ItemWrapper
{
    protected function getFreshItemQualityChange(): int
    {
        return 2 * parent::getFreshItemQualityChange();
    }
}