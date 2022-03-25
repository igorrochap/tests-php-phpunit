<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Auction;
use Alura\Leilao\Model\Bid;
use Alura\Leilao\Model\User;
use Alura\Leilao\Service\Evaluator;
use PHPUnit\Framework\TestCase;

class EvaluatorTest extends TestCase
{
    private Evaluator $auctioneer;

    protected function setUp(): void
    {
        $this->auctioneer = new Evaluator();
    }

    /**
     * @dataProvider ascendingOrderAuction
     * @dataProvider descendingOrderAuction
     * @dataProvider randomOrderAuction
     */
    public function testEvaluatorShouldFindTheHighestValueOfBids(Auction $auction)
    {
        //act - when
        $this->auctioneer->evaluate($auction);
        $highestValue = $this->auctioneer->getHighestValue();

        //assert - then
        self::assertEquals(2500, $highestValue);
    }

    /**
     * @dataProvider ascendingOrderAuction
     * @dataProvider descendingOrderAuction
     * @dataProvider randomOrderAuction
     */
    public function testEvaluatorShouldFindTheLowestValueOfBids(Auction $auction)
    {
        $this->auctioneer->evaluate($auction);
        $lowestValue = $this->auctioneer->getLowestValue();

        self::assertEquals(1300, $lowestValue);
    }

    /**
     * @dataProvider ascendingOrderAuction
     * @dataProvider descendingOrderAuction
     * @dataProvider randomOrderAuction
     */
    public function testEvaluatorShouldFindTheThreeHighestValues(Auction $auction)
    {
        $this->auctioneer->evaluate($auction);
        $highestBids = $this->auctioneer->getHighestBids();

        self::assertCount(3, $highestBids);
        self::assertEquals(2500, $highestBids[0]->getValue());
        self::assertEquals(2000, $highestBids[1]->getValue());
        self::assertEquals(1700, $highestBids[2]->getValue());
    }

    public function ascendingOrderAuction(): array
    {
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');
        $vanessa = new User('Vanessa');
        $rogerio = new User('Rogerio');

        $auction->receiveBid(new Bid($rogerio, 1300));
        $auction->receiveBid(new Bid($vanessa, 1700));
        $auction->receiveBid(new Bid($joao, 2000));
        $auction->receiveBid(new Bid($maria, 2500));

        return [
            "ascending order" => [$auction]
        ];
    }

    public function descendingOrderAuction(): array
    {
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');
        $vanessa = new User('Vanessa');
        $rogerio = new User('Rogerio');

        $auction->receiveBid(new Bid($maria, 2500));
        $auction->receiveBid(new Bid($joao, 2000));
        $auction->receiveBid(new Bid($vanessa, 1700));
        $auction->receiveBid(new Bid($rogerio, 1300));

        return [
            "descending order" => [$auction]
        ];
    }

    public function randomOrderAuction(): array
    {
        $auction = new Auction('Fiat 147 0km');

        $maria = new User('Maria');
        $joao = new User('João');
        $vanessa = new User('Vanessa');
        $rogerio = new User('Rogerio');

        $auction->receiveBid(new Bid($maria, 2500));
        $auction->receiveBid(new Bid($vanessa, 1700));
        $auction->receiveBid(new Bid($joao, 2000));
        $auction->receiveBid(new Bid($rogerio, 1300));

        return [
            "random order" => [$auction]
        ];
    }
}