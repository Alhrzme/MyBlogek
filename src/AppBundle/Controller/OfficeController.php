<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OfficeController
 * @package AppBundle\Controller
 * @Route("/office")
 */
class OfficeController extends Controller
{
    /**
     * @Route("/{id}", name="office_home")
     * @Template("office/index.html.twig")
     * @param User $user
     */
    public function indexAction(User $user)
    {
    }
}