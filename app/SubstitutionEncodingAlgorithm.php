<?php

declare(strict_types=1);

/**
 * Class SubstitutionEncodingAlgorithm
 */
class SubstitutionEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var array
     */
    private $substitutions;

    /**
     * SubstitutionEncodingAlgorithm constructor.
     * @param $substitutions
     */
    public function __construct(array $substitutions)
    {
        if ($this->isValidInputSubstitutionArray($substitutions)) {
            $this->substitutions = $substitutions;
        }
    }

    /**
     * Encodes text by substituting character with another one provided in the pair.
     * For example pair "ab" defines all "a" chars will be replaced with "b" and all "b" chars will be replaced with "a"
     * Examples:
     *      substitutions = ["ab"], input = "aabbcc", output = "bbaacc"
     *      substitutions = ["ab", "cd"], input = "adam", output = "bcbm"
     *
     * @param string $text
     * @return string
     */
    public function encode(string $text): string
    {
        $stringLength = strlen($text);
        $encodedString = '';
        for ($i = 0; $i < $stringLength; $i++) {
            $plaintextCharacter = $text[$i];
            $encodedCharacter = $this->getEncodedCharacter($plaintextCharacter);
            $encodedString .= IntlChar::isupper($plaintextCharacter) ? strtoupper($encodedCharacter) : $encodedCharacter;
        }
        return $encodedString;
    }

    private function getEncodedCharacter(string $inputString): string
    {
        foreach ($this->substitutions as $substitution) {
            $stringIndex = $this->getIndexInLookupString($inputString, $substitution);
            if ($stringIndex !== false) {
                $encodedStringIndex = $stringIndex == 1 ? 0 : 1;
                return $substitution[$encodedStringIndex];
            }
        }
        return $inputString;
    }

    private function getIndexInLookupString(string $needle, string $haystack)
    {
        return strpos($haystack, strtolower($needle));
    }

    private function isValidInputSubstitutionArray(array $substitutions): bool
    {
        for ($i = 0; $i < count($substitutions); $i++) {
            $substitution = $substitutions[$i];
            if (!$this->isSubstitutionOfAppropriateLength($substitution)) {
                throw new InvalidArgumentException();
            }
            if ($this->isSubstitutionCipherDuplicated($substitution)) {
                throw  new InvalidArgumentException();
            }
            if ($i > 0 && $this->isSubstitutionCipherAmbiguous($substitution, $substitutions[$i - 1])) {
                throw new InvalidArgumentException();
            }
        }
        return true;
    }

    private function isSubstitutionOfAppropriateLength(string $substitutionString)
    {
        return strlen($substitutionString) === 2;
    }

    private function isSubstitutionCipherDuplicated(string $substitutionString)
    {
        $stringArray = str_split($substitutionString);
        return $stringArray[0] === $stringArray[1];
    }

    private function isSubstitutionCipherAmbiguous(string $currentCipher, string $previousCipher)
    {
        $stringArray = str_split($currentCipher);
        foreach ($stringArray as $cipherString) {
            if ($this->getIndexInLookupString($cipherString, $previousCipher) !== false) {
                return true;
            }
        }
        return false;
    }
}
