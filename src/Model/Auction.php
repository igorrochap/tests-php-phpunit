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

    public function receiveBid(Bid $lance): void
    {
        $this->bids[] = $lance;
    }

    public function getBids(): array
    {
        return $this->bids;
    }
}
