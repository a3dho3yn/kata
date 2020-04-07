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

    public static function wrap(Item $item) {
        switch ($item->name) {
            case 'Aged Brie':
                return new AgedBrie($item);
            case 'Backstage passes to a TAFKAL80ETC concert':
                return new BackstagePass($item);
            case 'Sulfuras, Hand of Ragnaros':
                return new Sulfuras($item);
            case 'Conjured Mana Cake':
                return new ConjuredItem($item);
            default:
                return new self($item);
        }
    }


    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function __set($name, $value)
    {
        if ($name == 'quality') {
            $value = min(50, max(0, $value)); // clamp between 0-50
        }
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
        $this->sell_in -= 1;
    }

    protected function updateQuality(): void
    {
        $change = $this->getFreshItemQualityChange();
        if ($this->sell_in < 0) {
            $change = $this->getExpiredItemQualityChange();
        }

        $this->quality += $change;
    }

    /**
     * @return int
     */
    protected function getFreshItemQualityChange(): int
    {
        return -1;
    }

    /**
     * @return int
     */
    protected function getExpiredItemQualityChange(): int
    {
        return 2 * $this->getFreshItemQualityChange();
    }
}
