<?php

namespace AppBundle\Service;

use AppBundle\Entity\TagRepository;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\Tag;

class TagHandler
{
    /** @var  Container $container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * get Tag array, containing existing and new tags
     * @param $tagString
     * @return Tag[]|array
     */
    public function tagStringToArray($tagString)
    {
        $cleanTagString = $this->container->get('content.handler')->textClean($tagString);
        $tagArray = explode(' ', $cleanTagString);
        $tagArray = array_unique($tagArray);

        $entityManager = $this->container->get('doctrine')->getManager();
        /** @var TagRepository $tagRepository */
        $tagRepository = $entityManager->getRepository('AppBundle:Tag');
        return $tagRepository->getTagsByNameArray($tagArray);
    }
}