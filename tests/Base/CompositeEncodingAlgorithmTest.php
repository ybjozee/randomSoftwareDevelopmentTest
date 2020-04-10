<?php

declare(strict_types=1);

namespace Base;

use CompositeEncodingAlgorithm;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

/**
 * Class CompositeEncodingAlgorithmTest
 * @package verify_pack
 */
class CompositeEncodingAlgorithmTest extends TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    protected function setup()
    {
        $this->prophet = new Prophet;
    }

    public function testComposedAlgorithmsAreCalled()
    {
        $algorithmA = $this->prophet->prophesize('\EncodingAlgorithm');
        $algorithmB = $this->prophet->prophesize('\EncodingAlgorithm');

        $algorithmA->encode("plain text")->willReturn("encoded text");
        $algorithmB->encode("encoded text")->willReturn("text encoded twice");

        $algorithm = new CompositeEncodingAlgorithm();
        $algorithm->add($algorithmA->reveal());
        $algorithm->add($algorithmB->reveal());

        $this->assertSame("text encoded twice", $algorithm->encode("plain text"));
    }

    /**
     * @expectedException Exception
     */
    public function testEncodingWithEmptyAlgorithmsList()
    {
        $algorithm = new CompositeEncodingAlgorithm();

        $encoded = $algorithm->encode('lorem ipsum');

        // Encoding with empty list of algorithms shouldn't return string, but null, false or throws exception.
        if (is_string($encoded)) {
            $this->fail('Exception should be thrown');
        } else {
            $this->assertTrue(is_null($encoded) || $encoded === false);
        }
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
