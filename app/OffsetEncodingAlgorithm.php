<?php

declare(strict_types=1);

/**
 * Class OffsetEncodingAlgorithm
 */
class OffsetEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * Lookup string
     */
    public const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var int
     */
    private $offset;

    /**
     * @param int $offset
     */
    public function __construct(int $offset = 13)
    {
        if ($offset < 0) {
            throw new InvalidArgumentException();
        }
        $this->offset = $offset;
    }

    /**
     * Encodes text by shifting each character (existing in the lookup string) by an offset (provided in the constructor)
     * Examples:
     *      offset = 1, input = "a", output = "b"
     *      offset = 2, input = "z", output = "B"
     *      offset = 1, input = "Z", output = "a"
     *
     * @param string $text
     * @return string
     */
    public function encode(string $text): string
    {
        $stringLength = strlen($text);
        $encodedString = '';
        for ($i = 0; $i < $stringLength; $i++) {
            $encodedString .= $this->getEncodedCharacter($text[$i]);
        }
        return $encodedString;
    }

    private function getEncodedCharacter(string $inputString): string
    {
        $inputStringIndex = $this->getIndexInLookupString($inputString);
        if ($inputStringIndex !== false) {
            $cipherStringIndex = $inputStringIndex + $this->offset;
            $maxStringIndex = strlen(OffsetEncodingAlgorithm::CHARACTERS);
            if ($cipherStringIndex >= $maxStringIndex) {
                $cipherStringIndex -= $maxStringIndex;
            }
            return OffsetEncodingAlgorithm::CHARACTERS[$cipherStringIndex];
        }
        return $inputString;
    }

    private function getIndexInLookupString(string $needle)
    {
        return strpos(OffsetEncodingAlgorithm::CHARACTERS, $needle);
    }
}
