<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class UtilityController
 * @package AppBundle\Controller
 * @Route("/utility")
 */
class UtilityController {

    /**
     * @Route("/", name="utility_home")
     * @Template("utility/index.html.twig")
     */
    public function indexAction()
    {

    }
}