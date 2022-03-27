<?php

namespace Alura\Leilao\Model;

class Auction
{
    /** @var Bid[] */
    private array $bids;
    private string $description;
    private bool $finalized;

    public function __construct(string $description)
    {
        $this->description = $description;
        $this->bids = [];
        $this->finalized = false;
    }

    public function receiveBid(Bid $bid): void
    {
        if(!empty($this->bids) && $this->isLastBidFromTheSameUser($bid)) {
            throw new \DomainException("User can't do 2 consecutive bids");
        }
        if($this->quantityOfBidsFromTheSameUser($bid->getUser()) >= 5) {
            throw new \DomainException("User can't do more than 5 bids in the same auction");
        }
        $this->bids[] = $bid;
    }

    public function getBids(): array
    {
        return $this->bids;
    }

    public function finish()
    {
        $this->finalized = true;
    }

    public function isFinalized(): bool
    {
        return $this->finalized;
    }

    private function isLastBidFromTheSameUser(Bid $bid): bool
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
