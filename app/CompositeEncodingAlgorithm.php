<?php

declare(strict_types=1);

/**
 * Class CompositeEncodingAlgorithm
 */
class CompositeEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var EncodingAlgorithm[]
     */
    private $algorithms;

    /**
     * CompositeEncodingAlgorithm constructor
     */
    public function __construct()
    {
        $this->algorithms = [];
    }

    /**
     * @param EncodingAlgorithm $algorithm
     */
    public function add(EncodingAlgorithm $algorithm): void
    {
        $this->algorithms[] = $algorithm;
    }

    /**
     * Encodes text using multiple Encoders (in orders encoders were added)
     *
     * @param string $text
     * @return string
     * @throws Exception
     */
    public function encode(string $text): string
    {
        if (count($this->algorithms) === 0) {
            throw new Exception();
        }
        $encodedString = $text;
        foreach ($this->algorithms as $algorithm) {
            $encodedString = $algorithm->encode($encodedString);
        }
        return $encodedString;
    }
}
