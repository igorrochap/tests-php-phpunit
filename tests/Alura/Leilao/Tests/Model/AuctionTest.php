<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Auction;
use Alura\Leilao\Model\Bid;
use Alura\Leilao\Model\User;
use PHPUnit\Framework\TestCase;

class AuctionTest extends TestCase
{
    public function testAuctionShouldNotReceiveTwoConsecutiveBidsFromTheSameUser()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("User can't do 2 consecutive bids");

        $auction = new Auction('Brasilia Amarela');
        $ana = new User('Ana');

        $auction->receiveBid(new Bid($ana, 1000));
        $auction->receiveBid(new Bid($ana, 1500));
    }

    public function testAuctionShouldNotAcceptMoreThen5BidsFromTheSameUser()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("User can't do more than 5 bids in the same auction");

        $auction = new Auction('Fiat Marea Turbo');

        $joao = new User('João');
        $maria = new User('Maria');

        $auction->receiveBid(new Bid($joao, 1000));
        $auction->receiveBid(new Bid($maria, 1500));
        $auction->receiveBid(new Bid($joao, 2000));
        $auction->receiveBid(new Bid($maria, 2500));
        $auction->receiveBid(new Bid($joao, 3000));
        $auction->receiveBid(new Bid($maria, 4500));
        $auction->receiveBid(new Bid($joao, 4000));
        $auction->receiveBid(new Bid($maria, 4500));
        $auction->receiveBid(new Bid($joao, 5000));
        $auction->receiveBid(new Bid($maria, 5500));

        $auction->receiveBid(new Bid($joao, 6000));
    }

    /**
     * @dataProvider generateBids
     */
    public function testAuctionShouldReceiveBids(int $bidQuantity, Auction $auction, array $values)
    {
        static::assertCount($bidQuantity, $auction->getBids());
        foreach ($values as $key => $expectedValue) {
            $valueOfTheBid = $auction->getBids()[$key]->getValue();
            static::assertEquals($expectedValue, $valueOfTheBid);
        }
    }

    public function generateBids(): array
    {
        $maria = new User('Maria');
        $joao = new User('João');

        $oneBidAuction = new Auction('Fusca 1972 0Km');
        $oneBidAuction->receiveBid(new Bid($joao, 5000));

        $twoBidsAuction = new Auction('Fiat 147 0Km');
        $twoBidsAuction->receiveBid(new Bid($maria, 1000));
        $twoBidsAuction->receiveBid(new Bid($joao, 2000));

        return [
            "one bid" => [1, $oneBidAuction, [5000]],
            "two bids" => [2, $twoBidsAuction, [1000, 2000]]
        ];
    }
}