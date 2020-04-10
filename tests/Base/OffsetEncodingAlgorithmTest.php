<?php

declare(strict_types=1);

namespace Base;

/**
 * Class OffsetEncodingAlgorithmTest
 * @package Base
 */
class OffsetEncodingAlgorithmTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getTexts
     * @param $offset
     * @param $text
     * @param $encoded
     */
    public function testValidEncoding($offset, $text, $encoded)
    {
        $algorithm = new \OffsetEncodingAlgorithm($offset);

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @dataProvider getIllegalOffsets
     * @expectedException \InvalidArgumentException
     * @param $offset
     */
    public function testIllegalParameters($offset)
    {
        new \OffsetEncodingAlgorithm($offset);

        $this->fail('Exception should be thrown');
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return [
            [0, '', ''],
            [1, '', ''],
            [1, 'a', 'b'],
            [0, 'abc def.', 'abc def.'],
            [1, 'abc def.', 'bcd efg.'],
            [2, 'z', 'B'],
            [1, 'Z', 'a'],
            [26, 'abc def.', 'ABC DEF.'],
            [26, 'ABC DEF.', 'abc def.'],
        ];
    }

    /**
     * Data provider for {@link OffsetEncodingAlgorithmTest::testIllegalParameters()}
     * @return array
     */
    public function getIllegalOffsets()
    {
        return [
            [-1],
        ];
    }
}
