<?php

declare(strict_types=1);

namespace Base;

/**
 * Class SubstitutionEncodingAlgorithmTest
 * @package Base
 */
class SubstitutionEncodingAlgorithmTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getValidSubstitutions
     * @param $substitutions
     * @param $text
     * @param $encoded
     */
    public function testValidSubstitutions($substitutions, $text, $encoded)
    {
        $algorithm = new \SubstitutionEncodingAlgorithm($substitutions);

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * Data provider for {@link SubstitutionEncodingAlgorithmTest::testValidSubstitutions()}
     * @return array
     */
    public function getValidSubstitutions()
    {
        return [
            [['ab'], 'aabbcc', 'bbaacc'],
            [['ab', 'cd'], 'adam', 'bcbm'],
            [['ab', 'cd'], 'AdAm', 'BcBm'],
            [['ga', 'de', 'ry', 'po', 'lu', 'ki'], 'lorem ipsum dolor', 'upydm koslm epupy'],
        ];
    }

    /**
     * @dataProvider getIllegalSubstitutions
     * @expectedException \InvalidArgumentException
     * @param $substitutions
     */
    public function testIllegalSubstitutions($substitutions)
    {
        $algorithm = new \SubstitutionEncodingAlgorithm($substitutions);

        $algorithm->encode('');

        $this->fail('Exception should be thrown');
    }

    /**
     * @return array
     */
    public function getIllegalSubstitutions()
    {
        return [
            [['gg']],
            [['ga', 'gb']],
            [['g']],
        ];
    }
}
