<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Auction;
use Alura\Leilao\Model\Bid;
use Alura\Leilao\Model\User;
use Alura\Leilao\Service\Evaluator;
use PHPUnit\Framework\TestCase;

class EvaluatorTest extends TestCase
{
    public function testEvaluatorShouldFindTheHighestValueInAscendingOrder()
    {
        //arrange - given
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');

        $auction->receiveBid(new Bid($joao, 2000));
        $auction->receiveBid(new Bid($maria, 2500));

        $auctioneer = new Evaluator();

        //act - when
        $auctioneer->evaluate($auction);
        $highestValue = $auctioneer->getHighestValue();

        //assert - then
        self::assertEquals(2500, $highestValue);
    }

    public function testEvaluatorShouldFindTheHighestValueInDescendingOrder()
    {
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');

        $auction->receiveBid(new Bid($maria, 2500));
        $auction->receiveBid(new Bid($joao, 2000));

        $auctioneer = new Evaluator();

        $auctioneer->evaluate($auction);
        $highestValue = $auctioneer->getHighestValue();

        self::assertEquals(2500, $highestValue);
    }

    public function testEvaluatorShouldFindTheLowestValueInDescendingOrder()
    {
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');

        $auction->receiveBid(new Bid($maria, 2500));
        $auction->receiveBid(new Bid($joao, 2000));

        $auctioneer = new Evaluator();

        $auctioneer->evaluate($auction);
        $lowestValue = $auctioneer->getLowestValue();

        self::assertEquals(2000, $lowestValue);
    }

    public function testEvaluatorShouldFindTheLowestValueInAscendingOrder()
    {
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');

        $auction->receiveBid(new Bid($joao, 2000));
        $auction->receiveBid(new Bid($maria, 2500));

        $auctioneer = new Evaluator();

        $auctioneer->evaluate($auction);
        $lowestValue = $auctioneer->getLowestValue();

        self::assertEquals(2000, $lowestValue);
    }

    public function testEvaluatorShouldFindTheThreeHighestValues()
    {
        $auction = new Auction('Fiat 147 0Km');

        $joao = new User('João');
        $maria = new User('Maria');
        $rogerio = new User('Rogerio');
        $vanessa = new User('Vanessa');

        $auction->receiveBid(new Bid($rogerio, 1500));
        $auction->receiveBid(new Bid($maria, 1300));
        $auction->receiveBid(new Bid($vanessa, 2000));
        $auction->receiveBid(new Bid($joao, 1900));

        $auctioneer = new Evaluator();
        $auctioneer->evaluate($auction);
        $highestBids = $auctioneer->getHighestBids();

        self::assertCount(3, $highestBids);
        self::assertEquals(2000, $highestBids[0]->getValue());
        self::assertEquals(1900, $highestBids[1]->getValue());
        self::assertEquals(1500, $highestBids[2]->getValue());
    }
}