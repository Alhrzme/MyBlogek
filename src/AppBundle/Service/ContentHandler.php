<?php

namespace AppBundle\Service;

class ContentHandler
{
    const LIGHT_CLEAN_PATTERN = "[^-a-zA-Zа-яА-ЯёЁ0-9]";

    /**
     * get first paragraph from given text
     * @param $text
     * @return string
     */
    public function getSummary($text)
    {
        $lastLetterOfFirstParagraph = strpos($text, "\n");
        $summary = $lastLetterOfFirstParagraph ? substr($text, 0, $lastLetterOfFirstParagraph - 1) : $text;
        return $summary;
    }

    /**
     * clean text from extra characters
     * @param string $text
     * @param string $pattern
     * @return string
     */
    public function textClean($text, $pattern = self::LIGHT_CLEAN_PATTERN)
    {
        return preg_replace($pattern, "", $text);
    }
}