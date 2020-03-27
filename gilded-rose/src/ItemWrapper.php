<?php


namespace App;

/**
 * Class ItemWrapper
 *
 * @package App
 * @property string $name
 * @property integer $sell_in
 * @property integer $quality
 */
class ItemWrapper
{
    /**
     * @var Item
     */
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function __set($name, $value)
    {
        $this->item->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->item->{$name};
    }

    public function update(): void
    {
        $this->age();
        $this->updateQuality();
    }

    private function age(): void
    {
        if ($this->name != 'Sulfuras, Hand of Ragnaros') {
            $this->sell_in -= 1;
        }
    }

    private function updateQuality(): void
    {
        if ($this->name == 'Aged Brie') {
            $this->increaseQuality();
            if ($this->sell_in < 0) {
                $this->increaseQuality();
            }
        } elseif ($this->name == 'Backstage passes to a TAFKAL80ETC concert') {
            $this->increaseQuality();
            if ($this->sell_in < 10) {
                $this->increaseQuality();
            }
            if ($this->sell_in < 5) {
                $this->increaseQuality();
            }
            if ($this->sell_in < 0) {
                $this->quality -= $this->quality;
            }
        } elseif ($this->name == 'Sulfuras, Hand of Ragnaros') {
            // Nope! Legendary items don't change.
        } elseif ($this->name == 'Conjured Mana Cake') {
            $this->decreaseQuality();
            $this->decreaseQuality();
            if ($this->sell_in < 0) {
                $this->decreaseQuality();
                $this->decreaseQuality();
            }
        }else {
            $this->decreaseQuality();
            if ($this->sell_in < 0) {
                $this->decreaseQuality();
            }
        }
    }

    private function increaseQuality(): void
    {
        if ($this->quality < 50) {
            $this->quality += 1;
        }
    }

    private function decreaseQuality(): void
    {
        if ($this->quality > 0) {
            $this->quality -= 1;
        }
    }
}