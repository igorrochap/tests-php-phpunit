<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Auction;

class Evaluator
{
    private float $highestValue = -INF;
    private float $lowestValue = INF;

    public function evaluate(Auction $auction): void
    {
        foreach ($auction->getBids() as $bid) {
            if($bid->getValue() > $this->highestValue) {
                $this->highestValue = $bid->getValue();
            }
            if($bid->getValue() < $this->lowestValue) {
                $this->lowestValue = $bid->getValue();
            }
        }
    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }

    public function getLowestValue(): float
    {
        return $this->lowestValue;
    }
}