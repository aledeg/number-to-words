<?php

namespace NumberToWords\Legacy\Numbers\Words\Locale\En;

use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\Language\English\Dictionary;
use NumberToWords\Legacy\Numbers\Words;
use NumberToWords\Service\NumberToTripletsConverter;

class Us extends Words
{
    /**
     * @var NumberToTripletsConverter
     */
    private $numberToTripletsConverter;

    public function __construct()
    {
        $this->numberToTripletsConverter = new NumberToTripletsConverter();
    }

    /**
     * @param int $number
     *
     * @return string
     */
    protected function toWords($number)
    {
        if ($number === 0) {
            return Dictionary::$zero;
        }

        $triplets = $this->numberToTripletsConverter->convertToTriplets(abs($number));

        $transformedNumber = $this->buildWordsFromTriplets($triplets);

        return $number < 0 ? Dictionary::MINUS . ' ' . $transformedNumber : $transformedNumber;
    }

    /**
     * @param array $triplets
     *
     * @return string
     */
    private function buildWordsFromTriplets(array $triplets)
    {
        $words = [];

        foreach ($triplets as $i => $triplet) {
            if ($triplet > 0) {
                $words[] = trim($this->threeDigitsToWords($triplet) . ' ' . Dictionary::$exponent[count($triplets) - $i - 1]);
            }
        }

        return implode(' ', $words);
    }

    /**
     * @param int $number
     *
     * @return string
     */
    private function threeDigitsToWords($number)
    {
        $units = $number % 10;
        $tens = (int) ($number / 10) % 10;
        $hundreds = (int) ($number / 100) % 10;
        $words = [];

        if ($hundredsWord = $this->getHundred($hundreds)) {
            $words[] = $hundredsWord;
        }

        if ($subHundredsWord = $this->getSubHundred($tens, $units)) {
            $words[] = $subHundredsWord;
        }

        return implode(' ', $words);
    }

    /**
     * @param int $number
     *
     * @return string
     */
    private function getHundred($number)
    {
        $word = Dictionary::$units[$number];

        if ($word) {
            return $word . ' ' . Dictionary::$hundred;
        }

        return '';
    }

    /**
     * @param int $tens
     * @param int $units
     *
     * @return string
     */
    private function getSubHundred($tens, $units)
    {
        $words = [];

        if ($tens === 1) {
            $words[] = Dictionary::$teens[$units];
        } else {
            if ($tens > 0) {
                $words[] = Dictionary::$tens[$tens];
            }
            if ($units > 0) {
                $words[] = Dictionary::$units[$units];
            }
        }

        return implode('-', $words);
    }

    /**
     * @param string $currency
     * @param int    $decimal
     * @param int    $fraction
     *
     * @throws NumberToWordsException
     * @return string
     */
    public function toCurrencyWords($currency, $decimal, $fraction = null)
    {
        $currency = strtoupper($currency);

        if (!array_key_exists($currency, Dictionary::$currencyNames)) {
            throw new NumberToWordsException(
                sprintf('Currency "%s" is not available for "%s" language', $currency, get_class($this))
            );
        }

        $currencyNames = Dictionary::$currencyNames[$currency];

        $return = trim($this->toWords($decimal));
        $level = ($decimal === 1) ? 0 : 1;

        if ($level > 0) {
            if (count($currencyNames[0]) > 1) {
                $return .= Dictionary::$wordSeparator . $currencyNames[0][$level];
            } else {
                $return .= Dictionary::$wordSeparator . $currencyNames[0][0] . 's';
            }
        } else {
            $return .= Dictionary::$wordSeparator . $currencyNames[0][0];
        }

        if (null !== $fraction) {
            $return .= Dictionary::$wordSeparator . trim($this->toWords($fraction));

            $level = $fraction === 1 ? 0 : 1;

            if ($level > 0) {
                if (count($currencyNames[1]) > 1) {
                    $return .= Dictionary::$wordSeparator . $currencyNames[1][$level];
                } else {
                    $return .= Dictionary::$wordSeparator . $currencyNames[1][0] . 's';
                }
            } else {
                $return .= Dictionary::$wordSeparator . $currencyNames[1][0];
            }
        }

        return $return;
    }
}
