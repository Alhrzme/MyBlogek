<?php

namespace AppBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getUserWithPosts($id)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->from('AppBundle:User', 'u')
            ->select('u')
            ->where('u.id = :id')
            ->setParameter(':id', $id)
            ->leftJoin('u.posts', 'AppBundle:Comment');
        return $query->getQuery()->getSingleResult();
    }
}
