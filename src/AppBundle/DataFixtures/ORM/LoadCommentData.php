<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $comment11 = new Comment();
        $comment11->setBody('Ну и атстой!');
        $comment11->setUser($this->getReference('fixt_user'));
        $comment11->setPost($this->getReference('post1'));
        $manager->persist($comment11);

        $comment12 = new Comment();
        $comment12->setBody('Это лучшее, что я читал!');
        $comment12->setUser($this->getReference('fixt_user2'));
        $comment12->setPost($this->getReference('post1'));
        $manager->persist($comment12);

        $comment21 = new Comment();
        $comment21->setBody('Смолвил, что царь!!');
        $comment21->setUser($this->getReference('fixt_user2'));
        $comment21->setPost($this->getReference('post2'));
        $manager->persist($comment21);

        $comment31 = new Comment();
        $comment31->setBody('Брет какой та!!!');
        $comment31->setUser($this->getReference('fixt_user2'));
        $comment31->setPost($this->getReference('post3'));
        $manager->persist($comment31);

        $comment32 = new Comment();
        $comment32->setBody('Какой же он крутой был...');
        $comment32->setUser($this->getReference('fixt_user'));
        $comment31->setPost($this->getReference('post3'));
        $manager->persist($comment32);

        $comment41 = new Comment();
        $comment41->setBody('Лучшее!');
        $comment41->setUser($this->getReference('fixt_user'));
        $comment41->setPost($this->getReference('post4'));
        $manager->persist($comment41);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder() {
        return 4;
    }
}