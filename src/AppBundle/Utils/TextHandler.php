<?php

namespace AppBundle\Utils;

class TextHandler {
    /**
     * @param string $string
     * @return string
     */
    public function makeParagraphMarkup($string)
    {
        return '<p>'.str_replace("\n",'</p><p>',$string).'</p>';
    }
}