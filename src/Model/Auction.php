<?php

namespace Alura\Leilao\Model;

class Auction
{
    /** @var Bid[] */
    private array $bids;
    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
        $this->bids = [];
    }

    public function receiveBid(Bid $bid): void
    {
        if(!empty($this->bids) && $this->lastBidIsFromTheSameUser($bid)) {
            return;
        }
        if($this->quantityOfBidsFromTheSameUser($bid->getUser()) >= 5) {
            return;
        }
        $this->bids[] = $bid;
    }

    public function getBids(): array
    {
        return $this->bids;
    }

    private function lastBidIsFromTheSameUser(Bid $bid): bool
    {
        $lastBid = $this->bids[array_key_last($this->bids)];
        return $bid->getUser() === $lastBid->getUser();
    }

    private function quantityOfBidsFromTheSameUser(User $userOfTheBid): int
    {
        return array_reduce(
            $this->bids,
            function (int $currentTotal, Bid $currentBid) use ($userOfTheBid) {
                if($currentBid->getUser() === $userOfTheBid) {
                    return $currentTotal + 1;
                }
                return $currentTotal;
            },
            0);
    }
}
