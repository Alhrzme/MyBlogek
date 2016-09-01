<?php

namespace AppBundle\Controller;

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
     * @Route("/", name="office_home")
     */
    public function indexAction()
    {
        return new Response('Lomai menya polnostyu');
    }
}