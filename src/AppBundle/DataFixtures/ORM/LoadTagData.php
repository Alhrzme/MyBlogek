<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $firstTag = new Tag();
        $firstTag->setTagName('fixtur1');

        $secondTag = new Tag();
        $secondTag->setTagName('fixtur2');

        $manager->persist($firstTag);
        $manager->persist($secondTag);
        $manager->flush();

        $this->addReference('tag1', $firstTag);
        $this->addReference('tag2', $secondTag);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder() {
        return 2;
    }
}