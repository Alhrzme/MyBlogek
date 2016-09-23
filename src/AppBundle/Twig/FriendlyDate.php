<?php

namespace AppBundle\Twig;



class FriendlyDate extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('friendly_date', array($this, 'friendlyDate')),
        );
    }

    public function friendlyDate(\DateTime $date)
    {
        $currentDate = new \DateTime();
        if($currentDate->format('Y') != $date->format('Y')) {
            return $date->format('d M Y года');
        }
        if ($date) {

        }
        $dateDiff = date_diff(new \DateTime(), $date, true);
        if ($dateDiff->y > 0) {

        }
    }

    public function getName() {
        return 'friendly_date_extension';
    }
}