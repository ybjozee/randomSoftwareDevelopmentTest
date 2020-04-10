<?php

declare(strict_types=1);

namespace Base;

use Exception;

/**
 * Class CompositeEncodingAlgorithmTest
 * @package Base
 */
class CompositeOffsetSubstitutionEncodingAlgorithmTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getTexts
     * @param $offset
     * @param $text
     * @param $encoded
     * @throws Exception
     */
    public function testValidEncoding($offset, $text, $encoded)
    {
        $algorithm = new \CompositeEncodingAlgorithm();

        $algorithm->add(new \OffsetEncodingAlgorithm($offset));
        $algorithm->add(new \SubstitutionEncodingAlgorithm(['ga', 'de', 'ry', 'po', 'lu', 'ki']));

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return [
            [0, '', ''],
            [0, 'abc', 'gbc'],
            [1, 'abc', 'bce'],
            [1, 'abc def, ghi.', 'bce dfa, hkj.'],
            [26, 'abc def.', 'GBC EDF.'],
            [26, 'ABC DEF.', 'gbc edf.'],
        ];
    }

    /**
     * @dataProvider getReversedTexts
     * @param $offset
     * @param $text
     * @param $encoded
     * @throws Exception
     */
    public function testReverseOrder($offset, $text, $encoded)
    {
        $algorithm = new \CompositeEncodingAlgorithm();

        $algorithm->add(new \SubstitutionEncodingAlgorithm(['ga', 'de', 'ry', 'po', 'lu', 'ki']));
        $algorithm->add(new \OffsetEncodingAlgorithm($offset));

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @return array
     */
    public function getReversedTexts()
    {
        return [
            [0, 'abc', 'gbc'],
            [1, 'abc', 'hcd'],
            [1, 'abc def, ghi.', 'hcd feg, bil.']
        ];
    }
}
