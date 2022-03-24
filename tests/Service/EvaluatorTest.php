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
}