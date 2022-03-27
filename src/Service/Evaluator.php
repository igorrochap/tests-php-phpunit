<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Auction;
use Alura\Leilao\Model\Bid;

class Evaluator
{
    private float $highestValue;
    private float $lowestValue;
    private array $highestBids;

    public function evaluate(Auction $auction): void
    {
        if($auction->isFinalized()) {
            throw new \DomainException("Auction alredy finalized");
        }
        if(empty($auction->getBids())) {
            throw new \DomainException("Isn't possible to evaluate an empty auction");
        }
        $bids = $auction->getBids();
        usort($bids, function (Bid $bid1, Bid $bid2) {
            return $bid2->getValue() - $bid1->getValue();
        });
        $this->highestValue = $bids[0]->getValue();
        $this->lowestValue = $bids[count($bids) - 1]->getValue();
        $this->highestBids = array_slice($bids, 0, 3);
    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }

    public function getLowestValue(): float
    {
        return $this->lowestValue;
    }

    /**
     * @return Bid[]
     */
    public function getHighestBids(): array
    {
        return $this->highestBids;
    }
}