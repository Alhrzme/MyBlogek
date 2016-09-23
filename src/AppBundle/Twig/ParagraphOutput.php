<?php

namespace AppBundle\Twig;

class ParagraphOutput extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('paragraph', array($this, 'paragraphFilter')),
        );
    }

    public function paragraphFilter($text)
    {
        return '<p>'.str_replace('\n','</p><p>',$text).'</p>';
    }
    
    public function getName() {
        return 'paragraph_output_extension';
    }
}