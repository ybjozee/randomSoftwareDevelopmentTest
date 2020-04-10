<?php

declare(strict_types=1);

/**
 * Interface Algorithm
 */
interface EncodingAlgorithm
{
    /**
     * @param string $text
     * @return string
     */
    public function encode(string $text): string;
}
